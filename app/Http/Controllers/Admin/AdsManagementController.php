<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdsManagement;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class AdsManagementController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:ads-management-browse',['only' => ['index']]);
        $this->middleware('permission:ads-management-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:ads-management-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:ads-management-delete', ['only' => ['destroy','action']]);
    }
    public function index()
    {
        $data = AdsManagement::get();
        return view('admin.ads-management')->with('data', $data);
    }

    public function show($id)
    {
        if(AdsManagement::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Record Not Found.');
        }

        $adsManagement = AdsManagement::with('categories')->find($id);
        return view('admin.ads-management', compact('adsManagement'));
    }

    public function create()
    {
        return view('admin.ads-management');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url_link' => 'required',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'url_link' => $request->url_link,
            'page_name' => $request->page_name
        ];

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/ads-managements');
            $image->move($destinationPath, $name);
            $data['image_path'] = 'uploads/ads-managements/'.$name;
        }

        if(!empty($request->id))
        {
            $adsManagement = AdsManagement::find($request->id);
            $adsManagement->update($data);
            return redirect()->route('ads-managements-list')->with('success', 'AdsManagement successfully updated.');
        }
        else
        {
            AdsManagement::create($data);
            return redirect()->route('ads-managements-list')->with('success', 'AdsManagement successfully created.');
        }
    }

    public function edit($id)
    {
        if(AdsManagement::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Record Not Found.');
        }
        $adsManagement = AdsManagement::find($id);
        return view('admin.ads-management', compact('adsManagement'));
    }

    public function destroy($id)
    {
        if(AdsManagement::where('id', $id)->count() < 1)
        {
            return redirect()->back()->with('error','Record Not Found.');
        }

        AdsManagement::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'AdsManagement successfully deleted.');
    }

    public function action(Request $request)
    {
        try {
            $action = $request->input('cmbaction');
            $ids = $request->input('boxchecked');

            if ($action && $ids) {
                foreach($ids as $id) {
                    $adsManagement = AdsManagement::find($id);
                    if ($adsManagement) {
                        if ($action == 'Delete') {
                            $adsManagement->delete();
                        } elseif ($action == 'Active') {
                            $adsManagement->update(['status' => 1]);
                        } elseif ($action == 'Inactive') {
                            $adsManagement->update(['status' => 2]);
                        }
                    }
                }
                
                return redirect()->back()->with('success', 'Action successfully completed.');
            }
            
            return redirect()->back()->with('error', 'No action or items selected.');
        } catch (\Exception $exception) {

            \Log::error($exception);
            return $exception->getMessage();
        }
    }
}
