@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-user' || Request::segment(2)==='add-user')
<?php
$id = $name = $email = $address = $role_id = $mobile = $status = '';

if (Request::segment(2) !== 'add-user') {
    $id = $user->id;
    $name = $user->name;
    $email = $user->email;
    $address = $user->address;
    $role_id = $user->role_id;
    $mobile = $user->mobile;
    $status = $user->status;
}
?>


<form action="{{ route('user-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2)==='add-user')
                        Add
                        @else
                        Edit
                        @endif
                        User
                    </h3>
                </div>
                <div class="card-body">
    <div class="row">
        <!-- Name -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $name ?? '') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" autocomplete="off" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- Password (only for adding new user) -->
        @if(Request::segment(2) === 'add-user')
        <div class="col-md-6">
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" placeholder="Confirm Password" autocomplete="off" required>
                @error('confirm-password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        @endif

        <!-- Mobile -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $mobile ?? '') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" autocomplete="off" required>
                @error('mobile')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- Role -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="role_id" class="form-label">Role</label>
                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $value)
                    <option value="{{ $value->id }}" {{ old('role_id', $role_id ?? '') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- Address -->
        <div class="form-group col-sm-12">
            <label for="address" class="form-label">Address</label>
            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address" autocomplete="off">{{ old('address', $address ?? '') }}</textarea>
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>

                <div class="card-footer text-center">
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>

    @elseif(Request::segment(2)==='view-user')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <tr>
                                <td><span class="text-muted">{{ $row->id }}</span></td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->mobile }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <a href="{{ url('admin/edit-user/'.$row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{ url('admin/delete-user/'.$row->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title">User Management</h3>
                    <div class="card-options">
                        @can('user-add')
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('user-create') }}"> 
                            <i class="fa fa-plus"></i> Create New User
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('user-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">#</th>
                                        <!-- <th scope="col">User ID</th> -->
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">User Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                    <tr>
                                        <td>
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
                                                <span class="custom-control-label"></span>
                                            </label>
                                        </td>
                                        <td>{!! ++$i !!}</td>
                                        <!-- <td>{!! $rows->uuid !!}</td> -->
                                        <td>{!! $rows->name !!}</td>
                                        <td>{!! $rows->email !!}</td>
                                        <td>{{ $rows->mobile }}</td>
                                        @if(empty($rows->role_id))
                                        <td>{{ @$rows->userType }}</td>
                                        @else
                                        <td>{{ @$rows->roles->first()->name }}</td>
                                        @endif
                                        <td class="text-center">
                                            <div class="btn-group btn-group-xs">
                                                @if($rows->status=='2') 
                                                <span class="text-danger">Inactive</span>
                                                @else 
                                                <span class="text-success">Active</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                        @if($rows->userType == 'user')
                                        @can('user-edit')
                                        <a class="btn btn-sm btn-secondary" href="{{ route('user-view',$rows->uuid) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endcan
                                        @else
                                        @can('user-edit')
                                        <a class="btn btn-sm btn-primary" href="{{ route('user-edit',$rows->uuid) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @endif
                                        @can('user-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('user-delete',$rows->uuid) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row div-margin">
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-hand-o-right"></i>
                            </span>
                            <select name="cmbaction" class="form-control" id="cmbaction">
                                <option value="">Action</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-6">
                        <div class="input-group">
                            <button type="submit" class="btn btn-danger pull-right" name="Action" onClick="return delrec(document.getElementById('cmbaction').value);">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
@endif

@endsection