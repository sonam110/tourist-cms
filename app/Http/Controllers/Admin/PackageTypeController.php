<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\Appsetting;
use Illuminate\Support\Str;

class PackageTypeController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
		// $this->middleware('permission:packageType-browse',['only' => ['index']]);
		// $this->middleware('permission:packageType-add', ['only' => ['create','store','action']]);
		// $this->middleware('permission:packageType-edit', ['only' => ['edit','store','action']]);
		// $this->middleware('permission:packageType-delete', ['only' => ['destroy','action']]);
	}

	public function index()
	{
		$data = PackageType::get();
		return view('admin.package_type')->with('data', $data);
	}

	public function show($id)
	{
		if(PackageType::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}

		$packageType = PackageType::with('categories')->find($id);
		return view('admin.package_type', compact('packageType'));
	}

	public function action(Request $request)
	{
		$data = $request->all();
		foreach($request->input('boxchecked') as $action)
		{
			if($request->input('cmbaction') == 'Add To Home')
            {
                PackageType::where('id', $action)->update(['view_on_home' => '1']);
            }
            elseif($request->input('cmbaction') == 'Remove From Home')
            {
                PackageType::where('id', $action)->update(['view_on_home' => '2']);
            }
            elseif($request->input('cmbaction') == 'Active')
            {
                PackageType::where('id', $action)->update(['status' => '1']);
            }
            else
            {
                PackageType::where('id', $action)->update(['status' => '2']);
            }
		}

		return redirect()->back()->with('success', 'Action successfully completed.');
	}

	public function create()
	{
		return view('admin.package_type');
	}

	public function store(Request $request)
	{

		$data = [
			'package_type' => $request->package_type
		];

		if(!empty($request->id))
		{

			$this->validate($request, [
				'package_type' => 'required|unique:package_types,package_type,'.$request->id
			]);
			$packageType = PackageType::find($request->id);
			$packageType->update($data);
			return redirect()->route('package-types-list')->with('success', 'PackageType successfully updated.');
		}
		else
		{

			$this->validate($request, [
				'package_type' => 'required|unique:package_types,package_type'
			]);
			PackageType::create($data);
			return redirect()->route('package-types-list')->with('success', 'PackageType successfully created.');
		}
	}

	public function edit($id)
	{
		if(PackageType::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}
		$packageType = PackageType::find($id);
		return view('admin.package_type', compact('packageType'));
	}

	public function destroy($id)
	{
		if(PackageType::where('id', $id)->count() < 1)
		{
			notify()->error('Oops!!!, something went wrong, please try again.');
			return redirect()->back();
		}

		PackageType::where('id', $id)->delete();
		return redirect()->back()->with('delete', 'PackageType successfully deleted.');
	}
}
