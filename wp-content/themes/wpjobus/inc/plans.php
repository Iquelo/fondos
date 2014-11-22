<?php

	// Pricing Plans
	add_action('init', 'create_plan');
	function create_plan() {
    	$brandArgs = array(
        	'label' => __('Pricing Plans', 'agrg'),
        	'singular_label' => __('Image', 'agrg'),
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => true,
        	'supports' => array('title', 'editor', 'thumbnail'),
			'menu_icon' => 'dashicons-menu'
        );
    	register_post_type('priceplans',$brandArgs);
	}
	
	
	add_action("admin_init", "add_plan");
	add_action('save_post', 'update_plan_price');
	function add_plan(){
		add_meta_box("brand_details", "Plan Options", "plan_options", "priceplans", "normal", "low");
	}
	function plan_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$planPrice = $custom["planPrice"][0];
		$planURL = $custom["planURL"][0];
		$planURLName = $custom["planURLName"][0];
?>		

	<div id="slide-options">
		<div class="full" style="margin-bottom: 10px;">
			<label style="width: 100px; float: left;">Price:</label><input name="planPrice" value="<?php echo $planPrice; ?>" />
		</div>
		<div class="full" style="margin-bottom: 10px;">
			<label style="width: 100px; float: left;">Plan URL:</label><input name="planURL" value="<?php echo $planURL; ?>" />
		</div>
		<div class="full">
			<label style="width: 100px; float: left;">Plan Link Text:</label><input name="planURLName" value="<?php echo $planURLName; ?>" />
		</div>		
	</div><!--end slide-options-->
	
<?php		
		}
	function update_plan_price(){
		global $post;
		if(isset($_POST["planPrice"]))
		update_post_meta($post->ID, "planPrice", $_POST["planPrice"]);
		if(isset($_POST["planURL"]))
		update_post_meta($post->ID, "planURL", $_POST["planURL"]);
		if(isset($_POST["planURLName"]))
		update_post_meta($post->ID, "planURLName", $_POST["planURLName"]);
	}	

?>