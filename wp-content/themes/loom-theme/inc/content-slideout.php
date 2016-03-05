<a href="#" class="bonfire-slideout-button ebor-slideout-<?php echo get_option('slideout_location','right'); ?>"> 
	<i class="<?php echo get_option('slideout_icon','icon-mail-1'); ?>"></i> 
</a>

<div class="bonfire-slideout-button-triangle-background"></div>

<div class="bonfire-slideout">
  <div class="bonfire-slideout-inner">
    <div class="bonfire-slideout-inner-inner"> 
    
      <div class="bonfire-slideout-close ebor-slideout-<?php echo get_option('slideout_location','right'); ?>"></div>
      
      <div class="bonfire-slideout-content container">
      
	      <div class="thin">
		      <div class="row">
		      
		     		<?php echo do_shortcode( get_option('slideout_shortcode') ); ?>
		     		
		      </div>
	      </div>

      </div>
      
    </div>
  </div>
</div>