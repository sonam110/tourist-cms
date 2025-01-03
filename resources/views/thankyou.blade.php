@extends('layouts.master-front')
@section('content')

<section class="blog-page-header bg-grey">
  <div class="container">
    <div class="header-content text-center">
      <h1 class="blog-page-title">Thank <span>You</span></h1>
      <p>
        <!-- We deliver top-tier, responsive software solutions optimized for mobile devices, using the latest technology to
        enhance user experiences and meet modern digital demands. --> 
    </p>
    </div>
    <div class="col-lg-12">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
  </div>
</section>
@endsection
@section('extrajs')
<script type="text/javascript">
	window.setTimeout(function() {
    window.location.href = '/';
}, 5000);

</script>
@endsection