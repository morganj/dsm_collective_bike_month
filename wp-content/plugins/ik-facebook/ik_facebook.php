<?php
/*
Plugin Name: IK Facebook Plugin
Plugin URI: http://goldplugins.com/documentation/wp-social-pro-documentation/the-ik-facebook-plugin/
Description: IK Facebook Plugin - A Facebook Solution for WordPress
Author: Gold Plugins
Version: 2.14.1
Author URI: http://illuminatikarate.com
Text Domain: ik-facebook

This file is part of the IK Facebook Plugin.

The IK Facebook Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

The IK Facebook Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with the IK Facebook Plugin .  If not, see <http://www.gnu.org/licenses/>.
*/

include('include/widgets/ik_facebook_feed_widget.php');
include('include/widgets/ik_facebook_like_button_widget.php');
include('include/ik_facebook_options.php');
include('include/lib/lib.php');


//use this to track if css/powered by have been output
global $ikfb_footer_css_output;
global $ikfb_footer_poweredby_output;

class ikFacebook
{
	var $authToken;
	var $feed_options;
	var $is_pro;
	
	function __construct(){		
		//setup options and caching
		$this->feed_options = new IK_FB_Feed_Options();
		$this->cache = new GP_CacheBox();
		new ikFacebookOptions($this);
		
		//create shortcodes
		$this->createShortcodes();

		//add CSS
		$this->addCSS();

		//register sidebar widgets
		$this->registerWidgets();

		//display "powered by"
		$this->poweredBy();
		
		//admin init
		$this->adminInit();
		
		//add our custom links for Settings and Support to various places on the Plugins page
		$this->pluginLinks();
		
		//load language
		$this->language();
		
		//acquire token
		$this->generateAccessToken();
		
		//run pro check
		$this->isPro();
	}
	
	//setup language
	function language(){
		add_action('plugins_loaded', array($this, 'ikfb_load_textdomain'));
	}
	
	//add our plugin links to various locations
	function pluginLinks(){
		$plugin = plugin_basename(__FILE__);
		add_filter( "plugin_action_links_{$plugin}", array($this, 'add_settings_link_to_plugin_action_links') );
		add_filter( 'plugin_row_meta', array($this, 'add_custom_links_to_plugin_description'), 10, 2 );	
	}
	
	//admin init
	function adminInit(){
		add_action( 'admin_init', array($this, 'ikfb_admin_init') );
	}
	
	//display powered by
	function poweredBy(){
		add_action('wp_footer', array($this, 'ik_fb_show_powered_by' ));
	}
	
	//register Widgets
	function registerWidgets(){
		add_action( 'widgets_init', array($this, 'ik_fb_register_widgets' ));
	}
	
	//create shortcodes
	function createShortcodes(){
		add_shortcode('ik_fb_feed', array($this, 'ik_fb_output_feed_shortcode'));
		add_shortcode('ik_fb_gallery', array($this, 'ik_fb_output_gallery_shortcode'));
		add_shortcode('ik_fb_like_button', array($this, 'ik_fb_output_like_button'));
	}
	
	//add CSS
	function addCSS(){
		add_action( 'wp_enqueue_scripts', array($this, 'ik_fb_setup_css'));
		add_action( 'wp_head', array($this, 'ik_fb_setup_custom_css'));
		add_action( 'wp_enqueue_scripts', array($this, 'ik_fb_setup_custom_theme_css'));
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_webfonts'));
	}
	
	//check if pro and set class var
	function isPro(){
		$this->is_pro = is_valid_key();
	}
	
	//sets the locale for things such as the date formatting when displaying event dates
	function ikfb_set_locale(){
		//use get_locale() instead of WPLANG, as WPLANG is now deprecated
		//https://codex.wordpress.org/Function_Reference/get_locale
		return setlocale(LC_TIME, get_locale());
	}
	
	//load proper language pack based on current language
	function ikfb_load_textdomain() {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain( 'ik-facebook', false, $plugin_dir . '/include/languages' );
	}
	
