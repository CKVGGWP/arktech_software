!(function ($) {
  "use strict";

  $(document).ready(function () {
    $(".multiple-slides").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      nextArrow: "<i class='fa fa-angle-right'></i>",
      prevArrow: "<i class='fa fa-angle-left'></i>",
    });
  });
})(jQuery);
