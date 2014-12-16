<?php

	function post_type_company() {
		$labels = array(
	    	'name' => _x('Instituciones', 'post type general name', 'agrg'),
	    	'singular_name' => _x('Instituciones', 'post type singular name', 'agrg'),
	    	'add_new' => _x('Añadir nueva institución', 'book', 'agrg'),
	    	'add_new_item' => __('Añadir nueva institución', 'agrg'),
	    	'edit_item' => __('Editar institución', 'agrg'),
	    	'new_item' => __('Nueva institución', 'agrg'),
	    	'view_item' => __('Ver institución', 'agrg'),
	    	'search_items' => __('Buscar Institucón', 'agrg'),
	    	'not_found' =>  __('No se encontraron instituciones', 'agrg'),
	    	'not_found_in_trash' => __('No hay instituciones en la papelera', 'agrg'), 
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