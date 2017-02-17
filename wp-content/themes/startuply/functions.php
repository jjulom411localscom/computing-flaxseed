<?php
/**
 *
 * Startuply WP functions
 *
 * @author Vivaco
 * @license Commercial License
 * @link http://startuplywp.com
 * @copyright 2015 Vivaco
 * @package Startuply
 * @version 2.5
 *
 */

define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());

// Theme caching dirs
define('THEME_CACHE_DIR', THEME_DIR . '/cache');
define('THEME_CACHE_URI', THEME_URI . '/cache');

//Main compiled theme options css file
define('THEME_OPTIONS_CSS', 'theme-options');

 //Theme options LESS source file
define('THEME_OPTIONS_LESS', 'theme-options');
//Exported theme options variables only
define('THEME_OPTIONS_VARS_LESS', 'theme-vars');

define('CUSTOM_NAV', 'theme-nav');
define('CUSTOM_NAV_LESS', 'custom-navigation.less');

/* Image sizes for blog thumbnails */
define('BLOG_IMAGE_LARGE_W', 875);
define('BLOG_IMAGE_LARGE_H', 330);
define('BLOG_IMAGE_SMALL_W', 300);
define('BLOG_IMAGE_SMALL_H', 300);
/* Post link length in post navigation */
define('MAX_NAV_TITLE_LENGTH', 25);

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/engine/lib/options-framework/inc/' );
require_once dirname( __FILE__ ) . '/engine/lib/options-framework/inc/options-framework.php';

/* Including custom image resizer and widgets */
include ("engine/tools/image-resizer.php");
include ("engine/vivaco-widgets.php");

/* Including custom shortcodes for Visual Composer and Post Types */
require_once ( get_template_directory() . '/engine/vivaco-custom-post-types.php' );
require_once ( get_template_directory() . '/engine/vivaco-visual-composer-extend.php' );
require_once ( get_template_directory() . '/engine/vivaco-visual-composer-templates.php' );
require_once ( get_template_directory() . '/engine/vivaco-pagination.php' );
require_once ( get_template_directory() . '/engine/vivaco-login-forgot-register-form.php' );

/* Google fonts */
require_once ( get_template_directory() . '/fonts/google-fonts.php' );
/* LESS Lib */
require_once ( get_template_directory() . '/engine/lib/less.php/Less.php' );

/* Google fonts */
require_once ( get_template_directory() . '/fonts/google-fonts.php' );

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php')) {
	require_once ( get_template_directory() . '/engine/lib/edd-vc-shortcodes/edd_vc/edd_vc.php' );
	require_once ( get_template_directory() . '/engine/lib/edd-vc-shortcodes/edd.php' );
	require_once ( get_template_directory() . '/engine/lib/multi-post-thumbnails/multi-post-thumbnails.php' );
}

/* Register Custom Navigation Walker */
require_once ( get_template_directory() . '/engine/tools/wp_bootstrap_navwalker.php' );
/* Include custom css generation */
require_once ( get_template_directory() . '/engine/vivaco-generate-less-vars.php' );
require_once ( get_template_directory() . '/engine/lib/metaboxes/startuply-page-attributes-meta-box.php' );
require_once ( get_template_directory() . '/engine/lib/vivaco-importer/import.php' );

// after all includes
require_once ( get_template_directory() . '/engine/lib/vivaco-animations/vivaco-animations.php' );
require_once ( get_template_directory() . '/engine/lib/clone-post/clone-post.php' );

if ( file_exists( dirname( __FILE__ ) . '/engine/lib/acf/acf.php' ) ) {
	
	add_filter('acf/settings/path', 'vivaco_acf_settings_path');
	function vivaco_acf_settings_path( $path ) {
		$path = get_template_directory() . '/engine/lib/acf/';
		return $path;
	}
	
	add_filter('acf/settings/dir', 'vivaco_acf_settings_dir');
	function vivaco_acf_settings_dir( $dir ) {
		$dir = get_template_directory_uri() . '/engine/lib/acf/';
		return $dir;
	}

	//Hide ACF field group menu item
	add_filter('acf/settings/show_admin', '__return_false');
	include_once( get_template_directory() . '/engine/lib/acf/' . 'acf.php' );
}

//Include Vivaco Ultimate Page titles
if( function_exists('acf_add_local_field_group') ) {
	require_once ( get_template_directory() . '/engine/vivaco-page-settings.php' );
}

//Include Vivaco Modal Boxes
if (startuply_option('modal_box_on') !== false || startuply_option('modal_box_on') == '' || startuply_option('modal_box_on') == 1 ) {
	require_once ( get_template_directory() . '/engine/lib/vivaco-modal-boxes/vivaco-modal-box.php' );
	require_once ( get_template_directory() . '/engine/lib/vivaco-modal-boxes/vivaco-modal-function.php' );
}

/* Remove admin bar for users registered through reg form */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(current_user_can('administrator') || is_admin());
	}
}

function startuply_optionsframework_menu( $menu ) {
	$menu['mode'] = 'menu';
	$menu['page_title'] = 'Startuply Options';
	$menu['menu_title'] = 'Startuply';
	$menu['icon_url'] = 'dashicons-admin-generic';

	return $menu;
}
add_filter( 'optionsframework_menu', 'startuply_optionsframework_menu');

/* Remove Theme Customizer default params */
add_action( "customize_register", "startuply_customize_register" );
	function startuply_customize_register( $wp_customize ) {

		//=============================================================
		// Remove header image and widgets option from theme customizer
		//=============================================================
		$wp_customize->remove_control("header_image");
		$wp_customize->remove_panel("widgets");
		$wp_customize->remove_section("colors");
		$wp_customize->remove_section("background_image");

	}

// remove the standard EDD button that shows after the download's content
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

/* Add EDD cart to menu */
if( !function_exists('startuply_edd_cart_wrap') ) {
	function startuply_edd_cart_wrap() {

		$cart_icon_in_menu = startuply_option('vivaco_edd_menu_cart_on', 'empty');

		if (is_plugin_active('easy-digital-downloads/easy-digital-downloads.php') &&

			($cart_icon_in_menu === 'empty' || $cart_icon_in_menu === '1') ) {

			$new_nav_wrap  = '<ul id="%1$s" class="%2$s">';
			$new_nav_wrap .= '%3$s';
			$new_nav_wrap .= '<li class="menu-item">';
			$new_nav_wrap .= '<a href="' . edd_get_checkout_uri() . '">';
			$new_nav_wrap .= '<span class="fa icon icon-shopping-13 edd-cart-icon"><span class="edd-cart-quantity base_clr_bg">' . edd_get_cart_quantity() .'</span></span>';
			$new_nav_wrap .= '</a>';
			$new_nav_wrap .= '</li>';
			$new_nav_wrap .= '</ul>';

			return $new_nav_wrap;

		} else {

			$new_nav_wrap  = '<ul id="%1$s" class="%2$s">';
			$new_nav_wrap .= '%3$s';
			$new_nav_wrap .= '</ul>';

			return $new_nav_wrap;
		}
	}
}
//add_action( 'wp_head', 'startuply_edd_cart_wrap' );

/* Custom Excerpt length */
if( !function_exists('startuply_custom_excerpt_length') ) {
	function startuply_custom_excerpt_length( $length ) {
		$custom_len = (startuply_option('blog_excr_len', '') == '' ? 38 : startuply_option('blog_excr_len',''));
		return $custom_len;
	}
	add_filter( 'excerpt_length', 'startuply_custom_excerpt_length', 999 );
}

