<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use EmailFactory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use function Ramsey\Uuid\v1;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $adminRoleId = 1;

    private $userRoleId = 2;

    private $superAdminRoleId = 3;

    /**
     * Validate and do a user login
     *
     * @param $supplier
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin($subdomain, Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (is_null($credentials['email']) === true | is_null($credentials['password']) === true) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

        }

        if (@User::findByEmail($credentials['email'])->supplier_id !== @Supplier::findBySubdomain($subdomain)->id) {

            session()->flash('error', 'The provided credentials do not match our records!');

        }

        elseif (@Supplier::findBySubdomain($subdomain)->is_enabled === 0) {

            session()->flash('error', 'This supplier account has been disabled. Contact your administrator!');

        }

        elseif (@User::findByEmail($credentials['email'])->is_enabled === 0) {

            session()->flash('error', 'Your account has been disabled. Contact your administrator!');

        }

        elseif (Auth::attempt($credentials) === true) {

            $request->session()->regenerate();

            session()->flash('success', 'Welcome back, ' . auth()->user()->first_name);

            if (auth()->user()->role_id === $this->superAdminRoleId) {

                return redirect()->intended('admin/dashboard');

            }

            return redirect()->intended('dashboard');

        }

        else {

            session()->flash('error', 'The provided credentials do not match our records!');

        }


        return redirect()->back();

    }

    /**
     * Create a new record registering as a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister($subdomain, Request $request)
    {

        if (
            $request->filled(['first_name', 'last_name', 'email', 'password']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

        }

        else {

            try {

                $supplier = Supplier::findBySubdomain($subdomain);

                User::create([
                    'supplier_id' => $supplier->id,
                    'first_name' => $request->get('first_name'),
                    'last_name'  => $request->get('last_name'),
                    'email'      => $request->get('email'),
                    'password'   => bcrypt($request->get('password')),
                ]);

                session()->flash('success', 'You\'re now ready to go in!');

                return redirect()->to('login');

            }

            catch (QueryException $exception) {

                session()->flash('error', 'Email already taken, please provide a different one!');

            }

        }

        return redirect()->back();

    }

    /**
     * Save your profile
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postProfile($supplier, Request $request)
    {
        if (
            $request->filled(['first_name', 'last_name', 'email']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

        }

        else {

            $user             = User::find(Auth::id());
            $user->first_name = $request->get('first_name');
            $user->last_name  = $request->get('last_name');
            $user->email      = $request->get('email');
            $user->save();

            session()->flash('success', 'Your profile has been updated successfully!');

        }


        return redirect()->back();
    }


    /**
     * Process recovery password. Send email to reset password
     *
     * @param Request $request
     * @return
     */
    public function postRecoveryPassword($subdomain, Request $request)
    {

        if ($request->filled(['email']) === false) {

            session()->flash('error', 'Please, provide a valid email!');

            return redirect()->back();

        }

        $email = filter_var($request->get('email'), FILTER_SANITIZE_EMAIL);

        $supplier = Supplier::findBySubdomain($subdomain);

        $user = User::findByEmailAndSupplierId($email, $supplier->id);

        if (is_null($user) === false) {

            $token = md5(Carbon::now()->toString());

            PasswordReset::create(['email' => $email, 'token' => $token,]);

            try {

                $sent = EmailFactory::getInstance()->getService(env('EMAIL_INSTANCE'))->sendRecovery([
                    'user' => $user,
                    'link' => str_replace('{subdomain}', $subdomain, env('APP_URL')) . '/reset-password/' . $token
                ]);

                if ($sent !== true) {

                    session()->flash('error', 'Password recovery couldn\'t be sent. Try again!');

                    return redirect()->back();

                }


            } catch (\Exception $e) {

                session()->flash('error', 'Password recovery failed!' . $e->getMessage());

                return redirect()->back();

            }

        }

        return view('recovery-password')->with('sentRecovery', true);
    }

    /**
     * Reset password in the records
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword($supplier, Request $request)
    {

        $passwordReset = PasswordReset::findByToken($request->get('token'));
        $latestReset   = PasswordReset::latest($passwordReset->email);

        if ($passwordReset->token !== $latestReset->token || $passwordReset->verified === 1) {

            session()->flash('error', 'This recovery link is not valid!');

        }

        elseif (is_null($request->get('password')) || is_null($request->get('re-password'))) {

            session()->flash('error', 'Password can\'t be empty!');

        }

        elseif ($request->get('password') !== $request->get('re-password')) {

            session()->flash('error', 'Both passwords have to match!');

        }

        else {

            $user = User::findByEmail($passwordReset->email);
            $user->password = bcrypt($request->get('password'));
            $user->save();

            PasswordReset::removeByEmail($passwordReset->email);

            session()->flash('success', 'Your password has been reset successfully');

            return redirect()->to('login');

        }

        return redirect()->back();

    }

    public function getVerifyAccount($supplier, Request $request)
    {

        $user = User::find(auth()->user()->id);

        if (is_null($user->email_verified_at) === false) {

            session()->flash('success', 'Your account is already verified!');

            return redirect()->to('/my-profile');

        }

        try {

            $code = rand(10000 , 99999);

            $sent = EmailFactory::getInstance()->getService(env('EMAIL_INSTANCE'))->sendVerifyAccount([
                'user' => $user,
                'code' => $code,
            ]);

            if ($sent !== true) {

                session()->flash('error', 'Verify account email couldn\'t be sent. Try again!');

                return redirect()->back();

            }

            $user->remember_token = $code;
            $user->save();

            return view('verify-account');

        } catch (\Exception $e) {

            session()->flash('error', 'Verify account failed!');

            return redirect()->back();

        }
    }

    public function postVerifyAccount($supplier, Request $request)
    {

        $user = User::find(auth()->user()->id);

        if ($request->has('code') === false || $user->remember_token !== $request->get('code')) {

            session()->flash('error', 'Invalid code!');

        }

        else {

            $user->email_verified_at = Carbon::now();
            $user->save();

            session()->flash('success', 'Congrats, your account has been verified!');

        }

        return redirect()->to('/my-profile');

    }

    public function signup(Request $request)
    {

        if ($request->filled(['name', 'country', 'industry', 'website', 'subdomain', 'first_name', 'last_name', 'phone', 'email']) === false) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

            return redirect()->back();

        }

        $firstName = $request->get('first_name');
        $lastName  = $request->get('last_name');

        $requestData = [
            'name'          => $request->get('name'),
            'country'       => $request->get('country'),
            'industry'      => $request->get('industry'),
            'website'       => $request->get('website'),
            'subdomain'     => $request->get('subdomain'),
            'contact_name'  => $firstName . ' ' . $lastName,
            'email'         => $request->get('email'),
            'phone'         => $request->get('phone'),
        ];

        if (Supplier::existsBySubdomain($requestData['subdomain']) === true) {

            session()->flash('error', 'The subdomain is already taken!');

            return redirect()->back();

        }

        $supplier = Supplier::create($requestData);

        $user = User::create([
            'supplier_id' => $supplier->id,
            'role_id'     => $this->adminRoleId,
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $requestData['email'],
            'password'    => bcrypt(rand(100, 1000))
        ]);

        session()->flash('success', 'Your application has been sent. Our team is going to review it and get back to you!');

        return redirect()->to('/');

    }

}
