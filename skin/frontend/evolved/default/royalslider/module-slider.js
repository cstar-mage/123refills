define(['jquery', 'royalslider', 'rs.visible-nearby', 'rs.global-caption', 'rs.tabs', 'rs.active-class', 'rs.autoplay', 'jquery.countdown'], function($) {

  $(function () { // Start doc ready

    console.log('module-slider.js LOADED ');


// $('#mainHomeSlider').slideDown(500, function() {

// });
$('.home__slider-wrap').fadeIn(2000);




    // Slider one homepage -----
    $("#mainHomeSlider").royalSlider({
      addActiveClass: true,
      transitionSpeed: 500,
      arrowsNav: true,
      loop: true,
      // imgWidth: true,
      loopRewind: true,
      fadeinLoadedSlide: false,
      globalCaption: true,
      arrowsNavAutoHide: false,
      navigateByClick: false,
      slidesSpacing: 0,
      imageScalePadding: 0,
      imageScaleMode: 'fill',
      autoScaleSliderWidth: 960,
      autoScaleSliderHeight: 400,
      controlNavigation: 'tabs',
      navigateByCenterClick: false,
      autoScaleSlider: true,
      autoPlay: {
        enabled: true,
        pauseOnHover: true,
        delay: 250
      },
      thumbs: {
        spacing: 10,
        arrowsAutoHide: false
      },
    });

    $(".slider-category-list").royalSlider({
      transitionSpeed: 500,
      addActiveClass: true,
      arrowsNav: true,
      loop: true,
      fadeinLoadedSlide: false,
      globalCaption: false,
      arrowsNavAutoHide: false,
      slidesSpacing: 2,
      imageScalePadding: 2,
      controlsInside: false,
      autoScaleSlider: false,
      autoScaleSliderWidth: false,
      autoScaleSliderHeight: false,
      imageScaleMode: "fill",
      // sliderTouch: false,
      visibleNearby: {
        enabled: true,
        center: true,
        centerArea: .33,
        breakpoint: 600,
        breakpointCenterArea: .6
      }
    });

    $(".slider-product-list").royalSlider({
      transitionSpeed: 500,
      addActiveClass: true,
      arrowsNav: true,
      loop: true,
      fadeinLoadedSlide: false,
      globalCaption: false,
      arrowsNavAutoHide: false,
      slidesSpacing: 2,
      imageScalePadding: 2,
      controlsInside: false,
      autoScaleSlider: false,
      autoScaleSliderWidth: false,
      autoScaleSliderHeight: false,
      imageScaleMode: "fill",
      // sliderTouch: false,
      visibleNearby: {
        enabled: true,
        center: true,
        centerArea: .2,
        breakpoint: 600,
        breakpointCenterArea: .6
      }
    });



  // Force recalc of slides for sliders within bootstrap tabs ----
  $('a[data-toggle="tab"]').on('shown', function (e) {
    // force RS resize
    $('.royalSlider').royalSlider('updateSliderSize', true);
  })



    var getCarouselTabName = $('.nav-tabs--products .active a').text();
    $( '<h3 class="sub-slider__title">' + getCarouselTabName + '</h3>' ).prependTo( '.tab-content--products' );

      function initCountdownTimer () {
          $("p.countdown--timer").each(function(){
              var countdownDate = new Date($(this).attr("data-datetime"));
              $(this).countdown(countdownDate, function (event) {
                  var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                  if(totalHours < 10) totalHours = "0" + totalHours;
                  $(this).html(event.strftime(totalHours + "<span class=\"countdown--suffix\">h</span> %M<span class=\"countdown--suffix\">m</span> %S<span class=\"countdown--suffix\">s</span>"));
              });
          });
          console.log("done");
      }
      initCountdownTimer();
      var slider = $("#mainHomeSlider").data("royalSlider");
      slider.ev.on("rsAfterSlideChange", initCountdownTimer);



  });// End doc ready.
}); // End require

