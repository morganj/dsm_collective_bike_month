<?php

function tss_mpsp_style(){


  wp_register_style('mpsp-custom-style',plugins_url('css/custom_style.css',__FILE__));
  wp_enqueue_style( 'mpsp-custom-style');

	wp_register_style('mpsp-style',plugins_url('owl-carousel/owl.carousel.css',__FILE__));
	wp_enqueue_style( 'mpsp-style' );
  
	wp_register_style('mpsp_theme',plugins_url('owl-carousel/owl.theme.css',__FILE__));
	
    wp_enqueue_style('mpsp_theme');

	wp_register_style('mpsp_transitions',plugins_url('owl-carousel/owl.transitions.css',__FILE__));
	wp_enqueue_style('mpsp_transitions');
}
add_filter('init','tss_mpsp_style');

function tss_mpsp_script(){
  
	wp_enqueue_script('mpsp_script_tss',plugins_url('owl-carousel/owl.carousel.js',__FILE__),array( 'jquery' ));
	 


}

add_filter('init','tss_mpsp_script');

function tss_mpsp_scripts_add() {

	

	$screen = get_current_screen();
	if($screen->id == 'tss_slider'){ 
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'wp-color-picker');
	wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'tss_my-script-handle', plugins_url('/lpp_color_picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

if ($screen->id =='tss_data') {
	wp_enqueue_script('mpsp_script_s',plugins_url('image-upload.js',__FILE__),array( 'jquery' ));
    wp_enqueue_media();
}
}

add_action('admin_enqueue_scripts', 'tss_mpsp_scripts_add');



 ?>