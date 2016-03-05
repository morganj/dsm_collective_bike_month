<?php
/*
This file is part of IK Facebook.

IK Facebook is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

IK Facebook is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with IK Facebook.  If not, see <http://www.gnu.org/licenses/>.

Shout out to http://www.makeuseof.com/tag/how-to-create-wordpress-widgets/ for the help
*/

class ikFacebookLikeButtonWidget extends WP_Widget
{
	function __construct(){
		$widget_ops = array('classname' => 'ikFacebookLikeButtonWidget', 'description' => 'Displays the Facebook Like Button' );
		parent::__construct('ikFacebookLikeButtonWidget', 'IK Facebook Like Button', $widget_ops);
	}
	
	function ikFacebookLikeButtonWidget(){
		$this->__construct();
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'colorscheme' => false, 'page_id' => site_url(), 'height' => '45' ) );
		$title = $instance['title'];
		$colorscheme = $instance['colorscheme'];
		$page_id = $instance['page_id'];
		$height = $instance['height'];
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: </label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('page_id'); ?>">URL to Like (defaults to Site URL): </label><input class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>" type="text" value="<?php echo esc_attr($page_id); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('height'); ?>">Height (defaults to 45px): </label><input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('colorscheme'); ?>">Like Button Color Scheme: </label><select class="widefat" id="<?php echo $this->get_field_id('colorscheme'); ?>" name="<?php echo $this->get_field_name('colorscheme'); ?>"><option <?php if($colorscheme == "light"): ?> selected="SELECTED" <?php endif; ?> value="light" >Light</option><option <?php if($colorscheme == "dark"): ?> selected="SELECTED" <?php endif; ?> value="dark">Dark</option></select></p>
		<?php
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['colorscheme'] = strip_tags( $new_instance['colorscheme'] );
		$instance['page_id'] = strip_tags( $new_instance['page_id'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		return $instance;
	}

	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$colorscheme = empty($instance['colorscheme']) ? 'light' : $instance['colorscheme'];
		$page_id = empty($instance['page_id']) ? get_option('ikfb_page_id') : $instance['page_id'];
		$height = empty($instance['height']) ? '45' : $instance['height'];

		if (!empty($title))
			echo $before_title . $title . $after_title;;

		if (!isset($ik_fb)){
			$ik_fb = new ikFacebook();
		}

		echo $ik_fb->ik_fb_like_button($page_id,$height,$colorscheme);

		echo $after_widget;
	} 
}
?>