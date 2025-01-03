@extends('admin.layouts.master')
@section('content')

@if(Request::segment(2) === 'edit-email-template' || Request::segment(2) === 'add-email-template')
    @php
        $id = $emailTemplate->id ?? '';
        $language_id = $emailTemplate->language_id ?? '';
        $template_for = $emailTemplate->template_for ?? '';
        $mail_subject = $emailTemplate->mail_subject ?? '';
        $mail_body = $emailTemplate->mail_body ?? '';
        $image_path = $emailTemplate->image_path ?? 'assets/img/noimage.jpg';
        $status = $emailTemplate->status ?? '';
    @endphp

    <form action="{{ route('email-template-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}" class="form-control">

        <div class="row row-deck">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ Request::segment(2) === 'add-email-template' ? 'Add' : 'Edit' }} Email Template
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Template For -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="template_for" class="form-label">Template For</label>
                                    <input type="text" name="template_for" id="template_for" value="{{ old('template_for', $template_for) }}" class="form-control @error('template_for') is-invalid @enderror" placeholder="Template For" autocomplete="off" required>
                                    @error('template_for')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Mail Subject -->
                                    <div class="form-group">
                                        <label for="mail_subject" class="form-label">Mail Subject</label>
                                        <input type="text" name="mail_subject" id="mail_subject" value="{{ old('mail_subject', $mail_subject) }}" class="form-control @error('mail_subject') is-invalid @enderror" placeholder="Mail Subject" autocomplete="off" required>
                                        @error('mail_subject')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <!-- Language -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="language_id" class="form-label">Language</label>
                                                <select name="language_id" id="language_id" class="form-control @error('language_id') is-invalid @enderror" required>
                                                    <option value="">Select Language</option>
                                                    @foreach(App\Models\Language::all() as $lang)
                                                        <option value="{{ $lang->id }}" {{ old('language_id', $language_id) == $lang->id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('language_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                                    <option value="1" {{ old('status', $status) == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="2" {{ old('status', $status) == 2 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- Image -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image_path" class="form-label">Image</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 100%; height: 157px;">
                                            <img id="imageThumb" src="{{ $image_path ? url($image_path) : '' }}" alt="Image">
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 157px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-outline-primary btn-file" style="width: 100%;">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                                <input type="file" name="image_path" id="image_path" accept="image/*" onchange="readURL(this,'imageThumb')" class="@error('image_path') is-invalid @enderror">
                                            </span>
                                        </div>
                                        @error('image_path')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Mail Body -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mail_body" class="form-label">Mail Body</label>
                                    <textarea name="mail_body" id="mail_body" class="form-control content @error('mail_body') is-invalid @enderror" placeholder="Mail Body" rows="10" required>{{ old('mail_body', $mail_body) }}</textarea>
                                    @error('mail_body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            
                            

                            <!-- Submit -->
                            <div class="col-md-12">
                                <div class="form-footer text-center">
                                    <button type="submit" class="btn btn-primary btn-fixed">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@elseif(Request::segment(2) === 'view-email-template')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Email Template Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h5><strong>Template For:</strong></h5>
                            <p>{{ $emailTemplate->template_for }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5><strong>Language:</strong></h5>
                            <span>
                                {{ $emailTemplate->language->name }}
                            </span>
                        </div>
                        <div class="col-md-4">
                            <h5><strong>Status:</strong></h5>
                            <span class="badge {{ $emailTemplate->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $emailTemplate->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5><strong>Mail Subject:</strong></h5>
                            <p>{!! $emailTemplate->mail_subject !!}</p>
                            <h5><strong>Mail Body:</strong></h5>
                            <p>{!! $emailTemplate->mail_body !!}</p>
                        </div>
                        <div class="col-md-4">
                            <h5><strong>Image:</strong></h5>
                            @if($emailTemplate->image_path)
                                <img src="{{ asset($emailTemplate->image_path) }}" alt="Image" class="img-fluid rounded shadow-sm">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title">Email Template Management</h3>
                    <div class="card-options">
                        @can('email-template-add')
                       <!--  <a class="btn btn-sm btn-outline-primary" href="{{ route('email-template-create') }}">
                            <i class="fa fa-plus"></i> Create New Email Template
                        </a> -->
                        &nbsp;&nbsp;&nbsp;
                        @endcan
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Go To Back">
                            <i class="fa fa-mail-reply"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('email-template-action') }}" method="POST" class="form-horizontal" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">#</th>
                                    <th scope="col">Template For</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Body</th>
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
                                    <td>{!! $rows->template_for !!}</td>
                                    <td>{!! $rows->mail_subject !!}</td>
                                    <td>{!! $rows->mail_body !!}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            @if($rows->status == '2') 
                                            <span class="text-danger">Inactive</span>
                                            @else 
                                            <span class="text-success">Active</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            @can('email-template-read')
                                            <a class="btn btn-sm btn-secondary" href="{{ route('email-template-view',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('email-template-edit')
                                           <!--  <a class="btn btn-sm btn-info" href="{{ route('email-template-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a> -->
                                            @endcan
                                            @can('email-template-delete')
                                            <!-- <a class="btn btn-sm btn-danger" href="{{ route('email-template-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a> -->
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
                                    <option value="Delete">Delete</option>
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
