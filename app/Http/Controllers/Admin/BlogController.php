<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:blog-browse',['only' => ['index']]);
        $this->middleware('permission:blog-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Blog::get();
        return view('admin.blogs')->with('data', $data);
    }

    public function show($id)
    {
        if(Blog::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Blog Not Found.');
        }

        $blog = Blog::with('categories')->find($id);
        return view('admin.blogs', compact('blog'));
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $action)
        {
            if($request->input('cmbaction') == 'Add To Home')
            {
                Blog::where('id', $action)->update(['view_on_home' => '1']);
            }
            elseif($request->input('cmbaction') == 'Remove From Home')
            {
                Blog::where('id', $action)->update(['view_on_home' => '2']);
            }
            elseif($request->input('cmbaction') == 'Active')
            {
                Blog::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                Blog::where('id', $action)->update(['status' => '2']);
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }

    public function create()
    {
        return view('admin.blogs');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'categories' => 'required|array',
            'content' => 'required',
            // 'order_number' => 'required|integer',
            // 'posted_by' => 'required',
            // 'post_date' => 'required|date',
            // 'seo_key' => 'required',
            'status' => 'required|in:1,2',
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
            return redirect()->route('blogs-list')->with('success', 'Blog successfully updated.');
        }
        else
        {
            Blog::create($data);
            return redirect()->route('blogs-list')->with('success', 'Blog successfully created.');
        }
    }

    public function edit($id)
    {
        if(Blog::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Blog Not Found.');
        }
        $blog = Blog::find($id);
        return view('admin.blogs', compact('blog'));
    }

    public function destroy($id)
    {
        if(Blog::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Blog Not Found.');
        }

        Blog::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Blog successfully deleted.');
    }
}
