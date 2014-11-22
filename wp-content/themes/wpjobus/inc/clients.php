<?php

	// Clients
	add_action('init', 'create_brand');
	function create_brand() {
    	$brandArgs = array(
        	'label' => __('Clients', 'agrg'),
        	'singular_label' => __('Image', 'agrg'),
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => true,
        	'supports' => array('title', 'editor', 'thumbnail'),
			'menu_icon' => 'dashicons-menu'
        );
    	register_post_type('spns',$brandArgs);
	}
	
	
	add_action("admin_init", "add_brand");
	add_action('save_post', 'update_brand_url');
	function add_brand(){
		add_meta_box("brand_details", "Clients Options", "brand_options", "spns", "normal", "low");
	}
	function brand_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$brandUrl = $custom["brandUrl"][0];
?>		

	<div id="slide-options">
	<label>URL:</label><input name="brandUrl" value="<?php echo $brandUrl; ?>" />		
	</div><!--end slide-options-->
	
<?php		
		}
	function update_brand_url(){
		global $post;
		if(isset($_POST["brandUrl"]))
		update_post_meta($post->ID, "brandUrl", $_POST["brandUrl"]);
	}	

?>