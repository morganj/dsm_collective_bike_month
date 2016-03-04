<div class="meta"> 
	
	<?php if( has_category() ) : ?>
		<span class="categories">
			<?php the_category(', '); ?>
		</span>
	<?php endif; ?>
	
	<?php if( comments_open() ) : ?> 
		<span class="comments">
			<a href="<?php comments_link(); ?>"><?php comments_number( __('0 Comments','loom'), __('1 Comment','loom'), __('% Comments','loom') ); ?></a>
		</span>
	<?php endif; ?>
	
</div>