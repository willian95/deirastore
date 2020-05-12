$(function () {
  'use strict'

  $('[data-toggle="offcanvas"]').on('click', function () {
    $('.offcanvas-collapse').toggleClass('open')
  })
})

$(document).ready(function() {
	$(".megamenu").on("click", function(e) {
		e.stopPropagation();
	});
});


// Menú fixed
$(window).scroll(function () {
  if ($(document).scrollTop() > 70 && ($(window).width() >= 768)) {
   
    // $('.navbar-fixed-js').addClass('top');
    // $('.navbar-fixed-js').removeClasss('top');
  } else {
    // $('.navbar-fixed-js').removeClass('fixed');
    // $('.nav-link').removeClass('fixed-color');
    // $('.nav-top__header').removeClass('nav-top__header--detele');
    // $("#iso").removeClass('img-size').attr('src', 'assets/img/logo.jpeg').removeClass('scroll-up');
    // $('.navbar').addClass('top');
 
    // $('.navbar-fixed-js').addClass('top');
    // $('.navbar-fixed-js').removeClasss('top');
  }
});
let navLanguage = $('.nav-focus').find('a.focus__link')

$('.language').click(function () {
  var $this = $(this);
  if (navLanguage.hasClass('active')) {
    navLanguage.toggleClass('active');
  }
});

