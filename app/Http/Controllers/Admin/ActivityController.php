<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Package;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:activity-browse',['only' => ['index']]);
        $this->middleware('permission:activity-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:activity-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:activity-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $activities = Package::where('language_id',$this->appSetting->default_language)
        ->with(['destination'])
        ->where('data_for','activity')
        ->get()
        ->map(function($package) {
            return Package::where('id', $package->id)->with('destination')->first();
        });
        return view('admin.activities',compact('activities'));
    }

    public function show($id)
    {
        if(Activity::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error', 'Record not found.');
            return redirect()->back();
        }

        $activity = Activity::find($id);
        return view('admin.activities', compact('activity'));
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction') == 'Active')
            {
                Activity::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                Activity::where('id', $action)->update(['status' => '2']);
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }

    public function create()
    {
        return view('admin.activities');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:1,2',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'destination_id' => $request->destination_id,
            'content' => $request->content,
            'seo_keyword' => $request->seo_keyword,
            'status' => $request->status ? $request->status : 2,
            'slug' => Str::slug($request->title),
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/activities');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/activities/'.$name;
        }

        if(!empty($request->id))
        {
            $activity = Activity::find($request->id);
            $activity->update($data);
            return redirect()->route('activities-list')->with('success', 'Activity successfully updated.');
        }
        else
        {
            Activity::create($data);
            return redirect()->route('activities-list')->with('success', 'Activity successfully created.');
        }
    }

    public function edit($id)
    {
        if(Activity::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error', 'Record not found.');
            return redirect()->back();
        }
        $activity = Activity::find($id);
        return view('admin.activities', compact('activity'));
    }

    public function destroy($id)
    {
        if(Activity::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error', 'Record not found.');
            return redirect()->back();
        }

        Activity::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Activity successfully deleted.');
    }
}
