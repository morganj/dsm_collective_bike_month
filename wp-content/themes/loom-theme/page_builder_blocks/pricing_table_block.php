<?php
class AQ_Pricing_Table_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Pricing Table',
			'size' => 'span4',
			'block_icon' => '<i class="fa fa-font"></i>',
			'block_description' => 'Use to add Text<br />HTML or shortcodes.'
		);
		
		//create the block
		parent::__construct('aq_pricing_table_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'currency' => '$',
			'amount' => '3',
			'button_text' => 'Select Plan',
			'button_url' => ''
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
			<label for="<?php echo $this->get_field_id('currency') ?>">
				Currency
				<?php echo aq_field_input('currency', $block_id, $currency, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('amount') ?>">
				Amount
				<?php echo aq_field_input('amount', $block_id, $amount, $size = 'full', $type = 'number') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('button_text') ?>">
				Button Text
				<?php echo aq_field_input('button_text', $block_id, $button_text, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('button_url') ?>">
				Button URL
				<?php echo aq_field_input('button_url', $block_id, $button_url, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Details, new line (return) for each detail.
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
		</p>
		
	<?php
	}// end form
	
	function block($instance) {
		extract($instance);
		
		$details = preg_split( '/\r\n|\r|\n/', $text );
	?>
		
		<div class="pricing">
			<div class="plan">
			
				<?php
					if($title)
						echo '<h3>' . $title . '</h3>';
				?>
				
				<h4>
					<span class="amount"><span><?php echo htmlspecialchars_decode($currency); ?></span><?php echo htmlspecialchars_decode($amount); ?></span>
				</h4>
				
				<div class="features">
					<ul>
						<?php 
							foreach( $details as $detail){
								echo '<li>' . htmlspecialchars_decode($detail) . '</li>';
							}
						?>
					</ul>
				</div>
				
				<div class="select">
					<div> 
						<a href="<?php echo esc_url($button_url); ?>" class="btn inverse"><?php echo htmlspecialchars_decode($button_text); ?></a> 
					</div>
				</div>
				
			</div>
		</div>
		
	<?php
	}//end block
	
}//end class