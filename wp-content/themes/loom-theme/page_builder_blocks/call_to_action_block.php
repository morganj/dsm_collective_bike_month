<?php

class AQ_Call_To_Action_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Call to Action',
			'size' => 'span12',
			'block_icon' => '<i class="icon-picons-font"></i>',
			'block_description' => 'Use to add Text<br />HTML or shortcodes.'
		);
		
		//create the block
		parent::__construct('aq_call_to_action_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'text' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Link Text
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Link URL
				<?php echo aq_field_input('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>
		
	<?php
	}// end form
	
	function block($instance) {
		extract($instance);
	?>
		
		<div class="text-center">
			<p class="lead lite">
				<a href="<?php echo esc_url($text); ?>"><?php echo htmlspecialchars_decode($title); ?></a>
			</p>
		</div>
		
	<?php
	}//end block
	
}//end class