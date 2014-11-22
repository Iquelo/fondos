<?php
/**
 * Template name: Register Page
 */

if ( is_user_logged_in() ) { 

	$profile = home_url()."/my-account";
	wp_redirect( $profile ); exit;

} 

$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<section id="blog">

		<div class="container">

			<div class="resume-skills">

				<h1 class="resume-section-title"><i class="fa fa-check"></i><?php _e( 'Register an Account', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'You’ll be able to post your resume, apply for a job, add companies profiles and post job offers!', 'agrg' ); ?></h3>

				<div class="divider"></div>

				<div class="full">

					<?php 					
						if(get_option('users_can_register')) { //Check whether user registration is enabled by the administrator
					?>

					<div class="one_half first">

						<form id="wpjobus-register" type="post" action="" >  
						  	
						  	<span class="one_half first">
								<h3><?php _e( 'Username:', 'agrg' ); ?></h3>
							</span>

							<span class="one_half">
								<input type="text" name="userName" id="userName" value="" class="input-textarea" placeholder="" />
								<label for="userName" class="error userNameError"></label>
							</span>

							<span class="one_half first">
								<h3><?php _e( 'Email:', 'agrg' ); ?></h3>
							</span>

							<span class="one_half">
								<input type="text" name="userEmail" id="userEmail" value="" class="input-textarea" placeholder="" />
								<label for="userEmail" class="error userEmailError"></label>
							</span>

							<span class="one_half first">
								<h3><?php _e( 'Password:', 'agrg' ); ?></h3>
							</span>

							<span class="one_half">
								<input type="password" name="userPassword" id="userPassword" value="" class="input-textarea" placeholder="" />
							</span>

							<span class="one_half first">
								<h3><?php _e( 'Repeat Password:', 'agrg' ); ?></h3>
							</span>

							<span class="one_half">
								<input type="password" name="userConfirmPassword" id="userConfirmPassword" value="" class="input-textarea" placeholder="" />
							</span>
							 
							
							<input type="hidden" name="action" value="wpjobusRegisterForm" />
							<?php wp_nonce_field( 'wpjobusRegister_html', 'wpjobusRegister_nonce' ); ?>

							<input style="margin-bottom: 0;" name="submit" type="submit" value="<?php _e( 'Register', 'agrg' ); ?>" class="input-submit">	 

							<span class="submit-loading"><i class="fa fa-refresh fa-spin"></i></span>
						  	  
						</form>

						<div id="success">
							<span>
							   	<h3><?php _e( 'Registration successful.', 'agrg' ); ?></h3>
							</span>
						</div>
							 
						<div id="error">
							<span>
							   	<h3><?php _e( 'Something went wrong, try refreshing and submitting the form again.', 'agrg' ); ?></h3>
							</span>
						</div>

						<script type="text/javascript">

						jQuery(function($) {
							jQuery('#wpjobus-register').validate({
						        rules: {
						            userName: {
						                required: true,
						                minlength: 3
						            },
						            userEmail: {
						                required: true,
						                email: true
						            },
						            userPassword: {
						                required: true,
						                minlength: 6,
						            },
						            userConfirmPassword: {
						                required: true,
						                minlength: 6,
						                equalTo: "#userPassword"
						            }
						        },
						        messages: {
							        userName: {
							            required: "<?php _e( 'Please provide a username', 'agrg' ); ?>",
							            minlength: "<?php _e( 'Your username must be at least 3 characters long', 'agrg' ); ?>"
							        },
							        userEmail: {
							            required: "<?php _e( 'Please provide an email address', 'agrg' ); ?>",
							            email: "<?php _e( 'Please enter a valid email address', 'agrg' ); ?>"
							        },
							        userPassword: {
							            required: "<?php _e( 'Please provide a password', 'agrg' ); ?>",
							            minlength: "<?php _e( 'Your password must be at least 6 characters long', 'agrg' ); ?>"
							        },
							        userConfirmPassword: {
							            required: "<?php _e( 'Please provide a password', 'agrg' ); ?>",
							            minlength: "<?php _e( 'Your password must be at least 6 characters long', 'agrg' ); ?>",
							            equalTo: "<?php _e( 'Please enter the same password as above', 'agrg' ); ?>"
							        }
							    },
						        submitHandler: function(form) {
						        	jQuery('#wpjobus-register .input-submit').css('display','none');
						        	jQuery('#wpjobus-register .submit-loading').css('display','block');
						            jQuery(form).ajaxSubmit({
						            	type: "POST",
								        data: jQuery(form).serialize(),
								        url: '<?php echo admin_url('admin-ajax.php'); ?>', 
						                success: function(data) {
						                	if(data == 1) {
						                		jQuery("#userName").addClass("error");
						                		jQuery(".userNameError").text("<?php _e( 'Username exists. Please try another one.', 'agrg' ); ?>");
						                		jQuery('.userNameError').css('display','block');

						                		jQuery('#wpjobus-register .input-submit').css('display','block');
						        				jQuery('#wpjobus-register .submit-loading').css('display','none');
						                	}

						                	if(data == 2) {
						                		jQuery("#userEmail").addClass("error");
						                		jQuery(".userEmailError").text("<?php _e( 'Email exists. Please try another one.', 'agrg' ); ?>");
						                		jQuery('.userEmailError').css('display','block');

						                		jQuery('#wpjobus-register .input-submit').css('display','block');
						        				jQuery('#wpjobus-register .submit-loading').css('display','none');
						                	}

						                	if(data == 3) {
						                		jQuery("#userName").addClass("error");
						                		jQuery(".userNameError").text("<?php _e( 'Username exists. Please try another one.', 'agrg' ); ?>");
						                		jQuery('.userNameError').css('display','block');

						                		jQuery("#userEmail").addClass("error");
						                		jQuery(".userEmailError").text("<?php _e( 'Email exists. Please try another one.', 'agrg' ); ?>");
						                		jQuery('.userEmailError').css('display','block');

						                		jQuery('#wpjobus-register .input-submit').css('display','block');
						        				jQuery('#wpjobus-register .submit-loading').css('display','none');
						                	}

						                	if(data == 4) {
						                		jQuery('#wpjobus-register :input').attr('disabled', 'disabled');
							                    jQuery('#wpjobus-register').fadeTo( "slow", 0, function() {
							                    	jQuery('#wpjobus-register').css('display','none');
							                        jQuery(this).find(':input').attr('disabled', 'disabled');
							                        jQuery(this).find('label').css('cursor','default');
							                        jQuery('#success').fadeIn();

							                        <?php $profile = home_url()."/my-account"; ?>
      												var delay = 1000;
      												setTimeout(function(){ window.location = '<?php echo $profile; ?>';}, delay); 
							                    });
						                	}

						                	if(data == 5) {
						                		jQuery('#wpjobus-register').fadeTo( "slow", 0, function() {
							                        jQuery('#error').fadeIn();
							                    });
						                	}
						                },
						                error: function(data) {
						                    jQuery('#wpjobus-register').fadeTo( "slow", 0, function() {
						                        jQuery('#error').fadeIn();
						                    });
						                }
						            });
						        }
						    });
						});
						</script>

					</div>

					<div class="one_half social-links">

						<h3 style="margin-top: 0;"><?php _e( 'Social account register', 'agrg' ); ?></h3>

						<?php
						/**
						 * Detect plugin. For use on Front End only.
						 */
						include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

						// check for plugin using plugin name
						if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) {
						  //plugin is activated
						
						?>

						<a class="register-social-button-facebook" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"><i class="fa fa-facebook-square"></i> Facebook</a>

						<?php } ?>

						<?php
						/**
						 * Detect plugin. For use on Front End only.
						 */
						include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

						// check for plugin using plugin name
						if ( is_plugin_active( "nextend-twitter-connect/nextend-twitter-connect.php" ) ) {
						  //plugin is activated
						
						?>
						
						<a class="register-social-button-twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1&redirect='+window.location.href; return false;"><i class="fa fa-twitter-square"></i> Twitter</a>

						<?php } ?>

						<?php
						/**
						 * Detect plugin. For use on Front End only.
						 */
						include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

						// check for plugin using plugin name
						if ( is_plugin_active( "nextend-google-connect/nextend-google-connect.php" ) ) {
						  //plugin is activated
						
						?>

						<a class="register-social-button-google" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;"><i class="fa fa-google-plus-square"></i> Google</a>

						<?php } ?>

					</div>

					<?php }
						
						else echo "<span class='registration-closed'>Registration is currently disabled. Please try again later.</span>";

					?>

				</div>

			</div>

		</div>

	</section>

<?php get_footer(); ?>