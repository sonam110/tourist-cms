<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appsetting;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    protected $appSetting;

    public function __construct()
    {
        $this->appSetting = Appsetting::first();
        $this->middleware('permission:user-browse', ['only' => ['index']]);
        $this->middleware('permission:user-add', ['only' => ['create', 'store', 'action']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'store', 'action']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy', 'action']]);
    }

    public function index()
    {
        $data = User::where('role_id', '!=', '1')
            ->orWhereNull('role_id')
            ->get();
        return view('admin.users', compact('data'));
    }

    public function show($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $data = User::where('userType', '!=', 'admin')->get();
        return view('admin.users', compact('user', 'data'));
    }

    public function action(Request $request)
    {
        $status = $request->input('cmbaction') === 'Active' ? '1' : '2';
        User::whereIn('id', $request->input('boxchecked'))->update(['status' => $status]);
        return redirect()->back()->with('success', 'Action successfully done.');
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('admin.users', compact('roles'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($request->id),
        ],
        'mobile' => 'required|numeric|digits_between:10,15',
        'password' => [
            $request->id ? 'nullable' : 'required',
            'min:8',
            'same:confirm-password',
        ],
        'role_id' => 'required|exists:roles,id',
    ]);

    $data = $request->only(['name', 'email', 'mobile', 'role_id', 'address']);
    $role = Role::find($request->role_id);

    if (!$request->id) {
        $data['password'] = bcrypt($request->password);
        $data['userType'] = 'admin';
        $user = User::create($data);
        $user->assignRole($role);
        $message = 'User successfully created.';
    } else {
        $user = User::findOrFail($request->id);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        $user->syncRoles([$role]);
        $message = 'User successfully updated.';
    }

    return redirect()->route('users-list')->with('success', $message);
}


    public function edit($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $roles = Role::where('name', '!=', 'admin')->get();
        return view('admin.users', compact('roles', 'user'));
    }

    public function destroy($uuid)
    {
        User::where('uuid', $uuid)->firstOrFail()->delete();
        return redirect()->back()->with('delete', 'User successfully deleted.');
    }
}
