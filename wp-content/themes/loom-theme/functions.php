<?php 

/**
 * Ebor Framework
 * Queue Up Framework
 * @since version 1.0
 * @author TommusRhodus
 */
require_once ( "ebor_framework/init.php" );

/**
 * Queue up page builder elements
 */
require_once ( "page_builder_init.php" );

// Hides super annoying WP Admin Bar
add_filter('show_admin_bar', '__return_false');

/*** Remove Query String from Static Resources ***/
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );


/**
 * Please use a child theme if you need to modify any aspect of the theme, if you need to, you can add code
 * below here if you need to add extra functionality.
 * Be warned! Any code added here will be overwritten on theme update!
 * Add & modify code at your own risk & always use a child theme instead for this!
 */