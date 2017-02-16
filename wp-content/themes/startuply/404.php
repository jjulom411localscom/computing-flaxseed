<?php
/*
 * 404 page template
 *
*/

get_header();
?>

<div id="main-content">
	<div class="container inner">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="wrap404 aligncenter">
					<br/>
					<br/>
					<br/>
					<?php printf(__('<h1><span class="base_clr_txt">404</span> - page not found!</h1> <p>sorry but something you are looking for is not here :(</p>')); ?>
				</div>
				<div class="recent-posts-404">
					<?php get_sidebar('404'); ?>
					<h2>Suggested Posts</h2>
					<div class="entry-content behealthy-posts-widget">
					<?php
					$count_posts = 5;
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
							'post_type'      => 'post',
							'posts_per_page' => $count_posts,
							'paged' => $paged,
							'orderby' => 'rand'
							);
					$the_query = new WP_Query( $args );
						// Start the Loop.
					if($the_query->have_posts()):
						while ( $the_query->have_posts() ) : $the_query->the_post();
							if(has_post_thumbnail()){
								$out_thumb_class ='healthy';
							}else{
								$out_thumb_class = 'behealthy-title-full';
							}
						 ?>

							<article>
								<div class="behealthy-thumbnail"><?php the_post_thumbnail(); ?>
								</div>
								<div class="btde">
									<div class="behealthy-title <?php echo $out_thumb_class; ?>"><a href ="<?php the_permalink(); ?>"><h3 class="be-title base_clr_txt " style="text-align: left"><?php the_title();?></a></h3>
										<span class="behealthy-date"><?php the_date(); ?></span>
									</div>
									<div class="behealthy-excerpt">
										<?php the_excerpt(); ?>
									</div>
								</div>
							</article>

						<?php endwhile; ?>
						<?php endif;
					?>
				</div>
			</div>

	</div>
</div>

<?php get_footer(); ?>

