<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Country;
use DB;
use Str;
class MenuController extends Controller
{
    public function menus()
    {
        $data = Menu::get();
        return View('admin.menus')->with('data', $data);
    }

    public function viewmenu($id)
    {
        if(Menu::where('id', $id)->count()<1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
        }
        $menu = Menu::find($id);
        return View('admin.menus', compact('menu'));
    }

    public function actionMenus(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	Menu::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Menu::where('id', $action)->update(array('status' => '0'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function updateStatus(Request $request)
    {
        if(count(Menu::where('id', $request->id)->first())<1)
        {
            $data = [
                'type'      => 'error',
                'message'   => 'something went wrong. please try again.',
            ];
            return response()->json($data, 200);
        }
        if($request->input('cmbaction')=='Active')
        {
            Menu::where('id', $request->id)->update(array('status' => '1'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully activated.',
            ];
            return response()->json($data, 200);
        }
        else
        {
            Menu::where('id', $request->id)->update(array('status' => '0'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully inactivated.',
            ];
            return response()->json($data, 200);
        }
    }

    public function addmenu()
    {
        $menus = Menu::pluck('name','id')->all();
        return View('admin.menus',compact('menus'));
    }

    public function savemenu(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required'
        ]);

        if(!empty($request->id))
        {
            $this->validate($request, [
                'email'     => 'required|email|unique:menus,email,'.$request->id,
                'menuname'     => 'required|unique:menus,menuname,'.$request->id
            ]);
            $data = [
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'order_number' => $request->order_number,
                'position_type' => $request->position_type,
                'status' => $request->status,
                'icon_path' => $request->icon_path
            ];

            $menu = Menu::find($request->id);
            $menu->update($data);
            return redirect()->route('menus-list')->with('success','Menu successfully updated.');
        }
        else
        {

            $input 					= $request->all();
            $input['slug'] 		= Str::slug($request->name);
            $menu = Menu::create($input);
            return redirect()->route('menus-list')->with('success','Menu successfully created.');
        }
    }

    public function editmenu($id)
    {
         if(Menu::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $menus = Menu::pluck('name','id')->all();
        $menu = Menu::where('id', $id)->first();
        return View('admin.menus',compact('menu','menus'));
    }

    public function deletemenu($id)
    {
         if(Menu::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $menu = Menu::where('id', $id)->delete();
        return redirect()->back()->with('delete','Menu successfully created.');
    }
}
