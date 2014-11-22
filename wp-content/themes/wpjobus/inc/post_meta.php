<?php

	// Post Type Options
	add_action( 'add_meta_boxes', 'post_category_type' );
	function post_category_type() {
	    add_meta_box( 
	        'post_category_type',
	        __( 'Post type', 'myplugin_textdomain' ),
	        'post_type_content',
	        'post',
	        'side',
	        'high'
	    );
	}

	function post_type_content( $post ) {

		$post_category_type = get_post_meta( $post->ID, 'post_category_type', true );

		echo '<label for="post_category_type"></label>';
		echo '<select name="post_category_type" id="post_category_type" style="width: 260px;"><option value="For Sale"';
		echo selected( $post_category_type, "For Sale" );
		echo '>For Sale</option><option value="For Rent"';
		echo selected( $post_category_type, "For Rent" );
		echo '>For Rent</option><option value="Want to Buy"';
		echo selected( $post_category_type, "Want to Buy" );
		echo '>Want to Buy</option><option value="Want to Rent"';
		echo selected( $post_category_type, "Want to Rent" );
		echo '>Want to Rent</option></select>';
		
	}

	add_action( 'save_post', 'post_type_save' );
	function post_type_save( $post_id ) {		

		global $post_category_type;

		if(isset($_POST["post_category_type"]))
		$post_category_type = $_POST['post_category_type'];
		update_post_meta( $post_id, 'post_category_type', $post_category_type );

	}


	// Post price box
	add_action( 'add_meta_boxes', 'post_price' );
	function post_price() {
	    add_meta_box( 
	        'post_price',
	        __( 'Price', 'myplugin_textdomain' ),
	        'post_price_content',
	        'post',
	        'side',
	        'high'
	    );
	}

	function post_price_content( $post ) {

		$post_price = get_post_meta( $post->ID, 'post_price', true );

		echo '<label for="post_price"></label>';
		echo '<input type="text" id="post_price" name="post_price" placeholder="Enter price here" value="';
		echo $post_price; 
		echo '">';
		
	}

	add_action( 'save_post', 'post_price_save' );
	function post_price_save( $post_id ) {		

		global $post_price;

		if(isset($_POST["post_price"]))
		$post_price = $_POST['post_price'];
		update_post_meta( $post_id, 'post_price', $post_price );

	}

	// Post location box
	add_action( 'add_meta_boxes', 'post_location' );
	function post_location() {
	    add_meta_box( 
	        'post_location',
	        __( 'Lcation', 'myplugin_textdomain' ),
	        'post_location_content',
	        'post',
	        'side',
	        'high'
	    );
	}

	function post_location_content( $post ) {

		$post_location = get_post_meta( $post->ID, 'post_location', true );

		echo '<label for="post_location"></label>';
		echo '<input type="text" id="post_location" name="post_location" placeholder="Enter location here" value="';
		echo $post_location; 
		echo '">';
		
	}

	add_action( 'save_post', 'post_location_save' );
	function post_location_save( $post_id ) {		

		global $post_location;

		if(isset($_POST["post_location"]))
		$post_location = $_POST['post_location'];
		update_post_meta( $post_id, 'post_location', $post_location );

	}

?>
