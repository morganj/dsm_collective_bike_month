<?php 

/**
 * Page Builder Functions
 * Queue Up Framework
 * @since version 1.0
 * @author TommusRhodus
 */
if(class_exists('AQ_Page_Builder')) {
	
	/**
	 * Dre-register defaults
	 */
	aq_unregister_block('AQ_Text_Block');
	aq_unregister_block('AQ_Tabs_Block');
	aq_unregister_block('AQ_Alert_Block');
	aq_unregister_block('AQ_Richtext_Block');
	aq_unregister_block('AQ_Clear_Block');
	aq_unregister_block('AQ_Widgets_Block');
	
	/**
	 * Register custom blocks
	 * Override by copying block file of your choice to your child theme, and then require & register from your child theme functions.php
	 * Ensure that you use aq_regiser_block() in your child theme to register the block with the page builder.
	 */
	if(!( class_exists('AQ_Spacer_Block') )){
		require_once ( "page_builder_blocks/spacer_block.php" );
		aq_register_block('AQ_Spacer_Block');
	}
	if(!( class_exists('AQ_Section_Block') )){
		require_once ( "page_builder_blocks/section_block.php" );
		aq_register_block('AQ_Section_Block');
	}
	if(!( class_exists('AQ_Section_Title_Block') )){
		require_once ( "page_builder_blocks/section_title_block.php" );
		aq_register_block('AQ_Section_Title_Block'); 
	}
	if(!( class_exists('AQ_Revslider_Block') )){
		require_once ( "page_builder_blocks/revslider_block.php" );
		aq_register_block('AQ_Revslider_Block'); 
	}
	if(!( class_exists('AQ_Portfolio_Block') )){
		require_once ( "page_builder_blocks/portfolio_block.php" );
		aq_register_block('AQ_Portfolio_Block'); 
	}
	if(!( class_exists('AQ_Icon_Column_Block') )){
		require_once ( "page_builder_blocks/icon_block.php" );
		aq_register_block('AQ_Icon_Column_Block');
	}
	if(!( class_exists('AQ_Icon_Multiple_Block') )){
		require_once ( "page_builder_blocks/icon_column_block.php" );
		aq_register_block('AQ_Icon_Multiple_Block');
	}
	if(!( class_exists('AQ_Process_Block') )){
		require_once ( "page_builder_blocks/process_block.php" );
		aq_register_block('AQ_Process_Block');
	}
	if(!( class_exists('AQ_Intro_Block') )){
		require_once ( "page_builder_blocks/intro_block.php" );
		aq_register_block('AQ_Intro_Block'); 
	}
	if(!( class_exists('AQ_Call_To_Action_Block') )){
		require_once ( "page_builder_blocks/call_to_action_block.php" );
		aq_register_block('AQ_Call_To_Action_Block'); 
	}
	if(!( class_exists('AQ_Ebor_Text_Block') )){
		require_once ( "page_builder_blocks/text_block.php" );
		aq_register_block('AQ_Ebor_Text_Block');
	}
	if(!( class_exists('AQ_Pricing_Table_Block') )){
		require_once ( "page_builder_blocks/pricing_table_block.php" );
		aq_register_block('AQ_Pricing_Table_Block');
	}
	
	if(!( class_exists('AQ_Map_Block') )){
		require_once ( "page_builder_blocks/map_block.php" );
		aq_register_block('AQ_Map_Block');
	}
	
	if(!( class_exists('AQ_Ebor_Alert_Block') )){
		require_once ( "page_builder_blocks/alert_block.php" );
		aq_register_block('AQ_Ebor_Alert_Block');
	}
	
	if(!( class_exists('AQ_Ebor_Tabs_Block') )){
		require_once ( "page_builder_blocks/tabs_block.php" );
		aq_register_block('AQ_Ebor_Tabs_Block');
	}
	
	if(!( class_exists('AQ_Clients_Block') )){
		require_once ( "page_builder_blocks/clients_block.php" );
		aq_register_block('AQ_Clients_Block');
	}
	
	if(!( class_exists('AQ_Skills_Block') )){
		require_once ( "page_builder_blocks/skills_block.php" );
		aq_register_block('AQ_Skills_Block');
	}
	
	if(!( class_exists('AQ_Testimonial_Carousel_Block') )){
		require_once ( "page_builder_blocks/testimonial_carousel_block.php" );
		aq_register_block('AQ_Testimonial_Carousel_Block');
	}
	
	if(!( class_exists('AQ_Portfolio_Carousel_Block') )){
		require_once ( "page_builder_blocks/portfolio_carousel_block.php" );
		aq_register_block('AQ_Portfolio_Carousel_Block');
	}
	
	if(!( class_exists('AQ_Blog_Carousel_Block') )){
		require_once ( "page_builder_blocks/blog_carousel_block.php" );
		aq_register_block('AQ_Blog_Carousel_Block');
	}
	
	if(!( class_exists('AQ_Team_Carousel_Block') )){
		require_once ( "page_builder_blocks/team_carousel_block.php" );
		aq_register_block('AQ_Team_Carousel_Block');
	}
	
	if(!( class_exists('AQ_Team_Feed_Block') )){
		require_once ( "page_builder_blocks/team_feed_block.php" );
		aq_register_block('AQ_Team_Feed_Block');
	}
	
	if(!( class_exists('AQ_Blog_Block') )){
		require_once ( "page_builder_blocks/blog_block.php" );
		aq_register_block('AQ_Blog_Block');
	}
	
	if(!( class_exists('AQ_Testimonial_Feed_Block') )){
		require_once ( "page_builder_blocks/testimonial_feed_block.php" );
		aq_register_block('AQ_Testimonial_Feed_Block');
	}
	if(!( class_exists('AQ_Image_Block') )){
		require_once ( "page_builder_blocks/image_block.php" );
		aq_register_block('AQ_Image_Block');
	}
	if(!( class_exists('AQ_Video_Block') )){
		require_once ( "page_builder_blocks/video_block.php" );
		aq_register_block('AQ_Video_Block');
	}
	
	/**
	 * Wrapper function overrides
	 * @doNotModify Unless you know exactly what you're doing, modification of these will break the theme layout. You have been warned.
	 */
	function aq_css_classes($block){
		$block = str_replace('span', '', $block);
		$output = 'col-sm-' . $block;
		return $output;
	}
	function aq_css_clearfix(){
		return false;
	}
	function aq_template_wrapper_start($template_id){
		return '';
	}
	function aq_template_wrapper_end(){
		return '';
	}
	
}