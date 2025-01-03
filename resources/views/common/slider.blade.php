@section('extracss')
    <style>
        /*.page-header {
            height: 80px;
        }*/
    </style>
    @endsection
@if($appSetting->ads_enabled == 1)
    
    @if(!empty(@$_REQUEST['service']) && @$_REQUEST['service']=='ramta-yogi')
        @php
            $ads = App\Models\AdsManagement::where('page_name', 'service-ramta-yogi')->where('status', 1)->get();
        @endphp
    @elseif(!empty(@$_REQUEST['destination']) && @$_REQUEST['destination']=='domestic')
        @php
            $ads = App\Models\AdsManagement::where('page_name', 'service-domestic')->where('status', 1)->get();
        @endphp
    @elseif(!empty(@$_REQUEST['destination']) && @$_REQUEST['destination']=='international')
        @php
            $ads = App\Models\AdsManagement::where('page_name', 'service-international')->where('status', 1)->get();
        @endphp
    @else
    @php
        $pagename = Request::segment(1) ?? 'home'; // Default to 'home' if segment(1) is not found
        $ads = App\Models\AdsManagement::where('page_name', $pagename)->where('status', 1)->get();
    @endphp
    @endif
    
    @if(count($ads) > 0)
    <section class="padding-5x bg-grey">
        <div class="container">
            <div class="travel-carousel-wrap wow fade-in-bottom" data-wow-delay="1000ms">
                <div class="owl-carousel owl-theme">
                    @foreach($ads as $key => $ad)
                        <div class="item">
                            <a href="{{$ad->url_link}}" target="_blank">
                                <img class="slider-image-height" src="{{asset($ad->image_path)}}" alt="Ads">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @else
    <br><br>
    @endif
@endif
