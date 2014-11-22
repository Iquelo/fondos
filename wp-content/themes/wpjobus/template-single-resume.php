<?php
/**
 * Resume Page
 */

global $redux_demo; 
$access_state = $redux_demo['access-state'];

if ( !is_user_logged_in() && $access_state == 1) {

	$login = home_url()."/login?info=accesspage";
	wp_redirect( $login ); exit;

}

$this_post_id = $post->ID;

if(empty($this_post_id)) {

	$page = get_page($post->ID);
	$this_post_id = $page->ID;

} 

$wpjobus_resume_cover_image = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_cover_image',true));
$wpjobus_resume_fullname = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_fullname',true));
$resume_industry = esc_attr(get_post_meta($this_post_id, 'resume_industry',true));
$resume_about_me = html_entity_decode(get_post_meta($this_post_id, 'resume-about-me',true));
$resume_years_of_exp = esc_attr(get_post_meta($this_post_id, 'resume_years_of_exp',true));
$wpjobus_resume_profile_picture = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_profile_picture',true));

$wpjobus_resume_prof_title = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_prof_title',true));
$resume_career_level = esc_attr(get_post_meta($this_post_id, 'resume_career_level',true));

$wpjobus_resume_comm_level = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_comm_level',true));
$wpjobus_resume_comm_note = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_comm_note',true));

$wpjobus_resume_org_level = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_org_level',true));
$wpjobus_resume_org_note = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_org_note',true));

$wpjobus_resume_job_rel_level = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_job_rel_level',true));
$wpjobus_resume_job_rel_note = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_job_rel_note',true));

$wpjobus_resume_skills = get_post_meta($this_post_id, 'wpjobus_resume_skills',true);
$wpjobus_resume_native_language = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_native_language',true));
$wpjobus_resume_languages = get_post_meta($this_post_id, 'wpjobus_resume_languages',true);

$wpjobus_resume_hobbies = esc_attr(get_post_meta($this_post_id, 'wpjobus_resume_hobbies',true));

$wpjobus_resume_education = get_post_meta($this_post_id, 'wpjobus_resume_education',true);
$wpjobus_resume_award = get_post_meta($this_post_id, 'wpjobus_resume_award',true);
$wpjobus_resume_work = get_post_meta($this_post_id, 'wpjobus_resume_work',true);
$wpjobus_resume_testimonials = get_post_meta($this_post_id, 'wpjobus_resume_testimonials',true);

$wpjobus_resume_file = get_post_meta($this_post_id, 'wpjobus_resume_file',true);

$wpjobus_resume_remuneration = get_post_meta($this_post_id, 'wpjobus_resume_remuneration',true);
$wpjobus_resume_remuneration_per = get_post_meta($this_post_id, 'wpjobus_resume_remuneration_per',true);

$wpjobus_resume_job_type = get_post_meta($this_post_id, 'wpjobus_resume_job_type',true);

$wpjobus_resume_job_freelance = get_post_meta($this_post_id, 'wpjobus_resume_job_freelance',true);
$wpjobus_resume_job_part_time = get_post_meta($this_post_id, 'wpjobus_resume_job_part_time',true);
$wpjobus_resume_job_full_time = get_post_meta($this_post_id, 'wpjobus_resume_job_full_time',true);
$wpjobus_resume_job_internship = get_post_meta($this_post_id, 'wpjobus_resume_job_internship',true);
$wpjobus_resume_job_volunteer = get_post_meta($this_post_id, 'wpjobus_resume_job_volunteer',true);

$wpjobus_resume_portfolio = get_post_meta($this_post_id, 'wpjobus_resume_portfolio',true);


$wpjobus_resume_address = get_post_meta($this_post_id, 'wpjobus_resume_address',true);
$wpjobus_resume_phone = get_post_meta($this_post_id, 'wpjobus_resume_phone',true);
$wpjobus_resume_website = get_post_meta($this_post_id, 'wpjobus_resume_website',true);
$wpjobus_resume_email = get_post_meta($this_post_id, 'wpjobus_resume_email',true);
$wpjobus_resume_publish_email = get_post_meta($this_post_id, 'wpjobus_resume_publish_email',true);
$wpjobus_resume_facebook = get_post_meta($this_post_id, 'wpjobus_resume_facebook',true);
$wpjobus_resume_linkedin = get_post_meta($this_post_id, 'wpjobus_resume_linkedin',true);
$wpjobus_resume_twitter = get_post_meta($this_post_id, 'wpjobus_resume_twitter',true);
$wpjobus_resume_googleplus = get_post_meta($this_post_id, 'wpjobus_resume_googleplus',true);

$wpjobus_resume_googleaddress = get_post_meta($this_post_id, 'wpjobus_resume_googleaddress',true);
$wpjobus_resume_longitude = get_post_meta($this_post_id, 'wpjobus_resume_longitude',true);
$wpjobus_resume_latitude = get_post_meta($this_post_id, 'wpjobus_resume_latitude',true);

get_header(); 

global $redux_demo;
$contact_email = get_post_meta($this_post_id, 'wpjobus_resume_email',true);
$wpcrown_contact_email_error = $redux_demo['contact-email-error'];
$wpcrown_contact_name_error = $redux_demo['contact-name-error'];
$wpcrown_contact_message_error = $redux_demo['contact-message-error'];
$wpcrown_contact_thankyou = $redux_demo['contact-thankyou-message'];
$wpcrown_contact_test_error = $redux_demo['contact-test-error'];

