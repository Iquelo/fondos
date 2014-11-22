<?php

	function post_type_jobs() {
		$labels = array(
	    	'name' => _x('Jobs', 'post type general name', 'agrg'),
	    	'singular_name' => _x('Jobs', 'post type singular name', 'agrg'),
	    	'add_new' => _x('Add New Job', 'book', 'agrg'),
	    	'add_new_item' => __('Add New Job', 'agrg'),
	    	'edit_item' => __('Edit Job', 'agrg'),
	    	'new_item' => __('New Job', 'agrg'),
	    	'view_item' => __('View Job', 'agrg'),
	    	'search_items' => __('Search Jobs', 'agrg'),
	    	'not_found' =>  __('No Jobs found', 'agrg'),
	    	'not_found_in_trash' => __('No Jobs found in Trash', 'agrg'), 
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

		register_post_type( 'job', $args );						  
	} 
									  
	add_action('init', 'post_type_jobs');


?>