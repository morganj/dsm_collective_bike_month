<?php

add_action('add_meta_boxes','tss_mpsp_metaboxes_add');

  function tss_mpsp_metaboxes_add(){
    add_meta_box('tss_mpsp_tslider_premium_ver','Get More Awesome Features','tss_mpsp_tslider_premium_ver','tss_slider','side','high');
    add_meta_box('tss_mpsp_slider_settings','Slider Settings','tss_mpsp_slider_settings','tss_slider','normal','high');
    add_meta_box('tss_mpsp_slider_posts_settings',' Testimonial Settings','tss_mpsp_slider_posts_settings','tss_slider','normal','low');
   // add_meta_box('mpsp_slider_review','Help Us','mpsp_slider_review','mpsp_slider','side','high');
    add_meta_box('tss_mpsp_tslider_posts_shortcode','Testimonial Slider Shortcode','tss_mpsp_tslider_posts_shortcode','tss_slider','side','high');
    add_meta_box('tss_mpsp_tslider_premium_ver','Get More Awesome Features','tss_mpsp_tslider_premium_ver','tss_data','side','high');
    add_meta_box('tss_slider_data','Testimonial Data','tss_slider_data','tss_data','normal','high');
  }


  add_action('save_post','tss_mpsp_save_posts_slider');

  function tss_mpsp_save_posts_slider($post_id){
    
     // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     


// Starts Here ****** Stars ********* )))))) () Moon **********

    if( isset( $_POST['example'] ) )
        update_post_meta( $post_id, 'example',  $_POST['example']);

    ///////////////////////////////////////////
   /////////  SLider Settings Save  //////////
  ///////////////////////////////////////////
    if( isset( $_POST['mpsp_posts_bg_color'] ) )
        update_post_meta( $post_id, 'mpsp_posts_bg_color',  $_POST['mpsp_posts_bg_color']);


    if( isset( $_POST['mpsp_posts_heading_color'] ) )
        update_post_meta( $post_id, 'mpsp_posts_heading_color',  $_POST['mpsp_posts_heading_color']);


    if( isset( $_POST['mpsp_posts_description_color'] ) )
        update_post_meta( $post_id, 'mpsp_posts_description_color',  $_POST['mpsp_posts_description_color']);


    if( isset( $_POST['mpsp_slide_speed'] ) )
        update_post_meta( $post_id, 'mpsp_slide_speed',  $_POST['mpsp_slide_speed']);


    if( isset( $_POST['mpsp_slide_transistion'] ) )
        update_post_meta( $post_id, 'mpsp_slide_transistion',  $_POST['mpsp_slide_transistion']);


    if( isset( $_POST['mpsp_slide_single'] ) )
        update_post_meta( $post_id, 'mpsp_slide_single',  $_POST['mpsp_slide_single']);


    if( isset( $_POST['mpsp_slide_autoplay'] ) )
        update_post_meta( $post_id, 'mpsp_slide_autoplay',  $_POST['mpsp_slide_autoplay']);


    if( isset( $_POST['mpsp_slide_pagination'] ) )
        update_post_meta( $post_id, 'mpsp_slide_pagination',  $_POST['mpsp_slide_pagination']);


    if( isset( $_POST['mpsp_slide_pagination_numbers'] ) )
        update_post_meta( $post_id, 'mpsp_slide_pagination_numbers',  $_POST['mpsp_slide_pagination_numbers']);


    if( isset( $_POST['mpsp_slide_main_head_bar'] ) )
        update_post_meta( $post_id, 'mpsp_slide_main_head_bar',  $_POST['mpsp_slide_main_head_bar']);


    if( isset( $_POST['mpsp_slide_main_heading'] ) )
        update_post_meta( $post_id, 'mpsp_slide_main_heading',  $_POST['mpsp_slide_main_heading']);


    if( isset( $_POST['mpsp_slide_navigation'] ) )
        update_post_meta( $post_id, 'mpsp_slide_navigation',  $_POST['mpsp_slide_navigation']);


    if( isset( $_POST['mpsp_slide_nav_button_position'] ) )
        update_post_meta( $post_id, 'mpsp_slide_nav_button_position',  $_POST['mpsp_slide_nav_button_position']);


    if( isset( $_POST['mpsp_slide_nav_button_color'] ) )
        update_post_meta( $post_id, 'mpsp_slide_nav_button_color',  $_POST['mpsp_slide_nav_button_color']);


    if( isset( $_POST['mpsp_slide_custom_width'] ) )
        update_post_meta( $post_id, 'mpsp_slide_custom_width',  $_POST['mpsp_slide_custom_width']);






	    /////////////////////////////////////////////////
	   /////////  Slider Posts Settings Save  //////////
	  /////////////////////////////////////////////////

    if( isset( $_POST['mpsp_post_types'] ) )
        update_post_meta( $post_id, 'mpsp_post_types',  $_POST['mpsp_post_types']);

    if( isset( $_POST['mpsp_posts_visible'] ) )
        update_post_meta( $post_id, 'mpsp_posts_visible',  $_POST['mpsp_posts_visible']);


    if( isset( $_POST['mpsp_posts_Desc_limit'] ) )
        update_post_meta( $post_id, 'mpsp_posts_Desc_limit',  $_POST['mpsp_posts_Desc_limit']);

    if( isset( $_POST['mpsp_posts_order'] ) )
        update_post_meta( $post_id, 'mpsp_posts_order',  $_POST['mpsp_posts_order']);

    if( isset( $_POST['mpsp_posts_orderby'] ) )
        update_post_meta( $post_id, 'mpsp_posts_orderby',  $_POST['mpsp_posts_orderby']);

    if( isset( $_POST['mpsp_posts_key'] ) )
        update_post_meta( $post_id, 'mpsp_posts_key',  $_POST['mpsp_posts_key']);

    if( isset( $_POST['mpsp_posts_value'] ) )
        update_post_meta( $post_id, 'mpsp_posts_value',  $_POST['mpsp_posts_value']);

    if( isset( $_POST['mpsp_posts_img_size'] ) )
        update_post_meta( $post_id, 'mpsp_posts_img_size',  $_POST['mpsp_posts_img_size']);

    if( isset( $_POST['mpsp_slide_layout_custom'] ) )
        update_post_meta( $post_id, 'mpsp_slide_layout_custom',  $_POST['mpsp_slide_layout_custom']);


    if( isset( $_POST['mpsp_slider_id'] ) )
        update_post_meta( $post_id, 'mpsp_slider_id',  $_POST['mpsp_slider_id']);
    //Testimonial Data

    if( isset( $_POST['tss_name'] ) )
        update_post_meta( $post_id, 'tss_name',  $_POST['tss_name']);

    if( isset( $_POST['tss_ocupation'] ) )
        update_post_meta( $post_id, 'tss_ocupation',  $_POST['tss_ocupation']);

    if( isset( $_POST['tss_image'] ) )
        update_post_meta( $post_id, 'tss_image',  $_POST['tss_image']);

    if( isset( $_POST['tss_testimonial'] ) )
        update_post_meta( $post_id, 'tss_testimonial',  $_POST['tss_testimonial']);

    if( isset( $_POST['tss_mpsp_slider_img_border'] ) )
        update_post_meta( $post_id, 'tss_mpsp_slider_img_border',  $_POST['tss_mpsp_slider_img_border']);
}








 include 'mpsp_silder_settings_metabox.php';
 include 'mpsp_slider_posts_settings_metabox.php';
 include 'mpsp_slider_shortcode_metabox.php';
 include 'tss_slider_data.php';
 include 'tss_premium_ver.php';
 //include 'mpsp_slider_review.php';



 ?>