    function ikfb_admin_init() {
		wp_register_style( 'ikfb_admin_stylesheet', plugins_url('include/css/admin_style.css', __FILE__) );
	    wp_enqueue_style( 'ikfb_admin_stylesheet' );
        wp_enqueue_style( 'farbtastic' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style('jquery-style', plugins_url('include/css/jquery-ui.css', __FILE__));
		wp_enqueue_script( 'ik_fb_pro_options', plugins_url('include/js/js.js', __FILE__), array( 'farbtastic', 'jquery' ) );
		
		wp_enqueue_script(
			'gp-admin_v2',
			plugins_url('include/js/gp-admin_v2.js', __FILE__),
			array( 'jquery' ),
			false,
			true
		);
		
		wp_enqueue_script(
			'ikfb-admin',
			plugins_url('include/js/ikfb-admin.js', __FILE__),
			array( 'jquery' ),
			false,
			true
		); 

		// register the shortcode generator script
		wp_register_script( 'gp_shortcode_generator', plugins_url('include/js/shortcode-generator.js', __FILE__), array( 'jquery') );
    }

	//register any widgets here
	function ik_fb_register_widgets() {
		register_widget( 'ikFacebookFeedWidget' );
		register_widget( 'ikFacebookLikeButtonWidget' );
	}
	
	//add Basic CSS
	function ik_fb_setup_css() {						
		$ikfb_themes = array(
			'ik_facebook_style' => 'include/css/style.css',
			'ik_facebook_dark_style' => 'include/css/dark_style.css',
			'ik_facebook_light_style' => 'include/css/light_style.css',
			'ik_facebook_blue_style' => 'include/css/blue_style.css',
			'ik_facebook_no_style' => 'include/css/no_style.css',
			'ik_facebook_gallery_style' => 'include/css/gallery.css',
		);
		
		if($this->is_pro){
			$ikfb_themes['ik_facebook_cobalt_style'] = 'include/css/cobalt_style.css';
			$ikfb_themes['ik_facebook_green_gray_style'] = 'include/css/green_gray_style.css';
			$ikfb_themes['ik_facebook_halloween_style'] = 'include/css/halloween_style.css';
			$ikfb_themes['ik_facebook_indigo_style'] = 'include/css/indigo_style.css';
			$ikfb_themes['ik_facebook_orange_style'] = 'include/css/orange_style.css';			
		}
	
		foreach($ikfb_themes as $name => $path){
			wp_register_style( $name, plugins_url($path, __FILE__) );
		}
		
		wp_enqueue_style( 'ik_facebook_' . $this->feed_options->get_option('ik_fb_feed_theme'));
		wp_enqueue_style( 'ik_facebook_gallery_style' );
	}

	//add Custom CSS
	function ik_fb_setup_custom_css() {
		//use this to track if css has been output
		global $ikfb_footer_css_output;
		
		if($ikfb_footer_css_output){
			return;
		} else {
			echo '<!--IKFB CSS--> <style type="text/css" media="screen">' . $this->feed_options->get_option('ik_fb_custom_css') . "</style>";
			$ikfb_footer_css_output = true;
		}
	}
	
	//add Custom CSS from Theme
	function ik_fb_setup_custom_theme_css() {
		//only enqueue CSS if it's there
		if(file_exists(get_stylesheet_directory() . '/ik_fb_custom_style.css' )){
			wp_register_style( 'ik_facebook_custom_style', get_stylesheet_directory_uri() . '/ik_fb_custom_style.css' );
			wp_enqueue_style( 'ik_facebook_custom_style' );
		}
	}
	
	// Enqueue any needed Google Web Fonts
	function enqueue_webfonts()
	{
		$font_list = $this->list_required_google_fonts();
		$font_list_encoded = array_map('urlencode', $this->list_required_google_fonts());
		$font_str = implode('|', $font_list_encoded);
		
		//don't register this unless a font is set to register
		if(strlen($font_str)>2){
			$protocol = is_ssl() ? 'https:' : 'http:';
			$font_url = $protocol . '//fonts.googleapis.com/css?family=' . $font_str;
			wp_register_style( 'ik_facebook_webfonts', $font_url);
			wp_enqueue_style( 'ik_facebook_webfonts' );
		}
	}
	
	function list_required_google_fonts()
	{
		// check each typography setting for google fonts, and build a list
		$option_keys = array(	'ik_fb_font_family',
								'ik_fb_powered_by_font_family',
								'ik_fb_posted_by_font_family',
								'ik_fb_date_font_family',
								'ik_fb_description_font_family',
								'ik_fb_link_font_family',
								'ik_fb_font_family',
						);
		$fonts = array();		
		foreach ($option_keys as $option_key) {
			$option_value = $this->feed_options->get_option($option_key);
			if (strpos($option_value, 'google:') !== FALSE) {
				$option_value = str_replace('google:', '', $option_value);
				
				//only add the font to the array if it was in fact a google font
				$fonts[$option_value] = $option_value;				
			}
		}		
		return $fonts;
	}
	
	//generates the like button HTML
	function ik_fb_like_button($url, $height = "45", $colorscheme = "light"){
		return '<iframe id="like_button" src="//www.facebook.com/plugins/like.php?href='.htmlentities(urlencode($url).'&layout=standard&show_faces=false&action=like&colorscheme='.$colorscheme.'&height='.$height).'"></iframe>';//add facebook like button
	}
	
	//output the like button
	function ik_fb_output_like_button($atts){		
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'url' => site_url(),
			'height' => '45',
			'colorscheme' => 'light'
		), $atts ) );
		
		return $this->ik_fb_like_button($url,$height,$colorscheme);
	}
	
	function ik_fb_output_feed_shortcode($atts){
		//load shortcode attributes into an array
		$merged_atts = shortcode_atts( array(
			'colorscheme' => 'light',
			'width' => '', /* old, should no longer appear */
			'height' => '', /* old, should no longer appear */
			'feed_image_width' => $this->feed_options->get_option('ik_fb_feed_image_width'),
			'feed_image_height' => $this->feed_options->get_option('ik_fb_feed_image_height'),
			'use_thumb' => !$this->feed_options->get_option('ik_fb_fix_feed_image_width') && !$this->feed_options->get_option('ik_fb_fix_feed_image_height'),
			'num_posts' => null,
			'id' => false,
			'show_errors' => false,
			'show_only_events' => $this->feed_options->get_option('ik_fb_show_only_events'),
			'header_bg_color' => strlen($this->feed_options->get_option('ik_fb_header_bg_color')) > 2 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_header_bg_color') : '',
			'window_bg_color' => strlen($this->feed_options->get_option('ik_fb_window_bg_color')) > 2 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_window_bg_color') : '',
			'character_limit' => '',
			'description_character_limit' => '',
			'hide_feed_images' => '',
			'show_like_button' => '',
			'show_profile_picture' => '',
			'show_page_title' => '',
			'show_posted_by' => '',
			'show_date' => '',
			'use_human_timing' => '',
			'date_format' => '',
			'show_avatars' => '',
			'show_reply_counts' => '',
			'show_replies' => '',
			'show_likes' => '',
			'only_show_page_owner' => '',
			'reverse_events' => '',
			'start_date_format' => '',
			'end_date_format' => '',
			'event_range_start_date' => '',
			'event_range_end_date' => '',
		), $atts );
		
		extract( $merged_atts );
		$this->feed_options->load($merged_atts);
				
		// Initialize the feed options
		$show_only_events = ($show_only_events) ? 1 : 0;		
		$content_type = ($show_only_events) ? "events" : "";
		
		/* Previously, width and height referred to feed_image_width and feed_image_height, respectively.
		 * Check for those attributes here, to maintain compatibility */
		if (!empty($width)) {
			$feed_image_width = $width;
		}		
		if (!empty($height)) {
			$feed_image_height = $height;
		}

		return $this->ik_fb_output_feed($colorscheme, $use_thumb, $feed_image_width, false, $feed_image_height, $num_posts, $id, $show_errors, $show_only_events, $content_type, $header_bg_color, $window_bg_color);
	}
	
	function ik_fb_output_gallery_shortcode($atts){			
		//load shortcode attributes into an array
		extract( shortcode_atts( array(
			'id' => '',
			'size' => '320x180',
			'show_name' => true,
			'title' => null,
			'num_photos' => false
		), $atts ));
		
		return $this->ik_fb_output_gallery($id, $size, $show_name, $title, $num_photos);				
	}
	
	//passed an ID and limit, loads the gallery data
	function loadGallery($id = '', $limit = false){
		$gallery_data = $this->fetchUrl("https://graph.facebook.com/{$id}/photos?limit={$limit}&summary=1&{$this->authToken}", true);//the gallery data
		
		return $gallery_data;
	}
	
	public function ik_fb_output_gallery($id = '', $size = '320x180', $show_name = true, $the_title = null, $num_photos = false){
		$output = '';
		
		$size_array = array(
			'2048x1152' => 0,
			'960x540' => 1,
			'720x405' => 2,
			'600x337' => 3,
			'480x270' => 4,
			'320x180' => 5,
			'130x73' => 7
		);
		
		$width_array = array (
			'2048x1152' => '1152px',
			'960x540' => '540px',
			'720x405' => '405px',
			'600x337' => '337px',
			'480x270' => '270px',
			'320x180' => '180px',
			'130x73' => '73px'
		);
		
		$height_array = array (
			'2048x1152' => '2048px',
			'960x540' => '960px',
			'720x405' => '720px',
			'600x337' => '600px',
			'480x270' => '480px',
			'320x180' => '320px',
			'130x73' => '130px'
		);
		
		$position = $size_array[$size];
			
		//see if a limit is set in the options, if one wasn't passed via shortcode
		if(!$num_photos){
			$limit = $this->feed_options->get_option('ik_fb_photo_feed_limit');
	
		} else {
			$limit = $num_photos;
		}
		
		//make sure its really a number, otherwise we default to 25
		if(!is_numeric($limit)){				
			$limit = 25;
		}
		
		$gallery = $this->loadGallery($id,$limit);
		
		ob_start();
		
		echo '<div class="ik_fb_gallery_standard">';
		
		if(isset($the_title)){
			echo '<span class="ik_fb_gallery_standard_title">' . $the_title . '</span>';
		}
		
		if(isset($gallery->data)){
			foreach($gallery->data as $gallery_item){
				if(isset($gallery_item->images[$position]->source)){	
					//	echo '<div class="ik_fb_gallery_item" style="width:'.$width_array[$size].';height:'.$height_array[$size].';">';			
					echo '<div class="ik_fb_gallery_item ik_fb_gallery_'.$size.'">';
					
					$name = "";
					if(isset($gallery_item->name)){
						$name = $gallery_item->name;
					}
				
					echo '<a href="'.htmlentities($gallery_item->source).'" target="_blank" title="'. __('Click to View Full Sized Photo', 'ik-facebook') . '"><img class="ik_fb_standard_image" src="'.$gallery_item->images[$position]->source.'" alt="' . htmlentities($name) . '" /></a>';
				
					if($show_name){
						echo '<p class="ik_fb_standard_image_name">' . $name . '</p>';
					}
					
					echo '</div>';
				}
				
			}
		} else {
			echo '<p class="ik_fb_error">'.__('IK FB: Unable to load photos.', 'ik-facebook').'</p>';
		}
		
		echo '</div>';
		
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
	}

	/*
	 * Outputs a Facebook feed for an event
	 */
	public function ik_fb_output_single_event($colorscheme = "light", $use_thumb = true, $width = "", $is_sidebar_widget = false, $height = "", $num_posts = null, $id = false, $show_errors = false) {
		// Initialize the feed options
		$show_only_events = $this->feed_options->get_option('ik_fb_show_only_events');
		$show_only_events = ($show_only_events) ? 1 : 0;		
		$content_type = ($show_only_events) ? "events" : "";		
		$ik_fb_header_bg_color = strlen($this->feed_options->get_option('ik_fb_header_bg_color')) > 2 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_header_bg_color') : '';
		$ik_fb_window_bg_color = strlen($this->feed_options->get_option('ik_fb_window_bg_color')) > 2 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_window_bg_color') : '';		
		
		// pass through to the ik_fb_output_feed function, with the last param ($is_event) set to true
		return $this->ik_fb_output_feed($colorscheme, $use_thumb, $width, $is_sidebar_widget, $height, $num_posts, $id, $show_errors, true, $content_type, $ik_fb_header_bg_color, $ik_fb_window_bg_color);
	}
		
	/**
	 * Outputs a Facebook feed, either for a profile or for an event
	 */
	public function ik_fb_output_feed($colorscheme = "light", $use_thumb = true, $width = "", $is_sidebar_widget = false, $height = "", $num_posts = null, $id = false, $show_errors = false, $show_only_events, $content_type, $ik_fb_header_bg_color, $ik_fb_window_bg_color){

		// load the width and height settings for the feed. 
		// NOTE: the plugin uses different settings for the sidebar feed vs the normal (in-page) feed
		list($ik_fb_feed_width, $ik_fb_feed_height) = $this->get_feed_width_and_height($is_sidebar_widget);
		
		$options_hash = $this->feed_options->get_option_hash();
		$options_mixer = $this->feed_options->get_option('ik_fb_pro_options_mixer');
		
		// Load the profile's feed items from the Graph API
		// TODO: if page_data is not set, this indicates an error with the API reponse. We should handle it.

		// try to load the feed and the page data out of the cache
		$feed = $this->cache->get_key('ik_fb_feed', false, $id . $options_hash . $options_mixer);
		$page_data = $this->cache->get_key('ik_fb_page_data', false, $id . $options_hash . $options_mixer);
		
		// if feed and/or page data is not in the cache, reload it now
		if ($feed === FALSE || $page_data === FALSE) {
			$api_response = $this->loadFacebook($id, $num_posts, $content_type);
			$feed = isset($api_response['feed']) ? $api_response['feed'] : array();
			$page_data = isset($api_response['page_data']) ? $api_response['page_data'] : false;
			$fifteen_minutes = 900; // 15 mins in seconds (expiration time for the cache)
			
			if (!empty($feed)) {
				$this->cache->set_key('ik_fb_feed', $feed, $fifteen_minutes, $id);
			}
			if (!empty($page_data)) {
				$this->cache->set_key('ik_fb_page_data', $page_data, $fifteen_minutes, $id);
			}
		}
		
		// feed could not be loaded. (likely cause: no page ID specified, or bad FB API ID/key)
		if ( empty($feed) ) {
			return '';
		}

		// setup the cache for the rest of the items
		$first_item_id = $feed[0]->id;
		$mixer = md5($first_item_id . $options_hash . $options_mixer);
		
		//$feed = isset($api_response['feed']) ? $api_response['feed'] : array();		
		$the_link = $this->get_profile_link($page_data); // save a permalink to the Facebook profile. We'll need it in several places.
		$is_event = isset($page_data->start_time);

		// If there were no items and show_errors is OFF, we'll need to hide the feed
		$hide_the_feed = !$show_errors && !(count($feed) > 0);
		 
		$output = $this->cache->get_key('ik_fb_feed_output', FALSE, $mixer);

		if ($output === FALSE || strlen($output) < 10)
		{
			/** Start building the feed HTML now **/		
			// start with a template which contains the merge tag '{ik:feed}'
			$output = $this->build_feed_template($ik_fb_feed_width, $ik_fb_feed_height, $ik_fb_window_bg_color, $ik_fb_header_bg_color, $hide_the_feed);

			// {ikfb:image} merge tag - adds the profile photo HTML (can be disabled with options, in which case we'd be merging in a blank string)
			$image_html = $this->get_profile_photo_html($page_data); 
			$output = str_replace('{ikfb:image}', $image_html, $output);

			// {ikfb:link} merge tag - adds the profile title to the top of the feed (which is linked to the profile on Facebook)
			// NOTE: this is controlled by the "title" setting in the options, and can be disabled (meaning we would merge in a blank string)
			$title_html = $this->get_profile_title_html($page_data);
			$output = str_replace('{ikfb:link}', $title_html, $output);

			// {ikfb:like_button} merge tag - adds the Like button (for the profile itself, not the individual feed items)
			// NOTE: events cannot have like buttons, so they'll get a string with the event's Start/End Times and location instead
			$like_button_html = $this->get_feed_like_button_html($page_data, $is_event, $the_link, $colorscheme);
			$output = str_replace('{ikfb:like_button}', $like_button_html, $output);	

			// {ikfb:feed} merge tag - adds the actual line items
			// NOTE: this can be an error message, if the feed is empty and $show_errors = true
			$feed_items_html = $this->get_feed_items_html($feed, $page_data, $use_thumb, $width, $height, $the_link, $show_errors);
			$output = str_replace('{ikfb:feed}', $feed_items_html, $output);
			
			//RWG: changed this to 15 minutes from never expires, as the feed could update without having a new item added (which is what we checked on for cache busting.)
			$this->cache->set_key('ik_fb_feed_output', $output, $fifteen_minutes, $mixer);
		}

		// All done! Return the HTML we've built.
		// TODO: add a hookable filter on $output
		return $output;		
	}


	public function get_feed_width_and_height($is_sidebar_widget = false)
	{
		//use different heigh/width styling options, if this is the sidebar widget
		if($is_sidebar_widget) {
			// This is the sidebar widget, so load the sidebar feed settings
			$ik_fb_feed_height = strlen($this->feed_options->get_option('ik_fb_sidebar_feed_window_height')) > 0 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_sidebar_feed_window_height') : '';
			$ik_fb_feed_width = strlen($this->feed_options->get_option('ik_fb_sidebar_feed_window_width')) > 0 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_sidebar_feed_window_width') : '';
				
			if($ik_fb_feed_width == "OTHER"){
				$ik_fb_feed_width = str_replace("px", "", $this->feed_options->get_option('other_ik_fb_sidebar_feed_window_width')) . "px";
			}			
			
			if($ik_fb_feed_height == "OTHER"){
				$ik_fb_feed_height = str_replace("px", "", $this->feed_options->get_option('other_ik_fb_sidebar_feed_window_height')) . "px";
			}
		}
		else {
			// this is the normal (non-widget) feed, so load the normal settings
			$ik_fb_feed_height = strlen($this->feed_options->get_option('ik_fb_feed_window_height')) > 0 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_feed_window_height') : '';
			$ik_fb_feed_width = strlen($this->feed_options->get_option('ik_fb_feed_window_width')) > 0 && !$this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_feed_window_width') : '';
				
			if($ik_fb_feed_width == "OTHER"){
				$ik_fb_feed_width = str_replace("px", "", $this->feed_options->get_option('other_ik_fb_feed_window_width')) . "px";
			}
			
			if($ik_fb_feed_height == "OTHER"){
				$ik_fb_feed_height = str_replace("px", "", $this->feed_options->get_option('other_ik_fb_feed_window_height')) . "px";
			}		
		}
		return array($ik_fb_feed_width, $ik_fb_feed_height);		
	}
	
	public function build_feed_template($ik_fb_feed_width, $ik_fb_feed_height, $ik_fb_window_bg_color, $ik_fb_header_bg_color, $is_error = false)
	{
		//feed window width
		$custom_styling_1 = ' style="';
		if(strlen($ik_fb_feed_width)>0){
			$custom_styling_1 .= "width: {$ik_fb_feed_width};";
		}	
		if(strlen($ik_fb_feed_height)>0){		
			$custom_styling_1 .= "height: auto; ";
		}
		$custom_styling_1 .= '"';
		
		//feed window height, feed window bg color
		$custom_styling_2 = ' style="';
		if(strlen($ik_fb_feed_height)>0){		
			$custom_styling_2 .= "height: {$ik_fb_feed_height}; ";
		}
		if(strlen($ik_fb_window_bg_color)>0){
			$custom_styling_2 .= " background-color: {$ik_fb_window_bg_color};";
		}	
		
		$custom_styling_2 .= '"';
		
		//feed heading bg color
		$custom_styling_3 = ' style="';
		if(strlen($ik_fb_header_bg_color)>0){
			$custom_styling_3 .= "background-color: {$ik_fb_header_bg_color};";
		}
		$custom_styling_3 .= '"';	
		
		// if the user has specified custom feed HTML, use that. Else, use our default HTML
		$use_custom_html = strlen($this->feed_options->get_option('ik_fb_feed_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html');
		if ($use_custom_html) {
			// use custom HTML as specified in the options panel
			$template_html = $this->feed_options->get_option('ik_fb_feed_html');
		} else {
			// use default HTML
			$template_html = '<div id="ik_fb_widget" {custom_styling_1} ><div id="ik_fb_widget_top" {custom_styling_3} ><div class="ik_fb_profile_picture">{ikfb:image}{ikfb:link}</div>{ikfb:like_button}</div><ul class="ik_fb_feed_window" {custom_styling_2} >{ikfb:feed}</ul></div>';
		}
		
		// if there was an error, force custom_styling_2 to display: none
		if ($is_error) {
			$custom_styling_2 = 'style="display:none;"';
		}
		
		// replace the the custom styling merge tags (if present) and return the output
		$output = $template_html;
		$output = str_replace('{custom_styling_1}', $custom_styling_1, $output);
		$output = str_replace('{custom_styling_2}', $custom_styling_2, $output);
		$output = str_replace('{custom_styling_3}', $custom_styling_3, $output);
		return $output;
	}
	
	function loadPicture($id = ''){
		$picture = $this->fetchUrl("https://graph.facebook.com/{$id}/picture?redirect=0", true);
		
		return $picture;
	}
	
	public function get_profile_photo_html($page_data)
	{
		
		if($this->feed_options->get_option('ik_fb_show_profile_picture')){
			//use the username if available, otherwise fallback to page ID
			if(isset($page_data->username)){
				$picture = $this->loadPicture($page_data->username);
				$replace = "<img src=\"{$picture->data->url}\" alt=\"profile picture\"/>";
			} else if(isset($page_data->id)){
				$picture = $this->loadPicture($page_data->id);
				$replace = "<img src=\"{$picture->data->url}\" alt=\"profile picture\"/>";
			} else { //bad ID has been input, lets try not to crap out
				$replace = '';
			}
		} else {
			$replace = '';
		}	
		return $replace;
	}
	
	public function get_profile_title_html($page_data)
	{
		$url = $this->get_profile_link($page_data);
		if($this->feed_options->get_option('ik_fb_show_page_title') && isset($page_data->name))
		{
			// return a link to the profile, with the text inside wrapped in span.ik_fb_name
			return '<a target="_blank" href="' . $url . '"><span class="ik_fb_name">' . $page_data->name . '</span></a>';	
		} else {
			// user has disabled the feed title in the settings, or no page name was set, so return a blank string
			return '';
		}
	}
	
	public function get_feed_like_button_html($page_data, $is_event, $the_link, $colorscheme)
	{
		if(!$is_event){
			// This is a normal feed! (not an event)
			// only show like button if enabled in settings
			if($this->feed_options->get_option('ik_fb_show_like_button')){
				return $this->ik_fb_like_button($the_link, "45", $colorscheme);
			} else {
				return '';
			}
		} else {
			// This is an event! Events don't allow like buttons, so output the date and time instead
			// TODO: allow the Date Formatting to be controlled by user
			return '<p class="ikfb_event_meta">' . $page_data->location . ', ' . date('M d, Y',strtotime($page_data->start_time)) . '<br/>' . $page_data->venue->street . ', ' . $page_data->venue->city . ', ' . $page_data->venue->country . '</p>';
		}		
	}
	
	public function get_feed_items_html($feed, $page_data, $use_thumb, $width, $height, $the_link, $show_errors)
	{
		$feed_html = '';
		// if the feed contains items, build the HTML for each one and add it to $feed_html
		if(count($feed)>0) {
			foreach($feed as $item){//$item is the feed object	
				$feed_html .= $this->buildFeedLineItem($item, $use_thumb, $width, $page_data, $height, $the_link, $page_data->id);
			}
		} else {
			// if there was nothing in the feed, show an error instead (if error display is enabled)
			if($show_errors){
				$feed_html = "<p class='ik_fb_error'>" . __('IK FB: Unable to load feed.', 'ik-facebook') . "</p>";
			}
		}
		return $feed_html;
	}

	/**
	 * Returns a permalink to the Facebook page. 
	 *
	 * @param  object $page_data The Facebook page's profile data, which contains its name and id
	 *
	 * @return string Permalink to the Facebook profile, or 'https://www.facebook.com/' if bad $page_data was passed
	 *
	 */
	public function get_profile_link($page_data)
	{
		if(isset($page_data->name)) {
			$the_link = "https://www.facebook.com/pages/".urlencode($page_data->name)."/".urlencode($page_data->id);
		} else { //bad ID has been input, lets try not to crap out
			$the_link = "https://www.facebook.com/";
		}
		return $the_link;
	}

	//thanks to Alix Axel, http://stackoverflow.com/questions/2762061/how-to-add-http-if-its-not-exists-in-the-url
	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}
	
	//passed a FB Feed Item, builds the appropriate HTML
	function buildFeedLineItem($item, $use_thumb, $width, $page_data, $height, $the_link = false, $page_id = null){
		
		// load feed item template
		$default_feed_item_html = '<li class="ik_fb_feed_item">{ikfb:feed_item}</li>';		
		$feed_item_html = strlen($this->feed_options->get_option('ik_fb_feed_item_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_feed_item_html') : $default_feed_item_html;
				
		// Format the line item as either an Event or as a Normal Item (which could be a text post, photo, whatever)
		if((isset($item->link) && strpos($item->link,'http://www.facebook.com/events/') !== false) || $this->feed_options->get_option('ik_fb_show_only_events')) {			
			// Output this line item as an event
			$line_item_html = $this->build_event_feed_line_item_html($item);
		}
		else {
			// Output this line item normally (not an event)
			$line_item_html = $this->build_normal_feed_line_item_html($item, $page_id, $use_thumb, $width, $height, $the_link);
		}

		// replace the {ikfb:feed_item} merge tag with the line item html
		$output = str_replace('{ikfb:feed_item}', $line_item_html, $feed_item_html);	
		
		// TODO: Add a hookable filter?
		return $output;
	}
	
	public function build_event_feed_line_item_html($item)
	{
		$line_item = '';	
		
		if(isset($item->link)){
			//some event parsing				
			$event_id = explode('/',$item->link);
			$event_id = $event_id[4];
		}
		
		if($this->feed_options->get_option('ik_fb_show_only_events')){
			$event_id = $item->id;
		}
		
		if($event_id) {				
			$event_data = $this->fetchUrl("https://graph.facebook.com/{$event_id}?summary=1&{$this->authToken}", true);//the event data
			
			//add avatar for pro users
			if($this->is_pro){		
				$line_item = $this->pro_user_avatars($line_item, $item) . " ";
			}
			
			//load event image source
			//acceptable parameters for type are: small, normal, large, square
			//default is small
			$event_image_size = $this->feed_options->get_option('ik_fb_event_image_size', 'small');
			$event_image = "http://graph.facebook.com/" . $event_id . "/picture?type={$event_image_size}";
			
			if(isset($event_data->name)){
				//event name
				$line_item = '<p class="ikfb_event_title">' . $line_item . $event_data->name . '</p>';
				
				$start_time = isset($event_data->start_time) ? $event_data->start_time : '';
				$end_time = isset($event_data->end_time) ? $event_data->end_time : '';			
				
				//default time format
				$start_time_format = 'l, F jS, Y h:i:s a';
				$end_time_format = 'l, F jS, Y h:i:s a';
				
				if($this->is_pro){
					$start_time_format = $this->feed_options->get_option('ik_fb_start_date_format', 'l, F jS, Y h:i:s a');
					$end_time_format = $this->feed_options->get_option('ik_fb_end_date_format', 'l, F jS, Y h:i:s a');
				}
				
				//TBD: Allow user control over date formatting				
				$time_object = new DateTime($start_time);
				$start_time = $time_object->format($start_time_format);	
				
				//TBD: Allow user control over date formatting
				if(strlen($end_time)>2){
					$time_object = new DateTime($end_time);
					$end_time = $time_object->format($end_time_format);						
				}
				
				//event start time - event end time					
				$event_start_time = isset($event_data->start_time) ? $start_time : '';					
				$event_end_time = isset($event_data->end_time) ? $end_time : '';
				
				$line_item .= '<p class="ikfb_event_date">';
				$event_had_start = false;
				if(strlen($event_start_time)>2){
					$line_item .= $event_start_time;
					$event_had_start = true;
				}
				if($event_had_start){
					$line_item .= ' - ';
				}
				if(strlen($event_end_time)>2){
					$line_item .= $event_end_time; 
				}
				$line_item .= '</p>';
				
				//event image					
				$line_item .= '<img class="ikfb_event_image" src="' . $event_image . '" alt="Event Image"/>';					
				
				//event description
				if(isset($event_data->description)){	
					//use mb_substr, if available, for 2 byte character support
					if(function_exists('mb_substr')){
						$event_description = mb_substr($event_data->description, 0, 250);
					} else {
						$event_description = substr($event_data->description, 0, 250);
					}
					$event_description .= __('... ', 'ik-facebook');
						
					$line_item .= '<p class="ikfb_event_description">' . $event_description . '</p>';
				}
				
				//event read more link
				$line_item .= '<p class="ikfb_event_link"><a href="http://facebook.com/events/'.urlencode($event_id).'" title="Click Here To Read More" target="_blank">Read More...</a></p>';
			}
		}
		return $line_item;	
	}
	
	public function build_normal_feed_line_item_html($item, $page_id, $use_thumb, $width, $height, $the_link)
	{
		$default_story_html = '<p class="ik_fb_item_story">{ikfb:feed_item:story}</p>';
		$default_message_html = '<p class="ik_fb_item_message">{ikfb:feed_item:message}</p>';
		$default_image_html = '<p class="ik_fb_facebook_image">{ikfb:feed_item:image}</p>';		
		$default_description_html = '<p class="ik_fb_facebook_description">{ikfb:feed_item:description}</p>';		
		$default_caption_html = '<p class="ik_fb_facebook_link">{ikfb:feed_item:link}</p>';	
		
		$story_html = $default_story_html;//TBD: allow customization
		$message_html = strlen($this->feed_options->get_option('ik_fb_message_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_message_html') : $default_message_html;
		$image_html = strlen($this->feed_options->get_option('ik_fb_image_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_image_html') : $default_image_html;
		$description_html = strlen($this->feed_options->get_option('ik_fb_description_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_description_html') : $default_description_html;
		$caption_html = strlen($this->feed_options->get_option('ik_fb_caption_html')) > 2 && $this->feed_options->get_option('ik_fb_use_custom_html') ? $this->feed_options->get_option('ik_fb_caption_html') : $default_caption_html;
			
		// capture the post's date (if one is set)
		$date = isset($item->created_time) ? $item->created_time : "";		

		$line_item = '';
		$replace = $message_output = $picture_output = "";
		$message_truncated = false;
		$photo_caption_truncated = false;
		
		//output the item message
		if(isset($item->message)){		
			list($message_output, $message_truncated) = $this->ikfb_build_message($item,$replace,$message_html);
		}
		
		//output the item story
		if(isset($item->story)){
			//parse story
			$story = nl2br(make_clickable(htmlspecialchars($item->story)));
			
			//add custom story styling from pro options
			//building story html
			if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
				$story_html = $this->ikfb_story_styling($story_html);
			}		
			
			//build story output
			$story_output = str_replace('{ikfb:feed_item:story}', $story, $story_html);		
			
			//attach the story to the front of the message
			$message_output = $story_output . $message_output;
		}

		//output the item photo
		if(isset($item->picture)){ 		
			list($picture_output, $photo_caption_truncated) = $this->ikfb_build_photo($item,$replace,$image_html,$description_html,$caption_html,$use_thumb,$width,$height, $page_id);
		}			
		
		//if set, show the picture and it's content before you show the message
		if($this->feed_options->get_option('ik_fb_show_picture_before_message')){
			$line_item .= $picture_output;
			$line_item .= $message_output;
		} else {
			$line_item .= $message_output;
			$line_item .= $picture_output;				
		}

		//output a Read More link, if either the photo caption or the message body was truncated
		if($message_truncated || $photo_caption_truncated){
			$item_id = explode("_",$item->id);
			$the_link = "https://www.facebook.com/permalink.php" . htmlentities("?id=".urlencode($page_id)."&story_fbid=".urlencode($item_id[1]));				
			$line_item .= ' <a href="'.$the_link.'" class="ikfb_read_more" target="_blank">'.__('Read More...', 'ik-facebook').'</a>';
		}	
		
		//output the item link	
		$link_html = $this->get_feed_item_link_html($item);
		$line_item .= str_replace('{ikfb:feed_item:link}', $link_html, $caption_html);	
		
		//only add the line item if there is content (i.e., a message or a photo) to display
		if((strlen($line_item)>2))
		{
			//output Posted By... text, if option to display it is enabled
			$line_item .= $this->get_feed_item_posted_by_html($item);
			
			//output Posted By date, if option to display it is enabled
			$line_item .= $this->get_feed_item_post_date_html($date);
		
			//add likes, if pro and enabled
			if($this->is_pro){
				$line_item .= $this->pro_likes($item, $the_link);
			}
			
			//add comments, if pro and enabled
			if($this->is_pro){
				$line_item .= $this->pro_comments($item, $the_link);
			}	
		} 			
		return $line_item;
	}
	
	public function get_feed_item_link_html($item)
	{
		$link_html = '';
		if(isset($item->link))
		{
			if(isset($item->caption) && isset($item->picture)){
				$link_text = $item->caption; //some items have a caption	
			} else if(isset($item->description)){
				$link_text = $item->description; //some items have a description	
			} else {
				$link_text = isset($item->name) ? $item->name : '';  //others might just have a name
			}
			
			// don't add the line item if the link text isn't set
			if(strlen($link_text) > 1){
				// prevent validation errors
				$item->link = str_replace("&","&amp;",$item->link);
				
				$start_link = '<a href="'.htmlentities($item->link).'" target="_blank">';
				$end_link = '</a>';				
			
				// add custom link styling from pro options
				if(!$this->feed_options->get_option('ik_fb_use_custom_html')){
					$start_link = $this->ikfb_link_styling($item->link);
				}	
				
				$link_html = $start_link . $link_text. $end_link;	
			}
		}
		return $link_html;
	}

	//output "posted by" text (if it is enabled)
	//TBD: Allow user control over date formatting
	public function get_feed_item_posted_by_html($item)
	{
		$posted_by_text = '';
		if($this->feed_options->get_option('ik_fb_show_posted_by'))
		{
			if(isset($item->from)){ //output the author of the item
				if(isset($item->from->name)){
					$from_text = $item->from->name;
				}
				
				if(strlen($from_text) > 1){
					$posted_by_text = '<p class="ikfb_item_author">' . __('Posted By ', 'ik-facebook') . $from_text . '</p>';
		
					//add custom posted by styling from pro options
					if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
						$posted_by_text = $this->ikfb_posted_by_styling($posted_by_text);
					}			
				}
			}
		}
		return $posted_by_text;
	}
	
	//output Posted By date, if option to display it is enabled
	//TBD: Allow user control over date formatting
	public function get_feed_item_post_date_html($date) {
		if($this->feed_options->get_option('ik_fb_show_date')){			
			$ik_fb_use_human_timing = $this->feed_options->get_option('ik_fb_use_human_timing');
			if(strtotime($date) >= strtotime('-1 day') && !$ik_fb_use_human_timing){
				$date = $this->humanTiming(strtotime($date)). __(' ago', 'ik-facebook');
			}else{
				$ik_fb_date_format = $this->feed_options->get_option('ik_fb_date_format');
				$ik_fb_date_format = strlen($ik_fb_date_format) > 2 ? $ik_fb_date_format : "%B %d";
				$date = strftime($ik_fb_date_format, strtotime($date));
			}
		
			if(strlen($date)>2){
				$date = '<p class="date">' . $date . '</p>';
				
				//add custom date styling from  options
				if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
					$date = $this->ikfb_date_styling($date);
				}
			}
			return $date;
		}	
		else {
			return '';
		}
	}	
	
	function ikfb_build_photo($item,$replace="",$image_html,$description_html,$caption_html,$use_thumb,$width,$height,$page_id = ''){
		//output to return
		$output = '';
		//whether or not we are using a short version of anything (ie, are character limits set in the options)
		$shortened = false;
			
		//check to see if the option to display feed images is set
		//if not, skip doing any of the below
		//this option was originally created as 'hide feed images', but has been updated to be used as 'show feed images'
		//as a result, the option name is still 'hide feed images' but we treat it as meaning 'show feed images', throughout the cod
		if(!$this->feed_options->get_option('ik_fb_hide_feed_images')){
			$replace = '';
		} else {				
			$page_id = strlen($page_id) > 2 ? $page_id : $item->from->id;
			
			//need info about full sized photo for linking purposes
			//get the item id
			$item_id = isset($item->object_id) ? $item->object_id : -999;
			
			if($item_id != -999){
				$photo = $this->loadFacebookPhoto($item_id);
				$photo_source = urldecode($photo->data->url);
				$photo_link = urldecode($photo->data->url);
			} else { //else use thumbnail				
				//load arguments into array for use below
				$parsed_url = parse_url($item->picture);
				
				if(isset($parsed_url['query'])){
					parse_str($parsed_url['query'], $params);               
				}
				
				//handle images loaded by fb's scripts
				if(isset($params['url'])) {
					$photo_link = urldecode($params['url']);
					$photo_source = urldecode($params['url']);
				} else {
					$photo_link = $item->picture;
					$photo_source = urldecode($item->picture);
				}
			}
			
			if($this->feed_options->get_option('ik_fb_link_photo_to_feed_item')){
				$item_id = explode("_",$item->id);
				$photo_link = "https://www.facebook.com/permalink.php?id=".urlencode($page_id)."&story_fbid=".urlencode($item_id[1]);
			}

			//output the images
			//if set, load the custom image width from the options page
			if(!$use_thumb){			
				if($width == "OTHER"){
					$width = $this->feed_options->get_option('other_ik_fb_feed_image_width');
				}
				
				if($height == "OTHER"){
					$height = $this->feed_options->get_option('other_ik_fb_feed_image_height');
				}
				
				//source: tim morozzo
				if (isset($item->description) && strlen($item->description) >5){
					$title = $item->description;
				}elseif(isset($item->message)){
					$title = $item->message;
				}else{ 
					$title = __('Click for fullsize photo', 'ik-facebook');
				}
				
				$limit = $this->feed_options->get_option('ik_fb_description_character_limit');
				
				if(is_numeric($limit)){
					if(strlen($title) > $limit){
						//remove characters beyond limit							
						//use mb_substr, if available, for 2 byte character support
						if(function_exists('mb_substr')){
							$title = mb_substr($title, 0, $limit);
						} else {
							$title = substr($title, 0, $limit);
						}
						$title .= __('... ', 'ik-facebook');

						$shortened = true;
					}
				}
				
				//replace ampersands and equal signs, and whatever else
				$photo_link = str_replace("&","&amp;",$photo_link);
				
				$width = strlen($width)>0 ? 'width="'.$width.'"' : '';
				$height = strlen($height)>0 ? 'height="'.$height.'"' : '';
				
				$replace = '<a href="'.$photo_link.'" title="'.htmlspecialchars($title, ENT_QUOTES).'" target="_blank"><img '.$width.' '.$height.' src="'.$photo_source.'" alt="'.htmlspecialchars($title, ENT_QUOTES).'"/></a>';
					
				$output .= str_replace('{ikfb:feed_item:image}', $replace, $image_html);						
			} else {						
				//ampersands!
				$item->picture = str_replace("&","&amp;",$item->picture);

				//courtesy of tim morozzo
				if (isset($item->description) && strlen($item->description) >5){
					$title = $item->description;
				} elseif (isset($item->message)){
					$title = make_clickable($item->message);
				} else { 
					$title = __('Click for fullsize photo', 'ik-facebook');
				}
				//otherwise, use thumbnail
				$replace = '<a href="'.$photo_link.'" target="_blank"><img src="'.$item->picture.'" title="'.$title.'"></a>';
						
				$output .= str_replace('{ikfb:feed_item:image}', $replace, $image_html);	
			}

			//add the text for photo description
			if(isset($item->description)){
				$replace = $item->description;	

				//if a character limit is set, here is the logic to handle that
				$limit = $this->feed_options->get_option('ik_fb_description_character_limit');
				if(is_numeric($limit)){
					//only perform changes on posts longer than the character limit
					if(strlen($replace) > $limit){
						//remove characters beyond limit						
						//use mb_substr, if available, for 2 byte character support
						if(function_exists('mb_substr')){
							$replace = mb_substr($replace, 0, $limit);
						} else {
							$replace = substr($replace, 0, $limit);
						}
						$replace .= __('... ', 'ik-facebook');
					
						$shortened = true;
					}
				}					
			
				//add custom image styling from pro options
				if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
					$description_html = $this->ikfb_description_styling($description_html);
				}	
				
				$output .= str_replace('{ikfb:feed_item:description}', $replace, $description_html);	
			}
		}//end show feed images check
		
		return array( $output, $shortened);
	}
	
	//passed an item ID
	//loads a photo and returns its data
	function loadFacebookPhoto($item_id){
		$photo_data = $this->fetchUrl("https://graph.facebook.com/{$item_id}/picture?summary=1&{$this->authToken}&redirect=false", true);	
		
		return $photo_data;
	}
	
	function ikfb_build_message($item,$replace="",$message_html){
		
		$shortened = false;		
	
		//add avatar for pro users
		if($this->is_pro){		
			$replace = $this->pro_user_avatars($replace, $item) . " ";
		}		
		
		$message = $item->message;
		
		//if a character limit is set, here is the logic to handle that
		$limit = $this->feed_options->get_option('ik_fb_character_limit');
		if(is_numeric($limit)){
			//only perform changes on posts longer than the character limit
			if(strlen($message) > $limit){
				//remove characters beyond limit
				//use mb_substr, if available, for 2 byte character support
				if(function_exists('mb_substr')){
						$message = mb_substr($message, 0, $limit);
				} else {
					$message = substr($message, 0, $limit);
				}
				$message .= __('... ', 'ik-facebook');
				
				$shortened = true;
			}
		}
		
		$message = make_clickable(htmlspecialchars($message));
		
		$replace = $replace . $message;
		
		//add custom message styling from pro options
		if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
			$message_html = $this->ikfb_message_styling($message_html);
		}	
		
		$output = str_replace('{ikfb:feed_item:message}', $replace, $message_html);			
		
		return array($output, $shortened);
	}
	
	//check to see time elapsed since given datetime
	//credit to http://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
	function humanTiming ($time)	{
		$time = time() - $time; // to get the time since that moment
	
		$tokens = array (
			31536000 => __('year', 'ik-facebook'),
			2592000 => __('month', 'ik-facebook'),
			604800 => __('week', 'ik-facebook'),
			86400 => __('day', 'ik-facebook'),
			3600 => __('hour', 'ik-facebook'),
			60 => __('minute', 'ik-facebook'),
			1 => __('second', 'ik-facebook')
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}
	
	//checks settings and outputs Powered By link
	function ik_fb_show_powered_by() {
		//use this to track if powered by has been output
		global $ikfb_footer_poweredby_output;
				
		if($this->feed_options->get_option('ik_fb_powered_by')){			
			if($ikfb_footer_poweredby_output){
				return;
			} else {			
				$content = '<a href="https://illuminatikarate.com/ik-facebook-plugin/" target="_blank" id="ikfb_powered_by">'.__('Powered By IK Facebook Plugin', 'ik-facebook').'</a>';			
				
				//add custom powered by styling from pro options
				if(!$this->feed_options->get_option('ik_fb_use_custom_html')){		
					$content = $this->ikfb_powered_by_styling($content);
				}		
				
				echo $content;
				
				$ikfb_footer_poweredby_output = true;
			}
		}
	}
	
	//fetches an URL
	function fetchUrl($url,$decode=false){		
		//caching
		$ch = new CachedCurl();
		$retData = $ch->load_url($url);
		
		if($decode){
			$retData = json_decode($retData);
		}
		
		return $retData;
	}
	
	//loads app id and secret key from settings
	//generates an authtoken via the graph api and sets it
	//also returns the value, in 
	function generateAccessToken(){
		$app_id = $this->feed_options->get_option('ik_fb_app_id');
		$app_secret = $this->feed_options->get_option('ik_fb_secret_key');
			
		$access_token = $this->fetchUrl("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$app_id}&client_secret={$app_secret}");
		
		$this->authToken = $access_token;
		
		return $access_token;
	}
	
	//loads facebook feed based on current id
	function loadFacebook($id = false, $num_posts = -1, $content_type = ''){
		$retData = array();
	
		if(!$id){
			$profile_id = $this->feed_options->get_option('ik_fb_page_id'); //id of the facebook page
		} else {
			$profile_id = $id;
		}
	
		if(isset($profile_id) && strlen($profile_id)>0){				
			//see if a limit is set in the options, if one wasn't passed via shortcode
			if(!$num_posts){
				$limit = $this->feed_options->get_option('ik_fb_feed_limit');
			} else {
				$limit = $num_posts;
			}
			
			//make sure its really a number, otherwise we default to 25
			if(!is_numeric($limit)){				
				$limit = 25;
			}
			
			// Since we'll need to throw out some posts, we will query Facebook for 
			// the max possible # of posts and filter down to $limit from there
			// RWG: 1.21.15 -- reduced this from 250 to 50 due to various issues with the API timing out
			$fb_post_limit = 50; // TODO: move to a constant	
			
			//handle events
			if($content_type == "events") {
				//set a date range from now until a year in the future, to grab all upcoming events and no past events
				//these are the default values used if an override isn't set
				$now = time();
				$end_date = $now + 31557600;
				
				//check to see if we are using the manually selected event dates
				//or the automatically generated dates from the floating event dates
				$manual = get_option('ik_fb_range_or_manual','event-start-end-date-options') == 'event-date-range-window' ? false : true;
				
				if($manual){
					//if using manually selected options
					//load the event start date from options
					//if the event start date isn't set in the options, use now as the start date
					$event_start_date = $this->feed_options->get_option('ik_fb_event_range_start_date', $now);		

					//load the event end date from options
					//if the event end date isn't set in the options, use now + 1 year as the end date				
					$event_end_date = $this->feed_options->get_option('ik_fb_event_range_end_date', $end_date);
				} else {
					//if using automatically generated options
					$days_into_past = $this->feed_options->get_option('ik_fb_event_range_past_days', 1209600); //1209600 is 14 days in seconds
					$days_into_future = $this->feed_options->get_option('ik_fb_event_range_future_days', 31536000); //31536000 is 365 days in seconds
					$event_start_date = $now - ($days_into_past * 86400);		
					$event_end_date = $now + ($days_into_future * 86400);					
				}				
						
				$feed = $this->fetchUrl("https://graph.facebook.com/{$profile_id}/events?summary=1&limit={$fb_post_limit}&since={$event_start_date}&until={$event_end_date}&{$this->authToken}", true);//the feed data
			} else {
				//if showing only page owner posts
				if($this->feed_options->get_option('ik_fb_only_show_page_owner') && $this->is_pro){
					//only load page owner's posts
					//RWG: 1.21.15 -- reduced this from 250 to 50 due to various issues with the API timing out
					$fb_post_limit = 50; // there seems to be a bug with the Graph API, where we need to limit to 100 here (instead of the published limit of 250)
					$feed = $this->fetchUrl("https://graph.facebook.com/{$profile_id}/posts?limit={$fb_post_limit}&{$this->authToken}", true);//the feed data
				} else {
					//if showing everything on the feed (3rd party and page owner)
					$feed = $this->fetchUrl("https://graph.facebook.com/{$profile_id}/feed?summary=1&limit={$fb_post_limit}&{$this->authToken}", true);//the feed data							
				}
			}

			$page_data = $this->fetchUrl("https://graph.facebook.com/{$profile_id}?summary=1&{$this->authToken}", true);//the page data
			if(isset($feed->data)){ //check to see if feed data is set				
				$retData['feed'] = $this->trim_feed($feed->data, $limit);

				//reverse the order of the events feed, if the option is checked.
				if($this->feed_options->get_option('ik_fb_reverse_events', 0) && $content_type == "events" && $this->is_pro){
					$retData['feed'] = array_reverse($retData['feed']);
				}
			//in this case, something didn't load correctly.  lets try and see what it is...
			} else {
				//NOTES: limit seems to be impacting response times, causing various versions of "Feed Not Loading" errors
				//As FB changes over time, so do response times, and so do incidences of this error
				//I suggest to myself implementing a method of loading, via WP Cron, a few items at a time, and paging through the requests to build the feed without loading a ton at once.
				$retData['feed_dump'] = $feed;
			}
			
			if(isset($page_data)){ //check to see if page data is set
				$retData['page_data'] = $page_data;
			}
		}
		return $retData;
	}
	
	function trim_feed($feed_items, $limit)
	{
		$valid_items = array();
		
		// sometimes $limit comes in as -1, meaning unlimited
		if ($limit < 0) {
			$limit = count($feed_items);
		}
		
		foreach ($feed_items as $item)
		{
			// see if this item is a "keeper"; if so, add it to our list
			if ($this->feed_item_is_valid($item)) {
				$valid_items[] = $item;
			}
			
			// if we have enough vaild items by now, stop the loop early
			if (count($valid_items) >= $limit) {
				break;
			}		
		}			
					
		// return whatever we have (somewhere between 0 and $limit items)
		return $valid_items;
	}
	
	function feed_item_is_valid($item)
	{
		// throw out anything that's a "story" (i.e., "John Doe liked a photo")
		// only do this if option is set to hide them
		if(!get_option('ik_fb_show_stories',1)){
			if (isset($item->story)) {
				return false;
			}
		}
		
		//  TODO: add other validation rules based on the user's settings (i.e., "Hide Photos" or "Show Only Events")
		
		// passed all rules, so return true
		return true;
	}
	
	/* Styling Functions */
	
	/*
	 * Builds a CSS string corresponding to the values of a typography setting
	 *
	 * @param	$prefix		The prefix for the settings. We'll append font_name,
	 *						font_size, etc to this prefix to get the actual keys
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_typography_css($prefix)
	{
		$css_rule_template = ' %s: %s;';
		$output = '';
		
		/* 
		 * Font Family
		 */
		$option_val = $this->feed_options->get_option($prefix . 'font_family', '');
		if (!empty($option_val)) {
			// strip off 'google:' prefix if needed
			$option_val = str_replace('google:', '', $option_val);

		
			// wrap font family name in quotes
			$option_val = '\'' . $option_val . '\'';
			$output .= sprintf($css_rule_template, 'font-family', $option_val);
		}
		
		/* 
		 * Font Size
		 */
		$option_val = $this->feed_options->get_option($prefix . 'font_size', '');
		if (!empty($option_val)) {
			// append 'px' if needed
			if ( is_numeric($option_val) ) {
				$option_val .= 'px';
			}
			$output .= sprintf($css_rule_template, 'font-size', $option_val);
		}		
		
		/* 
		 * Font Color
		 */
		$option_val = $this->feed_options->get_option($prefix . 'font_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'color', $option_val);
		}

		/* 
		 * Font Style - add font-style and font-weight rules
		 * NOTE: in this special case, we are adding 2 rules!
		 */
		$option_val = $this->feed_options->get_option($prefix . 'font_style', '');

		// Convert the value to 2 CSS rules, font-style and font-weight
		// NOTE: we lowercase the value before comparison, for simplification
		switch(strtolower($option_val))
		{
			case 'regular':
				// not bold not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold':
				// bold, but not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;

			case 'italic':
				// italic, but not bold
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold italic':
				// bold and italic
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;
			
			default:
				// empty string or other invalid value, ignore and move on
			break;			
		}			

		// return the completed CSS string
		return trim($output);		
	}
	
	/*
	 * Looks for $tag in $haystack, and inserts $replacement in its place
	 * NOTE: this function currently assumes an HTML tag preceeds $tag
	 *
	 * @param	$tag		The string to match. $replace is inserted here
	 * @param	$replace	The string to match. $replace is inserted here
	 * @param	$haystack	The string to search, and to insert $replace into
	 *
	 * @returns	string		$haystack, with $tag replaced by $replace
	 */
	 function replace_ikfb_merge_tag($tag, $replace, $haystack)
	{	
		//find the position of the search string in the haystack
		$position = strpos($haystack, $tag);
		
		// if we don't find it, return the original string
		// NOTE: we would usually use === here, but in this case 0 would 
		//		 be invalid as well, so we use == instead
		if ($position == FALSE) {
			return $haystack;
		}
		
		// Move back one character from that position, and insert our string
		// NOTE: we are assuming a closing bracket to some HTML tag here
		// TODO: Let's not assume an HTML tag! (maybe add a <span> instead?)
		return substr_replace($haystack, $replace, $position - 1, 0);
	}
	
	//inserts any selected custom styling options into the feed's message html
	//load custom style options from Pro Plugin, if available
	function ikfb_message_styling($message_html = ""){
		$css = sprintf(' style="%s"', $this->build_typography_css('ik_fb_'));
		$tag = '{ikfb:feed_item:message}';
		return $this->replace_ikfb_merge_tag($tag, $css, $message_html);
	}
	
	//inserts any selected custom styling options into the feed's message html
	//load custom style options from Pro Plugin, if available
	function ikfb_story_styling($story_html = ""){
		$css = sprintf(' style="%s"', $this->build_typography_css('ik_fb_story_'));
		$tag = '{ikfb:feed_item:story}';
		return $this->replace_ikfb_merge_tag($tag, $css, $story_html);
	}
	
	//inserts any selected custom styling options into the feed's link
	//$replace = <p class="ik_fb_facebook_link">{ikfb:feed_item:link}</p>
	function ikfb_link_styling($item_link = "") {		
		//load our custom styling, to insert
		$css = $this->build_typography_css('ik_fb_link_');
		$style_attr = sprintf(' style="%s"', $css);
		$template = '<a href="%s" target="_blank" %s>';
		return sprintf($template, $item_link, $style_attr);
	}
	
	//inserts any selected custom styling options into the feed's posted by attribute
	//$line_item .= '<p class="ikfb_item_author">Posted By '.$from_text.'</p>';		
	function ikfb_posted_by_styling($line_item = ""){	
		$css = $this->build_typography_css('ik_fb_posted_by_');
		$style_attr = sprintf(' style="%s"', $css);		
		$tag = 'Posted By';
		return $this->replace_ikfb_merge_tag($tag, $style_attr, $line_item);
	}
	
	//inserts any selected custom styling options into the feed's date attribute
	function ikfb_date_styling($line_item = ""){	
		$css = $this->build_typography_css('ik_fb_date_');
		$style_attr = sprintf(' style="%s"', $css);		
		$tag = 'class="date"';
		return $this->replace_ikfb_merge_tag($tag, $style_attr, $line_item);
	}
	
	//inserts any selected custom styling options into the feed's description
	//$replace = $item->description;				
	function ikfb_description_styling($replace = ""){	
		$css = $this->build_typography_css('ik_fb_description_');
		$style_attr = sprintf(' style="%s"', $css);		
		$tag = '{ikfb:feed_item:description}';
		return $this->replace_ikfb_merge_tag($tag, $style_attr, $replace);
	}
	
	//inserts any selected custom styling options into the feed's powered by attribute	
	//$content = '<a href="https://illuminatikarate.com/ik-facebook-plugin/" target="_blank" id="ikfb_powered_by">Powered By IK Facebook Plugin</a>';	
	function ikfb_powered_by_styling($content = ""){		
		$css = $this->build_typography_css('ik_fb_powered_by_');
		$style_attr = sprintf(' style="%s"', $css);		
		$tag = 'id="ikfb_powered_by"';
		return $this->replace_ikfb_merge_tag($tag, $style_attr, $content);
	}

	//add an inline link to the settings page, before the "deactivate" link
	function add_settings_link_to_plugin_action_links($links) { 
	  $settings_link = '<a href="admin.php?page=ikfb_configuration_options">Settings</a>';
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	// add inline links to our plugin's description area on the Plugins page
	function add_custom_links_to_plugin_description($links, $file) { 

		/** Get the plugin file name for reference */
		$plugin_file = plugin_basename( __FILE__ );
	 
		/** Check if $plugin_file matches the passed $file name */
		if ( $file == $plugin_file )
		{		
			$new_links['settings_link'] = '<a href="admin.php?page=ikfb_configuration_options">Settings</a>';
			$new_links['support_link'] = '<a href="http://goldplugins.com/contact/?utm-source=plugin_menu&utm_campaign=support&utm_banner=ikfb_settings_links" target="_blank">Pro Support</a>';
				
			if(!$this->is_pro){
				$new_links['upgrade_to_pro'] = '<a href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=plugin_menu&utm_campaign=upgrade" target="_blank">Upgrade to Pro</a>';
			}
			
			$links = array_merge( $links, $new_links);
		}
		return $links; 
	}
	
	//functions from iksocialpro
	//returns true if current item is written by the page owner
	function is_page_owner($item,$page_data){
		//only hide items if the option is toggled
		if($this->feed_options->get_option('ik_fb_only_show_page_owner') && $this->is_pro){
			if($item->from->id == $page_data->id){
				return true;
			}
			return false;
		} else {
			return true;
		}
	}
	
	//inserts avatars into the message content, if option is enabled
	function pro_user_avatars($content = "", $item = array()){				
		if($this->is_pro && $this->feed_options->get_option('ik_fb_show_avatars') && isset($item->from->id)){				
			$picture = $this->fetchUrl("https://graph.facebook.com/{$item->from->id}/picture?{$this->authToken}&redirect=0", true);
			
			$content .= "<img src=\"{$picture->data->url}\" class=\"ikfb_user_avatar\" alt=\"avatar\"/>";
		}
		
		return $content;
	}
	
	//insert comment info into feed, if enabled
	function pro_comments($item, $the_link){	
		$comment_output = "";
		$show_avatars = $this->feed_options->get_option('ik_fb_show_avatars');
		$show_date = $this->feed_options->get_option('ik_fb_show_date');
		$show_likes = $this->feed_options->get_option('ik_fb_show_likes');
		
		if($this->is_pro){	
		
			if($this->feed_options->get_option('ik_fb_show_reply_counts')){			
				$request = "https://graph.facebook.com/{$item->id}/comments?summary=1&{$this->authToken}";
							
				$data = $this->fetchUrl($request, true);
				
				$num_comments = 0;
				
				if(isset($data->summary->total_count)){
					$num_comments = $data->summary->total_count;
				}	
				
				if($num_comments > 0){				
					$comment_string = "comment";
					
					if($num_comments > 1){
						$comment_string = "comments";
					}
					
					$comment_output = '<a href="'.$the_link.'" target="_blank" class="ikfb_comments" title="Click To Read On Facebook">' . $num_comments . ' ' . $comment_string . '</a>';
				}
			}

			if($this->feed_options->get_option('ik_fb_show_replies')){	
				$has_comments = false;
				
				if(isset($item->comments)){
					$comment_list = '<ul class="ikfb_comment_list">';
					
					//list of comment groupss per feed item
					foreach($item->comments as $comments){
						//each comment group has multiple comments - conversations per feed item
						foreach($comments as $comment){
							if(isset($comment->message)){
								$comment_list .= '<li class="ikfb_comment">';
								//show avatars, if enabled
								if($show_avatars){			
									$picture = $this->fetchUrl("https://graph.facebook.com/{$comment->from->id}/picture?{$this->authToken}&redirect=0", true);
									
									$comment_avatar = "<img src=\"{$picture->data->url}\" class=\"ikfb_user_comment_avatar\" alt=\"avatar\"/>";
									
									$comment_list .= $comment_avatar;
								}
								$comment_list .= isset($comment->from->name) ? '<p class="ikfb_comment_message"><span class="ikfb_comment_author">' . $comment->from->name . ' says:</span> ' : '';
								$comment_list .= nl2br($comment->message,true) . '</p>';
								
								//output date, if option to display it is enabled
								if($show_date){
									if(strtotime($comment->created_time) >= strtotime('-1 day')){
										$date = $this->humanTiming(strtotime($comment->created_time)). " ago";
									}else{
										$date = date('F jS', strtotime($comment->created_time));
									}
								
									if(strlen($date)>2){
										$comment_list .= '<p class="ikfb_comment_date">' . $date . '</p>';
									}
								}	
								
								//ouput number of likes, if option to show them are enabled
								if($show_likes){	
									if($comment->like_count > 0){
										$like_string = "person likes";
										if($comment->like_count > 1){
											$like_string = "people like";
										}
										$comment_list .= '<p class="ikfb_comment_likes">' . $comment->like_count . ' ' . $like_string . ' this.</p>';
									}
								}						
								
								$comment_list .= '<span class="ikfb_clear"></span>';
								
								$comment_list .= '</li>';
								
								$has_comments = true;
							}
						}
					}
					
					$comment_list .= '</ul>';
				}
				
				if($has_comments){
					$comment_output .= $comment_list;
				}
			}
		}
		
		return $comment_output;
	}
	
	//insert like info into feed, if enabled
	function pro_likes($item, $the_link){
		$likes = "";
		if($this->feed_options->get_option('ik_fb_show_likes')){		
			$request = "https://graph.facebook.com/{$item->id}/likes?summary=1&{$this->authToken}";
						
			$data = $this->fetchUrl($request, true);
			
			$num_likes = 0;
			
			if(isset($data->summary->total_count)){
				$num_likes = $data->summary->total_count;
			}	
			
			if($num_likes > 0){				
				$like_string = "like";
				
				if($num_likes > 1){
					$like_string = "likes";
				}
				
				$likes = '<a href="'.$the_link.'" target="_blank" class="ikfb_likes">' . $num_likes . ' ' . $like_string . '</a> ';
			}
		}
		
		return $likes;
	}
}//end ikFacebook

//publicly available functions

//display feed
function ik_fb_display_feed(){
	$ik_fb = new ikFacebook();
	echo $ik_fb->ik_fb_output_feed();
}

//display like box
function ik_fb_display_like_button($url, $height = "45", $colorscheme = "light"){
	$ik_fb = new ikFacebook();
	echo $ik_fb->ik_fb_like_button($url,$height,$colorscheme);
}

if (!isset($ik_fb)){
	$ik_fb = new ikFacebook();
}
