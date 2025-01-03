@extends('layouts.app')
@section('content')
<style type="text/css">
#clockbox {
  text-align: center;
  color: #ffffff;
  font-size: 40px;
  margin-top: 20%;
}
#clockboxd {
  text-align: center;
  color: #ffffff;
  font-size: 18px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-6">
                <img src="{{url('/')}}/{{$appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}">
                
            </div>
            <div class="card-group mb-0">
                <div class="card p-4">
                    @php
                        $user = App\Models\User::select('id','name','email')->find($id);
                    @endphp
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                        <input type="hidden" name="email" class="form-control" id="email" value="{{ $user->email }}">
                    
                        <div class="card-body">
                            <div class="text-center mb-4 ">
                                <span><img src="{{url('/assets/uploads')}}/{{$appSetting->app_logo}}" class="avatar avatar-xxl brround"></span>
                            </div>
                            <span class="m-4 d-none d-lg-block text-center">
                                <span class=""><strong>{{ $user->name }}</strong></span>
                            </span>
                            <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                    <input id="password" type="password" class="form-control{{ $errors->has('email') ? ' is-invalid state-invalid' : '' }}" name="password" required placeholder="Password">

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    
                                </div>
                            <button type="submit" class="btn btn-gradient-primary btn-block" name="unlock">Unlock</button>
                        </div>
                    </form>
                </div>
                <div class="card text-white bg-primary py-5 d-md-down-none login-transparent">
                    <div class="card-body text-center align-items-center">
                        <div>
                            <h2>{{$appSetting->app_name}}</h2>
                            <div id="clockbox"></div>
                            <div id="clockboxd"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extrajs')
<script src="{{asset('assets/js/lockscreen.js')}}"></script>
@endsection
