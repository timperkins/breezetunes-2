<?php
/**
 * Template Name: Homepage
 *
 */

get_header(); ?>

<?php

	$sheet_item_nums = array();
	if(is_local()) {
		$sheet_item_nums = [354, 349];
	} else {
		$sheet_item_nums = [378, 352];	
	}

	$sheet_items = array();
	foreach($sheet_item_nums as $num) {
		$sheet_items[] = Item::find_by_id($wpdb, $num);
	}

	$cart = Cart::get_cart();

?>

	<section class="main-highlight-wrap wrap-border dark">
		<div class="main-highlight">
			
				<div class="clearfix">
					<div class="bio-pic">
						<img src="<?php echo get_template_directory_uri(); ?>/images/garrett.jpg" />
					</div>
					
					<div class="content">
						<div class="content-inner">
							<h1>Hi, I'm Garrett Breeze.</h1>
							<p class="section-description">I am a composer, arranger, trombonist, music copyist, and graduate of Brigham Young University's Commercial Music program.</p>
							<div class="demo-reel-wrap light">
								<div id="jp-item-demo" class="jp-jplayer jp-audio-item" data-item-id="demo" data-mp3="<?php echo get_template_directory_uri(); ?>/reel.mp3" data-swf-path="<?php echo get_template_directory_uri(); ?>/extras"></div>
								<?php //<div id="jp-demo-reel" class="jp-jplayer"></div> ?>
								<div id="jp-item-demo-container" class="demo-reel audio-player">
									<p>Garrett Breeze - Composition, Arranging, and Production Reel</p>
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
		<img src="<?php echo get_template_directory_uri(); ?>/images/wood-floor.jpg" class="bg" />
	</section>
	<section class="main-show-wrap wrap-border">
		<div class="main-show">
			<div class="clearfix">
				<div class="content">
					<div class="content-inner">
						<h2>Show Choir Arrangements</h2>
						<p class="section-description">Breeze Tunes Productions specializes in creating high-quality, competitive arrangements tailored to fit your choir's show design, skill level, and budget!</p>
						<a href="/show-choir-arrangements" class="btn btn-green clearfix">Learn More</a>
					</div>
				</div>
				<div class="video-player-small">
					<iframe width="300" height="169" src="//www.youtube.com/embed/MDaH8oTNjMY?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
				<div class="video-player-large">
					<iframe width="400" height="225" src="//www.youtube.com/embed/MDaH8oTNjMY?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>				
			</div>
		</div>
	</section>
	<section class="main-media-wrap wrap-border dark">
		<div class="main-media">
			<div class="content">
				<div class="content-inner">
					<h2>Media Composition</h2>
					<p class="section-description">Equally comfortable composing for the big screen, the studio, or the concert hall, Garrett Breeze brings an energetic and emotional voice to each project.</p>
					<a href="/media-composition" class="btn btn-green clearfix">Hear Examples</a>
				</div>
			</div>			
		</div>
	</section>
	<section class="main-testimonial-wrap wrap-border">
		<div class="main-testimonial">
			<div class="content">
				<blockquote>"Garrett's prices are affordable, and he knows how to revamp a popular tune to make it more accessible to show choirs!"</blockquote>
				<span class="person-quoted">- Garrett Lindsay<br><small>Music Director of the University 
<br>of Alabama "Resonance"</small></span>
			</div>			
		</div>
	</section>
	<section class="main-sheet-music-wrap wrap-border">
		<div class="main-sheet-music">
			<div class="main-sheet-music-inner clearfix">
				<aside class="sidebar clearfix dark">
					<div class="sidebar-inner">
						<div class="sidebar-container">
							<h3 class="from-the-blog">From the Blog</h3>
							<div class="blog-img">
								<img src="<?php echo get_template_directory_uri(); ?>/images/blog-img.png" />
							</div>
							<div class="blog-snippet">
								<div class="blog-snippet-inner">
									<h4 class="blog-title">Orchestration for Variety</h4>
									<span class="blog-author">By: Garrett Breeze</span>
									<p class="blog-content">Do you have an orchestra or a show band that’s smaller than you’d like?  To quote a mentor of mine: “We didn’t hire our keyboard player to only use 1 hand.”  If ensemble is small, use each player as much as you can, even if they would have more rests in a larger group.</p>
									<a target="_blank" href="http://musicarranging.net/" class="btn btn-darkgray clearfix">Continue Reading</a>
								</div>
							</div>
						</div>
					</div>
				</aside>
				<div class="content">
					<div class="content-inner">
						<h2>Sacred Music</h2>
						<p class="section-description">Browse our catalog of choral and instrumental sheet music suitable for use in LDS/Christian worship services.</p>


						<?php foreach($sheet_items as $item): ?>
							<div class="sheet-item-wrap">
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


						<?php /*
						<div class="sheet-item-wrap">
							<div class="sheet-item">
								<div class="sheet-item-inner clearfix">
									<div class="image-section">
										<a href="#" class="view-front"><img src="<?php echo get_template_directory_uri(); ?>/images/item-img.jpg" /></a>
										<a href="#" class="view-front-btn">View Front Page</a>
									</div>
									<div class="item-content">
										<div class="item-content-inner">
											<h3 class="item-title">There is a Green Hill Far Away (SATTBB)</h3>
											<div class="price-section clearfix">
												<span class="price">$1.98</span>
												<a href="#" class="add-to-cart" data-item-id="2"><span>Add to Cart</span><i></i></a>
											</div>
											<p class="item-description">A favorite of the BYU Young Ambassadors performed in firesides all over the world. Hymn arrangement in 5/4. SATB except for one verse of TTBB. Free recording available from BYU Singers (singersalumni.com)</p>
											<div id="jp-item-1" class="jp-jplayer jp-audio-item" data-item-id="1" data-m4a="http://www.jplayer.org/audio/m4a/Miaow-02-Hidden.m4a" data-oga="http://www.jplayer.org/audio/ogg/Miaow-02-Hidden.ogg" data-swf-path="<?php echo get_template_directory_uri(); ?>/extras"></div>
											<div id="jp-item-1-container" class="audio-player">
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
						<div class="sheet-item-wrap">
							<div class="sheet-item">
								<div class="sheet-item-inner clearfix">
									<div class="image-section">
										<a href="#" class="view-front"><img src="<?php echo get_template_directory_uri(); ?>/images/item-img.jpg" /></a>
										<a href="#" class="view-front-btn">View Front Page</a>
									</div>
									<div class="item-content">
										<div class="item-content-inner">
											<h3 class="item-title">There is a Green Hill Far Away (SATTBB)</h3>
											<div class="price-section clearfix">
												<span class="price">$1.98</span>
												<a href="#" class="add-to-cart" data-item-id="2"><span>Add to Cart</span><i></i></a>
											</div>
											<p class="item-description">A favorite of the BYU Young Ambassadors performed in firesides all over the world. Hymn arrangement in 5/4. SATB except for one verse of TTBB. Free recording available from BYU Singers (singersalumni.com)</p>
											<div id="jp-item-2" class="jp-jplayer jp-audio-item" data-item-id="2" data-m4a="http://www.jplayer.org/audio/m4a/Miaow-07-Bubble.m4a" data-oga="http://www.jplayer.org/audio/ogg/Miaow-07-Bubble.ogg" data-swf-path="<?php echo get_template_directory_uri(); ?>/extras"></div>
											<div id="jp-item-2-container" class="audio-player">
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
						*/ ?>
						<a href="/sacred-music" class="btn btn-green clearfix">See More</a>
					</div>	
				</div>	
			</div>
		</div>
	</section>

<?php
get_footer();
