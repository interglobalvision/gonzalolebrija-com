/* jshint browser: true, devel: true, indent: 2, curly: true, eqeqeq: true, futurehostile: true, latedef: true, undef: true, unused: true */
/* global $, jQuery, document, Modernizr, Site, Swiper, animationSpeed */
const animationSpeed = 300;

Site = {
  mobileThreshold: 1008,
  init: function() {
    var _this = this;

    _this.ObraSidebar.init();
    _this.ObraInfinite.init();
    _this.Filters.bind();
    _this.ExhibitionFilters.init();
    _this.Header.init();
    _this.Mobile.init();
    _this.Gallery.init();
    _this.GridHovers.init();

    $(window).resize(function(){
      _this.onResize();
    });

  },

  onResize: function() {
    var _this = this;

    _this.ObraSidebar.onResize();
    _this.Mobile.onResize();

    if ($('body').hasClass('single-obra')) {
      _this.Gallery.layoutForObra();
    }
  },

  isMobile: function() {
    var _this = this;

    if ($(window).width() <= _this.mobileThreshold) {
      return true;
    } else {
      return false;
    }
  },
};

Site.ObraSidebar = {
  init: function() {
    var _this = this;

    if ($('body').hasClass('single-obra') || $('body').hasClass('post-type-archive-obra')) {
      _this.obraSidebar = true;
      _this.$obraSidebar = $('#obra-archive-submenu');
      if (!Site.isMobile()) {
        $('#main-content').imagesLoaded(function() {
          _this.fixObraSidebar();
        });
      }
    }
  },

  onResize: function() {
    var _this = this;

    if (_this.obraSidebar && !Site.isMobile()) {
      _this.fixObraSidebar();
    }
  },

  fixObraSidebar: function() {
    var _this = this;

    _this.$obraSidebar.height(0);

    var heightToMatch = $('#main-content').height();

    _this.$obraSidebar.height(heightToMatch);

    if (!_this.perfectScrollbarInitiated) {
      _this.$obraSidebar.perfectScrollbar({
        suppressScrollX: true,
      });
      _this.perfectScrollbarInitiated = true;
    }
  },
};

Site.ObraInfinite = {
  postsPerPage: 9,

  init: function() {
    var _this = this;

    if ($('body').hasClass('post-type-archive-obra')) {
      _this.$trigger = $('#works-lazy-loader');
      _this.bind();
    }
  },

  bind: function() {
    var _this = this;

    _this.$trigger.click(function() {
      _this.loadMore();
    });
  },

  loadMore: function() {
    var _this = this;

    $('.pseudo-lazy-work').slice(0, _this.postsPerPage).removeClass('pseudo-lazy-work');

    if ($('.pseudo-lazy-work').length === 0) {
      _this.$trigger.remove();
    }

    Site.ObraSidebar.onResize();
  },
};

Site.Filters = {
  bind: function() {
    var _this = this;
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

            // If mobile close submenu
            if (Site.isMobile()) {
              Site.Mobile.Submenus.close();
            }
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

Site.Mobile = {
  init: function() {
    var _this = this;

    _this.bind();
    _this.Submenus.fixHeight();

  },

  bind: function() {
    var _this = this;

     // MAIN MENU
    $('.mobile-menu-open').on({
      click: function() {
        _this.Menu.open();
      },
    });

    $('.mobile-menu-close').on({
      click: function() {
        _this.Menu.close();
      },
    });

    // SUBMENUS
    $('#mobile-submenu-open').on({
      click: function() {
        _this.Submenus.open();
      },
    });

    $('#mobile-submenu-close').on({
      click: function() {
        _this.Submenus.close();
      },
    });
  },

  onResize: function() {
    var _this = this;

    _this.Submenus.fixHeight();

  },

  Menu: {
    open: function() {
      $('#mobile-active-menu').show();
    },

    close: function() {
      $('#mobile-active-menu').hide();
    },
  },

  Submenus: {
    open: function() {
      $('#mobile-archive-submenu').css({
        'transform': 'translateX(0%)',
      });
      $('#mobile-submenu-open').css('visibility', 'hidden');
    },

    close: function() {
      $('#mobile-archive-submenu').css({
        'transform': 'translateX(-100%)',
      });
      $('#mobile-submenu-open').css('visibility', 'visible');
    },

    fixHeight: function() {

      $('#mobile-submenu-main').css({
        'height': ($(window).height() - $('#mobile-submenu-header').innerHeight()) + 'px',
      });

    },
  },
};

Site.Gallery = {
  Swiper: undefined,
  $captionHolder: undefined,
  init: function() {
    var _this = this;

    _this.$captionHolder = $('#swiper-caption-holder');

    _this.Swiper = new Swiper ('.swiper-container', {
      effect: 'slide',
      loop: true,
      spaceBetween: 24,
      nextButton: '.js-gallery-next',
      prevButton: '.js-gallery-prev',
      preloadImages: false,
      lazyLoading: true,
      lazyLoadingInPrevNext: true,

      pagination: '#single-work-gallery-pagination',
      paginationType: 'custom',
      paginationCustomRender: function (swiper, current, total) {
        return '<span id="gallery-index-active">' + current + '</span> / <span id="gallery-index-length">' + total + '</span>';
      },

      onClick: function(swiper) {
        swiper.slideNext();
      },

      onSlideChangeEnd: function(swiper) {
        var caption = $('.swiper-slide-active .swiper-caption').html();

        _this.$captionHolder.html(caption);
      },
    });

    if ($('body').hasClass('single-obra')) {
      _this.layoutForObra();
    }

  },

  layoutForObra: function() {
    var _this = this;
    var minHeight = 480;

    if (!Site.isMobile()) {

      var headerHeight = $('#single-work-header').outerHeight(true);

      $('#single-work-copy').css({
        'min-height': (minHeight - headerHeight) + 'px',
      });

      $('.swiper-wrapper').css({
        'min-height': minHeight + 'px',
      });

    }
  },
};

Site.GridHovers = {
  init: function() {
    var _this = this;

    _this.$hoverElements = $('.attachment-hover-grid-thumb, .attachment-hover-grid-thumb-small');

    _this.$hoverElements.on({
      mousemove: function(e) {
        var $title = $(this).siblings('.hover-grid-title').first();

        // If mobile dont
        if (!Site.isMobile()) {
          $title.css({
            display: 'block',
            top: e.clientY + 15,
            left: e.clientX + 15,
          });
        }

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
