/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr, Site, Gallery, animationSpeed */
const animationSpeed = 300;

Site = {
  init: function() {

    Site.Filters.bind();

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
          if( 'all' === type ) {
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
