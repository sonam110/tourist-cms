@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-package-type' || Request::segment(2) === 'add-package-type')
@if(Request::segment(2) === 'add-package-type')
<?php
$id           = '';
$package_type       = '';
?>
@else
<?php
$id           = $packageType->id;
$package_type       = $packageType->package_type;
?>
@endif

<form action="{{ route('package-type-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(Request::segment(2) === 'add-package-type')
                        Add
                        @else
                        Edit
                        @endif
                        Package Type
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Package Type -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="package_type" class="form-label">Package Type</label>
                                <input type="text" name="package_type" id="package_type" value="{{ $package_type }}" class="form-control @error('package_type') is-invalid @enderror" placeholder="Package Type" autocomplete="off" required>
                                @error('package_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                            </div>
                        </div>
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
            <div class="card-header ">
                <h3 class="card-title">Package Type Management</h3>
                <div class="card-options">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('package-type-create') }}"> 
                        <i class="fa fa-plus"></i> Create New Package Type
                    </a>
                    &nbsp;&nbsp;&nbsp;
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
                                    <th scope="col">Package Type</th>
                                    <th scope="col" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0 @endphp
                                @foreach($data as $rows)
                                <tr>
                                    <td>{!! ++$i !!}</td>
                                    <td>{!! $rows->package_type !!}</td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <a class="btn btn-sm btn-info" href="{{ route('package-type-edit',$rows->id) }}"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger" href="{{ route('package-type-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
</div>
@endif
<script>
    function readVideoURL(input, thumbId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var video = document.getElementById(thumbId);
                video.src = e.target.result;
                video.load();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
