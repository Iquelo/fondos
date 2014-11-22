<?php

function wpjobusSubmitReviewStat() {

  	if ( isset( $_POST['wpjobusSubmitReviewStat_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitReviewStat_nonce'], 'wpjobusSubmitReviewStat_html' ) ) {

  		$review_post_status = $_POST['review_post_status'];
  		$id = $_POST['review_post_current_id'];

  		if($review_post_status == "reject") { 

  			global $redux_demo; 
			$contact_email = $redux_demo['contact-email'];
  			$email = $contact_email;
  			$blog_title = get_bloginfo('name');

  			$post_type_id = get_post_type($id);

  			if($post_type_id == "job") {
  				$message = $redux_demo['job-reject-message'];
  			} elseif($post_type_id == "company") {
  				$message = $redux_demo['company-reject-message'];
  			} elseif($post_type_id == "resume") {
  				$message = $redux_demo['resume-reject-message'];
  			}

			$emailTo = get_post_meta($id, 'wpjobus_'.$post_type_id.'_email',true);
			$subject = "Message from ".$blog_title; 
			$body = $message;
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			  
			wp_mail($emailTo, $subject, $body, $headers);

			wp_delete_post( $id, true );

			echo $response = $id;

			$response = ob_get_contents();
			ob_end_clean();

		} elseif($review_post_status == "approve") {

		  	global $redux_demo; 
			$contact_email = $redux_demo['contact-email'];
  			$email = $contact_email;
  			$blog_title = get_bloginfo('name');

  			$post_type_id = get_post_type($id);

  			if($post_type_id == "job") {

  				$message = $redux_demo['job-approve-message'];

  				$comp_reg_price = $redux_demo['job-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($id, 'wpjobus_featured_post_status',true));


  			} elseif($post_type_id == "company") {

  				$message = $redux_demo['company-approve-message'];

  				$comp_reg_price = $redux_demo['company-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($id, 'wpjobus_featured_post_status',true));

  			} elseif($post_type_id == "resume") {

  				$message = $redux_demo['resume-approve-message'];

  				$comp_reg_price = $redux_demo['resume-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($id, 'wpjobus_featured_post_status',true));

  			}


			if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				$my_post = array(
				  	'ID' => $id,
				  	'post_status' => 'publish'
			  	);

			  	wpjobusSendNotifications($id);

			} else {

				$my_post = array(
				  	'ID' => $id,
				  	'post_status' => 'draft'
			  	);

			}

		  	wp_update_post( $my_post );



			$emailTo = get_post_meta($id, 'wpjobus_'.$post_type_id.'_email',true);
			$subject = "Message from ".$blog_title; 
			$body = $message."\n\n".home_url()."/".$post_type_id."/".$id."";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			  
			wp_mail($emailTo, $subject, $body, $headers);

			echo $response = $id;

			$response = ob_get_contents();
			ob_end_clean();

		}


	} else {

		$response = 0;

  	}

  	die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitReviewStat', 'wpjobusSubmitReviewStat' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitReviewStat', 'wpjobusSubmitReviewStat' );

