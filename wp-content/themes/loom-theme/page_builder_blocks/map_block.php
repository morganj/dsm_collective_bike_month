<?php

class AQ_Map_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Map',
			'size' => 'span12',
			'resizable' => 0,
			'block_description' => 'Add a google map<br />to the page.'
		);
		//create the block
		parent::__construct('aq_map_block', $block_options);
	}//end construct
	
	function form($instance) {
		
		$defaults = array(
			'image' => ''
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
	?>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('image') ?>">
				Upload a Marker Image
				<?php echo aq_field_upload('image', $block_id, $image, $media_type = 'image') ?>
			</label>
		</p>
		
		<p class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Address for map, use plain text, e.g: <code>Lord Mayors Walk, York, England</code>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</p>

	<?php
	}//end form
	
	function block($instance) {
		extract($instance);
		
		$unique = wp_rand(0,1000);
		
		echo '<div id="map-' . $unique . '-' . $block_id . '" class="map"></div>'; 
		echo "<script type='text/javascript'>
				jQuery(document).ready(function($){
				'use strict';
				
					jQuery('#map-" . $unique . "-" . $block_id . "').goMap({ address: '$title',
					  zoom: 14,
					  mapTypeControl: false,
				      draggable: false,
				      scrollwheel: false,
				      streetViewControl: true,
				      maptype: 'ROADMAP',
			    	  markers: [
			    		{ 'address' : '$title' }
			    	  ],
					  icon: '$image', 
					  addMarker: false
					});
				
				});
			</script>";
			
	}//end block
	
}//end class