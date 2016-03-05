<?php
class WPSPKG
{
	var $secret = 'The bluejay is one the roof';
	var $keyPrefix = 'wp_social_pro_';	

	function __construct($config = array())	{
		if (is_array($config))
		{
			if (isset($config['secret'])) {
				$this->secret = $config['secret'];
			}
			if (isset($config['key_prefix'])) {
				$this->keyPrefix = $config['key_prefix'];
			}
		}
	}
	
	function computeKey($email)
	{
		$key = md5($this->secret . $email . $this->secret);
		$key2 = md5($this->secret . $email . $this->secret);
		$funbox = strlen($key . $key2);
		for($i = 1; $i < 2289; $i++) {
			$key2 = sha1(md5($key2 . $key . $funbox));
			$key = md5(sha1($key . $key2 . $funbox));
		}
		
		return $this->keyPrefix . md5($key);	
	}
}