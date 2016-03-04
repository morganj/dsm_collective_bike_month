<?php
	$additional = get_post_meta( $post->ID, '_ebor_meta_repeat_group', true );
?>

<ul class="item-details">
	<?php
		  if( get_post_meta( $post->ID, '_ebor_the_client_date', true ) && get_option('portfolio_date', '1') == 1 ){
		  		echo '<li><span>'.__('Date','loom').':</span> '.get_post_meta( $post->ID, '_ebor_the_client_date', true ).'</li>';
		  }
		  if( ebor_the_simple_terms() && get_option('portfolio_categories', '1') == 1 ){
		  		echo '<li><span>'.__('Categories','loom').':</span> '.ebor_the_simple_terms().'</li>';
		  }
		  if( get_post_meta( $post->ID, '_ebor_the_client', true ) && get_option('portfolio_client', '1') == 1 ){
		  		echo '<li><span>'.__('Client','loom').':</span> '.get_post_meta( $post->ID, '_ebor_the_client', true ).'</li>';
		  }
		  if( get_post_meta( $post->ID, '_ebor_the_client_url', true ) && get_option('portfolio_url', '1') == 1 ){
		  		echo '<li><span>'.__('URL','loom').':</span> <a href="'.esc_url(get_post_meta( $post->ID, '_ebor_the_client_url', true )).'" target="_blank">'.esc_url(get_post_meta( $post->ID, '_ebor_the_client_url', true )).'</a></li>';
		  }
		  if( $additional ){
		  	foreach( $additional as $index => $item ){
		  		echo '<li><span>';
		  		if( isset ( $item['_ebor_the_additional_title'] ) )
		  			echo $item['_ebor_the_additional_title'];
		  		echo ':</span> ';
		  		if( isset ( $item['_ebor_the_additional_detail'] ) )
		  			echo $item['_ebor_the_additional_detail'];
		  		echo '</li>';
		  	}
		  }
	?>
</ul>