/* Custom thumbnail sizes */
if( !function_exists('startuply_thumb_sizes') ) {
	function startuply_thumb_sizes() {
		add_image_size( 'blog-thumb-large', 875 ); 	// Blog thumbnails
		add_image_size( 'full-size',  9999, 9999, false ); 	// Full Size
	}
	add_action( 'init', 'startuply_thumb_sizes' );
}

/* composer fix */
function startuply_admin_enqueue_scripts() {
	// wp_deregister_script('customize-controls');

	$version = defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1.0.0.1';

	// wp_register_script(
	// 	'customize-controls', get_template_directory_uri().'/js/customize-controls.js',
	// 	array( 'customize-base' ),
	// 	$version,
	// 	true
	// );

	wp_register_script('composer_custom_views_fix', get_template_directory_uri().'/js/composer-custom-views-fix.js', array('wpb_js_composer_js_custom_views'), $version, true);
	wp_enqueue_script('composer_custom_views_fix', array('jquery'), true);

	wp_register_script(
		'custom_admin',
		get_template_directory_uri().'/js/custom-admin.js',
		array('jquery'),
		$version,
		true
	);
	wp_enqueue_script('custom_admin', array('jquery'), true);
}
add_action( 'admin_enqueue_scripts', 'startuply_admin_enqueue_scripts' );
/**/

/* composer vc_css_editor.js fix */
function startuply_vc_css_editor_fix($output) {
	$old_vc_css_editor_path = vc_asset_url( 'js/params/css_editor.js' );
	$new_vc_css_editor_path = get_template_directory_uri().'/js/css_editor-fix.js';

	return str_replace($old_vc_css_editor_path, $new_vc_css_editor_path, $output);
}
add_filter( 'vc_css_editor', 'startuply_vc_css_editor_fix');

/* Theme setup */
function startuply_theme_setup () {
	/* Add thumbnail metabox for all post types (show/hide from page settings in top menu) */
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header');
	add_theme_support('custom-background');
	add_theme_support('title-tag');

	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function theme_slug_render_title() { ?>
			<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php
		}
		add_action( 'wp_head', 'theme_slug_render_title' );
	}

	/* Add excerpt metabox for pages (show/hide from page settings in top menu) */
	add_post_type_support( 'page', 'excerpt' );
	load_theme_textdomain( 'vivaco', get_template_directory() . '/languages/' );
}
add_action('after_setup_theme', 'startuply_theme_setup');


/* Startuply Admin Menu Setup*/
function startuply_admin_menu() {
/* import Demo data menu item*/
	$page_slug = add_menu_page(
		'Demo Data',
		'Demo Data',
		'edit_theme_options', //capability
		'startuply_import', // menu_slug
		'startuply_import', // callback
		'dashicons-download'
	);

	add_action('admin_print_styles-'.$page_slug, 'startuply_admin_menu_enqueue');

	// Re-create new CSS files from LESS on each theme options update
	if( strlen(get_option('startuply-options-updated', '')) > 0 ) {
		$path = startuply_update_less();
		if( $path !== false ) {
			update_option('startuply-options-css', filectime($path));
		} else {
			update_option('startuply-options-css', '');
		}
		update_option('startuply-options-updated', '');
	}
}
add_action( 'admin_menu', 'startuply_admin_menu');
add_action( 'admin_init', 'startuply_admin_menu_init' ); // need to be before 'admin_menu' action

// Fix for Custom CSS/JS html characters
function startuply_of_textarea_change_sanitization() {
		remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
		add_filter( 'of_sanitize_textarea', 'startuply_of_textarea_clear_sanitization' );
}
function startuply_of_textarea_clear_sanitization($output) {
	return $output;
}
add_action( 'admin_init', 'startuply_of_textarea_change_sanitization', 100);


/* Content Width */
if ( ! isset( $content_width ) ) $content_width = 960;

/* Register menus */
if( !function_exists('startuply_register_menus') ) {
	function startuply_register_menus() {
		register_nav_menus( array(
			'left_menu' => 'Main left',
			'right_menu' => 'Extra right'

		) );
	}
	add_action( 'init', 'startuply_register_menus' );
}
/*Register Footer menu 2.16.2017*/
add_action( 'after_setup_theme', 'register_behealthy_footer_menu' );
function register_behealthy_footer_menu() {
  register_nav_menu( 'behealthy_footer_menu_col-1', __( 'Behealthy Footer Menu Column 1', 'theme-slug' ) );
  register_nav_menu( 'behealthy_footer_menu_col-2', __( 'Behealthy Footer Menu Column 2', 'theme-slug' ) );
}

/* Initializing custom widgets */
if( !function_exists('startuply_register_custom_widgets') ) {
	function startuply_register_custom_widgets() {
		unregister_widget('WP_Widget_Recent_Posts');
		unregister_widget('WP_Widget_Recent_Comments');

		register_widget( 'VSC_Widget_Recent_Posts' );
		register_widget( 'VSC_Widget_Recent_Comments' );
		register_widget( 'VSC_Widget_Contacts' );
		register_widget( 'VSC_Widget_Socials' );
		register_widget( 'VSC_Widget_About' );
		register_widget( 'VSC_Widget_CF7' );
	}
	add_action( 'widgets_init', 'startuply_register_custom_widgets' );
}

/* Sidebars & Widgetizes Areas */
if(!function_exists('startuply_register_sidebars')) {
	function startuply_register_sidebars() {
		register_sidebar(array(
			'id' => 'sidebar',
			'name' => 'Sidebar',
			'class' => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widgetBody clearfix">',
			'after_widget' => '</div></aside>',
			'before_title' => '<header class="widgetHeader"><h3>',
			'after_title' => '</h3></header>',
		));

		if (startuply_option('footer_on', '1') === '1') {

			$layout_footer = array();

			$footer_widgets = startuply_option('footer_widgets', '3_widget');

			if ($footer_widgets == '1_widget') {
				$layout_footer = array(12);
			} elseif ($footer_widgets == '2_widget') {
				$layout_footer = array(6,6);
			} elseif ($footer_widgets == '3_widget') {
				$layout_footer = array(4,4,4);
			} elseif ($footer_widgets == '4_widget') {
				$layout_footer = array(3,3,3,3);
			} elseif ($footer_widgets == '3x1_big_widget') {
				$layout_footer = array(6,3,3);
			} elseif ($footer_widgets == '3x2_big_widget') {
				$layout_footer = array(3,6,3);
			} elseif ($footer_widgets == '3x3_big_widget') {
				$layout_footer = array(3,3,6);
			} elseif ($footer_widgets == '4x1_big_widget') {
				$layout_footer = array(6,2,2,2);
			} elseif ($footer_widgets == '4x4_big_widget') {
				$layout_footer = array(2,2,2,6);
			}

			for ($widget_number = 1; $widget_number < count($layout_footer) + 1; $widget_number++) {
				register_sidebar(array(
					'id' => "sidebar_footer_$widget_number",
					'name' => "Footer Sidebar $widget_number",
					'class' => 'sidebar',
					'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widgetBody clearfix">',
					'after_widget' => '</div></aside>',
					'before_title' => '<div class="footer-title">',
					'after_title' => '</div>',
				));
			}
		}

		if (startuply_option('sub_menu_on', '1') === '1') {

			$layout_sub_menu = array(6,6);

			for ($widget_number = 1; $widget_number < count($layout_sub_menu) + 1; $widget_number++) {
				register_sidebar(array(
					'id' => "sidebar_sub_menu_$widget_number",
					'name' => "Sub menu Sidebar $widget_number",
					'class' => 'fa',
					'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widgetBody clearfix">',
					'after_widget' => '</div></aside>',
					'before_title' => '<div class="menu-title">',
					'after_title' => '</div>',
				));
			}
		}
	}
	add_action( 'widgets_init', 'startuply_register_sidebars' );
}

