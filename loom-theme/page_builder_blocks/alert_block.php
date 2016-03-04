<?php

class AQ_Ebor_Alert_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Alerts',
			'size' => 'span6',
			'block_description' => 'Add alert blocks<br />to warn your readers.'
		);
		//create the block
		parent::__construct('aq_ebor_alert_block', $block_options);
	}//end construct
	
	function form($instance) {
		
		$defaults = array(
			'content' => '',
			'type' => '',
			'format' => 'dismiss'
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$type_options = array(
			'alert-warning' => 'Standard',
			'alert-danger' => 'Error',
			'alert-success' => 'Success',
			'alert-info' => 'Info'
		);
		
		$format_options = array(
			'standard' => 'Standard Alert',
			'dismiss' => 'Alert with Dismiss'
		);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)<br/>
				<?php echo aq_field_input('title', $block_id, $title) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('content') ?>">
				Alert Text (required)<br/>
				<?php echo aq_field_textarea('content', $block_id, $content) ?>
			</label>
		</p>
		
		<p class="description half">
			<label for="<?php echo $this->get_field_id('type') ?>">
				Alert Type<br/>
				<?php echo aq_field_select('type', $block_id, $type_options, $type) ?>
			</label>
		</p>
		
		<p class="description half">
			<label for="<?php echo $this->get_field_id('format') ?>">
				Alert Format<br/>
				<?php echo aq_field_select('format', $block_id, $format_options, $format) ?>
			</label>
		</p>

	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		if( $format == 'standard'){
			
			echo '<div class="alert '.$type.'">';
			if($title) 
				echo '<strong>' . $title . '</strong> ';
			echo do_shortcode(htmlspecialchars_decode($content)) . '</div>';
			
		} else {
			
			echo '<div class="alert '.$type.'"><button type="button" class="close" data-dismiss="alert">&times;</button>';
			if($title) 
				echo '<strong>' . $title . '</strong> ';
			echo do_shortcode(htmlspecialchars_decode($content)) . '</div>';
			
		}
			
	}//end block
	
}//end class