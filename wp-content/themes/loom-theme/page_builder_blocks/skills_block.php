<?php

class AQ_Skills_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
			'name' => 'Skill Bars',
			'size' => 'span6',
			'block_description' => 'Add percentage skill<br />bars to the page.'
		);
		parent::__construct('AQ_Skills_Block', $block_options);
		add_action('wp_ajax_aq_block_skill_add_new', array($this, 'add_skill'));
	}//end construct
	
	function form($instance) {
	
		$defaults = array(
			'tabs' => array(
				1 => array(
					'title' => 'Skill Bar',
					'content' => '90%',
				)
			),
			'text' => ''
		);
		
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Block Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Content Above Tabs (optional)
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full', true) ?>
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
			<a href="#" rel="skill" class="aq-sortable-add-new button">Add New</a>
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
						Skill Bar Title<br/>
						<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
					</label>
				</p>
				<p class="tab-desc description">
					<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
						Skill ability in % e.g; 90%<br/>
						<input type="number" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][content]" value="<?php echo $tab['content'] ?>" />
					</label>
				</p>
				<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
			
		</li>
	<?php
	}//end tab
	
	function block($instance) {
		extract($instance);
		
		$output = '';
		
		if($title) 
			$output .= '<h3>' . htmlspecialchars_decode($title) . '</h3>';
			
		if($text) 
			$output .= wpautop(do_shortcode(htmlspecialchars_decode($text)));

		$output .= '<div class="divide10"></div><ul class="progress-list">';
		
		foreach($tabs as $tab){
			$output .= '<li>
		      				<p>'.$tab['title'].' <em>'.$tab['content'].'%</em></p>
		     				<div class="progress plain">
		        				<div class="bar" style="width: '.$tab['content'].'%;"></div>
		      				</div>
		    			</li>';
		}
		    
		$output .= '</ul>';
		
		echo $output;
		
	}//end block
	
	/* AJAX add tab */
	function add_skill() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the tab
		$tab = array(
			'title' => 'New Skill Bar',
			'content' => '90%'
		);
		
		if($count) {
			$this->tab($tab, $count);
		} else {
			die(-1);
		}
		
		die();
	}//end add skill
	
	function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}//end update
}//end class