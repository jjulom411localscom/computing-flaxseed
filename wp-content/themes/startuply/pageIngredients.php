<?php
/*
 * Template name:  For Ingredients
 */

get_header();
?>
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
				wp_reset_postdata();
			?>
			<div class="container behealthy-posts-container">
				<?php $query = new WP_Query( array(
						'post_type' => 'ingredient',
						'posts_per_page' => 4,
						'orderby' => 'date'
					) );

				global $post;
				if( $query->have_posts() ):
				$current_page = $query->get( 'paged' );
				if ( ! $current_page ) {
				    $current_page = 1;
				}
				if ( $current_page == $query->max_num_pages ) {
				    // You are on the last page
				    $last_page_btn ='last_page_btn';
				}else{
					$last_page_btn = '';
				}
									
					while( $query->have_posts() ): $query->the_post(); ?>
					
						<div class="col-md-6 col-post col-ingredient">
							<?php 
					//$meta = get_post_meta( $post->ID, 'your_fields', true ); 
					$meta = get_post_meta( $post->ID, 'your_fields', true ); 
					$month = get_the_date();
							$month = strip_tags($month); ?>
							<div class="col-md-12 post-thumbnail"><?php echo get_the_post_thumbnail(); ?>
							</div> 
							<?php echo '<div class="title-height"><h4 class="ingredient">' . get_the_title() . '</h4></div>'; ?>
							<?php
							$content = get_the_content();
							$content = strip_tags($content);
							echo '<div class="col-md-12 post-excerpt"><p>' . substr($content, 0, 300) . '...</p></div>';?>
							<div class="col-md-12 more-link-container">
								<a href="<?php if(empty($meta)){ echo "#"; }else{ echo $meta['text']; } ?>" class="more-link static" >Read More </a>
								
							</div>

					</div>

				<?php endwhile;
						
					endif;
					wp_reset_postdata();
					?>
			</div><!-- end container -->
			<div class="container text-center ingred-load">
				<a class="btn btn-lg btn-default ingred-load-btn <?php echo  $last_page_btn; ?>" data-page="1" data-url="<?php echo admin_url('admin-ajax.php') ?>">Load More</a>
			</div>
</div>
</div>

<?php get_footer(); ?>