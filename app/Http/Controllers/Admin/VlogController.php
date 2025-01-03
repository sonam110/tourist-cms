<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vlog;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class VlogController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
		$this->middleware('permission:vlog-browse',['only' => ['index']]);
		$this->middleware('permission:vlog-add', ['only' => ['create','store','action']]);
		$this->middleware('permission:vlog-edit', ['only' => ['edit','store','action']]);
		$this->middleware('permission:vlog-delete', ['only' => ['destroy','action']]);
	}

	public function index()
	{
		$data = Vlog::get();
		return view('admin.vlogs')->with('data', $data);
	}

	public function show($id)
	{
		if(Vlog::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}

		$vlog = Vlog::with('categories')->find($id);
		return view('admin.vlogs', compact('vlog'));
	}

	public function action(Request $request)
	{
		$data = $request->all();
		foreach($request->input('boxchecked') as $action)
		{
			if($request->input('cmbaction') == 'Add To Home')
            {
                Vlog::where('id', $action)->update(['view_on_home' => '1']);
            }
            elseif($request->input('cmbaction') == 'Remove From Home')
            {
                Vlog::where('id', $action)->update(['view_on_home' => '2']);
            }
            elseif($request->input('cmbaction') == 'Active')
            {
                Vlog::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                Vlog::where('id', $action)->update(['status' => '2']);
            }
		}

		return redirect()->back()->with('success', 'Action successfully completed.');
	}

	public function create()
	{
		return view('admin.vlogs');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'title' => 'required',
			'categories' => 'required|array',
			'status' => 'required|in:1,2'
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

		// $video = $request->file('video_path');
		// $name = time() . '.' . $video->getClientOriginalExtension();
		// $destinationPath = public_path('/uploads/vlogs');
		
  		// Debugging
		// if (!is_dir($destinationPath)) {
		// 	return "Destination path does not exist.";
		// }
		
		// if (!$video->move($destinationPath, $name)) {
		// 	return "Failed to move the video file.";
		// }
		
		// $data['video_path'] = 'uploads/vlogs/' . $name;

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
			return redirect()->route('vlogs-list')->with('success', 'Vlog successfully updated.');
		}
		else
		{
			Vlog::create($data);
			return redirect()->route('vlogs-list')->with('success', 'Vlog successfully created.');
		}
	}

	public function edit($id)
	{
		if(Vlog::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}
		$vlog = Vlog::find($id);
		return view('admin.vlogs', compact('vlog'));
	}

	public function destroy($id)
	{
		if(Vlog::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}

		Vlog::where('id', $id)->delete();
		return redirect()->back()->with('delete', 'Vlog successfully deleted.');
	}
}
