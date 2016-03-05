<?php

class AQ_Revslider_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Revslider',
			'size' => 'span12',
			'resizable' => false,
			'block_icon' => '<i class="fa fa-random"></i>',
			'block_description' => 'Use to add a<br />Revslider to the page.'
		);
		
		//create the block
		parent::__construct('aq_revslider_block', $block_options);
	}//end construct
	
	function form($instance) {
		
		$defaults = array(
			'slider' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		// Get Rev Sliders
		global $wpdb;
		$table_name = $wpdb->prefix . 'revslider_sliders';
		$sliders = $wpdb->get_results( "SELECT id, title, alias FROM $table_name" );
		$amount = count($sliders);
		
		$slider_choices = array();
		
		if( is_array($sliders) ){
			for( $i = 0; $i < $amount; $i++ ){
				$slider_choices[$sliders[$i]->alias] = $sliders[$i]->title;
			}
		}
		
		if( $sliders ) :
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('slider') ?>">
				Choose Revolution Slider to Display<br/>
				<?php echo aq_field_select('slider', $block_id, $slider_choices, $slider) ?>
			</label>
		</p>
		
	<?php
		
		else : 
	?>
	
		<p class="description">Please Add Some Revolution Sliders</p>
		
	<?php
		endif;
	}// end form
	
	function block($instance) {
		extract($instance);
		
		echo do_shortcode( '[rev_slider '. $slider .']' );
		
	}//end block
	
}//end class