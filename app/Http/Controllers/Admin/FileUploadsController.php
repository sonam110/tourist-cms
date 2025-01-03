<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileUploads;
use App\Models\Appsetting;
use App\Models\Language;
use DB;
use Illuminate\Support\Facades\Storage;
use Str;
use File;

class FileUploadsController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
    }

    public function index()
    {
        $fileUploads = FileUploads::get();
        return view('admin.fileUploads', compact('fileUploads'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image_path' => 'required|array',
        ]);
        if ($request->hasFile("image_path")) {
            foreach ($request->file("image_path") as $key => $image) {
                $name = time() . '-'.$key.'-.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/fileUploads');
                $image->move($destinationPath, $name);
                $imagePath = 'uploads/fileUploads/' . $name;
                FileUploads::create(['image_path' => $imagePath]);
            }
        }
        return redirect()->route('file-uploads-list')->with('success', 'FileUploads added successfully');
    }

    public function destroy($id)
    {
        $fileUpload = FileUploads::find($id);

        if (!$fileUpload) {
            return redirect()->back()->with('error','Record not found');
            return redirect()->back();
        }

        $fileUpload->delete();

        return redirect()->back()->with('success', 'FileUploads successfully deleted.');
    }

    public function imageDestroy(Request $request)
    {
        $image = FileUploads::find($request->id);
        if ($image) {

            File::delete(public_path($image->image_path));
            $image->delete();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']);
    }

}
