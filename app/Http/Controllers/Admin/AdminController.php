<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use App\Models\User;
use Str;
use Intervention\Image\ImageManager;
class AdminController extends Controller
{
    
    public function index()
    {
        return view('admin.auth.login');
    }

    public function dashboard()
    {
        $getUsers   = User::count();

        return view('admin.dashboard',compact('getUsers'));
    }

    public function editprofile()
    {
    	$user = User::find(Auth::id());
        return view('admin.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'          => ['required', 'string', 'max:191'],
            'mobile'        => ['required', 'numeric', 'digits_between:10,12'],
            'locktimeout'   => ['required', 'numeric','min:10','max:120']
        ]);

        $profile_image = auth()->user()->profile_image;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/profile');
            $image->move($destinationPath, $name);
            $profile_image = 'uploads/profile/'.$name;
        }

        $user = User::find(Auth::user()->id);
        $user->name         = $request->name;
        $user->mobile       = $request->mobile;
        $user->address       = $request->address;
        $user->profile_image = $profile_image;
        $user->locktimeout  = $request->locktimeout;
        $user->save();
        if($user)
        {
           return \Redirect()->back()->with('success','Success, Profile setting successfully changed.');
        }
        else
        {
           return \Redirect()->back()->with('error','Oops!!!, something went wrong, please try again.');
        }
        return \Redirect()->back();

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

    public function logout()
    {
        Auth::logout();
        return \Redirect('/');
    }
}
