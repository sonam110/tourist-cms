@extends('layouts.master-front')
@section('extracss')
<style type="text/css">
  .project-wrap {
    height: auto;
}
</style>
@endsection
@section('content')

@include('common.slider')

    <section class="blog-page-header bg-grey">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="blog-page-title">Activity  <span>Destinations</span></h1>
            </div>
        </div>
    </section>


    <!-- ./ blog-page-header -->

    <section class="blog-section blog-inner pt-15 p-0 bg-dark-deep">
        <div class="container">
            <div class="listing-top">
                <div class="listing-top-left d-none d-lg-block">
                    &nbsp;
                </div>
                <div class="listing-top-right">
                    <div class="right-item">
                        <input type="text" name="destination-filter" id="destination-filter" class="form-control w-100" placeholder="Search Destination...">
                    </div>
                </div>
            </div>
            <div class="row" id="results">
                @forelse($destinations as $destination)

                <div class="col-lg-4 col-md-6">
                  <div class="project-wrap wrap-1">
                    <div class="project-box">
                      <div class="project-thumb">
                        <a href="{{route('activities',['destination'=>$destination->name])}}" class="project-title"><img src="{{asset($destination->image_path)}}" alt="{{$destination->name}}"></a>
                        <div class="project-content">
                          <h4><a href="{{route('activities',['destination'=>$destination->name])}}" class="project-title destination-name">{{$destination->name}}</a>
                          </h4>
                          <span class="destination-icons"><i class="fa-regular fa-user"></i> &nbsp; {{@$destination->destination_type == '1' ? 'Domestic' : 'International'}} <span class="float destination-icons"><i class="fa-regular fa-tasks"></i> &nbsp;{{$destination->activities_count}}</span></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    @endsection

@section('extrajs')
<script>
$("#destination-filter").keyup(function() {

  // Retrieve the input field text and reset the count to zero
  var filter = $(this).val(),
    count = 0;

  // Loop through the comment list
  $('#results div').each(function() {


    // If the list item does not contain the text phrase fade it out
    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
      $(this).hide();  // MY CHANGE

      // Show the list item if the phrase matches and increase the count by 1
    } else {
      $(this).show(); // MY CHANGE
      count++;
    }

  });

});
</script>
@endsection
