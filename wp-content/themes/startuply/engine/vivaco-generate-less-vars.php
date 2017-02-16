<?php

function vivaco_generate_less_vars() {

	$options = startuply_get_all_option();

	ob_start(); // Capture all output (output buffering)

	$vivaco_base_color = !empty($options['vivaco_base_color']) ? $options['vivaco_base_color'] : '#1ac6ff';
    echo '@vivaco_base_color:'.$vivaco_base_color.';'."\r\n"; ;

	/*
	*
	* START LOADING GIF
	*
	*/
	$loading_gif_on = !empty($options['loading_gif_on']) ? $options['loading_gif_on'] : 0;
	echo '@loading_gif_on: ' . $loading_gif_on . ';'."\r\n";

	/*
	*
	* START DISABLE BASE COLOR BORDER ON FIELDS
	*
	*/
	$disable_border_color = !empty($options['disable_border_color']) ? $options['disable_border_color'] : 0;
	echo '@disable_border_color: ' . $disable_border_color . ';'."\r\n";

	/*
	*
	* START THEME MENU
	*
	*/
	$main_menu_height = isset($options['main_menu_height']) ? $options['main_menu_height'] : '65';
	if ( $main_menu_height ) {
		echo '@main_menu_height: ' . intval($main_menu_height) . 'px;'."\r\n";
	}

	//$menu_height = isset($options['menu_height']) ? $options['menu_height'] : '65';
	//if ( $menu_height ) {
	//	echo '@menu_height: ' . intval($menu_height) . 'px;'."\r\n";
	//}

	$main_menu_bg_color = isset($options['main_menu_bg_color']) ? hex2rgb($options['main_menu_bg_color']) : hex2rgb('#ffffff');
	$main_menu_color_opacity = isset($options['main_menu_color_opacity']) ? ($options['main_menu_color_opacity']/100) : 0;

	$main_menu_bg_image = isset($options['main_menu_bg_image']) ? $options['main_menu_bg_image'] : '';

	$main_menu_bg_position = isset($options['main_menu_bg_position']) ? $options['main_menu_bg_position'] : 'center center';
	$main_menu_bg_repeat = isset($options['main_menu_bg_repeat']) ? $options['main_menu_bg_repeat'] : 'no-repeat';
	$main_menu_bg_size = isset($options['main_menu_bg_size']) ? $options['main_menu_bg_size'] : 'cover';

	$main_menu_text_color = isset($options['main_menu_text_color']) ? $options['main_menu_text_color'] : '#333333';
	$main_menu_active_color = !empty($options['main_menu_active_color']) ? $options['main_menu_active_color'] : '#1ac6ff';

	//$menu_text_color = !empty($options['menu_text_color']) ? $options['menu_text_color'] : $main_menu_text_color;
	//$menu_active_color = !empty($options['menu_active_color']) ? $options['menu_active_color'] : $main_menu_active_color;

	if ($main_menu_bg_image) {
		echo '@main_menu_bg: url("' . remove_base_url(esc_attr($main_menu_bg_image)) . '");'."\r\n";
	}
	elseif( $main_menu_bg_color ) {
		echo '@main_menu_bg:rgba(' . esc_attr($main_menu_bg_color) . ',' . esc_attr($main_menu_color_opacity) .');'."\r\n";
		// $options_responsive .= '.navigation-header.main-menu:not(.fixmenu-clone) { background-color: rgba(' . esc_attr($main_menu_bg_color_rgba) . ',' . esc_attr($main_menu_color_opacity) .'); }'."\r\n";
	}

	if ( $main_menu_bg_position ) {
		 echo '@main_menu_bg_position:' . esc_attr($main_menu_bg_position) .';'."\r\n";
		// $options_responsive .= '.navigation-header.main-menu:not(.fixmenu-clone) { background-position: ' . esc_attr($main_menu_bg_position) . '; }'."\r\n";
	}
	else {
		echo '@main_menu_bg_position: center center;'."\r\n";
	}

	if ( $main_menu_bg_repeat ) {
		echo '@main_menu_bg_repeat:' . esc_attr($main_menu_bg_repeat) .';'."\r\n";
		// $options_responsive .= '.navigation-header.main-menu:not(.fixmenu-clone) { background-repeat: ' . esc_attr($main_menu_bg_repeat) . '; }'."\r\n";
	}
	else {
		echo '@main_menu_bg_repeat: no-repeat;'."\r\n";
	}

	if ( $main_menu_bg_size ) {
		echo '@main_menu_bg_size:' . esc_attr($main_menu_bg_size) .';'."\r\n";
		// $options_responsive .= '.navigation-header.main-menu:not(.fixmenu-clone) { background-size: ' . esc_attr($main_menu_bg_size) . '; -moz-background-size: ' . esc_attr($main_menu_bg_size) . '; -webkit-background-size: ' . esc_attr($main_menu_bg_size) . '; }'."\r\n";
	}
	else {
		echo '@main_menu_bg_size: cover;'."\r\n";
	}

	/* Menu */

	if ($main_menu_text_color) {
		echo '@main_menu_text_color: ' . esc_attr($main_menu_text_color) . ';'."\r\n";
	}

	if ($main_menu_active_color) {
		echo '@main_menu_active_color: ' . esc_attr($main_menu_active_color) . ';'."\r\n";
	}

	//if ($menu_text_color) {
	//	echo '@menu_text_color: ' . esc_attr($menu_text_color) . ';'."\r\n";
	//}

	//if ($menu_active_color) {
	//	echo '@menu_active_color: ' . esc_attr($menu_active_color) . ';'."\r\n";
	//}

	/*
	*
	* START STICKY MENU
	*
	*/
	$sticky_menu_height = isset($options['sticky_menu_height']) ? $options['sticky_menu_height'] : '65';
	$sticky_menu_bg_color = isset($options['sticky_menu_bg_color']) ? $options['sticky_menu_bg_color'] : '#ffffff';
	$sticky_menu_color_opacity = isset($options['sticky_menu_color_opacity']) ? ($options['sticky_menu_color_opacity']/100) : 1;

	$sticky_menu_text_color = isset($options['sticky_menu_text_color']) ? $options['sticky_menu_text_color'] : '#000000';
	$sticky_menu_active_color = !empty($options['sticky_menu_active_color']) ? $options['sticky_menu_active_color'] : '#1ac6ff';

	if ( $sticky_menu_height ) {
		echo '@sticky_menu_height: ' . intval($sticky_menu_height) . 'px;'."\r\n";
	}

	if ($sticky_menu_bg_color) {
		echo '@sticky_menu_bg_color:rgba(' . esc_attr(hex2rgb($sticky_menu_bg_color)) . ',' . esc_attr($sticky_menu_color_opacity) .');'."\r\n";
	}

	if ($sticky_menu_text_color) {
		echo '@sticky_menu_text_color: ' . esc_attr($sticky_menu_text_color) . ';'."\r\n";
	}

	if ($sticky_menu_active_color) {
		echo '@sticky_menu_active_color: ' . esc_attr($sticky_menu_active_color) . ';'."\r\n";
	}

	/* Dropdown menu */
	$dropdown_bg_light = !empty($options['dropdown_bg_light']) ? $options['dropdown_bg_light'] : 0;
	$dropdown_bg_opacity = isset($options['dropdown_bg_opacity']) ? ($options['dropdown_bg_opacity']/100) : 1;

	$dropdown_text_color = !empty($options['dropdown_text_color']) ? $options['dropdown_text_color'] : '';
	$dropdown_active_color = !empty($options['dropdown_active_color']) ? $options['dropdown_active_color'] : '';


	echo '@dropdown_bg_light:'.$dropdown_bg_light.';'."\r\n";
	echo '@dropdown_text_color:'.$dropdown_text_color.';'."\r\n";
	echo '@dropdown_active_color:'.$dropdown_active_color.';'."\r\n";

	echo '@dropdown_bg_light_opacity:rgba(255, 255, 255,' . esc_attr($dropdown_bg_opacity) .');'."\r\n";
	echo '@dropdown_bg_light_opacity3:rgba(255, 255, 255,' . esc_attr($dropdown_bg_opacity) * 0.3 .');'."\r\n";
	echo '@dropdown_bg_light_opacity1:rgba(255, 255, 255,' . esc_attr($dropdown_bg_opacity) * 0.1 .');'."\r\n";
	echo '@dropdown_bg_dark_opacity:rgba(37, 37, 37,' . esc_attr($dropdown_bg_opacity) .');'."\r\n";
	echo '@dropdown_bg_dark_opacity3:rgba(37, 37, 37,' . esc_attr($dropdown_bg_opacity) * 0.3 .');'."\r\n";
	echo '@dropdown_bg_dark_opacity5:rgba(37, 37, 37,' . esc_attr($dropdown_bg_opacity) * 0.5 .');'."\r\n";

/*
*
* FOOTER
*
*/

	$subfooter_bg_color = isset($options['subfooter_bg_color']) ? $options['subfooter_bg_color'] : '#000000';
	$subfooter_text_color = isset($options['subfooter_text_color']) ? $options['subfooter_text_color'] : '#B3B3B3';
	$subfooter_link_color = isset($options['subfooter_link_color']) ? $options['subfooter_link_color'] : '#B3B3B3';
	$subfooter_linkhover_color = isset($options['subfooter_linkhover_color']) ? $options['subfooter_linkhover_color'] : '#1ac6ff';

	  echo '@subfooter_text_color:'.$subfooter_text_color.';'."\r\n"; ;
		echo '@subfooter_link_color:'.$subfooter_link_color.';'."\r\n"; ;
		echo '@subfooter_linkhover_color:'.$subfooter_linkhover_color.';'."\r\n"; ;

	$subfooter_bg_color = hex2rgb($subfooter_bg_color);

	// $color_opacity = isset($options['subfooter_color_opacity']) ? $options['subfooter_color_opacity'] : $default;
	$subfooter_opacity = isset($options['subfooter_color_opacity']) ? ($options['subfooter_color_opacity']/100) : 1;

	echo '@subfooter_bg_color:rgba(' . esc_attr($subfooter_bg_color) . ',' . esc_attr($subfooter_opacity) .');'."\r\n";

	$subheader_bg_color = isset($options['subheader_bg_color']) ? $options['subheader_bg_color'] : '#1AC6FF';
	$subheader_text_color = isset($options['subheader_text_color']) ? $options['subheader_text_color'] : '#ffffff';
	$subheader_link_color = isset($options['subheader_link_color']) ? $options['subheader_link_color'] : '#ffffff';
	$subheader_linkhover_color = isset($options['subheader_linkhover_color']) ? $options['subheader_linkhover_color'] : '#ffffff';

		echo '@subheader_text_color:'.$subheader_text_color.';'."\r\n"; ;
		echo '@subheader_link_color:'.$subheader_link_color.';'."\r\n"; ;
		echo '@subheader_linkhover_color:'.$subheader_linkhover_color.';'."\r\n"; ;

	$subheader_bg_color = hex2rgb($subheader_bg_color);

	// $color_opacity = isset($options['subheader_color_opacity']) ? $options['subheader_color_opacity'] : $default;
	$subheader_opacity = isset($options['subheader_color_opacity']) ? ($options['subheader_color_opacity']/100) : 1;

	echo '@subheader_bg_color:rgba(' . esc_attr($subheader_bg_color) . ','.esc_attr($subheader_opacity).');'."\r\n";

	$footer_bg_image = isset($options['footer_bg_image']) ? $options['footer_bg_image'] : '';
	$footer_bg_color = isset($options['footer_bg_color']) ? $options['footer_bg_color'] : '#1b1b1b';
	$footer_opacity = isset($options['footer_color_opacity']) ? ($options['footer_color_opacity']/100) : 1;

	$footer_bg_color = hex2rgb($footer_bg_color);
	
	if ($footer_bg_image) {
		echo '@footer_bg_color: url("' . remove_base_url(esc_attr($footer_bg_image)) . '");'."\r\n";
	}
	elseif($footer_bg_color){
		echo '@footer_bg_color:rgba(' . esc_attr($footer_bg_color) . ',' . esc_attr($footer_opacity) .');'."\r\n";
	}

	$footer_bg_position = isset($options['footer_bg_position']) ? $options['footer_bg_position'] : 'center center';
	$footer_bg_repeat = isset($options['footer_bg_repeat']) ? $options['footer_bg_repeat'] : 'no-repeat';
	$footer_bg_size = isset($options['footer_bg_size']) ? $options['footer_bg_size'] : 'cover';

	if($footer_bg_position){
		 echo '@footer_bg_position:' . esc_attr($footer_bg_position) .';'."\r\n";
	}
	else {
		echo '@footer_bg_position: center center;'."\r\n";
	}

	if($footer_bg_repeat){
		echo '@footer_bg_repeat:' . esc_attr($footer_bg_repeat) .';'."\r\n";
	}
	else {
		echo '@footer_bg_repeat: no-repeat;'."\r\n";
	}

	if($footer_bg_size) {
		echo '@footer_bg_size:' . esc_attr($footer_bg_size) .';'."\r\n";
	}
	else {
		echo '@footer_bg_size: auto;'."\r\n";
	}

	/*
	*
	* START BOXED LAYOUT WIDTH
	*
	*/
	$fullscreen_on = !empty($options['fullscreen_on']) ? $options['fullscreen_on'] : 0;
	$boxed_layout_width = !empty($options['boxed_width']) ? $options['boxed_width'] : 0;

	echo '@boxed_layout_width:'.$boxed_layout_width.';'."\r\n";
	echo '@fullscreen_on:'.$fullscreen_on.';'."\r\n";

	/* END BOXED LAYOUT WIDTH  */


	/*
	*
	* START BOXED LAYOUT BACKGROUND
	*
	*/

	$boxed_layout_bg_image = isset($options['boxed_background']) ? $options['boxed_background'] : '';
	$boxed_layout_bg_position = isset($options['boxed_background_position']) ? $options['boxed_background_position'] : 'center center';
	$boxed_layout_bg_repeat = isset($options['boxed_background_repeat']) ? $options['boxed_background_repeat'] : 'no-repeat';
	$boxed_layout_bg_size = isset($options['boxed_background_size']) ? $options['boxed_background_size'] : 'cover';

	if ( $boxed_layout_bg_image ) {
			echo '@boxed_layout_bg_image: url("' . remove_base_url(esc_attr($boxed_layout_bg_image)) . '");'."\r\n";
			echo '@boxed_layout_bg_position: ' . esc_attr($boxed_layout_bg_position) . ';'."\r\n";;
			echo '@boxed_layout_bg_repeat: ' . esc_attr($boxed_layout_bg_repeat) . ';'."\r\n";;
			echo '@boxed_layout_bg_size: ' . esc_attr($boxed_layout_bg_size) . ';'."\r\n";;
	}
	else {
			echo '@boxed_layout_bg_image: 0;'."\r\n";
	}
	/* END BOXED LAYOUT BACKGROUND  */

	$output = ob_get_clean(); // Get generated CSS (output buffering)

	return $output;
}

