<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Appsetting;
use DB;
use Str;
class GalleryController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:gallery-browse',['only' => ['index']]);
        $this->middleware('permission:gallery-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:gallery-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:gallery-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Gallery::get();
        return View('admin.gallery')->with('data', $data);
    }

    public function action(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
            if($request->input('cmbaction') == 'Add To Home')
            {
                Gallery::where('id', $action)->update(['view_on_home' => '1']);
            }
            elseif($request->input('cmbaction') == 'Remove From Home')
            {
                Gallery::where('id', $action)->update(['view_on_home' => '2']);
            }
            else
          	if($request->input('cmbaction')=='Active')
          	{
              	Gallery::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Gallery::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function create()
    {
        $galleries = Gallery::pluck('name','id')->all();
        return View('admin.gallery',compact('galleries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'gallery_type' => $request->gallery_type,
            'status' => $request->status ? $request->status : 1
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $galleryPath = public_path('/uploads/galleries');
            $image->move($galleryPath, $name);
            $data['image_path'] = 'uploads/galleries/'.$name;
        }

        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:galleries,name,'.$request->id
            ]);

            $gallery = Gallery::find($request->id);
            $gallery->update($data);
            return redirect()->route('galleries-list')->with('success','Gallery successfully updated.');
        }
        else
        {
            $gallery = Gallery::create($data);
            return redirect()->route('galleries-list')->with('success','Gallery successfully created.');
        }
    }

    public function edit($id)
    {
         if(Gallery::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $galleries = Gallery::pluck('name','id')->all();
        $gallery = Gallery::where('id', $id)->first();
        return View('admin.gallery',compact('gallery','galleries'));
    }

    public function destroy($id)
    {
         if(Gallery::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $gallery = Gallery::where('id', $id)->delete();
        return redirect()->back()->with('delete','Gallery successfully created.');
    }
}
