<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function print_pre() {
	for($i=0,$sum=0;$i<func_num_args();$i++) {
		echo '<pre>';
		print_r(func_get_arg($i));
		echo '</pre>';
	}
}
/**
* Tries to get the real user ip
**/
function owc_get_real_ip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){  //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}

// Adds a "first-paragraph" class to the first <p> of a html string 
function add_first_paragraph_class($content){
	return preg_replace('/<p([^>]+)?>/', '<p$1 class="first-paragraph">', $content, 1);
}
?>