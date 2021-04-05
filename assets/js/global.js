jQuery(document).ready(function( $ ) {

  // swal('nameProduct', "is added to wishlist !", "success");
  //Magic Popup
  

  // ===================================================================


  // Initiate the wowjs animation library
  new WOW().init();

  // ===================================================================
  /*==================================================================
    [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function () {
      $filter.on('click', 'button', function () {
        var filterValue = $(this).attr('data-filter');
        $topeContainer.isotope ({filter: filterValue});
      });
      
    });

    // init Isotope
    $(window).on('load', function () {
      var $grid = $topeContainer.each(function () {
        $(this).isotope({
          itemSelector: '.isotope-item',
          layoutMode: 'fitRows',
          percentPosition: true,
          animationEngine : 'best-available',
          masonry: {
            columnWidth: '.isotope-item'
          },
        });
      });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function(){
      $(this).on('click', function(){
        for(var i=0; i<isotopeButton.length; i++) {
          $(isotopeButton[i]).removeClass('how-active1');
        }

        $(this).addClass('how-active1');
      });
    });


  // Mobile Navigation
  if ($('#nav-menu-container').length) {
    var $mobile_nav = $('#nav-menu-container').clone().prop({
      id: 'mobile-nav'
    });
    $mobile_nav.find('> ul').attr({
      'class': '',
      'id': ''
    });
    $('body').append($mobile_nav);
    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

    $(document).on('click', '.menu-has-children i', function(e) {
      $(this).next().toggleClass('menu-item-active');
      $(this).nextAll('ul').eq(0).slideToggle();
      $(this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });
  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  // Smooth scroll for the menu and links with .scrollto classes
  $('.nav-menu a, #mobile-nav a, .scrollto').on('click', function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      if (target.length) {
        var top_space = 0;

        if ($('#header').length) {
          top_space = $('#header').outerHeight();

          if( ! $('#header').hasClass('header-fixed') ) {
            top_space = top_space - 20;
          }
        }

        $('html, body').animate({
          scrollTop: target.offset().top - top_space
        }, 1500, 'easeInOutExpo');

        if ($(this).parents('.nav-menu').length) {
          $('.nav-menu .menu-active').removeClass('menu-active');
          $(this).closest('li').addClass('menu-active');
        }

        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
        return false;
      }
    }
  });


  
  $("a[href='#!']").on('click', function (event) {
    event.preventDefault();
  });

  // Image select Script
  $('.image').click(function() {
    $(this).parent().find("[type='file']").click();
    $(this).parent().parent().find('.uploadMessage').html('Click to add image');
    $(this).attr('src', '../../assets/img/demoUpload.jpg');
  });

  function readURL(input, previewer) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        previewer.attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $(".img-select").change(function() {
    var previewer = $(this).parent().find('.image');
    readURL(this, previewer);
    $(this).parent().parent().find('.uploadMessage').html('Click again to change');
  });


  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "md-toast-bottom-left",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 2000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  // Material Select Initialization
  $('.mdb-select').material_select();

  // Chip (tag) Initialization
  $('.chips-placeholder').materialChip({
    placeholder: 'More tags',
    secondaryPlaceholder: 'Casual, Classic',
  });

});