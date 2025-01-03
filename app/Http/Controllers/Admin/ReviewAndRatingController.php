<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewAndRating;
use App\Models\Package;
use App\Models\Appsetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;
use DB;
use Auth;
use App\Models\Label;

class ReviewAndRatingController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:review-and-rating-browse',['only' => ['index']]);
        $this->middleware('permission:review-and-rating-add', ['only' => ['create','store','action']]);
        $this->middleware('permission:review-and-rating-edit', ['only' => ['edit','store','action']]);
        $this->middleware('permission:review-and-rating-delete', ['only' => ['destroy','action']]);
    }
    
    public function index(Request $request)
    {
        try {
            // Select specific columns and aggregate them
            $packages = Package::select('uuid', DB::raw('MAX(id) as id'), DB::raw('MAX(package_name) as package_name'))
                                ->groupBy('uuid')
                                ->get();
            $data = ReviewAndRating::orderBy('id', 'DESC')->get();
            return view('admin.review_and_rating', compact('data', 'packages'));
        } catch (\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function create()
    {
        try {
            // Select specific columns and aggregate them
            $packages = Package::select('uuid', DB::raw('MAX(id) as id'), DB::raw('MAX(package_name) as package_name'))
                                ->groupBy('uuid')
                                ->get();
            return view('admin.review_and_rating', compact('packages'));
        } catch (\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            // Select specific columns and aggregate them
            $packages = Package::select('uuid', DB::raw('MAX(id) as id'), DB::raw('MAX(package_name) as package_name'))
                                ->groupBy('uuid')
                                ->get();
            $reviewAndRating = ReviewAndRating::find($id);
            if (!$reviewAndRating) {
                return redirect()->back()->with('error', 'Record Not Found!');
            }
            return view('admin.review_and_rating', compact('reviewAndRating', 'packages'));
        } catch (\Exception $exception) {
            \Log::error($exception);
            return $exception->getMessage();
        }
    }


    public function show($id)
    {
        try 
        {
            $reviewAndRating = ReviewAndRating::find($id);
            if(!$reviewAndRating)
            {
                return redirect()->back()->with('error','Record Not Found!');
            }
            return view('admin.review_and_rating', compact('reviewAndRating'));
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
            // 'package_uuid' => 'required|exists:packages,uuid',
            'rating' => 'required',
            'review' => 'required|string',
            // 'status' => 'required|boolean',
        ]);

        // Prepare the data for insertion/updating
        $data = [
            'package_uuid' => $request->package_uuid,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => $request->status ? $request->status : 1,
            'user_id' => $request->user_id ? $request->user_id : auth()->id(),
            'user_name' => $request->user_name ? $request->user_name : auth()->user()->name,
        ];

        // Check if an image is uploaded
        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/profile');
            $image->move($destinationPath, $name);
            $data['user_image'] = 'uploads/profile/' . $name; // Add user_image to data array
        }

        // Check if the request is for updating an existing record
        if (!empty($request->id)) {
            $reviewAndRating = ReviewAndRating::find($request->id);
            $reviewAndRating->update($data);

            $uuid = $reviewAndRating->package_uuid;
            $rating = ratingAvg($uuid);

            Package::where('uuid', $uuid)->update(['rating' => $rating]);
            return redirect()->route('review-and-ratings-list')->with('success', 'Review And Rating successfully updated.');
        } else {
            // Create a new record
            $reviewAndRating = ReviewAndRating::create($data);

            $uuid = $reviewAndRating->package_uuid;
            $rating = ratingAvg($uuid);

            Package::where('uuid', $uuid)->update(['rating' => $rating]);
            return redirect()->route('review-and-ratings-list')->with('success', 'Review And Rating successfully created.');
        }
    } catch (Exception $exception) {
        \Log::error($exception);
        return $exception->getMessage();
    }
}


    public function destroy($id)
    {
        try 
        {
            $reviewAndRating = ReviewAndRating::find($id);
            if($reviewAndRating)
            {
                $reviewAndRating->delete();
                return redirect()->back()->with('delete','Contact Us Deleted Successfully');
            }
            return redirect()->back()->with('error','Record Not Found!');
            
        } catch (\Throwable $exception) {
            \Log::error($exception);
            DB::rollback();
            return $exception->getMessage();
        }
    }

    public function action(Request $request)
    {
        $data = $request->all();
        foreach($request->input('boxchecked') as $id)
        {
            if($request->input('cmbaction') == 'Delete')
            {
                ReviewAndRating::where('id', $id)->delete();
            }
            elseif($request->input('cmbaction') == 'Active')
            {
                ReviewAndRating::where('id', $id)->update(['status' => '1']);
            }
            elseif($request->input('cmbaction') == 'Inactive')
            {
                ReviewAndRating::where('id', $id)->update(['status' => '2']);
            }
            else
            {
                return redirect()->back()->with('error', 'Action Invalid.');
            }
            $uuid = ReviewAndRating::find($id)->package_uuid;
            $rating = ratingAvg($uuid);

            Package::where('uuid',$uuid)->update(['rating'=>$rating]);
        }

        return redirect()->back()->with('success', 'Action successfully completed.');
    }
}