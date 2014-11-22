<?php

	function post_type_menus() {
		$labels = array(
	    	'name' => _x('Resumes', 'post type general name', 'agrg'),
	    	'singular_name' => _x('Resumes', 'post type singular name', 'agrg'),
	    	'add_new' => _x('Add New Resume', 'book', 'agrg'),
	    	'add_new_item' => __('Add New Resume', 'agrg'),
	    	'edit_item' => __('Edit Resume', 'agrg'),
	    	'new_item' => __('New Resume', 'agrg'),
	    	'view_item' => __('View Resume', 'agrg'),
	    	'search_items' => __('Search Resumes', 'agrg'),
	    	'not_found' =>  __('No Resumes found', 'agrg'),
	    	'not_found_in_trash' => __('No Resumes found in Trash', 'agrg'), 
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

		register_post_type( 'resume', $args );						  
	} 
									  
	add_action('init', 'post_type_menus');


?>