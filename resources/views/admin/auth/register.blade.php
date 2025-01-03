@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div class="col mx-auto">
         <div class="text-center mb-6">
            <img src="{{ url('/') }}/{{ $appSetting->app_logo }}" alt="{{ $appSetting->app_name }}" width="300px">
         </div>
         <div class="row justify-content-center">
            <div class="col-md-12">
               @include('admin.includes.message')
               @if ($message = Session::get('success'))
               <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                  <strong>Success!</strong> {{ $message }}
               </div>
               @endif
               <div class="card-group mb-0">
                  <div class="card p-4">
                     <form action="{{ route('signup-save') }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                           <h1>{{ __('Sign up') }}</h1>
                           <div class="row">
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="name" class="form-label">Name <span class="requiredLabel">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid state-invalid @enderror" placeholder="Name" autocomplete="off" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="email" class="form-label">Email Address <span class="requiredLabel">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid state-invalid @enderror" placeholder="Email Address" autocomplete="off" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="password" class="form-label">Password <span class="requiredLabel">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid state-invalid @enderror" placeholder="Password" autocomplete="off" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="confirm-password" class="form-label">Confirm Password <span class="requiredLabel">*</span></label>
                                    <input type="password" id="confirm-password" name="confirm-password" class="form-control @error('confirm-password') is-invalid state-invalid @enderror" placeholder="Confirm Password" autocomplete="off" required>
                                    @error('confirm-password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="mobile" class="form-label">Mobile <span class="requiredLabel">*</span></label>
                                    <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid state-invalid @enderror" placeholder="Mobile" autocomplete="off" required>
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="country" class="form-label">Country</label>
                                    <select name="country" class="form-control">
                                       @foreach($countries as $key => $value)
                                       <option value="{{ $key }}" {{ $key == '98' ? 'selected' : '' }}>{{ $value }}</option>
                                       @endforeach
                                    </select>
                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="city" class="form-label">City <span class="requiredLabel">*</span></label>
                                    <input type="text" id="city" name="city" class="form-control @error('city') is-invalid state-invalid @enderror" placeholder="City" autocomplete="off" required>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-3 col-sm-6">
                                 <div class="form-group">
                                    <label for="zipCode" class="form-label">Zipcode</label>
                                    <input type="number" id="zipCode" name="zipCode" class="form-control @error('zipCode') is-invalid state-invalid @enderror" placeholder="Zipcode" autocomplete="off">
                                    @error('zipCode')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-12 col-sm-12">
                                 <div class="form-group">
                                    <label for="address" class="form-label">Address <span class="requiredLabel">*</span></label>
                                    <input type="text" id="address" name="address" class="form-control @error('address') is-invalid state-invalid @enderror" placeholder="Address" autocomplete="off" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-12 col-sm-12">
                                 <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" required>
                                       <span class="custom-control-label">Agree the <a href="#" target="_blank">Terms and policy</a></span>
                                    </label>
                                 </div>
                              </div>
                             
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <button type="submit" class="btn btn-gradient-primary btn-block">{{ __('Sign up') }}</button>
                              </div>
                              <div class="col-6">
                                 <a href="{{ url('login') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Login') }}</a>
                              </div>
                              @if (Route::has('password.request'))
                              <div class="col-6 text-right">
                                 <a href="{{ route('password.request') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Forgot Your Password?') }}</a>
                              </div>
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
