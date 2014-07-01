// Menu object
var Menu = (function() {
	var pub = {};
	
	pub.showMenu = function() {
		var menuHeight = $('header .menu-inner:first').innerHeight();
		$('header .menu-wrap')
			.css({
				'height': 'auto',
				'margin-top': '-' + menuHeight + 'px'
			});
		setTimeout(function() {
			$('header .menu-wrap')
				.addClass('trans')
				.css({
					'margin-top': 0
				});
		},10);
	}
	pub.hideMenu = function() {
		var menuHeight = $('header .menu-inner:first').innerHeight();
		$('header .menu-wrap')
			.css({
				'margin-top': '-' + menuHeight + 'px'
			});
		
		if(!Util.ie8) {
			setTimeout(function() {
				$('header .menu-wrap')
					.removeClass('trans')
					.css({
						'height': 0,
						'margin-top': 0
					});
			},1000);		
		}

	}
	
	// Event bindings
	$(document).on('click', '.menu-btn', function() {
		if(!$(this).hasClass('close')) {
			pub.showMenu();
		} else {
			pub.hideMenu();
		}
		$(this).toggleClass('close');
	});
	$(document).on('click', '.menu-close-btn', function() {
		pub.hideMenu();
		$('.menu-btn').removeClass('close');
	});
	
	// Return public vars
	return pub;
})();

// AudioPlayer object
var AudioPlayer = (function() {
	var pub = {};
	
	// Public variables & methods
	pub.checkDemoReel = function() {
		// Fade in the demo reel if the bottom of the 
		// screen is below the bottom of the demo reel
		var scrollBottom = $(window).scrollTop() + $(window).height(),
			$demoReel = $('.main-highlight .demo-reel-wrap'),
			demoReelBottom = $demoReel.offset().top + $demoReel.height();
			
		if(scrollBottom > demoReelBottom) {
			demoReelFade();
		}
	}
	pub.demoReelFade = function() {
		$('.main-highlight .demo-reel-wrap').addClass('trans');
		
		// Unbind the demo reel event listeners
		$(window).off('.demoReel');
	}
	
	// Private variables & methods
	var priv = {};
	priv.demoReelEval = function() {
		// Fade in the demo reel if the bottom of the 
		// screen is below the bottom of the demo reel
		var scrollBottom = $(window).scrollTop() + $(window).height(),
			$demoReel = $('.main-highlight .demo-reel-wrap'),
			demoReelBottom = $demoReel.offset().top + $demoReel.height();
			
		if(scrollBottom > demoReelBottom) {
			$('.main-highlight .demo-reel-wrap').addClass('trans');
			
			// Unbind the demo reel event listeners
			$(window).off('.demoReel');
			return true;
		}
		return false;
	}
	
	// Event bindings
	$(document).ready(function() {
		// Initialize all of the jPlayers
		$('.jp-audio-item').each(function() {
			var id = $(this).data('item-id'),
				// m4aUrl = $(this).data('m4a'),
				// ogaUrl = $(this).data('oga'),
				mp3Url = $(this).data('mp3'),

				swf = $(this).data('swf-path');
			$(this).jPlayer({
				ready: function () {
					$(this).jPlayer("setMedia", {
						// m4a: m4aUrl,
						// oga: ogaUrl
						mp3: mp3Url,
					});
				},
				swfPath: swf,
				// supplied: "m4a, oga",
				supplied: "mp3",
				cssSelectorAncestor: "#jp-item-" + id + "-container"
			});		
		});
	});
	$(window).load(function() {
		// Check for demo reel
		// Does this page have the demo reel?
		if($('#jp-item-demo').length) {
			if(!priv.demoReelEval()) {
				// If the demo reel didn't load the first time then
				// we listen for window changes so it fires later
				$(window).on('scroll.demoReel, resize.demoReel', function() {
					priv.demoReelEval();
				});			
			}
		}
	});
	
	// Return public vars
	return pub;
})();

