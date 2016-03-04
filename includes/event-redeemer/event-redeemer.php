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

// Update user events attended
function bikes_check_event($id){

    $events_redeemed = get_user_meta(get_current_user_id(), 'events_redeemed', true);

    // Check if this value has already been entered?
    // And if so, ignore all this unnecessary stuff

    if($events_redeemed){
        $events_redeemed = json_decode($events_redeemed, true);

        if(array_key_exists($_POST['eventYear'], $events_redeemed))
            array_push($events_redeemed[$_POST['eventYear']], $_POST['eventID']);
        else{
            $events_redeemed[$_POST['eventYear']] = array($_POST['eventID']);
        }
    }
    else{
        $events_redeemed = array($_POST['eventYear'] => array($_POST['eventID']));
    }

    update_user_meta(get_current_user_id(), 'events_redeemed', json_encode($events_redeemed));

    exit();
}
add_action('wp_ajax_bikes_check_event', 'bikes_check_event');           // for logged in user
add_action('wp_ajax_no_priv_bikes_check_event', 'bikes_check_event');    // if user not logged in

// Get event status details
function bikes_event_details(){
    $event_code = get_field('bikes_event_code');
    $event_id = get_the_id();
    $event_year = tribe_get_start_date(get_the_id(), false, 'Y');
    $events_redeemed = json_decode(get_user_meta(get_current_user_id(), 'events_redeemed', true), true);

    if(!is_null($events_redeemed) and array_key_exists($event_year, $events_redeemed))
        $event_status = array_search($event_id, $events_redeemed[(string)$event_year]);
    else
        $event_status = false;

    $details = array(
        'event_code' => $event_code,
        'event_id' => $event_id,
        'event_year' => $event_year,
        'event_status' => $event_status
    );
    return $details;
}
add_action('wp_head', 'bikes_event_details');

// Get class to add to event redeemer div
function bikes_event_classes(){
    $details = bikes_event_details();
    $status = $details['event_status'];
//    return $status;

    if(!is_int($status))
        return 'incomplete';
    return 'complete';
}
add_action('wp_head', 'bikes_event_classes');

// Initialize styles and scripts with info they need
function bikes_js_init(){

    // Get info to send
    $args = bikes_event_details();

    // Initialize
    wp_enqueue_script('bike_event_code', get_template_directory_uri().'/includes/event-redeemer/event-redeemer.js');
    wp_localize_script('bike_event_code', 'event_redeemer', $args);
    wp_enqueue_style('event_redeemer_style', get_template_directory_uri().'/includes/event-redeemer/event-redeemer.css');
}
add_action('wp_enqueue_scripts', 'bikes_js_init');












