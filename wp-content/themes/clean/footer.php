<?php
/**
 * The template for displaying the footer
 */
?>
		<section class="social-wrap wrap-border dark">
			<div class="social">
				<div class="content">
					<ul class="social-icons clearfix">
						<li><a target="_blank" href="https://www.facebook.com/BreezeTunes" class="facebook"></a></li>
						<li><a target="_blank" href="https://twitter.com/BreezeTunes" class="twitter"></a></li>
						<li><a target="_blank" href="https://www.linkedin.com/pub/garrett-breeze/25/47/a20" class="linkedin"></a></li>
						<li><a target="_blank" href="http://www.youtube.com/user/BreezeTunes" class="youtube"></a></li>
						<li><a href="#" class="rss"></a></li>
					</ul>	
				</div>
			</div>
			<div class="diagonal-bottom-wrap"></div>
		</section>	
		<footer>
			<div class="menu-wrap dark wrap-border">
				<div class="menu">
					<div class="menu-inner">
						<ul>
							<li class="first">
								<h2>Music</h2>
								<ul>
									<li><a href="/show-choir">Show Choir Arrangements</a></li>
									<li><a href="/media-composition">Media Composition</a></li>
									<li><a href="/sacred-music">Sacred Music</a></li>
									<li><a href="https://soundcloud.com/breeze-tunes-productions">Demo Reel</a></li>
								</ul>
							</li>
							<li>
								<h2>Portfolio</h2>
								<ul>
									<li><a href="/discography">Discography</a></li>
									<li><a href="/filmography">Filmography</a></li>
									<li><a href="/show-choir-clients">Show Choir Clients</a></li>
									<li><a href="/stage-productions">Stage Productions</a></li>
									<li><a href="/concert-works">Concert Works</a></li>
									<li><a href="/corporate-media">Corporate Media</a></li>
								</ul>
							</li>
							<li>
								<h2>About</h2>
								<ul>
									<li><a href="/biography">Biography</a></li>
									<li><a href="http://musicarranging.net/">Blog</a></li>
									<li><a href="/contact">Contact Me</a></li>
								</ul>
							</li>
						</ul>
					</div>		
				</div>
			</div>
			<input type="hidden" id="ajax-path" value="<?php echo admin_url('admin-ajax.php'); ?>" />
			<?php $cart = Cart::get_cart(); ?>
			<input type="hidden" id="num-cart-items" value="<?php echo $cart->num_items; ?>" />
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>