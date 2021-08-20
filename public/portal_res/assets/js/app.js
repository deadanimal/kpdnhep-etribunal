var GPTHEME = GPTHEME || {};

(function($) {

  /*!----------------------------------------------
  # This beautiful code written with heart
  # by Aminul Islam <mominul@gpthemes.com>
  # In Nawabganj, BD at the GP Themes workstation.
  ---------------------------------------------*/

  // USE STRICT
  "use strict";

  var $window = $(window);

  var MAIN = {};
  MAIN.guid = function() {
    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4();
  };

  GPTHEME.initialize = {

    init: function() {
      GPTHEME.initialize.general();
      GPTHEME.initialize.header();
      GPTHEME.initialize.menuToggle();
      GPTHEME.initialize.mobileMenu();
      GPTHEME.initialize.revSlider();
      GPTHEME.initialize.portfolio();
      GPTHEME.initialize.sectionBackground();
      GPTHEME.initialize.skills();
      //GPTHEME.initialize.countup();
      GPTHEME.initialize.magneficPopup();
      GPTHEME.initialize.sectionSwitch();
      GPTHEME.initialize.animateIcons();
      GPTHEME.initialize.map();
    },

    /*===============================================*/
    /*=      Collection of snippet and tweaks       =*/
    /*===============================================*/

    general: function() {

      /* Footer Fixed */
      var footerFixed = $('.footer-fixed').outerHeight();

      if ($(document).width() > 768) {
        $('#main_content').css('margin-bottom', footerFixed);
      }

      /* Rating Star */
      $('.choose-ratting .star-rating').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
      });


      /* Product Filter */
      $("#slider-range").slider({
        range: true,
        min: 0,
        max: 500,
        values: [75, 300],
        slide: function(event, ui) {
          $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
      });

      $("#amount").val("$" + $("#slider-range").slider("values", 0) +
        " - $" + $("#slider-range").slider("values", 1));

      $("#spinner")
        .spinner('delay', 200) //delay in ms
        .spinner('changed', function(e, newVal, oldVal) {

        })
        .spinner('changing', function(e, newVal, oldVal) {

        });

      $('.kv-ltr-theme-default-star').rating({
        hoverOnClear: false,
        containerClass: 'is-star'
      });

      new WOW().init()

      /* Accordian */
      var $panelgroup = $('.panel-group');
      $panelgroup.find('.panel-default:has(".in")').addClass('panel-active');
      $panelgroup.on('shown.bs.collapse', function(e) {
        $(e.target).closest('.panel-default').addClass(' panel-active');
      }).on('hidden.bs.collapse', function(e) {
        $(e.target).closest('.panel-default').removeClass(' panel-active');
      });

      /* Twitter Feed */
      var config4 = {
        "id": '693671421331922946',
        "domId": 'twitter_feed',
        "maxTweets": 2,
        "enableLinks": true,
        "showUser": false,
        "showTime": true,
        "showRetweet": false
      };

      $('#twitter_feed').each(function() {
        twitterFetcher.fetch(config4);
      });



      /* Swiper Slider Init */
      $('.gp-slider').each(function() {
        new SwiperRunner($(this));
      });

      /* Search Box */

      $.fn.searchBox = function(ev) {

        var $searchEl = $('.search-elem');
        var $placeHolder = $('.placeholder');
        var $sField = $('#search-field');

        if (ev === "open") {
          $searchEl.addClass('search-open')
        };

        if (ev === 'close') {
          $searchEl.removeClass('search-open'),
            $placeHolder.removeClass('move-up'),
            $sField.val('');
        };

        var moveText = function() {
          $placeHolder.addClass('move-up');
        }

        $sField.focus(moveText);
        $placeHolder.on('click', moveText);

        $('.submit').prop('disabled', true);
        $('#search-field').keyup(function() {
          if ($(this).val() != '') {
            $('.submit').prop('disabled', false);
          }
        });
      }

      $('.search-btn').on('click', function(e) {
        $(this).searchBox('open');
        e.preventDefault();
      });

      $('.close').on('click', function() {
        $(this).searchBox('close');
      });


      /* Tab */
      $('.tabs').each(function() {
        var tabs = $(this);
        tabs.after('<ul class="tabs-content">');
        tabs.find('li').each(function() {
          var currentTab = $(this);
          var tabContent = currentTab.find('.tab__content').wrap('<li></li>').parent();
          tabContent.detach();
          currentTab.closest('.tabs-container').find('.tabs-content').append(tabContent);
        });
      });

      $('.tabs li').on('click', function() {
        var clickedTab = $(this);
        var tabContainer = clickedTab.closest('.tabs-container');
        var activeIndex = (clickedTab.index() * 1) + (1);

        tabContainer.find('> .tabs > li').removeClass('active');
        tabContainer.find('> .tabs-content > li').removeClass('active');

        clickedTab.addClass('active');
        tabContainer.find('> .tabs-content > li:nth-of-type(' + activeIndex + ')').addClass('active');
      });

      $('.tabs li.active').trigger('click');

      /* Colorfull Banner */


      var scene = document.getElementById('scene');

      // var parallax = new Parallax(scene);

      /* Swiper Slider Init */
      $(scene).each(function() {
        var parallax = new Parallax(scene);
      });

      $('.typed-title').typed({
        stringsElement: $('.typing-title'),
        backDelay: 2000,
        typeSpeed: 0,
        loop: true
      });

      /* Banner Particles */

      $('#banner-particales').particleground({
        directionY: 'center',
        curvedLines: false,
        parallaxMultiplier: 20,
        lineWidth: .5
      });


      /* Banner Static */
      if (typeof $.fn.ripples == 'function') {
        try {
          $('#banner-ripple').ripples({
            resolution: 500,
            perturbance: 0.04
          });
        } catch (e) {
          $('.error').show().text(e);
        }
      }



    },

    /**
     * Control Header
     */
    header: function() {
      var $headerHeight = $('#discohead').outerHeight(),
        $scrollTop = $window.scrollTop(),
        $faker = $('#discohead-faker'),
        $sticky = $('body').hasClass('sticky-header');

      if ($sticky && $scrollTop >= $headerHeight) {
        $('#discohead').addClass('fixed');
        $faker.css('height', $headerHeight + 'px');
      } else {
        $('#discohead').removeClass('fixed');
        $faker.css('height', '');
      }
    },

    /**
     * Menu Toggler
     */
    menuToggle: function() {
      $('#nav-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('#discovery-main-menu').toggleClass('visible');
      });
    },

    /**
     * Mobile Menu
     */

    /*================================*/
    /*=           Mobile Menu        =*/
    /*================================*/
    mobileMenu: function() {
      var $items = $('.menu-item-has-children', $('#discovery-main-menu'));

      $items.each(function() {
        var $this = $(this),
          $anchor = $('> a', $this);

        $anchor.on('click', function(e) {
          var $this = $(this),
            style = $this.next().attr('style');
          e.preventDefault();
          $this.parent().parent().find('.menu-item-has-children').removeClass('sub-menu-open');
          $this.parent().parent().find('.menu-item-has-children > .sub-menu').slideUp();
          if (!style || style === 'display: none;') {
            $this.closest('.menu-item-has-children').toggleClass('sub-menu-open');
            $this.next().slideToggle();
          }

        });
      });
    },

    /*============================================*/
    /*=           Mobile Menu Height Set         =*/
    /*============================================*/

    mobileMenuHeight: function() {

      var $innerHeight = $window.innerHeight(),
        $outerWidth = $window.outerWidth(),
        $headerHeight = $('#masthead').outerHeight(),
        $adminBar = $('#wpadminbar').outerHeight(),
        height = $innerHeight - $headerHeight;

      if ($('body').hasClass('admin-bar')) {
        height = height - $adminBar;
      }

      if ($outerWidth <= 768) {
        $('#discovery-main-menu').css({
          'max-height': height + "px",
          'overflow': 'auto'
        });
      } else {
        $('#discovery-main-menu').css({
          'max-height': '',
          'overflow': ''
        });
        $('.menu-item-has-children', $('#discovery-main-menu')).removeClass('sub-menu-open');
        $('.menu-item-has-children > .sub-menu', $('#discovery-main-menu')).css({
          'display': ''
        });
      }
    },

    /*========================================*/
    /*=           Revolution Slider          =*/
    /*========================================*/
    revSlider: function() {
      $('#main_slider').show().revolution({
        sliderType: "standard",
        sliderLayout: "fullscreen",
        dottedOverlay: "none",
        delay: 9000,
        navigation: {
          keyboardNavigation: "off",
          keyboard_direction: "horizontal",
          mouseScrollNavigation: "off",
          mouseScrollReverse: "default",
          onHoverStop: "off",
          touch: {
            touchenabled: "on",
            touchOnDesktop: "off",
            swipe_threshold: 75,
            swipe_min_touches: 1,
            swipe_direction: "horizontal",
            drag_block_vertical: false
          },
          arrows: {
            style: "uranus",
            enable: true,
            hide_onmobile: true,
            hide_under: 767,
            hide_onleave: true,
            hide_delay: 200,
            hide_delay_mobile: 1200,
            tmp: '',
            left: {
              h_align: "left",
              v_align: "center",
              h_offset: 20,
              v_offset: 0
            },
            right: {
              h_align: "right",
              v_align: "center",
              h_offset: 20,
              v_offset: 0
            }
          },
          bullets: {
            enable: true,
            hide_onmobile: false,
            style: "hermes",
            hide_onleave: false,
            direction: "horizontal",
            h_align: "center",
            v_align: "bottom",
            h_offset: 0,
            v_offset: 40,
            space: 10,
            tmp: ''
          }
        },
        responsiveLevels: [1240, 1024, 778, 480],
        visibilityLevels: [1240, 1024, 778, 480],
        gridwidth: [1200, 1024, 778, 480],
        gridheight: [800, 768, 960, 720],
        lazyType: "smart",
        parallax: {
          type: "scroll",
          origo: "slidercenter",
          speed: 1000,
          speedbg: 0,
          speedls: 0,
          levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, -60, -70, 200, -120, 55],
          disable_onmobile: "on"
        },
        shadow: 0,
        spinner: "off",
        stopLoop: "off",
        stopAfterLoops: -1,
        stopAtSlide: -1,
        shuffle: "off",
        autoHeight: "off",
        fullScreenAutoWidth: "off",
        fullScreenAlignForce: "off",
        fullScreenOffsetContainer: "",
        fullScreenOffset: "",
        hideThumbsOnMobile: "off",
        hideSliderAtLimit: 0,
        hideCaptionAtLimit: 0,
        hideAllCaptionAtLilmit: 0,
        debugMode: false,
        fallbacks: {
          simplifyAll: "off",
          nextSlideOnWindowFocus: "off",
          disableFocusListener: false,
        }
      });

      $('#slider_two').show().revolution({
        sliderLayout: "fullscreen",
        dottedOverlay: "none",
        delay: 9000,
        navigation: {
          keyboardNavigation: "off",
          keyboard_direction: "horizontal",
          mouseScrollNavigation: "off",
          mouseScrollReverse: "default",
          onHoverStop: "off",
          bullets: {
            enable: true,
            hide_onmobile: false,
            style: "zeus",
            hide_onleave: false,
            direction: "vertical",
            h_align: "right",
            v_align: "center",
            h_offset: 20,
            v_offset: 0,
            space: 5,
            tmp: '<span class="tp-bullet-image"></span><span class="tp-bullet-imageoverlay"></span><span class="tp-bullet-title">{{title}}</span>'
          }
        },
        responsiveLevels: [1240, 1024, 778, 480],
        visibilityLevels: [1240, 1024, 778, 480],
        gridwidth: [1240, 1024, 778, 480],
        gridheight: [868, 768, 960, 720],
        lazyType: "none",
        parallax: {
          type: "mouse+scroll",
          origo: "slidercenter",
          speed: 400,
          speedbg: 0,
          speedls: 0,
          levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 51, 55],
        },
        shadow: 0,
        spinner: "off",
        stopLoop: "off",
        stopAfterLoops: -1,
        stopAtSlide: -1,
        shuffle: "off",
        autoHeight: "off",
        fullScreenAutoWidth: "off",
        fullScreenAlignForce: "off",
        fullScreenOffsetContainer: "",
        fullScreenOffset: "",
        disableProgressBar: "on",
        hideThumbsOnMobile: "off",
        hideSliderAtLimit: 0,
        hideCaptionAtLimit: 0,
        hideAllCaptionAtLilmit: 0,
        debugMode: false,
        fallbacks: {
          simplifyAll: "off",
          nextSlideOnWindowFocus: "off",
          disableFocusListener: false,
        }
      });

      $('#rev_slider_gradien').show().revolution({
        sliderType: "hero",
        sliderLayout: "fullscreen",
        dottedOverlay: "none",
        delay: 9000,
        navigation: {},
        responsiveLevels: [1240, 1240, 778, 480],
        visibilityLevels: [1240, 1240, 778, 480],
        gridwidth: [1240, 1240, 778, 480],
        gridheight: [868, 868, 960, 720],
        lazyType: "none",
        parallax: {
          type: "scroll",
          origo: "slidercenter",
          speed: 1000,
          speedbg: 0,
          speedls: 2000,
          levels: [8, 16, 24, 32, -8, -16, -24, -32, 36, 2, 4, 6, 50, -30, -20, 55],
        },
        shadow: 0,
        spinner: "off",
        autoHeight: "off",
        fullScreenAutoWidth: "off",
        fullScreenAlignForce: "off",
        fullScreenOffsetContainer: "",
        fullScreenOffset: "",
        disableProgressBar: "on",
        hideThumbsOnMobile: "off",
        hideSliderAtLimit: 0,
        hideCaptionAtLimit: 0,
        hideAllCaptionAtLilmit: 0,
        debugMode: false,
        fallbacks: {
          simplifyAll: "off",
          disableFocusListener: false,
        }

      });

      $('#rev_slider_colorfull').show().revolution({
        sliderType: "standard",
        sliderLayout: "fullscreen",
        dottedOverlay: "none",
        delay: 9000,
        navigation: {
          keyboardNavigation: "off",
          keyboard_direction: "horizontal",
          mouseScrollNavigation: "off",
          mouseScrollReverse: "default",
          onHoverStop: "off",
          arrows: {
            style: "custom",
            enable: true,
            hide_onmobile: false,
            hide_onleave: false,
            tmp: '',
            left: {
              h_align: "left",
              v_align: "center",
              h_offset: 20,
              v_offset: 0
            },
            right: {
              h_align: "right",
              v_align: "center",
              h_offset: 20,
              v_offset: 0
            }
          },
          bullets: {
            enable: true,
            hide_onmobile: false,
            style: "new-bullet-bar",
            hide_onleave: false,
            direction: "horizontal",
            h_align: "center",
            v_align: "bottom",
            h_offset: 0,
            v_offset: 20,
            space: 5,
            tmp: ''
          }
        },
        responsiveLevels: [1240, 1024, 778, 480],
        visibilityLevels: [1240, 1024, 778, 480],
        gridwidth: [1240, 1024, 778, 480],
        gridheight: [868, 768, 960, 720],
        lazyType: "none",
        parallax: {
          type: "mouse",
          origo: "enterpoint",
          speed: 400,
          speedbg: 0,
          speedls: 0,
          levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 51, 55],
        },
        shadow: 0,
        spinner: "off",
        stopLoop: "off",
        stopAfterLoops: -1,
        stopAtSlide: -1,
        shuffle: "off",
        autoHeight: "off",
        fullScreenAutoWidth: "off",
        fullScreenAlignForce: "off",
        fullScreenOffsetContainer: "",
        fullScreenOffset: "",
        disableProgressBar: "on",
        hideThumbsOnMobile: "off",
        hideSliderAtLimit: 0,
        hideCaptionAtLimit: 0,
        hideAllCaptionAtLilmit: 0,
        debugMode: false,
        fallbacks: {
          simplifyAll: "off",
          nextSlideOnWindowFocus: "off",
          disableFocusListener: false,
        }
      });
    },

    /*===========================*/
    /*=           Popup         =*/
    /*===========================*/

    magneficPopup: function() {
      $('.popup-modal').magnificPopup({
        type: 'image',
        gallery: {
          enabled: true
        }
      });
      $('.video-play-icon').magnificPopup({
        type: 'iframe'
      });
      $.extend(true, $.magnificPopup.defaults, {
        iframe: {
          patterns: {
            youtube: {
              index: 'youtube.com/',
              id: 'v=',
              src: 'http://www.youtube.com/embed/%id%?autoplay=1'
            }
          }
        }
      });
    },


    /*========================================*/
    /*=          Portfolio Masonrty          =*/
    /*========================================*/
    portfolio: function() {

      var $gride = $('.portfolio-masonry').isotope({
        itemSelector: '.portfolio-item',
        percentPosition: true,
        masonry: {
          columnWidth: '.grid-sizer',
          layoutMode: 'masonry',
        }
      });

      if ($('.gp-isotope').length > 0) {

        var $container = $('.gp-portfolio-items');

        // init Isotope
        var $grid = $('.grid').isotope({
          itemSelector: '.grid-item',
          percentPosition: true,
          masonry: {
            columnWidth: '.grid-sizer'
          }
        });

        // layout Isotope after each image loads
        $grid.imagesLoaded().progress(function() {
          $grid.isotope('layout');
        });

        // filter items when filter link is clicked
        $('.gp-isotope-filter a').on('click', function() {
          var selector = $(this).attr('data-filter');
          $container.isotope({
            filter: selector
          });
          return false;
        });

        $('.gp-isotope-filter a').on('click', function() {
          $('.gp-isotope-filter').find('.current').removeClass('current');
          $(this).parent().addClass('current');
        });
      }
    },

    /*========================================*/
    /*=          Section Background          =*/
    /*========================================*/

    sectionBackground: function() {
      // Section Background Color
      $('[data-bg-color]').each(function() {
        var value = $(this).data('bg-color');
        $(this).css({
          backgroundColor: value,
        });
      });

      // Section Background Image
      $('[data-bg-image]').each(function() {
        var img = $(this).data('bg-image');
        $(this).css({
          backgroundImage: 'url(' + img + ')',
        });
      });

      $('[data-parallax="image"]').each(function() {

        var actualHeight = $(this).position().top;
        var speed = $(this).data('parallax-speed');
        var reSize = actualHeight - $(window).scrollTop();
        var makeParallax = -(reSize / 2);
        var posValue = makeParallax + "px";

        $(this).css({
          backgroundPosition: '50% ' + posValue,
        });
      });
    },

    /*=============================*/
    /*=           Skills          =*/
    /*=============================*/
    skills: function() {


      $('.skill-bar li, .skill-bar-two li').appear();

      $(document.body).on('appear', '.skill-bar li', function(e, $affected) {
        // this code is executed for each appeared element

        $affected.each(function() {
          $(this).css({
            opacity: 1,
            left: "0px"
          });
          var b = $(this).find(".progress-bar").attr("data-width");
          $(this).find(".progress-bar").css({
            width: b + "%"
          });
        })
      });


    },

    /*==============================*/
    /*=           Countup          =*/
    /*==============================*/
    countup: function() {
      var options = {
        useEasing: true,
        useGrouping: true,
        separator: ',',
        decimal: '.',
        prefix: '',
        suffix: ''
      };

      var counteEl = $('[data-counter]');

      if (counteEl) {
        counteEl.each(function() {
          var val = $(this).data('counter');

          var countup = new CountUp(this, 0, val, 0, 2.5, options);
          $(this).appear(function() {
            countup.start();
          }, {
            accX: 0,
            accY: 0
          })
        });
      }
    },

    /*=====================================*/
    /*=           Section Switch          =*/
    /*=====================================*/

    sectionSwitch: function() {
      $('[data-type="section-switch"], #menu-home li a, #banner-particales a, #banner-creative a, #banner-ripple a').on('click', function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = $(this.hash);
          if (target.length > 0) {

            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    },

    /*=================================*/
    /*=           Google Map          =*/
    /*=================================*/
    map: function() {

      $('.gmap3-area').each(function() {
        var $this = $(this),
          key = $this.data('key'),
          lat = $this.data('lat'),
          lng = $this.data('lng'),
          mrkr = $this.data('mrkr');

        $this.gmap3({
            center: [lat, lng],
            zoom: 16,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            style: [{
              "featureType": "poi.business",
              "elementType": "all",
              "stylers": [{
                "hue": "#ff00ca"
              }, {
                "saturation": "100"
              }, {
                "lightness": "0"
              }, {
                "gamma": "1"
              }]
            }, {
              "featureType": "poi.business",
              "elementType": "labels.icon",
              "stylers": [{
                "hue": "#ff0000"
              }]
            }]
          })
          .marker(function(map) {
            return {
              position: map.getCenter(),
              icon: mrkr
            };
          })

      });
    },

    /*==================================*/
    /*=           Animate Icon         =*/
    /*==================================*/

    animateIcons: function() {

      var instanceName = '__animatedIcon';
      var AnimatedIcon = function(el, options) {
        return this.init(el, options);
      };
      AnimatedIcon.defaults = {
        color: '#6d47d9',
        hoverColor: null,
        type: 'delayed',
        duration: 100,
        delay: 0,
        resetOnHover: true
      };
      AnimatedIcon.prototype = {
        init: function(el, options) {
          if (el.data(instanceName)) {
            return this;
          }
          this.el = el;
          this.setOptions(options).build();
          return this;
        },
        setOptions: function(options) {
          this.el.data(instanceName, this);
          this.options = $.extend(true, {}, AnimatedIcon.defaults, options);
          return this;
        },
        build: function() {
          var self = this,
            el = this.el,
            obj = el.find('svg'),
            objVivus, delayTime = parseInt(self.options.delay, 10),
            parentIconbox = el.closest('.icon-box').attr('id', 'iconbox-' + Math.round(Math.random() * 1e6));
          if (!obj.length) {
            return;
          }
          objVivus = new Vivus(obj.get(0), {
            type: self.options.type,
            duration: self.options.duration,
            start: 'manual',
            onReady: function(event) {
              var strokegradients, strokeHoverGradients = document.createElementNS('http://www.w3.org/2000/svg', 'style'),
                linearGradientEl = document.createElementNS('http://www.w3.org/2000/svg', 'linearGradient'),
                gradientValues = typeof self.options.color !== typeof undefined && self.options.color !== null ? self.options.color.split(',') : '#000',
                hoverGradientValues = self.options.hoverColor,
                gid = Math.round(Math.random() * 1e6);
              if (undefined === gradientValues[1]) {
                gradientValues[1] = gradientValues[0];
              }
              strokegradients = '<defs xmlns="http://www.w3.org/2000/svg"><linearGradient gradientUnits="userSpaceOnUse" id="grad' + gid + '" x1="0%" y1="0%" x2="0%" y2="100%">' + '<stop offset="0%" stop-color="' + gradientValues[0] + '" />' + '<stop offset="100%" stop-color="' + gradientValues[1] + '" />' + "</linearGradient></defs>";
              var xmlStrokegradients = new DOMParser().parseFromString(strokegradients, "text/xml");
              obj.prepend(xmlStrokegradients.documentElement);
              if (typeof undefined !== typeof hoverGradientValues && null !== hoverGradientValues) {
                hoverGradientValues = hoverGradientValues.split(',');
                if (undefined === hoverGradientValues[1]) {
                  hoverGradientValues[1] = hoverGradientValues[0];
                }
                strokeHoverGradients.innerHTML = '#' + parentIconbox.attr('id') + ':hover .animated-icon defs stop:first-child{stop-color:' + hoverGradientValues[0] + ';}' + '#' + parentIconbox.attr('id') + ':hover .animated-icon defs stop:last-child{stop-color:' + hoverGradientValues[1] + ';}';
                obj.prepend(strokeHoverGradients);
              }
              obj.find('path').attr('stroke', 'url(#grad' + gid + ')');
              $(event.el).closest('.animated-icon').addClass('appear-animation-visible');
            }
          }).play();
          if ($(window).width() >= 992) {
            objVivus.reset().stop();
            el.appear();
            el.on('appear', function() {
              if (objVivus.getStatus() == 'start' && objVivus.getStatus() != 'progress') {
                objVivus.stop().reset();
                setTimeout(function() {
                  objVivus.play(self.options.duration / 100);
                }, delayTime);
              }
            });
            $.force_appear();
            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
              objVivus.stop().reset();
              setTimeout(function() {
                objVivus.play(self.options.duration / 100);
              }, delayTime);
            });
            if (self.options.resetOnHover) {
              parentIconbox.on('mouseenter', function() {
                if (objVivus.getStatus() == 'end') {
                  objVivus.stop().reset().play(self.options.duration / 100);
                }
              });
            }
          }
          return this;
        }
      };
      $.fn.rellaAnimatedIcon = function(settings) {
        return this.map(function() {
          var el = $(this);
          if (el.data(instanceName)) {
            return el.data(instanceName);
          } else {
            var pluginOptions = el.data('plugin-options'),
              opts;
            if (pluginOptions) {
              opts = $.extend(true, {}, settings, pluginOptions);
            }
            return new AnimatedIcon(el, opts);
          }
        });
      };
      $(document).ready(function() {
        $('[data-plugin-animated-icon]').rellaAnimatedIcon();
      });
    }

  };

  GPTHEME.documentOnReady = {
    init: function() {
      GPTHEME.initialize.init();
      //$('[data-plugin-animated-icon]').rellaAnimatedIcon();
      /* TweenMax */
      // var slp = $(".slideUp"),
      //     sld = $(".slideDown"),
      //     sll = $(".slideLeft"),
      //     slr = $(".slideRight"),
      //     fu =  $(".fadeInUp"),
      //     fd =  $(".fadeInDown"),
      //     fl =  $(".fadeInLeft"),
      //     fr =  $(".fadeInRight"),
      //     fi =  $(".fadeIn"),
      //     tm = new TweenMax();

      // tm
      //


    },

  };

  GPTHEME.documentOnLoad = {
    init: function() {
      $(".loader-wrap").fadeOut("slow");
      //GPTHEME.initialize.parallaxBanner();
      TweenMax.from('.slideUp', 1, {
        y: 100,
        autoAlpha: 0,
        opacity: 0,
        scale: 0,
        delay: 0.3,
        ease: Power4.easeOut
      });
      TweenMax.from('.slideUpd', 1, {
        y: 100,
        autoAlpha: 0,
        opacity: 0,
        scale: 0,
        delay: 0.5,
        ease: Power3.easeOut
      });
      TweenMax.from('.slideLeft', .5, {
        opacity: 0,
        delay: 0.7,
        ease: Power4.easeOut
      });
      TweenMax.from('.slideRight', .5, {
        opacity: 0,
        delay: 0.7,
        ease: Power4.easeOut
      });
    },

  };

  GPTHEME.documentOnResize = {
    init: function() {
      GPTHEME.initialize.mobileMenuHeight();
    },

  };

  GPTHEME.documentOnScroll = {
    init: function() {
      GPTHEME.initialize.sectionBackground();
      GPTHEME.initialize.header();

      if ($(window).scrollTop() > 300) {
        $('.return-to-top').addClass('back-top');
      } else {
        $('.return-to-top').removeClass('back-top');
      }




    },

  };

  // Initialize Functions
  $(document).ready(GPTHEME.documentOnReady.init);
  $(window).on('load', GPTHEME.documentOnLoad.init);
  $(window).on('resize', GPTHEME.documentOnResize.init);
  $(window).on('scroll', GPTHEME.documentOnScroll.init);

})(jQuery);