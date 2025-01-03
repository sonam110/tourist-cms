@extends('admin.layouts.master')

@section('content')
@if(Request::segment(2) === 'edit-career' || Request::segment(2) === 'add-career')
    @php
        $id = '';
        $title = '';
        $subtitle = '';
        $location = '';
        $description = '';
        $salary = '';
        $status = '';

        if(Request::segment(2) === 'edit-career' && isset($career)) {
            $id = $career->id;
            $title = $career->title;
            $subtitle = $career->subtitle;
            $location = $career->location;
            $description = $career->description;
            $salary = $career->salary;
        }
    @endphp

    <form action="{{ route('career-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" class="form-control">

        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Request::segment(2) === 'add-career' ? 'Add' : 'Edit' }} Career
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Career Title" autocomplete="off" required>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle" class="form-label">Career Sub Title</label>
                                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $subtitle) }}" class="form-control @error('subtitle') is-invalid @enderror" placeholder="Career Sub Title" autocomplete="off">
                                    @error('subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="form-label">Career Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $location) }}" class="form-control @error('location') is-invalid @enderror" placeholder="Career Location" autocomplete="off">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="salary" class="form-label">Career Salary</label>
                                    <input type="text" name="salary" id="salary" value="{{ old('salary', $salary) }}" class="form-control @error('salary') is-invalid @enderror" placeholder="Career Salary" autocomplete="off">
                                    @error('salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Career description</label>
                                    <textarea name="description" id="description" class="form-control content @error('description') is-invalid @enderror" placeholder="Enter description" required>{{ old('description', $description) }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ $status == '2' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
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
                    <h3 class="card-title">career Management</h3>
                    <div class="card-options">
                        @can('career-add')
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('career-create') }}"> 
                            <i class="fa fa-plus"></i> Create New career
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('career-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Subtitle</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $rows)
                                    <tr>
                                        <td>
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="boxchecked[]" value="{{ $rows->id }}" class="colorinput-input custom-control-input">
                                                <span class="custom-control-label"></span>
                                            </label>
                                        </td>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $rows->title }}</td>
                                        <td>{{ $rows->subtitle }}</td>
                                        <td class="text-center">
                                            <span class="{{ $rows->status == '2' ? 'text-danger' : 'text-success' }}">
                                                {{ $rows->status == '2' ? 'Inactive' : 'Active' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-xs">
                                                @can('career-edit')
                                                <a class="btn btn-sm btn-info" href="{{ route('career-edit', $rows->id) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('career-delete')
                                                <a class="btn btn-sm btn-danger" href="{{ route('career-delete', $rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="Delete">
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
