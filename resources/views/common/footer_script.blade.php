
<script src="{{asset('js/jquary-3.6.0.min.js')}}"></script>
<script src="{{asset('js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<script src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('js/jquery.ajaxchimp.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/jquery.isotope.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/daterangepicker.min.js')}}"></script>
<script src="{{asset('js/waypoints.min.js')}}"></script>
<script src="{{asset('js/meanmenu.js')}}"></script>
<script src="{{asset('js/smooth-scroll.js')}}"></script>
<script src="{{asset('js/nice-select.js')}}"></script>
<script src="{{asset('js/odometer.min.js')}}"></script>
<script src="{{asset('js/venobox.min.js')}}"></script>
<script src="{{asset('js/swiper.min.js')}}"></script>
<script src="{{asset('js/wow.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('js/jquery.flexslider.js')}}"></script>

<script src="{{asset('js/main.js')}}"></script>
<script>
  $(document).ready(function() {
    $('img').on('error', function() {
      // Check if the fallback image is already applied to prevent an endless loop
      if ($(this).attr('src') !== '/assets/img/noimage.jpg') {
        $(this).attr('src', '/assets/img/noimage.jpg');
      }
    });
  });
</script>
<script type="text/javascript">
  var headerContainer = $('.header-container');
var topPanel = headerContainer.find('#top-panel');
var searchHolder = headerContainer.find('.search-holder');
var searchForm = headerContainer.find('#search-form');
var openToggle = headerContainer.find('#form-open');
var closeToggle = searchForm.find('#form-close');

function calculateAnimationProps () {
  var vpWidth = $(window).outerWidth(true);
  var width = 0;
  
  if (vpWidth < 1000) {
    width = headerContainer.outerWidth(true) - 40; // Minus container side padding
  } else {
    width = topPanel.outerWidth(true);
  }
  
  var right = width - openToggle.outerWidth(true);
  
  return {
    formWidth: width,
    formRight: right,
    toggleRight: right / 2
  };
}

$(document).ready(function() {
  // Show search form
  openToggle.on('click', function() {
    var animProps = calculateAnimationProps();

    searchHolder.show().css({
      width: animProps.formWidth,
      //height: headerContainer.outerHeight(true)
    });
    
    searchForm.css({
      width: animProps.formWidth,
      right: -(animProps.formRight),
      transform: 'translatex(-' + animProps.formRight + 'px)'
    }).addClass('active');
    
    $(this).css({
      right: animProps.toggleRight,
      transform: 'translatex(-' + animProps.toggleRight + 'px)'
    }).addClass('hidden');
  });

  // Hide search form
  closeToggle.on('click', function() {
    searchForm.css('transform', '')
      .removeClass('active');
    
    // Let the animation finished first then hide the holder
    setTimeout(function () {
      searchHolder.hide();
    }, 500);
    
    openToggle.removeAttr('style')
      .removeClass('hidden');
  });
  
});
</script>