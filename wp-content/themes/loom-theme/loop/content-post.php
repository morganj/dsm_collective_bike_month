<div id="post-<?php the_ID(); ?>" class="post">
	
	<?php if( has_post_thumbnail() ) : ?>
		<figure>
			<a href="<?php the_permalink(); ?>">
				<div class="text-overlay">
					<div class="info"><?php echo get_option('blog_read_more', 'Read More'); ?></div>
				</div>
				<?php the_post_thumbnail('index'); ?>
			</a>
		</figure>
	<?php endif; ?>
	
	<div class="image-caption">
	
		<div class="date-wrapper">
			<div class="day"><?php echo get_the_date('d'); ?></div>
			<div class="month"><?php echo get_the_date('M'); ?></div>
		</div>
		
		<?php 
			the_title('<h4 class="post-title entry-title"><a href="'. get_permalink() .'">', '</a></h4>'); 
			get_template_part('loop/content','meta');
			echo '<p>' . wp_trim_words( get_the_content(), 26) . '</p>';
		?>

		<a href="<?php the_permalink(); ?>" class="more"><?php echo get_option('blog_continue', 'Continue Reading'); ?> →</a> 
		
	</div>

</div>
<hr />