<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\Appsetting;
use Str;
class PermissionController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:permission-browse',['only' => ['index']]);
        $this->middleware('permission:permission-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Permission::get();
        return View('admin.permissions')->with('data', $data);
    }

    public function action(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	Permission::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Permission::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function create()
    {
        $permissions = Permission::pluck('name','id')->all();
        return View('admin.permissions',compact('permissions'));
    }

    public function store(Request $request)
    {
        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:permissions,name,'.$request->id
            ]);
            $data = [
                'name' => $request->name,
                'group_name' => $request->group_name
            ];

            $permission = Permission::find($request->id);
            $permission->update($data);
            return redirect()->route('permissions-list')->with('success','Permission successfully updated.');
        }
        else
        {
            $this->validate($request, [
                'name'     => 'required|unique:permissions,name'
            ]);

            $input 					= $request->all();
            $permission = Permission::create($input);
            return redirect()->route('permissions-list')->with('success','Permission successfully created.');
        }
    }

    public function edit($id)
    {
         if(Permission::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $permissions = Permission::pluck('name','id')->all();
        $permission = Permission::where('id', $id)->first();
        return View('admin.permissions',compact('permission','permissions'));
    }

    public function destroy($id)
    {
         if(Permission::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $permission = Permission::where('id', $id)->delete();
        return redirect()->back()->with('delete','Permission successfully deleted.');
    }
}
