<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
	@include('common.head')
	@yield('extracss')
	<script type="text/javascript">
		var appurl = '{{url("/")}}/';
	</script>
</head>
<body>
	@include('common.header')

	@yield('content')

	@include('common.footer')

	@include('common.footer_script')
	@yield('extrajs')
</body>
</html>