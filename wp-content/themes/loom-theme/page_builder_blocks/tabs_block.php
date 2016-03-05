<?php

class AQ_Ebor_Tabs_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Tabs & Toggles',
			'size' => 'span6',
			'block_description' => 'Add tabs & toggles<br />of content to the page.'
		);
		parent::__construct('AQ_Ebor_Tabs_Block', $block_options);
		add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
	}//end construct
	
	function form($instance) {
	
		$defaults = array(
			'tabs' => array(
				1 => array(
					'title' => 'My New Tab',
					'content' => 'My tab contents',
				)
			),
			'type'	=> 'tab',
			'text' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$tab_types = array(
			'tab' => 'Tabs',
			'toggle' => 'Toggles'
		);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Block Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>

		<p class="description">
			<label for="<?php echo $this->get_field_id('type') ?>">
				Tabs style<br/>
				<?php echo aq_field_select('type', $block_id, $tab_types, $type) ?>
			</label>
		</p>
		
		<div class="description cf">
			<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
				<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {	
						$this->tab($tab, $count);
						$count++;
					}
				?>
			</ul>
			<p></p>
			<a href="#" rel="tab" class="aq-sortable-add-new button">Add New</a>
			<p></p>
		</div>
		
	<?php
	}//end form
	
	function tab($tab = array(), $count = 0) {	
	?>
	
		<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $tab['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>
			
			<div class="sortable-body">
				<p class="tab-desc description">
					<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title">
						Tab Title<br/>
						<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
					</label>
				</p>
				<p class="tab-desc description">
					<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
						Tab Content<br/>
						<div class="clear"></div>
						<button name="B">B</button>
						<button name="I">I</button>
						<button name="BQ">Quote</button>
						<button name="LINK">Link</button>
						<button name="OL">OL</button>
						<button name="UL">UL</button>
						<button name="IMG">IMG</button>
						<button name="H1">H1</button>
						<button name="H2">H2</button>
						<button name="H3">H3</button>
						<button name="H4">H4</button>
						<button name="H5">H5</button>
						<button name="H6">H6</button>
						<textarea id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $tab['content'] ?></textarea>
					</label>
				</p>
				<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
		
	<?php
	}//end
	
	function block($instance) {
		extract($instance);
		
		$unique = wp_rand(0,10000);
		
		if($title)
			echo '<h3>' . htmlspecialchars_decode($title) . '</h3>';

		if( $type == 'tab' ){
	?>	
		
			<div class="tabs tabs-top left tab-container" id="tabs-<?php echo $unique; ?>">
			
			  <ul class="etabs">
				<?php
					foreach( $tabs as $key => $tab ) {
						echo '<li class="tab"><a href="#tab-' . $unique . '-' . $key . '">'. htmlspecialchars_decode($tab['title']) .'</a></li> ';
					}
				?>
			  </ul>

			  <div class="panel-container">
			  	<?php
			  		foreach( $tabs as $key => $tab ) {
			  			echo '<div class="tab-block" id="tab-' . $unique . '-' . $key . '">'. wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))) .'</div>';
			  		}
			  	?>
			  </div>

			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function () {
				"use strict";
				    jQuery('#tabs-<?php echo $unique; ?>').easytabs({
				        animationSpeed: 300,
				        updateHash: false
				    });
				});
			</script>
			
	<?php
		} elseif( $type == 'toggle' ){
	?>
			
			<div class="panel-group" id="accordion-<?php echo $unique; ?>">
				
				<?php foreach( $tabs as $key => $tab ) : ?>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title"> 
				      	<a data-toggle="collapse" class="panel-toggle <?php if($key == '1') echo 'active'; ?>" data-parent="#accordion-<?php echo $unique; ?>" href="<?php echo '#tab-' . $unique . '-' . $key; ?>"> <?php echo htmlspecialchars_decode($tab['title']); ?> </a> 
				      </h4>
				    </div>
				    <div id="<?php echo 'tab-' . $unique . '-' . $key; ?>" class="panel-collapse collapse <?php if($key == '1') echo 'in'; ?>">
				      <div class="panel-body"> <?php echo wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))); ?> </div>
				    </div>
				  </div>
				<?php endforeach; ?>

			</div>
			
	<?php		
		}//end type check
		
	}//end block
	
	/* AJAX add tab */
	function add_tab() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$tab = array(
			'title' => 'New Tab',
			'content' => ''
		);
		
		if($count) {
			$this->tab($tab, $count);
		} else {
			die(-1);
		}
		
		die();
	}//add_tab
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}//update
}//end class