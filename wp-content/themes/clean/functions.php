<?php 
	
	require_once(get_template_directory() . '/extras/stripe/lib/Stripe.php');
	  
	// Cart functions
	function get_cart() {
		get_template_part('partial/cart', 'content');
		return;
	}
	add_action('wp_ajax_get_cart', 'get_cart');
	add_action('wp_ajax_nopriv_get_cart', 'get_cart');

	function add_cart_item() {
		global $wpdb;
		
		$item_id = $_POST['item_id'];
		$item = Item::find_by_id($wpdb, $item_id);
		$cart = Cart::get_cart();
		$cart->add_to_cart($item);
		
		get_template_part('partial/cart', 'content');
		return;
	}
	add_action('wp_ajax_add_cart_item', 'add_cart_item');
	add_action('wp_ajax_nopriv_add_cart_item', 'add_cart_item');
	
	function update_qty() {
		$item_id = $_POST['item_id'];
		$item_qty = $_POST['item_qty'];
		$cart = Cart::get_cart();
		$cart->update_qty($item_id, $item_qty);
		$data = array(
			'formattedTotalPrice' => $cart->formatted_total_price,
			'totalPrice' => $cart->total_price
		);
		die(json_encode($data));
	}
	add_action('wp_ajax_update_qty', 'update_qty');
	add_action('wp_ajax_nopriv_update_qty', 'update_qty');
	
	function remove_item() {
		$item_id = $_POST['item_id'];
		$cart = Cart::get_cart();
		$cart->remove($item_id);
		$data = array(
			'formattedTotalPrice' => $cart->formatted_total_price,
			'items' => $cart->items,
			'totalPrice' => $cart->total_price,
			'numItems' => $cart->num_items
		);
		lg('price');
		lg($cart->formatted_total_price);
		die(json_encode($data));
	}
	add_action('wp_ajax_remove_item', 'remove_item');
	add_action('wp_ajax_nopriv_remove_item', 'remove_item');
	
	function checkout() {
		$cart = Cart::get_cart();
		Stripe::setApiKey("sk_test_8299MI1Fwu0veIaz1towC1Nf");

		// Get the credit card details submitted by the form
		$token = $_POST['token'];
		$email = $_POST['email'];

		// Create the charge on Stripe's servers - this will charge the user's card
		try {
			$charge = Stripe_Charge::create(
				array(
					"amount" => $cart->total_price, // amount in cents, again
					"currency" => "usd",
					"card" => $token,
					"description" => $email
				)
			);
			
			// Return vars
			$data = array(
				'status' => 'complete',
				'email' => $email,
				'formattedTotalPrice' => $cart->formatted_total_price
			);
			
			// Update cart status
			$cart->status = 'Paid';
			
			// Email music, clear the cart, etc
			$cart->checkout();
			
		} catch(Stripe_CardError $e) {
			// The card has been declined
			$data = array(
				'status' => 'error',
				'message' => 'Your card has been declined.'
			);
		}
		die(json_encode($data));
	}
	add_action('wp_ajax_checkout', 'checkout');
	add_action('wp_ajax_nopriv_checkout', 'checkout');	
	
	// Remove dumb stuff from wp_head
	function clean_header(){
		//remove_filter( 'the_content', 'wpautop' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
		remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
		remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
		remove_action( 'wp_head', 'index_rel_link' ); // index link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
		remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	}
	function page_start() {
		define(DS, DIRECTORY_SEPARATOR);
		session_start();
		if(!empty($_GET['session']) && $_GET['session'] == 'unset') {
			session_unset();
		}
		
		require_once(get_template_directory() . DS . 'classes' . DS . 'Item.php');
		require_once(get_template_directory() . DS . 'classes' . DS . 'Cart.php');
	}
	add_action('init','clean_header');
	add_action('init','page_start');
	
	function wp_add_head_contents() {
		$tm_uri = get_template_directory_uri();
		
		// Remove default wp scripts
		wp_deregister_script('comment-reply');
		wp_deregister_script('jquery-migrate');
		wp_deregister_script('jquery');
		
		// Remove default wp styles
		wp_deregister_style( 'twentyfourteen-lato' );
		wp_deregister_style( 'twentyfourteen-style' );
		wp_deregister_style( 'twentyfourteen-ie' );
		wp_deregister_style( 'genericons' );
		
		// jQuery
		wp_register_script('jquery', $tm_uri . '/js/jquery-1.11.1.min.js');
		wp_enqueue_script('jquery');
		
		// jPlayer
		wp_register_script('jplayer', $tm_uri . '/js/jquery.jplayer.min.js', array('jquery'));
		wp_enqueue_script('jplayer');		

		// Bootstrap
		wp_register_script('bootstrap', $tm_uri . '/js/bootstrap.js', array('jquery'));
		wp_enqueue_script('bootstrap');	
	
		// Placeholders.js
		wp_register_script('placeholders', $tm_uri . '/js/placeholders.min.js');
		wp_enqueue_script('placeholders');

		// lodash.js
		wp_register_script('lodash', $tm_uri . '/js/lodash.min.js');
		wp_enqueue_script('lodash');

		// loadmodal.js
		wp_register_script('loadmodal', $tm_uri . '/js/jquery.loadmodal.js', array('jquery', 'bootstrap'));
		wp_enqueue_script('loadmodal');
		
		// stripe.js
		wp_register_script('stripe', 'https://js.stripe.com/v2/');
		wp_enqueue_script('stripe');
		
		// main stuff
		wp_register_script('mainjs', $tm_uri . '/js/main.js', array('jquery', 'jplayer', 'stripe'));
		wp_enqueue_script('mainjs');
		wp_register_style('maincss', $tm_uri . '/css/main-1.0.0.css');
		wp_enqueue_style('maincss');	
		
		// jScrollWheel
		wp_register_style('jscrollcss', $tm_uri . '/css/jquery.jscrollpane.css');
		wp_enqueue_style('jscrollcss');		
		wp_register_script('mousewheel', $tm_uri . '/js/jquery.mousewheel.js', array('jquery'));
		wp_enqueue_script('mousewheel');
		wp_register_script('mwheelIntent', $tm_uri . '/js/mwheelIntent.js', array('jquery'));
		wp_enqueue_script('mwheelIntent');		
		wp_register_script('jscrolljs', $tm_uri . '/js/jquery.jscrollpane.min.js', array('jquery', 'mousewheel', 'mwheelIntent'));
		wp_enqueue_script('jscrolljs');		
		
		
		
		/*
		// Modernizr.js
		wp_register_script('modernizr', $tm_uri . '/js/modernizr.custom.js', array('jquery', 'mainjs'));
		wp_enqueue_script('modernizr');
		*/
		
		// FontAwesome
		wp_register_style('fontawesome', $tm_uri . '/css/font-awesome.css');
		wp_enqueue_style('fontawesome');
	}
	add_action( 'wp_enqueue_scripts', 'wp_add_head_contents' );
	
	function print_array($str) {
		echo "<pre>";
		print_r($str);
		echo "</pre>";
	}
	function lg($new_log) {
		$log_file = ABSPATH . "log.txt";
		$log_content = file_get_contents($log_file);
		if(is_array($new_log) || is_object($new_log)) {
			$new_log = print_r($new_log, 1);
		}
		// $newLogContent = $newLog . "\n" . $logContent;
		$new_log_content = $log_content . "\n" . $new_log;
		file_put_contents($log_file, $new_log_content);
	}
	function is_mobile() {
	$useragent=$_SERVER['HTTP_USER_AGENT'];
		return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
	}

	function is_local() {
		if(strpos($_SERVER[HTTP_HOST], '.local') !== false) {
			return true;
		}
		return false;
	}
	
?>