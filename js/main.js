/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr, Site, Swiper, Gallery, animationSpeed */
const animationSpeed = 300;

Site = {
  init: function() {
    var _this = this;

    Site.Filters.bind();

    _this.Header.init();
    _this.Gallery.init();
  },
};

Site.Filters = {
  bind: function() {
    var $links = $('.filters a');
    var $posts = $('.filtered-content');

    if($links) {
      $links.bind('click', function(event) {

        // Get filter type clicked
        var type = event.currentTarget.dataset.filter;

        // If clicked on active, reset filter
        if( !$(this).hasClass('active') ) {
          $links.removeClass('active');

          // Reset All
          if( type === 'all' ) {
            $('[data-filter="all"]').addClass('active');
            $posts.fadeIn();
          } else {
          // Else, apply filter
            $(this).addClass('active');

            // Hide everything then fade in the filtred posts
            $posts.hide().filter('[data-filter-type="' + type + '"]').fadeIn(animationSpeed);
          }
        }
      });
    }
  },
};

// Show/Hide header on scroll
Site.Header = {
  debounceSpeed: 10,
  threshold: 1.1,

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

Site.Gallery = {
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

});