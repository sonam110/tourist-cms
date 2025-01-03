<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Seo -->
@if(@$pageinfo)

@php
$content = strip_tags($pageinfo['seo_description']);
$limit = 300; // Set the character limit
$seo_description = strlen($content) > $limit ? substr($content, 0, $limit) . '...' : $content;
@endphp

<title>{{$pageinfo['seo_title']}}</title>
<meta name="keywords" content="{{$pageinfo['seo_keyword']}}">
<meta name="description" content="{!! $seo_description !!}">
<meta property="og:title" content="{{$pageinfo['seo_title']}}" />
<meta property="og:description" content="{!! \Illuminate\Support\Str::words(strip_tags($pageinfo['seo_description']), 35,'....') !!}" />
<meta property="og:image" content="{{asset($pageinfo['seo_image'])}}" />
<!-- Facebook Meta Tags -->
<meta property="og:title" content="{{$pageinfo['seo_title']}}">
<meta property="og:description"
content="{!! \Illuminate\Support\Str::words(strip_tags($pageinfo['seo_description']), 35,'....') !!}">
<meta property="og:image" content="{{asset($pageinfo['seo_image'])}}">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="{{$pageinfo['seo_keyword']}}">
<meta name="twitter:title" content="{{$pageinfo['seo_title']}}">
<meta name="twitter:description"
content="{!! \Illuminate\Support\Str::words(strip_tags($pageinfo['seo_description']), 35,'....') !!}">
<meta name="twitter:image" content="{{asset($pageinfo['seo_image'])}}">
<!--  <meta name="twitter:site" content="@yourhandle">-->
@else
<title>{{ $appSetting->app_name }}</title>
<meta name="keywords" content="{{$appSetting->seo_keyword}}">
<meta name="description" content="{!! $appSetting->seo_description !!}">
<meta property="og:title" content="{{$appSetting->seo_keyword}}" />
<meta property="og:description" content="{!! \Illuminate\Support\Str::words(strip_tags($appSetting->seo_description), 35,'....') !!}" />
<meta property="og:image" content="{{asset($appSetting->app_logo)}}" />

<!-- Facebook Meta Tags -->
<meta property="og:title" content="{{$appSetting->app_name}}">
<meta property="og:description"
content="{!! $appSetting->seo_description !!}">
<meta property="og:image" content="{{asset($appSetting->app_logo)}}">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="{{$appSetting->seo_keyword}}">
<meta name="twitter:title" content="{{$appSetting->app_name}}">
<meta name="twitter:description"
content="{!! $appSetting->seo_description !!}">
<meta name="twitter:image" content="{{asset($appSetting->app_logo)}}">
<!--  <meta name="twitter:site" content="@yourhandle">-->
@endif

<meta property="og:url" content="{{url('/')}}">
<meta property="og:type" content="website">


<meta name="robots" content="index,follow" />
<meta property="og:site_name" content="{{ $appSetting->app_name }}" />


<!-- Google / Search Engine Tags -->
<meta itemprop="name" content="{{ $appSetting->app_name }}">
<meta itemprop="{!! $appSetting->seo_description !!}">
<meta itemprop="image" content="{{asset($appSetting->app_logo)}}">



<!-- Additional Tags -->
<link rel="icon" type="image/png" href="{{asset('/'.$appSetting->fav_icon)}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/apple-touch-icon.png')}}">

<meta name="author" content="Pakxaros">
<meta name="copyright" content="Copyright © Pakxaros">
<meta name="robots" content="index, follow">

<meta name="theme-color" content="#399f6e">

<meta name="keywords" content="{{$appSetting->seo_keyword}}">

<!-- CSS here -->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/fontawesome-6.3.0.min.css')}}">
<link rel="stylesheet" href="{{asset('css/keyframe-animation.min.css')}}">
<link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('css/meanmenu.min.css')}}">
<link rel="stylesheet" href="{{asset('css/daterangepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('css/odometer.min.css')}}">
<link rel="stylesheet" href="{{asset('css/venobox.min.css')}}">
<link rel="stylesheet" href="{{asset('css/swiper.min.css')}}">
<link rel="stylesheet" href="{{asset('css/nice-select.min.css')}}">
<link rel="stylesheet" href="{{asset('css/main.min.css')}}">
<link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
<link href="{{asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('css/flexslider.css')}}">
<link rel="stylesheet" href="{{asset('css/custom.css')}}">