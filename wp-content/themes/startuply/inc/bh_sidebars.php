<?php
//Add 404 page sidebar
add_action( 'widgets_init', 'widget_404_add' );
function widget_404_add() {
    register_sidebar( array(
        'name' => __( '404 Page', 'theme-slug' ),
        'id' => 'sidebar-404',
        'description' => __( 'Widgets in this area will be shown on 404 Page.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );
}
//Add about us footer sidebar
add_action( 'widgets_init', 'widget_footer_add' );
function widget_footer_add() {
    register_sidebar( array(
        'name' => __( 'Footer Column 1', 'theme-slug' ),
        'id' => 'sidebar-footer1',
        'description' => __( 'Widgets in this area will be shown on Footer Column 1.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h4 class="widgettitle">',
	'after_title'   => '</h4>',
    ) );
}