// Util object
var Util = (function() {
	var pub = {},
		_ajaxPath = '';
	
	pub.ie8 = $('html').hasClass('ie8');
	pub.getWindowWidth = function() {
		return window.innerWidth;
	}
	pub.getWindowTop = function() {
		return $(window).scrollTop();
	}
	pub.getWindowHeight = function() {
		return $(window).height();
	}
	pub.getWindowWidth = function() {
		return document.body.clientWidth;
	}
	pub.getAjaxPath = function() {
		if(_ajaxPath.length == 0 && $.isReady) {
			var $ajaxPathElm = $('#ajax-path');
			_ajaxPath = $ajaxPathElm.attr('value');
			$ajaxPathElm.remove();
		} 
		return _ajaxPath;
	}
	
	// Event bindings
	$(document).on('click', 'a[href="#"]', function(e) {
		e.preventDefault();
	});
	$(document).ready(function() {
		pub.isMobile = $('body').hasClass('mobile');
	});
	
	// Return public vars
	return pub;
})();

/*
var FrontPage = (function() {

	// Event bindings
	$(document).on('click', '.view-front, .view-front-btn', function(e) {
		e.preventDefault();

		var url = $(this).attr('href');
		$(this).loadmodal(url);
	});
})();
*/

// Cart object
var Cart = (function() {
	// Public variables & methods
	var pub = {};
	pub.numItems = 0;
	pub.viewCart = function(hasDelay) {
		// Make sure that init() has run first!
		if(!priv.hasInit) {
			priv.init(pub.viewCart);
			return;
		}

		// Are we debugging?
		dbg = $('input.d').val();
		if(dbg == '0') {
			// Set the unavailable message
			$('.stage-2-wrap .stage-2 .stage-inner').html('<h2>Checkout</h2><p>The system is currently unavailable. Please try again later.</p><div class="split-buttons clearfix"><div class="btn-container"><a href="#" class="btn-back btn-gray">Back</a></div></div>');
		}
	
		var delayTime = hasDelay ? 2000 : 0; // delay before showing sidebar

		// Hide .cart-notification
		priv.$cartNotification.removeClass('on-screen');
			
		// Display the cart
		// Run this after a couple of seconds
		// (it goes smoother this way)
		setTimeout(function() {
			// Display the cart-container on the right
			// side of the body-inner (off page)
			priv.$cartContainer
				.show()
				.css({
					'top': Util.getWindowTop(),
					'height': Util.getWindowHeight()
				});
				
			// Check if there is an overlap
			priv.overlapEval();
			
			// Slide the body-inner off the left of the
			// page (and the cart in on the right)
			priv.$bodyInner.addClass('off-screen');
			
			// Set the sidebar to fixed position after it
			// slides in
			setTimeout(function() {
				priv.$cartContainer
					.prependTo($('body'))
					.addClass('fixed')
					.css({
						'top': 0,
						'height': 'inherit'
					});
				
				$('.stage')
					.removeClass('init')
					.css({'right': '0px'});
				//var pane = $('.stage-1:first').jScrollPane();

				priv.jScrollPane = [];
				$('.jscrollpane').each(function() {
					var pane = $(this).jScrollPane();
					priv.jScrollPane.push(pane.data('jsp'));
				});
			}, 1500);
			
			// Add the width of the scrollbar to the body
			// so it doesn't jump
			//priv.$bodyInner.width(Util.getWindowWidth());
			
			// Remove the vertical body scrollbar
			$('body').addClass('no-scrollbar');
			
			// Bring in the overlay
			priv.$bodyOverlay.delay(1000).fadeIn(500);
		}, delayTime);
	}
	pub.addToCart = function(itemId, callback) {
		// Make sure that init() has run first!
		if(!priv.hasInit) {
			priv.init(function() {
				pub.addToCart(itemId, callback)
			});
			return;
		}
		
		$.post(Util.getAjaxPath(), {'action': 'add_cart_item', 'item_id': itemId }, function(data) {

			var dataJSON = $.parseJSON(data);
			priv.$cartContainer.html(dataJSON.html);
			pub.items = dataJSON.items;
			pub.numItems = dataJSON.numItems;
			pub.totalPrice = dataJSON.totalPrice;
			//priv.$cartContainer.find('.cart-items:first').append(data);
			
			//pub.viewCart(true);
			callback();
		});
	}
	pub.back = function() {
		if($('.cart-container .cart:first').hasClass('offset-stage-2')) {
			$('.cart-container .cart:first')
				.removeClass('offset-stage-2');
		} else if ($('.cart-container .cart:first').hasClass('offset-stage-3')) {
			
			// Reload the page
			document.location.href=document.location.href;
			/*
			pub.hideCart();
			setTimeout(function() {
				$('.cart-container .cart:first')
				.removeClass('offset-stage-3');
			}, 3000);
			*/
		} else {
			pub.hideCart();
		}
	}
	pub.hideCart = function() {
		// Here we are reversing everything that we did in viewCart()
		
		// Set the sidebar back to absolute positioning
		priv.$cartContainer
			.prependTo(priv.$bodyInner)
			.removeClass('fixed')
			.css({
				'top': Util.getWindowTop(),
				'height': Util.getWindowHeight()
			});
		
		setTimeout(function() {
			priv.$cartContainer.hide();
		}, 2000);
		
		
		// Hide the overlay
		priv.$bodyOverlay.fadeOut(500);
		
		setTimeout(function() {
			priv.$bodyInner.removeClass('off-screen');
			
			// Show the vertical body scrollbar
			$('body').removeClass('no-scrollbar');
			
			// Show .cart-notification
			if(pub.numItems > 0) {
				setTimeout(function() {
					priv.$cartNotification.find('span:first').html(pub.numItems);
					priv.$cartNotification.addClass('on-screen');
				}, 1000);		
			} 
		}, 500);
	}
	pub.removeItem = function(item) {
		var itemId = item.data('item-id');
		item.remove();
		
		// Update the add-to-cart button
		$('.add-to-cart').each(function() {
			if($(this).data('item-id') == itemId) {
				var $button = $(this),
					$buttonText = $button.find('span:first'),
					$buttonIcon = $button.find('i:first');
					
				$button.removeClass('added');
				$buttonText.html('Add to Cart')
				$buttonIcon.removeClass('fa-check-circle');
			}
		});
		
		// Remove this item from the stage 2 list
		$('.small-item-list li').each(function() {
			if($(this).data('item-id') == itemId) {
				var $button = $(this);
				$button.remove();
			}
		});
			
		$.post(Util.getAjaxPath(), {'action': 'remove_item', 'item_id': itemId}, function(data) {
			//console.dir(data);
			var dataJSON = $.parseJSON(data);
			priv.$cartContainer.find('.total-price').html(dataJSON.formattedTotalPrice);
			pub.items = dataJSON.items;
			pub.numItems = dataJSON.numItems;
			pub.totalPrice = dataJSON.totalPrice;
			
			if(pub.numItems == 0) {
				setTimeout(function() {
					pub.hideCart();
				}, 500);
			}
		});
	}
	pub.updateQty = function(inp) {
		// Hide the bottom section on mobile to free up 
		// some space
		/*
		if(Util.isMobile) {
			$('.bottom-wrap:first').hide();
			$('.stage-1').addClass('extend-bottom');
			priv.overlapEval();
		}
		*/
		
		// Unbind everything on blur
		inp.on('blur', function() {
			/*
			if(Util.isMobile) {
				setTimeout(function() {
					$('.bottom-wrap:first').show();
					$('.stage-1').removeClass('extend-bottom');
					priv.overlapEval();				
				}, 1000);

			}
			*/
			
			var qty = parseInt(inp.val()),
				itemId = inp.data('item-id');

			if(qty < 1 || isNaN(qty)) {
				qty = 1;
			}
			inp
				.val(qty)
				.off('blur');
			$.post(Util.getAjaxPath(), {'action': 'update_qty', 'item_id': itemId, 'item_qty': qty}, function(data) {
				var dataJSON = $.parseJSON(data);
				priv.$cartContainer.find('.total-price').html(dataJSON.formattedTotalPrice);
				pub.totalPrice = dataJSON.totalPrice;
			});
		});
	}

	// Private variables & methods
	var priv = {};
	priv.hasInit = false;
	priv.init = function(callback) {
		// Create elements
		priv.$cartContainer = $('<div class="cart-container"></div>');
		// Add .body-inner, wrap inside the body tag
		$('body').wrapInner('<div class="body-inner"></div>');
		priv.$bodyInner = $('.body-inner:first');
		
		// Add things in .body-inner
		// Add .cart-container
		priv.$bodyInner.prepend(priv.$cartContainer);
		
		// Add things to the body
		// Add .body-overlay
		priv.$bodyOverlay = $('<div class="body-overlay"></div>');
		$('body').prepend(priv.$bodyOverlay);
		
		// Add .cart-notification
		priv.$cartNotification = $('<a href="#" class="cart-notification">Shopping Cart<span>' + pub.numItems + '</span></a>');
		$('body').prepend(priv.$cartNotification);
		
		// Now init() has run
		priv.hasInit = true;
		
		callback();
	}
	priv.getCart = function(callback) {
		// Make sure that init() has run first!
		if(!priv.hasInit) {
			priv.init(function() {
				priv.getCart()
			});
			return;
		}

		
		
		$.post(Util.getAjaxPath(), {'action': 'get_cart'}, function(data) {
			//console.dir(data);
			var dataJSON = $.parseJSON(data);
			priv.$cartContainer.html(dataJSON.html);
			pub.items = dataJSON.items;
			pub.numItems = dataJSON.numItems;
			pub.totalPrice = dataJSON.totalPrice;
			
			if(pub.numItems > 0) {
				setTimeout(function() {

					

					priv.$cartNotification.find('span:first').html(pub.numItems);
					priv.$cartNotification.addClass('on-screen');
				}, 500);			
			}

			// Run the callback function
			if(typeof callback == 'function') {
				callback();
			}
		});
	}
	priv.overlapEval = function() {
		if(typeof priv.jScrollPane != 'undefined') {
			for(var i=0; i<priv.jScrollPane.length; i++) {
				priv.jScrollPane[i].reinitialise();
			}
		}
		
		if(($('.stage-1-inner').height() + 20) > $('.stage-1').height()) {
			$('.stage-1-wrap').addClass('overlap');
		} else {
			$('.stage-1-wrap').removeClass('overlap');
		}
	}
	
	// Event bindings
	$(document).ready(function() {
		// Are there items in the cart already?
		var numItems = $('#num-cart-items').val();
		if(numItems > 0) {
			priv.getCart();
		}
	});
	$(document).on('click', '.add-to-cart', function() {
		var $button = $(this),
			$buttonText = $button.find('span:first'),
			$buttonIcon = $button.find('i:first'),
			itemId = $button.data('item-id');
		
		if($button.hasClass('added')) {
			// The item has already been added
			pub.viewCart();
			return;
		}
		
		// Add item to cart
		pub.addToCart(itemId, function() {
			// View the cart
			pub.viewCart(true);
		});

		// Style the add-to-cart button
		$button.addClass('loading');
		$buttonText.html('Adding');
		$buttonIcon.addClass('fa fa-refresh fa-spin');
		setTimeout(function() {
			$button.removeClass('loading').addClass('added');
			$buttonText.html('Added')
			$buttonIcon
				.removeClass('fa-refresh fa-spin')
				.addClass('fa-check-circle');
		}, 2000);
		
	});
	$(window).on('resize', function() {
		priv.overlapEval();
	});
	$(document).on('click', '.btn-checkout', function() {
		$('.cart-container .cart').addClass('offset-stage-2');
	});
	$(document).on('click', '.btn-back, .body-overlay, .btn-finish', function() {
		pub.back();
	});
	$(document).on('click', '.cart-notification', function() {
		// Hide .cart-notification
		priv.$cartNotification.removeClass('on-screen');
		
		setTimeout(function() {
			pub.viewCart(false);
		}, 500);
	});	
	
	$(document).on('focus', '.details .quantity', function(e) {
		var curTop = $('.stage-1 .jspPane:first').css('top');
		setTimeout(function() {
			$('.stage-1 .jspPane:first').css({
				'top': curTop
			});
		}, 50);
		
		var inp = $(this);
		pub.updateQty(inp);
	});
	$(document).on('click', '.cart-item-wrap .remove', function() {
		var item = $(this).parent().parent();
		pub.removeItem(item);	
	});
	$(document).on('click', '.btn-clear', function() {
		$('.cart-item-wrap').each(function() {
			pub.removeItem($(this));
		});
	});
	
	// Return public vars
	return pub;
})();

