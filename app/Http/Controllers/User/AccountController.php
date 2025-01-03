<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\BookingInquiry;
use App\Models\Booking;
use App\Models\Vlog;
use Str;
use Intervention\Image\ImageManager;
class AccountController extends Controller
{
	public function dashboard()
    {
        $user = auth()->user();
        $blogs = Blog::where('status',1)->withCount('comments')->with('postedBy:id,name','categoryLists:id,name')->get();
        $vlogs = Vlog::where('status',1)->withCount('comments')->with('postedBy:id,name','categoryLists:id,name')->get();
        $bookings = BookingInquiry::get();
        return view('user.dashboard',compact('user','blogs','vlogs','bookings'));
    }

	public function editprofile()
	{
		$user = User::find(Auth::id());
		return view('user.edit-profile', compact('user'));
	}

	public function updateProfile(Request $request)
	{
		// dd($request);
    // Validate the incoming request
		$validator = \Validator::make($request->all(), [
			'name'          => ['required', 'string', 'max:191'],
			'email'         => 'required|email|unique:users,email,' . Auth::id(),
			'mobile'        => ['required', 'numeric', 'digits_between:10,12'],
		]);

    // Check if validation fails
		if ($validator->fails()) {
			return response()->json([
				'status' => 'error',
				'errors' => $validator->errors()
			], 422);
		}

    // Handle the profile image upload
		if ($request->hasFile('profile_image')) {
			$image = $request->file('profile_image');
			$name = time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/profile');
			$image->move($destinationPath, $name);
			$profile_image = 'uploads/profile/' . $name;
		}

	    // Handle the banner image upload
		if ($request->hasFile('banner_image')) {
			$image = $request->file('banner_image');
			$name = time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/banner');
			$image->move($destinationPath, $name);
			$banner_image = 'uploads/banner/' . $name;
		}

    // Update user profile
		$user = User::find(Auth::id());
		$user->name         = $request->name;
		$user->email        = $request->email;
		$user->mobile       = $request->mobile;
		$user->country_code       = $request->country_code;
		$user->address      = $request->address;
		if (isset($profile_image)) {
			$user->profile_image = $profile_image;
		}
		if (isset($banner_image)) {
			$user->banner_image = $banner_image;
		}
		$user->save();

    // Return a JSON response
		return response()->json([
			'status' => 'success',
			'message' => 'Profile updated successfully.',
			'profile_image_url' => asset($user->profile_image),
			'banner_image_url' => asset($user->banner_image)
		]);
	}


	public function changePassword(Request $request)
	{
		$this->validate($request, [
			'old_password'              => ['required'],
			'new_password'              => ['required', 'confirmed', 'min:6', 'max:25'],
			'new_password_confirmation' => ['required']
		]);

		$matchpassword  = User::find(Auth::user()->id)->password;
		if(\Hash::check($request->old_password, $matchpassword))
		{
			$user = User::find(Auth::user()->id);
			$user->password = bcrypt($request->new_password);
			$user->save();
			return \Redirect()->back()->with('success','Success, Password successfully changed.');
		}
		else
		{
			return \Redirect()->back()->with('error','Incorrect password, Please try again with correct password.');
		}
		return \Redirect()->back();
	}

	public function bookings()
	{
		$bookings = Booking::where('user_id',auth()->id())->with('package')->get();
		return view('user.bookings', compact('bookings'));
	}

	public function logout()
	{
		Auth::logout();
		return \Redirect('/');
	}
}
