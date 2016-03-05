<?php
	/**
	 * searchform.php
	 * The theme searchform
	 * @author TommusRhodus
	 * @package loom
	 * @since 1.0.0
	 */
?>

<form class="searchform" method="get" id="searchform" action="<?php echo home_url(); ?>">
	<input type="text" id="s2" name="s" class="search" placeholder="<?php _e('Search something','loom'); ?>" />
	<button type="submit" class="btn btn-default"><?php _e('Find','loom'); ?></button>
</form>