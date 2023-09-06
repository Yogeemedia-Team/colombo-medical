/** @format */

(function ($, window) {
	'use strict';
	var $window = $(window);
	var drthWidgets = {
		LoadWidgets: function () {
			var e_front = elementorFrontend,
				e_module = elementorModules;

			var $proWidgets = {
				'droit-video_popup.default': '_video_popup',
				'droit-advance-accordions.default': '_dl_pro_accordions',
				'droit-advance_pricing.default': '_dl_pro_advance_pricing',
				'droit-tabs.default': '_dl_pro_tabs',
				'droit-fun_fact.default': '_dl_pro_counterup',
				'droit-adavnced-slider.default': '_dl_pro_advance_slider',
				'droit-testimonial-pro.default': '_dl_pro_advance_slider',
				'droit-woo-product-cat-slider.default': '_dl_pro_advance_slider'
			};

			var widgetsMap = {
				'drth-parallax-img.default': drthWidgets._dl_pro_animated_img,
				'drth-test.default': drthWidgets.drth_test,
				'droit-video_popup.default': drthWidgets._video_popup,
				'droit-fun_fact.default': drthWidgets._dl_pro_counterup,
				'droit-advance-accordions.default': drthWidgets._dl_pro_accordions,
				'droit-advance_pricing.default': drthWidgets._dl_pro_advance_pricing,
				'droit-tabs.default': drthWidgets._dl_pro_tabs,
				'drth-banner-slider.default': drthWidgets._dl_pro_banner_slider,
				'drth-causes-carousel.default': drthWidgets._dl_cause_carousel,
				'drth-recent-projects.default': drthWidgets._dl_recent_project_carousel,
				'droit-adavnced-slider.default': drthWidgets._dl_pro_advance_slider,
				'droit-testimonial-pro.default': drthWidgets._dl_pro_advance_slider,
				'droit-woo-product-cat-slider.default': drthWidgets._dl_pro_advance_slider
			};

			$.each(widgetsMap, function (name, callback) {
				if (dlth_theme.dl_pro == 'yes' && name in $proWidgets) {
				} else {
					e_front.hooks.addAction('frontend/element_ready/' + name, callback);
				}
			});
		},

		_dl_pro_animated_img: function ($scope) {
			var $parallax_img = $scope.find('.droit_parallax_img_wrapper'),
				$parallax_data = $parallax_img.data('settings');
		},
		_video_popup: function ($scope) {
			var $selector = $scope.find('.droit-video-popup');
			if ($selector.length > 0) {
				$($selector).magnificPopup({
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: !0,
					fixedContentPos: !1,
				});
			}
		},

		_dl_pro_counterup: function ($scope) {
			var $selector = $scope.find('.dl-fun-fact-wrapper'),
				$selector_id = '#' + $selector.attr('id').toString(),
				controls = null,
				delay = 10,
				timer = 1000;
			if ($selector.attr('data-controls')) {
				var controls = JSON.parse($selector.attr('data-controls'));
				delay = controls.delay;
				timer = controls.timer;
			}
			if ($selector_id.length > 0) {
				$($selector_id + ' .fun-counter').counterUp({
					delay: delay,
					time: timer,
				});
			}
		},

		_dl_pro_accordions: function ($scope) {
			var $accrodion = $scope.find('.dl_accordion');
			if ($accrodion.length > 0) {
				$accrodion
					.find('.dl_accordion_item.is-active')
					.children('.dl_accordion_panel')
					.slideDown();
				$accrodion.find('.dl_accordion_item').on('click', function () {
					// Cancel the siblings
					$(this)
						.siblings('.dl_accordion_item')
						.removeClass('is-active')
						.children('.dl_accordion_panel')
						.slideUp();
					// Toggle the item
					$(this)
						.toggleClass('is-active')
						.children('.dl_accordion_panel')
						.slideToggle('ease-out');
				});
			}
		},
		_dl_pro_advance_pricing: function ($scope) {
			var t = $scope.find('.dl_switcher_control-item'),
				h = $scope.find('.dl_switcher_content-item');
			// tab style
			t.click(function (e) {
				e.preventDefault();
				var $this = $(this);

				// close all switcher active class
				t.each(function () {
					let $self = $(this);
					$self.removeClass('on-select');
				});

				// close all content tab
				h.each(function () {
					let $self = $(this);
					$self.removeClass('on-active');
				});

				// selector content
				let $target = $this.data('target');
				let $content = $scope.find('[data-toggle=' + $target + ']');
				$content.addClass('on-active');
				// selected tab
				$this.addClass('on-select');
			});

			// switch style
			var s = $scope.find('.dl_toggle');
			s.click(function (e) {
				e.preventDefault();
				var $this = $(this);
				$this.toggleClass('dl-active');
				$this.parents('.dl_switcher_control').toggleClass('dl-active');

				// content
				h.each(function () {
					let $self = $(this);
					$self.toggleClass('on-active');
				});
			});
		},
		_dl_pro_tabs: function ($scope, t, e) {
			var a = '#' + $scope.find('.dl_tab_container').attr('id').toString();
			t(a + ' ul.dl_tab_menu > li').each(function (e) {
				t(this).hasClass('active-default')
					? (t(a + ' ul.dl_tab_menu > li')
							.removeClass('dl_active')
							.addClass('dl_inactive'),
					  t(this).removeClass('dl_inactive'))
					: 0 == e && t(this).removeClass('dl_inactive').addClass('dl_active');
			}),
				t(a + ' .tab_container div').each(function (e) {
					t(this).hasClass('active-default')
						? t(a + ' .tab_container > div').removeClass('dl_active')
						: 0 == e &&
						  t(this).removeClass('dl_inactive').addClass('dl_active');
				}),
				t(a + ' ul.dl_tab_menu > li').click(function () {
					var e = t(this).index(),
						a = t(this).closest('.droit-advance-tabs'),
						n = t(a).children('.droit-tabs-nav').children('ul').children('li'),
						i = t(a).children('.tab_container').children('div');
					t(this).parent('li').addClass('dl_active'),
						t(n)
							.removeClass('dl_active active-default')
							.addClass('dl_inactive'),
						t(this).addClass('dl_active').removeClass('dl_inactive'),
						t(i).removeClass('dl_active').addClass('dl_inactive'),
						t(i).eq(e).addClass('dl_active').removeClass('dl_inactive');
					t(i).each(function (e) {
						t(this).removeClass('active-default');
					});
				});
		},
		_dl_pro_banner_slider: function ($scope, $) {
			var $slider = $scope.find('.dl_banner_slider'),
				$item = $slider.find('.swiper-slide > *'),
				$thumbs = $scope.find('.gallery-thumbs'),
				$dat = $slider.data('settings'),
				$datTh = $thumbs.data('settings') ? $thumbs.data('settings') : {};

			if ($datTh.hasOwnProperty('thumbsEnable')) {
				var $obj = {
					spaceBetween: $datTh.spaceBetween ? $datTh.spaceBetween : '',
					slidesPerView: $datTh.slidesPerView ? $datTh.slidesPerView : '',
				};
				if ($datTh.breakpoints && $datTh.breakpoints != '') {
					$obj.breakpoints = $datTh.breakpoints;
				}
				var $galleryThumbs = new Swiper($thumbs, $obj);

				$dat.thumbs = {
					swiper: $galleryThumbs,
				};
			}

			$dat.on = {
				slideChangeTransitionStart: function () {
					$item.each(function () {
						$(this).css({
							transition: '0.1s',
							opacity: '0',
						});
					});
				},
				slideChangeTransitionEnd: function () {
					var $animation = $item.find('[data-animation]');
					if ($animation.length > 0) {
						dlAddons_banner_slider($animation);
					}
					$item.each(function () {
						$(this).css({
							transition: '0.1s',
							opacity: '1',
						});
					});
				},
			};
			// render slider
			new Swiper($slider, $dat);

			// auto slider
			if ($dat.dl_mouseover) {
				$slider.hover(
					function () {
						this.swiper.autoplay.stop();
					},
					function () {
						this.swiper.autoplay.start();
					}
				);
			}

			if ($dat.dl_autoplay) {
				$slider.each(function () {
					this.swiper.autoplay.start();
				});
			} else {
				$slider.each(function () {
					this.swiper.autoplay.stop();
				});
			}

			let $delay = $dat.speed;
			if ($dat.autoplay) {
				$delay = $dat.autoplay.delay;
			}
		},
		_dl_cause_carousel: function ($scope) {
			let sliderWrapp = $scope.find('.dl_carousel_slider');
			new Swiper(sliderWrapp, {
				slidesPerView: 'auto',
				centeredSlides: true,
				paginationClickable: true,
				loop: true,
				spaceBetween: 10,
				slideToClickedSlide: true,
				autoplay: {
					delay: 2000,
					disableOnInteraction: false,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					1921: {
						slidesPerView: 4,
					},
					1920: {
						slidesPerView: 'auto',
					},
				},
			});
		},
		_dl_recent_project_carousel: function ($scope) {
			let sliderWrapp = $scope.find('.dl_precent_project_carousel_slider');
			new Swiper(sliderWrapp, {
				slidesPerView: 1,
				spaceBetween: 25,
				loop: true,
				autoplay: {
					delay: 2000,
					disableOnInteraction: false,
				},
				navigation: {
					nextEl: '.recent-project-nav .rpn-button-next',
					prevEl: '.recent-project-nav .rpn-button-prev',
				},
				breakpoints: {
					1025: {
						slidesPerView: 'auto',
					},
					768: {
						slidesPerView: 2,
					},
				},
			});
		},
		_dl_pro_advance_slider: function ($scope) {
			var $slider = $scope.find(
					'.dl_advance_slider, .dl_pro_testimonial_slider, .dl_pro_post_slider, .dl_pro_wooslider, .dl_product_category_slider'
				),
				$item = $scope.find('.swiper-slide'),
				$dat = $slider.data('settings');

			// render slider
			new Swiper($slider, $dat);

			// auto slider
			if ($dat.dl_mouseover) {
				$slider.hover(
					function () {
						this.swiper.autoplay.stop();
					},
					function () {
						this.swiper.autoplay.start();
					}
				);
			}

			if ($dat.dl_autoplay) {
				$slider.each(function () {
					this.swiper.autoplay.start();
				});
			} else {
				$slider.each(function () {
					this.swiper.autoplay.stop();
				});
			}

			let $delay = $dat.speed;
			if ($dat.autoplay) {
				$delay = $dat.autoplay.delay;
			}
		}
	};
	function _dl_pro_count_down_redirect(url) {
		window.location.replace(url);
	}

	function dlAddons_banner_slider(elements) {
		var animationEndEvents =
			'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay,
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
		});
	}
	// load elementor
	$window.on('elementor/frontend/init', drthWidgets.LoadWidgets);
})(jQuery, window);