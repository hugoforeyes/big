$(document).ready(function() {
    //  The menu on the left
    $(function() {
      $('nav#menu').mmenu();
    });

    $('#full-width-slider').royalSlider({
      arrowsNav: true,
      loop: true,
      keyboardNavEnabled: true,
      controlsInside: false,
      imageScaleMode: 'fill',
      arrowsNavAutoHide: false,
      autoScaleSlider: true,
      autoScaleSliderWidth: 707,
      autoScaleSliderHeight: 367,
      controlNavigation: 'none',
      thumbsFitInViewport: false,
      navigateByClick: true,
      startSlideId: 0,
      autoPlay: {
            enabled: true,
            pauseOnHover: true,
            delay: 2000
      },
      transitionType:'fade',
      globalCaption: true
    });
});