/* Enqueue Startuply styles */
if( !function_exists('startuply_enqueue_styles') ) {
	function startuply_enqueue_styles()
	{
		/* Styles registered in Visual Composer, enqueue it */
		wp_enqueue_style('prettyphoto');
		wp_enqueue_style('js_composer_front' );
		wp_enqueue_style('js_composer_custom_css');

		/* Startuply styles */
		wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
		wp_enqueue_style('revolution', get_template_directory_uri() . '/css/combined-styles.css');

		wp_enqueue_style('startuply_custom', get_stylesheet_directory_uri() . '/style.css');

		
		$lastmodify = filectime(THEME_DIR .'/css/less/'. THEME_OPTIONS_LESS . '.less');

		if( is_multisite() ) {
			global $blog_id;
			$enqueue_css = THEME_CACHE_URI . '/' . THEME_OPTIONS_CSS . '-'. $blog_id .'.css';
			$enqueue_css_dir = THEME_CACHE_DIR . '/' . THEME_OPTIONS_CSS . '-'. $blog_id .'.css';

		} else {
			$enqueue_css = THEME_CACHE_URI . '/' . THEME_OPTIONS_CSS . '.css';
			$enqueue_css_dir = THEME_CACHE_DIR . '/' . THEME_OPTIONS_CSS . '.css';
		}

		
		wp_enqueue_style('startuply_option', $enqueue_css);
	
		$page_menu_override = get_field('vivaco_override', get_the_ID());
		if($page_menu_override != 'false'){
			wp_enqueue_style('startuply_custom_nav', THEME_CACHE_URI .'/'. CUSTOM_NAV.'.css');
		}
		
		if (startuply_option('fullscreen_on') == true) {
			wp_enqueue_style('boxed-layout', get_template_directory_uri() . '/css/boxed-layout.css');
		}

		if (startuply_option('responsive_on') == true) {
			wp_enqueue_style('non-responsive', get_template_directory_uri() . '/css/non-responsive.css');
		}

	}
	add_action('wp_enqueue_scripts', 'startuply_enqueue_styles');
}

/* Enqueue Startuply Fonts */
if( !function_exists('startuply_fonts') ) {
	function startuply_fonts() {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'startuply_ptsans', "$protocol://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic" );
		wp_enqueue_style( 'startuply_lato', "$protocol://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" );
		wp_enqueue_style('startuply_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	}
	add_action( 'wp_enqueue_scripts', 'startuply_fonts' );
}

function startuply_detect_plugin_activation(  $plugin, $network_activation ) {
	// do stuff
	if (strpos($plugin, 'revslider.php') !== FALSE) { // on revslider activation

		if ( is_plugin_active( 'revslider/revslider.php' ) ) {
			/**
			 * revoslider force set js to footer
			**/
			if( class_exists('RevOperations') ) {
				$revOperations = new RevOperations();

				$revGeneralSettings = $revOperations->getGeneralSettingsValues();
				if(!isset($revGeneralSettings)) {
					$revGeneralSettings = array();
				}

				if(!isset($revGeneralSettings['js_to_footer']) || $revGeneralSettings['js_to_footer'] == 'off' ||
					!isset($revGeneralSettings['includes_globally']) || $revGeneralSettings['includes_globally'] == 'on') {
					$revGeneralSettings['js_to_footer'] = 'on';
					$revGeneralSettings['includes_globally'] = 'off';
					$revOperations->updateGeneralSettings($revGeneralSettings);
				}
			}
		}
	}
}
add_action( 'activated_plugin', 'startuply_detect_plugin_activation', 999, 2 );

if( !function_exists( 'startuply_custom_js' ) ) {
	function startuply_custom_js() {
		$custom_js = startuply_option( 'custom_js', '');
		if ( strlen($custom_js) ) {
			echo '<script type="text/javascript">(function($) {' . "\n" . $custom_js . "\n" . '}(jQuery));</script>';
		}
	}
}
add_action('wp_footer', 'startuply_custom_js');

/* Enqueue javascript */
if( !function_exists('startuply_add_theme_js') ) {
	function startuply_add_theme_js(){
		if (!is_admin()) {
			if ( is_customize_preview() ) {
				wp_deregister_script( 'wpb_composer_front_js' );
				wp_dequeue_script( 'wpb_composer_front_js' );
				wp_register_script('wpb_composer_front_js-customizer_fix', get_template_directory_uri().'/js/wpb_composer_front_js-customizer_fix.js', array('jquery'), '', true);
				wp_enqueue_script( 'wpb_composer_front_js-customizer_fix' );
			}

			/* JS Compatibility Libraries */
			if  ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) ) && ( false === strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 9' ) ) ) {
				wp_register_script( 'html5shiv', get_template_directory_uri() . '/js/lib/html5.js',   array(), null, false );
				wp_register_script( 'respond', get_template_directory_uri() . '/js/lib/respond.min.js', array(), null, false );
			}
			// on single blog post pages with comments open and threaded comments
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				// enqueue the javascript that performs in-link comment reply fanciness
				wp_enqueue_script( 'comment-reply' );
			}

			wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), '', true);
			wp_register_script('nav', get_template_directory_uri().'/js/lib/jquery.nav.js', array(), '', true);
			wp_register_script('social-share', get_template_directory_uri().'/js/lib/social-share.js', array(), '', true);
			wp_register_script('headhesive', get_template_directory_uri().'/js/lib/headhesive.min.js', array(), '', true);
			wp_register_script('tween-max', get_template_directory_uri().'/js/lib/TweenMax.min.js', array(), '', true);
			wp_register_script('scroll-to-plugin', get_template_directory_uri().'/js/lib/ScrollToPlugin.min.js', array(), '', true);
			wp_register_script('ease-pack', get_template_directory_uri().'/js/lib/EasePack.min.js', array(), '', true);
			wp_register_script('vsc-parallax', get_template_directory_uri().'/js/lib/jquery.parallax.js', array('jquery'), '1.1.3', true );
			wp_register_script('vsc-isotope', get_template_directory_uri().'/js/lib/jquery.isotope.min.js', array('jquery'), '1.0', true );
			wp_register_script('ui-slider', get_template_directory_uri().'/js/lib/jquery-ui-slider.min.js', array('jquery'), '', true);
			wp_register_script('bx-slider', get_template_directory_uri().'/js/lib/jquery.bxslider.min.js', array('jquery'), '', true);
			wp_register_script('vsc-countdown', get_template_directory_uri().'/js/lib/jquery.countdown.min.js', array('jquery'), '', true);

			/* User scripts */
			wp_register_script('vsc-custom-parallax', get_template_directory_uri().'/js/custom-parallax.js', array('jquery'), '1.1.3', true );
			wp_register_script('vsc-custom-contact-form-7', get_template_directory_uri().'/js/custom-contact-form7.js', array('jquery'), '1.1.3', true );
			wp_register_script('vsc-custom-isotope-portfolio', get_template_directory_uri().'/js/custom-isotope-portfolio.js', array('jquery'), '1.0', true );
			wp_register_script('progressCircle', get_template_directory_uri().'/js/lib/ProgressCircle.js' , '' , true );
			wp_register_script('vsc-custom-pie', get_template_directory_uri().'/js/custom-pie.js', array( 'jquery', 'waypoints', 'progressCircle' ), '', true );
			wp_register_script('vsc-counter', get_template_directory_uri().'/js/custom-counter.js', array( 'jquery', 'waypoints' ), '', true);
			wp_register_script('vsc-content-slider', get_template_directory_uri().'/js/custom-content-slider.js', array('jquery', 'bx-slider'), '', true);
			wp_register_script('modal-box', get_template_directory_uri().'/js/modal-box.js', array(), '', true);


			wp_register_script('svg-text', get_template_directory_uri().'/js/svg-text.js', array(), '', true);
			wp_register_script('mailing-list', get_template_directory_uri().'/js/custom-mailing-list.js', array(), '', true);
			wp_register_script('custom', get_template_directory_uri().'/js/custom.js', array(), '', true);

			if (startuply_option('smooth_scroll_on') == true) {
				wp_register_script('smoothScroll', get_template_directory_uri().'/js/lib/jquery.smooth-scroll.js', array('jquery'), '' , true );
				wp_enqueue_script('smoothScroll', array('jquery'), true);
			}

			/* Enqueue all */
			wp_enqueue_script('jquery');
			wp_enqueue_script('ease-pack');
			wp_enqueue_script('bootstrap', array('jquery'), true);
			wp_enqueue_script('nav', array('jquery'), true);
			wp_enqueue_script('social-share', array('jquery'), true);
			wp_enqueue_script('mailing-list', array('jquery'), true);
			wp_localize_script('mailing-list', 'locale', array( 'templateUrl' => get_template_directory_uri() ) );
			wp_enqueue_script('vsc-parallax', array('jquery'), true);
			wp_enqueue_script('vsc-custom-parallax', array('jquery'), true);
			wp_enqueue_script('vsc-isotope', array('jquery'), true);
			wp_enqueue_script('vsc-custom-isotope-portfolio', array('jquery'), true);
			wp_enqueue_script('modal-box', array('jquery'), true);

			$args = array();
			if(isset($grid_manager)) {
				$args['grid_manager'] = $grid_manager;
			}
			if(isset($grid_very_wide)) {
				$args['grid_very_wide'] = $grid_very_wide;
			}
			if(isset($grid_wide)) {
				$args['grid_wide'] = $grid_wide;
			}
			if(isset($grid_normal)) {
				$args['grid_normal'] = $grid_normal;
			}
			if(isset($grid_small)) {
				$args['grid_small'] = $grid_small;
			}
			if(isset($grid_tablet)) {
				$args['grid_tablet'] = $grid_tablet;
			}
			if(isset($grid_phone)) {
				$args['grid_phone'] = $grid_phone;
			}
			if(isset($grid_gutter_width)) {
				$args['grid_gutter_width'] = $grid_gutter_width;
			}

			//Check sticky menu option
			$sticky_menu_display = '';
			$sticky_menu_position = '';
			
			$sticky_menu_display = ( startuply_option( 'sticky_menu_display', '') !== '') ? startuply_option( 'sticky_menu_display', '') : 'all_pages';

			//Check mobile always option
			$mobile_main_menu_mod_on = ( startuply_option( 'mobile_main_menu_mod_on', '') !== '') ? startuply_option( 'mobile_main_menu_mod_on', '') : false;
			$mobile_menu_mod_on = ( startuply_option( 'mobile_menu_mod_on', '') !== '') ? startuply_option( 'mobile_menu_mod_on', '') : false;

			//add scmooth scroll
			$smooth_scroll_on = startuply_option( 'smooth_scroll_on' );

			if ($smooth_scroll_on == '1') {
				wp_enqueue_script('tween-max');
				wp_enqueue_script('scroll-to-plugin');
			}

			//add scmooth scroll parameters
			$smooth_speed = startuply_option( 'smooth_scroll_speed', '');
			if(strlen($smooth_speed) == 0) { $smooth_speed = 100; }

			//Check if PrettyPhoto is already loaded by Visual Composer
			if(!wp_script_is( 'prettyphoto', 'registered' )) {
				wp_register_script( 'prettyphoto', get_template_directory_uri().'/js/lib/jquery.prettyPhoto.js', array('jquery'), '1.0', true );
			}

			if ( $sticky_menu_display ) {
				wp_enqueue_script('headhesive', array('jquery'), true);
				$sticky_menu_position = startuply_option( 'sticky_menu_position', '');
				if(strlen($sticky_menu_position) == 0) { $sticky_menu_position = 600; }
			}

			wp_localize_script( 'vsc-custom-isotope-portfolio', 'vals', $args );
			wp_enqueue_script('prettyphoto', array('jquery'), true);
			wp_localize_script('custom', 'themeOptions', array('stickyMenu' => $sticky_menu_display, 'menuPosition' => $sticky_menu_position, 'mobileMainMenuMod' => $mobile_main_menu_mod_on, 'mobileMenuMod' => $mobile_menu_mod_on, 'smoothScroll' => $smooth_scroll_on, 'smoothScrollSpeed' => $smooth_speed) );
			wp_enqueue_script('custom', array('jquery'), true);

		}
	}
	add_action('wp_enqueue_scripts', 'startuply_add_theme_js');
}

