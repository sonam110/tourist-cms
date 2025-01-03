<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vlog;
use App\Models\User;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class VlogController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
    }

    public function index()
    {
        $vlogs = Vlog::where('posted_by',auth()->id())->withCount('comments')->with('postedBy:id,name','categoryLists:id,name')->get();
        $user = auth()->user();
        return view('user.vlogs',compact('vlogs','user'));
    }

    public function create()
    {
        return view('user.vlogs');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'categories' => 'required|array',
            'video_path' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'language_id' => $request->language_id ? $request->language_id : $this->appSetting->default_language,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'categories' => json_encode($request->categories),
            'video_path' => $request->video_path,
            'order_number' => $request->order_number,
            'posted_by' => $request->posted_by ? $request->posted_by : auth()->id(),
            'post_date' => $request->post_date ? $request->post_date : date('Y-m-d'),
            'seo_key' => $request->seo_key,
            'status' => $request->status ? $request->status : 2,
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/vlogs');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/vlogs/'.$name;
        }

        if(!empty($request->id))
        {
            $vlog = Vlog::find($request->id);
            $vlog->update($data);
            return redirect()->route('user.vlogs-list')->with('success', 'Vlog successfully updated.');
        }
        else
        {
            Vlog::create($data);
            return redirect()->route('user.vlogs-list')->with('success', 'Vlog successfully created.');
        }
    }

    public function edit($slug)
    {
        if(Vlog::where('slug', $slug)->where('posted_by',auth()->id())->count() < 1)
        {
            redirect()->back()->with('error', 'Record Not Found.');
            return redirect()->back();
        }
        $vlog = Vlog::where('slug',$slug)->first();
        return view('user.vlogs', compact('vlog'));
    }

    public function destroy($slug)
    {
        if(Vlog::where('slug', $slug)->count() < 1)
        {
            redirect()->back()->with('error', 'Record Not Found.');
            return redirect()->back();
        }

        Vlog::where('slug', $slug)->where('posted_by',auth()->id())->delete();
        return redirect()->back()->with('success', 'Vlog successfully deleted.');
    }
}
