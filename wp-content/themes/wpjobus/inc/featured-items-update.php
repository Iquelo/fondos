<?php

function wpjobusSubmitFeaturedPost() {

  	if ( isset( $_POST['wpjobusSubmitFeaturedPost_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitFeaturedPost_nonce'], 'wpjobusSubmitFeaturedPost_html' ) ) {

  		$featPostId = $_POST['featPostId'];
  		$featPostStatus = $_POST['featPostStatus'];
  		$featPostValid = $_POST['featPostValid'];
  		$str = preg_replace('/\D/', '', $featPostValid);
  		$currentDate = current_time('timestamp');
  		$timestamp = strtotime('+'.$str.' days', $currentDate);

  		update_post_meta($featPostId, 'wpjobus_featured_post_status', $featPostStatus);

	  	update_post_meta($featPostId, 'wpjobus_featured_activation_date', $currentDate);
	  	update_post_meta($featPostId, 'wpjobus_featured_expiration_date', $timestamp);
	  	update_post_meta($featPostId, 'wpjobus_featured_active_time', $str);

  		$my_post = array(
  			'ID' => $featPostId,
  			'post_status' => 'publish'
  		);

  		wp_update_post( $my_post );

      wpjobusSendNotifications($featPostId);

  		$timeStampCleanDate = date( "m/d/Y", $timestamp);

  		echo '<span data-rel="tooltip" rel="top" title="'; _e( "Featured until", "agrg" ); echo ' '.$timeStampCleanDate.'" id="featured" class="make-featured"><i class="fa fa-star"></i></span>';

		$responseFeat = ob_get_contents();
		ob_end_clean();


	} else {

		$responseFeat = 0;

  	}

  	die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitFeaturedPost', 'wpjobusSubmitFeaturedPost' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitFeaturedPost', 'wpjobusSubmitFeaturedPost' );

