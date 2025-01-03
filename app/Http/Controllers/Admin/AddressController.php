<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Appsetting;
use DB;
class AddressController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
	    $this->appSetting = Appsetting::first();
	    $this->middleware('permission:address-browse',['only' => ['index']]);
        $this->middleware('permission:address-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:address-edit', ['only' => ['edit','update','action']]);
        $this->middleware('permission:address-delete', ['only' => ['destroy','action']]);
	}

	public function index()
	{
		$data = Address::get();
		return View('admin.addresses',compact('data'));
	}

	public function create()
	{
		return View('admin.addresses');
	}

	public function store(Request $request)
	{
		$data = [
			'language_id' => $request->language_id ? $request->language_id : $this->appSetting->default_language,
			'title' => $request->title,
			'email' => $request->email,
			'mobilenum' => $request->mobilenum,
			'address' => $request->address,
			'website' => $request->website,
			'gst' => $request->gst,
		];
		
		if (!empty($request->id)) {
                $this->validate($request, [
                    'title' => 'required|unique:addresses,title,' . $request->id,
                    'email' => 'required',
                    'mobilenum' => 'required',
                    'address' => 'required'
                ]);

                $address = Address::findOrFail($request->id);
                $address->update($data);
                return redirect()->route('addresses-list')->with('success', 'Address successfully updated.');
            } else {
                $this->validate($request, [
                    'title' => 'required|unique:addresses,title',
                    'email' => 'required|email',
                    'mobilenum' => 'required',
                    'address' => 'required'
                ]);

                Address::create($data);
                return redirect()->route('addresses-list')->with('success', 'Address successfully created.');
            }
	}

	public function edit($id)
	{
		$address = Address::find($id);
		if(!empty($address))
		{
			return View('admin.addresses',compact('address'));
		}
		else
		{
			return redirect()->back()->with('error','Address Not Found.');
		}
	}

	public function destroy($id)
	{
		$address = Address::find($id);
		if(!empty($address))
		{
			$address->delete();
			return redirect()->back()->with('delete','Address successfully deleted.');
		}
		else
		{
			return redirect()->back()->with('error','Address Not Found.');
		}
	}
}