/* Add CSS Class to Gravatar */
if(!function_exists('startuply_avatar_css')) {
	function startuply_avatar_css($class) {
		$class = str_replace("class='avatar", "class='avatar img-circle", $class);
		return $class;
	}
	add_filter('get_avatar', 'startuply_avatar_css');
}

/* Add Twitter Bootstrap's standard 'active' class name to the active nav link item */
if(!function_exists('startuply_add_active_class')) {
	function startuply_add_active_class($classes, $item) {
		if($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)) {
			$classes[] = "active";
		}
		return $classes;
	}
	add_filter('nav_menu_css_class', 'startuply_add_active_class', 10, 2 );
}


/* Replace [...] to ... in excerpt posts */
if( !function_exists('startuply_excerpt_read_more_sign') ) {
	function startuply_excerpt_read_more_sign($content) {
		return str_replace('[&hellip;]', '&hellip;', $content);
	}
	add_filter( 'the_excerpt', 'startuply_excerpt_read_more_sign' );
}
/* Add 'Read More' link to posts */
if( !function_exists('startuply_excerpt_read_more_link') ) {
	function startuply_excerpt_read_more_link($output) {
		global $post;
		$show_read_more = (startuply_option('blog_readmr', '') == '' ? true : false);
		if ($show_read_more){
		return $output . ' <a href="' . get_permalink($post->ID) . '" class="more-link" title="Read More">READ MORE</a>';
		} else {
			return $output;
	}
	}
	add_filter( 'the_excerpt', 'startuply_excerpt_read_more_link' );
}

/* Modifying Read More links  */
if( !function_exists('startuply_modify_read_more_link') ) {
	function startuply_modify_read_more_link() {
		return ' <a href="' . get_permalink($post->ID) . '" class="more-link" title="Read More">READ MORE<i class="fa fa-angle-right"></i></a>';
	}
	add_filter( 'the_content_more_link', 'startuply_modify_read_more_link' );
}

/* Edit the tag cloud elements size */
if( !function_exists('startuply_cloud_widget') ) {
	function startuply_cloud_widget($args) {
		$args['largest'] = 14; //largest tag
		$args['smallest'] = 14; //smallest tag
		$args['unit'] = 'px'; //tag font unit
		return $args;
	}
	add_filter( 'widget_tag_cloud_args', 'startuply_cloud_widget' );
}

/* Adding support for custom editor styles */
if( !function_exists('startuply_add_editor_styles') ) {
	function startuply_add_editor_styles() {
		add_editor_style( get_template_directory_uri().'/css/custom-editor-style.css' );
	}
	add_action( 'after_setup_theme', 'startuply_add_editor_styles' );
}

/* Extending some default Visual Composer shortcodes */
if(function_exists('vc_set_shortcodes_templates_dir')) {
	vc_set_shortcodes_templates_dir(get_template_directory() . '/engine/shortcodes/vc_templates/');
}


