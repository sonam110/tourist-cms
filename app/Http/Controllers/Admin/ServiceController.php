<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appsetting;
use DB;
use Str;

class ServiceController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:service-browse', ['only' => ['index']]);
        $this->middleware('permission:service-add', ['only' => ['create', 'store', 'action']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'store', 'action']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy', 'action']]);
    }

    public function index()
    {
        $data = Service::get();
        return view('admin.services')->with('data', $data);
    }

    public function show($id)
    {
        if (Service::where('id', $id)->count() < 1) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $service = Service::find($id);
        return view('admin.services', compact('service'));
    }

    public function action(Request $request)
    {
        $data = $request->all();

        foreach ($request->input('boxchecked') as $action) {
            if ($request->input('cmbaction') == 'Active') {
                Service::where('id', $action)->update(['status' => '1']);
            } else {
                Service::where('id', $action)->update(['status' => '2']);
            }
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }

    public function create()
    {
        $services = Service::pluck('name', 'id')->all();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        if (!empty($request->id)) {
            $this->validate($request, [
                'name' => 'required|unique:services,name,' . $request->id
            ]);

            $data = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'status' => $request->status
            ];

            $service = Service::find($request->id);
            $service->update($data);
            return redirect()->route('services-list')->with('success', 'Service successfully updated.');
        } else {
            $input = $request->all();
            Service::create($input);
            return redirect()->route('services-list')->with('success', 'Service successfully created.');
        }
    }

    public function edit($id)
    {
        if (Service::where('id', $id)->count() < 1) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        if ($id == '1') {
            return redirect()->back()->with('error', 'Cannot edit this record.');
        }

        $services = Service::pluck('name', 'id')->all();
        $service = Service::where('id', $id)->first();
        return view('admin.services', compact('service', 'services'));
    }

    public function destroy($id)
    {
        if (Service::where('id', $id)->count() < 1) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        $service = Service::find($id);

        if ($id->id != 1 && $id->id != 6 && $id->id != 26 && $id->id != 27) {
            return redirect()->back()->with('error', 'Cannot delete this record.');
        }

        Service::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Service successfully deleted.');
    }
}
