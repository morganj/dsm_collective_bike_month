<?php

class IK_FB_Feed_Options
{
	var $options = array();
	var $defaults = array();
	var $cache = array();
	
	function __construct($options = array())
	{
		if (!empty($options)) {
			$this->load($options);
		}
	}
	
	function get_option($key, $default = '', $use_cache = true)
	{
		if ($use_cache && isset($this->cache[$key])) {
			return $this->cache[$key];
		}

		$key_no_prefix = str_replace('ik_fb_', '', $key);
		
		if (isset($this->options[$key])) {
			// value found, return it
			$v = $this->options[$key];
		} else if ( isset($this->options[$key_no_prefix]) ) {
			// un-prefixed value found, return it
			$v = $this->options[$key_no_prefix];
		} else if ( ($opt = get_option($key, FALSE)) !== FALSE ) {
			// wp option value found, return it
			$v = $opt;
		} else if ( ($opt = get_option('ik_fb_'. $key, FALSE)) !== FALSE ) {
			// wp option value found with ik_fb_ prefix, return it
			$v = $opt;
		} else if (isset($this->defaults[$key])) {
			// default value found, return it
			$v = $this->defaults[$key];
		} else {
			// return the local default
			$v = $default;
		}
		
		if ($use_cache && !empty($v)) {
			$this->cache[$key] = $v;
		}		
		
		return $v;
	}
	
	function set_option($key, $value, $use_cache = true)
	{
		$this->options[$key] = $value;
		if ($use_cache) {
			$this->cache[$key] = $value;
		}
	}
	
	function load($options, $use_cache = true)
	{
		foreach($options as $key => $val) {
			if ($val !== '') {
				$this->set_option($key, $val, $use_cache);
			}
		}
	}
	
	function flush_cache()
	{
		$this->cache = array();
	}
	
	function get_option_hash()
	{
		$v = array_merge($this->defaults, $this->options);
		return md5(serialize($v));
	}
}