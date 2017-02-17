<?php
/**
 * Behealthy Contact Info
 */
class behealthy_contact_widget extends WP_Widget {


    function behealthy_contact_widget() {
        parent::WP_Widget(false, $name = 'Behealthy Contact Info');	
    }

    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $Company_name 	= $instance['Company_name'];
        $Address1 	= $instance['Address1'];
        $Address2 	= $instance['Address2'];
        $phone_num 	= $instance['phone_num'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul class="contact-list">
								<li><?php echo $Company_name; ?></li>
								<li><?php echo $Address1; ?></li>
								<li><?php echo $Address2; ?></li>
								<li><a href="tel:+<?php echo $phone_num; ?>">PHONE: <?php echo $phone_num; ?></a></li>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['Company_name'] = strip_tags($new_instance['Company_name']);
		$instance['Address1'] = strip_tags($new_instance['Address1']);
		$instance['Address2'] = strip_tags($new_instance['Address2']);
		$instance['phone_num'] = strip_tags($new_instance['phone_num']);
        return $instance;
    }

    function form($instance) {	
	
        $title 		= esc_attr($instance['title']);
        $Company_name	= esc_attr($instance['Company_name']);
        $Address1	= esc_attr($instance['Address1']);
        $Address2	= esc_attr($instance['Address2']);
        $phone_num	= esc_attr($instance['phone_num']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <!-- addition-->
		<p>
          <label for="<?php echo $this->get_field_id('Company_name'); ?>"><?php _e('Company Name'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('Company_name'); ?>" name="<?php echo $this->get_field_name('Company_name'); ?>" type="text" value="<?php echo $Company_name; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('Address1'); ?>"><?php _e('Address 1'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('Address1'); ?>" name="<?php echo $this->get_field_name('Address1'); ?>" type="text" value="<?php echo $Address1; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('Address2'); ?>"><?php _e('Address 2'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('Address2'); ?>" name="<?php echo $this->get_field_name('Address2'); ?>" type="text" value="<?php echo $Address2; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('phone_num'); ?>"><?php _e('Phone Number'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('phone_num'); ?>" name="<?php echo $this->get_field_name('phone_num'); ?>" type="text" value="<?php echo $phone_num; ?>" />
        </p>
        <?php 
    }


} 
add_action('widgets_init', create_function('', 'return register_widget("behealthy_contact_widget");'));
?>