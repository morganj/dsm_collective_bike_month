<?php

class AQ_Section_Title_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Section Title',
			'size' => 'span12',
			'block_icon' => '<i class="icon-picons-font"></i>',
			'block_description' => 'Use to add a title &<br />subtitle to the page.'
		);
		
		//create the block
		parent::__construct('aq_section_title_block', $block_options);
	}//end construct
	
	function form($instance) {
		$defaults = array(
			'text' => '',
			'line' => 1
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title
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
			<label for="<?php echo $this->get_field_id('line') ?>">
				Use "thin" content width?<br/>
				<?php echo aq_field_checkbox('line', $block_id, $line) ?>
			</label>
		</p>
		
	<?php
	}// end form
	
	function block($instance) {
		extract($instance);
	?>
		
		<div class="section-title-wrapper">
		  <h3 class="section-title"><?php echo htmlspecialchars_decode($title); ?></h3>
		</div>
		
		<?php 
			if( $text ){
				if( $line == 1 )
					echo '<div class="thin">';
				
				if( $text ){	
					echo '<div class="text-center">'. wpautop(do_shortcode(htmlspecialchars_decode($text))) .'</div>';
					echo '<div class="divide40"></div>';
				}
				
				if( $line == 1 )
					echo '</div>';
			}
	}//end block
	
}//end class