/* Add Google Analytics Tracking code */
if( !function_exists('startuply_google_analytics_code') ) {
	function startuply_google_analytics_code(){
		$ga_code = startuply_option('google_analytics');
		$google_gtm = startuply_option('google_gtm');
		if(!empty($ga_code) && empty($google_gtm)) {
			if(startuply_option('google_alternative_on') == 0) {
				wp_enqueue_script('google-analytics', get_template_directory_uri() . '/js/lib/google-analytics.js', array('jquery'), '1.0', false );
				wp_localize_script( 'google-analytics', "g", array( 'ga_id' => $ga_code) );
			}
			else {
				wp_enqueue_script('google-altern-async', '//www.google-analytics.com/analytics.js');
				wp_enqueue_script('google-altern-analytics', get_template_directory_uri() . '/js/lib/google-altern-analytics.js', array('jquery'), '1.0', false );
				wp_localize_script( 'google-altern-analytics', "g", array( 'ga_id' => $ga_code) );
			}
		}
	}
	add_action('wp_enqueue_scripts', 'startuply_google_analytics_code');
}

add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
function add_async_attribute($tag, $handle) {
    if ( 'google-altern-async' !== $handle )
        return $tag;
    return str_replace( ' src', ' async src', $tag );
}

/* Add Google Tag Manager for Web Tracking */
if( !function_exists('startuply_google_gtm_code') ) {
	function startuply_google_gtm_code(){
		$gtm_code = startuply_option('google_gtm');
		if(isset($gtm_code) && !empty($gtm_code)) {
			wp_enqueue_script('google-gtm', get_template_directory_uri() . '/js/lib/gtm.js', array('jquery'), '1.0', false );
			wp_localize_script( 'google-gtm', "gtm", array( 'gtm_id' => $gtm_code) );

		}
	}
	add_action('wp_enqueue_scripts', 'startuply_google_gtm_code');
}


/* Add Social Widgets */
if( !function_exists('startuply_social_widget') ) {
	function startuply_social_widget() {

		$output = '';
		$output .= '<ul class="startuply-social">';

		//$output .= startuply_option('facebook');

		if(startuply_option('facebook')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('facebook').'"><i class="fa fa-facebook-official"></i></a></li>';
		}

		if(startuply_option('twitter')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('twitter').'"><i class="fa fa-twitter-square"></i></a></li>';
		}

		if(startuply_option('googleplus')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('googleplus').'"><i class="fa fa-google-plus-square"></i></a></li>';
		}

		if(startuply_option('instagram')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('instagram').'"><i class="fa fa-instagram"></i></a></li>';
		}

		if(startuply_option('linkedin')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('linkedin').'"><i class="fa fa-linkedin-square"></i></a></li>';
		}

		if(startuply_option('youtube')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('youtube').'"><i class="fa fa-youtube-square"></i></a></li>';
		}

		if(startuply_option('whatsapp')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('whatsapp').'"><i class="fa fa-whatsapp"></i></a></li>';
		}

		if(startuply_option('vk')) {
			$output .= '<li><a target="_blank" href="'.startuply_option('vk').'"><i class="fa fa-vk"></i></a></li>';
		}

		$output .= '</ul>';
		print $output;
	}
	add_action('social_widget', 'startuply_social_widget');
}

/* Custom comments function */
if(!function_exists('startuply_comment')) {
	function startuply_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li class="comment" <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

			<div class="comment-body">

				<div class="comment-author vcard">
					<?php echo get_avatar($comment,$size='60'); ?>
					<cite class="fn base_clr_txt"><?php echo get_comment_author_link() ?></cite> <span class="says base_clr_txt">says:</span>
				</div>

				<div class="comment-meta commentmetadata">
					<?php printf(__('%1$s at %2$s', 'vivaco'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('Edit', 'vivaco'),'  ','') ?>
				</div>

				<div class="comment-data">
					<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('<em>Your comment is awaiting moderation.</em>', 'vivaco') ?></em>
					<br />
					<?php endif; ?>
					<?php comment_text() ?>
				</div>

				<?php if ( have_comments() ) : ?>
						<?php comment_reply_link(array_merge( $args, array('before' => '<div class="reply"><span class="reply-icon base_clr_txt"><i class="fa fa-comment-o"></i></span>' ,'depth' => $depth, 'max_depth' => $args['max_depth'], 'after' => '</div>'))) ?>
				<?php endif; // end have_comments() ?>

			</div>

	<?php }
}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/engine/lib/tgm-plugin-activation/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function startuply_theme_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme.
		array(
			'name'               => 'Visual Composer', // The plugin name.
			'slug'               => 'js_composer', // The plugin slug (typically the folder name).
			'source'             => 'http://vivaco.com/ext/js_composer_4.11.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '4.11', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		),

		/*
		array(
			'name'               => 'Templatera',
			'slug'               => 'templatera',
			'source'             => get_template_directory() . '/engine/plugins/templatera.zip',
			'required'           => true,
			'version'            => '1.1.1',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		*/

		array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => 'http://vivaco.com/ext/revslider_5.1.6.zip',
			'required'           => false,
			'version'            => '5.1.6',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Contact Form 7',
			'slug'               => 'contact-form-7',
			'source'             => 'http://downloads.wordpress.org/plugin/contact-form-7.zip',
			'required'           => true,
			'version'            => '4.4',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Envato WordPress Toolkit',
			'slug'               => 'envato-wordpress-toolkit-master',
			'source'             => 'http://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
			'required'           => false,
			'version'            => '1.7.3',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Contact Form DB',
			'slug'               => 'contact-form-7-to-database-extension',
			'source'             => 'http://downloads.wordpress.org/plugin/contact-form-7-to-database-extension.zip',
			'required'           => false,
			'version'            => '2.10.1',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Easy Digital Downloads',
			'slug'               => 'easy-digital-downloads',
			'source'             => 'http://downloads.wordpress.org/plugin/easy-digital-downloads.zip',
			'required'           => false,
			'version'            => '2.5.9',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'vivaco' ),
			'menu_title'                      => __( 'Install Plugins', 'vivaco' ),
			'installing'                      => __( 'Installing Plugin: %s', 'vivaco' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'vivaco' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'vivaco' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'vivaco' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'vivaco' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'startuply_theme_register_required_plugins' );

function startuply_options_updated($options) {
	update_option( 'startuply-options-updated', 'changed' );
}
add_action( 'optionsframework_after_validate', 'startuply_options_updated');


function startuply_set_menus_columns($columns ) {
	$desc_key = 'managenav-menuscolumnshidden';
	$hidden   = get_user_option( $desc_key );
	$user_id  = wp_get_current_user()->ID;

	// default menu meta-boxes array ( 0 => 'link-target', 1 => 'description', 2 => 'xfn', 3 => 'css-classes' );
	if ( !empty( $hidden ) && FALSE !== ( $key = array_search( 'css-classes', $hidden ) ) ) {
		if ( !empty( $hidden[ $key ] ) && is_array( $hidden[ $key ] ) ) {
			unset( $hidden[ $key ] );
			update_user_option( $user_id, $desc_key, $hidden );
		}
	}

	return $columns;
}
add_filter( 'manage_nav-menus_columns', 'startuply_set_menus_columns', 99 );


function vivaco_compile_theme_less() {

	$less = vivaco_generate_less_vars();

	if( is_multisite() ) {
		global $blog_id;
		$output_file = THEME_CACHE_DIR . '/' . THEME_OPTIONS_VARS_LESS . '-' . $blog_id .'.less';
	} else {
		$output_file = THEME_CACHE_DIR . '/' . THEME_OPTIONS_VARS_LESS . '.less';
	}

	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/template.php' );

	WP_Filesystem();
	global $wp_filesystem;

	if ( ! $wp_filesystem->put_contents( $output_file, $less, 0644) ) {
			add_settings_error( 'options-framework', 'error_update_options', __( 'Can\'t save to cache/theme-option.css file, using inline styles instead', 'startuply' ), 'error' );
			return false;
	} else {
			return true;
	}

}


