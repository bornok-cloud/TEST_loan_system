$(document).ready(function () {
    $('#carouselExampleIndicators').carousel({
      interval: 1000,
    });
    $('#carouselExampleIndicators').on('slid.bs.carousel', function () {
      console.log("Slide changed!");
    });
  });