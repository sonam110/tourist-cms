@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-menu' || Request::segment(2)==='add-menu')
@if(Request::segment(2)==='add-menu')
<?php
$id             = '';
$name           = '';
$parent_id      = '';
$order_number   = '';
$position_type  = '';
$status         = '';
$icon_path      = '';
?>
@else
<?php
$id             = $menu->id;
$name           = $menu->name;
$parent_id      = $menu->parent_id;
$order_number        = $menu->order_number;
$position_type        = $menu->position_type;
$status           = $menu->status;
$icon_path        = $menu->icon_path;
?>
@endif

<form action="{{ route('menu-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2)==='add-menu')
                        Add
                        @else
                        Edit
                        @endif
                        Menu
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Position Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position_type" class="form-label">Position Type</label>
                                <input type="text" name="position_type" id="position_type" value="{{ $position_type }}" class="form-control @error('position_type') is-invalid @enderror" placeholder="Position Type" autocomplete="off" required>
                                @error('position_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Order Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order_number" class="form-label">Order Number</label>
                                <input type="text" name="order_number" id="order_number" value="{{ $order_number }}" class="form-control @error('order_number') is-invalid @enderror" placeholder="Order Number" autocomplete="off">
                                @error('order_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Parent Menu -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="parent_id" class="form-label">Parent Menu</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    @foreach($menus as $key => $value)
                                    <option value="{{ $key }}" {{ $menu->id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
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

@elseif(Request::segment(2)==='view-menu')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Menus</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Name</th>
                            <th>slug</th>
                            <th>order number</th>
                            <th>position type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td><span class="text-muted">{{ $row->id }}</span></td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->slug }}</td>
                            <td>{{ $row->order_number }}</td>
                            <td>{{ $row->position_type }}</td>
                            <td>{{ $row->status }}</td>
                            <td>
                                <a href="{{ url('edit-menu/'.$row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ url('delete-menu/'.$row->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this menu?');">Delete</a>
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
            <h3 class="card-title">Menu Management</h3>
            <div class="card-options">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('menu-create') }}"> 
                    <i class="fa fa-plus"></i> Create New Menu
                </a>
                &nbsp;&nbsp;&nbsp;
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                    <i class="fa fa-mail-reply"></i>
                </a>
            </div>
        </div>
        <form action="{{ route('menu-action') }}" method="POST" class="form-horizontal" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
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
                                <td>{!! $rows->name !!}</td>
                                <td>{!! $rows->slug !!}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        @if($rows->status=='0') 
                                        <span class="text-danger">Inactive</span>
                                        @else 
                                        <span class="text-success">Active</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a class="btn btn-sm btn-secondary" href="{{ route('menu-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('menu-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger" href="{{ route('menu-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
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