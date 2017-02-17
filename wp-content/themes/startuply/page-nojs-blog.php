<?php
/*
 * Template name: Bloggerri
 */

get_header();
$comments_count = wp_count_comments(get_the_ID());
?>
<div id="main-content">
	<div class="container inner blog-block">
		<div class="col-md-8 col-sm-12 blogs articles">
			<div class="wpb_text_column wpb_content_element  cont-h1"><div class="wpb_wrapper"><div class="wpb_text_column-text-style" style=""><h1><strong>Latest Posts</strong></h1>
			</div>	</div></div>
			<section id="post-<?php the_ID(); ?> " <?php post_class(); ?>>
				<?php
					//the_title( '<header class="entry-header"><h2 class="entry-title">', '</h2></header><!-- .entry-header -->' );
				?>

				<div class="entry-content">
					<?php
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
							'post_type'      => 'post',
							'posts_per_page' => 10,
							'paged' => $paged,
							);
					$the_query = new WP_Query( $args );
						// Start the Loop.
					if($the_query->have_posts()):
						while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

							<article>
								<div class="th-cat"><a href ="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
								<?php the_category(); ?>
								</div>
								<h1 class="be-title base_clr_txt " style="text-align: left"><?php the_title();?></h1>
								<?php the_excerpt(); ?>
							</article>

						<?php endwhile; ?>
					<div class="col-sm-12 post-pagination">
						<?php if (function_exists("pagination")) {
						    pagination($the_query->max_num_pages);
						} ?>

					</div>
						<?php endif;
					?>
				</div>

			</section>

		</div><!--end col-dm-8- blogs-->

		<?php get_sidebar(); ?>

	</div><!--end container -->
</div>
</div>
<?php get_footer(); ?>