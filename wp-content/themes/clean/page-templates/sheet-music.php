<?php
/**
 * Template Name: Sheet Music
 *
 */
get_header(); ?>

<?php
	$sheet_items = Item::find_all($wpdb);
	$cart = Cart::get_cart();
?>

	<section class="main-sheet-music-wrap js-music-list wrap-border">
		<div class="main-sheet-music">
			<div class="main-sheet-music-inner clearfix">
				<aside class="sidebar clearfix music-filter-sidebar">
					<div class="sidebar-inner">
						<div class="sidebar-container">
							<h3>Filter Results:</h3>
							<div class="sidebar-filter-options">
								<!-- js-populated -->
							</div>
						</div>
					</div>
				</aside>
				<div class="content">
					<div class="content-inner">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<h2><?php echo the_title(); ?></h2>
							<div class="section-description">
								<?php the_content(); ?>
							</div>
						<?php endwhile; ?>
						<?php endif; ?>
						<?php foreach($sheet_items as $item): ?>
							<div class="sheet-item-wrap" data-tags="<?php echo $item->tag_names(); ?>">
								<div class="sheet-item">
									<div class="sheet-item-inner clearfix">
										<div class="image-section">
											<a href="<?php echo $item->front_page; ?>" class="view-front" target="_blank"><?php /* <img src="<?php echo get_template_directory_uri(); ?>/images/item-img.jpg" /> */ ?><img src="<?php echo $item->image; ?>" /></a>
											<a href="<?php echo $item->front_page; ?>" class="view-front-btn" target="_blank">View Front Page</a>
										</div>
										<div class="item-content">
											<div class="item-content-inner">
												<h3 class="item-title"><?php echo $item->title; ?></h3>
												<div class="price-section clearfix">
													<span class="price"><?php echo $item->get_formatted_price(); ?></span>
													<?php if($cart->has_item($item->id)): ?>
														<a href="#" class="add-to-cart added" data-item-id="<?php echo $item->id; ?>"><span>Added</span><i class="fa fa-check-circle"></i></a>
													<?php else: ?>
														<a href="#" class="add-to-cart" data-item-id="<?php echo $item->id; ?>"><span>Add to Cart</span><i></i></a>
													<?php endif; ?>
												</div>
												<p class="item-description"><?php echo $item->description; ?></p>
												<?php /* <div id="jp-item-1" class="jp-jplayer jp-audio-item" data-item-id="1" data-m4a="http://www.jplayer.org/audio/m4a/Miaow-02-Hidden.m4a" data-oga="http://www.jplayer.org/audio/ogg/Miaow-02-Hidden.ogg" data-swf-path="<?php echo get_template_directory_uri(); ?>/extras"></div> */ ?>
												<div id="jp-item-<?php echo $item->id; ?>" class="jp-jplayer jp-audio-item" data-item-id="<?php echo $item->id; ?>" data-mp3="<?php echo $item->music_file; ?>" data-swf-path="<?php echo get_template_directory_uri(); ?>/extras"></div>
												<div id="jp-item-<?php echo $item->id; ?>-container" class="audio-player">
													<div class="controls clearfix">
														<a href="#" class="jp-play item"><i class="fa fa-play"></i></a>
														<a href="#" class="jp-pause item"><i class="fa fa-pause"></i></a>
														<div class="play-section item">
															<div class="jp-progress">
																<div class="jp-seek-bar">
																	<div class="jp-play-bar"></div>
																</div>
															</div>
															<p class="time"><span class="jp-current-time"></span> / <span class="jp-duration"></span></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>	
				</div>	
			</div>
		</div>
	</section>

<?php
get_footer();
