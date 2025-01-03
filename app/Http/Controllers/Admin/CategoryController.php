<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Appsetting;
use App\Models\Country;
use DB;
use Str;
class CategoryController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:category-browse',['only' => ['index']]);
        $this->middleware('permission:category-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Category::get();
        return View('admin.categories')->with('data', $data);
    }

    public function show($id)
    {
        if(Category::where('id', $id)->count()<1)
        {
            return redirect()->back()->with('error','Record not found');
             return \Redirect()->back();
        }
        $category = Category::find($id);
        return View('admin.categories', compact('category'));
    }

    public function action(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	Category::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Category::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function create()
    {
        $categories = Category::pluck('name','id')->all();
        return View('admin.categories',compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required'
        ]);

        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:categories,name,'.$request->id
            ]);
            $data = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'status' => $request->status
            ];

            $category = Category::find($request->id);
            $category->update($data);
            return redirect()->route('categories-list')->with('success','Category successfully updated.');
        }
        else
        {

            $input 					= $request->all();
            $category = Category::create($input);
            return redirect()->route('categories-list')->with('success','Category successfully created.');
        }
    }

    public function edit($id)
    {
         if(Category::where('id', $id)->count()<1)
         {
             return redirect()->back()->with('error','Record not found');
             return \Redirect()->back();
         }
         $categories = Category::pluck('name','id')->all();
        $category = Category::where('id', $id)->first();
        return View('admin.categories',compact('category','categories'));
    }

    public function destroy($id)
    {
         if(Category::where('id', $id)->count()<1)
         {
             return redirect()->back()->with('error','Record not found');
             return \Redirect()->back();
         }
        $category = Category::where('id', $id)->delete();
        return redirect()->back()->with('delete','Category successfully deleted.');
    }
}
