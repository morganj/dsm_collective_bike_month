<?php
if (!class_exists('GP_CacheBox')):

	class GP_CacheBox
	{
		var $hash = '';
		var $hash_key = '_ik_fb_feed_hash_key';
		
		function __construct($hash = '')
		{
			if (!empty($hash)) {
				$this->hash = $hash;
			}
		}
		
		function set_hash($hash) {
			if (is_object($hash) || is_array($hash)) {
				$hash = md5(serialize($hash));
			}
			$this->hash = $hash;
			$this->set_key($this->hash_key, $hash);
		}		
		
		function get_hash($hash) {
			return $this->hash;
		}
		
		function set_key($key, $val, $expiration = 0, $mixer = '') {
			$key = $this->generate_key($key, $mixer);
			$val = base64_encode(serialize($val));
			set_site_transient($key, $val, $expiration);
		}
		
		function get_key($key, $default = FALSE, $mixer = '')
		{
			$key = $this->generate_key($key, $mixer);
			$val = get_site_transient($key);
			if (!isset($val) || $val === FALSE) {
				return $default;
			} else {
				$val = unserialize(base64_decode($val));
				return $val;
			}
		}

		/* This function returns $key mixed with $mixer and trimmed to at most
		 * 40 chars. Required because WordPress transients keys must be <= 40 
		 * chars or caching will silently fail
		 * 
		 * @param	$key	(required) The starting cache key (a plain english name is fine)
		 * @param	$mixer	(optional) An extra string to mix into the key, to make invalidation easier
		 * 
		 * @return	string	The new key, pseudorandom (the first 30 chars of an md5 hash)
		 */
		function generate_key($key, $mixer = '') {
			$key_hash = md5($mixer . $key);
			return substr($key_hash, 0, 30);
		}		
		
	}
	
endif; // class_exists