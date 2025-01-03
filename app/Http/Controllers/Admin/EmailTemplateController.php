<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Appsetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmailTemplateController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:email-template-browse',['only' => ['index']]);
        $this->middleware('permission:email-template-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:email-template-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:email-template-delete', ['only' => ['destroy','action']]);
    }

    public function index()
    {
        try 
        {
            $data = EmailTemplate::get();
            return view('admin.email_templates')->with('data', $data);
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function show($id)
    {
        try 
        {
            $emailTemplate = EmailTemplate::find($id);
            if(!$emailTemplate)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.email_templates', compact('emailTemplate'));
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('admin.email_templates');
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
        // Validate the request inputs
            $this->validate($request, [
                'template_for' => 'required|string|max:255',
                'mail_subject' => 'required|string|max:255',
                'mail_body' => 'required|string',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'status' => 'required|boolean',
            ]);

        // Prepare the data for insertion/updation
            $data = [
                'language_id' => $request->language_id ?? $this->appSetting->default_language,
                'template_for' => $request->template_for,
                'mail_subject' => $request->mail_subject,
                'mail_body' => $request->mail_body,
                'status' => $request->status,
            ];

            // Handle background image upload
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/EmailTemplates');
                $image->move($destinationPath, $name);
                $data['image_path'] = 'uploads/EmailTemplates/' . $name;
            }

        // Check if the request is for updating an existing record
            if (!empty($request->id)) {
                $emailTemplate = EmailTemplate::find($request->id);
                $emailTemplate->update($data);
                return redirect()->route('email-templates-list')->with('success', 'Email Template successfully updated.');
            } else {
            // Create a new record
                EmailTemplate::create($data);
                return redirect()->route('email-templates-list')->with('success', 'Email Template successfully created.');
            }
        } catch (Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function edit($id)
    {
        try 
        {
            $emailTemplate = EmailTemplate::find($id);
            if(!$emailTemplate)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.email_templates', compact('emailTemplate'));
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function destroy($id)
    {

        try 
        {
            $emailTemplate = EmailTemplate::find($id);
            if(!$emailTemplate)
            {
                
                return redirect()->back()->with('error','Record Not Found!');
            }
            $emailTemplate->delete();
            
            return redirect()->back()->with('delete', 'Dynamic Page successfully deleted.');
        }
        catch(\Exception $exception) {
            
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {

        try {
            $action = $request->input('cmbaction');
            $ids = $request->input('boxchecked');

            if ($action && $ids) {
                foreach($ids as $id) {
                    $emailTemplate = EmailTemplate::find($id);
                    if ($emailTemplate) {
                        if ($action == 'Delete') {
                            $emailTemplate->delete();
                        } elseif ($action == 'Active') {
                            $emailTemplate->update(['status' => 1]);
                        } elseif ($action == 'Inactive') {
                            $emailTemplate->update(['status' => 2]);
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
