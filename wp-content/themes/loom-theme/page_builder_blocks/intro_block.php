<?php

class AQ_Intro_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Intro',
			'size' => 'span12',
			'block_description' => 'Add a large, chunky<br />intro text to the page.'
		);
		
		//create the block
		parent::__construct('aq_intro_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'text' => '',
			'wpautop' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Content
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full', true) ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('wpautop') ?>">
				Remove bottom margin?
				<?php echo aq_field_checkbox('wpautop', $block_id, $wpautop) ?>
			</label>
		</p>
		
	<?php
	}// end form
	
	function block($instance) {
		extract($instance);
 
			if( $title )
				echo '<h1>' . htmlspecialchars_decode($title) . '</h1>';
				
			if( $text )
				echo '<div class="lead">' . wpautop(do_shortcode(htmlspecialchars_decode($text))) . '</div>';
			
			if(!( $wpautop ))
				echo '<div class="divide60"></div>';

	}//end block
	
}//end class