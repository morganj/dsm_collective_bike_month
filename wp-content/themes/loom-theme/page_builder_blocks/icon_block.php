<?php

class AQ_Icon_Column_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Icon Block',
			'size' => 'span3',
			'block_description' => 'Use to add Text<br />with an icon top.'
		);
		
		//create the block
		parent::__construct('aq_icon_column_block', $block_options);
	}//end construct
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'icon' => 'none',
			'link' => ''
		);
		
		$icon_options = ebor_picons();
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);

		$selected = $icon;
	?>
		
		<p class="tab-desc description">
			<label for="<?php echo 'aq_blocks['.$block_id.'][icon]'; ?>">
				Icon (Required)
				<div class="cf">
					<div class="icon-selector-render"></div>
					<select class="icon-selector" id="<?php echo $block_id .'_icon'; ?>" name="<?php echo 'aq_blocks['.$block_id.'][icon]'; ?>">
						<?php
							foreach($icon_options as $key=>$value) {
								echo '<option value="'.$key.'" '.selected( $selected, $key, false ).' data-icon="'.$key.'">'.htmlspecialchars($value).'</option>';
							}
						?>
					</select>
				</div>
			</label>
		<p>
		
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
			<label for="<?php echo $this->get_field_id('link') ?>">
				Link entire Block? Enter URL here. <code>optional</code>
				<?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?>
			</label>
		</p>

	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		if(!( isset($link) ))
			$link = false;
			
		if($link)
			echo '<a class="ebor-icon-link" href="'. esc_url($link) .'">';
	?>
	
		<div class="text-center services-1">
			<div class="col-wrapper">
				<?php 
					if(!( $icon == 'none' ))
						echo '<div class="icon-border bm15"> <i class="'. $icon .'"></i> </div>';
						
					if($title)
						echo '<h5 class="upper">'. htmlspecialchars_decode($title) .'</h5>';
						
					if($text)
						echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
				?>
			</div>
		</div>
	
	<?php	
		if($link)
			echo '</a>';
				
	}//end block
	
}//end class