<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
    }

    public function index()
    {
        $blogs = Blog::where('posted_by',auth()->id())->withCount('comments')->with('postedBy:id,name','categoryLists:id,name')->get();
        $user = auth()->user();
        return view('user.blogs',compact('blogs','user'));
    }

    public function create()
    {
        return view('user.blogs');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'categories' => 'required|array',
            'content' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'language_id' => $request->language_id ? $request->language_id : $this->appSetting->default_language,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'categories' => json_encode($request->categories),
            'content' => $request->content,
            'order_number' => $request->order_number,
            'posted_by' => $request->posted_by ? $request->posted_by : auth()->id(),
            'post_date' => $request->post_date ? $request->post_date : date('Y-m-d'),
            'seo_key' => $request->seo_key,
            'status' => $request->status ? $request->status : 2,
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/blogs');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/blogs/'.$name;
        }

        if(!empty($request->id))
        {
            $blog = Blog::find($request->id);
            $blog->update($data);
            return redirect()->route('user.blogs-list')->with('success', 'Blog successfully updated.');
        }
        else
        {
            Blog::create($data);
            return redirect()->route('user.blogs-list')->with('success', 'Blog successfully created.');
        }
    }

    public function edit($slug)
    {
        if(Blog::where('slug', $slug)->where('posted_by',auth()->id())->count() < 1)
        {
            redirect()->back()->with('error', 'Record Not Found.');
            return redirect()->back();
        }
        $blog = Blog::where('slug',$slug)->first();
        return view('user.blogs', compact('blog'));
    }

    public function destroy($slug)
    {
        if(Blog::where('slug', $slug)->where('posted_by',auth()->id())->count() < 1)
        {
            redirect()->back()->with('error', 'Record Not Found.');
            return redirect()->back();
        }

        Blog::where('slug', $slug)->delete();
        return redirect()->back()->with('success', 'Blog successfully deleted.');
    }
}
