<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Appsetting;
use DB;
class FaqController extends Controller
{
	protected $appSetting;

	public function __construct()
	{
		$this->appSetting = Appsetting::first();
		$this->middleware('permission:faq-browse',['only' => ['index']]);
        $this->middleware('permission:faq-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:faq-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:faq-delete', ['only' => ['destroy','action']]);
	}
	public function index()
	{
		$data = Faq::get();
		return View('admin.faqs',compact('data'));
	}

	public function create()
	{
		return View('admin.faqs');
	}

	public function store(Request $request)
	{
		$data = [
			'language_id' => $request->language_id ? $request->language_id : $this->appSetting->default_language,
			'question' => $request->question,
			'answer' => $request->answer
		];
		if(!empty($request->id))
		{
			$this->validate($request, [
				'question'     => 'required|unique:faqs,question,'.$request->id
			]);

			$faq = Faq::find($request->id);
			$faq->update($data);
			return redirect()->route('faqs-list')->with('success','Faq successfully updated.');
		}
		else
		{
			$this->validate($request, [
				'question'              => 'required|unique:faqs,question'
			]);
			$input 	= $request->all();
			$faq = Faq::create($input);
			return redirect()->route('faqs-list')->with('success','Faq successfully created.');
		}
	}

	public function edit($id)
	{
		$faq = Faq::find($id);
		if(!empty($faq))
		{
			return View('admin.faqs',compact('faq'));
		}
		else
		{
			return redirect()->back()->with('error','Faq Not Found.');
		}
	}

	public function destroy($id)
	{
		$faq = Faq::find($id);
		if(!empty($faq))
		{
			$faq->delete();
			return redirect()->back()->with('delete','Faq successfully deleted.');
		}
		else
		{
			return redirect()->back()->with('error','Faq Not Found.');
		}
	}
}
