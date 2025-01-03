@extends('admin.layouts.app')
@section('content')
<div class="container">
        <div class="row">

            <div class="col mx-auto">
                <div class="text-center mb-6">
                    <img src="{{url('/')}}/{{$appSetting->app_logo}}" class="front_logo"  alt="{{$appSetting->app_name}}">
                </div>
                <div class="row justify-content-center">

                    <div class="col-md-8">
                           @include('admin.includes.message')
                        <div class="card-group mb-0">
                            <div class="card p-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="card-body">
                                        <h1>{{ __('Login') }}</h1>
                                        <p class="text-muted">Sign In to your account</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid state-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address OR Username">

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid state-invalid' : '' }}" name="password" required placeholder="Password">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                                                    <span class="custom-control-label">{{ __('Remember Me') }}</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-gradient-primary btn-block">{{ __('Login') }}</button>
                                            </div>
                                            <!-- <div class="col-6">
                                                <a href="{{ route('sign-up') }}" class="btn btn-link box-shadow-0 px-0">Sign up</a>
                                            </div> -->
                                            @if (Route::has('password.request'))
                                            <div class="col-6">
                                                <a href="{{ route('password.request') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Forgot Your Password?') }}</a>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </form>
                                <!-- <a href="{{ url('login/google') }}" class="btn btn-primary">Login with Google</a>
                                <a href="{{ url('login/facebook') }}" class="btn btn-primary">Login with Facebook</a> -->
                            </div>
                            <div class="card text-white bg-primary py-5 d-md-down-none login-transparent">
                                <div class="card-body text-center justify-content-center ">
                                    <h2>About</h2>
                                    <p>
                                        <strong>
                                            {!! $appSetting->description !!}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
