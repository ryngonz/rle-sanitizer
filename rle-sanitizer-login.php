<?php
/*
Plugin Name: RLE Sanitizer Login
Plugin URI: http://www.mojobitz.com
Description: Enables your email address to be your username. It usually sanitizes your username removing all of the unsafe characters and lets you login using your email address.
Version: 1.0
Author: Ryan Gonzales
Author URI: http://www.mojobitz.com.com/
License:GPL-2.0+
License URI:http://www.gnu.org/licenses/gpl-2.0.txt
*/

function rle_sanitizer ($username, $raw_username, $strict)
{
	$username = wp_strip_all_tags ($raw_username);
	$username = remove_accents ($username);
	$username = preg_replace ('/&.+?;/', '', $username);
	$username = preg_replace ('|[^a-z0-9 _.\-@]|iu', '', $username);
	$username = trim ($username);
	$username = preg_replace ('|\s+|', '', $username);
	return $username;
}

function login_with_your_email($username) {
	$user = get_user_by_email($username);
	if(!empty($user->user_login)){
		$username = $user->user_login;
	}
	return $username;
}

add_action('wp_authenticate','login_with_your_email');
add_filter ('sanitize_user', 'rle_sanitizer', 10, 3);