if ( !function_exists( 'startuply_update_less' ) ) {
	function startuply_update_less() {
		
		$var = vivaco_generate_less_vars();
		
		if( $var ) {

			$css_file = THEME_CACHE_DIR .'/'. THEME_OPTIONS_CSS.'.css';
			$less_file = THEME_DIR .'/css/less/'.  THEME_OPTIONS_LESS . '.less';
			
			try {
				$parser = new Less_Parser( );
				$parser->parseFile($less_file);
				$parser->parse( $var );
				$css = $parser->getCss();

			} catch (Exception $e) {
				print $e->getMessage();
				return false;
			}
			
			//START USER CUSTOM CSS FROM THEME OPTIONS
			$theme_custom_css = startuply_option( 'custom_css', '');
			if ( strlen($theme_custom_css) ) {
				$custom_css =  $theme_custom_css. "\r\n";
			}
			else {
				$custom_css = '';
			}

			$custom_css_xs = startuply_option( 'custom_css_xs', '');
			if ( strlen($custom_css_xs) ) {
				$custom_css .= '@media (max-width: 767px) {' . "\r\n";
				$custom_css .= $custom_css_xs . "\r\n";
				$custom_css .=  '}' . "\r\n";
			}
			else {
				$custom_css .= '';
			}

			$custom_css_sm = startuply_option( 'custom_css_sm', '');
			if ( strlen($custom_css_sm) ) {
				$custom_css .= '@media (min-width: 768px) and (max-width: 991px) {' . "\r\n";
				$custom_css .= $custom_css_sm . "\r\n";
				$custom_css .= '}' . "\r\n";
			}
			else {
				$custom_css .= '';
			}
			
			$custom_css_md = startuply_option( 'custom_css_md', '');
			if ( strlen($custom_css_md) ) {
				$custom_css .= '@media (min-width: 992px) and (max-width: 1199px) {' . "\r\n";
				$custom_css .= $custom_css_md . "\r\n";
				$custom_css .= '}' . "\r\n";
			}
			else {
				$custom_css .= '.custom_css_md() { }';
			}

			$custom_css_lg = startuply_option( 'custom_css_lg', '');
			if ( strlen($custom_css_lg) ) {
				$custom_css .= '@media (min-width: 1200px) {' . "\r\n";
				$custom_css .= $custom_css_lg . "\r\n";
				$custom_css .= '}' . "\r\n";
			}
			else {
				$custom_css .= '';
			}

			$css = $css . $custom_css;

			require_once( ABSPATH . 'wp-admin/includes/file.php' );

			WP_Filesystem();

			global $wp_filesystem;
			if ( ! $wp_filesystem->put_contents( $css_file, $css, 0644) ) {
				add_settings_error( 'options-framework', 'error_update_options', __( 'Error save less to css', 'startuply' ), 'error' );
				return false;
			}
			else {
				return $less_file;
			}

		}
		else {
			add_settings_error( 'update-less', 'error_update_options', __( 'Error save less to css', 'startuply' ), 'error' );
			return false;
		}

	}
}
add_action("after_switch_theme", "startuply_update_less");
add_action("after_switch_theme", "startuply_custom_page_nav");

if ( !function_exists('startuply_custom_page_nav') ) {
	function startuply_custom_page_nav() {

		$var = get_pageid_override_menu();
 
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		WP_Filesystem();
		global $wp_filesystem;
 
		$less_file = THEME_DIR .'/css/less/'.  CUSTOM_NAV_LESS;

			if( is_multisite() ) {
				global $blog_id;
				$css_file = THEME_CACHE_DIR . '/' . THEME_CONFIG_CSS . '-' . $blog_id .'.less';
			}
			else {
				$css_file = THEME_CACHE_DIR .'/'. CUSTOM_NAV.'.css';
			}

 
		if(!empty($var)) {

			try {
			  $parser = new Less_Parser( );
			  $parser->parseFile($less_file);
				$parser->parse( $var );
			  $css = $parser->getCss();

			} catch (Exception $e) {
			  print $e->getMessage();
			  return false;
			}

			if ( ! $wp_filesystem->put_contents( $css_file, $css, 0644) ) {
				add_settings_error( 'options-framework', 'error_update_options', __( 'Error save less to css', 'startuply' ), 'error' );
				return false;
			}
		} else {
			if ( ! $wp_filesystem->put_contents( $css_file, '', 0644) ) {
				add_settings_error( 'options-framework', 'error_update_options', __( 'Error save less to css', 'startuply' ), 'error' );
				return false;
			}
		}
	}
}
add_action( 'acf/save_post', 'startuply_custom_page_nav' );

//check if needed CSS files exist, create them if not
if( !function_exists('startuply_check_css_cache') ) {
	function startuply_check_css_cache(){
		if( !file_exists( get_template_directory() . '/cache/theme-options.css' )) {
			startuply_update_less(); //re-create new LESS files
		}		
		if( !file_exists( get_template_directory() . '/cache/theme-nav.css' )) {
			startuply_custom_page_nav(); //re-create new LESS files
		}
	}
}
add_action( 'wp_enqueue_scripts', 'startuply_check_css_cache', 100, 0);

if ( !function_exists( 'startuply_get_all_option' ) ) {
	function startuply_get_all_option($default = false) {
		$config = get_option( 'optionsframework' );

		if ( ! isset( $config['id'] ) ) {
			return $default;
		}

		$options = get_option( $config['id'] );

		if ( isset( $options ) ) {
			return $options;
		} else {
			return $default;
		}
	}
}

/**
 * remove meta box to the page screen
 */
if (is_admin()) :
function startuply_reorder_meta_box( $post_type ) {
	global $wp_meta_boxes;

	if(isset($wp_meta_boxes['page']['side']['default']['vc_teaser'])) {
		$teaser = $wp_meta_boxes['page']['side']['default']['vc_teaser'];
		$wp_meta_boxes['page']['side']['low']['vc_teaser'] = $teaser;

		unset($wp_meta_boxes['page']['side']['default']['vc_teaser']);
	}
}
add_action('do_meta_boxes', 'startuply_reorder_meta_box', 999);
endif;

if ( ! function_exists( 'vsc_css_compress' ) ) {
	function vsc_css_compress( $css ) {
		$css  = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
		$css  = str_replace( ': ', ':', $css );
		$css  = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
		return $css;
	}
}


// Rearrange the admin menu

if( ! function_exists( 'array_column' )) { // fallback for php < 5.5
	function array_column($array, $column) {
		$ret = array();
		foreach ($array as $row) {
			$ret[] = $row[$column];
		}
		return $ret;
	}
}

