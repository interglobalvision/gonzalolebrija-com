/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr */

Site = {
  init: function() {
    var _this = this;

    _this.Header.init();
  },

};

// Show/Hide header on scroll
Site.Header = {
  init: function() {
    var _this = this;

    var $body = $('body');

    if ( $body.hasClass('home') ) {
      _this.headerHeight = $('#home-header').height();

      // Initial check
      if ( $(window).scrollTop() > _this.headerHeight * _this.threshold ) {
        $body.addClass('state-scrolled');
      } else { 
        $body.removeClass('state-scrolled');
      }

      _this.bindScroll();
    }
  },

  debounceSpeed: 10,
  threshold: 1.1,

  showHide: function() {
    var _this = this;

    return Debounce( function () {
      var scrollTop = $(this).scrollTop();
      var $body = $('body');

      if ( scrollTop >= _this.headerHeight * _this.threshold) {
        $body.addClass('state-scrolled');
      } else { 
        $body.removeClass('state-scrolled');
      }

      _this.lastScroll = scrollTop;

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
