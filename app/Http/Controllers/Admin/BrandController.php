<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Appsetting;
use App\Models\Language;
use DB;
use Illuminate\Support\Facades\Storage;
use Str;
use File;

class BrandController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        // $this->middleware('permission:brand-browse',['only' => ['index']]);
        // $this->middleware('permission:brand-add', ['only' => ['create','store','action']]);
        // $this->middleware('permission:brand-delete', ['only' => ['destroy','action']]);
    }

    public function index()
    {
        $brands = Brand::get();
        return view('admin.brands', compact('brands'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image_path' => 'required|array',
        ]);
        if ($request->hasFile("image_path")) {
            foreach ($request->file("image_path") as $key => $image) {
                $name = time() . '-'.$key.'-.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/brands');
                $image->move($destinationPath, $name);
                $imagePath = 'uploads/brands/' . $name;
                Brand::create(['image_path' => $imagePath]);
            }
        }
        return redirect()->route('brands-list')->with('success', 'Brand added successfully');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with('error','Record not found');
            return redirect()->back();
        }

        $brand->delete();

        return redirect()->back()->with('success', 'Brand successfully deleted.');
    }

    public function imageDestroy(Request $request)
    {
        $image = Brand::find($request->id);
        if ($image) {

            File::delete(public_path($image->image_path));
            $image->delete();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

}
