<?php

	function post_type_jobs() {
		$labels = array(
	    	'name' => _x('Instrumentos', 'post type general name', 'agrg'),
	    	'singular_name' => _x('Instrumentos', 'post type singular name', 'agrg'),
	    	'add_new' => _x('Crear nuevo instrumento', 'book', 'agrg'),
	    	'add_new_item' => __('Crear nuevo instrumento', 'agrg'),
	    	'edit_item' => __('Editar instrumento', 'agrg'),
	    	'new_item' => __('Nuevo instrumento', 'agrg'),
	    	'view_item' => __('Ver instrumento', 'agrg'),
	    	'search_items' => __('Buscar Instrumentos', 'agrg'),
	    	'not_found' =>  __('No se encontraron instrumentos', 'agrg'),
	    	'not_found_in_trash' => __('No hay instrumentos found en la papelera', 'agrg'), 
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