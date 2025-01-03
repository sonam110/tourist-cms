<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Appsetting;
use App\Models\Country;
use DB;
use Str;
class DestinationController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:destination-browse',['only' => ['index']]);
        $this->middleware('permission:destination-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:destination-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:destination-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = Destination::get();
        return View('admin.destinations')->with('data', $data);
    }

    public function action(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
            if($request->input('cmbaction') == 'Add To Home')
            {
                Destination::where('id', $action)->update(['view_on_home' => '1']);
            }
            elseif($request->input('cmbaction') == 'Remove From Home')
            {
                Destination::where('id', $action)->update(['view_on_home' => '2']);
            }
            else
          	if($request->input('cmbaction')=='Active')
          	{
              	Destination::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Destination::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function create()
    {
        $destinations = Destination::pluck('name','id')->all();
        return View('admin.destinations',compact('destinations'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'destination_type' => $request->destination_type,
            'status' => $request->status ? $request->status : 1
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/destinations');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/destinations/'.$name;
        }

        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:destinations,name,'.$request->id
            ]);

            $destination = Destination::find($request->id);
            $destination->update($data);
            return redirect()->route('destinations-list')->with('success','Destination successfully updated.');
        }
        else
        {
            $this->validate($request, [
                'name'     => 'required|unique:destinations,name'
            ]);
            $destination = Destination::create($data);
            return redirect()->route('destinations-list')->with('success','Destination successfully created.');
        }
    }

    public function edit($id)
    {
         if(Destination::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $destinations = Destination::pluck('name','id')->all();
        $destination = Destination::where('id', $id)->first();
        return View('admin.destinations',compact('destination','destinations'));
    }

    public function destroy($id)
    {
         if(Destination::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $destination = Destination::where('id', $id)->delete();
        return redirect()->back()->with('delete','Destination successfully created.');
    }
}
