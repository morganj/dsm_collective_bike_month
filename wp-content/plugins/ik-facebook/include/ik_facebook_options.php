<?php
/*
This file is part of The IK Facebook Plugin .

The IK Facebook Plugin  is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

The IK Facebook Plugin  is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with The IK Facebook Plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

class ikFacebookOptions
{
	var $root = false;
	var $is_pro = false;

	function __construct($root = false){
		//may be running in non WP mode (for example from a notification)
		if(function_exists('add_action')){
			//add a menu item
			add_action('admin_menu', array($this, 'add_admin_menu_item'));		
		}
		if ($root) {
			$this->root = $root;
		}
		
		// create the BikeShed object now, so that BikeShed can add its hooks
        $this->shed = new GoldPlugins_BikeShed();
		
		//check for pro and set class variable if so
		if(is_valid_key(get_option('ik_fb_pro_key'))){
			$this->is_pro = true;
		}
	}
	
	function add_admin_menu_item(){
		if(get_option('ik_fb_unbranded') && $this->is_pro){
			$title = __('Social Settings', 'ik-facebook');
		} else {
			$title = __('IK FB Settings', 'ik-facebook');
		}
		
		if(get_option('ik_fb_unbranded') && $this->is_pro){
			$page_title = __('Social Plugin Settings', 'ik-facebook');
		} else {
			$page_title = __('IK Facebook Plugin Settings', 'ik-facebook');
		}
		
		// TODO: Any reason not to change this to ik-facebook or something? see note on http://codex.wordpress.org/Function_Reference/add_submenu_page:
		// 		 "For $menu_slug please don't use __FILE__ it makes for an ugly URL, and is a minor security nuisance. "
		// $top_level_menu_slug = __FILE__;
		$this->top_level_menu_slug = 'ikfb_configuration_options';
		
		//create new top-level menu
		$this->hook_suffix = add_menu_page($page_title, $title, 'administrator', $this->top_level_menu_slug, array($this, 'configuration_options_page'));

		//create sub menus for each tab
		add_submenu_page( $this->top_level_menu_slug, 'Basic Configuration', 'Basic Configuration', 'manage_options', $this->top_level_menu_slug, array($this, 'configuration_options_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Style Options', 'Style Options', 'manage_options', 'ikfb_style_options', array($this, 'style_options_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Display Options', 'Display Options', 'manage_options', 'ikfb_display_options', array($this, 'display_options_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Event Options', 'Event Options', 'manage_options', 'ikfb_event_options', array($this, 'event_options_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Custom HTML Options', 'Custom HTML Options', 'manage_options', 'ikfb_custom_html_options', array($this, 'custom_html_options_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Shortcode Generator', 'Shortcode Generator', 'manage_options', 'ikfb_shortcode_generator', array($this, 'shortcode_generator_page') ); 
		add_submenu_page( $this->top_level_menu_slug, 'Plugin Status &amp; Help', 'Plugin Status &amp; Help', 'manage_options', 'ikfb_plugin_status', array($this, 'plugin_status_page') );

		//call register settings function
		add_action( 'admin_init', array($this, 'register_settings'));	

		if ( get_option('ik_fb_app_id', '') == '' ) {
			add_action( 'admin_init', array($this, 'register_admin_notices'));
		}
	}
	
	/**
	 * If the user hasn't entered their Facebook App ID, show a notice
	 */
	function register_admin_notices() {
		add_action( 'admin_notices', array( $this, 'display_admin_notices' ) );
	}
	
	/**
	 * Function to output an admin notice when the plugin has not 
	 * been configured yet
	 */
	function display_admin_notices() {
		$screen = get_current_screen();
		if ( $screen->id == $this->hook_suffix ) { //$this->hook_suffix
			$fb_url = 'https://developers.facebook.com/apps';
			$tutorial_url = 'http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/?utm_source=ikfb_settings&utm_campaign=enter_app_id_and_secret';
			
?>
		<div id='ikfb-warning' class='updated fade'>
			<p><strong><?php _e( 'Please enter your Facebook App ID and Secret Key. ', 'ik_facebook' ); ?></strong>
			<?php _e( 'This is required for the plugin to be able to access your Facebook page and display your latest posts.', 'ik-facebook');?></p>
			<p><?php printf( __( 'To get your App ID and Secret Key from Facebook, please visit the <a href="%1$s">Facebook Developer portal</a>.', 'ik-facebook'), $fb_url ); ?></p>
			<p><?php printf( __( 'As this process can be somewhat confusing for new users, we have created a <a href="%1$s">video tutorial for you to follow</a>, which explains the process in detail</a>.', 'ik-facebook' ), $tutorial_url ); ?></p>
		</div>
<?php
		} else {
?>
		<div id='ikfb-warning' class='updated fade'><p><strong><?php _e( 'IK Facebook is almost ready. ', 'ik_facebook' ); ?></strong><?php printf( __( 'You must <a href="%1$s">configure IK Facebook</a> for it to work.', 'ik-facebook' ), menu_page_url($this->top_level_menu_slug , false ) ); ?></p></div>
<?php
		}
	}
		
	//function to produce tabs on admin screen
	function ik_fb_admin_tabs() {	
		$current = $_GET['page'];
	
		$tabs = array( 'ikfb_configuration_options' => __('Basic Configuration', 'ik-facebook'), 'ikfb_style_options' => __('Style Options', 'ik-facebook'), 'ikfb_display_options' => __('Display Options', 'ik-facebook'), 'ikfb_event_options' => __('Event Options', 'ik-facebook'), 'ikfb_custom_html_options' => __('Custom HTML Options', 'ik-facebook'), 'ikfb_shortcode_generator' => __('Shortcode Generator', 'ik-facebook'), 'ikfb_plugin_status' => __('Plugin Status &amp; Help', 'ik-facebook'));
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
			foreach( $tabs as $tab => $name ){
				$class = ( $tab == $current ) ? ' nav-tab-active' : '';
				echo "<a class='nav-tab$class' href='?page=$tab'>$name</a>";
			}
		echo '</h2>';
	}
	
	//register our settings
	function register_settings(){
		//register our config settings
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_page_id', array($this, 'extract_facebook_id') );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_app_id' );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_secret_key' );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_pro_key' );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_pro_url' );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_pro_email' );
		register_setting( 'ik-fb-config-settings-group', 'ik_fb_pro_options_mixer', array($this, 'update_options_mixer') );
		
		// register pro config settings		
		register_setting( 'ik-fb-config-settings-group', 'wp_social_pro_registered_email' );
		register_setting( 'ik-fb-config-settings-group', 'wp_social_registered_url' );
		register_setting( 'ik-fb-config-settings-group', 'wp_social_pro_registered_key' );		
		
		//register our style settings
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_custom_css' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_fix_feed_image_width' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_feed_image_width' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_fix_feed_image_height' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_feed_image_height' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_feed_theme' );		
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_header_bg_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_window_bg_color' );		
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_powered_by_font_color' );		
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_powered_by_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_powered_by_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_powered_by_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_posted_by_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_posted_by_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_posted_by_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_posted_by_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_date_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_date_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_date_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_date_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_description_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_description_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_description_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_description_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_link_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_link_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_link_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_link_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_feed_window_height' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_feed_window_width' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_story_font_color' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_story_font_size' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_story_font_family' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_story_font_style' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_sidebar_feed_window_height' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_sidebar_feed_window_width' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_feed_window_width' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_feed_image_width' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_feed_image_height' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_feed_window_height' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_sidebar_feed_window_height' );
		register_setting( 'ik-fb-style-settings-group', 'other_ik_fb_sidebar_feed_window_width' );
		register_setting( 'ik-fb-style-settings-group', 'ik_fb_pro_options_mixer', array($this, 'update_options_mixer') );
		
		//register our display settings
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_hide_feed_images' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_like_button' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_profile_picture' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_page_title' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_posted_by' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_stories' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_date' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_date_format' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_use_human_timing' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_feed_limit' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_photo_feed_limit' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_powered_by' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_character_limit' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_description_character_limit' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_caption_character_limit' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_link_photo_to_feed_item' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_pro_options_mixer', array($this, 'update_options_mixer') );
		
		//register any pro settings		
		//in 2.13 update, "branding" settings were moved under the Display Options and grouped
		register_setting( 'ik-fb-branding-settings-group', 'ik_fb_only_show_page_owner' );
		register_setting( 'ik-fb-branding-settings-group', 'ik_fb_unbranded' );
		
		//in 2.13 update, Pro Display Options were moved under Standard Display Options and grouped
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_avatars' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_replies' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_reply_counts' );
		register_setting( 'ik-fb-display-settings-group', 'ik_fb_show_likes' );
		
		//in 2.13 update, Event Settings were moved out of Pro sub-tab (Pro sub-tab has been removed) and given their own tab
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_show_only_events' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_reverse_events' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_start_date_format' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_end_date_format' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_event_image_size' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_event_range_start_date' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_event_range_end_date' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_range_or_manual' );
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_event_range_past_days' );	
		register_setting( 'ik-fb-pro-event-settings-group', 'ik_fb_event_range_future_days' );			
		
		//in 2.13 update, Custom HTML Settings were moved out of the Pro sub-tab and into their own tab
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_feed_item_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_message_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_image_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_description_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_caption_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_feed_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_use_custom_html' );
		register_setting( 'ik-fb-html-settings-group', 'ik_fb_show_picture_before_message' );
	}
	
	function update_options_mixer($v = '')
	{
		return md5(rand());
	}
	
	function extract_facebook_id($input)
	{
		if (strpos($input, 'facebook.com/') !== FALSE) {
			$pieces = explode('/', $input); // divides the string in pieces where '/' is found
			return end($pieces); //takes the last piece
		}
		return $input;
	}

	function start_settings_page($wrap_with_form = true, $show_newsletter_form = true, $before_title = '' )
	{
		global $pagenow;
		
		if(get_option('ik_fb_unbranded') && $this->is_pro){
			$title = __("Facebook Settings", 'ik-facebook');
			$message = __("Facebook Settings Updated.", 'ik-facebook');
		} else {
			$title = __("IK Facebook Plugin Settings", 'ik-facebook');
			$message = __("IK Facebook Plugin Settings Updated.", 'ik-facebook');
		}
		global $current_user;
		get_currentuserinfo();		
		
		if(!$this->is_pro): ?><style>div.disabled,div.disabled th,div.disabled label,div.disabled .description{color:#999999;}</style><?php endif;
		
		?>
			<script type="text/javascript">
				jQuery(function () {
					if (typeof(gold_plugins_init_coupon_box) == 'function') {
						gold_plugins_init_coupon_box();
					}
				});
			</script>
			<?php if($this->is_pro): ?>	
			<div class="wrap ikfb_settings gold_plugins_settings">
			<?php else: ?>
			<div class="wrap ikfb_settings not-pro gold_plugins_settings">			
			<?php endif; ?>
			
				<?php echo $before_title; ?>
				
				<h2><?php echo $title; ?></h2>		
				
				<?php if( !$this->is_pro && $show_newsletter_form ): ?>
				<?php $this->output_newsletter_signup_form(); ?>
				<?php endif; ?>
			
				<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') : ?>
				<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
				<?php endif; ?>	
				
				<?php 
					//output tabs at top of options screen
					$this->ik_fb_admin_tabs();
				?>
	
				<?php if($wrap_with_form): ?>
				<form method="post" action="options.php" class="options_form">
				<?php endif; ?>
		<?php
	}
	
	function end_settings_page($wrap_with_form = true)
	{
		//don't output the save button on the status screen
		if($wrap_with_form):
		?>			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'ik-facebook') ?>" />
			</p>		
		<?php endif; ?>
		<?php if($wrap_with_form): ?></form><?php endif; ?>
		<?php
	}
	
	/*
	 * Outputs the Basic Configuration page
	 */
	function configuration_options_page()
	{
		$this->start_settings_page(true);
		settings_fields( 'ik-fb-config-settings-group' );
		?>
			<h3><?php _e("Facebook API Settings", 'ik-facebook');?></h3>
			<p><?php _e("These options tell the plugin how to access your Facebook Page. They are required for the plugin to work.", 'ik-facebook');?></p>
			<?php 
			$needs_app_id = (get_option('ik_fb_app_id', '') == '');
			$needs_secret = (get_option('ik_fb_secret_key', '') == '');
			if ( $needs_app_id ):
			?>
			<p><?php _e("<strong>Important:</strong> You'll need to <a href=\"http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/\">create a free Facebook app</a> so that your plugin can access your feed. Don't worry - it only takes 2 minutes, and we've even got <a href=\"http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/\">a video explaining the process</a>.", 'ik-facebook');?></p>
			<?php endif; ?>
			<table class="form-table">
			
			<?php
				// Facebook Page ID
				$this->shed->text( array('name' => 'ik_fb_page_id', 'label' =>'Facebook Page ID', 'value' => get_option('ik_fb_page_id'), 'description' => 'Your Facebook Username or Page ID. This can be a username (like IlluminatiKarate) or a number (like 189090822).<br />Tip: You can find it by visiting your Facebook profile and copying the entire URL into the box above.') );

				// Facebook App ID
				$desc = 'This is the App ID you acquired when you <a href="http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/" target="_blank" title="How To Get An App ID and Secret Key From Facebook">setup your Facebook app</a>.';
				$desc = $needs_app_id ? '<div class="app_id_callout">' . $desc . '</div>' : $desc;
				$this->shed->text( array('name' => 'ik_fb_app_id', 'label' =>'Facebook App ID', 'value' => get_option('ik_fb_app_id'), 'description' => $desc) );

				// Facebook Secret Key
				$desc = 'This is the App Secret you acquired when you <a href="http://goldplugins.com/documentation/wp-social-pro-documentation/how-to-get-an-app-id-and-secret-key-from-facebook/" target="_blank" title="How To Get An App ID and Secret Key From Facebook">setup your Facebook app</a>.';
				$desc = $needs_secret ? '<div class="app_id_callout">' . $desc . '</div>' : $desc;
				$this->shed->text( array('name' => 'ik_fb_secret_key', 'label' =>'Facebook Secret Key', 'value' => get_option('ik_fb_secret_key'), 'description' => $desc) );
			?>
			
			</table>
		<?php		
		
		//output registration options
		$this->output_registration_options();
		
		$this->end_settings_page();		
	}
	
	/* Outputs the Registration Options */
	function output_registration_options(){
		?>
		<h3><?php _e('WP Social Pro Registration', 'ik-facebook'); ?></h3>			
		<?php if(is_valid_key()): ?>
		<p class="plugin_is_registered">&#x2713; WP Social Pro is registered and activated. Thank you!</p>
		<?php else: ?>
		<p class="plugin_is_not_registered">&#x2718; Pro features not available. Upgrade to WP Social Pro to unlock all features. <a class="button" href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=api_key_reminder" target="_blank">Click here to upgrade now!</a></p>
		<p>Enter your Email Address and API Key here to activate additional features such as Custom HTML, Unbranded Admin Screens, Comments, Avatars, and more!</p>
		<p><a class="button" href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=plugin&utm_campaign=api_key_reminder_2">Get An API Key</a></p>
		<?php endif; ?>

		<?php if(!wpsp_is_valid_multisite_key()): ?>
		<table class="form-table">
			<?php
				// Registration Email
				$this->shed->text( array('name' => 'wp_social_pro_registered_email', 'label' =>'Email Address', 'value' => get_option('wp_social_pro_registered_email'), 'description' => 'This is the e-mail address that you used when you registered the plugin.') );

				// API Key
				$this->shed->text( array('name' => 'wp_social_pro_registered_key', 'label' =>'API Key', 'value' => get_option('wp_social_pro_registered_key'), 'description' => 'This is the API Key that you received after registering the plugin.') );
			?>
		</table>	
		<?php endif; ?>
		<?php
	}
	
	/*
	 * Outputs the Style Options page
	 */
	function style_options_page()
	{
		$this->start_settings_page();
		$ikfb_themes = array(
							'style' => 'Default Theme',
							'dark_style' => 'Dark Theme',
							'light_style' => 'Light Theme',
							'blue_style' => 'Blue Theme',
							'no_style' => 'No Theme',
						);
						
		if($this->is_pro){
			$ikfb_themes['cobalt_style'] = 'Cobalt Theme';
			$ikfb_themes['green_gray_style'] = 'Green Gray Theme';
			$ikfb_themes['halloween_style'] = 'Halloween Theme';
			$ikfb_themes['indigo_style'] = 'Indigo Theme';
			$ikfb_themes['orange_style'] = 'Orange Theme';			
		}
		?>
		<?php settings_fields( 'ik-fb-style-settings-group' ); ?>
			
			<h3><?php _e('Style Options', 'ik-facebook');?></h3>
			<p><?php _e('These options control the style of the Facebook Feed displayed on your website. You can change fonts, colors, image sizes, and even add your own custom CSS.', 'ik-facebook');?></p>
		
			<table class="form-table">
			<?php 
				$desc = 'Select which theme you want to use.  If \'No Theme\' is selected, only your own theme\'s CSS, and any Custom CSS you\'ve added, will be used.  The settings below will override the defaults set in your selected theme.';
				if (!$this->is_pro) {
					$desc .= '<br /><br /><a href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=plugin&utm_campaign=unlock_more_themes">Tip: Upgrade to WP Social Pro to unlock more themes!</a>';
				}
				$this->shed->select( array('name' => 'ik_fb_feed_theme', 'options' => $ikfb_themes, 'label' =>'Feed Theme', 'value' => get_option('ik_fb_feed_theme'), 'description' => $desc) );
			?>				
				<?php $this->shed->textarea( array('name' => 'ik_fb_custom_css', 'label' =>'Custom CSS', 'value' => get_option('ik_fb_custom_css'), 'description' => 'Input any Custom CSS you want to use here.  You can also include a file in your theme\'s folder called \'ik_fb_custom_style.css\' - any styles in that file will be loaded with the plugin.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though.') ); ?>
				
				<tr><td colspan=2><h4><?php _e('Feed Images', 'ik-facebook');?></h4></td></tr>
				
				<?php
					$checked = (get_option('ik_fb_fix_feed_image_width') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_fix_feed_image_width', 'label' =>'Fix Feed Image Width', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, images inside the feed will all be displayed at the width set below. If both this and \'Fix Feed Image Height\' are unchecked, feed will display image thumbnails.', 'inline_label' => 'Display images at the width selected below') ); 
				?>
				
				<?php
					$radio_options = array(
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_feed_image_width|%s}}', get_option('other_ik_fb_feed_image_width')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_feed_image_width', 'value' => get_option('ik_fb_feed_image_width'), 'options' => $radio_options, 'label' =>'Feed Image Width', 'description' => "If 'Fix Feed Image Width' is checked, the images will be set to this width.  Choose '100%' or 'Other' and type in an integer number of pixels.  The effect of this setting may vary, based upon your theme's CSS.") );
				?>

				<?php
					$checked = (get_option('ik_fb_fix_feed_image_height') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_fix_feed_image_height', 'label' =>'Fix Feed Image Height', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, images inside the feed will all be displayed at the height set below.  If both this and \'Fix Feed Image Width\' are unchecked, feed will display image thumbnails.', 'inline_label' => 'Display images at the height selected below') ); 
				?>
				<?php
					$radio_options = array(
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_feed_image_height|%s}}', get_option('other_ik_fb_feed_image_height')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_feed_image_height', 'value' => get_option('ik_fb_feed_image_height'), 'options' => $radio_options, 'label' =>'Feed Image Height', 'description' => "If 'Fix Feed Image Height' is checked, the images will be set to this height.  Choose '100%' or 'Other' and type in an integer number of pixels.  The effect of this setting may vary, based upon your theme's CSS.") );
				?>
				
				<tr><td colspan=2><h4><?php _e('Feed Window Color and Dimensions', 'ik-facebook');?></h4></td></tr>
				
				<?php $this->shed->color( array('name' => 'ik_fb_header_bg_color', 'label' =>'Feed Header Background Color', 'value' => get_option('ik_fb_header_bg_color'), 'description' => 'Input your hex color code, by clicking and using the Colorpicker or typing it in.  Erase the contents of this field to use the default color.') ); ?>				
				<?php $this->shed->color( array('name' => 'ik_fb_window_bg_color', 'label' =>'Feed Window Background Color', 'value' => get_option('ik_fb_window_bg_color'), 'description' => 'Input your hex color code, by clicking and using the Colorpicker or typing it in.  Erase the contents of this field to use the default color.') ); ?>
				
				<?php
					$radio_options = array(
						'' => 'Default',
						'auto' => 'Auto',
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_feed_window_height|%s}}', get_option('other_ik_fb_feed_window_height')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_feed_window_height', 'value' => get_option('ik_fb_feed_window_height'), 'options' => $radio_options, 'label' =>'Feed Window Height', 'description' => "Choose 'Auto', '100%', or 'Other' and type in an integer number of pixels. The effect of this setting may vary, based upon your theme's CSS. This option does not apply to the sidebar widget.") );
				?>
				
				<?php
					$radio_options = array(
						'' => 'Default',
						'auto' => 'Auto',
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_feed_window_width|%s}}', get_option('other_ik_fb_feed_window_width')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_feed_window_width', 'value' => get_option('ik_fb_feed_window_width'), 'options' => $radio_options, 'label' =>'Feed Window Width', 'description' => "Choose 'Auto', '100%', or 'Other' and type in an integer number of pixels. The effect of this setting may vary, based upon your theme's CSS. This option does not apply to the sidebar widget.") );
				?>
				
				<?php
					$radio_options = array(
						'' => 'Default',
						'auto' => 'Auto',
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_sidebar_feed_window_height|%s}}', get_option('other_ik_fb_sidebar_feed_window_height')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_sidebar_feed_window_height', 'value' => get_option('ik_fb_sidebar_feed_window_height'), 'options' => $radio_options, 'label' =>'Sidebar Feed Window Height', 'description' => "Choose 'Auto', '100%', or 'Other' and type in an integer number of pixels. The effect of this setting may vary, based upon your theme's CSS. This option does not apply to the sidebar widget.") );
				?>
				
				<?php
					$radio_options = array(
						'' => 'Default',
						'auto' => 'Auto',
						'100%' => '100%',
						'OTHER' => sprintf('Other Pixel Value {{text|other_ik_fb_sidebar_feed_window_width|%s}}', get_option('other_ik_fb_sidebar_feed_window_width')),
					);				
					$this->shed->radio( array('name' => 'ik_fb_sidebar_feed_window_width', 'value' => get_option('ik_fb_sidebar_feed_window_width'), 'options' => $radio_options, 'label' =>'Sidebar Feed Window Width', 'description' => "Choose 'Auto', '100%', or 'Other' and type in an integer number of pixels. The effect of this setting may vary, based upon your theme's CSS. This option does not apply to the sidebar widget.") );
				?>
								
				<tr>
					<td colspan="2">
						<h4><?php _e('Font Styling', 'ik-facebook');?></h4>
						<p class="section_intro"><strong>Tip:</strong> try out the <a href="http://www.google.com/fonts/" target="_blank">Google Web Fonts</a> for more exotic font options!</p>
					</td>
				</tr>
			
				<?php
					$values = array(
								'font_size' => get_option('ik_fb_description_font_size'),
								'font_family' => get_option('ik_fb_description_font_family'),
								'font_style' => get_option('ik_fb_description_font_style'),
								'font_color' => get_option('ik_fb_description_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_description_*', 'label' =>'Description Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>

				<?php
					$values = array(
								'font_size' => get_option('ik_fb_font_size'),
								'font_family' => get_option('ik_fb_font_family'),
								'font_style' => get_option('ik_fb_font_style'),
								'font_color' => get_option('ik_fb_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_*', 'label' =>'Message Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>

				<?php
					$values = array(
								'font_size' => get_option('ik_fb_story_font_size'),
								'font_family' => get_option('ik_fb_story_font_family'),
								'font_style' => get_option('ik_fb_story_font_style'),
								'font_color' => get_option('ik_fb_story_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_story_*', 'label' =>'Story Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>

				<?php
					$values = array(
								'font_size' => get_option('ik_fb_link_font_size'),
								'font_family' => get_option('ik_fb_link_font_family'),
								'font_style' => get_option('ik_fb_link_font_style'),
								'font_color' => get_option('ik_fb_link_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_link_*', 'label' =>'Link Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>
			
				<?php
					$values = array(
								'font_size' => get_option('ik_fb_posted_by_font_size'),
								'font_family' => get_option('ik_fb_posted_by_font_family'),
								'font_style' => get_option('ik_fb_posted_by_font_style'),
								'font_color' => get_option('ik_fb_posted_by_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_posted_by_*', 'label' =>'Posted By Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>

				<?php
					$values = array(
								'font_size' => get_option('ik_fb_date_font_size'),
								'font_family' => get_option('ik_fb_date_font_family'),
								'font_style' => get_option('ik_fb_date_font_style'),
								'font_color' => get_option('ik_fb_date_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_date_*', 'label' =>'Date Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>
			
				<?php
					$values = array(
								'font_size' => get_option('ik_fb_powered_by_font_size'),
								'font_family' => get_option('ik_fb_powered_by_font_family'),
								'font_style' => get_option('ik_fb_powered_by_font_style'),
								'font_color' => get_option('ik_fb_powered_by_font_color'),
							);
					$this->shed->typography( array('name' => 'ik_fb_powered_by_*', 'label' =>'Powered By Font', 'description' => 'Choose a font size, family, style, and color.', 'google_fonts' => true, 'default_color' => '#878787', 'values' => $values) );
				?>
			
			</table>
		<?php			
		$this->end_settings_page();		
	}
	
	/*
	 * Outputs the Display Options page
	 */
	function display_options_page()
	{
		$this->start_settings_page();
		?>
		<?php settings_fields( 'ik-fb-display-settings-group' ); ?>
			
			<h3><?php _e('Display Options', 'ik-facebook');?></h3>
			<p><?php _e('These options control the type and amount of content that is displayed in your Facebook Feed.', 'ik-facebook');?></p>
			
			
			
			<fieldset>
				<legend>Fields To Display</legend>	
				<table class="form-table">
				<?php	

					// Show Page Title (checkbox)
					$checked = (get_option('ik_fb_show_page_title') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_page_title', 'label' =>'Show Page Title', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Title of the feed will be shown.', 'inline_label' => 'Show my Page Title above my feed') );			

					// Show Profile Photo (checkbox)
					$checked = (get_option('ik_fb_show_profile_picture') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_profile_picture', 'label' =>'Show Profile Picture', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Profile Picture will be shown next to the Title of the feed.', 'inline_label' => 'Show my Profile Picture above my feed ') );
					
					// Show the Like Button (checkbox)
					$checked = (get_option('ik_fb_show_like_button') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_like_button', 'label' =>'Show Like Button', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Like Button and number of people who like your page will be displayed above the Feed.', 'inline_label' => 'Show the Like Button above my feed') ); 
					
					// Show Images in Feed (checkbox)
					// RWG: this was originally Hide Feed Images, so things are opposite
					//		ie, before checking this option would hide images.  now checking this option will display images (codepaths throughout plugin updated to match)
					$checked = (get_option('ik_fb_hide_feed_images') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_hide_feed_images', 'label' =>'Show Feed Images', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, images will be shown in your feed.', 'inline_label' => 'Show Images In My Feed') ); 

					// Show 'Stories' text (checkbox)
					$checked = (get_option('ik_fb_show_stories',1) == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_stories', 'label' =>'Show Stories', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Story text will be displayed in the feed.', 'inline_label' => 'Show \'Story\' for each item') );
					
					// Show 'Posted By' text (checkbox)
					$checked = (get_option('ik_fb_show_posted_by') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_posted_by', 'label' =>'Show Posted By', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the text Posted By PosterName will be displayed in the feed.', 'inline_label' => 'Show \'Posted by PosterName\' for each item') );

					// Show Posted Date (checkbox)
					$checked = (get_option('ik_fb_show_date') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_show_date', 'label' =>'Show Posted Date', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the date of the post will be displayed in the Feed.', 'inline_label' => 'Show the date posted for each item') );
				?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend>Advanced Display Options</legend>	
				<table class="form-table">
					<?php
					// Limit the total number of posts in the feed (number)
					$this->shed->text( array('name' => 'ik_fb_feed_limit', 'label' =>'Number of Posts', 'value' => get_option('ik_fb_feed_limit'), 'description' => 'The number of posts to show in the Standard Facebook Feed.  The default number of posts displayed is 25 - set higher numbers to display more.  If set, the feed will be limited to this number of posts.  This can be overridden via the shortcode.') );
				
					//Limit the number of photos in the feed (number)
					$this->shed->text( array('name' => 'ik_fb_photo_feed_limit', 'label' =>'Number of Photo Album Photos', 'value' => get_option('ik_fb_photo_feed_limit'), 'description' => 'The number of photos to show in a Photo Album Feed.  The default number of photos displayed is 25 - set higher numbers to display more.  If set, the photo feed will be limited to this number of photos.  This can be overridden via the shortcode.') );

					// Feed Item Message Character limit (number)
					$this->shed->text( array('name' => 'ik_fb_character_limit', 'label' =>'Post Message Character Limit', 'value' => get_option('ik_fb_character_limit'), 'description' => 'The Message is the primary text block of a post.  If set, the Message will be limited to this number of characters.  If the Message is shortened, a Read More link will be displayed that takes the user to the full length post on Facebook.') );

					// Feed Item Description Character Limit (number)
					$this->shed->text( array('name' => 'ik_fb_description_character_limit', 'label' =>'Photo Description Character Limit', 'value' => get_option('ik_fb_description_character_limit'), 'description' => 'The Description is the block of text that appears below Photos in the Standard Feed.  If set, the Description will be limited to this number of characters.  If a Description is shortened, a Read More link will be displayed that takes the user to the full length post on Facebook.') );
				
					// Link Photo To Feed Item (checkbox)
					$checked = (get_option('ik_fb_link_photo_to_feed_item') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_link_photo_to_feed_item', 'label' =>'Link Photo to Facebook Post', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Photos in the Feed will link to the same location that the Read More text does, the full post on Facebook.  If unchecked, the Photos in the Feed will link to the Full Sized version of themselves.', 'inline_label' => 'Link Photos to \'Read More\'') ); 

					// Date Format (text)
					$this->shed->text( array('name' => 'ik_fb_date_format', 'label' =>'Date Format', 'value' => get_option('ik_fb_date_format', '%B %d'), 'description' => 'The format string to be used for the Post Date.  This follows the standard used for <a href="http://php.net/manual/en/function.strftime.php">PHP strfrtime()</a>.') );

					// Disable "Human Timing" (checkbox)
					$checked = (get_option('ik_fb_use_human_timing') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_use_human_timing', 'label' =>'Disable "Human Timing" For Timestamps', 'value' => 1, 'checked' => $checked, 'description' => 'Check this box to always show normal timestamps, such as "August 9th", instead of "2 hours ago"', 'inline_label' => 'Disable Human Timing for Timestamps') );

					// Show Powered By link (checkbox)
					$checked = (get_option('ik_fb_powered_by') == '1');
					$this->shed->checkbox( array('name' => 'ik_fb_powered_by', 'label' =>'Show Powered By IK Facebook', 'value' => 1, 'checked' => $checked, 'description' => 'Love this plugin but are unable to donate?  Show your love by displaying our inconspicuous "Powered By IK Facebook" link in the footer of your site.', 'inline_label' => 'Add a "Powered By IK Facebook" link to my website\'s footer') );
					
					?>		
				</table><!-- end original table, non pro options -->
			</fieldset>
			
			<h3 id="pro-display-options"><?php _e('Pro Display Options', 'ik-facebook');?></h3>				
			<?php if(!$this->is_pro): ?><div class="disabled"><?php endif; ?>
			<?php echo $this->pro_upgrade_link(); ?>
			<table class="form-table">
			<?php
				// Use Custom HTML (checkbox)
				$checked = (get_option('ik_fb_show_avatars') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_show_avatars', 'label' => 'Show Avatars', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, user avatars will be shown in the feed.', 'inline_label' => 'Show user avatars in my feed', 'disabled' => !$this->is_pro) );
				
				// Show Comment Count (checkbox)
				$checked = (get_option('ik_fb_show_reply_counts') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_show_reply_counts', 'label' => 'Show Comment Counts', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, user comment counts will be shown in the feed, with a link to the Facebook page.', 'inline_label' => 'Show Comment Counts', 'disabled' => !$this->is_pro) );

				// Show Comments (checkbox)
				$checked = (get_option('ik_fb_show_replies') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_show_replies', 'label' => 'Show Comments', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, user comments will be shown in the feed.  If Show Avatars is also checked, user avatars will be shown in the replies.  If Show Date is is also checked, the comment date will be shown in the replies. If Show Likes is also checked, the number of likes for each comment will be displayed.', 'inline_label' => 'Show Comments', 'disabled' => !$this->is_pro) );

				// Show Likes (checkbox)
				$checked = (get_option('ik_fb_show_likes') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_show_likes', 'label' => 'Show Likes', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, user like counts will be shown in the feed, with a link to the Facebook page.', 'inline_label' => 'Show Likes', 'disabled' => !$this->is_pro) );
			?>
			</table>					
			<?php if(!$this->is_pro): ?></div><?php endif; ?>
			
			<h3 id="branding-options"><?php _e('Branding Options', 'ik-facebook');?></h3>	
			<?php if(!$this->is_pro): ?><div class="disabled"><?php endif; ?>
			<?php echo $this->pro_upgrade_link(); ?>
			<table class="form-table">	
			<?php
				// Only Show Page Owner's Posts (checkbox)
				$checked = (get_option('ik_fb_only_show_page_owner') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_only_show_page_owner', 'label' =>'Only Show Page Owner\'s Posts', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the only posts shown will be those made by the Page Owner.  This is a good way to prevent random users from posting things to your FB Wall that will then show up on your website.', 'inline_label' => 'Only show posts made by the page owner', 'disabled' => !$this->is_pro) );

				// Hide Branding (checkbox)
				$checked = (get_option('ik_fb_unbranded') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_unbranded', 'label' =>'Hide Branding', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, our branding will be hidden from the Dashboard.', 'inline_label' => 'Hide WP Social Branding', 'disabled' => !$this->is_pro) );
			?>
			</table>
			<?php if(!$this->is_pro): ?></div><?php endif; ?>
		<?php	
		$this->end_settings_page();		
	}
	
	/*
	 * Outputs the Event Options page
	 */
	function event_options_page()
	{
		$this->start_settings_page();
		?>
		<?php settings_fields( 'ik-fb-pro-event-settings-group' ); ?>
			
		<h3><?php _e('Event Options');?></h3>
				
		<fieldset>
			<legend>Only Display Events:</legend>	
			<table class="form-table">	
				<?php // Show Only Events (checkbox)
				$checked = (get_option('ik_fb_show_only_events') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_show_only_events', 'label' =>'Only Show Events', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, only Events will be shown in your Feed.', 'inline_label' => 'Only Show Events in my Feed') ); ?>
			</table>
		</fieldset>
		
		<?php if(!$this->is_pro): ?><div class="disabled"><?php endif; ?>
		
		<?php echo $this->pro_upgrade_link(); ?>
		<fieldset>
			<legend>Event Feed Order:</legend>	
			<table class="form-table">	
			<?php			
				// Reverse Event Feed Order (checkbox)
				$checked = (get_option('ik_fb_reverse_events') == '1');
				$this->shed->checkbox( array('name' => 'ik_fb_reverse_events', 'label' =>'Reverse Event Feed Order', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the order of the events feed will be reversed.', 'inline_label' => 'Reverse the order of the events feed', 'disabled' => !$this->is_pro) );
			?>
			</table>
		</fieldset>
		<fieldset>
			<legend>Event Date Format:</legend>	
			<table class="form-table">	
			<?php
				// Start Date Format (text)
				$value = get_option('ik_fb_start_date_format', 'l, F jS, Y h:i:s a');
				$this->shed->text( array('name' => 'ik_fb_start_date_format', 'label' =>'Start Date Format', 'value' => $value, 'description' => 'The format string to be used for the Event Start Date.  This follows the standard used for PHP date.  Warning: this is an advanced feature - do not change this value if you do not know what you are doing! The default setting is l, F jS, Y h:i:s a', 'disabled' => !$this->is_pro) );

				// End Date Format (text)
				$value = get_option('ik_fb_end_date_format', 'l, F jS, Y h:i:s a');
				$this->shed->text( array('name' => 'ik_fb_end_date_format', 'label' =>'End Date Format', 'value' => $value, 'description' => 'The format string to be used for the Event End Date.  This follows the standard used for PHP date.  Warning: this is an advanced feature - do not change this value if you do not know what you are doing! The default setting is l, F jS, Y h:i:s a', 'disabled' => !$this->is_pro) );
			?>			
			</table>
		</fieldset>
		<fieldset>	
			<legend>Floating or Manual Range:</legend>	
			<table class="form-table">	
			<?php
				// Use Event Date Range Window option or Use Event Start Date and Event End Date options
				// Depending on selection, we will either calculate the Date Range using the Window selected, or will use the manually selected dates in the Event Start Date and Event End Date options
				$radio_options = array(
					'event-date-range-window' => 'Floating Date Range',
					'event-start-end-date-options' => 'Manual Event Start and End Date Options',
				);				
				$this->shed->radio( array('name' => 'ik_fb_range_or_manual', 'value' => get_option('ik_fb_range_or_manual','event-start-end-date-options'), 'options' => $radio_options, 'label' =>'Use Floating or Manual Selection', 'description' => "Depending on selection, we will either calculate the Date Range using the time frame selected, or will will use the manually selected dates in the Event Start Date and Event End Date options.", 'disabled' => !$this->is_pro) );
			?>
			</table>
		</fieldset>
		</fieldset>			
		<fieldset>
			<legend>Floating Date Range:</legend>	
			<table class="form-table">	
			<?php
				// Floating Event Range - Days Into Future
				$this->shed->text( array('name' => 'ik_fb_event_range_future_days', 'label' =>'Days Into Future', 'value' => get_option('ik_fb_event_range_future_days',365), 'description' => 'How many days into the future to look for Upcoming Events. Defaults to 365 days.', 'disabled' => !$this->is_pro) );
				
				// Floating Event Range - Days Into Past
				$this->shed->text( array('name' => 'ik_fb_event_range_past_days', 'label' =>'Days Into Past', 'value' => get_option('ik_fb_event_range_past_days',14), 'description' => 'How many days into the past to show Old Events. Defaults to 14 days.', 'disabled' => !$this->is_pro) );
			?>
			</table>
		</fieldset>
		<fieldset>
			<legend>Manual Date Range:</legend>	
			<table class="form-table">	
			<?php
				// Event Range - Start Date (text / datepicker)
				$this->shed->text( array('name' => 'ik_fb_event_range_start_date', 'label' =>'Event Range Start Date', 'value' => get_option('ik_fb_event_range_start_date'), 'description' => 'The Start Date of Events you want shown.  Events that start before this date will not be shown in the feed - even if their End Date is after this date.', 'class' => 'datepicker', 'disabled' => !$this->is_pro) );
			
				// Event Range - End Date (text / datepicker)
				$this->shed->text( array('name' => 'ik_fb_event_range_end_date', 'label' =>'Event Range End Date', 'value' => get_option('ik_fb_event_range_end_date'), 'description' => 'The End Date of Events you want shown.  Events that end after this date will not be shown in the feed - even if their Start Date is before this date.', 'class' => 'datepicker', 'disabled' => !$this->is_pro) );
			
			?>
			</table>
		</fieldset>
		<fieldset>
			<legend>Event Image Size:</legend>	
			<table class="form-table">	
			<?php
				$ikfb_event_image_sizes = array(
					'normal' => 'Normal',
					'small' => 'Small',
					'large' => 'Large',
					'square' => 'Square'
				);			
				$this->shed->select( array('name' => 'ik_fb_event_image_size', 'options' => $ikfb_event_image_sizes, 'label' =>'Event Feed Image Size', 'value' => get_option('ik_fb_event_image_size'), 'description' => 'Select which size of image to display with Events in your Feed.', 'disabled' => !$this->is_pro) );
			?>
			</table>
		</fieldset>			
		<?php if(!$this->is_pro): ?></div><?php endif; ?>
		<?php	
		$this->end_settings_page();		
	}
	
	/*
	 * Outputs the Custom HTML Options page
	 */
	function custom_html_options_page()
	{
		$this->start_settings_page();
		?>
				
		<?php settings_fields( 'ik-fb-html-settings-group' ); ?>			
			
		<h3><?php _e('Custom HTML', 'ik-facebook');?></h3>
		<?php if(!$this->is_pro): ?><div class="disabled"><?php endif; ?>
		
		<?php echo $this->pro_upgrade_link(); ?>
		<table class="form-table">
		<?php
			// Use Custom HTML (checkbox)
			$checked = (get_option('ik_fb_use_custom_html') == '1');
			$this->shed->checkbox( array('name' => 'ik_fb_use_custom_html', 'label' => 'Use Custom HTML', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, this will disable the Style Options in the first tab and will instead use the HTML from below.', 'inline_label' => 'Use Custom HTML', 'disabled' => !$this->is_pro) );

			// Hide Branding (checkbox)
			$checked = (get_option('ik_fb_show_picture_before_message') == '1');
			$this->shed->checkbox( array('name' => 'ik_fb_show_picture_before_message', 'label' => 'Show Picture Before Message', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Picture HMTL will be output before the Message HTML.', 'inline_label' => 'Output the Picture HTML before the Message HTML', 'disabled' => !$this->is_pro) );
			
			// Custom Feed Item Wrapper HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though. Accepts the following shortcodes: {ikfb:feed_item}';
			$desc .= '<br />Example: <code>' . htmlentities('<li class="ik_fb_feed_item">{ikfb:feed_item}</li>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_feed_item_html', 'label' => 'Custom Feed Item Wrapper HTML', 'value' => get_option('ik_fb_feed_item_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
			
			// Custom Feed Message HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though. Accepts the following shortcodes: {ikfb:feed_item:message}';
			$desc .= '<br />Example: <code>' . htmlentities('<p>{ikfb:feed_item:message}</p>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_message_html', 'label' => 'Custom Feed Message HTML', 'value' => get_option('ik_fb_message_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
			
			// Custom Feed Image HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though. Accepts the following shortcodes: {ikfb:feed_item:image}';
			$desc .= '<br />Example: <code>' . htmlentities('<p class="ik_fb_facebook_image">{ikfb:feed_item:image}</p>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_image_html', 'label' => 'Custom Feed Image HTML', 'value' => get_option('ik_fb_image_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
			
			// Custom Feed Description HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though. Accepts the following shortcodes: {ikfb:feed_item:description}';
			$desc .= '<br />Example: <code>' . htmlentities('<p class="ik_fb_facebook_description">{ikfb:feed_item:description}</p>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_description_html', 'label' => 'Custom Feed Description HTML', 'value' => get_option('ik_fb_description_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
			
			// Custom Feed Caption HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though. Accepts the following shortcodes: {ikfb:feed_item:link}';
			$desc .= '<br />Example: <code>' . htmlentities('<p class="ik_fb_facebook_link">{ikfb:feed_item:link}</p>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_caption_html', 'label' => 'Custom Feed Caption HTML', 'value' => get_option('ik_fb_caption_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
			
			// Custom Feed Wrapper HTML (textarea)
			$desc = 'Input any Custom Feed Item HTML you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though.  Accepts the following shortcodes: {ikfb:image},{ikfb:link},{ikfb:like_button}, and {ikfb:feed}.';
			$desc .= '<br />Example: <code>' . htmlentities('<div id="ik_fb_widget"><div class="ik_fb_profile_picture">{ikfb:image}{ikfb:link}</div>{ikfb:like_button}<ul class="ik_fb_feed_window">{ikfb:feed}</ul></div>') . '</code>';
			$this->shed->textarea( array('name' => 'ik_fb_feed_html', 'label' => 'Custom Feed Wrapper HTML', 'value' => get_option('ik_fb_feed_html'), 'description' => $desc, 'disabled' => !$this->is_pro) );
		?>
		</table>		
		<?php if(!$this->is_pro): ?></div><?php endif; ?>
		
		<?php	
		$this->end_settings_page();		
	}
	
	/* outputs Upgrade to Pro text, if Pro is not registered. */
	function pro_upgrade_link($text = 'Upgrade To WP Social Pro To Unlock These Features')
	{
		if(!$this->is_pro) {
			return '<p class="plugin_is_not_registered">&#x2718; Pro features not available. Upgrade to WP Social Pro to unlock all features. <a class="button" href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=plugin_dash&utm_campaign=upgrade_to_unlock" target="_blank">Click here to upgrade now!</a></p>';
		} else {
			return '';
		}
	}
	
	/*
	 * Outputs the Basic Configuration page
	 */
	function pro_options_page()
	{
		$this->start_settings_page();
		global $ik_social_pro_options;
		$ik_social_pro_options->output_settings($this->shed);
		$this->end_settings_page();		
	}
	
	/*
	 * Outputs the Shortcode Generator page
	 */
	function shortcode_generator_page()
	{
		// start the settings page, outputting a notice about the Graph API if needed
		$this->start_settings_page(false);
			
		$this->is_pro = $this->is_pro;
		
		wp_enqueue_script( 'gp_shortcode_generator');
		wp_enqueue_script( 'ikfb-admin');
		echo '<form id="gold_plugins_shortcode_generator">';
		printf('<input type="hidden" id="ik_fb_is_pro" value="%s" />', ($this->is_pro ? 'true': 'false')); 
		echo '<h3>Shortcode Generator</h3>';		
		echo '<table class="form-table">';
			echo '<tbody>';
			// Facebook Page ID
			$this->shed->text( array('name' => 'id', 'label' =>'Facebook Page ID', 'value' => get_option('ik_fb_page_id'), 'description' => 'Your Facebook Username or Page ID. This can be a username (like IlluminatiKarate) or a number (like 189090822).') );	

			//feed themes array
			$ikfb_themes = array(
				'style' => 'Default Theme',
				'dark_style' => 'Dark Theme',
				'light_style' => 'Light Theme',
				'blue_style' => 'Blue Theme',
				'no_style' => 'No Theme',
			);

			if($this->is_pro){
				$ikfb_themes['cobalt_style'] = 'Cobalt Theme';
				$ikfb_themes['green_gray_style'] = 'Green Gray Theme';
				$ikfb_themes['halloween_style'] = 'Halloween Theme';
				$ikfb_themes['indigo_style'] = 'Indigo Theme';
				$ikfb_themes['orange_style'] = 'Orange Theme';			
			}
			
			$desc = 'Select which theme you want to use.  If \'No Theme\' is selected, only your own theme\'s CSS, and any Custom CSS you\'ve added, will be used.  The settings below will override the defaults set in your selected theme.';
			if (!$this->is_pro) {
				$desc .= '<br /><br /><a href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=plugin&utm_campaign=unlock_more_themes">Tip: Upgrade to WP Social Pro to unlock more themes!</a>';
			}
			
			// NOTE: disabled until we can support themes from the shortcode
			//feed themes dropdown menu
			//$this->shed->select( array('name' => 'colorscheme', 'options' => $ikfb_themes, 'label' =>'Feed Theme', 'value' => get_option('ik_fb_feed_theme'), 'description' => $desc) );
			
			// Use Thumbnails (radio)
			$radio_options = array(
				'1' => 'Use \'Thumbnail Size\' for images',
				'0' => 'Use the sizes specified below (Feed Image Width and Feed Image Height)',
			);				
			$this->shed->radio( array('name' => 'use_thumb', 'value' => get_option('ik_fb_use_thumb'), 'options' => $radio_options, 'label' =>'Use Image Thumbnails', 'description' => 'If you choose to specify your sizes, make sure to complete the 2 fields below (Feed Image Width and Feed Image Height).') );
			
			//feed image width
			$this->shed->text( array('name' => 'feed_image_width', 'label' =>'Feed Image Width', 'value' => get_option('ik_fb_feed_image_width'), 'description' => 'The desired width of images in the feed. (Note: this field will be ignored if you select "Use \'Thumbnail Size\' above")') );	
			
			//feed image height
			$this->shed->text( array('name' => 'feed_image_height', 'label' =>'Feed Image Height', 'value' => get_option('ik_fb_feed_image_height'), 'description' => 'The desired height of images in the feed. (Note: this field will be ignored if you select "Use \'Thumbnail Size\' above")') );	
			
			// Show Only Events (checkbox)
			$checked = (get_option('ik_fb_show_only_events') == '1');
			$this->shed->checkbox( array('name' => 'show_only_events', 'label' =>'Show Only Events', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, only Events will be shown in your Feed.', 'inline_label' => 'Only Show Events In My Feed') ); 
			
			// Link Photo To Feed Item (checkbox)
			$checked = (get_option('ik_fb_link_photo_to_feed_item') == '1');
			$this->shed->checkbox( array('name' => 'link_photo_to_feed_item', 'label' =>'Link Photo to Feed Item', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the Photos in the Feed will link to the same location that the Read More text does.  If unchecked, the Photos in the Feed will link to the Full Sized version of themselves.', 'inline_label' => 'Link Photos to \'Read More\'') ); 

			// Limit the total number of posts in the feed (number)
			$this->shed->text( array('name' => 'num_posts', 'label' =>'Number of Feed Items', 'value' => get_option('ik_fb_feed_limit'), 'description' => 'The default number of items displayed is 25 - set higher numbers to display more.  If set, the feed will be limited to this number of items.  This can be overridden via the shortcode.') );

			// Feed Item Message Character limit (number)
			$this->shed->text( array('name' => 'character_limit', 'label' =>'Feed Item Message Character Limit', 'value' => get_option('ik_fb_character_limit'), 'description' => 'If set, the feed item will be limited to this number of characters.  If a feed item is shortened, a Read More link will be displayed.') );

			// Feed Item Description Character Limit (number)
			$this->shed->text( array('name' => 'description_character_limit', 'label' =>'Feed Item Description Character Limit', 'value' => get_option('ik_fb_description_character_limit'), 'description' => 'If set, the feed item will be limited to this number of characters.  If a feed item is shortened, a Read More link will be displayed.') );
		
			// Hide Images in Feed (checkbox)
			$radio_options = array(
				'0' => 'Hide All Images In My Feed',
				'1' => 'Allow Images In My Feed',
			);				
			$this->shed->radio( array('name' => 'hide_feed_images', 'value' => get_option('ik_fb_hide_feed_images'), 'options' => $radio_options, 'label' =>'Hide Feed Images', 'description' => "Whether or not to allow images in your feed") );
			

			// Show the Like Button (checkbox)
			$radio_options = array(
				'1' => 'Show A Like Button Above My Feed',
				'0' => 'No Like Button',
			);				
			$this->shed->radio( array('name' => 'show_like_button', 'value' => get_option('ik_fb_show_like_button'), 'options' => $radio_options, 'label' =>'Show Like Button', 'description' => "If selected, a Like Button and number of people who like your page will be displayed above the Feed.") );

			// Show Profile Photo (checkbox)
			$radio_options = array(
				'1' => 'Show Profile Picture',
				'0' => 'No Profile Picture',
			);				
			$this->shed->radio( array('name' => 'show_profile_picture', 'value' => get_option('ik_fb_show_profile_picture'), 'options' => $radio_options, 'label' =>'Show Profile Picture', 'description' => "If selected, your Profile Picture will be shown next to the Title of the feed.") );

			// Show Page Title (checkbox)
			$radio_options = array(
				'1' => 'Show Page Title Picture',
				'0' => 'Do Not Show Page Title',
			);				
			$this->shed->radio( array('name' => 'show_page_title', 'value' => get_option('ik_fb_show_page_title'), 'options' => $radio_options, 'label' =>'Show Page Title', 'description' => "If selected, your Title of your page will be shown above the feed.") );

			// Show 'Posted By' text (checkbox)
			$radio_options = array(
				'1' => 'Show \'Posted by Author_Name\' with each post in your feed',
				'0' => 'Do not show the author\'s name with each post',
			);				
			$this->shed->radio( array('name' => 'show_posted_by', 'value' => get_option('ik_fb_show_posted_by'), 'options' => $radio_options, 'label' =>'Show \'Posted By\' Text', 'description' => "If selected, the text 'Posted By Author_Name' will be displayed in the feed.") );

			// Show Posted Date (checkbox)
			$radio_options = array(
				'1' => 'Show the date posted for each item in the feed',
				'0' => 'Do not show the date posted',
			);				
			$this->shed->radio( array('name' => 'show_date', 'value' => get_option('ik_fb_show_date'), 'options' => $radio_options, 'label' =>'Show Post Date', 'description' => "If selected,  the date of the post will be displayed in the Feed.") );

			// Disable "Human Timing" (checkbox)
			$radio_options = array(
				'1' => 'Use \'Human Timing\' (Example: "posted 2 hours ago")',
				'0' => 'Use \'Literal Timing\' (Example: "posted at 12:35 pm")',
			);				
			$this->shed->radio( array('name' => 'use_human_timing', 'value' => get_option('ik_fb_use_human_timing'), 'options' => $radio_options, 'label' =>'Use \'Human Timing\'', 'description' => 'Choose whether to use the more user-friendly "Human Timing" for your posts, or the standard "Literal Times"') );

			// Date Format (text)
			$this->shed->text( array('name' => 'date_format', 'label' =>'Date Format', 'value' => get_option('ik_fb_date_format'), 'description' => 'The format string to be used for the Post Date.  This follows the standard used for PHP strfrtime().  Warning: this is an advanced feature - do not change this value if you do not know what you are doing! The default setting is %B %d') );
			
			if(!$this->is_pro){
				echo '<tr valign="top"><th colspan="2"><p class="plugin_is_not_registered">&#x2718; Pro features not available. Upgrade to WP Social Pro to unlock all features. <a class="button" href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=sc_generator&utm_campaign=upgrade_to_unlock" target="_blank">Click here to upgrade now!</a></p></th></tr>';
			}
			
			// Show Avatars (radio)
			$radio_options = array(
				'1' => 'Show avatars',
				'0' => 'Do not show avatars',
			);				
			$this->shed->radio( array('name' => 'show_avatars', 'value' => get_option('ik_fb_show_avatars'), 'options' => $radio_options, 'label' =>'Show Avatars', 'description' => "Whether or not to show the avatar of the author for each post in the feed", 'disabled' => !$this->is_pro) );
			
			
			// Show Comment Count (radio)
			$radio_options = array(
				'1' => 'Show comment counts',
				'0' => 'Do not show comment counts',
			);				
			$this->shed->radio( array('name' => 'show_reply_counts', 'value' => get_option('ik_fb_show_reply_counts'), 'options' => $radio_options, 'label' =>'Show Comment Counts', 'description' => "Whether or not to show the comment count for each post in the feed", 'disabled' => !$this->is_pro) );

			// Show Comments (radio)
			$radio_options = array(
				'1' => 'Show comments',
				'0' => 'Do not show comments',
			);				
			$this->shed->radio( array('name' => 'show_replies', 'value' => get_option('ik_fb_show_replies'), 'options' => $radio_options, 'label' =>'Show Comments', 'description' => "Whether or not to show comments in your feed", 'disabled' => !$this->is_pro) );

			// Show Likes (radio)			
			$radio_options = array(
				'1' => 'Show the number of likes on each post',
				'0' => 'Do not show the number of likes on each post',
			);				
			$this->shed->radio( array('name' => 'show_likes', 'value' => get_option('ik_fb_show_likes'), 'options' => $radio_options, 'label' =>'Show Like Counts', 'description' => "Whether or not to show the number of likes for each post in the feed", 'disabled' => !$this->is_pro) );
			
			
			// Only Show Page Owner's Posts (checkbox)
			$radio_options = array(
				'1' => 'Only show posts made by the page owner',
				'0' => 'Show posts by all users (default)',
			);				
			$this->shed->radio( array('name' => 'only_show_page_owner', 'value' => get_option('ik_fb_only_show_page_owner'), 'options' => $radio_options, 'label' =>'Only Show Page Owner\'s Posts', 'description' => "Only show posts made by the page owner. This is a good choice if you don't want random posts appearing in your feed.", 'disabled' => !$this->is_pro) );



			
			// Reverse Event Feed Order (checkbox)
			$checked = (get_option('ik_fb_reverse_events') == '1');
			$this->shed->checkbox( array('name' => 'reverse_events', 'label' =>'Reverse Event Feed Order', 'value' => 1, 'checked' => $checked, 'description' => 'If checked, the order of the events feed will be reversed.', 'inline_label' => 'Reverse the order of the events feed', 'disabled' => !$this->is_pro) );
		
			// Start Date Format (text)
			$value = get_option('ik_fb_start_date_format', 'l, F jS, Y h:i:s a');
			$this->shed->text( array('name' => 'start_date_format', 'label' =>'Start Date Format', 'value' => $value, 'description' => 'The format string to be used for the Event Start Date.  This follows the standard used for PHP date.  Warning: this is an advanced feature - do not change this value if you do not know what you are doing! The default setting is l, F jS, Y h:i:s a', 'disabled' => !$this->is_pro) );

			// End Date Format (text)
			$value = get_option('ik_fb_end_date_format', 'l, F jS, Y h:i:s a');
			$this->shed->text( array('name' => 'end_date_format', 'label' =>'End Date Format', 'value' => $value, 'description' => 'The format string to be used for the Event End Date.  This follows the standard used for PHP date.  Warning: this is an advanced feature - do not change this value if you do not know what you are doing! The default setting is l, F jS, Y h:i:s a', 'disabled' => !$this->is_pro) );

			// Event Range - Start Date (text / datepicker)
			$this->shed->text( array('name' => 'event_range_start_date', 'label' =>'Event Range Start Date', 'value' => get_option('ik_fb_event_range_start_date'), 'description' => 'The Start Date of Events you want shown.  Events that start before this date will not be shown in the feed - even if their End Date is after this date.', 'class' => 'datepicker', 'disabled' => !$this->is_pro) );
		
			// Event Range - End Date (text / datepicker)
			$this->shed->text( array('name' => 'event_range_end_date', 'label' =>'Event Range End Date', 'value' => get_option('ik_fb_event_range_end_date'), 'description' => 'The End Date of Events you want shown.  Events that end after this date will not be shown in the feed - even if their Start Date is before this date.', 'class' => 'datepicker', 'disabled' => !$this->is_pro) );
						
			// shortcode output
			//$this->shed->textarea( array('name' => 'sc_gen_output', 'label' =>'Your Shortcode') );
			echo '</tbody>';
		echo '</table>';

		// Generate button
		echo '<p class="submit"><input id="generate" type="submit" value="Generate My Shortcode" class="button-primary"></p>';
		
		?>
			<div id="sc_gen_output_wrapper">
				<label for="sc_gen_output">Here is your Shortcode!</label>
				<p class="description">Copy and paste this shortcode into any page or post to display your Facebook Feed!</p>
				<textarea cols="80" rows="4" id="sc_gen_output"></textarea>
			</div>
		<?php
		echo '</form>';
		$this->end_settings_page(false);
	}
	
	/*
	 * Outputs the Basic Configuration page
	 */
	function plugin_status_page()
	{
		$diagnostics_results = $this->run_diagnostics();
		$graph_api_warning = '';
		
		// if their API Key and Secret work, but we can't load their profile, 
		// let the user know that they need to make their profile public
		if ($diagnostics_results['loaded_demo_profile'] && !$diagnostics_results['loaded_own_profile']) {
			$graph_api_warning = '<p class="alert_important"><strong>Your Facebook page (' . get_option("ik_fb_page_id") .') cannot be accessed via the Graph API</strong>Please verify that your Facebook page is Public, that it is not a Personal account, and that it has no Country, Age or other restrictions enabled.</p>';
		}

		// start the settings page, outputting a notice about the Graph API if needed
		$this->start_settings_page(false, true, $graph_api_warning);
			
		// output the Status Widget with the results of our diagnostics
		echo '<h2>';
		_e('Plugin Status', 'ik-facebook');
		echo'</h2>';
		echo '<p>';
		_e('We\'re running some quick tests, to help you troubleshoot any issues you might be running into while setting up your Facebook feed.', 'ik-facebook');
		echo '</p>';
		$this->output_status_box($diagnostics_results);
			

		// output the current configuration settings (e.g., Page ID, API Key, and Secret)
		_e("<h2>Configuration Settings</h2>", 'ik-facebook');
		_e("<p>If you need to contact us for help, please be sure to include these settings in your message, as well as a functional description of how you have the feed implemented on your site.</p>", "ik-facebook");
		echo "<table><tbody>";
		_e("<tr><td align='right'>Page ID:</td><td>" . get_option("ik_fb_page_id") . "</td></tr>");
		_e("<tr><td align='right'>App ID:</td><td>" . get_option("ik_fb_app_id") . "</td></tr>");
		_e("<tr><td align='right'>Secret Key:</td><td>" . get_option("ik_fb_secret_key") . "</td></tr>");
		echo "</tbody></table>";
					
		// show some example shortcodes				
		$this->output_example_shortcodes();
		
		// show a message about where they can get help from a human
		_e("<h3>Get Help From A Human</h3>", 'ik-facebook');
		_e("<p>Still having trouble? Sometimes talking to another person is the best way to get moving again.</p>", 'ik-facebook');
		_e("<p>There are two great ways to get help from another human being:</p>", 'ik-facebook');
		echo "<ol>";
		_e('<li><a href="https://wordpress.org/support/plugin/ik-facebook">Leave a message on the WordPress Support Forums</a>, and see if another member of the community can help.</li>', 'ik-facebook');
		if (!$this->is_pro) {
			_e('<li><a href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/?utm_source=help_from_a_human">Upgrade to WP Social Pro</a>, and get support directly from the developers.</li>', 'ik-facebook');
		} else {
			_e('<li><a href="http://goldplugins.com/contact/">Contact Gold Plugins Support</a>. Please include the email address you used to purchase, and the address of this website.</li>', 'ik-facebook');
		}
		echo "</ol>";
		_e("<p>If nothing else works, you might also try taking a 15 minute break. You'd be surprised how well it can work!</p>", 'ik-facebook');
		
		
		$this->end_settings_page(false);		
	}
	
	function output_example_shortcodes()
	{
?>
		<div id="ikfb_example_shortcodes">
<?php		
		echo '<h2>' . __("Example Shortcodes") . '</h2>';
?>
		<ul class="gp_inline_menu">
			<li><strong><?php _e('Jump to:', 'ik-facebook'); ?></strong></li>
			<li><a href="#fb_feed_shortcodes"><?php _e('Facebook Feed Shortcodes', 'ik-facebook'); ?></a></li>
			<li><a href="#fb_like_button_shortcodes"><?php _e('Like Button Shortcodes', 'ik-facebook'); ?></a></li>
			<li><a href="#fb_photo_gallery_shortcodes"><?php _e('Photo Gallery Shortcodes', 'ik-facebook'); ?></a></li>
		</ul>	
<?php
		// show some example shortcodes				
		$shortcode_generator_url = menu_page_url( 'ikfb_shortcode_generator', false );
		$s_msg = sprintf('The example shortcodes below are meant to show off some of the attributes you can pass to the shortcodes. For advanced styling, check out the <a href="%s">shortcode generator.</a>', $shortcode_generator_url);
		echo '<p>' . __($s_msg) . '</p>';
		echo '<p>' . __('Tip: try mixing and matching the attributes in these examples! These are only suggestions meant ot get you thinking, not an exhaustive list of what the plugin can do.', 'ik-facebook') . '</p>';
		
		_e('<h3 id="fb_feed_shortcodes">Facebook Feed Shortcodes</h3>', 'ik-facebook');
		echo '<p>' . __('To output a custom feed of your own posts, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed]</textarea>';
		echo '<p>' . __('To show a feed from another page, for example NatGeo\'s page, use the id attribute:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed id="NatGeo"]</textarea>';
		echo '<p>' . __('This shortcode will output a feed that\'s 500px wide and 300px tall:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed width="500" height="300"]</textarea>';
		echo '<p>' . __('This shortcode will output a feed using the light color scheme:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed colorscheme="light"]</textarea>';
		echo '<p>' . __('This shortcode will output a feed using the dark color scheme (the default is light):', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed colorscheme="dark"]</textarea>';
		echo '<p>' . __('This shortcode will output a feed which includes your Facebook Profile Picture:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed use_thumb="true"]</textarea>';
		echo '<p>' . __('This shortcode will output a feed <em>without</em> your Facebook Profile Picture:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed use_thumb="false"]</textarea>';
		echo '<p>' . __('This shortcode will output only your most recent post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed num_posts="1"]</textarea>';
		echo '<p>' . __('This shortcode will output your 5 most recent posts: ', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_feed num_posts="5"]</textarea>';
		echo '<p>' . __('<em>Tip: you can change 5 to any number you wish, up to 100, and your feed will always show that many posts.</em>', 'ik-facebook') . '</p>';		
		//_e('<p>To further customize the feed via the shortcode, available attributes include: <code>colorscheme="light" use_thumb="true" width="250" num_posts="5" id="123456789"</code>.</p>');
		//_e('<p><em>Valid choices for "colorscheme" are "light" and "dark". If "use_thumb" is set to true, the value of "width" will be ignored.  If "use_thumb" or "width" are not set, the values from the Options page will be used.  If id is not set, the shortcode will use the Page ID from your Settings page.</em></p>');
		echo '<br />';

		_e('<h3 id="fb_like_button_shortcodes">Like Button Shortcodes</h3>', 'ik-facebook');
		echo '<p>' . __('To output a Like Button for your website, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_like_button]</textarea>';
		echo '<p>' . __('To output a Like Button for a specific page on your website, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_like_button url="http://www.YourWebsite.com/example"]</textarea>';
		echo '<p>' . __('To output a Like Button using the light color scheme, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_like_button url="http://www.YourWebsite.com/example" colorscheme="light"]</textarea>';
		echo '<p>' . __('To output a Like Button using the dark color scheme, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_like_button url="http://www.YourWebsite.com/example" colorscheme="dark"]</textarea>';
		echo '<p>' . __('Valid attributes include: <code>url="" height="" colorscheme="light"</code>.', 'ik-facebook') . '</p>';
		echo '<p>' . __('<em>Valid options for colorscheme are "light" and "dark".  Valid values for height are integers.  URL must be a valid website URL.</em>', 'ik-facebook') . '</p>';


		_e('<h3 id="fb_photo_gallery_shortcodes">Photo Gallery Shortcodes</h3>', 'ik-facebook');
		$s_important = __('Important', 'ik-facebook');
		$s_main_msg = __('The id attribute is always required for photo galleries. It corresponds to your photo gallery\'s ID on Facebook. You can find it by visiting the photo gallery on Facebook, and then examining the URL.', 'ik-facebook');
		$s_more_info = __('More Information', 'ik-facebook');
		$faq_url = 'http://goldplugins.com/documentation/wp-social-pro-documentation/frequently-asked-questions/#easy-faq-815';
		//'Important</strong>: The id attribute is always required for photo galleries. It corresponds to your photo gallery\'s ID on Facebook. You can find it by visiting the photo gallery on Facebook, and then examining the URL. More info <a href="%s"></p>';
		printf('<p><strong>%s:</strong> %s [<a href="%s">%s</a>]', $s_important, $s_main_msg, $faq_url, $s_more_info);
		echo '<p>' . __('To output a Photo Gallery, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery limited to 25 items, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" num_photos="25"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 130px wide and 73px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="130x73"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 320px wide and 180px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="320x180"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 480px wide and 270px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="480x270"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 600px wide and 337px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="600x337"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 720px wide and 405px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="720x405"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 960px wide and 540px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="960x540"]</textarea>';
		echo '<p>' . __('To output a Photo Gallery with thumbnails that are 2048px wide and 1152px tall, place the following shortcode in the body of any page or post:', 'ik-facebook') . '</p>';
		echo '<textarea class="gp_code_to_copy">[ik_fb_gallery id="539627829386059" size="2048x1152"]</textarea>';
		echo '<p>' . __('<em>If no size is passed, it will default to 320 x 180.  Size options are 2048x1152, 960x540, 720x405, 600x337, 480x270, 320x180, and 130x73.  If num_photos is not passed, the Gallery will default to the amount set on the Dashboard - if no amount is set there, it will display up to 25 photos.  The ID number is found by looking at the URL of the link to the Album on Facebook - you can read more on our FAQs <a href="http://goldplugins.com/documentation/wp-social-pro-documentation/frequently-asked-questions/">here</a>.</em>', 'ik-facebook') . '</p>';

?>
		</div>
<?php		
		
	}
	
	function run_diagnostics()
	{
		// required settings for Graph API		
		$app_id = get_option('ik_fb_page_id', '');
		$secret_key = get_option('ik_fb_page_id', '');
		$page_id = get_option('ik_fb_page_id', '');
		
		// default all flags to false
		$results = array( 'keys_present' => false,
						  'keys_work' => false,
						  'loaded_demo_profile' => false,
						  'loaded_own_profile' => false,
					);
					
		/* run tests! */
		
		// Test #1: make sure the keys are present
		if ( empty($app_id) || empty($secret_key)  || empty($page_id) ) {
			$results['keys_present'] = false;
			return $results;
		} else {
			$results['keys_present'] = true;
		}

		// Test #2: See if we can connect to the Graph API and generate an Access Token
		$access_token = $this->root->generateAccessToken();
		
		if ( empty($access_token)){
			$results['keys_work'] = false;
		} else {
			$results['keys_work'] = true;
		}
		
		// Test #3: See if we can load the demo profile
		$demo_feed = $this->root->loadFacebook('IlluminatiKarate');		
		if ( empty($demo_feed['feed']) ) {
			$results['loaded_demo_profile'] = false;
			$results['loaded_own_profile'] = false;
			return $results;
		} else {
			$results['loaded_demo_profile'] = true;
		}
				  
		// Test #4: See if we can load the owner's profile
		$own_feed = $this->root->loadFacebook($page_id);		
		if ( empty($own_feed['feed']) ) {
			//echo "<pre>";
			
			//print_r($own_feed);
			
			//echo "</pre>";
			
			$results['loaded_own_profile'] = false;
		} else {
			$results['loaded_own_profile'] = true;
		}
				  
		return $results;
		
	}
	
	/*
	 * Outputs a plugin status box
	 */
	function output_status_box($diagnostics_results)
	{		
?>
	
	
	<table class="table" id="plugin_status_table" cellpadding="0" cellspacing="0">
		<tbody>
			<!-- Page ID -->
			<?php if ( $diagnostics_results['keys_present'] ): ?>
			<tr class="success">
				<td><img src="<?php echo plugins_url('/img/check-button.png', __FILE__); ?>" alt="SUCCESS" /></td>
				<td>API Key and Secret Key Present</td>
			</tr>
			<?php else: ?>
			<tr class="fail">
				<td><img src="<?php echo plugins_url('/img/x-button.png', __FILE__); ?>" alt="FAIL" /></td>
				<td>API Key and Secret Key Present</td>
			</tr>
			<?php endif; ?>
			
			<!-- Connected To Graph API -->
			<?php if ( $diagnostics_results['keys_work'] ): ?>
			<tr class="success">
				<td><img src="<?php echo plugins_url('/img/check-button.png', __FILE__); ?>" alt="SUCCESS" /></td>
				<td>Connected To Facebook Graph API</td>
			</tr>
			<?php else: ?>
			<tr class="fail">
				<td><img src="<?php echo plugins_url('/img/x-button.png', __FILE__); ?>" alt="FAIL" /></td>
				<td>Connected To Facebook Graph API</td>
			</tr>
			<?php endif; ?>
			
			<!-- Load Their Page Data -->
			<?php if ( $diagnostics_results['loaded_own_profile'] ): ?>
			<tr class="success">
				<td><img src="<?php echo plugins_url('/img/check-button.png', __FILE__); ?>" alt="SUCCESS" /></td>
				<td>Loaded Your Profile</td>
			</tr>			
			<?php else: ?>
			<tr class="fail">
				<td><img src="<?php echo plugins_url('/img/x-button.png', __FILE__); ?>" alt="FAIL" /></td>
				<td>Loaded Your Profile</td>
			</tr>
			<?php endif; ?>
			
			<!-- Load Their Page Data -->
			<?php if ( $diagnostics_results['loaded_demo_profile'] ): ?>
			<tr class="success">
				<td><img src="<?php echo plugins_url('/img/check-button.png', __FILE__); ?>" alt="SUCCESS" /></td>
				<td>Loaded Test Profile</td>
			</tr>			
			<?php else: ?>
			<tr class="fail">
				<td><img src="<?php echo plugins_url('/img/x-button.png', __FILE__); ?>" alt="FAIL" /></td>
				<td>Loaded Test Profile</td>
			</tr>
			<?php endif; ?>
			
			<!-- PRO Version Activated -->
			<?php if ($this->is_pro): ?>
			<tr class="success">
				<td><img src="<?php echo plugins_url('/img/check-button.png', __FILE__); ?>" alt="SUCCESS" /></td>
				<td>PRO Features Activated</td>
			</tr>
			<?php else: ?>
			<tr class="fail">
				<td><img src="<?php echo plugins_url('/img/x-button.png', __FILE__); ?>" alt="FAIL" /></td>
				<td>PRO Features Unlocked</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
<?php	
	}
	
	
	/*
	 * Outputs a Mailchimp signup form
	 */
	function output_newsletter_signup_form()
	{
		global $current_user;
		get_currentuserinfo();
?>
			<!-- Begin MailChimp Signup Form -->
			<div id="signup_wrapper">
				<div class="topper topper_gray">
					<h3>Save 20% on WP Social Pro!</h3>
					<p class="pitch" style="font-size: 15px">When you upgrade, the new features will instantly become available to you inside this plugin - no additional downloads are required.</p>
					<h4>
					<h4>How To Save 20% on Your Upgrade:</h4>
					<p class="pitch pitch_how_to_save">Simply submit your name and email below, and we’ll send you a coupon for 20% off your upgrade to WP Social Pro.</p>
				</div>
				<div id="mc_embed_signup">
					<form action="http://goldplugins.com/atm/atm.php?u=403e206455845b3b4bd0c08dc&amp;id=a70177def0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div class="fields_wrapper">
							<label for="mce-EMAIL">Your Name:</label>
							<input type="email" value="<?php echo (!empty($current_user->display_name) ? $current_user->display_name : ''); ?>" name="NAME" class="email" id="mce-EMAIL" placeholder="Your Name" required>
							<label for="mce-EMAIL">Your Email:</label>
							<input type="email" value="<?php echo (!empty($current_user->user_email) ? $current_user->user_email : ''); ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your Email" required>
							<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;"><input type="text" name="b_403e206455845b3b4bd0c08dc_6ad78db648" tabindex="-1" value=""></div>
						</div>
						<div class="clear"><input type="submit" value="Send Me The Coupon Now!" name="subscribe" id="mc-embedded-subscribe" class="smallBlueButton"></div>
						<p class="secure"><img src="<?php echo plugins_url( 'img/lock.png', __FILE__ ); ?>" alt="Lock" width="16px" height="16px" />We respect your privacy.</p>
						<input type="hidden" name="PRODUCT" value="WP Social Pro" />
						<input type="hidden" id="mc-upgrade-plugin-name" value="WP Social Pro" />
						<input type="hidden" id="mc-upgrade-link-per" value="http://goldplugins.com/purchase/wp-social-pro/single?promo=newsub20" />
						<input type="hidden" id="mc-upgrade-link-biz" value="http://goldplugins.com/purchase/wp-social-pro/business?promo=newsub20" />
						<input type="hidden" id="mc-upgrade-link-dev" value="http://goldplugins.com/purchase/wp-social-pro/developer?promo=newsub20" />
						<p class="customer_testimonial">
							"It's easy to use, it works, and with excellent support from it's developers - there is no reason to use any other plugin."
							<br /><span class="author">&dash; Jake Wheat, Author &amp; Artist</span>
						</p>
					</form>
				</div>
				<p class="u_to_p"><a href="http://goldplugins.com/our-plugins/wp-social-pro/upgrade-to-wp-social-pro/#buy_now"><?php _e("Upgrade to WP Social Pro now</a> to remove banners like this one.", 'ik-facebook'); ?></p>
			</div>
		<?php
	} // end output_newsletter_signup_form function
} // end class
?>