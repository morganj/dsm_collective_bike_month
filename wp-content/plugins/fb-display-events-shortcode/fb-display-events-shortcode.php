<?php
/*
Plugin Name: FB Display Events Shortcode
Plugin URI: https://wordpress.org/plugins/fb-display-events-shortcode
Description: Display Facebook Events in your website using shortcode.
Version: 1.0
Author: Krzysztof Kuziel KrzyKuStudio
Author URI: http://krzykustudio.pl
Text Domain: fb-display-events-shortcode
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'FB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_NAME', 'FB Display Events Shortcode'); 
require_once( FB_PLUGIN_PATH . 'admin/admin.php');
require_once( FB_PLUGIN_PATH . 'classes/FB_event.php');
require_once( FB_PLUGIN_PATH . 'classes/class.translator.php');

//SCRIPTS
function fb_display_events_shortcode_scripts(){
		wp_enqueue_script('jquery');
		
		wp_register_script('even_script',plugin_dir_url( __FILE__ ).'js/even_js.js');
	    wp_enqueue_script('even_script');
		
		wp_register_script('jquery_tosrus__min_script',plugin_dir_url( __FILE__ ).'js/jquery.tosrus.min.all.js');
	    wp_enqueue_script('jquery_tosrus__min_script');
			
		wp_register_script('lightboxik_script',plugin_dir_url( __FILE__ ).'js/lightboxik.js',false,'');
	    wp_enqueue_script('lightboxik_script');

}
add_action('wp_enqueue_scripts','fb_display_events_shortcode_scripts');

//STYLES
function fb_display_events_shortcode_styles() {

	wp_enqueue_style( 'event-font', '//fonts.googleapis.com/css?family=Open+Sans:800italic,700italic,600italic,400italic,300italic,800,700,600,400,300&subset=latin,latin-ext' );
	wp_enqueue_style( 'dynamic-style', plugin_dir_url( __FILE__ ).'css/dynamic_styles.css', false );
	wp_enqueue_style( 'tosrus-style', plugin_dir_url( __FILE__ ).'css/jquery.tosrus.all.css', false );
	wp_enqueue_style( 'fdes-style', plugin_dir_url( __FILE__ ).'css/fdes_css.css', false ); 
}
add_action( 'wp_enqueue_scripts', 'fb_display_events_shortcode_styles' );

/** Facebook event list shortcode plugin main function
* shortcode [fb_display_events fb_user_id="id_value" or fb_event_id="id_value" or fb_user_name="name" limit="limit_query" fb_time"upcoming, past, all"] 
* example [fb_display_events fb_user_id="1234" fb_time="upcoming" limit="10"] displays list of 10 upcoming user events
*         [fb_display_events fb_event_id="1234556"] displays event with specified id
*
*/
function fb_display_events_shortcode ($atts) {
    $a = shortcode_atts( array(
        'fb_user_id' => 'not set',
		'fb_event_id' => 'not set',
		'fb_time' => 'upcoming',
		'limit' => '0',
		'fb_user_name' => 'not set'
         ), $atts );
		//page id or single eveent
		
	$fb_user_name = $a['fb_user_name'];
	if($fb_user_name != 'not set'){
		try
			{
				$variable = convert_fb_name_to_id($fb_user_name);
			}
		catch (Exception $e)
			{ 
				return $e->getMessage();
			}
	}
	$is_single_event = True;
	$fb_time = $a['fb_time'];
	if(intval($a['limit']) > 0){
		$limit = intval($a['limit']);
	}
	else{
		$limit = 0;
	}
	$message = "";
	if($fb_time == 'upcoming' or $fb_time == 'past' or $fb_time == 'all'){
		if ($a['fb_user_id'] == 'not set' and $a['fb_event_id'] == 'not set' and $a['fb_user_name'] == 'not set'){
			$message = display_id_not_set(); 
		}
		else if ($a['fb_user_id'] != 'not set' and $a['fb_event_id'] != 'not set' ){
			$message = two_display_id_set(); 
		}
		else if (isset($variable)){
			$is_single_event = False;
			try
			{
				$message = display_user_event_list($variable, $is_single_event, $fb_time, $limit);
			}
			catch (Exception $e)
			{ 
				$message = $e->getMessage();
			}
		}
		else if ($a['fb_user_id'] != 'not set' and $a['fb_event_id'] == 'not set' ){
			$variable = $a['fb_user_id'];
			$is_single_event = False;
			try
			{
				$message = display_user_event_list($variable, $is_single_event, $fb_time, $limit);
			}
			catch (Exception $e)
			{ 
				$message = $e->getMessage();
			}
		}
		else if ($a['fb_user_id'] == 'not set' and $a['fb_event_id'] != 'not set' ){
			$variable = $a['fb_event_id'];
			$is_single_event = True;
			try
			{
				$message = display_user_event_list($variable, $is_single_event, $fb_time, $limit);
			}
			catch (Exception $e)
			{ 
				$message = $e->getMessage();
			}
		}
	 }
	else{
		$message = __( 'Incorrect fb_time value', 'fb-display-events-shortcode' ); 
	}

	return $message;
}

