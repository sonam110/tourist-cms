@extends('layouts.master-front')
@section('content')


<!-- <section class="page-header" data-background="{{asset($dynamicPage->banner_image_path)}}">
    <div class="container">

    </div>
</section> -->
<!-- ./ ads -->
@include('common.slider')
<!-- ./ page header -->
<section class="blog-page-header bg-grey" @if(!empty($dynamicPage->banner_image_path)) style="background: url('{{asset('/'.$dynamicPage->banner_image_path)}}'); background-position: center center;" @endif>
    <div class="container" @if(!empty($dynamicPage->banner_image_path)) style="background: rgb(255 255 255 / 85%)" @endif>
        <div class="header-content text-center">
            <h1 class="blog-page-title"><span>{{$dynamicPage->title}}</span></h1>
            <p>
                {{$dynamicPage->sub_title}}
            </p>
        </div>
    </div>
</section>
<!-- ./ blog-page-header -->

<section class="privacy-section padding">
    <div class="container">
        <div class="privacy-content-wrap">
            <div class="privacy-wrap">
                <div class="row">
                    {!! $dynamicPage->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection