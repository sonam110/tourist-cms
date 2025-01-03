/***************************************************
 Main JS
 ****************************************************/

(function ($) {
  'use strict'

  var windowOn = $(window)
  var rtlMode = true
  ////////////////////////////////////////////////////
  // 01. PreLoader Js
  windowOn.on('load', function () {
    $('.preloader').fadeOut(500)
  })

  // RTL Switcher
  $('.switcher-input').on('click', function () {
    $(this).toggleClass('rtl-mode')
    $('body').toggleClass('rtl')
    // rtlMode = true;
  })

  // Copy Author Link
  $('.author-link').on('click', function () {
    var copyText = $(this).data('link'),
      textWrap = $(this).find('span')
    navigator.clipboard.writeText(copyText)
    textWrap.text('Link Copied')
  })

  var owl = $(".owl-carousel");
    owl.owlCarousel({
      items: 1,
      margin: 10,
      loop: true,
      nav: false,
      autoplay: true, 
      dots: true,
      autoplayHoverPause:true,
    });

    var owl = $(".owl-carousel-hero");
    owl.owlCarousel({
      items: 1,
      margin: 1,
      loop: true,
      nav: false,
      autoplay: true, 
      dots: false,
      autoplayHoverPause:false,
    });
    
    $('#carousel').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 210,
      itemMargin: 5,
      asNavFor: '#slider'
    });
   
    $('#slider').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      sync: "#carousel"
    });

  var headerArea = $('.sticky-active'),
    headerClone = headerArea.clone()

  function menuSticky (w) {
    if (w.matches) {
      $('.header').after('<div class="sticky-header-wrap"></div>')
      $('.sticky-header-wrap').html(headerClone)
      $(window).on('scroll', function () {
        var headerSelector = $('.sticky-header-wrap')
        var scroll = $(window).scrollTop()
        if (scroll >= 110) {
          headerSelector.addClass('fixed')
        } else {
          headerSelector.removeClass('fixed')
        }
      })
    }
  }
  
  // Venobox Video
  new VenoBox({
    selector: '.video-popup, .img-popup',
    bgcolor: 'transparent',
    numeration: true,
    infinigall: true,
    spinner: 'plane',
  })

  var minWidth = window.matchMedia('(min-width: 992px)')
  if ($('.header').hasClass('sticky-active')) {
    menuSticky(minWidth)
  } else {
    windowOn.on('scroll', function () {
      var scroll = $(window).scrollTop()
      if (scroll < 100) {
        $('.header').removeClass('header__sticky')
      } else {
        $('.header').addClass('header__sticky')
      }
    })
  }

  ////////////////////////////////////////////////////
  // 02. Mobile Menu Js
  $('.mobile-menu-items').meanmenu({
    meanMenuContainer: '.side-menu-wrap',
    meanScreenWidth: '991',
    meanMenuCloseSize: '30px',
    meanRemoveAttrs: true,
    meanExpand: ['<i class="fa-solid fa-caret-down"></i>'],
  })

  // Mobile Sidemenu
  $('.mobile-side-menu-toggle').on('click', function () {
    $('.mobile-side-menu, .mobile-side-menu-overlay').toggleClass('is-open')
  })

  $('.mobile-side-menu-close, .mobile-side-menu-overlay').on('click', function () {
    $('.mobile-side-menu, .mobile-side-menu-overlay').removeClass('is-open')
  })

  // Popup Search Box
  $(function () {
    $('#popup-search-box').removeClass('toggled')

    $('.dl-search-icon').on('click', function (e) {
      e.stopPropagation()
      $('#popup-search-box').toggleClass('toggled')
      $('#popup-search').focus()
    })

    $('#popup-search-box input').on('click', function (e) {
      e.stopPropagation()
    })

    $('#popup-search-box, body').on('click', function () {
      $('#popup-search-box').removeClass('toggled')
    })
  })

  // Multiple Radio Btn

  var checkboxes = $('.group input[type=\'checkbox\']')

  $(checkboxes).click(function () {
    var checkedcheckboxcount = $('.group input[type=\'checkbox\']:checked').size()
    if (checkedcheckboxcount < 1) {
      $(this).prop('checked', true)
    }
  })

  ////////////////////////////////////////////////////
  // Search Js
  $('.search-toggle').on('click', function () {
    $('.search__area').addClass('opened')
  })
  $('.search-close-btn').on('click', function () {
    $('.search__area').removeClass('opened')
  })

  ////////////////////////////////////////////////////
  // Sticky Header Js
  windowOn.on('scroll', function () {
    var scroll = $(window).scrollTop()
    if (scroll < 100) {
      $('#main-header').removeClass('header__sticky')
    } else {
      $('#main-header').addClass('header__sticky')
    }
  })

  // Data CSS Js
  $('[data-background').each(function () {
    $(this).css('background-image', 'url( ' + $(this).attr('data-background') + '  )')
  })

  $('[data-width]').each(function () {
    $(this).css('width', $(this).attr('data-width'))
  })

  $('[data-bg-color]').each(function () {
    $(this).css('background-color', $(this).attr('data-bg-color'))
  })

  // Nice Select Js
  $('.nice-select').niceSelect()

  // Odometer
  $('.odometer').waypoint(
    function () {
      var odo = $('.odometer')
      odo.each(function () {
        var countNumber = $(this).attr('data-count')
        $(this).html(countNumber)
      })
    },
    {
      offset: '80%',
      triggerOnce: true,
    }
  )

  // Side menu
  $('.side-menu-icon').on('click', function () {
    $('.side-menu-wrapper, .side-menu-overlay').toggleClass('is-open')
  })

  $('.side-menu-close, .side-menu-overlay').on('click', function () {
    $('.side-menu-wrapper, .side-menu-overlay').removeClass('is-open')
  })

  // Address Aditional Field

  var addressField = $('.booking-item.address').clone()
  $('.additional-address-field').on('click', function (e) {
    e.preventDefault()
    $(this).before(addressField)
    $(this).remove()
  })

  // Wow Js
  new WOW().init()

  //Event Carousel
  var swiperEvent = new Swiper('.event-carousel', {
    slidesPerView: '3',
    spaceBetween: 10,
    slidesPerGroup: 1,
    rtl: rtlMode,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.event-section .swiper-prev',
      prevEl: '.event-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
        autoplay: true,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 2,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Offer Carousel
  var swiperOffer = new Swiper('.offer-carousel', {
    slidesPerView: '4',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.offer-section .swiper-prev',
      prevEl: '.offer-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 2,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 4,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

    //Travel Carousel
  var swiperTravels = new Swiper('.travel-carousels', {
    slidesPerView: '3',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.travel-section .swiper-prev',
      prevEl: '.travel-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 2,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Travel Carousel
  var swiperTravel = new Swiper('.travel-carousel', {
    slidesPerView: '4',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.travel-section .swiper-prev',
      prevEl: '.travel-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 2,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 4,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Testimonial Carousel
  var swiperTesti = new Swiper('.testimonial-carousel', {
    slidesPerView: '1',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.testimonial-section .swiper-prev',
      prevEl: '.testimonial-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Event Listing Carousel
  const sliderSpeeds = [700, 1200, 900, 1500, 600, 1000, 800, 1100]

  $('.event-listing-carousel').each((index, slide) => {
    new Swiper(slide, eventListCarouselConfig(sliderSpeeds[index] || 2000))
  })

  function eventListCarouselConfig (speed = 700) {
    return {
      slidesPerView: '1',
      spaceBetween: 10,
      slidesPerGroup: 1,
      initialSlide: 1050,
      loop: true,
      speed: speed,
      autoplay: {
        delay: speed * 5,
        disableOnInteraction: false,
      },
      grabCursor: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    }
  }

  //Event Details Carousel
  var swiperDetails = new Swiper('.event-details-carousel', {
    slidesPerView: '1',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: {
      enabled: true,
      delay: 2500,
    },
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.event-details .swiper-prev',
      prevEl: '.event-details .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 3,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Project Carousel
  var swiperProject = new Swiper('.project-carousel', {
    slidesPerView: '1',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.project-section .swiper-prev',
      prevEl: '.project-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Project Single Carousel
  var swiperProject = new Swiper('.project-single-carousel', {
    slidesPerView: '1',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.project-section .swiper-prev',
      prevEl: '.project-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 20,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 30,
      },
    },
  })

  //Sign in Carousel
  var swiperSign = new Swiper('.signin-carousel', {
    slidesPerView: '1',
    spaceBetween: 10,
    slidesPerGroup: 1,
    loop: true,
    speed: 700,
    autoplay: true,
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.project-section .swiper-prev',
      prevEl: '.project-section .swiper-next',
    },
    breakpoints: {
      // when window width is >= 320px
      320: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 10,
      },
      // when window width is >= 767px
      767: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 10,
      },
      // when window width is >= 1024px
      992: {
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 10,
      },
    },
  })

  // RTL Switcher
  const toggleLabel = (el) => {
    const { id, value } = el
    const label = document.querySelector(`label[for="${id}"]`)
    const labelHasFocusClass = label.classList.contains('focus-label')
    const inputHasValue = value.length > 0
    if (!inputHasValue) {
      el.classList.remove('input-complete')
      label.classList.remove('focus-label')
      return
    }
    if (labelHasFocusClass) {
      return
    }
    label.classList.add('focus-label')
    el.classList.add('input-complete')
  }

  // Input Counter
  $(document).ready(function () {
    $('.minus').click(function () {
      var $input = $(this).parent().find('input')
      var count = parseInt($input.val()) - 1
      count = count < 1 ? 1 : count
      $input.val(count)
      $input.change()
      return false
    })
    $('.plus').click(function () {
      var $input = $(this).parent().find('input')
      $input.val(parseInt($input.val()) + 1)
      $input.change()
      return false
    })
  })

  // Date Range Picker
  $(function () {
    $('input[name="daterange"]').daterangepicker(
      {
        opens: 'center',
      },
      function (start, end, label) {
        console.log(
          'A new date selection was made: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD')
        )
      }
    )
  })

  $(function () {
    $('input[name="birthday"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
    })
  })

  // Price range slider
  var priceRange = $('#price-range'),
    priceOutput = $('#price-output span')
  priceOutput.html(priceRange.val())
  priceRange.on('change input', function () {
    priceOutput.html($(this).val())
  })

  

  ////////////////////////////////////////////////////
  // 23. InHover Active Js
  $('.hover__active').on('mouseenter', function () {
    $(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active')
  })

  

})(jQuery)