/**
* FB get id from fb graph
*/
function convert_fb_name_to_id($name){
	
	$access_token = esc_attr( get_option('access_token') ); 
	$json_link = "https://graph.facebook.com/{$name}?access_token={$access_token}";
	
	//Exception handler
	set_error_handler(
		create_function(
			'$severity, $message, $file, $line',
			'throw new ErrorException($message, $severity, $severity, $file, $line);'
		)
	);

	try
	{
		$json = file_get_contents($json_link);
	}
	catch (Exception $e)
	{ 
		$message = "";
		// Problem with connection
		if (strpos($e->getMessage(), "php_network_getaddresses")  == True){
			$message = __( 'Connection error', 'fb-display-events-shortcode' ); 
		}
		//Problem with ID
		else if (strpos($e->getMessage(), "404 Not Found")  == True){
			$message =  __( 'Bad Request. Your fb_user_name or access token is not valid.', 'fb-display-events-shortcode' ); 
		}
		//diffrent problems
		else{
			$message = $e->getMessage();
		}
		$exc =  __( 'Caught Exception:', 'fb-display-events-shortcode' ); 
		throw new Exception($exc . ' ' .  $message);
	}
	/**  Use only in php5.5 or higher
	finally
	{
		restore_error_handler();
	}
	other case line below:
	*/
	restore_error_handler();
		
	$obj = json_decode($json, true);
	if(isset($obj['error']))
	{
		$exc = __( 'fb_user_name is not valid', 'fb-display-events-shortcode' );
		throw new Exception($exc);
	}
	// return valid id
	return $obj['id'];
}

