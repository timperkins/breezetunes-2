<?php
/**
 * Template Name: Default
 *
 */

get_header(); ?>
	
<section class="default-wrap wrap-border">
	<div class="default">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
				echo "<h1>";
				the_title();
				echo "</h1>";
				the_content();
			endwhile;
		?>
		<br><br>
	</div>
</section>

<?php
get_footer();
