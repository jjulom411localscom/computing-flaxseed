<?php
/*
 * Template name: For Inforgraphic 
 */

get_header();
$comments_count = wp_count_comments(get_the_ID());
?>
<div id="main-content infographic page">
	<div class="container inner blog-block">
		<div class="col-md-8 col-sm-12 blogs articles">
			<section id="post-<?php the_ID(); ?> " <?php post_class(); ?>>

				<div class="entry-content">
					<?php
					// Start the Loop.
					while ( have_posts() ) : the_post(); 
						// Include the page content template. ?>
						<h1><?php the_title(); ?> </h1> <?php
						the_content();
					endwhile;
				?>
				</div>

			</section>

		</div><!--end col-dm-8- blogs-->

		<?php get_sidebar(); ?>

	</div><!--end container -->
</div>

<?php get_footer(); ?>