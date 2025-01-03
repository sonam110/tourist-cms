<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Appsetting;
use App\Models\Country;
use DB;
use Str;
class CurrencyController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:currency-browse',['only' => ['index']]);
        $this->middleware('permission:currency-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:currency-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:currency-delete', ['only' => ['destroy','action']]);
    }

    public function index()
    {
        $data = Currency::get();
        return View('admin.currencies')->with('data', $data);
    }

    public function show($id)
    {
        if(Currency::where('id', $id)->count()<1)
        {
            notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
        }
        $currency = Currency::find($id);
        return View('admin.currencies', compact('currency'));
    }

    public function action(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	Currency::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Currency::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function create()
    {
        $currencies = Currency::pluck('name','id')->all();
        return View('admin.currencies',compact('currencies'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required'
        ]);

        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:currencies,name,'.$request->id
            ]);
            $data = [
                'name' => $request->name,
                'icon' => $request->icon,
                'status' => $request->status
            ];

            $currency = Currency::find($request->id);
            $currency->update($data);
            return redirect()->route('currencies-list')->with('success','Currency successfully updated.');
        }
        else
        {

            $input 					= $request->all();
            $currency = Currency::create($input);
            return redirect()->route('currencies-list')->with('success','Currency successfully created.');
        }
    }

    public function edit($id)
    {
         if(Currency::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $currencies = Currency::pluck('name','id')->all();
        $currency = Currency::where('id', $id)->first();
        return View('admin.currencies',compact('currency','currencies'));
    }

    public function destroy($id)
    {
         if(Currency::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $currency = Currency::where('id', $id)->delete();
        return redirect()->back()->with('delete','Currency successfully deleted.');
    }
}
