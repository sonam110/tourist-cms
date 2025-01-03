@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-role' || Request::segment(2)==='add-role')
@if(Request::segment(2)==='add-role')
<?php
$id             = '';
$name           = '';
$permissions    = $permissions;
$rolePermissions = [];
?>
@else
<?php
$id             = $role->id;
$name           = $role->name;
$permissions    = $permissions;
$rolePermissions = $role->permissions->pluck('name')->toArray();
?>
@endif

<form action="{{ route('role-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2)==='add-role')
                        Add
                        @else
                        Edit
                        @endif
                        Role
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="Permission" class="form-label">Permissions</label>
                        <div class="row">
                            @foreach($permissions->groupBy('group_name') as $groupName => $groupPermissions)

                                <div class="col-12">

                                <hr>
                                    <h5>{{ ucfirst($groupName) }}</h5>
                                </div>
                                @foreach($groupPermissions as $permission)
                                <div class="col-xs-12 col-sm-6 col-md-3">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="colorinput-input custom-control-input" name="permission[]" value="{{ $permission->name }}" {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        <span class="custom-control-label">{{ $permission->name }}</span>
                                    </label>
                                </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-footer text-center">
                        <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@else
<!-- Existing roles table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Role Management</h3>
                <div class="card-options">
                    @can('role-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('role-create') }}">
                        <i class="fa fa-plus"></i> Create New Role
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Permissions</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($data as $rows)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rows->name }}</td>
                                <td>
                                    @foreach($rows->permissions as $permission)
                                        <span class="badge bg-default">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @can('role-edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('role-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('role-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('role-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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
                
            </div>
        </div>
    </div>
</div>
@endif

@endsection
