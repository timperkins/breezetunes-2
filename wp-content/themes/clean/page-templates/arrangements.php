<?php
/**
 * Template Name: Arrangements
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

				$arrangements = array(
					'ballads' => 'Ballads',
					'mash-ups' => 'Mash-Ups',
					'medleys' => 'Medleys',
					'rock-songs' => 'Rock Songs',
					'jazz-songs' => 'Jazz Songs',
					'pop-songs' => 'Pop Songs'
				);

				foreach($arrangements as $slug => $title):
					echo "<br><br>";
					echo "<h3>" . $title . "</h3>";
					echo '<table class="arrangements-table">';
					$args = array(
						'post_type' => 'arrangement',
						'category' => $slug,
						'posts_per_page' => 100,
						'orderby' => 'title',
						'order' => 'ASC'
					);
					$loop = new WP_Query( $args );
					echo "<tr>";
						echo "<th>Song Title</th>";
						echo "<th>Performing Artist</th>";
						echo "<th>Current Voicing</th>";
						echo "<th>Other Notes</th>";
					echo "</tr>";
					while ( $loop->have_posts() ) : $loop->the_post();
						echo "<tr>";
							echo "<td>" . the_title("","",0) . "</td>";
							echo "<td>" . get_field('performing_artist') . "</td>";
							echo "<td>" . get_field('current_voicing') . "</td>";
							echo "<td>" . get_field('other_notes') . "</td>";
						echo "</tr>";
					endwhile;
					echo "</table>";  
				endforeach;

			endwhile;
		?>
		<br><br>
	</div>
</section>

<?php
get_footer();


