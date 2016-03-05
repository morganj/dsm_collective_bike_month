GoldPlugins_ShortcodeGenerator = function (shortcode, form)
{
	$ = jQuery;
	root = this; 
	root.form = jQuery(form);
	root.values = [];	
	root.attributes = [];
	root.shortcode = shortcode;
	
	this.main = function () {
		if (form.length > 0)
		{
			// wire-up the "Build My Shortcode" button
			var button = form.find('#sc_generate');
			button.on('click', root.build_shortcode);

			// make the output box auto-highlight
			root.enable_shortcode_highlighting();
			
			// make sure all disabled inputs are really disabled
			root.update_disabled_inputs();
		}
	};
	
	this.getFormValues = function(frm) {
		if (typeof(frm) == 'undefined') {
			frm = root.form;
		} else {
			frm = jQuery(frm); // for safety
		}
		var arr = frm.serializeArray();
		var vals = [];
		jQuery(arr).each(function (i) {
			vals[this.name] = this.value;
		});
		root.values = vals;
		return root.values;
	}
	
	this.addTextAttribute = function (field_id, default_val) {
		root.attributes.push(function () {
			
			// default_val defaults to 0
			if (typeof(default_val) == 'undefined') {
				default_val = '';
			}
			var val = root.get_value_from_input('#' + field_id, '');
			if (val.length > 0) {
				return field_id + '="' + val + '"';
			} else {
				return default_val;
			}
		});
	}
	
	this.addOptionalAttribute = function (field_id, default_val) {
		root.attributes.push(function () {
			
			// default_val defaults to 0
			if (typeof(default_val) == 'undefined') {
				default_val = '';
			}
			// none_val defaults to 'none'
			if (typeof(none_val) == 'undefined') {
				none_val = 'none';
			}
			var val = root.get_value_from_input('#' + field_id, '');
			if (val.length > 0 && val != none_val) {
				return field_id + '="' + val + '"';
			} else {
				return default_val;
			}
		});
	}
	
	this.addNumberAttribute = function (field_id, default_val) {
		root.attributes.push(function () {
			
			// default_val defaults to 0
			if (typeof(default_val) == 'undefined') {
				default_val = '0';
			}
			var val = root.get_value_from_input('#' + field_id, default_val, 'int');
			if (val > 0) {
				return field_id + '="' + val + '"';
			} else {
				return default_val;
			}
		});
	}
	
	this.addCheckboxAttribute = function (field_id, default_val, allow_multiple_selections) {
		root.attributes.push(function () {
			
			// default_val defaults to 0
			if (typeof(default_val) == 'undefined') {
				default_val = '';
			}
			// default allow_multiple_selections to false
			if (typeof(allow_multiple_selections) == 'undefined') {
				allow_multiple_selections = false;
			}
			var selector = 'input[name=\'' + field_id + '\']:checked';
			
			var val = root.get_multiple_values_from_input(selector, default_val);
			if (val.length > 0) {
				return field_id + '="' + val.join(',') + '"';
			} else {
				return default_val;
			}
			
		});
	}
	
	this.addCustomAttribute = function (field_id, callback) {
		root.attributes.push(function () {
			return callback(field_id, root.values);
		});
	}
	
		this.combineAttributes = function() {
		var key;
		var res;
		var str = [];
		root.getFormValues();
		for (key in root.attributes) {
			res = root.attributes[key]();
			if (res && res.length) {
				str.push(res);
			}			
		}
		return str.join(' ');
	}

	
	this.log_attributes = function() {
		var key;
		var res;
		for (key in root.attributes) {
			res = root.attributes[key]();
			console.log(res);
		}
		//console.log(root.attributes);
	}

	this.sayHello = function() {
		console.log('wamp wamp');
	}

	// disables all inputs inside table rows that have the class "disabled"
	this.update_disabled_inputs = function()
	{
		form.find('tr.disabled input').attr('disabled', 'disabled');
	}

	// highlight the shortcode inside it's textbox
	this.highlight_shortcode = function()
	{
		jQuery('#shortcode').select();
	}
	
	// highlight the shortcode when the textbox gains focus
	this.enable_shortcode_highlighting = function()
	{
		jQuery('#shortcode').bind('click', function ()
		{
			root.highlight_shortcode();
		});
	}

	// retrives the value from the input specified by selector,
	// and optionally runs it through the filter function
	// note: this is a generic, reusable function
	this.get_value_from_input = function(selector, default_value, filter)
	{
		var trg = jQuery(selector);
		var val = '';

		if ( trg.is(':checkbox') ) {
			val = ( jQuery(selector).is(':checked') ? jQuery(selector).val() : '' );
		} else {
			val = jQuery(selector).val();
		}
		
		val = (val ? val : default_value);
		return root.apply_input_filter(val, filter, default_value);
		
	}
	
	/* Returns an array of values from the matches inputs. Returns empty array if none found. 
	 *
	 * Useful for getting values from checkboxes, radios, and selects that allow several values
	 */
	this.get_multiple_values_from_input = function(selector, default_value, filter)
	{
		// if no filter specified (not unlikely), just return the original value
		if (typeof(default_value) == 'undefined') {
			default_value = [];
		}
		
		var bag = $(selector);
		if (bag.length > 0) {
			return $(selector).map(function(_, el) {
				var val = $(el).val();
				return root.apply_input_filter(val, filter, default_value);
			}).get();
		}
		else {
			return default_value;
		}
	}
	
	this.apply_input_filter = function(val, filter, default_val)
	{
		// if no filter specified (not unlikely), just return the original value
		if (typeof(filter) == 'undefined') {
			return val;
		}
		
		if (filter == 'int') {
			var temp_val  = parseInt(val + '' , 10 );
			if (isNaN(temp_val)) {
				return default_val;
			} else {
				return temp_val;
			}
		}
		else if (filter == 'convert_to_milliseconds') {
			var temp_val  = parseInt(val + '' , 10 );
			if (isNaN(temp_val)) {
				return default_value;
			} else {
				return temp_val * 1000;
			}
		}
		else if (filter == 'yes_or_no_to_0_or_1') {
			if (val == 'yes') {
				return 1;
			} else if (val == 'no' || val == '') {
				return 0;			
			} else {
				return default_value;
			}
		}
		else {
			return val;
		}	
	}
	
	// converts a $key and its $value into text output, per our business rules
	this.add_attribute = function($key, $val, $orderby, $show_quick_links, $read_more_url)
	{
		if ($key == 'use_excerpt') {
			return ($val == 1) ? " use_excerpt='1'" : '';
		}
		else if ($key == 'show_thumbs') {
			return ($val == 1) ? " show_thumbs='1'" : '';
		}
		else if ($key == 'count') {
			return ($val > 1) ? " count='" + $val + "'" : '';
		}
		else if ($key == 'category') {
			return ($val != 'all') ? " category='" + $val + "'" : '';
		}
		else if ($key == 'orderby') {
			return ($val != '') ? " orderby='" + $val + "'" : '';
		}
		else if ($key == 'order') {
			if ($orderby !=='random' && $orderby !=='rand') {
				return " order='" + $val + "'";
			} else {
				return '';
			}
		}
		else if ($key == 'quick_links_cols') {
			if ($show_quick_links !== 0 ) {
				return " colcount='" + $val + "'";
			} else {
				return '';
			}
		}
		else if ($key == 'quick_links') {
			if ($show_quick_links !== 0 ) {
				return " quicklinks='" + $val + "'";
			} else {
				return '';
			}
		}
		else if ($key == 'read_more_url') {
			if ($read_more_url.length > 0) {
				return " read_more_link='" + $val + "'";
			} else {
				return '';
			}
		}
		else if ($key == 'read_more_text') {
			if ($read_more_url.length > 0) {
				return " read_more_link_text='" + $val + "'";
			} else {
				return '';
			}
		}
		else if ($key == 'accordion_style') {
			if ($val !== 'normal') {
				return " style='" + $val + "'";
			} else {
				return '';
			}
		}
		else {
			return " " + $key + "='" + $val + "'";
		}
	}

	// given our inputs, generate the shortcode
	// note: this function is almost entirely business logic, and thus not reusable
	this.buildShortcode = function()
	{
		// begin with shortcode
		var $str = '[' + root.shortcode + ' ';
		
		// next add each attribute according to the user supplied values
		var $attrs = root.combineAttributes();
		$str += $attrs;
		
		// close the shortcode
		if ($attrs.length > 0) {
			// has attributes, so make this a normal shortcode
			$str += ']';		
		}
		else {
			// no attributes, so make this a self-closing shortcode
			$str += ']';
		}
		
		// return the completed shortcode
		return $str;
		
	}
	
	// kick things off upon construction
	root.main();
	
	return root;	
} // end GoldPlugins_ShortcodeGenerator class