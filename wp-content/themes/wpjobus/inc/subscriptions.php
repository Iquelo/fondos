<?php

function wpjobusSendNotifications($post_id) {

  	$post_type_id = get_post_type($post_id);

    if($post_type_id == "job") {

        $item_location = get_post_meta($post_id, 'job_location',true);
        $item_industry = get_post_meta($post_id, 'job_industry',true);

        $authors = get_users();

        // Check for results
        if (!empty($authors)) {

            // loop trough each author
            foreach ($authors as $author) {

                $user_id = $author->ID;
                $user_email = $author->user_email;

                $user_job_categories = get_user_meta( $user_id, 'user_job_categories_subcriptions' );
                $user_job_locations = get_user_meta( $user_id, 'user_job_locations_subcriptions' );

                if(!empty($user_job_locations)) { 
                    if (in_array($item_location, $user_job_locations[0])) {
                        $location = 1;
                    }
                }

                if(!empty($user_job_categories)) { 
                    if (in_array($item_industry, $user_job_categories[0])) {
                        $category = 1;
                    }
                }

                if($location == 1 AND $category == 1) {

                    // send email code here
                    global $redux_demo; 
                    $contact_email = $redux_demo['contact-email'];
                    $email = $contact_email;
                    $blog_title = get_bloginfo('name');
                    $link = home_url()."/job/".$post_id;

                    $emailTo = $user_email;
                    $subject = "Job Notification from ".$blog_title; 
                    $body = "A new job has been added in '".$item_industry."' category in ".$item_location.". Link: ".$link." ";
                    $headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
                      
                    wp_mail($emailTo, $subject, $body, $headers);

                }

            }

        }

    } elseif($post_type_id == "company") {

        $item_location = get_post_meta($post_id, 'company_location',true);
        $item_industry = get_post_meta($post_id, 'company_industry',true);

        $authors = get_users();

        // Check for results
        if (!empty($authors)) {

            // loop trough each author
            foreach ($authors as $author) {

                $user_id = $author->ID;
                $user_email = $author->user_email;

                $user_job_categories = get_user_meta( $user_id, 'user_company_categories_subcriptions' );
                $user_job_locations = get_user_meta( $user_id, 'user_company_locations_subcriptions' );

                if(!empty($user_job_locations)) { 
                    if (in_array($item_location, $user_job_locations[0])) {
                        $location = 1;
                    }
                }

                if(!empty($user_job_categories)) { 
                    if (in_array($item_industry, $user_job_categories[0])) {
                        $category = 1;
                    }
                }

                if($location == 1 AND $category == 1) {

                    // send email code here
                    global $redux_demo; 
                    $contact_email = $redux_demo['contact-email'];
                    $email = $contact_email;
                    $blog_title = get_bloginfo('name');
                    $link = home_url()."/company/".$post_id;

                    $emailTo = $user_email;
                    $subject = "Company Notification from ".$blog_title; 
                    $body = "A new company has been added in '".$item_industry."' category in ".$item_location.". Link: ".$link." ";
                    $headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
                      
                    wp_mail($emailTo, $subject, $body, $headers);

                }

            }

        }

    } elseif($post_type_id == "resume") {

        $item_location = get_post_meta($post_id, 'resume_location',true);
        $item_industry = get_post_meta($post_id, 'resume_industry',true);

        $authors = get_users();

        // Check for results
        if (!empty($authors)) {

            // loop trough each author
            foreach ($authors as $author) {

                $user_id = $author->ID;
                $user_email = $author->user_email;

                $user_job_categories = get_user_meta( $user_id, 'user_resume_categories_subcriptions' );
                $user_job_locations = get_user_meta( $user_id, 'user_resume_locations_subcriptions' );

                if(!empty($user_job_locations)) { 
                    if (in_array($item_location, $user_job_locations[0])) {
                        $location = 1;
                    }
                }

                if(!empty($user_job_categories)) { 
                    if (in_array($item_industry, $user_job_categories[0])) {
                        $category = 1;
                    }
                }

                if($location == 1 AND $category == 1) {

                    // send email code here
                    global $redux_demo; 
                    $contact_email = $redux_demo['contact-email'];
                    $email = $contact_email;
                    $blog_title = get_bloginfo('name');
                    $link = home_url()."/resume/".$post_id;

                    $emailTo = $user_email;
                    $subject = "Resume Notification from ".$blog_title; 
                    $body = "A new resume has been added in '".$item_industry."' category in ".$item_location.". Link: ".$link." ";
                    $headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
                      
                    wp_mail($emailTo, $subject, $body, $headers);

                }

            }

        }

    }

}