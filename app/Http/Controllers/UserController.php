<?php


namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $maxUsersAllowedBasicPlan = 3;

    public function create($subdomain, Request $request)
    {
        if (
            $request->filled(['first_name', 'last_name', 'role_id', 'email']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

            return redirect()->back();

        }

        $supplier = Supplier::findBySubdomain($subdomain);

        $user = [
            'supplier_id' => $supplier->id,
            'role_id'     => $request->get('role_id'),
            'first_name'  => $request->get('first_name'),
            'last_name'   => $request->get('last_name'),
            'email'       => $request->get('email'),
            'password'    => bcrypt(rand(100, 1000)),
        ];

        User::create($user);

        session()->flash('success', 'User account for "' . $user['first_name'] . ' '. $user['last_name'] . '" was created successfully!');

        return redirect()->to('/users');

    }

    public function changeStatus($subdomain, $userId, $action)
    {

        $user     = User::find($userId);
        $supplier = Supplier::findBySubdomain($subdomain);

        if ($user->supplier_id !== $supplier->id) {

            session()->flash('error', '"' . $user->fullName . '\'s" account can\'t be modified');

        }

        else {

            $user->is_enabled = ($action === 'enable') ? 1 : 0;
            $user->save();

            session()->flash('success', '"' . $user->fullName() . '\'s" account has been modified');

        }

        return redirect()->back();

    }


}