<?php


namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class SupplierController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $maxUsersAllowedBasicPlan = 3;

    private $adminRoleId = 1;

    public function save($subdomain, Request $request)
    {
        if (
            $request->filled(['name', 'country', 'industry', 'website', 'subdomain', 'contact_name', 'phone', 'email']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

            return redirect()->back();

        }

        $supplier = [
            'name'          => $request->get('name'),
            'country'       => $request->get('country'),
            'website'       => $request->get('website'),
            'industry'      => $request->get('industry'),
            'subdomain'     => $request->get('subdomain'),
            'contact_name'  => $request->get('contact_name'),
            'phone'         => $request->get('phone'),
            'email'         => $request->get('email'),
        ];

        $supplierCreated = Supplier::create($supplier);

        $separatedUser = explode(' ', $supplier['contact_name']);

        User::create([
            'supplier_id' => $supplierCreated->id,
            'first_name'  => $separatedUser[0],
            'last_name'   => (isset($separatedUser[1]) === true) ? $separatedUser[1] : '',
            'role_id'     => $this->adminRoleId,
            'email'       => $supplier['email'],
            'password'    => bcrypt(rand(100, 1000)),
            'is_enabled'  => 1
        ]);

        session()->flash('success', '"' . $supplier['name'] . '" account has been created successfully!');

        return redirect()->to('/admin/suppliers');

    }

    public function changeStatus($subdomain, $supplierId, $action)
    {

        $supplier = Supplier::find($supplierId);

        if (is_null($supplier) === true) {

            session()->flash('error', 'Supplier account can\'t be modified');

        }

        else {

            $supplier->is_enabled = ($action === 'enable') ? 1 : 0;
            $supplier->save();

            $user = User::findByEmailAndSupplierId($supplier->email, $supplier->id);
            if (is_null($user) === false) {

                $user->is_enabled = 1;
                $user->save();

            }


            session()->flash('success', '"' . $supplier->name . '" account has been modified');

        }

        return redirect()->back();

    }


}