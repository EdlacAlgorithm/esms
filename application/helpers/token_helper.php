<?php

if(!function_exists('csrf_token'))
{
	function csrf_token()
	{
		$ci =& get_instance();
		return $ci->security->get_csrf_hash();
	}
}