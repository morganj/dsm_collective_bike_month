<?php
//Create Menu
function fb_display_events_shortcode_menu(){
        add_options_page( PLUGIN_NAME, PLUGIN_NAME, 'manage_options', 'fb-display-events-shortcode-plugin', 'fb_display_events_shortcode_settings_page' );
}

add_action( 'admin_menu', 'fb_display_events_shortcode_menu' );
 
//Register Menu Settings
function fb_display_events_shortcode_settings() {
	register_setting( 'fb-display-events-shortcode-plugin-settings-group', 'access_token' );
}
add_action( 'admin_init', 'fb_display_events_shortcode_settings' );

//Settings Page
function fb_display_events_shortcode_settings_page(){
        echo '<h1>' . PLUGIN_NAME . '</h1>';
		echo '<h2>';
		echo __( 'Settings', 'fb-display-events-shortcode') .':</h2>';
		echo '<div class="wrap">
			  <form method="post" action="options.php">';
			  settings_fields( 'fb-display-events-shortcode-plugin-settings-group' ); 
			  do_settings_sections( 'fb-display-events-shortcode-plugin-settings-group' );
		echo '<table class="form-table">
				<tr valign="top">
				<th scope="row">Facebook Developer Access Token</th>
				<td><input type="text" size="50" name="access_token" value="'; 
				echo esc_attr( get_option('access_token') ); 
				echo '" /></td>
				</tr>
				 
				</table>';
			
		submit_button();

		echo '</form>
			</div>';
}
?>