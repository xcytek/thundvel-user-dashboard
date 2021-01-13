<?php


namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Workspace;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class WorkspacesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create($subdomain, Request $request)
    {
        if (
            $request->filled(['name', 'data_source_id', 'description']) === false
        ) {

            session()->flash('error', 'Please, fill out all the fields with right data!');

            return redirect()->back();

        }

        $supplier = Supplier::findBySubdomain($subdomain);

        $workspace = [
            'name'           => $request->get('name'),
            'supplier_id'    => $supplier->id,
            'data_source_id' => $request->get('data_source_id'),
            'description'    => $request->get('description')
        ];

        Workspace::create($workspace);

        session()->flash('success', 'Workspace "' . $workspace['name'] . '" was created successfully!');

        return redirect()->to('/workspaces');

    }

    public function getWorkspace($subdomain, Request $request, $workspaceId)
    {

        $supplier = Supplier::findBySubdomain($subdomain);

        $workspace = Workspace::find($workspaceId);

        return view('workspaces.get')->with('subdomain', $subdomain)->with('workspace', $workspace);

    }
}