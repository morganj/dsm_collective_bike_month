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

    // wp_enqueue_script('jquery');

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

// add_action('init', 'test_meta');
function test_meta() {
  if(is_user_logged_in()) {
    $id = get_current_user_id();
    $zip = get_user_meta('dsm_bike_zip', $id);
    die('<pre style="display:block;background-color:white;color:black;padding:15px;font-size:16px;font-family:monospace;text-align:left;">'.print_r($zip, true).'</pre>');
  }
}

add_action('branded_user_flow_after_register', 'dsmbc_register_user_meta', 10, 2);
add_action('branded_user_flow_after_update', 'dsmbc_register_user_meta', 10, 2);

function dsmbc_register_user_meta($post, $user_id) {
  update_user_meta( $user_id, 'dsm_bike_zip', $post['zip_code'] );
  update_user_meta( $user_id, 'dsm_bike_gender', $post['gender'] );
  update_user_meta( $user_id, 'dsm_bike_age', $post['age'] );

}

add_action('branded_user_register_fields', 'dsmbc_register_fields');
function dsmbc_register_fields($user) {
  if($user) {
    $zip = get_user_meta($user, 'dsm_bike_zip', true);
    $age = get_user_meta($user, 'dsm_bike_age', true);
    $gender = get_user_meta($user, 'dsm_bike_gender', true);
  }
  ob_start(); ?>
  <p class="form-row">
      <label for="zip_code"><?php _e( 'Zip Code', 'personalize-login' ); ?></label>
      <input type="text" name="zip_code" id="zip-code"<?php echo (isset($zip) ? ' value="'.$zip.'"' : ''); ?>>
  </p>
  <p class="form-row">
      <label for="age"><?php _e( 'Age', 'personalize-login' ); ?></label>
      <input type="number" name="age" id="age"<?php echo (isset($age) ? ' value="'.$age.'"' : ''); ?>>
  </p>
  <p class="form-row">
      <label for="gender"><?php _e( 'Gender', 'personalize-login' ); ?><br></label>
      <label for="gender_male"><?php _e( 'Male', 'personalize-login' ); ?><input type="radio" name="gender" id="gender_male" value="Male"<?php echo (isset($gender) && $gender == 'Male' ? ' checked' : ''); ?>></label>

      <label for="gender_female"><?php _e( 'Female', 'personalize-login' ); ?><input type="radio" name="gender" id="gender_female" value="Female"<?php echo (isset($gender) && $gender == 'Female' ? ' checked' : ''); ?>></label>
  </p>

  <?php echo ob_get_clean();
}


add_action('wp_loaded', 'dsmbc_add_acf_options');
function dsmbc_add_acf_options() {
  if( function_exists('acf_add_options_page') ) {
  	acf_add_options_page(['page_title' => 'Site-Wide Sponsors']);
  }
}

add_action('tribe_events_before_template', 'calendar_desc_markup');
add_action('tribe_events_before_template', 'dsmbc_sponsor_markup');

function calendar_desc_markup(){
ob_start(); ?>
    <div>
        <p>Participate in the Virtual Passport Adventure and earn badges to get swag! 
    So how does it work?</p>
        <ul class="calendar-description">
            <li>Join us at the event</li> 
            <li>Get the posted event code</li>  
            <li>Enter the code into the badge area on the event’s page to earn your badge!</li>
            <li>See your progress towards swag!</li> 
        </ul>
        <div>
            <h1 class="virtual-passport-title">Virtual Passport</h1>
        </div>
    </div>
<?php echo ob_get_clean();
}

function dsmbc_sponsor_markup(){
ob_start();
 if( have_rows('tier_1_sponsors', 'option') ): ?>
 
    <h1 class="virtual-passport-title">Virtual Passport</h1>
    <div>
 
    <?php while( have_rows('tier_1_sponsors', 'option') ): the_row(); ?>
 
        <div class="hero-container"><a href="<?php the_sub_field('sponsor_link'); ?>"><?php echo wp_get_attachment_image(get_sub_field('sponsor_logo')); ?> <br /><h2><?php the_sub_field('sponsor_title'); ?></h2></a></div>
        
    <?php endwhile; ?>
 
    </div>
 
<?php endif;
echo ob_get_clean();
}