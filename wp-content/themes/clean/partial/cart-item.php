<?php 
	// Are we printing a newly added item or the list of existing items?
	$cart = Cart::get_cart();
	
	/*
	if($item = $cart->has_new_item()) {
		$items = array($item);
		$add_item = true;
		// Start the buffer
		ob_start();
	} else {
		$items = $cart->items;
		$add_item = false;
	}
	*/
	
	/*
	if($item = $cart->has_new_item()) {
		$print_items = true;
		// Start the buffer
		ob_start();
	} else {
		$print_items = false;
	}
	*/

	foreach($cart->items as $item):
?>	
<div class="cart-item-wrap clearfix" data-item-id="<?php echo $item->id; ?>">
	<div class="cart-title-container">
		<a href="#" class="remove fa fa-times"></a>
		<h4><?php echo $item->title; ?></h4>
	</div>
	<div class="cart-details-container clearfix">
		<img src="<?php echo $item->image; ?>" />
		<div class="details">
			<div class="line top clearfix">
				<span class="field">Price:</span><span class="value price"><?php echo $item->formatted_price; ?></span>
			</div>
			<div class="line">
				<span class="field">Quantity:</span><span class="value"><input class="quantity" type="text" maxlength="2" data-item-id="<?php echo $item->id; ?>" value="<?php echo $item->qty; ?>" /></span>
			</div>
		</div>
	</div>
</div>
<?php endforeach; 

	/*
	if($print_items) {
		$html = ob_get_clean();
		$data = array(
			'html' => $html,
			'items' => $cart->items,
			'totalPrice' => $cart->total_price,
			'numItems' => $cart->num_items
		);
		die(json_encode($data));
	}
	*/
?>
