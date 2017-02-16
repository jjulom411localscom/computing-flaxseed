<?php 
/***
Ajax Functions

*/

add_action('wp_ajax_nopriv_behealthy_load_more', 'behealthy_load_more');
add_action('wp_ajax_behealthy_load_more', 'behealthy_load_more');
function behealthy_load_more(){

	$paged = $_POST["page"]+1;
	
	$query = new WP_Query( array(
		'post_type' => 'ingredient',
		'paged' => $paged,
		'posts_per_page' => 4,
		'orderby' => 'date'
	) );
	global $post;
	global $wp_query;
	if( $query->have_posts() ): ?>
		<?php 

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
			//$meta = get_post_meta( $post->ID, 'your_fields', true );		 
			while( $query->have_posts() ): $query->the_post(); ?>
			
					<?php $meta = get_post_meta( $post->ID, 'your_fields', true ); ?>
				<div class="col-md-6 col-post col-ingredient">
					<?php  $month = get_the_date();
					$month = strip_tags($month); ?>
					<div class="col-md-12 post-thumbnail"><?php echo get_the_post_thumbnail(); ?>
					</div> 
					<?php echo '<div class="title-height"><h4 class="ingredient">' . get_the_title() . '</h4></div>'; ?>
					<?php
					$content = get_the_content();
					$content = strip_tags($content);
					echo '<div class="col-md-12 post-excerpt"><p>' . substr($content, 0, 300) . '...</p></div>';?>
					<div class="col-md-12 more-link-container">
						<a href="<?php if(empty($meta)){ echo "#"; }else{ echo $meta['text']; } ?>" class="more-link static " >Read More </a> 
					</div>


				</div>

			<?php endwhile; ?>
		
	<?php endif;
	
	wp_reset_postdata();
	
	die();
}