<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DynamicPage;
use App\Models\Appsetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DynamicPageController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:dynamic-page-browse',['only' => ['index']]);
        $this->middleware('permission:dynamic-page-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:dynamic-page-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:dynamic-page-delete', ['only' => ['destroy','action']]);
    }

    public function index()
    {
        try 
        {
            $data = DynamicPage::get();
            return view('admin.dynamic_pages')->with('data', $data);
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
            $dynamicPage = DynamicPage::find($id);
            if(!$dynamicPage)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.dynamic_pages', compact('dynamicPage'));
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('admin.dynamic_pages');
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
                'title' => 'required|string|max:255',
                'sub_title' => 'required|string',
                'content' => 'required|string',
                'placed_in' => 'required|string',
                'banner_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'status' => 'required|boolean',
            ]);

        // Prepare the data for insertion/updation
            $data = [
                'language_id' => $request->language_id ?? $this->appSetting->default_language,
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'order_number' => $request->order_number,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
                'placed_in' => $request->placed_in,
                'seo_keyword' => $request->seo_keyword,
            ];

            // Handle background image upload
            if ($request->hasFile('banner_image_path')) {
                $image = $request->file('banner_image_path');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/DynamicPages');
                $image->move($destinationPath, $name);
                $data['banner_image_path'] = 'uploads/DynamicPages/' . $name;
            }

        // Check if the request is for updating an existing record
            if (!empty($request->id)) {
                $dynamicPage = DynamicPage::find($request->id);
                $dynamicPage->update($data);
                return redirect()->route('dynamic-pages-list')->with('success', 'Dynamic Page successfully updated.');
            } else {
            // Create a new record
                DynamicPage::create($data);
                return redirect()->route('dynamic-pages-list')->with('success', 'Dynamic Page successfully created.');
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
            $dynamicPage = DynamicPage::find($id);
            if(!$dynamicPage)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.dynamic_pages', compact('dynamicPage'));
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
            $dynamicPage = DynamicPage::find($id);
            if(!$dynamicPage)
            {
                
                return redirect()->back()->with('error','Record Not Found!');
            }
            $dynamicPage->delete();
            
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
                    $dynamicPage = DynamicPage::find($id);
                    if ($dynamicPage) {
                        if ($action == 'Delete') {
                            $dynamicPage->delete();
                        } elseif ($action == 'Active') {
                            $dynamicPage->update(['status' => 1]);
                        } elseif ($action == 'Inactive') {
                            $dynamicPage->update(['status' => 2]);
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
