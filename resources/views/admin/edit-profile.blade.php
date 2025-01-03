@extends('admin.layouts.master')
@section('extracss')
<link rel="stylesheet" href="{{ asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') }}">
@endsection
@section('content')

<div class="row row-deck">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('change-password') }}" class="form-horizontal">
                    @csrf
                    <div class="row mb-2">
                        <!-- <div class="col-auto">
                            <span class="avatar brround avatar-xl cover-image" data-image-src="{{ url('/') }}/{{ $user->profile_image }}"></span>
                        </div> -->
                        <div class="col">
                            <h3 class="mb-1 ">{{ $user->name }}</h3>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email-Address</label>
                        <input type="text" id="email" name="email" class="form-control @error('email') is-invalid state-invalid @enderror" placeholder="Email-Address" value="{{ $user->email }}" autocomplete="off" required readonly>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input type="password" id="old_password" name="old_password" class="form-control @error('old_password') is-invalid state-invalid @enderror" placeholder="Old Password" autocomplete="off" required>
                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid state-invalid @enderror" placeholder="New Password" autocomplete="off" required>
                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid state-invalid @enderror" placeholder="Confirm Password" autocomplete="off" required>
                        @error('new_password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <form method="POST" action="{{ route('update-profile') }}" class="card" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
                <div class="card-options">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-8 col-md-8">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid state-invalid @enderror" placeholder="Name" value="{{ $user->name }}" autocomplete="off" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="number" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid state-invalid @enderror" placeholder="Mobile" value="{{ $user->mobile }}" autocomplete="off" required>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="locktimeout" class="form-label">App Auto Lock Time</label>
                            <input type="number" id="locktimeout" name="locktimeout" class="form-control @error('locktimeout') is-invalid state-invalid @enderror" placeholder="10" value="{{ $user->locktimeout }}" autocomplete="off" min="10">
                            @error('locktimeout')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 147px;">
                                    <img id="imageThumb" src="{{ url('/') }}/{!! $user->profile_image !!}"> 
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 147px; line-height: 20px;"></div>
                            </div>
                            <div>
                                <span class="btn btn-outline-primary btn-file" style="width: 100%;">
                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                    <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="readURL(this,'imageThumb')">
                                </span> 
                            </div>
                            @if ($errors->has('profile_image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('profile_image') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    

                    <div class="form-group col-sm-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea type="text" id="address" name="address" class="{{ $errors->has('address') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Address" autocomplete="off">{{ $user->address }}</textarea>
                        @if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('extracss')
@endsection