$startuply_menu_data = array(  // rearrange this menu to new order
	//'link-manager.php', // Links

	array(
		'slug' => 'index.php', // Dashboard
	),
	array(
		'slug' => 'edit.php', // Posts
	),
	array(
		'slug' => 'upload.php', // Media
	),
	array(
		'slug' => 'edit.php?post_type=page', // Pages
	),
	array(
		'slug' => 'edit-comments.php', // Comments
	),
	array(
		'slug' => 'themes.php', // Appearance
	),
	array(
		'slug' => 'plugins.php', // Plugins
	),
	array(
		'slug' => 'users.php', // Users
	),

	// separator
	array(
		'slug' => 'separator2', // Second separator
	),
	// separator


	array(
		'slug' => 'tools.php', // Tools
	),
	array(
		'slug' => 'options-general.php', // Settings
	),
		// separator
	array(
		'slug' => 'separator1', // First separator
	),
	// separator


	array(
		'slug' => 'options-framework', // Startuply Option
	),
	array(
		'slug' => 'startuply_import', // Demo data
		'parent_slug' => 'options-framework'
	),
	array(
		'slug' => 'envato-wordpress-toolkit', // Evanto Toolkit
		'parent_slug' => 'options-framework'
	),
	array(
		'slug' => 'edit.php?post_type=templatera', // VC Templates
		'parent_slug' => 'options-framework'
	),
	array(
		'slug' => 'edit.php?post_type=vc_grid_item', // Grid Elements
		'parent_slug' => 'options-framework'
	),
	array(
		'slug' => 'edit.php?post_type=team', // Team
	),
	array(
		'slug' => 'edit.php?post_type=portfolio', // Portfolio
	),
	array(
		'slug' => 'edit.php?post_type=testimonials', // Testimonials
	),
	array(
		'slug' => 'wpcf7', // Contact Form 7
		'name' => __('Forms', 'vivaco')
	),
	array(
		'icon_url' => 'dashicons-admin-generic',
		'slug' => 'CF7DBPluginSubmissions',
		'name' => __('Forms Data', 'vivaco')
	),
	array(
		'slug' => 'edit.php?post_type=download', // Easy digital downloads
		'name' => __('EDD Products', 'vivaco')
	),


	// separator

	// other plugin pages
	array(
		'slug' => 'vc-general', // Last separator
	),
	array(
		'slug' => 'revslider', // Last separator
	),
	array(
		'slug' => 'themepunch-google-fonts', // Last separator
	),
);

function startuply_reorder_dashboard_menu($order) {
	if (!$order) {
		return true;
	}
	global $startuply_menu_data;
	return array_column($startuply_menu_data, 'slug');
}
add_filter('custom_menu_order', 'startuply_reorder_dashboard_menu'); // Activate custom_menu_order
add_filter('menu_order', 'startuply_reorder_dashboard_menu');

function startuply_rename_dashboard_menu() {
	global $menu;
	global $startuply_menu_data;
	foreach ($startuply_menu_data as $item) {
		if( !empty($item['name'])) {
			foreach ($menu as $key => $value) { // $value = array ('menu title', 'capabilites', 'slug', 'page title', 'menu class', 'callback?', 'menu icon')
				if ( $value[2] == $item['slug'] ) {
					$menu[$key][0] = $item['name'];// menu title
					$menu[$key][3] = $item['name'];// page title
				}
			}
		}
	}
}
add_action( 'admin_menu', 'startuply_rename_dashboard_menu' );


function startuply_change_nesting_dashboard_menu() {
	global $menu;
	global $submenu;

	if(empty($menu)) {
		return;
	}

	global $startuply_menu_data;
	foreach ($startuply_menu_data as $item) {
		if( !empty($item['parent_slug']) ) {
			$first = null;
			foreach ($menu as $key => $value) {
				if ( $value[2] == $item['parent_slug'] ) {
					$first = $value;
				}
			}

			foreach ($menu as $key => $value) { // $value = array ('menu title', 'capabilites', 'slug', 'page title', 'menu class', 'callback?', 'menu icon')
				if ( $value[2] == $item['slug'] ) {
					$removed_item = remove_menu_page( $item['slug'] );

					if ( $removed_item !== false ) {
						if ( empty($submenu[$item['parent_slug']]) ) { // duplicate Top level menu item as first child
							unset($first[4]); // remove additional item class from top level menu
							if ($first[0] == 'Startuply' && $item['parent_slug'] == 'options-framework' ) { // for first menu item in Startuply block
								$first[0] = __('Theme Options', 'vivaco');
								$first[3] = __('Theme Options', 'vivaco');
							}

							$submenu[$item['parent_slug']][] = $first;
						}

						unset($removed_item[4]); // remove additional item class from top level menu
						$submenu[$item['parent_slug']][] = $removed_item;

						unset($submenu[$item['slug']]); // remove sub menu child elements, if exist
					}
				}
			}
		}
	}
}
add_action( 'admin_init', 'startuply_change_nesting_dashboard_menu');


# Returns current URL of the page
####################################################################################################
function startuply_current_url($only_url = null, $port = null){
	$pageURL = (is_ssl()) ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		if(is_null($port)){
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		}else{
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	if(is_null($only_url)){
		return $pageURL;
	}else{
		$url = explode('?', $pageURL);
		return $url[0];
	}
}

function startuply_wpcf7_on_success_send_mail($WPCF7_ContactForm) {

	$submission = WPCF7_Submission::get_instance();
	$data = $submission->get_posted_data();

	$email = '';
	$fullname = '';

	$hide_after_send = '';
	$redirect_after_send = '';
	$mail_list_provider = '';

	$api_keys = array();
	$api_keys_all = array( 'mailchimp', 'aweber', 'madmimi', 'campaign_monitor', 'get_response' );

	foreach ($api_keys_all as $key) {

		$key_values = startuply_option("vivaco_{$key}_api_key", '');

		if ( !empty($key_values) ) {
			$api_keys[$key] = $key_values;
		}
	}


	if(!empty($data['_wpcf7_vsc_hide_after_send'])){ $hide_after_send = $data['_wpcf7_vsc_hide_after_send']; }
	if(!empty($data['_wpcf7_vsc_redirect_after_send'])){ $redirect_after_send = $data['_wpcf7_vsc_redirect_after_send']; }

	if(!empty($data['_wpcf7_vsc_provider'])){ $mail_list_provider = $data['_wpcf7_vsc_provider']; }

	if(!empty($data['_wpcf7_unit_tag'])){ $unit_id = $data['_wpcf7_unit_tag']; }
	if(!empty($data['EMAIL'])){ $email = $data['EMAIL']; }
	if(!empty($data['FULLNAME'])){ $fullname = $data['FULLNAME']; }

	$hide_after_send = (filter_var($hide_after_send, FILTER_VALIDATE_BOOLEAN) === true);
	$redirect_after_send = (filter_var($redirect_after_send, FILTER_VALIDATE_BOOLEAN) === true);

	$on_sent_ok_array = array();

	$wpcf7 = WPCF7_ContactForm::get_current();
	$on_sent_ok = $wpcf7->additional_setting('on_sent_ok', false);

	foreach( $on_sent_ok as $action ) {
		$on_sent_ok_array[] = "on_sent_ok: $action";
	}

	// check if form should be hidden on successful submit
	if( $hide_after_send ) {
		$on_sent_ok_array[] = "on_sent_ok: \"$('#$unit_id .form').hide();\"";
	}

	if( !empty($mail_list_provider) && !empty($api_keys) && !empty($api_keys[$mail_list_provider]) ) { // code for mailchimp here

		$params = array();

		$params['email'] = $email;

		if ($fullname != ''){
			$tmp = explode (" ", $fullname, 2); // for name as Alex Victor Maria
			$params['fname'] = $tmp[0];
			$params['lname'] = empty($tmp[1]) ? '' : $tmp[1];
		} else {
			$params['fname'] = $data['FNAME'];
			$params['lname'] = $data['LNAME'];
		}

		if ($mail_list_provider !== 'aweber') {
			$params['akey'] = $api_keys[$mail_list_provider];
		}

		$params['lid'] = $data["_wpcf7_vsc_{$mail_list_provider}_list_id"];

		if ($mail_list_provider == 'mailchimp') {
			$params['dopt'] = (filter_var($data['_wpcf7_vsc_double_opt'], FILTER_VALIDATE_BOOLEAN) === true); // check this!!
		}

		if ($mail_list_provider == 'madmimi') {
			$params['madmimi_email'] = $data['_wpcf7_vsc_madmimi_email'];
		}


		require_once ( get_template_directory() . "/engine/mailing-list/{$mail_list_provider}/{$mail_list_provider}.php" );

        $process = "process_{$mail_list_provider}";

        $result = $process($params);

        $data["{$mail_list_provider}_result"] = $result;

        if (strpos(strtolower($result), 'error') !== false) {
			error_log( print_r( $result, true ) ); // simple write data to wp-content/debug.log. Check it!!!
        }

		//error_log( print_r( $data, true ) ); // simple write data to wp-content/debug.log. Check it!!!
	}

	if( $redirect_after_send && !empty($data['_wpcf7_vsc_redirect_url']) ) { // code for redirect here

		$redirect_url = base64_decode( $data['_wpcf7_vsc_redirect_url'] );

		$on_sent_ok_array[] = "on_sent_ok: \"window.location.href='{$redirect_url}';\"";

	}

	if( count($on_sent_ok_array) > 0 ) {

		$properties = array('additional_settings' => implode("\n", $on_sent_ok_array));

		$wpcf7->set_properties($properties);

	}

}
add_action("wpcf7_mail_sent", "startuply_wpcf7_on_success_send_mail");

if ( ! function_exists( 'startuply_menu_style' ) ) {
	function startuply_menu_style($page_id) {

		$prefix = 'vivaco_';

		$page_menu_override = get_field($prefix . 'override', $page_id);
		
		$page_menu_style = get_field($prefix . 'menu_style', $page_id);

		$options = startuply_get_all_option();

		//if(!empty($page_menu_style) && $page_menu_override != 'false') {
		if(!empty($page_menu_style)) {
			$menu_style = $page_menu_style;
		}
		else {
			if(!empty($options['menu_style'])) {
				$menu_style = $options['menu_style'];
			}
		}

		echo $menu_style;
		
	}
}



//Remove paddings for rows on mobiles 
if ( ! function_exists( 'startuply_remove_responsive_paddings' ) ) {
	function startuply_remove_responsive_paddings() {
		$responsive_css = "<style>@media (max-width: 767px) {
		.vc_row {padding:0px !importat; padding-top:10px !important; padding-right:0px !important; padding-bottom:10px !important; padding-left:0px !important;}
	}</style>";
		echo $responsive_css;
	}
}
add_action( 'wp_footer', 'startuply_remove_responsive_paddings');

