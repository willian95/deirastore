$('.main-banner__content').slick({
  infinite: true,
  autoplay: false,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  fade: true,
  cssEase: "linear",
  arrows: false,
  responsive: [{
    breakpoint: 1200,
    settings: {

      infinite: true,
      dots: false
    }
  },
  {
    breakpoint: 900,
    settings: {

    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      autoplay: false,
      arrows: false,
      autoplaySpeed: 1000
    }
  }
  ]
});

$('.main-categorias__content').slick({
  // infinite: true,
  slidesToShow: 6,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  centerMode: false,
  centerPadding: '10px',

  responsive: [{
    breakpoint: 1200,
    settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
      dots: true
    }
  },
  {
    breakpoint: 900,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1
    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 2,

      autoplaySpeed: 1000
    }
  }
  ]
});

$('.main-slider__content').slick({
  // infinite: true,
  slidesToShow: 5,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  responsive: [{
    breakpoint: 1200,
    settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
      dots: true
    }
  },
  {
    breakpoint: 900,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 1
    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,

      autoplaySpeed: 1000
    }
  }
  ]
});