@extends('admin.layouts.master')
@section('content')
@if(Request::segment(2)==='edit-faq' || Request::segment(2)==='add-faq')
@if(Request::segment(2)==='add-faq')
<?php
$id             = '';
$question           = '';
$answer  = '';
$status         = '';
$language_id         = '';
?>
@else
<?php
$id             = $faq->id;
$question           = $faq->question;
$answer        = $faq->answer;
$language_id        = $faq->language_id;
?>
@endif

<form action="{{ route('faq-save') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}" class="form-control">

    <div class="row row-deck">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-question">
                        @if(Request::segment(2)==='add-faq')
                            Add
                        @else
                            Edit
                        @endif
                        FAQ
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">

                        <!-- Question -->
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" name="question" id="question" value="{{ $question }}" class="form-control @error('question') is-invalid @enderror" placeholder="Question" autocomplete="off" required>
                                @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="language_id" class="form-label">Language</label>
                                <select name="language_id" id="language_id" class="form-control" required>
                                    <option value="">Select Language</option>
                                    @foreach(App\Models\Language::all() as $lang)
                                        <option value="{{ $lang->id }}" {{ $lang->id == $language_id ? 'selected' : '' }}>{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Answer -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="answer" class="form-label">Answer</label>
                                <textarea name="answer" id="answer" class="form-control @error('answer') is-invalid @enderror" rows="6" placeholder="Answer" required>{{ $answer }}</textarea>
                                @error('answer')
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
            <div class="card-header ">
                <h3 class="card-question">FAQ Management</h3>
                <div class="card-options">
                    @can('faq-add')
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('faq-create') }}"> 
                        <i class="fa fa-plus"></i> Create New FAQ
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    @endcan
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" question="" data-original-question="Go To Back">
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
                                <th scope="col">Language</th>
                                <th scope="col">Question</th>
                                <th scope="col">Answer</th>
                                <th scope="col" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 0 @endphp
                            @foreach($data as $rows)
                            <tr>
                                <td>{!! ++$i !!}</td>
                                <td>{!! @$rows->language->name !!}</td>
                                <td>{!! $rows->question !!}</td>
                                <td>{!! $rows->answer !!}</td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        @can('faq-edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('faq-edit',$rows->id) }}" data-toggle="tooltip" data-placement="top" question="" data-original-question="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('faq-delete')
                                        <a class="btn btn-sm btn-danger" href="{{ route('faq-delete',$rows->id) }}" onClick="return confirm('Are you sure you want to delete this?');" data-toggle="tooltip" data-placement="top" question="" data-original-question="Delete">
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