function remove_base_url($path) { // remove base url to fix https warning when using images with http://.. url
	$url_parts = parse_url($path);
	return $url_parts['path'];
}

function get_pageid_override_menu() {

  $options = '';

  ob_start();

  $prefix = 'vivaco_';

  $count = 0;

  $option_arr = array();

  $args = array(
    'posts_per_page' => 100000,
    'post_type' => 'page',
    'post_status' => 'publish',
    'orderby' => 'post_date',
    'order' => 'DESC',
  );

  $all_pages = get_posts($args);

  $page_to_display = null;

  if(!empty($all_pages)) {

    foreach ($all_pages as $key => $page) {
      $override = get_field( $prefix.'override', $page->ID );
      if($override == 'true') {
        $page_to_display[$page->ID] = $page->ID;
      }
    }

    if(!empty($page_to_display)) {

      $pages_array = '@pages-array:';

      foreach ($page_to_display as $key => $page) {

        $post = get_post($page);

		$page_options = get_post_meta($page);
		 
         $main_menu_height = isset($page_options['vivaco_main_menu_height'][0]) ? $page_options['vivaco_main_menu_height'][0] : '65';
         if ( $main_menu_height ) {
           echo '@main_menu_height_'.$post->ID.': ' . intval($main_menu_height) . 'px;'."\r\n";
         }

		if (isset($page_options['vivaco_main_menu_bg_img'][0])){
			$menu_url = wp_get_attachment_url( $page_options['vivaco_main_menu_bg_img'][0], 'full' );
		}
		 
        $main_menu_bg_color = isset($page_options['vivaco_main_menu_bg_color'][0]) ? hex2rgb($page_options['vivaco_main_menu_bg_color'][0]) : hex2rgb('#ffffff');
       	$main_menu_bg_opacity = isset($page_options['vivaco_main_menu_bg_opacity'][0]) ? ($page_options['vivaco_main_menu_bg_opacity'][0]/100) : 1;
        $main_menu_bg_img = isset($menu_url) ? $menu_url : '';

        if( !empty($main_menu_bg_img) ) {
          echo '@main_menu_bg_'.$post->ID.': url("' . remove_base_url(esc_attr($main_menu_bg_img)) . '");'."\r\n";
        }
        elseif(!empty($page_options['vivaco_main_menu_bg_color'][0])) {
          echo '@main_menu_bg_'.$post->ID.': rgba(' . esc_attr($main_menu_bg_color) . ',' . esc_attr($main_menu_bg_opacity) .');'."\r\n";
        }
        else {
          echo '@main_menu_bg_'.$post->ID.': ;'."\r\n";
        }

        $main_menu_bg_position = isset($page_options['vivaco_main_menu_bg_position'][0]) ? $page_options['vivaco_main_menu_bg_position'][0] : 'center center';
        $main_menu_bg_repeat = isset($page_options['vivaco_main_menu_bg_repeat'][0]) ? $page_options['vivaco_main_menu_bg_repeat'][0] : 'no-repeat';
        $main_menu_bg_size = isset($page_options['vivaco_main_menu_bg_size'][0]) ? $page_options['vivaco_main_menu_bg_size'][0] : 'cover';
        if ( $main_menu_bg_position ) {
           echo '@main_menu_bg_position_'.$post->ID.': ' . esc_attr($main_menu_bg_position) .';'."\r\n";
        }
        if ( $main_menu_bg_repeat ) {
          echo '@main_menu_bg_repeat_'.$post->ID.': ' . esc_attr($main_menu_bg_repeat) .';'."\r\n";
        }
        if ( $main_menu_bg_size ) {
          echo '@main_menu_bg_size_'.$post->ID.': ' . esc_attr($main_menu_bg_size) .';'."\r\n";
        }

        $main_menu_text_color = !empty($page_options['vivaco_menu_text_color'][0]) ? $page_options['vivaco_menu_text_color'][0] : '#333333';
      	$main_menu_active_color = !empty($page_options['vivaco_menu_active_color'][0]) ? $page_options['vivaco_menu_active_color'][0] : '#1ac6ff';

        if ($main_menu_text_color) {
          echo '@main_menu_text_color_'.$post->ID.': ' . esc_attr($main_menu_text_color) . ';'."\r\n";
        }

        if ($main_menu_active_color) {
          echo '@main_menu_active_color_'.$post->ID.': ' . esc_attr($main_menu_active_color) . ';'."\r\n";
        }

        $pages_array .= $post->ID.' @main_menu_height_'.$post->ID.
        ' @main_menu_bg_'.$post->ID.' @main_menu_bg_position_'.$post->ID.
        ' @main_menu_bg_repeat_'.$post->ID.' @main_menu_bg_size_'.$post->ID.
        ' @main_menu_text_color_'.$post->ID.' @main_menu_active_color_'.$post->ID.',';

        $count++;
      }

      echo substr($pages_array, 0, -1).';';
      echo '@count:'.$count.';';

    }

  }

  $output = ob_get_clean();
  return $output;
}


?>
