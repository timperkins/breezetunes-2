<?php
	$cart = Cart::get_cart();
	// lg('cart');
	// lg($cart);
	/*
	$_SESSION['cart']['items'] = array(
		array(
			'id' => 1,
			'title' => 'There is a Green Hill Far Away',
			'price' => 198,
			'qty' => 1
		),
		array(
			'id' => 3,
			'title' => 'Have Yourself a Merry Little Christmas',
			'price' => 598,
			'qty' => 4
		)
	);
	$_SESSION['cart']['total-price'] = 25.90;
	$_SESSION['cart']['num-items'] = 2;
	*/
	

	// Start reading in the buffer
	// (we'll save this html as $html)
	ob_start();
	// lg('cart');
	// lg($cart);
?>
<div class="cart clearfix">
	<div class="stage-wrap stage-1-wrap">
		<div class="stage stage-1 init jscrollpane">
			<div class="stage-inner stage-1-inner">
				<h2>Shopping Cart</h2>
				<ul class="progress clearfix">
					<li class="circle filled"><span class="fill"></span><span class="connector right"></span></li>
					<li class="circle"><span class="fill"></span><span class="connector left"></span><span class="connector right"></span></li>
					<li class="circle"><span class="fill"></span><span class="connector left"></span></li>
				</ul>
				<div class="cart-items">
					<?php if($cart->num_items > 0) require('cart-item.php'); ?>
				</div>
			</div>
		</div>
		<div class="bottom-wrap">
			<div class="bottom">
				<div class="bottom-inner clearfix">
					<div class="price clearfix">
						<span class="field">Total:</span><span class="value total-price"><?php echo $cart->formatted_total_price; ?></span>
					</div>
					<a href="#" class="btn-checkout btn-green clearfix">Online Checkout</a>
					<div class="split-buttons clearfix">
						<div class="btn-container">
							<a href="#" class="btn-back btn-gray">Back</a>
						</div>
						<div class="btn-container">
							<a href="#" class="btn-clear btn-gray">Clear Cart</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="stage-wrap stage-2-wrap">
		<div class="stage stage-2 init jscrollpane">
			<div class="stage-inner">	
					<h2>Checkout</h2>
					<ul class="progress clearfix">
						<li class="circle filled"><span class="fill"></span><span class="connector right"></span></li>
						<li class="circle filled"><span class="fill"></span><span class="connector left"></span><span class="connector right"></span></li>
						<li class="circle"><span class="fill"></span><span class="connector left"></span></li>
					</ul>
					<ul class="small-item-list">
						<?php foreach($cart->items as $item): ?>
							<li class="clearfix" data-item-id="<?php echo $item->id; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/item-img.jpg" /><span><?php echo $item->title; ?></span></li>
						<?php endforeach; ?>
					</ul>
					<form id="pmt-form">
						<p class="payment-errors"></p>
						
						<div class="input-text-wrap">
							<input class="email-field" type="text" name="email" placeholder="Email" maxlength="50" />
							<p class="input-description">The sheet music will be sent to this email.</p>
						</div>
						<div class="input-text-wrap">
							<input class="number-field" type="text" placeholder="Card Number" data-stripe="number" value="4242424242424242" />
						</div>
						<div class="input-text-wrap col-2 clearfix">
							<div class="input-text-container">
								<div class="input-text">
									<input class="exp-field" type="text" placeholder="MM/YY" maxlength="7" />
									<input class="exp-month" type="hidden" data-stripe="exp-month" />
									<input class="exp-year" type="hidden" data-stripe="exp-year" />
								</div>
							</div>
							<div class="input-text-container">
								<div class="input-text">
									<input class="cvc-field" type="text" placeholder="CVC" maxlength="3" data-stripe="cvc" />
								</div>
							</div>
						</div>
						<a href="#" class="btn-pay btn-green active-pay clearfix"><span class="pay">Pay <span class="total-price"><?php echo $cart->formatted_total_price; ?></span></span><span class="processing">Processing <i class="fa fa-refresh fa-spin"></i></span><span class="completed">Completed <i class="fa fa-check-circle"></i></span></a>
					</form>
					<p class="input-description clearfix"><i class="fa fa-lock"></i><span>Secure payments via Stripe</span></p>
					<div class="split-buttons clearfix">
						<div class="btn-container">
							<a href="#" class="btn-back btn-gray">Back</a>
						</div>
					</div>
				
				
					<!-- <h2>Checkout</h2>
					<p>The system is currently unavailable. Please try again later.</p>
					<div class="split-buttons clearfix">
						<div class="btn-container">
							<a href="#" class="btn-back btn-gray">Back</a>
						</div>
					</div> -->
			
			</div>
		</div>
	</div>
	<div class="stage-wrap stage-3-wrap">
		<div class="stage stage-3 init jscrollpane">
			<div class="stage-inner">	
				<h2>Finished!</h2>
				<ul class="progress clearfix">
					<li class="circle filled"><span class="fill"></span><span class="connector right"></span></li>
					<li class="circle filled"><span class="fill"></span><span class="connector left"></span><span class="connector right"></span></li>
					<li class="circle filled"><span class="fill"></span><span class="connector left"></span></li>
				</ul>
				<p>Thank you for your purchase! An email will be sent to <span class="sent-to-email"></span> with your songs as an attachment.</p>
				<p>If your sheet music does not arrive within 5 minutes or if you have any questions, please shoot us an email at sales@breezetunes.com.</p>
				<p>Order Number: <span class="order-number"></span></p>
				<p>Amount Charged: <span class="amount-charged"></span></p>
				<a href="#" class="btn-finish btn-green clearfix">Done!</a>
			</div>
		</div>
	</div>
</div>
<?php 
	// $html is the previous html stored in a buffer variable
	$html = ob_get_clean();
	$data = array(
		'html' => $html,
		'items' => $cart->items,
		'totalPrice' => $cart->total_price,
		'numItems' => $cart->num_items
	);
	die(json_encode($data));

?>	
	
