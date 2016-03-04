<?php

// Enqueue jQuery
function jquery_init() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'jquery_init');

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


// Update user badge info
function bikes_check_event($id){

    $badges = get_user_meta(get_current_user_id(), 'badges', true);

    if($badges){
        $badges = json_decode($badges);

        if($badges->{$_POST['year']})
            array_push($badges->{$_POST['year']}, 'k'.$_POST['event']);
        else{
            $badges->{$_POST['year']} = array('i'.$_POST['event']);
        }
    }
    else{
        $badges = array($_POST['year'] => array('m'.$_POST['event']));
    }

    update_user_meta(get_current_user_id(), 'badges', json_encode($badges));
}
add_action('wp_ajax_bikes_check_event', 'bikes_check_event');           // for logged in user
add_action('wp_ajax_no_priv_bikes_check_event', 'bikes_check_event');    // if user not logged in


// Initialize scripts
function bikes_js_init(){
    wp_enqueue_script('bike_click', get_template_directory_uri().'/js/rest-test.js');
}
add_action('wp_enqueue_scripts', 'bikes_js_init');













