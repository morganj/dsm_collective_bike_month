<?php

/**
 * Ebor Framework
 * Theme Support
 * @since version 1.0
 * @author TommusRhodus
 */

/**
 * Load Theme Support on Init
 */
function ebor_starter_add_editor_styles() {
	/**
	 * Add WP Editor Styling
	 */
    add_editor_style( 'editor-style.css' );
    
    /**
     * Set Content Width
     */
    if ( ! isset( $content_width ) ) $content_width = 1180;
}
add_action( 'init', 'ebor_starter_add_editor_styles', 10 );

/**
 * Load Theme Support after_theme_setup
 */
function ebor_starter_add_theme_support() {
	/**
	 * Add post thumbnail (featured image) support
	 */
	add_theme_support( 'post-thumbnails' );
	
	/**
	 * Image Sizes used in the theme
	 */
	add_image_size( 'index', 440, 290, true);
	add_image_size( 'portfolio', 440, 320, true);
	add_image_size( 'index-square', 280, 280, true );
	add_image_size( 'admin-list-thumb', 60, 60, true );
	
	/**
	 * Add Custom Background Support and Set Default
	 */
	add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );
	
	/**
	 * Add feed link support
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Add html5 support
	 */
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'image', 'chat', 'quote', 'audio' ) );
	add_post_type_support('dslc_projects','post-formats');
	
	/**
	 * Load Translation Files
	 */
	load_theme_textdomain('loom', get_template_directory() . '/languages');
	
	/**
	 * Woocommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action('after_setup_theme', 'ebor_starter_add_theme_support', 10 );