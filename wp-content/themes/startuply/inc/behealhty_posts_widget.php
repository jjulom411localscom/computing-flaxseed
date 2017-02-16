<?php
//Widget
/**
 * Behealthy-posst widget.
 */
class behealthy_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'behealthy_widget', // Base ID
			esc_html__( 'Behealhty Posts', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Add Behealthy Recent Posts', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];?>
		<h2>Recent Posts</h2>
		<div class="entry-content behealthy-posts-widget">
					<?php
					$count_posts = $instance['title'];
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args = array(
							'post_type'      => 'post',
							'posts_per_page' => $count_posts,
							'paged' => $paged,
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
								<div class="behealthy-title <?php echo $out_thumb_class; ?>"><a href ="<?php the_permalink(); ?>"><h3 class="be-title base_clr_txt " style="text-align: left"><?php the_title();?></a></h3>
									<span class="behealthy-date"><?php the_date(); ?></span>
								</div>
								<?php //the_excerpt(); ?>
							</article>

						<?php endwhile; ?>
						<?php endif;
					?>
		</div>

	<?php 
		echo $args['after_widget']; 
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'How many posts you want to display? ( empty means 10 )', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="number" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class behealthy_widget
// register behealthy_widget widget
function register_behealthy_widget() {
    register_widget( 'behealthy_widget' );
}
add_action( 'widgets_init', 'register_behealthy_widget' );