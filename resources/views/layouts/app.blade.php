<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    @include('includes.head')
    <script type="text/javascript">
      var appurl = '{{url("/")}}/';
    </script>
</head>
<body class="login-img">
    <div class="page">
        <div class="page-single">
            @yield('content')
        </div>
    </div>
<script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/vendors/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@yield('extrajs')
</body>
</html>
