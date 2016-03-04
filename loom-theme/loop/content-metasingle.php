<div class="meta">

	<span class="date">
		<?php _e('Posted on','loom'); ?> <a href="#"><?php the_time( get_option('date_format') ); ?></a>
	</span> 
	
	<?php if( has_category() ) : ?>
		<span class="category">
			<?php _e('Under','loom'); ?> <?php the_category(', '); ?>
		</span> 
	<?php endif; ?>
	
	<?php if( comments_open() ) : ?>
		<span class="comments">
			<a href="<?php comments_link(); ?>"><?php comments_number( __('0 Comments','loom'), __('1 Comment','loom'), __('% Comments','loom') ); ?></a>
		</span> 
	<?php endif; ?>
	
</div>