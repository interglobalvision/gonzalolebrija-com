/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr, Site, Swiper, animationSpeed */
const animationSpeed = 300;

Site = {
  init: function() {
    var _this = this;

    _this.Filters.bind();
    _this.ExhibitionFilters.init();
    _this.Header.init();
    _this.Gallery.init();
    _this.GridHovers.init();
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

Site.ExhibitionFilters = {
  init: function() {
    var _this = this;

    if ($('body').hasClass('single-exposiciones')) {
      _this.bind();
    }

  },

  bind: function() {
    var $exhibtionFilters = $('.exposicion-filter');

    $exhibtionFilters.on({
      click: function() {
        var $this = $(this);
        var target = $this.data('target');

        $exhibtionFilters.removeClass('active');
        $this.addClass('active');

        $('.exposicion-content').removeClass('active');
        $('#exposicion-' + target).addClass('active');
      },
    });
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

      pagination: '#single-work-gallery-nav',
      paginationType: 'custom',
      paginationCustomRender: function (swiper, current, total) {
        return '<span class="js-gallery-prev u-pointer">< </span><span id="gallery-index-active">' + current + '</span> / <span id="gallery-index-length">' + total + '</span><span class="js-gallery-next u-pointer"> ></span>';
      },

      onClick: function(swiper) {
        swiper.slideNext();
      },
    });
  },
};

Site.GridHovers = {
  init: function() {
    var _this = this;

    _this.$hoverElements = $('.attachment-hover-grid-thumb, .attachment-hover-grid-thumb-small');

    _this.$hoverElements.on({
      mousemove: function(e) {
        var $title = $(this).siblings('.hover-grid-title').first();

        $title.css({
          display: 'block',
          top: e.screenY - 70,
          left: e.screenX,
        });

      },

      mouseout: function() {
        var $title = $(this).siblings('.hover-grid-title').first();

        $title.hide();
      },
    });
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
