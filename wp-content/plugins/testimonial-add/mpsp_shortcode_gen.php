<?php


add_shortcode( 'tss_slider', 'tss_mpsp_shortcode_generate' );
function tss_mpsp_shortcode_generate($atts, $content){
   ob_start();
  
	  extract( shortcode_atts( array(

			'id' => null,

		), $atts ) );


   include(get_post_meta($id,'mpsp_slide_layout_custom',true).".php");
   


   return ob_get_clean();

	

}





 ?>