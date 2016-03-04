<?php

//REGISTER CUSTOM MENUS
function register_ebor_menus() {
  register_nav_menus( 
  	array(
  		'primary' => __( 'Standard Navigation', 'loom' ),
  		'footer' => __( 'Footer Navigation', 'loom' ),
  	) 
  );
}
add_action( 'init', 'register_ebor_menus' );

//REGISTER SIDEBARS
function ebor_register_sidebars() {

	register_sidebar(
		array(
			'id' => 'primary',
			'name' => __( 'Blog Sidebar', 'loom' ),
			'description' => __( 'Widgets to be displayed in the blog sidebar.', 'loom' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'page',
			'name' => __( 'Page With Sidebar, Sidebar', 'loom' ),
			'description' => __( 'Widgets to be displayed in the page with sidebar, sidebar.', 'loom' ),
			'before_widget' => '<div id="%1$s" class="sidebox widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);

	register_sidebar(
		array(
			'id' => 'footer1',
			'name' => __( 'Multiwidget Footer Style Column 1', 'loom' ),
			'description' => __( 'If this is set, your footer will be 1 column', 'loom' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title upper">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'footer2',
			'name' => __( 'Multiwidget Footer Style Column 2', 'loom' ),
			'description' => __( 'If this & column 1 are set, your footer will be 2 columns.', 'loom' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title upper">',
			'after_title' => '</h3>'
		)
	);
	
	
	register_sidebar(
		array(
			'id' => 'footer3',
			'name' => __( 'Multiwidget Footer Style Column 3', 'loom' ),
			'description' => __( 'If this & column 1 & column 2 are set, your footer will be 3 columns.', 'loom' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title upper">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'footer4',
			'name' => __( 'Multiwidget Footer Style Column 4', 'loom' ),
			'description' => __( 'If this & column 1 & column 2 & column 3 are set, your footer will be 4 columns.', 'loom' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title upper">',
			'after_title' => '</h3>'
		)
	);
	
	register_sidebar(
		array(
			'id' => 'singlewidget',
			'name' => __( 'Singlewidget Footer Style', 'loom' ),
			'description' => __( 'Widgets for the singleWidget footer style', 'loom' ),
			'before_widget' => '<div id="%1$s" class="widget single section-title-wrapper clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="section-title bm20">',
			'after_title' => '</h3>'
		)
	);
	
}
add_action( 'widgets_init', 'ebor_register_sidebars' );