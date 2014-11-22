<?php
/*
Plugin Name: I Like This
Plugin URI: http://www.my-tapestry.com/i-like-this/
Description: This plugin allows your visitors to simply like your posts instead of commment it.
Version: 1.7.1
Author: Benoit "LeBen" Burgener
Author URI: http://benoitburgener.com

Copyright 2009  BENOIT LEBEN BURGENER  (email : CONTACT@BENOITBURGENER.COM)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/


#### INSTALL PROCESS ####
$ilt_dbVersion = "1.0";

function setOptionsILT() {
	global $wpdb;
	global $ilt_dbVersion;
	
	$table_name = $wpdb->prefix . "ilikethis_votes";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . " (
			id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
			time TIMESTAMP NOT NULL,
			post_id BIGINT(20) NOT NULL,
			ip VARCHAR(15) NOT NULL,
			UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option("ilt_dbVersion", $ilt_dbVersion);
	}
	
	add_option('ilt_jquery', '1', '', 'yes');
	add_option('ilt_onPage', '1', '', 'yes');
	add_option('ilt_textOrImage', 'image', '', 'yes');
	add_option('ilt_text', 'I like This', '', 'yes');
}

register_activation_hook(__FILE__, 'setOptionsILT');

function unsetOptionsILT() {
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."ilikethis_votes");

	delete_option('ilt_jquery');
	delete_option('ilt_onPage');
	delete_option('ilt_textOrImage');
	delete_option('ilt_text');
	delete_option('most_liked_posts');
	delete_option('ilt_dbVersion');
}

register_uninstall_hook(__FILE__, 'unsetOptionsILT');
####


#### FRONT-END VIEW ####
function getILikeThis($arg) {
	global $wpdb;
	$post_ID = get_the_ID();
	$ip = $_SERVER['REMOTE_ADDR'];
	
    $liked = get_post_meta($post_ID, '_liked', true) != '' ? get_post_meta($post_ID, '_liked', true) : '0';
	$voteStatusByIp = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."ilikethis_votes WHERE post_id = '$post_ID' AND ip = '$ip'");
		
    if (!isset($_COOKIE['liked-'.$post_ID]) && $voteStatusByIp == 0) {
    	
    	$counter = '<a onclick="likeThis('.$post_ID.');"><i class="fa fa-heart"></i></a> <span class="likes-count">'.$liked.'</span> Likes';
    }
    else {
    	$counter = '<i class="fa fa-heart"></i> <span class="likes-count">'.$liked.'</span> Likes';
    }
    
    $iLikeThis = '<span id="iLikeThis-'.$post_ID.'" class="iLikeThis gallery-sets-likes">'.$counter.'</span>';
    
    if ($arg == 'put') {
	    return $iLikeThis;
    }
    else {
    	echo $iLikeThis;
    }
}

#### FRONT-END VIEW ####
function getILikeThisCount($arg) {
	global $wpdb;
	$post_ID = get_the_ID();
	$ip = $_SERVER['REMOTE_ADDR'];
	
    $liked = get_post_meta($post_ID, '_liked', true) != '' ? get_post_meta($post_ID, '_liked', true) : '0';
	$voteStatusByIp = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."ilikethis_votes WHERE post_id = '$post_ID' AND ip = '$ip'");
    
    $iLikeThisCount = $liked;
    
   
    echo $iLikeThisCount;

}

?>