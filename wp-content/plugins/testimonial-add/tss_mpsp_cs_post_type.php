<?php




/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function tss_mpsp_slider_posts_type() {

	$labels = array(
		'name'                => _x( 'Testimonial Sliders', 'text-domain' ),
		'singular_name'       => _x( 'Testimonial Slider', 'text-domain' ),
		'add_new'             => _x( 'Add New Testimonial Slider', 'text-domain', 'text-domain' ),
		'add_new_item'        => _x( 'Add New Testimonial Slider', 'text-domain' ),
		'edit_item'           => _x( 'Edit Testimonial Slider', 'text-domain' ),
		'new_item'            => _x( 'New Testimonial Slider', 'text-domain' ),
		'view_item'           => _x( 'View Testimonial Slider', 'text-domain' ),
		'search_items'        => _x( 'Search Testimonial Sliders', 'text-domain' ),
		'not_found'           => _x( 'No Testimonial Sliders found', 'text-domain' ),
		'not_found_in_trash'  => _x( 'No Testimonial Sliders found in Trash', 'text-domain' ),
		'parent_item_colon'   => _x( 'Parent Testimonial Slider:', 'text-domain' ),
		'menu_name'           => _x( 'Testimonial Sliders', 'text-domain' ),
	);

	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports' => array('title','custom_fields')
	);

	register_post_type( 'tss_slider', $args );
}

add_action( 'init', 'tss_mpsp_slider_posts_type' );



function tss_data_post_type() {

	$labels = array(
		'name'                => _x( 'Testimonials', 'text-domain' ),
		'singular_name'       => _x( 'Testimonials ', 'text-domain' ),
		'add_new'             => _x( 'Add New Testimonial ', 'text-domain', 'text-domain' ),
		'add_new_item'        => _x( 'Add New Testimonial ', 'text-domain' ),
		'edit_item'           => _x( 'Edit Testimonial ', 'text-domain' ),
		'new_item'            => _x( 'New Testimonial ', 'text-domain' ),
		'view_item'           => _x( 'View Testimonial ', 'text-domain' ),
		'search_items'        => _x( 'Search Testimonials', 'text-domain' ),
		'not_found'           => _x( 'No Testimonials found', 'text-domain' ),
		'not_found_in_trash'  => _x( 'No Testimonials found in Trash', 'text-domain' ),
		'parent_item_colon'   => _x( 'Parent Testimonial :', 'text-domain' ),
		'menu_name'           => _x( 'Testimonials', 'text-domain' ),
	);

	$args = array(
		'labels'                   => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array('category'),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports' => array('title','custom_fields')
	);

	register_post_type( 'tss_data', $args );
}

add_action( 'init', 'tss_data_post_type' );







 ?>