<?php
	class Item {
		public $id;
		public $title;
		public $filename;
		public $price;
		public $description;
		public $featured;
		private static $list = array();
		public static function find_all($wpdb) {
			if(!empty(self::$list)) {
				return self::$list;
			}

			$args = array(
				'post_type' => 'music', 
				'posts_per_page' => 100, 
				'orderby' => 'title', 
				'order' => 'ASC',
			);
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
				
				// print_array(get_field('image'));
				$item = new self;
				$item->id = get_the_ID();
				$item->title = get_the_title();

				// Record the price in cents
				$item->price = get_field('price') * 100;

				$item->description = get_field('description');
				$item->music_file = get_field('music_file');
				$item->front_page = get_field('front_page');
				$item->image = get_field('image')['sizes']['thumbnail'];
				$item->featured = false;

				self::$list[$item->id] = $item;

			endwhile;
			



			/*
			$sql = 'SELECT id, title, filename, price, description, featured'
				. ' FROM item'
				. ' ORDER BY title';
			$items_ar = $wpdb->get_results($sql, ARRAY_A);

			foreach($items_ar as $item_ar) {
				$item = new self;
				$item->id = $item_ar['id'];
				$item->title = $item_ar['title'];
				$item->filename = $item_ar['filename'];
				$item->price = $item_ar['price'];
				$item->description = $item_ar['description'];
				$item->featured = $item_ar['featured'];
				self::$list[$item->id] = $item;
			}
			*/
			 return self::$list;
		}
		public static function find_by_id($wpdb, $id) {
			if(!empty(self::$list[$id])) {
				
				return self::$list[$id];
			}

			// echo $id;
			$args = array(
				'p' => $id,
				'post_type' => 'music', 
				'posts_per_page' => 2,
				'orderby' => 'title', 
				'order' => 'ASC',
			);
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
				$item = new self;
				$item->id = get_the_ID();
				$item->title = get_the_title();

				// Record the price in cents
				$item->price = get_field('price') * 100;

				$item->description = get_field('description');
				$item->music_file = get_field('music_file');
				$item->front_page = get_field('front_page');
				$item->image = get_field('image')['sizes']['thumbnail'];
				$item->featured = false;
				self::$list[$item->id] = $item;

			endwhile;

			return $item;

			/*
			$sql = 'SELECT id, title, filename, price, description, featured'
				. ' FROM item'
				. ' WHERE id=' . $id;
			$item_ar = $wpdb->get_row($sql, ARRAY_A);
			$item = new self;
			$item->id = $item_ar['id'];
			$item->title = $item_ar['title'];
			$item->filename = $item_ar['filename'];
			$item->price = $item_ar['price'];
			$item->description = $item_ar['description'];
			$item->featured = $item_ar['featured'];
			self::$list[$item->id] = $item;
			return $item;
			*/
		}
		public function get_formatted_price() {
			if($this->price == 0) {
				return 'FREE';
			}

			$in_dollars = $this->price * .01;
			return '$' . $in_dollars;
		}
	}
?>