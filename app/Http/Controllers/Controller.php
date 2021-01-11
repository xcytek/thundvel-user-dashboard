<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validate and do a user login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (is_null($credentials['email']) === true | is_null($credentials['password']) === true) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

        }

        if (Auth::attempt($credentials) === true) {

            $request->session()->regenerate();

            return redirect()->intended('dashboard');

        }

        session()->flash('error', 'The provided credentials do not match our records!');

        return redirect()->back();

    }

    /**
     * Create a new record registering as a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {

        if (
            $request->filled(['first_name', 'last_name', 'email', 'password']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

        }

        else {

            try {

                User::create([
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
    public function postProfile(Request $request)
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
    public function postRecoveryPassword(Request $request)
    {

        if ($request->filled(['email']) === false) {

            session()->flash('error', 'Please, provide a valid email!');

            return redirect()->back();

        }

        $email = filter_var($request->get('email'), FILTER_SANITIZE_EMAIL);

        $user = User::findByEmail($email);

        if (is_null($user) === false) {

            $token = md5(Carbon::now()->toString());

            PasswordReset::create(['email' => $email, 'token' => $token,]);

            try {

                $sent = EmailFactory::getInstance()->getService(env('EMAIL_INSTANCE'))->sendRecovery([
                    'user' => $user,
                    'link' => env('APP_URL') . '/reset-password/' . $token
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
    public function postResetPassword(Request $request)
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


}