/**
* Return formated user event list
*/
function display_user_event_list($id, $is_single_event, $fb_time, $limit){
	$fb_page_id = $id;
	
	if($fb_time == 'past'){
		// get events for the past x years
		$year_range = 2;
		 
		// automatically adjust date range
		// human readable years
		$since_date = date('Y-01-01', strtotime('-' . $year_range . ' years'));
		$until_date = date('Y-m-d', strtotime('-1 day'));
	}
	else if($fb_time == 'all'){
		// between past 4 and future for years
		$year_range = 2;
 
		// automatically adjust date range
		// human readable years
		$since_date = date('Y-01-01', strtotime('-' . $year_range . ' years'));
		$until_date = date('Y-01-01', strtotime('+' . $year_range . ' years'));
	}
	else{
	//Upcoming events
	 // get events for the next x years
	$year_range = 2;
	 
	// automatically adjust date range
	// human readable years
	$since_date = date('Y-m-d');
	$until_date = date('Y-12-31', strtotime('+' . $year_range . ' years'));
	}

	// unix timestamp years
	$since_unix_timestamp = strtotime($since_date);
	$until_unix_timestamp = strtotime($until_date);

	$access_token = esc_attr( get_option('access_token') ); 
	
	$fields="id,name,description,place,timezone,start_time,cover";
	if($is_single_event){
	//single event
	$json_link = "https://graph.facebook.com/{$fb_page_id}?fields={$fields}&access_token={$access_token}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
	}
	else {
	//events page
	$json_link = "https://graph.facebook.com/{$fb_page_id}/events/attending/?fields={$fields}&access_token={$access_token}&since={$since_unix_timestamp}&until={$until_unix_timestamp}";
	}

	//Exception handler
	set_error_handler(
		create_function(
			'$severity, $message, $file, $line',
			'throw new ErrorException($message, $severity, $severity, $file, $line);'
		)
	);

	try
	{
		$json = file_get_contents($json_link);
	}
	catch (Exception $e)
	{ 
		$message = "";
		// Problem with connection
		if (strpos($e->getMessage(), "php_network_getaddresses")  == True){
			$message = __( 'Connection error', 'fb-display-events-shortcode' ); 
		}
		//Problem with ID
		else if (strpos($e->getMessage(), "400 Bad Request")  == True){
			$message =  __( 'Bad Request. Yours id_value or access token is not valid.', 'fb-display-events-shortcode' ); 
		}
		//diffrent problems
		else{
			$message = $e->getMessage();
			
		}
		$exc =  __( 'Caught Exception:', 'fb-display-events-shortcode' ); 
		throw new Exception($exc . " " . $message);
		//return $exc .  $message;
	}
	
	/**  Use only in php5.5 or higher
	finally
	{
		restore_error_handler();
	}
	other case line below:
	*/
	restore_error_handler();
	
	//$obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
	 
	// for those using PHP version older than 5.4, use this instead:
	//$obj = json_decode(preg_replace('/("\w+"):(\d+)/', '\\1:"\\2"', $json), true);

	//for PHP version 5.3
	$obj = json_decode($json, true);
	if(isset($obj['error']))
	{
		return '<p>' . __( 'Wrong id_number', 'fb-display-events-shortcode' ) . '</p>';
	}
	
	$events = [];		
	$location_not_set = __( 'Location not fully set', 'fb-display-events-shortcode' );
	//default time and date format
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );
	
	if($is_single_event){
		//single event
		// set timezone
		date_default_timezone_set($obj['timezone']);
		$start_date = null !== (strtotime($obj['start_time'])) ? date_i18n( 'l, d F, Y', strtotime($obj['start_time'])) : "";
		$start_date_day = null !== (strtotime($obj['start_time'])) ? date_i18n( 'd', strtotime($obj['start_time'])) :  "";
		$start_time = null !== (strtotime($obj['start_time'])) ? date($time_format, strtotime($obj['start_time'])) : "";
		$start_month = null !== (strtotime($obj['start_time'])) ? substr(date_i18n('F', strtotime($obj['start_time'])),0, 3) : "";
		$pic_big = isset($obj['cover']['source']) ? $obj['cover']['source'] : "https://graph.facebook.com/{$fb_page_id}/picture?type=large";
		$eid = isset($obj['id']) ? $obj['id'] : "";
		$name = isset($obj['name']) ? $obj['name'] : "";
		$description = isset($obj['description']) ? $obj['description'] : "";
	 
		// place
		$place_name = isset($obj['place']['name']) ? $obj['place']['name'] : "";
		$city = isset($obj['place']['location']['city']) ? $obj['place']['location']['city'] : "";
		$country = isset($obj['place']['location']['country']) ? $obj['place']['location']['country'] : "";
		
		try{
			$country = fb_country_translate($country);
		}catch(Exception $e) {
			$country = "";
		}
		$zip = isset($obj['place']['location']['zip']) ? $obj['place']['location']['zip'] : "";
		 
		$location="";
		 
		if($place_name && $city && $zip){
			$location="{$place_name}, {$city}, {$zip}, {$country}";
		}else{
			$location= $location_not_set;
		}
		$obj_event = new FB_event($name, $start_date, $start_date_day, $start_month, $start_time, $location, $description, $eid, $pic_big);

		$events[0] = $obj_event;
		$event_count = count($events);
		
	}
	else {
		//events page
		// count the number of events
		$event_count = count($obj['data']);
		
		if($limit > 0 and $limit < $event_count){
			$event_count = $limit;
		}
		for($x=0; $x<$event_count; $x++){
			// set timezone
			date_default_timezone_set($obj['data'][$x]['timezone']);
			$start_date = null !== (strtotime($obj['data'][$x]['start_time'])) ? date_i18n( $date_format, strtotime($obj['data'][$x]['start_time'])) : "";
			$start_date_day = date_i18n( 'd', strtotime($obj['data'][$x]['start_time']));
			$start_time = date($time_format, strtotime($obj['data'][$x]['start_time']));
			
			//short start month 3 DIGITS
			$start_month = isset($obj['data'][$x]['start_time']) ? date_i18n('F', strtotime($obj['data'][$x]['start_time'])) : "   ";
			mb_internal_encoding("UTF-8");
			$start_month = mb_substr($start_month,0,3);
			
			$pic_big = isset($obj['data'][$x]['cover']['source']) ? $obj['data'][$x]['cover']['source'] : "https://graph.facebook.com/{$fb_page_id}/picture?type=large";
			$eid = $obj['data'][$x]['id'];
			$name = isset($obj['data'][$x]['name']) ? $obj['data'][$x]['name'] : "";
			$description = isset($obj['data'][$x]['description']) ? $obj['data'][$x]['description'] : "";
			 
			// place
			$place_name = isset($obj['data'][$x]['place']['name']) ? $obj['data'][$x]['place']['name'] : "";
			$city = isset($obj['data'][$x]['place']['location']['city']) ? $obj['data'][$x]['place']['location']['city'] : "";
			$country = isset($obj['data'][$x]['place']['location']['country']) ? $obj['data'][$x]['place']['location']['country'] : "";
			
			try{
				$country = fb_country_translate($country);
			}catch(Exception $e) {
				$country = "";
			}			
			
			$zip = isset($obj['data'][$x]['place']['location']['zip']) ? $obj['data'][$x]['place']['location']['zip'] : "";
			 
			$location="";
			 
			if($place_name && $city && $zip){
				$location="{$place_name}, {$city}, {$zip}, {$country}";
			}else{
				$location= $location_not_set;
			}

			$obj_event = new FB_event($name, $start_date, $start_date_day, $start_month, $start_time, $location, $description, $eid, $pic_big);
			$events[$x] = $obj_event;
		}					
	}

    //returned html_
	$full_string = '<div id="evcal_list" class="fdes_events_list">';

	//no events
	if($event_count == 0){
		$full_string .= '<div class="fdes_list_event event">';
		$full_string .= '<div>' . __( 'No events', 'fb-display-events-shortcode' ) . '</div>';
		$full_string .= '</div>';
	}
	else{
		for($x=0; $x<count($events); $x++){
			$full_string .= '<div class="fdes_list_event event">';
			$full_string .= $events[$x]->Print_event();
			$full_string .= '</div>';	
		}	
	}
	$full_string .= '<div class="clear"></div></div>';
	
	return $full_string;
}

/**
* Translate english country name to country name based on site language
* @country_input
*/
function fb_country_translate($country_input){
	$translated = "";
	$translateTO = substr(get_bloginfo( 'language' ), 0, 2);
	$translateFROM = "en";
	if(isset($country_input)){
		if($country_input != ""){
			$translated = \Fr\Translator::translate($country_input, $translateTO, $translateFROM);
			if($translated == null){
				$translated = "";
			}
		}
	}
	return $translated;	
}

/** 
* Display message that fb_user_id or fb_event_id is not setted
*/
function two_display_id_set(){
	return '<p>' . __( 'Please use only one shortcode: fb_user_id or fb_event_id', 'fb-display-events-shortcode' ) . '</p>'; 
}

/**
* Display message: id is not set
*/
function display_id_not_set(){
	return '<p>' . __( 'Please set in shortcode: fb_user_id or fb_event_id', 'fb-display-events-shortcode' ) . '</p>'; 
}

add_shortcode('fb_display_events', 'fb_display_events_shortcode');

//add translations
function fb_display_events_shortcode_load_textdomain() {
	load_plugin_textdomain( 'fb-display-events-shortcode', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}
add_action('plugins_loaded', 'fb_display_events_shortcode_load_textdomain');
?>