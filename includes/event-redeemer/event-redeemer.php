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

        if($badges->{$_POST['eventYear']})
            array_push($badges->{$_POST['eventYear']}, $_POST['eventID']);
        else{
            $badges->{$_POST['eventYear']} = array($_POST['eventID']);
        }
    }
    else{
        $badges = array($_POST['eventYear'] => array($_POST['eventID']));
    }

    update_user_meta(get_current_user_id(), 'badges', json_encode($badges));
}
add_action('wp_ajax_bikes_check_event', 'bikes_check_event');           // for logged in user
add_action('wp_ajax_no_priv_bikes_check_event', 'bikes_check_event');    // if user not logged in


// Initialize styles and scripts with info they need
function bikes_js_init(){

    // Get info to send
    $args = array(
        'eventCode' => get_field('bikes_event_code'),
        'eventID' => get_the_id(),
        'eventYear' => tribe_get_start_date(get_the_id(), false, 'Y')
    );

    wp_enqueue_script('bike_event_code', get_template_directory_uri().'/includes/event-redeemer/event-redeemer.js');
    wp_localize_script('bike_event_code', 'event_redeemer', $args);
    wp_enqueue_style('event_redeemer_style', get_template_directory_uri().'/includes/event-redeemer/event-redeemer.css');
}
add_action('wp_enqueue_scripts', 'bikes_js_init');












