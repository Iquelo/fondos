<?php

function wpjobusSubmitPostStatus() {

  	if ( isset( $_POST['wpjobusSubmitPostStatus_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitPostStatus_nonce'], 'wpjobusSubmitPostStatus_html' ) ) {

  		$postId = $_POST['postId'];
  		$postStatus = $_POST['postStatus'];

        if($postStatus == 'publish') {

      		$my_post = array(
    			'ID' => $postId,
    			'post_status' => 'publish'
    		);

            wpjobusSendNotifications($post_id);

        } elseif($postStatus == 'unpublish') {

            $my_post = array(
                'ID' => $postId,
                'post_status' => 'draft'
            );

        }

        wp_update_post( $my_post );


	} else {

		$response = 0;

  	}

  	die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitPostStatus', 'wpjobusSubmitPostStatus' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitPostStatus', 'wpjobusSubmitPostStatus' );



function wpjobusSubmitPayedPostStatus() {

    if ( isset( $_POST['wpjobusSubmitPayedPostStatus_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitPayedPostStatus_nonce'], 'wpjobusSubmitPayedPostStatus_html' ) ) {

        $postId = $_POST['postId'];
        $postStatus = 'regular';

        update_post_meta($postId, 'wpjobus_featured_post_status', $postStatus);

        $my_post = array(
            'ID' => $postId,
            'post_status' => 'publish'
        );

        wp_update_post( $my_post );

        wpjobusSendNotifications($post_id);


    } else {

        $response = 0;

    }

    die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitPayedPostStatus', 'wpjobusSubmitPayedPostStatus' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitPayedPostStatus', 'wpjobusSubmitPayedPostStatus' );

