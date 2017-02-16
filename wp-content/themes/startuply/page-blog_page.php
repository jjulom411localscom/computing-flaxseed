<?php
/*
 * Template name:  The Blog Posts
 */

get_header(); ?>

<header class="entry-header">
	<?php vivaco_ultimate_title(); ?>
</header><!-- .entry-header -->

<div id="main-content">
	<div class="container-fluid">
	<?php if ( have_posts() ) : ?>
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
				// Include the page content template.
				the_content();
			endwhile;
		?>
		<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
		<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
		<?php else : ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	</div>

</div>

<?php get_footer(); ?>
