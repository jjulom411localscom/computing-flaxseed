<?php
/*
 * Template name:  ShopBe
 */

get_header(); ?>


<div id="main-content">
	<div class="container-fluid">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
				// Include the page content template.
				the_content();
			endwhile;
		?>
	</div>

</div>

<?php get_footer(); ?>