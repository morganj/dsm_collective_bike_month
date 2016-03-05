<div class="item">

  <?php if( has_post_thumbnail() ) : ?>
  	<figure>
  		<a href="<?php the_permalink(); ?>">
  			<div class="text-overlay">
  				<?php the_title('<div class="info">', '</div>'); ?>
  			</div>
  			<?php the_post_thumbnail('portfolio'); ?>
  		</a>
  	</figure>
  <?php endif; ?>
  
  <div class="image-caption text-center">
    <?php 
    	the_title('<h4 class="post-title upper entry-title"><a href="'. get_permalink() .'">', '</a></h4>');
    ?>
    <div class="meta"> 
    	<span class="categories"><?php echo ebor_the_simple_terms_links(); ?></span> 
    </div>
    <?php the_excerpt(); ?>
  </div>
  
</div>