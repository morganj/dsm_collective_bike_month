<?php 


// Event content type will be created by plugin

// Create sponsored content
function create_bikes_sponsors() {
    $labels = array(
        'name' => __( 'Sponsors' ),
        'singular_name' => __( 'Sponsor' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'sponsor')
    );

    register_post_type( 'bikes_sponsor', $args);
}
add_action( 'init', 'create_bikes_sponsors' );
