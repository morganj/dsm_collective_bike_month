<?php

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

// Check if user has already filled out demographics
function user_valid(){
    if(!is_user_logged_in())
        return false;

    $user_id = get_current_user_id();

    $fields = ['dsm_bike_zip', 'dsm_bike_gender', 'dsm_bike_age'];
    foreach($fields as $field) {
        if(!get_user_meta($user_id, $field, true))
            return false;
    }
    return true;
}
add_action('wp_head', 'user_valid');

// Submit user data
function bikes_submit_user_data(){
    $user_id = $_POST['user'];
    $results = [];
    $results[] = update_user_meta($user_id, 'dsm_bike_age', intval($_POST['user_age']));
    $results[] = update_user_meta($user_id, 'dsm_bike_gender', sanitize_text_field($_POST['user_gender']));
    $results[] = update_user_meta($user_id, 'dsm_bike_zip', sanitize_text_field($_POST['user_zipcode']));

    wp_send_json($results);
}
add_action('wp_ajax_bikes_submit_user_data', 'bikes_submit_user_data');           // for logged in user
add_action('wp_ajax_no_priv_bikes_submit_user_data', 'bikes_submit_user_data');    // if user not logged in

// Update events user attended
function bikes_check_event($id){
    if(strcasecmp($_POST['eventCode'], get_field('bikes_event_code')) == 0){
        $events_redeemed = get_user_meta(get_current_user_id(), 'events_redeemed', true);
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
        return true;    
    }else{
        return false;
    }  
}
add_action('wp_ajax_bikes_check_event', 'bikes_check_event');           // for logged in user
add_action('wp_ajax_no_priv_bikes_check_event', 'bikes_check_event');    // if user not logged in

// Get event status details
function bikes_event_details(){

    $user_valid = user_valid();
    $event_code = get_field('bikes_event_code');
    $event_id = get_the_id();
    $event_year = tribe_get_start_date(get_the_id(), false, 'Y');

    if(!is_user_logged_in()){
        $details = array(
            'event_code' => $event_code,
            'event_id' => $event_id,
            'event_year' => $event_year,
            'event_status' => null,
            'user_valid' => $user_valid,
            'user_logged_in' => 0
        );
        return $details;
    }

    $events_redeemed = json_decode(get_user_meta(get_current_user_id(), 'events_redeemed', true), true);

    if(!is_null($events_redeemed) and array_key_exists($event_year, $events_redeemed)){
        $event_status = array_search($event_id, $events_redeemed[(string)$event_year]);
        if(is_int($event_status))
            $event_status = true;
    }
    else
        $event_status = false;

    $details = array(
        'event_code' => $event_code,
        'event_id' => $event_id,
        'event_year' => $event_year,
        'event_status' => $event_status,
        'user_valid' => $user_valid,
        'user_logged_in' => is_user_logged_in()
    );
    return $details;
}
add_action('wp_head', 'bikes_event_details');

// Initialize styles and scripts with info they need
function bikes_js_init(){

    // Get info to send
    $args = bikes_event_details();
    $args = array_merge($args, ['ajax_url' => admin_url( 'admin-ajax.php' )]);

    // Initialize
    wp_enqueue_script('bike_event_code', get_stylesheet_directory_uri().'/includes/event-redeemer/event-redeemer.js');
    wp_localize_script('bike_event_code', 'event_redeemer', $args);
    wp_enqueue_style('event_redeemer_style', get_stylesheet_directory_uri().'/includes/event-redeemer/event-redeemer.css');
}
add_action('wp_enqueue_scripts', 'bikes_js_init');

// Get class to add to event redeemer div
/*function bikes_event_classes(){
    $details = bikes_event_details();
    $status = $details['event_status'];

    if(!is_int($status))
        return 'incomplete';
    return 'complete';
}
add_action('wp_head', 'bikes_event_classes');*/
