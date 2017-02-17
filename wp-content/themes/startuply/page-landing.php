<?php
/**
 * Template Name: Home Landing Page
 *
 */

get_header();
?>
<div id="main-content">
	<div class="container-fluid">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					// Include the page content template.
					the_content();
				endwhile;
				wp_reset_postdata();
			?>
			<!--    ************** -->
			<?php
			// The Query
			$p_args = array(
				'category'    => 'health tips' || 'Tips',
				'posts_per_page' => 3,
				'orderby' => 'date');
			$the_query = new WP_Query( $p_args );

			// The Loop
			if ( $the_query->have_posts() ) { ?>
				<div class="container">
					<div class="row posts-strip">
							<?php	while ( $the_query->have_posts() ) { ?>
						<div class="col-md-4 col-post">
									<?php $the_query->the_post();
									$month = get_the_date();
									$month = strip_tags($month); ?>
									<div class="col-md-12 post-thumbnail"><?php echo get_the_post_thumbnail(); ?>
									<div class="date-block">
										<span class="entry-date post-day"><?php the_date('d'); ?></span><br/>
										<span class="entry-date post-month"><?php echo  substr($month, 0, 3) ; ?></span> 
									</div>
									</div> 
									<?php echo '<div class="title-height"><h4>' . get_the_title() . '</h4></div>'; ?>
									<?php
									$content = get_the_content();
									$content = strip_tags($content);
									echo '<div class="col-md-12 post-excerpt"><p>' . substr($content, 0, 150) . '...</p></div>';?>
									<a class="btn btn-narrow btn_mwyhmdqcpy  btn-solid base_clr_bg" href="<?php echo get_permalink(); ?>"> Learn More</a>

							</div>

							<?php }
								/* Restore original Post Data */
								wp_reset_postdata();
							} else {
								// no posts found
							}
							?>
					</div><!-- end row -->
			</div><!-- end container -->

	</div>
</div>

<?php get_footer(); ?>