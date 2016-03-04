<?php $cats = get_categories('taxonomy=portfolio-category'); ?>

<div class="container">
	<ul class="filter">
		<li><a class="active" href="#" data-filter="*"><?php _e('All','loom'); ?></a></li>
		<?php 
			foreach ($cats as $cat){
				echo '<li><a href="#" data-filter=".' . $cat->slug . '">' . $cat->name . '</a></li>';
			} 
		?>
	</ul>
</div>