var Payment = (function() {
	var pub = {};
	
	Stripe.setPublishableKey('pk_test_xD6s3jGWQM5y4Ck7tpgbekEi');

	pub.stripeResponseHandler = function(status, response) {
		var $form = $('#pmt-form');
		$('input[type="text"]').removeClass('error');
		//console.log(status);
		//console.log(response);
		if (response.error) {
			// Remove processing styles on the pay button
			var $button = $('.btn-pay');
				$button
					.removeClass('active-processing')
					.addClass('active-pay');
			
			// Show the errors on the form
			$form.find('.payment-errors')
				.text(response.error.message)
				.show();
			$('.btn-pay').removeClass('disabled');
			
			switch(response.error.code) {
				case 'invalid_expiry_month':
				case 'invalid_expiry_year':
					$('input[type="text"].exp-field:first').addClass('error');
					break;
				case 'card_declined':
				case 'incorrect_number':
				case 'invalid_number':
				case 'expired_card':
				case 'card_declined':
				case 'processing_error':
					$('input[type="text"].number-field:first').addClass('error');
					break;
				case 'invalid_cvc':
				case 'incorrect_cvc':
					$('input[type="text"].cvc-field:first').addClass('error');
					break;
			}
		} else {
			// token contains id, last4, and card type
			var token = response.id,
				email = $('.email-field:first').val();
		
			$.post(Util.getAjaxPath(), {'action': 'checkout', 'token': token, 'email': email}, function(data) {

				var dataJSON = $.parseJSON(data),
					$button = $('.btn-pay');
				
				
					
				if(dataJSON.status == 'complete') {
					var email = dataJSON.email;

					$button
						.removeClass('active-processing')
						.addClass('active-completed');
					
					// Slide to stage 3
					$form.find('.payment-errors').hide();
					$('.cart-container .cart')
						.addClass('offset-stage-3')
						.removeClass('offset-stage-2');
				} else {

					// The card has been declined
					$('input[type="text"].number-field:first').addClass('error');

					$button
						.removeClass('active-processing')
						.addClass('active-pay');

					$form.find('.payment-errors')
						.text(dataJSON.message)
						.show();
					$('.btn-pay').removeClass('disabled');
					$('input[type="text"]').removeClass('error');
					$('input[type="text"].number-field:first').addClass('error');
				}
			});
		}
	};	
	
	var priv = {};
	
	// Event bindings
	$(document).on('keyup', '.exp-field', function(e) {
		var inp = $(this),
			inpVal = inp.val(),
			key = e.which;
		
		// Is the delete key pressed?
		if(key == 8) {
			return;
		}

		// Is the key pressed a number?
		if((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			
			if(inpVal.indexOf('/') == -1) {
				if(inpVal.length == 2) {
					inp.val(inpVal + '/');
				} else if(inpVal.length > 2) {
					var first = inpVal.substr(0, 2),
						lastLength = (inpVal.length-2 < 5 ? inpVal.length-2 : 4),
						last = inpVal.substr(2, lastLength);
					inp.val(first + '/' + last);
				}
			}
		} else {
			// Remove the last character (it was not a number)
			inp.val(inpVal.substr(0,inpVal.length-1));
		}
		inpVal = inp.val();
		
		// Set some stripe vars
		if(inpVal.length > 2 && inpVal.indexOf('/') != -1) {
			var dateVals = inpVal.split('/'),
				expMonth = parseInt(dateVals[0]),
				expYear = parseInt(dateVals[1]) || '';
			
			$('input.exp-month[type="hidden"]:first').val(expMonth);
			$('input.exp-year[type="hidden"]:first').val(expYear);
		} else {
			$('input.exp-month[type="hidden"]:first').val(inpVal);
			$('input.exp-year[type="hidden"]:first').val('');
		}

	});
	$(document).on('click.form-submit', '.btn-pay', function() {
		var $form = $('#pmt-form'),
			email = $form.find('.email-field:first').val(),
			$button = $(this);
		
		// Do nothing if the button is disabled
		if($button.hasClass('disabled')) {
			return;
		}
		
		// Simple email validation
		// Note: card validation happens in stripeResponseHandler()
		if(email.indexOf('@') == -1) {
			$form.find('.payment-errors')
				.text('You must provide a valid email')
				.show();
			$('input[type="text"]').removeClass('error');	
			$('input[type="text"].email-field:first').addClass('error');
			return;
		}
		
		// Style the button, set to disabled so the user
		// can't rapid fire click
		$button
			.removeClass('active-pay')
			.addClass('active-processing disabled');

    Stripe.card.createToken($form, pub.stripeResponseHandler);

    // Prevent the form from submitting with the default action
    return false;
  });
	
	// Return public vars
	return pub;
})();











/*
var Template = (function() {
	var pub = {};
	
	// Event bindings
	
	
	// Return public vars
	return pub;
})();


var Test = (function() {
	var pub = {},
		priv = {};
	
	pub.func = function() {
		alert(priv.yo);
	}
	
	// Event bindings
	$(function() {
		priv.yo = 'yod';
		pub.func();
	});
	
	// Return public vars
	return pub;
})();
*/