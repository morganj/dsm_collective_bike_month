<footer class="footer">

	<div class="container inner">
	  <div class="row">
	
		<?php dynamic_sidebar('singlewidget'); ?>
	    
	  </div>
	</div>
	
	<div class="sub-footer">
	  <div class="container">
	    
	    <div class="text-center">
	    	<?php echo wpautop(htmlspecialchars_decode(get_option('copyright', 'Configure this message in "appearance" => "customize"'))); ?>
	    </div>
	    
	  </div>
	</div>

</footer>