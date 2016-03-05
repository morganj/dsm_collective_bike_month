<?php

class AQ_Video_Block extends AQ_Block {
	
	function __construct() {
		$block_options = array(
			'name' => 'Video',
			'size' => 'span6',
			'block_icon' => '<i class="fa fa-video"></i>',
			'block_description' => 'Use to add a Video<br />block to the page.'
		);
		parent::__construct('aq_video_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'link' => '',
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('link') ?>">
				Video or oEmbed URL.<br /><code>List of Acceptable Services Here:</code><br /><a href="http://codex.wordpress.org/Embeds" target="_blank">http://codex.wordpress.org/Embeds</a><br />
				<?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?>
			</label>
		</p>
		
	<?php
	}// end form
	
	function block($instance) {
		extract($instance);
		
		if( $link )
			echo '<figure class="media-wrapper player portfolio">' . wp_oembed_get( esc_url( $link ) ) . '</figure>';
		
	}//end block
	
}//end class