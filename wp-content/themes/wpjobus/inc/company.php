<?php

	function post_type_company() {
		$labels = array(
	    	'name' => _x('Companies', 'post type general name', 'agrg'),
	    	'singular_name' => _x('Companies', 'post type singular name', 'agrg'),
	    	'add_new' => _x('Add New Company', 'book', 'agrg'),
	    	'add_new_item' => __('Add New Company', 'agrg'),
	    	'edit_item' => __('Edit Company', 'agrg'),
	    	'new_item' => __('New Company', 'agrg'),
	    	'view_item' => __('View Company', 'agrg'),
	    	'search_items' => __('Search Companies', 'agrg'),
	    	'not_found' =>  __('No Companies found', 'agrg'),
	    	'not_found_in_trash' => __('No Companies found in Trash', 'agrg'), 
	    	'parent_item_colon' => ''
		);		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
	    	'publicly_queryable' => true,
	    	'show_ui' => true, 
	    	'query_var' => true,
	    	'rewrite' => true,
	    	'capability_type' => 'post',
	    	'hierarchical' => false,
	    	'menu_position' => null,
	    	'supports' => array('thumbnail'),
	    	'menu_icon' => 'dashicons-menu'
		); 		

		register_post_type( 'company', $args );						  
	} 
									  
	add_action('init', 'post_type_company');


?>