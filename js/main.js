/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

Site = {
  init: function() {
    var _this = this;

    _this.showHideHeader.init();
  },

};

// Show/Hide header on scroll
Site.showHideHeader = {
  init: function() {
    var _this = this;

    _this.headerHeight = $('#header').height();

    _this.bindScroll();
  },

  debounceSpeed: 150,

  showHide: function() {
    var _this = this;

    return Debounce( function () {
      if ( $(this).scrollTop() >= _this.headerHeight ) {
        $('body').addClass('state-scrolled');
      } else { 
        $('body').removeClass('state-scrolled');
      }

      console.log($(this).scrollTop());
    }, _this.debounceSpeed);
  },

  bindScroll: function() {
    var _this = this;

    window.addEventListener('scroll', _this.showHide());
  },
};

Gallery = {
  Swiper: undefined,
  init: function() {
    var _this = this;

    _this.Swiper = new Swiper ('.swiper-container', {
      loop: true,
      preloadImages: false,
      lazyLoading: true,
      lazyLoadingInPrevNext: true,
      nextButton: '.js-gallery-next',
      prevButton: '.js-gallery-prev',
      onInit: function(swiper) {
        $('#gallery-index-length').html(swiper.slides.length - 2);
        _this.setActive(swiper.activeIndex);
      },

      onSlideChangeEnd: function(swiper) {
        _this.setActive(swiper.activeIndex);
      },

      onClick: function(swiper) {
        swiper.slideNext();
      },
    });

  },

  setActive: function(activeIndex) {
    $('#gallery-index-active').html(activeIndex);
  },
};

jQuery(document).ready(function () {
  'use strict';

  // utility class mainly for use on headines to avoid widows [single words on a new line]
  $('.js-fix-widows').each(function(){
    var string = $(this).html();

    string = string.replace(/ ([^ ]*)$/,'&nbsp;$1');
    $(this).html(string);
  });

  Site.init();
  Gallery.init();

});
