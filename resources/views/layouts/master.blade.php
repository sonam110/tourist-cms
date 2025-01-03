<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
	@include('includes.head')
    <script type="text/javascript">
      var appurl = '{{url("/")}}/';
     
    </script>
    @yield('extracss')
</head>
<body class="app sidebar-mini rtl">
	<div id="global-loader" ></div>
	<div class="page">
		@include('includes.header')
		@include('includes.leftbar')
		<div class="app-content  my-3 my-md-5">
			<div class="side-app">
				@include('includes.message')
				@yield('content')
				
			</div>
		</div>
		@include('includes.footer')
	</div>
	<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
	@include('includes.footer_script')
	@notify_render
	@yield('extrajs')
	<script>
	//code to add to * to labels with required fields
	  document.addEventListener("DOMContentLoaded", function() {
	    // Select all required input, select, and textarea fields
	    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
	    
	    requiredFields.forEach(function(field) {
	      // Find the corresponding label
	      const label = document.querySelector(`label[for="${field.id}"]`);
	      
	      if (label) {
	        // Add an asterisk (*) to the label
	        label.innerHTML += ' <span style="color: green;">*</span>';
	      }
	    });
	  });
	</script>
	<script type="text/javascript">
		setIdleTimeout(<?= 1000*60*Auth::user()->locktimeout; ?>, function() {
		window.location.href = "{{ route('screenlock', [time(), Auth::user()->id, MD5(Str::random(10))]) }}";
		}, function() {});

		function setIdleTimeout(millis, onIdle, onUnidle) {
		    var timeout = 0;
		    $(startTimer);

		function startTimer() {
		    timeout = setTimeout(onExpires, millis);
		    $(document).on("mousemove keypress", onActivity);
		}

		function onExpires() {
		    timeout = 0;
		    onIdle();
		}

		function onActivity() {
		    if (timeout) clearTimeout(timeout);
		    else onUnidle();
		    $(document).off("mousemove keypress", onActivity);
		    setTimeout(startTimer, 1000);
		}
	}
	</script>
</body>
</html>