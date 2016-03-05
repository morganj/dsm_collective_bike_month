<li id="portfolio-<?php the_ID(); ?>" class="item thumb <?php echo ebor_the_isotope_terms(); ?>">
	<figure>
		<a href="<?php the_permalink(); ?>">
			<div class="text-overlay">
				<?php the_title('<div class="info">', '</div>'); ?>
			</div>
			<?php the_post_thumbnail('portfolio'); ?>
		</a>
	</figure>
</li>