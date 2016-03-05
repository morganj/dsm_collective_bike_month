<div id="sub-header" class="sub-footer footer <?php echo get_option('header_layout'); ?>">
  <div class="container">
    
    <div class="pull-left">
    	<?php
    		if( get_option('header_phone') )
    			echo '<i class="budicon-telephone"></i> <a href="tel:' . get_option('header_phone') . '">'. get_option('header_phone') .'</a>';
    			
    		if( get_option('header_email') )
    			echo '<i class="budicon-mail"></i> <a href="mailto:' . get_option('header_email') . '">'. get_option('header_email') .'</a>';
    	?>
    </div>
    
    <ul class="social pull-right">
      <?php 
      	for( $i = 0; $i < 7; $i++ ){
      		if( get_option("header_social_link_$i") ) {
      			echo '<li><a href="' . esc_url(get_option("header_social_link_$i"), 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'skype') . '" target="_blank">
      					  <i class="icon-s-' . get_option("header_social_$i") . '"></i>
      				  </a></li>';
      		}
      	} 
      ?>
    </ul>
    
  </div>
</div>