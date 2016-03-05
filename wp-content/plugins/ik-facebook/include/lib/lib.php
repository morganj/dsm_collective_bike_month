<?php
	require_once('CachedCurl.php');
	require_once('GP_CacheBox.php');
	require_once('BikeShed/bikeshed.php');
	require_once('ik_fb_feed_options.php');
	require_once('wpspkg.php');

	function is_valid_key($key = '')
	{
		// look for a valid, stored API key first
		if (wpsp_check_stored_key()) {
			return true;
		}
		
		// look for a valid mulstisite key 
		if (wpsp_is_valid_multisite_key()) {
			return true;
		}

		// key could not be validated
		return false;
	}

	function wpsp_is_valid_multisite_key()
	{
		//  look for the IK FB Pro or WP Social Pro plugins to be installed and activated
		$ikfb_plugin = "ik-facebook-pro/ik_facebook_pro.php";
		$wpsp_plugin = "wp_social_pro/wp_social_pro.php";
			
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		if(is_plugin_active($ikfb_plugin) || is_plugin_active($wpsp_plugin)){
			return true;
		}
	}

	function wpsp_check_stored_key()
	{
		$email = get_option('wp_social_pro_registered_email');
		$webaddress = get_option('wp_social_pro_registered_url');
		$key = get_option('wp_social_pro_registered_key');		
		$keygen = new WPSPKG();
		$computedKey = $keygen->computeKey($email);
		return ($key == $computedKey);	
	}
