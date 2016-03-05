var gold_plugins_init_selectable_code_boxes = function () {
	jQuery('.gp_code_to_copy').bind('click', function () {
		jQuery(this).select();
	});
};

	
jQuery(function () {
	var default_time_str = 'l, F jS, Y h:i:s a';
	gold_plugins_init_selectable_code_boxes();
	scg = jQuery('#gold_plugins_shortcode_generator');
	if (typeof(GoldPlugins_ShortcodeGenerator) == 'function' && scg.length > 0)
	{
		var frm = scg;//.find('form:first');
		var generator = new GoldPlugins_ShortcodeGenerator('ik_fb_feed', frm);
		var is_pro = (jQuery('#ik_fb_is_pro').val() == 'true');

		
		generator.addTextAttribute('id');
		// NOTE: colorsheme is disabled until we can support themes from the shortcode
		//generator.addOptionalAttribute('colorscheme', '');
		generator.addCheckboxAttribute('use_thumb');
		
		/* only include attributes for the feed_image_width if use_thumb is 0 */
		generator.addCustomAttribute('feed_image_width', function (field_id, values) {			
			if (values.use_thumb !== '1' && values[field_id].length > 0) {
				return field_id += '="' + values[field_id] + '"';
			} else {
				return '';
			}
		});
		
		/* only include attributes for the feed_image_height if use_thumb is 0 */
		generator.addCustomAttribute('feed_image_height', function (field_id, values) {			
			if (values.use_thumb !== '1' && values[field_id].length > 0) {
				return field_id += '="' + values[field_id] + '"';
			} else {
				return '';			
			}
		});
				
		generator.addCheckboxAttribute('show_only_events');
		generator.addCheckboxAttribute('link_photo_to_feed_item');
		generator.addNumberAttribute('num_posts', '');
		generator.addNumberAttribute('character_limit', '');
		generator.addNumberAttribute('description_character_limit', '');
		generator.addCheckboxAttribute('hide_feed_images');
		generator.addCheckboxAttribute('show_like_button');
		generator.addCheckboxAttribute('show_profile_picture');
		generator.addCheckboxAttribute('show_page_title');
		generator.addCheckboxAttribute('show_posted_by');
		generator.addCheckboxAttribute('show_date');
		generator.addCheckboxAttribute('use_human_timing');
		generator.addTextAttribute('date_format');
		
		// Pro features
		if (is_pro)
		{
		
			generator.addCheckboxAttribute('show_avatars');
			generator.addCheckboxAttribute('show_reply_counts');
			generator.addCheckboxAttribute('show_replies');
			generator.addCheckboxAttribute('show_likes');
			generator.addCheckboxAttribute('only_show_page_owner');
			generator.addCheckboxAttribute('reverse_events');
			/* only include attributes for the date formats if they have been changed from the defaults */
			generator.addCustomAttribute('start_date_format', function (field_id, values) {			
				if (values[field_id] != default_time_str) {
					return field_id += '="' + values[field_id] + '"';
				}
			});

			/* only include attributes for the date formats if they have been changed from the defaults */
			generator.addCustomAttribute('end_date_format', function (field_id, values) {			
				if (values[field_id] != default_time_str) {
					return field_id += '="' + values[field_id] + '"';
				}
			});
			generator.addTextAttribute('event_range_start_date');
			generator.addTextAttribute('event_range_end_date');
		} // end pro features
		
		jQuery('#generate').on('click', function () {
			var output  = generator.buildShortcode();
			jQuery('#sc_gen_output_wrapper').show();		
			jQuery('#sc_gen_output').val(output).select();
			return false;
		});
		
		jQuery('#sc_gen_output').bind('click', function ()
		{
			jQuery(this).select();
		});		
	}
}); 