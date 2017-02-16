<?php
/*
 * Template name:  Fullwidth
 */

get_header(); ?>

<header class="entry-header">
	<?php vivaco_ultimate_title(); ?>
</header><!-- .entry-header -->

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