//Startuply default menu
if ( ! function_exists( 'startuply_default_menu' ) ) {
	function startuply_default_menu() {
		$html = '<ul id="menu-demo-menu" class="navigation-bar navigation-bar-left">';
			$html .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
				$html .= '<a href="' . esc_url( home_url() ) . '/wp-admin/nav-menus.php" title="' . esc_html__( 'Home', 'ventcamp' ) . '">';
					$html .= esc_html__( 'ADD THEME MENU', 'ventcamp' );
				$html .= '</a>';
			$html .= '</li>';
		$html .= '</ul>';
		echo $html;
	}
}
//custom exceprt
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*Adding Fonts*/
function add_fonts_google(){
	wp_enqueue_style('MavenPro', 'https://fonts.googleapis.com/css?family=Maven+Pro');
}
add_action('wp_enqueue_scripts', 'add_fonts_google');
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-logo.png);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/*Pagination*/
// numbered pagination
function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}
//Change amp site icon
add_filter( 'amp_post_template_data', 'xyz_amp_set_site_icon_url' );

function xyz_amp_set_site_icon_url( $data ) {
    // Ideally a 32x32 image
    $data[ 'site_icon_url' ] = get_stylesheet_directory_uri() . '/images/Dec2016/amp-site-icon.png';
    return $data;
}
//Add child  amp style.php
add_filter( 'amp_post_template_file', 'amp_set_cutome_style_path', 10, 3 );  
// Setting custom stylesheet 
function amp_set_cutome_style_path( $file, $type, $post ) {
 if ( 'style' === $type ) { $file = dirname( __FILE__ ) . '/amp/style.php'; } return $file; }
//Schema page identify
function html_schema()
{
    $schema = 'http://schema.org/';
 
    // Is single post
    if(is_single())
    {
        $type = "Article";
    }
    // Is blog home, archive or category
    else if(is_home()||is_archive()||is_category())
    {
        $type = "Blog";
    }
    // Is static front page
    else if(is_front_page())
    {
        $type = "Website";
    }
    // Is a general page
     else
    {
        $type = 'WebPage';
    }
 
    echo 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
}

/**
 * Redirect user after successful login.
 */
function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
function logout_redirect_home(){
	wp_safe_redirect(home_url());
	exit;
}
add_action('wp_logout', 'logout_redirect_home');

// New order status Woocommerce
/*Returned Order status*/
add_action( 'init', 'register_my_new_order_statuses' );

function register_my_new_order_statuses() {
    register_post_status( 'wc-returned', array(
        'label'                     => _x( 'Returned', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Returned <span class="count">(%s)</span>', 'Returned<span class="count">(%s)</span>', 'woocommerce' )
    ) );
    register_post_status( 'wc-reshipped', array(
        'label'                     => _x( 'Re-Shipped', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Re-shipped <span class="count">(%s)</span>', 'Re-shipped<span class="count">(%s)</span>', 'woocommerce' )
    ) );
}

add_filter( 'wc_order_statuses', 'my_new_wc_order_statuses' );
add_filter( 'wc_order_statuses', 'my_new_wc_order_statuses_two' );
// Register in wc_order_statuses.
function my_new_wc_order_statuses( $order_statuses ) {
    $order_statuses['wc-returned'] = _x( 'Returned', 'Order status', 'woocommerce' );

    return $order_statuses;
}
// Register in wc_order_statuses.
function my_new_wc_order_statuses_two( $order_statuses_two ) {
    $order_statuses_two['wc-reshipped'] = _x( 'Re-Shipped', 'Order status', 'woocommerce' );

    return $order_statuses_two;
}

// Add a custom user role

add_role( 'student_role', 'Student', array( 'read' => true, 'level_0' => true ) );
// Add coupon to students
if ( current_user_can('Student')) {
	$coupon_code = 'behealthystudent';
    $woocommerce->cart->add_discount( $coupon_code );
    $woocommerce->show_messages();
}
add_action( 'init', 'create_post_type_ingredient' );
function create_post_type_ingredient() {
  register_post_type( 'ingredient',
    array(
      'labels' => array(
        'name' => __( 'ingredient' ),
        'singular_name' => __( 'ingredient' )
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_menu' => 'edit.php',
      'supports'     => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'custom-fields'
			)
    )
  );
}
/***************************************/
//hide admin notices Temporary
add_action('admin_enqueue_scripts', 'ds_admin_theme_style');
add_action('login_enqueue_scripts', 'ds_admin_theme_style');
function ds_admin_theme_style() {
    if (current_user_can( 'manage_options' )) {
        echo '<style>.update-nag, .updated,   .error, .is-dismissible { display: none; }</style>';
    }
}
//For Ajax Load
function infinite_posts(){
	wp_enqueue_script('posts-load-script', get_template_directory_uri(). '/js/postsLoad.js', array(), '1.0.0', true);

}

add_action('wp_enqueue_scripts', 'infinite_posts');
require get_template_directory() . '/inc/ajax.php';
require get_template_directory() . '/inc/behealhty_posts_widget.php';
require get_template_directory() . '/inc/embed-code.php';
require get_template_directory() . '/inc/metabox_ingredient.php';
require get_template_directory() . '/inc/redirectAffiliate.php';
require get_template_directory() . '/inc/bh_sidebars.php';
require get_template_directory() . '/inc/behealhty_contact_widget.php';


//Login Form Style
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/inc/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );
