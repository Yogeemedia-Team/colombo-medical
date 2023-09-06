/** @format */

jQuery(function () {
	'use strict';

	//*============ parallaxie js ==============*/

	if ($('.parallaxie').length) {
		if ($(window).width() > 767) {
			$('.parallaxie').parallaxie({
				speed: 0.5,
			});
		}
	}
	$('.orderby').niceSelect();
	//*============ background image js ==============*/
	$('[data-bg-img]').each(function () {
		var bg = $(this).data('bg-img');
		$(this).css({
			background: 'no-repeat center 0/cover url(' + bg + ')',
		});
	});

	//* Navbar Fixed
	function navbarFixedTwo() {
		if ($('.sticky_nav').length) {
			$(window).scroll(function () {
				var scroll = $(window).scrollTop();
				if (scroll) {
					$('.sticky_nav').addClass('navbar_fixed');
				} else {
					$('.sticky_nav').removeClass('navbar_fixed');
				}
			});
		}
	}
	navbarFixedTwo();

	if ($('.site-header').hasClass('site-header')) {
		var nav = $('.site-header');
		$(window).on('load resize', function () {
			var headerHeight = nav.outerHeight();
			nav.css('height', headerHeight).show();
		});
	}

	function Menu_js() {
		if ($('.submenu').length) {
			$('.submenu > .dropdown-toggle').click(function () {
				var location = $(this).attr('href');
				window.location.href = location;
				return false;
			});
		}
	}
	Menu_js();

	function menu_dropdown() {
		if ($(window).width() < 992) {
			$('.menu > li .mobile_dropdown_icon,.search_cart .shpping-cart').on(
				'click',
				function (event) {
					$(this).parent().find('.dropdown-menu').first().slideToggle(700);
					$(this)
						.parent()
						.find('.mobile_dropdown_icon')
						.first()
						.toggleClass('arrow_rotate');
					$(this).parent().siblings().find('.dropdown-menu').slideUp(700);
					$(this)
						.parent()
						.siblings()
						.find('.mobile_dropdown_icon')
						.removeClass('arrow_rotate');
				}
			);
		}
	}
	menu_dropdown();

	$('.search > a').on('click', function () {
		if ($(this).parent().hasClass('open')) {
			$(this).parent().removeClass('open');
		} else {
			$(this).parent().addClass('open');
		}
		return false;
	});

	$('.navbar-toggler').on('click', function () {
		if ($('.navbar-toggler').hasClass('collapsed')) {
			$(this).removeClass('collapsed');
		} else {
			$(this).addClass('collapsed');
		}

		if ($('.navbar-collapse').not('show')) {
			$('.navbar-collapse').removeClass('show').slideToggle(700);
		} else {
			$('.navbar-collapse').addClass('show').slideUp(700);
		}
	});

	$(window).resize(function() {
		if (window.matchMedia("(max-width: 1024px)").matches) {
			$('.drdt_navmenu li i').on('click', function(e){
				$(this).siblings('.sub-menu').toggle(700);
				$(this).parents('li').siblings('li').find('.sub-menu').slideUp(700);
			});
		}
	}).trigger("resize");

	$(document).on('mouseenter', '.has-mega-menu', function(){
		// fulid menu
		if($(this).hasClass('fullwidth')){
			 $($(this).parents('.elementor-top-section')).addClass('megamenu_wrapper');
		}
		// Container width Menu
		if($(this).hasClass('contentwidth')){
			 $($(this).parents('.elementor-widget-container')).addClass('megamenu_wrapper');
		}
		// Content width menu
		if($(this).hasClass('menuwidth')){
			 $($(this).parents('.drdt_navmenu')).addClass('megamenu_wrapper');
		}
   }).on('mouseleave','.has-mega-menu', function(){
	   
		setTimeout(function(){
			 if($(this).hasClass('fullwidth')){
				  $($(this).parents('.elementor-top-section')).removeClass('megamenu_wrapper');
			 }
		}.bind(this), 300);
		
		setTimeout(function(){
			 if($(this).hasClass('contentwidth')){
				  $($(this).parents('.elementor-widget-container')).removeClass('megamenu_wrapper');
			 }
		}.bind(this), 300);
		
		setTimeout(function(){
			 if($(this).hasClass('menuwidth')){
				  $($(this).parents('.drdt_navmenu')).removeClass('megamenu_wrapper');
			 }
		}.bind(this), 300);	
   });
 //  WooCommerce Quntity Changer 
 QuantityChange();
 function QuantityChange() {
	$(document).off("click", "._medishop_quntity_changer > button").on("click", "._medishop_quntity_changer > button", function () {
		// Find quantity input field corresponding to increment button clicked.
		var qty = $(this).parents('._medishop_quntity_changer').siblings('.input-text');
		console.log(qty);
		// Read value and attributes min, max, step.
		var val = parseFloat(qty.val());
		var max = parseFloat(qty.attr("max"));
		var min = parseFloat(qty.attr("min"));
		var step = parseFloat(qty.attr("step"));
		// var static = 8;
		
		var qtyObj = $(this).siblings(".quantity");
		var last_step = qtyObj.attr('data-last_step');
		last_step = parseFloat( last_step );
		var prev_step = qtyObj.attr('data-prev_step');
		prev_step = parseFloat( prev_step );
		// Change input field value if result is in min and max range.
		// If the result is above max then change to max and alert user about exceeding max stock.
		// If the field is empty, fill with min for "-" (0 possible) and step for "+".
		if ($(this).is(".plus")) {
			if (val === max){
				return false;
			}
				
			if (isNaN(val)) {
				qty.val(step);
				return false;
			}
			if (val + step > max) {
				qtyObj.attr('data-last_step', ( max-val < 0 ? 1 : max-val ) );
				qtyObj.attr('data-prev_step', ( step ) );
				qtyObj.find(".input-text").removeAttr('step' );
				qty.val(max);
			} else {
				qty.val(val + step);
			}
		} else {

			if (last_step) {
				
				qty.val(max - last_step);
				qtyObj.removeAttr('data-last_step');
				qtyObj.find(".input-text").attr('step', prev_step );
				qtyObj.removeAttr('data-prev_step');
				return false;
			}
			if (val === min){
				return false;
			}
				
			if (isNaN(val)) {
				qty.val(min);
				return false;
			}
			if (val - step < min) {
				qty.val(min);
			} else {
				qty.val(val - step);
			}
		}

		qty.val(Math.round(qty.val() * 100) / 100);
		qty.trigger("change");
		$("body").removeClass("sf-input-focused");
	});
}
$(document).ajaxComplete(function () {
	QuantityChange();
});
//  add active class on checkout page 
$('body').on( 'updated_checkout', function() {  // lets do this everytime the ajax event update_checkout goes off, which is also does when the checkout loads on inital page load and/or refreash

    var $input = $('.wc_payment_method input');   // caching our input 

    $input.filter(':checked').parent().addClass("active");  // filtering out the checked one and adding .is-active to the parten li on inital page load/refresh

    $input.on('change', function () { // removing and adding our .is-active whnever there is a change
        $input.parent().removeClass('active');
        $(this).parent().addClass('active');
    });     
});  
//  wishlist icon change 
$('.theme-list-view-wrapper .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a').html('<i class="icon-heart"></i> <span></span>');
$('.product_featured_img .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a').html('<i class="icon-heart"></i> <span></span>');

});