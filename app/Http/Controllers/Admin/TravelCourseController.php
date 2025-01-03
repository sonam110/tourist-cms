<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TravelCourse;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class TravelCourseController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:travel-course-browse',['only' => ['index']]);
        $this->middleware('permission:travel-course-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:travel-course-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:travel-course-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = TravelCourse::get();
        return view('admin.travel_courses')->with('data', $data);
    }

    public function show($id)
    {
        if(TravelCourse::where('id', $id)->count() < 1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
            return redirect()->back();
        }

        $travelCourse = TravelCourse::find($id);
        return view('admin.travel_courses', compact('travelCourse'));
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction') == 'Active')
            {
                TravelCourse::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                TravelCourse::where('id', $action)->update(['status' => '2']);
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }

    public function create()
    {
        return view('admin.travel_courses');
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
            'language_id' => $request->language_id ? $request->language_id : $this->appSetting->default_language,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'video_link' => $request->video_link,
            'status' => $request->status ? $request->status : 2,
            'seo_keyword' => $request->seo_keyword,
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/TravelCourses');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/TravelCourses/'.$name;
        }

        if(!empty($request->id))
        {
            $travelCourse = TravelCourse::find($request->id);
            $travelCourse->update($data);
            return redirect()->route('travel-courses-list')->with('success', 'TravelCourse successfully updated.');
        }
        else
        {
            TravelCourse::create($data);
            return redirect()->route('travel-courses-list')->with('success', 'TravelCourse successfully created.');
        }
    }

    public function edit($id)
    {
        if(TravelCourse::where('id', $id)->count() < 1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
            return redirect()->back();
        }
        $travelCourse = TravelCourse::find($id);
        return view('admin.travel_courses', compact('travelCourse'));
    }

    public function destroy($id)
    {
        if(TravelCourse::where('id', $id)->count() < 1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
            return redirect()->back();
        }

        TravelCourse::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'TravelCourse successfully deleted.');
    }
}
