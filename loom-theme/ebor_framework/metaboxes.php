<?php
  
function ebor_custom_metaboxes( $meta_boxes ) {
	$prefix = '_ebor_'; // Prefix for all fields
	
	$social_options = array(
		array('name' => 'Pinterest', 'value' => 'pinterest'),
		array('name' => 'RSS', 'value' => 'rss'),
		array('name' => 'Facebook', 'value' => 'facebook'),
		array('name' => 'Twitter', 'value' => 'twitter'),
		array('name' => 'Flickr', 'value' => 'flickr'),
		array('name' => 'Dribbble', 'value' => 'dribbble'),
		array('name' => 'Behance', 'value' => 'behance'),
		array('name' => 'linkedIn', 'value' => 'linkedin'),
		array('name' => 'Vimeo', 'value' => 'vimeo'),
		array('name' => 'Youtube', 'value' => 'youtube'),
		array('name' => 'Skype', 'value' => 'skype'),
		array('name' => 'Tumblr', 'value' => 'tumblr'),
		array('name' => 'Delicious', 'value' => 'delicious'),
		array('name' => '500px', 'value' => '500px'),
		array('name' => 'Grooveshark', 'value' => 'grooveshark'),
		array('name' => 'Forrst', 'value' => 'forrst'),
		array('name' => 'Digg', 'value' => 'digg'),
		array('name' => 'Blogger', 'value' => 'blogger'),
		array('name' => 'Klout', 'value' => 'klout'),
		array('name' => 'Dropbox', 'value' => 'dropbox'),
		array('name' => 'Github', 'value' => 'github'),
		array('name' => 'Songkick', 'value' => 'singkick'),
		array('name' => 'Posterous', 'value' => 'posterous'),
		array('name' => 'Appnet', 'value' => 'appnet'),
		array('name' => 'Google Plus', 'value' => 'gplus'),
		array('name' => 'Stumbleupon', 'value' => 'stumbleupon'),
		array('name' => 'LastFM', 'value' => 'lastfm'),
		array('name' => 'Spotify', 'value' => 'spotify'),
		array('name' => 'Instagram', 'value' => 'instagram'),
		array('name' => 'Evernote', 'value' => 'evernote'),
		array('name' => 'Paypal', 'value' => 'paypal'),
		array('name' => 'Picasa', 'value' => 'picasa'),
		array('name' => 'Soundcloud', 'value' => 'soundcloud')
	);
	
	$portfolio_layouts = array(
		array('name' => 'Full Width (Large Element on Top)', 'value' => 'full'),
		array('name' => 'Half Width (Left/Right)', 'value' => 'half'),
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR PORTFOLIO POST TYPE /////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'portfolio_metabox',
		'title' => __('Additional Portfolio Item Details', 'loom'),
		'pages' => array('portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Portfolio Item Layout',
				'desc' => 'What layout would you like for this portfolio item?',
				'id' => $prefix . 'layout_checkbox',
				'type' => 'select',
				'options' => $portfolio_layouts
			),
			array(
				'name' => __('Client Name', 'loom'),
				'desc' => __("(Optional) Add a Client Name for this Project?", 'loom'),
				'id'   => $prefix . 'the_client',
				'type' => 'text',
			),
			array(
				'name' => __('Project Date', 'loom'),
				'desc' => __("(Optional) Add the Date this Project Took Place?", 'loom'),
				'id'   => $prefix . 'the_client_date',
				'type' => 'text_date',
			),
			array(
				'name' => __('Client URL', 'loom'),
				'desc' => __("(Optional) Add a URL for this Project?", 'loom'),
				'id'   => $prefix . 'the_client_url',
				'type' => 'text_url',
			),
			array(
			    'id'          => $prefix . 'meta_repeat_group',
			    'type'        => 'group',
			    'description' => __( 'Additional Meta Titles & Descriptions', 'loom' ),
			    'options'     => array(
			        'add_button'    => __( 'Add Another Entry', 'loom' ),
			        'remove_button' => __( 'Remove Entry', 'loom' ),
			        'sortable'      => true, // beta
			    ),
			    'fields'      => array(
					array(
						'name' => __('Additional Item Title', 'loom'),
						'desc' => __("Title of your Additional Meta", 'loom'),
						'id'   => $prefix . 'the_additional_title',
						'type' => 'text'
					),
					array(
						'name' => __('Additional Item Detail', 'loom'),
						'desc' => __("Detail of your Additional Meta", 'loom'),
						'id'   => $prefix . 'the_additional_detail',
						'type' => 'text'
					),
			    ),
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR TEAM MEMBERS      ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'team_metabox',
		'title' => __('The Job Title', 'loom'),
		'pages' => array('team'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Job Title', 'loom'),
				'desc' => '(Optional) Enter a Job Title for this Team Member',
				'id'   => $prefix . 'the_job_title',
				'type' => 'text',
			),
		)
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR PAGES           ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'page_metabox',
		'title' => __('Page Additional Details', 'loom'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Choose Single Widget Footer?','loom'),
				'desc' => __("Show the single widget footer on this page?", 'loom'),
				'id'   => $prefix . 'single_footer',
				'type' => 'checkbox',
			),
		)
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR POSTS             ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'post_metabox',
		'title' => __('The Post Sidebar', 'loom'),
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Disable Post Sidebar','loom'),
				'desc' => __("Check to disable the sidebar on this post.", 'loom'),
				'id'   => $prefix . 'disable_sidebar',
				'type' => 'checkbox',
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR SOCIAL            ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'social_metabox',
		'title' => __('Post Social Details', 'loom'),
		'pages' => array('team', 'user'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Social Icon 1',
				'desc' => 'What icon would you like for this team members first social profile?',
				'id' => $prefix . 'team_social_icon_1',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 1', 'loom'),
				'desc' => __("Enter the URL for Social Icon 1 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_1_url',
				'type' => 'text',
			),
			array(
				'name' => 'Social Icon 2',
				'desc' => 'What icon would you like for this team members second social profile?',
				'id' => $prefix . 'team_social_icon_2',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 2', 'loom'),
				'desc' => __("Enter the URL for Social Icon 1 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_2_url',
				'type' => 'text',
			),
			array(
				'name' => 'Social Icon 3',
				'desc' => 'What icon would you like for this team members third social profile?',
				'id' => $prefix . 'team_social_icon_3',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 3', 'loom'),
				'desc' => __("Enter the URL for Social Icon 3 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_3_url',
				'type' => 'text',
			),
			array(
				'name' => 'Social Icon 4',
				'desc' => 'What icon would you like for this team members fourth social profile?',
				'id' => $prefix . 'team_social_icon_4',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 4', 'loom'),
				'desc' => __("Enter the URL for Social Icon 4 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_4_url',
				'type' => 'text',
			),
			array(
				'name' => 'Social Icon 5',
				'desc' => 'What icon would you like for this team members fifth social profile?',
				'id' => $prefix . 'team_social_icon_5',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 5', 'loom'),
				'desc' => __("Enter the URL for Social Icon 5 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_5_url',
				'type' => 'text',
			),
			array(
				'name' => 'Social Icon 6',
				'desc' => 'What icon would you like for this team members sixth social profile?',
				'id' => $prefix . 'team_social_icon_6',
				'type' => 'select',
				'options' => $social_options
			),
			array(
				'name' => __('URL for Social Icon 6', 'loom'),
				'desc' => __("Enter the URL for Social Icon 6 e.g www.google.com", 'loom'),
				'id'   => $prefix . 'team_social_icon_6_url',
				'type' => 'text',
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR CLIENTS /////////////////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'clients_metabox',
		'title' => __('Client URL', 'loom'),
		'pages' => array('client'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('URL for this client (optional)', 'loom'),
				'desc' => __("Enter a URL for this client, if left blank, client logo will open into a lightbox.", 'loom'),
				'id'   => $prefix . 'client_url',
				'type' => 'text',
			),
		),
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR GALLERY POST FORMAT /////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'gallery_metabox',
		'title' => __('The Gallery', 'loom'),
		'pages' => array('post', 'portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Attach files for the gallery',
				'desc' => 'Add your images here, they will be used to create a sliding gallery for the post.',
				'id' => $prefix . 'gallery_list',
				'type' => 'file_list',
			),
		)
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR VIDEO POST FORMAT ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'video_metabox',
		'title' => __('The Video Link', 'loom'),
		'pages' => array('post', 'portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'the_video_1',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'the_video_2',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'the_video_3',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'the_video_4',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'the_video_5',
				'type' => 'textarea_code',
			),
		)
	);


	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'ebor_custom_metaboxes' );

// Initialize the metabox class
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'metabox/init.php' );
	}
}
?>