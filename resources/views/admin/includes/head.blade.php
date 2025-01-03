<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="_token" content="{{ csrf_token() }}">
<meta name="msapplication-TileColor" content="#ff685c">
<meta name="theme-color" content="#32cafe">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<link rel="icon" href="{{url('/')}}/{{$appSetting->fav_icon}}" type="image/x-icon"/>
<link rel="shortcut icon" type="image/x-icon" href="{{url('/')}}/{{$appSetting->fav_icon}}" />

<title>{{$appSetting->app_name}}</title>
<link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/fonts/fonts/font-awesome.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/toggle-sidebar/sidemenu.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/iconfonts/plugin.css')}}" />
<link rel="stylesheet" href="{{asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />

<!-- select2 Plugin -->
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- WYSIWYG Editor css -->
		<link href="{{asset('assets/plugins/wysiwyag/richtext.css')}}" rel="stylesheet" />

<link rel="stylesheet" href="{{asset('assets/js/bootstrap-fileupload/bootstrap-fileupload.css') }}">

<style type="text/css">
	/* Add this to your custom CSS file */
	.select2-container--default .select2-selection--multiple {
		background-color: white; /* Match your form's background */
		border: 1px solid black;    /* Match your form's border */
		border-radius: 4px; 
		height: 40px;       /* Match your form's border-radius */
		color: black;

	}

</style>

