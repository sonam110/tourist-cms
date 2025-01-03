@extends('admin.layouts.master')

@section('content')
@if(Request::segment(2) === 'edit-permission' || Request::segment(2) === 'add-permission')
    @php
        $id = '';
        $name = '';
        $group_name = '';
        $belongs_to = '';

        if(Request::segment(2) === 'edit-permission' && isset($permission)) {
            $id = $permission->id;
            $name = $permission->name;
            $group_name = $permission->group_name;
            $belongs_to = $permission->belongs_to;
        }
    @endphp

    <form action="{{ route('permission-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" class="form-control">

        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Request::segment(2) === 'add-permission' ? 'Add' : 'Edit' }} Permission
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Group Name -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="group_name" class="form-label">Group Name</label>
                                    <input type="text" name="group_name" id="group_name" value="{{ old('group_name', $group_name) }}" class="form-control @error('group_name') is-invalid @enderror" placeholder="Group Name" autocomplete="off" required>
                                    @error('group_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="belongs_to" class="form-label">Status</label>
                                    <select name="belongs_to" id="belongs_to" class="form-control @error('belongs_to') is-invalid @enderror">
                                        <option value="1" {{ $belongs_to == '1' ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ $belongs_to == '2' ? 'selected' : '' }}>User</option>
                                        <option value="3" {{ $belongs_to == '3' ? 'selected' : '' }}>Both(Admin & User)</option>
                                    </select>
                                    @error('belongs_to')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Management</h3>
                    <div class="card-options">
                        @can('permission-add')
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('permission-create') }}"> 
                            <i class="fa fa-plus"></i> Create New Permission
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go Back">
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
                                        <th scope="col">Group Name</th>
                                        <th scope="col">Belong To</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0 @endphp
                                    @foreach($data as $rows)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $rows->name }}</td>
                                        <td>{{ $rows->group_name }}</td>
                                        <td class="text-center">
                                            @if($rows->belongs_to == 1)
                                            <span class="text-success">
                                                Admin
                                            </span>
                                            @elseif($rows->belongs_to == 2)
                                            <span class="text-danger">
                                                User
                                            </span>
                                            @elseif($rows->belongs_to == 3)
                                            <span class="text-info">
                                                Both(Admin & User)
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                                @can('permission-edit')
                                                <a class="btn btn-sm btn-info" href="{{ route('permission-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('permission-edit')
                                                <a class="btn btn-sm btn-danger" href="{{ route('permission-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
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
