<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Country;
use DB;
use Str;
class LanguageController extends Controller
{
    public function languages()
    {
        $data = Language::get();
        return View('admin.languages')->with('data', $data);
    }

    public function actionLanguages(Request $request)
    {
      	$data  = $request->all();
      	foreach($request->input('boxchecked') as $action)
      	{
          	if($request->input('cmbaction')=='Active')
          	{
              	Language::where('id', $action)->update(array('status' => '1'));
          	}
          	else
          	{
              	Language::where('id', $action)->update(array('status' => '2'));
          	}
      	}
      	return \Redirect()->back()->with('success', 'Action successfully done.');;
  	}

    public function updateStatus(Request $request)
    {
        if(count(Language::where('id', $request->id)->first())<1)
        {
            $data = [
                'type'      => 'error',
                'message'   => 'something went wrong. please try again.',
            ];
            return response()->json($data, 200);
        }
        if($request->input('cmbaction')=='Active')
        {
            Language::where('id', $request->id)->update(array('status' => '1'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully activated.',
            ];
            return response()->json($data, 200);
        }
        else
        {
            Language::where('id', $request->id)->update(array('status' => '0'));
            $data = [
                'type'      => 'success',
                'message'   => 'Account successfully inactivated.',
            ];
            return response()->json($data, 200);
        }
    }

    public function addlanguage()
    {
        $languages = Language::pluck('name','id')->all();
        return View('admin.languages',compact('languages'));
    }

    public function savelanguage(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required'
        ]);

        if(!empty($request->id))
        {
            $this->validate($request, [
                'name'     => 'required|unique:languages,name,'.$request->id
            ]);
            $data = [
                'name' => $request->name,
                'value' => $request->value,
                'status' => $request->status ? $request->status : 1
            ];

            $language = Language::find($request->id);
            $language->update($data);
            return redirect()->route('languages-list')->with('success','Language successfully updated.');
        }
        else
        {

            $input 					= $request->all();
            $language = Language::create($input);
            return redirect()->route('languages-list')->with('success','Language successfully created.');
        }
    }

    public function editlanguage($id)
    {
         if(Language::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
         $languages = Language::pluck('name','id')->all();
        $language = Language::where('id', $id)->first();
        return View('admin.languages',compact('language','languages'));
    }

    public function deletelanguage($id)
    {
         if(Language::where('id', $id)->count()<1)
         {
             notify()->error('Oops!!!, something went wrong, please try again.');
             return \Redirect()->back();
         }
        $language = Language::where('id', $id)->delete();
        return redirect()->back()->with('delete','Language successfully deleted.');
    }
}
