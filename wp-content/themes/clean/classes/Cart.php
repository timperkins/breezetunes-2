<?php 
	class Cart {
		private static $instance = null;
		public $items = array();
		public $num_items = 0;
		public $total_price = 0;
		public $formatted_total_price = '$0.00';
		public $status = "Unpaid";

		private function __construct() {
			
		}
		public static function get_cart() {
			//lg('sesh');
			//lg($_SESSION);
			if (empty(self::$instance)) {
				self::$instance = new self;
				if(!empty($_SESSION['cart']['items'])) {
					$items = $_SESSION['cart']['items'];
					foreach($items as $item) {
						self::$instance->add_to_cart($item);
					}
					self::$instance->update_totals();
				} 
			}
			return self::$instance;
		}
		public function add_to_cart($item) {
			// here
			if(!empty($this->items[$item->id])) {
				// This item has already been added to the cart
				return;
			}
			
			// We don't need every attribute from $item,
			// so let's put some in a new class
			$cartItem = new stdClass;
			$cartItem->id = $item->id;
			$cartItem->title = $item->title;
			$cartItem->price = $item->price;
			$cartItem->image = $item->image;
			$cartItem->qty = isset($item->qty) ? $item->qty : 1; 
			$fmpr = number_format($cartItem->price * 0.01, 2);
			$cartItem->formatted_price = '$' . $fmpr; 
			
			$this->items[$item->id] = $cartItem;
			//$this->tmp_new_item = $cartItem;
			$this->save_to_session();
			
			// Update some of the instance vars
			$this->update_totals();
		}
		public function update_qty($item_id, $qty) {
			if(!empty($this->items[$item_id])) {
				$this->items[$item_id]->qty = $qty;
				$this->save_to_session();
				$this->update_totals();
			}
		}
		public function remove($item_id) {
			lg(1);
			if(!empty($this->items[$item_id])) {
				lg(2);
				unset($this->items[$item_id]);
				$this->save_to_session();
				$this->update_totals();
			}
		}
		public function has_item($item_id) {
			return !empty($this->items[$item_id]);
		}
		/*
		public function has_new_item() {
			if(isset($this->tmp_new_item)) {
				$item = $this->tmp_new_item;
				unset($this->tmp_new_item);
				return $item;
			} 
			return false;
		}
		*/
		private function update_totals() {
			$this->total_price = 0;	
			$this->num_items = 0;	
			foreach($this->items as $item) {
				$this->total_price += ($item->price * $item->qty);
				$this->num_items++;
			}
			$in_dollars = number_format($this->total_price * .01, 2);
			$this->formatted_total_price = '$' . $in_dollars;
		}
		private function save_to_session() {
			$_SESSION['cart']['items'] = $this->items;
			/*
			foreach($this->items as $item) {
				$_SESSION['cart'][] = array(
					'id' => $item->id,
					'title' => $item->id,
					'price' => $item->id,
					'qty' => $item->qty
				);
			}
			*/
			//$_SESSION['cart'] = $this;
		}

		public function checkout() {
			// TODO: Save to db
			
			
			// Remove the cart items from the session
			$this->items = array();
			$this->save_to_session();


		}
		
		/*
		public function get_formatted_total_price() {
			$in_dollars = $this->total_price * .01;
			return '$' . $in_dollars;
		}
		*/
	}

	
?>