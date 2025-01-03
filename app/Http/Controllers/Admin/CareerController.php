<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\Appsetting;
use DB;
use Str;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:career-list',['only' => ['index']]);
        $this->middleware('permission:career-add', ['only' => ['create','store', 'action']]);
        $this->middleware('permission:career-edit', ['only' => ['edit','store', 'action']]);
        $this->middleware('permission:career-delete', ['only' => ['destroy', 'action']]);
    }

    public function index()
    {
        $data = Career::get();
        return View('admin.career')->with('data', $data);
    }

    public function show($id)
    {
        if(Career::where('id', $id)->count()<1)
        {
            return redirect()->back()->with('error','Record not found');
             return \Redirect()->back();
        }
        $career = Career::find($id);
        return View('admin.career', compact('career'));
    }

    public function action(Request $request)
    {
        $data  = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction')=='Active')
            {
                Career::where('id', $action)->update(array('status' => '1'));
            }
            else
            {
                Career::where('id', $action)->update(array('status' => '2'));
            }
        }
        return \Redirect()->back()->with('success', 'Action successfully done.');;
    }

    public function create()
    {
        return View('admin.career');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            // 'location' => 'required',
            'description' => 'required',
            // 'salary' => 'required',
        ]);

        if(!empty($request->id))
        {
            $this->validate($request, [
                'title'     => 'required|unique:careers,title,'.$request->id
            ]);
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'subtitle' => $request->subtitle,
                'location' => $request->location,
                'description' => $request->description,
                'salary' => $request->salary,
                'status' => $request->status
            ];

            $career = Career::find($request->id);
            $career->update($data);
            return redirect()->route('career-list')->with('success','Career successfully updated.');
        }
        else
        {
            $input = $request->all();
            $input['slug'] = Str::slug($request->title);
            $career = Career::create($input);
            return redirect()->route('career-list')->with('success','Career successfully created.');
        }
    }

    public function edit($id)
    {
        if(Career::where('id', $id)->count()<1)
        {
            return redirect()->back()->with('error','Record not found.');
            return \Redirect()->back();
        }
        $career = Career::where('id', $id)->first();
        return View('admin.career',compact('career'));
    }

    public function destroy($id)
    {
        if(Career::where('id', $id)->count()<1)
        {
            return redirect()->back()->with('error','Record not found.');
            return \Redirect()->back();
        }
        $career = Career::where('id', $id)->delete();
        return redirect()->back()->with('delete','Career successfully deleted.');
    }
}