?>

	<section id="resume-cover-image">

		<?php 
			if (current_user_can('administrator')) {
		?>

		<div class="admin-settings-header">

			<div class="admin-settings-header-top">

				<div class="container">

					<div class="one_fifth first">

						<span><?php _e( 'Status:', 'agrg' ); ?> <?php echo get_post_status($result_company[$this_post_id]); ?></span>

					</div>

					<div class="one_fifth">

						<span><?php _e( 'Type:', 'agrg' ); ?> <?php $wpjobus_post_reg_status = esc_attr(get_post_meta($this_post_id, 'wpjobus_featured_post_status',true)); echo $wpjobus_post_reg_status; ?></span>

					</div>

					<div class="one_fifth">

						<span><?php _e( 'Submitted on:', 'agrg' ); ?> <?php echo get_the_time('d/m/Y', $this_post_id); ?></span>

					</div>

					<div class="one_fifth">

						<?php if($wpjobus_post_reg_status == "featured") { ?>

						<span><?php _e( 'Expires on:', 'agrg' ); ?> <?php $wpjobus_post_exp = esc_attr(get_post_meta($this_post_id, 'wpjobus_featured_expiration_date',true)); if(!empty($wpjobus_post_exp)) { echo $time = date("m/d/Y", $wpjobus_post_exp); } ?></span>

						<?php } ?>

					</div>

					<div class="one_fifth">

						<?php

							$author_id = $wpdb->get_results( "SELECT DISTINCT post_author FROM `{$wpdb->prefix}posts` WHERE post_type = 'resume' and ID = '".$this_post_id."' ORDER BY `ID` DESC");

							foreach ($author_id as $key => $value) {
							    
							    $result_author = $value->post_author;

							}

						?>

						<span style="float: right;"><?php _e( 'Username:', 'agrg' ); ?> <?php $user_info = get_userdata($result_author); echo $user_info->user_login; ?></span>

					</div>

				</div>

			</div>

			<div class="admin-settings-header-content">

				<div class="container">

					<div class="one_fourth first" style="margin-bottom: 0;">

						<h3><?php _e( 'Admin Menu', 'agrg' ); ?></h3>

					</div>

					<div class="three_fourth" style="margin-bottom: 0; margin: 18px 0;">

						<div style="float: right">

							<form id="wpjobus-add-company" type="post" action="" >

								<span style="margin-right: 10px; margin-top: 12px;"><?php _e( 'Status:', 'agrg' ); ?></span>

								<?php $post_status = get_post_status($result_company[$this_post_id]); ?>

								<select name="post-status" id="post-status" style="width: 150px; margin-right: 30px; margin-bottom: 0;">
									<option value='publish' <?php selected( $post_status, "publish" ); ?>>publish</option>
									<option value='draft' <?php selected( $post_status, "draft" ); ?>>draft</option>
									<option value='pending' <?php selected( $post_status, "pending" ); ?>>pending</option>
								</select>

								<span style="margin-right: 10px; margin-top: 12px;"><?php _e( 'Type:', 'agrg' ); ?></span>

								<select name="post-type" id="post-type" style="width: 150px; margin-right: 30px; margin-bottom: 0;">
									<option value='featured' <?php selected( $wpjobus_post_reg_status, "featured" ); ?>>featured</option>
									<option value='regular' <?php selected( $wpjobus_post_reg_status, "regular" ); ?>>regular</option>
								</select>

								<div class="exp-days-block" style="display: <?php if($wpjobus_post_reg_status == "featured") { ?>block;<?php } else { ?>none;<?php } ?>">

									<span style="margin-right: 10px; margin-top: 12px;"><?php _e( 'Expires in:', 'agrg' ); ?></span>

									<?php 

										if($wpjobus_post_reg_status == "featured") {

											$wpjobus_featured_expiration_date = esc_attr(get_post_meta($this_post_id, 'wpjobus_featured_expiration_date',true));

											$start = current_time('timestamp');
											$end = $wpjobus_featured_expiration_date;

											$days_between = ceil(abs($end - $start) / 86400); 

										} else {

											$days_between = "";
											
										} 

									?>

									<input type="text" name="exp-time" id="exp-time" value="<?php echo $days_between; ?>" class="input-textarea" placeholder="" style="width: 50px; margin-right: 10px; margin-bottom: 0;"/>

									<span style="margin-right: 30px; margin-top: 12px;"><?php _e( 'days', 'agrg' ); ?></span>

								</div>

								<input type="hidden" id="featPostId" name="featPostId" value="<?php echo $this_post_id; ?>">

								<input style="margin: 0;" name="submit" type="submit" value="Update" class="input-submit">
								<span class="submit-loading" style="margin: 0;"><i class="fa fa-refresh fa-spin"></i></span>

								<span id="success" style="float: left; width: auto; margin: 10px 0;"><?php _e( 'Done', 'agrg' ); ?></span>

								<input type="hidden" name="action" value="wpjobusAdminFeaturedCompanyForm" />
								<?php wp_nonce_field( 'wpjobusAdminFeaturedCompanyForm_html', 'wpjobusAdminFeaturedCompanyForm_nonce' ); ?>

							</form>

							<script type="text/javascript">

								jQuery(function($) {

									$("#post-type").change(function(){

										if($(this).val() == "featured" ) {

									    	jQuery('.exp-days-block').css('display','block');

									 	} else {

									   		jQuery('.exp-days-block').css('display','none');

									  	}

									});

									jQuery('#wpjobus-add-company').validate({
										rules: {
										},
										messages: {
										},
										submitHandler: function(form) {
										    jQuery('#wpjobus-add-company .input-submit').css('display','none');
										    jQuery('#wpjobus-add-company .submit-loading').css('display','block');
										    jQuery(form).ajaxSubmit({
										        type: "POST",
												data: jQuery(form).serialize(),
												url: '<?php echo admin_url('admin-ajax.php'); ?>', 
										        success: function(data) {
										            jQuery('#wpjobus-add-company .submit-loading').css('display','none');
										        	jQuery('#success').fadeIn(); 

				      								<?php $redirect_link = home_url()."/?post_type=resume&p=".$this_post_id."&preview=true"; ?>

				      								var delay = 1;
				      								setTimeout(function(){ window.location = '<?php echo $redirect_link; ?>';}, delay);
										        },
										        error: function(data) {
										        	jQuery('#wpjobus-add-company .input-submit').css('display','block');
										        	jQuery('#wpjobus-add-company .submit-loading').css('display','none');

										            jQuery('#error').fadeIn();
										        }
										    });
										}
									});

								});

							</script>

						</div>

					</div>

				</div>

			</div>

		</div>

		<?php } ?>

		<div class="bannerText">
			<?php 

				global $redux_demo, $website_type; 
				$website_type = $redux_demo['homepage-state'];

				if(($website_type == 1) or empty($website_type)) {

			?>
			<div class="menu-nav-trigger">
				<span class="zebra-line top"></span>
				<span class="zebra-line middle"></span>
				<span class="zebra-line bottom"></span>
			</div>
			<?php } ?>
			<span class="banner-hello">Hi</span>
	      	<h1><span class="light"><?php _e( 'I&#39;m', 'agrg' ); ?></span> <?php echo esc_attr( $wpjobus_resume_fullname ); ?></h1>
	      	<h2><?php echo esc_attr( $resume_career_level ); ?> <?php echo esc_attr( $wpjobus_resume_prof_title ); ?></h2>
	      	<span class="cover-resume-breadcrumbs"><i class="fa fa-home"></i> <i class="fa fa-chevron-right"></i> <?php _e( 'Resumes', 'agrg' ); ?> <i class="fa fa-chevron-right"></i>  <?php echo esc_attr( $resume_industry ); ?> </span>
	    </div>

		<div class="coverImageHolder">
			<img src="<?php echo esc_url( $wpjobus_resume_cover_image ); ?>" alt="" class="bgImg">
		</div>

	</section>

	<section id="resume-menu">

		<div class="container">

			<ul class="nav navbar-nav">

				<li class="menuItem active backtophome"><a href="#backtop"><i class="fa fa-home"></i><?php _e( 'Home', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-about-block"><i class="fa fa-file-text-o"></i><?php _e( 'About', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-skills-block"><i class="fa fa-bar-chart-o"></i><?php _e( 'Skills', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-education-block"><i class="fa fa-university"></i><?php _e( 'Education', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-experience-block"><i class="fa fa-building"></i><?php _e( 'Experience', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-portfolio-block"><i class="fa fa-bookmark"></i><?php _e( 'Portfolio', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-contact-block"><i class="fa fa-envelope"></i><?php _e( 'Contact', 'agrg' ); ?></a></li>

			</ul>

			<select id="mobile-nav-bar" onchange="location = this.options[this.selectedIndex].value;">

				<option value="#backtop"><?php _e( 'Home', 'agrg' ); ?></option>
				<option value="#resume-about-block"><?php _e( 'About', 'agrg' ); ?></option>
				<option value="#resume-skills-block"><?php _e( 'Skills', 'agrg' ); ?></option>
				<option value="#resume-education-block"><?php _e( 'Education', 'agrg' ); ?></option>
				<option value="#resume-experience-block"><?php _e( 'Experience', 'agrg' ); ?></option>
				<option value="#resume-portfolio-block"><?php _e( 'Portfolio', 'agrg' ); ?></option>
				<option value="#resume-contact-block"><?php _e( 'Contact', 'agrg' ); ?></option>

			</select>

		</div>

	</section>

	<section id="resume-about-block">

		<div class="container">

			<div class="three_fifth first">

				<h1 class="resume-author-name"><?php echo esc_attr( $wpjobus_resume_fullname ); ?></h1>
				<h2 class="resume-author-subtitle"><?php echo esc_attr( $resume_career_level ); ?> <?php echo esc_attr( $wpjobus_resume_prof_title ); ?></h2>

				<div class="full">
					<span class="resume-experience-years-block">
						<i class="fa fa-clock-o"></i>
						<span class="experience-period"><?php echo esc_attr( $resume_years_of_exp ); ?> <?php _e( 'Years', 'agrg' ); ?></span>
						<span class="experience-subtitle"><?php _e( 'of experience', 'agrg' ); ?></span>
					</span>
					<span class="resume-expect-revenue-block">
						<i class="fa fa-money"></i>
						<span class="experience-period"><?php if(!empty($wpjobus_resume_remuneration)) { echo esc_attr( $wpjobus_resume_remuneration ); } else { echo "-"; } ?></span>
						<span class="experience-subtitle">/<?php if(!empty($wpjobus_resume_remuneration_per)) { echo esc_attr( $wpjobus_resume_remuneration_per ); } else { echo "-"; } ?></span>
					</span>
					<span class="resume-expect-jobs">
						<span class="experience-period"><?php _e( 'Job Types I am looking for:', 'agrg' ); ?></span>
						<span class="experience-subtitle">

							<?php 

								if(!empty($wpjobus_resume_job_type)) {

									for ($i = 0; $i < (count($wpjobus_resume_job_type)); $i++) {

										if(!empty($wpjobus_resume_job_type[$i][1])) {
							?>

							<span class="resume_job_<?php echo esc_attr( $wpjobus_resume_job_type[$i][0] ); ?>"><?php echo esc_attr( $wpjobus_resume_job_type[$i][1] ); ?></span>

							<?php } } } ?>

						</span>
					</span>
				</div>

				<div class="full">
					<?php echo $resume_about_me; ?>
				</div>

			</div>

			<div class="two_fifth">

				<div class="resume-author-avatar">

					<span class="resume-author-avatar-holder">
						<?php 

							require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
							$params = array( 'width' => 260, 'height' => 260, 'crop' => true );
							echo "<img src='" . bfi_thumb( "$wpjobus_resume_profile_picture", $params ) . "' alt='" . $wpjobus_resume_fullname . "'/>";

						?>
					</span>

					<?php if(!empty($wpjobus_resume_file)) { ?>

					<span class="resume-download-file">
						<a href="<?php echo esc_url( $wpjobus_resume_file ); ?>" rel="external"><i class="fa fa-cloud-download"></i><?php _e( 'Download Resume', 'agrg' ); ?></a>
					</span>

					<?php } ?>

				</div>

			</div>

		</div>

	</section>

	<section id="resume-skills-block">

		<div class="container">

			<div class="resume-skills">

				<h1 class="resume-section-title"><i class="fa fa-bar-chart-o"></i><?php _e( 'Skills', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'Here’s an overview of my skills.', 'agrg' ); ?></h3>

				<div class="one_half first">

					<span class="main-skills-item">
						<span class="main-skills-item-title"><?php _e( 'Communication', 'agrg' ); ?></span>
						<span class="main-skills-item-bar">
							<span class="main-skills-item-bar-color" style="width: <?php echo esc_attr( $wpjobus_resume_comm_level ); ?>; background-color: #2ecc71;"></span>
						</span>
					</span>

					<div class="full main-skills-item-note"><?php echo esc_attr( $wpjobus_resume_comm_note ); ?></div>

					<span class="main-skills-item">
						<span class="main-skills-item-title"><?php _e( 'Organisational', 'agrg' ); ?></span>
						<span class="main-skills-item-bar">
							<span class="main-skills-item-bar-color" style="width: <?php echo esc_attr( $wpjobus_resume_org_level ); ?>; background-color: #e74c3c;"></span>
						</span>
					</span>

					<div class="full main-skills-item-note"><?php echo esc_attr( $wpjobus_resume_org_note ); ?></div>

					<span class="main-skills-item">
						<span class="main-skills-item-title"><?php _e( 'Job Related', 'agrg' ); ?></span>
						<span class="main-skills-item-bar">
							<span class="main-skills-item-bar-color" style="width: <?php echo esc_attr( $wpjobus_resume_job_rel_level ); ?>; background-color: #34495e;"></span>
						</span>
					</span>

					<div class="full main-skills-item-note"><?php echo esc_attr( $wpjobus_resume_job_rel_note ); ?></div>

				</div>

				<div class="one_half single-resume-skills">

					<?php 

						if(!empty($wpjobus_resume_skills)) {

							for ($i = 0; $i < (count($wpjobus_resume_skills)); $i++) {
					?>

					<span class="main-skills-item bar-skills-item">
						<span class="main-skills-item-title skill-title"><?php echo esc_attr( $wpjobus_resume_skills[$i][0] ); ?></span>
						<span class="main-skills-item-bar">
							<span class="main-skills-item-bar-color skill-bg" style="width: <?php echo esc_attr( $wpjobus_resume_skills[$i][1] ); ?>;"></span>
						</span>
					</span>

					<?php } ?>

					<div class="divider"></div>

					<div class="one_half first"><span class="main-skills-item-title-language"><?php $languages_total = count($wpjobus_resume_languages); $languages_total++; echo $languages_total; ?> <?php _e( 'Languages', 'agrg' ); ?></span></div>

					<div class="one_half"><span class="main-skills-item-title-language native-language"><?php echo esc_attr( $wpjobus_resume_native_language ); ?></span> <span class="main-skills-item-title-language native-small-language"><?php _e( '(Native)', 'agrg' ); ?></span></div>

					<?php 
						for ($i = 0; $i < (count($wpjobus_resume_languages)); $i++) {
					?>

					<div class="full main-skills-item-language">

						<div class="full"><span class="main-skills-item-title-language native-language-all"><?php echo esc_attr( $wpjobus_resume_languages[$i][0] ); ?></span></div>

						<div class="full" style="margin-bottom: 0;">

							<div class="one_half first" style="margin-bottom: 10px;"><span class="main-skills-item-title-language native-small-language-all"><?php _e( 'Understanding', 'agrg' ); ?></span></div>

							<div class="one_half" style="margin-bottom: 10px;">
								<span class="main-skills-item-title-language">

									<?php if($wpjobus_resume_languages[$i][1] == "Level 1") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][1] == "Level 2") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][1] == "Level 3") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][1] == "Level 4") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][1] == "Level 5") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i>

									<?php } ?>

								</span>
							</div>

						</div>

						<div class="full" style="margin-bottom: 0;">

							<div class="one_half first" style="margin-bottom: 10px;"><span class="main-skills-item-title-language native-small-language-all"><?php _e( 'Speaking', 'agrg' ); ?></span></div>

							<div class="one_half" style="margin-bottom: 10px;">
								<span class="main-skills-item-title-language">

									<?php if($wpjobus_resume_languages[$i][2] == "Level 1") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][2] == "Level 2") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][2] == "Level 3") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][2] == "Level 4") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][2] == "Level 5") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i>

									<?php } ?>

								</span>
							</div>

						</div>

						<div class="full" style="margin-bottom: 0;">

							<div class="one_half first" style="margin-bottom: 10px;"><span class="main-skills-item-title-language native-small-language-all"><?php _e( 'Writing', 'agrg' ); ?></span></div>

							<div class="one_half" style="margin-bottom: 10px;">
								<span class="main-skills-item-title-language">

									<?php if($wpjobus_resume_languages[$i][3] == "Level 1") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][3] == "Level 2") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][3] == "Level 3") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][3] == "Level 4") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment-o"></i>

									<?php } ?>

									<?php if($wpjobus_resume_languages[$i][3] == "Level 5") { ?>

									<i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i><i class="fa fa-comment"></i>

									<?php } ?>

								</span>
							</div>

						</div>

					</div>

					<?php } } ?>

				</div>

				<?php if (!empty($wpjobus_resume_hobbies)) { ?>

				<div class="divider"></div>

				<h1 class="resume-section-title"><i class="fa fa-gamepad"></i><?php _e( 'Hobbies', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'What I like to do in my free time.', 'agrg' ); ?></h3>

				<div class="full hobbies-block" style="text-align: center;">

					<?php $wpjobus_resume_hobbies = str_replace(", ", ",", $wpjobus_resume_hobbies); $wpjobus_resume_hobbies = str_replace(",", "</span><span class='hobbies-item'>", $wpjobus_resume_hobbies); ?>

					<span class="hobbies-item"><?php echo $wpjobus_resume_hobbies; ?></span>

				</div>

				<?php } ?>

			</div>

		</div>

	</section>

	<section id="resume-education-block">

		<div class="container">

			<?php if(!empty($wpjobus_resume_award)) { ?>

			<div class="two_third first">

			<?php } else { ?>

			<div class="full">

			<?php } ?>

				<h1 class="resume-section-title"><i class="fa fa-university"></i><?php _e( 'Education', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'Here’s an overview of education institutions I attended.', 'agrg' ); ?></h3>

				<?php 

					if(!empty($wpjobus_resume_education)) {

						for ($i = 0; $i < (count($wpjobus_resume_education)); $i++) {
				?>

				<span class="education-institution-block">
					<span class="education-period-circle">
						<span class="education-period-time"><?php echo esc_attr( $wpjobus_resume_education[$i][3] ); ?></span>
						<span class="education-period-time">-</span>
						<span class="education-period-time"><?php echo esc_attr( $wpjobus_resume_education[$i][2] ); ?></span>
					</span>
					<span class="education-institution-name"><?php echo esc_attr( $wpjobus_resume_education[$i][0] ); ?></span>
					<span class="education-institution-faculty-name"><?php echo esc_attr( $wpjobus_resume_education[$i][1] ); ?></span>
					<span class="education-institution-location"><i class="fa fa-map-marker"></i><?php echo esc_attr( $wpjobus_resume_education[$i][4] ); ?></span>
					<span class="education-institution-notes"><?php echo esc_attr( $wpjobus_resume_education[$i][5] ); ?></span>
				</span>

				<?php } } ?>

			</div>

			<?php if(!empty($wpjobus_resume_award)) { ?>

			<div class="one_third">

				<div class="resume-skills awards-trophy">

					<h1 class="resume-section-title"><i class="fa fa-trophy"></i><?php _e( 'Awards & Honors', 'agrg' ); ?></h1>

					<div class="divider"></div>

					<?php 
						for ($i = 0; $i < (count($wpjobus_resume_award)); $i++) {
					?>

					<span class="education-institution-block">
						<span class="education-period-circle">
							<span class="education-period-trophy"><i class="fa fa-trophy"></i></span>
							<span class="education-period-time"><?php echo esc_attr( $wpjobus_resume_award[$i][2] ); ?></span>
						</span>
						<span class="education-institution-name"><?php echo esc_attr( $wpjobus_resume_award[$i][0] ); ?></span>
						<span class="education-institution-faculty-name"><?php echo esc_attr( $wpjobus_resume_award[$i][1] ); ?></span>
						<span class="education-institution-location"><i class="fa fa-map-marker"></i><?php echo esc_attr( $wpjobus_resume_award[$i][3] ); ?></span>
					</span>

					<?php } ?>

				</div>

			</div>

			<?php } ?>

		</div>

	</section>

	<section id="resume-experience-block">

		<div class="container">

			<div class="resume-skills">

				<h1 class="resume-section-title"><i class="fa fa-building"></i><?php _e( 'Work Experience', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'Here’s a list of companies where I worked and gained my professional experience.', 'agrg' ); ?></h3>

				<div class="divider" style="margin-top: 20px;"></div>

				<div class="work-experience-holder">

					<?php 

						if(!empty($wpjobus_resume_work)) {

							for ($i = 0; $i < (count($wpjobus_resume_work)); $i++) {
					?>

					<span class="work-experience-block">

						<span class="work-experience-first-block">

							<span class="work-experience-first-block-content">

								<span class="work-experience-org-name"><?php echo esc_attr( $wpjobus_resume_work[$i][0] ); ?></span>
								<span class="work-experience-job-title"><?php echo esc_attr( $wpjobus_resume_work[$i][1] ); ?></span>

							</span>

						</span>

						<span class="work-experience-second-block">

							<span class="work-experience-second-block-content">

								<span class="work-experience-time-line"></span>

								<span class="work-experience-period"><?php echo esc_attr( $wpjobus_resume_work[$i][2] ); ?> - <?php echo esc_attr( $wpjobus_resume_work[$i][3] ); ?></span>
								<span class="work-experience-job-type"><?php echo esc_attr( $wpjobus_resume_work[$i][4] ); ?></span>

							</span>

						</span>

						<span class="work-experience-third-block">

							<span class="work-experience-third-block-content">

								<span class="work-experience-notes"><?php echo esc_attr( $wpjobus_resume_work[$i][5] ); ?></span>

							</span>

						</span>

					</span>

					<?php } } ?>

				</div>

				<?php if(!empty($wpjobus_resume_testimonials)) { ?>

				<h1 class="resume-section-title"><i class="fa fa-comment"></i><?php _e( 'Testimonials', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'Here’s whar people are saying about me.', 'agrg' ); ?></h3>

				<div id="owl-demo" class="owl-carousel owl-theme">

					<?php 

						for ($i = 0; $i < (count($wpjobus_resume_testimonials)); $i++) {

							if(!empty($wpjobus_resume_testimonials[$i][0])) {
					?>
 
				  	<div class="item">

				  		<div class="resume-testimonials">

				  			<span class="resume-testimonials-image">

				  				<?php 

				  					$wpjobus_resume_testimonials_profile_picture = esc_url($wpjobus_resume_testimonials[$i][3]);

					  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
									$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
									echo "<img src='" . bfi_thumb( "$wpjobus_resume_testimonials_profile_picture", $params ) . "' alt='" . esc_attr($wpjobus_resume_testimonials[$i][0]) . "'/>";

								?>

				  			</span>

				  			<span class="resume-testimonials-quote"><i class="fa fa-quote-right"></i></span>

				  			<div class="resume-testimonials-note"><?php echo esc_attr( $wpjobus_resume_testimonials[$i][2] ); ?></div>

				  			<div class="resume-testimonials-author-box"><span class="resume-testimonial-author"><?php echo esc_attr( $wpjobus_resume_testimonials[$i][0] ); ?></span> <span class="resume-testimonial-author-position"><?php echo esc_attr( $wpjobus_resume_testimonials[$i][1] ); ?></span></div>

				  		</div>

				  	</div>

				  	<?php } } ?>
				 
				</div>

				<?php } ?>

			</div>

		</div>

	</section>

	<section id="resume-portfolio-block">

		<div class="container">

			<h1 class="resume-section-title"><i class="fa fa-bookmark"></i><?php _e( 'Portfolio', 'agrg' ); ?></h1>
			<h3 class="resume-section-subtitle"><?php _e( 'Here are some of my works.', 'agrg' ); ?></h3>

			<section class="ff-container">

				<?php

					$categories = 0;

					for ($i = 0; $i < (count($wpjobus_resume_portfolio)); $i++) {

						if(!empty($wpjobus_resume_portfolio[$i][1])) {
							$categories++;
						}

					}
				?>

				<?php if($categories > 0) { ?>
 
			    <input id="select-type-all" name="radio-set-1" type="radio" class="ff-selector-type-all" checked="checked" />
			    <label for="select-type-all" class="ff-label-type-all"><?php _e( 'All', 'agrg' ); ?></label>

			    <?php 

			    if(!empty($wpjobus_resume_portfolio)) {

				    for ($i = 0; $i < (count($wpjobus_resume_portfolio)); $i++) {

						if(!empty($wpjobus_resume_portfolio[$i][1])) {
							$all_project_cat[] = $wpjobus_resume_portfolio[$i][1];
						}

					}

				}

				?>

					<?php

					$catProjID = 0;

					$directors = array_unique($all_project_cat);
					foreach ($directors as $director) { $catProjID++; $directorClass_0 = preg_replace('/^\/[^a-zA-Z0-9_ -%][().][\/]/s', '_', $director); $directorClass = preg_replace('/\s*,\s*/', '_', $directorClass_0); ?>

						<style>

				    		.ff-container input.ff-selector-type-<?php echo esc_attr( $directorClass ); ?>:checked ~ label.ff-label-type-<?php echo esc_attr( $directorClass ); ?> {
							    background: #999;
							    color: #fff;
							    padding: 10px 20;
							}

							.ff-container input.ff-selector-type-<?php echo esc_attr( $directorClass ); ?>:checked ~ .ff-items .ff-item-type-<?php echo esc_attr( $directorClass ); ?> {
							    opacity: 1;
							}

							.ff-container input.ff-selector-type-<?php echo esc_attr( $directorClass ); ?>:checked ~ .ff-items li:not(.ff-item-type-<?php echo esc_attr( $directorClass ); ?>) {
							    opacity: 0.1;
							}

							.ff-container input.ff-selector-type-<?php echo esc_attr( $directorClass ); ?>:checked ~ .ff-items li:not(.ff-item-type-<?php echo esc_attr( $directorClass ); ?>) span {
							    display: none;
							}


				    	</style>

						<input id="select-type-<?php echo esc_attr( $directorClass ); ?>" name="radio-set-1" type="radio" class="ff-selector-type-<?php echo esc_attr( $directorClass ); ?>" />
				    	<label for="select-type-<?php echo esc_attr( $directorClass ); ?>" class="ff-label-type-<?php echo esc_attr( $directorClass ); ?>"><?php echo esc_attr( $director ); ?></label>

					<?php } ?>

			    <?php } ?>
			     
			    <div class="clr"></div>
			     
			    <ul class="ff-items <?php if($categories == 0) { ?>visibile-projects<?php } ?>">

			    	<?php 

			    	if(!empty($wpjobus_resume_portfolio)) {

				    	$current = -1;

					    for ($p = 0; $p < (count($wpjobus_resume_portfolio)); $p++) {

					    	$directorClassProj_0 = preg_replace('/[^a-zA-Z0-9_ -%][().][\/]/s', '_', $wpjobus_resume_portfolio[$p][1]); $directorClassProj = preg_replace('/\s*,\s*/', '_', $directorClassProj_0);
					    	$current++;

					?>

			        <li class="ff-item-type-<?php echo esc_attr( $directorClassProj ); ?> <?php if($current%3 ==0) { echo 'first'; } ?>">
			            <a href="<?php echo esc_attr( $wpjobus_resume_portfolio[$p][3] ); ?>" data-lightbox="portfolio" data-title="<?php echo esc_attr( $wpjobus_resume_portfolio[$p][2] ); ?>">
			                <span><?php echo esc_attr( $wpjobus_resume_portfolio[$p][0] ); ?></span>

			                <?php 

								require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
								$params = array( 'width' => 430, 'height' => 247, 'crop' => true );
								$wpjobus_resume_portfolio_img = $wpjobus_resume_portfolio[$p][3];
								echo "<img src='" . bfi_thumb( "$wpjobus_resume_portfolio_img", $params ) . "' alt='" . $wpjobus_resume_portfolio[$p][0] . "'/>";

							?>

			            </a>
			        </li>

			        <?php } } ?>

			    </ul>
			     
			</section>

		</div>

	</section>

	<section id="resume-contact-block">

		<div id="resume-map"></div>

		<script type="text/javascript">
					var mapDiv,
						map,
						infobox;
					jQuery(document).ready(function($) {

						mapDiv = $("#resume-map");
						mapDiv.height(600).gmap3({
							map: {
								options: {
									"center": [<?php echo esc_attr( $wpjobus_resume_latitude ); ?>,<?php echo esc_attr( $wpjobus_resume_longitude ); ?>]
									,"zoom": 16
									,"draggable": true
									,"mapTypeControl": true
									,"mapTypeId": google.maps.MapTypeId.ROADMAP
									,"scrollwheel": false
									,"panControl": true
									,"rotateControl": false
									,"scaleControl": true
									,"streetViewControl": true
									,"zoomControl": true
									<?php global $redux_demo; $map_style = $redux_demo['map-style']; if(!empty($map_style)) { ?>,"styles": <?php echo $map_style; ?> <?php } ?>
								}
							}
							,marker: {
								values: [

								<?php

									$iconPath = get_template_directory_uri() .'/images/icon-services.png';

								?>

								{
									<?php require_once(TEMPLATEPATH . "/inc/BFI_Thumb.php"); ?>
									<?php $params = array( "width" => 230, "height" => 150, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $this_post_id ), "single-post-thumbnail" ); ?>

									latLng: [<?php echo esc_attr( $wpjobus_resume_latitude ); ?>,<?php echo esc_attr( $wpjobus_resume_longitude ); ?>],
									options: {
										icon: "<?php echo esc_url($iconPath); ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									}
								}	
									
								],
								options:{
									draggable: false
								}
							}
							 		 	});

						map = mapDiv.gmap3("get");

					    infobox = new InfoBox({
					    	pixelOffset: new google.maps.Size(-50, -65),
					    	closeBoxURL: '',
					    	enableEventPropagation: true
					    });
					    mapDiv.delegate('.infoBox .close','click',function () {
					    	infobox.close();
					    });

					    if (Modernizr.touch){
					    	map.setOptions({ draggable : false });
					        var draggableClass = 'inactive';
					        var draggableTitle = "Activate map";
					        var draggableButton = $('<div class="draggable-toggle-button '+draggableClass+'">'+draggableTitle+'</div>').appendTo(mapDiv);
					        draggableButton.click(function () {
					        	if($(this).hasClass('active')){
					        		$(this).removeClass('active').addClass('inactive').text("Activate map");
					        		map.setOptions({ draggable : false });
					        	} else {
					        		$(this).removeClass('inactive').addClass('active').text("Deactivate map");
					        		map.setOptions({ draggable : true });
					        	}
					        });
					    }

					});
		</script>

		<div class="container">

			<div class="resume-contact">

				<div class="two_third first">

					<h1 class="resume-section-title" style="margin-bottom: 10px;"><i class="fa fa-list-ul"></i><?php _e( 'Contact Form', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle"><?php _e( 'Use this contact form to send an email.', 'agrg' ); ?></h3>

					<div id="resume-contact">

						<form id="contact" type="post" action="" >  
						  	
						  	<span class="contact-name">
								<input type="text"  name="contactName" id="contactName" value="" class="input-textarea" placeholder="<?php _e("Name*", "agrg"); ?>" />
							</span>
							 
							<span class="contact-email">
								<input type="text" name="email" id="email" value="" class="input-textarea" placeholder="<?php _e("Email*", "agrg"); ?>" />
							</span>

							<span class="contact-message">
							    <textarea name="message" id="message" cols="8" rows="8" ></textarea>
							</span>

							<span class="contact-test">
							    <p style="margin-top: 20px;"><?php _e("Human test. Please input the result of 5+3=?", "agrg"); ?></p>
							    <input type="text" onfocus="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" name="answer" id="humanTest" value="" class="input-textarea" />
							</span>

							<input type="text" name="receiverEmail" id="receiverEmail" value="<?php echo $wpjobus_resume_email; ?>" class="input-textarea" style="display: none;"/>

							<input type="hidden" name="action" value="wpjobContactForm" />
							<?php wp_nonce_field( 'scf_html', 'scf_nonce' ); ?>

							<input style="margin-bottom: 0;" name="submit" type="submit" value="<?php _e( 'Send Message', 'agrg' ); ?>" class="input-submit">	 

							<span class="submit-loading"><i class="fa fa-refresh fa-spin"></i></span>
						  	  
						</form>

						<div id="success">
							<span>
							   	<h3><?php echo esc_attr( $wpcrown_contact_thankyou ); ?></h3>
							</span>
						</div>
							 
						<div id="error">
							<span>
							   	<h3><?php _e( 'Something went wrong, try refreshing and submitting the form again.', 'agrg' ); ?></h3>
							</span>
						</div>

						<script type="text/javascript">

						jQuery(function($) {
							jQuery('#contact').validate({
						        rules: {
						            contactName: {
						                required: true
						            },
						            email: {
						                required: true,
						                email: true
						            },
						            message: {
						                required: true
						            },
						            answer: {
						                required: true,
						                answercheck: true
						            }
						        },
						        messages: {
						            name: {
						                required: "<?php echo esc_attr( $wpcrown_contact_name_error ); ?>"
						            },
						            email: {
						                required: "<?php echo esc_attr( $wpcrown_contact_email_error ); ?>"
						            },
						            message: {
						                required: "<?php echo esc_attr( $wpcrown_contact_message_error ); ?>"
						            },
						            answer: {
						                required: "<?php echo esc_attr( $wpcrown_contact_test_error ); ?>"
						            }
						        },
						        submitHandler: function(form) {
						        	jQuery('#contact .input-submit').css('display','none');
						        	jQuery('#contact .submit-loading').css('display','block');
						            jQuery(form).ajaxSubmit({
						            	type: "POST",
								        data: jQuery(form).serialize(),
								        url: '<?php echo admin_url('admin-ajax.php'); ?>', 
						                success: function(data) {
						                   	jQuery('#contact :input').attr('disabled', 'disabled');
						                    jQuery('#contact').fadeTo( "slow", 0, function() {
						                    	jQuery('#contact').css('display','none');
						                        jQuery(this).find(':input').attr('disabled', 'disabled');
						                        jQuery(this).find('label').css('cursor','default');
						                        jQuery('#success').fadeIn();
						                    });
						                },
						                error: function(data) {
						                    jQuery('#contact').fadeTo( "slow", 0, function() {
						                        jQuery('#error').fadeIn();
						                    });
						                }
						            });
						        }
						    });
						});
						</script>

					</div>

				</div>

				<div class="one_third">

					<h1 class="resume-section-title" style="margin-bottom: 80px;"><i class="fa fa-envelope"></i><?php _e( 'Contact Details', 'agrg' ); ?></h1>

					<?php if(!empty($wpjobus_resume_address)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-map-marker"></i><span><?php echo esc_attr( $wpjobus_resume_address ); ?></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_phone)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-mobile"></i><span><?php echo esc_attr( $wpjobus_resume_phone ); ?></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_website)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_resume_website;
							$url = $wpjobus_resume_website;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-link"></i><span><a href="<?php echo esc_url( $return ); ?>"><?php echo esc_attr( $wpjobus_resume_website ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_email)) { ?>

					<?php if(!empty($wpjobus_resume_publish_email)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-envelope-o"></i><span><a href="mailto:<?php echo esc_url( $wpjobus_resume_email ); ?>"><?php echo esc_attr( $wpjobus_resume_email ); ?></a></span>

					</span>

					<?php } } ?>

					<?php if(!empty($wpjobus_resume_facebook)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_resume_facebook;
							$url = $wpjobus_resume_facebook;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-facebook-square"></i><span><a href="<?php echo esc_url( $return ); ?>"><?php _e( 'Facebook', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_linkedin)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_resume_linkedin;
							$url = $wpjobus_resume_linkedin;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-linkedin-square"></i><span><a href="<?php echo esc_url( $return ); ?>"><?php _e( 'LinkedIn', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_twitter)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_resume_twitter;
							$url = $wpjobus_resume_twitter;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-twitter-square"></i><span><a href="<?php echo esc_url( $return ); ?>"><?php _e( 'Twitter', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_resume_googleplus)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_resume_googleplus;
							$url = $wpjobus_resume_googleplus;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-google-plus-square"></i><span><a href="<?php echo esc_url( $return ); ?>"><?php _e( 'Google+', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

				</div>

			</div>

		</div>

	</section>

<?php get_footer(); ?>