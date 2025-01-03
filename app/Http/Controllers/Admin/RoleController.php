<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appsetting;
use App\Models\Country;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Str;
class RoleController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:role-browse',['only' => ['index']]);
        $this->middleware('permission:role-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Role::with('permissions')->get();
        return View('admin.roles')->with('data', $data);
    }

    public function create()
    {
        $permissions = Permission::all();
        return View('admin.roles',compact('permissions'));
    }

    public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required|unique:roles,name,' . ($request->id ?? 'NULL'),
        'permission' => 'required|array',
    ]);

    if (!empty($request->id)) {
        // Updating an existing role
        $role = Role::findOrFail($request->id);
        $role->update(['name' => $request->name]);
    } else {
        // Creating a new role
        $role = Role::create(['name' => $request->name]);
    }

    // Sync the permissions
    $role->syncPermissions($request->permission);

    $message = !empty($request->id) ? 'Role successfully updated.' : 'Role successfully created.';
    return redirect()->route('roles-list')->with('success', $message);
}


    public function edit($id)
    {
         if(Role::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $permissions = Permission::all();
        $role = Role::where('id', $id)->first();
        return View('admin.roles',compact('role','permissions'));
    }

    public function destroy($id)
    {
         if(Role::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $role = Role::where('id', $id)->delete();
        return redirect()->back()->with('delete','Role successfully deleted.');
    }
}
