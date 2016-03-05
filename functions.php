<?php

include 'includes/event-redeemer/event-redeemer.php';

// Event API
function dsmbc_event_args ($args){
  $args['rest_base'] = 'tribe_events';
  $args['rest_controller_class'] = 'WP_REST_Posts_Controller';
  $args['show_in_rest'] = true;
  return $args; 
}
add_filter('tribe_events_register_event_type_args', 'dsmbc_event_args');

// Enqueue styles
function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );

    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous');
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Calendar widget space
function calendar_widget_init() {

    register_sidebar( array(
        'name'          => 'Calendar Widget',
        'id'            => 'calendar_widget',
        'before_widget' => '<div class="widget-space">',
        'after_widget'  => '</div>',
    ) );
}
add_action( 'widgets_init', 'calendar_widget_init' );
