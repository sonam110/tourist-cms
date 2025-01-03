@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-genres' || Request::segment(2)==='add-genres')
@if(Request::segment(2)==='add-genres')
<?php
$id                  = '';
$name                = '';
$required            = 'required';
?>
@else
<?php
$id               = $genres->id;
$name             = $genres->name;
$required         = '';
?>
@endif


{{ Form::open(array('route' => 'genres-save', 'class'=> 'form-horizontal','enctype'=>'multipart/form-data', 'files'=>true)) }}
{!! Form::hidden('id',$id,array('class'=>'form-control')) !!}
@csrf
<div class="row row-deck">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(Request::segment(2)==='add-genres')
                    Add
                    @else
                    Edit
                    @endif
                    Genres
                </h3>
                <div class="card-options">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Genres Name <span class="requiredLabel">*</span></label>
                            {!! Form::text('name',$name, array('id'=>'name','class'=> $errors->has('name') ? 'form-control is-invalid state-invalid' : 'form-control', 'placeholder'=>'Genres Name', 'autocomplete'=>'off',$required)) !!}
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
               <div class="form-footer">
               {!! Form::submit('Save', array('class'=>'btn btn-primary btn-fixed')) !!}
            </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

@else
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title ">Genres Management</h3>
                <div class="card-options">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('genres-add') }}"> <i class="fa fa-plus"></i> Add New Genres</a>
                    &nbsp;&nbsp;&nbsp;<a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary"  data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>

                                <th scope="col" width="5%">#</th>
                                <th scope="col">Genres Name</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($genrestList as $rows)
                            <tr>
                                <td>{!! ++$i !!}</td>
                                <td>{!! $rows->name !!}</td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a class="btn btn-sm btn-primary" href="{{ route('genres-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger" href="{{ route('genres-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif

@endsection