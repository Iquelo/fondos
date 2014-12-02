<?php
/**
 * Job Page
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

$wpjobus_job_cover_image = esc_attr(get_post_meta($post->ID, 'wpjobus_job_cover_image',true));
$wpjobus_job_fullname = esc_attr(get_post_meta($post->ID, 'wpjobus_job_fullname',true));
$job_company = esc_attr(get_post_meta($post->ID, 'job_company',true));
$job_location = esc_attr(get_post_meta($post->ID, 'job_location',true));
$job_career_level = esc_attr(get_post_meta($post->ID, 'job_career_level',true));
$job_presence_type = esc_attr(get_post_meta($post->ID, 'job_presence_type',true));
$wpjobus_job_type = esc_attr(get_post_meta($post->ID, 'wpjobus_job_type',true));
$wpjobus_job_remuneration_per = esc_attr(get_post_meta($post->ID, 'wpjobus_job_remuneration_per',true));
$wpjobus_job_remuneration = esc_attr(get_post_meta($post->ID, 'wpjobus_job_remuneration',true));
$wpjobus_job_benefits = get_post_meta($post->ID, 'wpjobus_job_benefits',true);

$job_industry = esc_attr(get_post_meta($post->ID, 'job_industry',true));
$job_about_me = html_entity_decode(get_post_meta($post->ID, 'job-about-me',true));
$job_years_of_exp = esc_attr(get_post_meta($post->ID, 'job_years_of_exp',true));
$wpjobus_resume_profile_picture = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_profile_picture',true));

$wpjobus_resume_prof_title = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_prof_title',true));
$resume_career_level = esc_attr(get_post_meta($post->ID, 'resume_career_level',true));

$wpjobus_job_comm_level = esc_attr(get_post_meta($post->ID, 'wpjobus_job_comm_level',true));
$wpjobus_job_comm_note = esc_attr(get_post_meta($post->ID, 'wpjobus_job_comm_note',true));

$wpjobus_job_org_level = esc_attr(get_post_meta($post->ID, 'wpjobus_job_org_level',true));
$wpjobus_job_org_note = esc_attr(get_post_meta($post->ID, 'wpjobus_job_org_note',true));

$wpjobus_job_job_rel_level = esc_attr(get_post_meta($post->ID, 'wpjobus_job_job_rel_level',true));
$wpjobus_job_job_rel_note = esc_attr(get_post_meta($post->ID, 'wpjobus_job_job_rel_note',true));

$wpjobus_job_skills = get_post_meta($post->ID, 'wpjobus_job_skills',true);
$wpjobus_job_native_language = esc_attr(get_post_meta($post->ID, 'wpjobus_job_native_language',true));
$wpjobus_job_languages = get_post_meta($post->ID, 'wpjobus_job_languages',true);

$wpjobus_job_hobbies = get_post_meta($post->ID, 'wpjobus_job_hobbies',true);

$wpjobus_job_address = esc_attr(get_post_meta($post->ID, 'wpjobus_job_address',true));
$wpjobus_job_phone = esc_attr(get_post_meta($post->ID, 'wpjobus_job_phone',true));
$wpjobus_job_website = esc_url(get_post_meta($post->ID, 'wpjobus_job_website',true));
$wpjobus_job_email = get_post_meta($post->ID, 'wpjobus_job_email',true);
$wpjobus_job_publish_email = esc_attr(get_post_meta($post->ID, 'wpjobus_job_publish_email',true));
$wpjobus_job_facebook = esc_url(get_post_meta($post->ID, 'wpjobus_job_facebook',true));
$wpjobus_job_linkedin = esc_url(get_post_meta($post->ID, 'wpjobus_job_linkedin',true));
$wpjobus_job_twitter = esc_url(get_post_meta($post->ID, 'wpjobus_job_twitter',true));
$wpjobus_job_googleplus = esc_url(get_post_meta($post->ID, 'wpjobus_job_googleplus',true));

$wpjobus_job_googleaddress = esc_attr(get_post_meta($post->ID, 'wpjobus_job_googleaddress',true));
$wpjobus_job_longitude = esc_attr(get_post_meta($post->ID, 'wpjobus_job_longitude',true));
$wpjobus_job_latitude = esc_attr(get_post_meta($post->ID, 'wpjobus_job_latitude',true));

get_header(); 

global $redux_demo;
$contact_email = esc_attr(get_post_meta($post->ID, 'wpjobus_job_email',true));
$wpcrown_contact_email_error = esc_attr($redux_demo['contact-email-error']);
$wpcrown_contact_name_error = esc_attr($redux_demo['contact-name-error']);
$wpcrown_contact_message_error = esc_attr($redux_demo['contact-message-error']);
$wpcrown_contact_thankyou = esc_attr($redux_demo['contact-thankyou-message']);
$wpcrown_contact_test_error = esc_attr($redux_demo['contact-test-error']);

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

							$author_id = $wpdb->get_results( "SELECT DISTINCT post_author FROM `{$wpdb->prefix}posts` WHERE post_type = 'job' and ID = '".$this_post_id."' ORDER BY `ID` DESC");

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

				      								<?php $redirect_link = home_url()."/?post_type=job&p=".$this_post_id."&preview=true"; ?>

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
			<div class="menu-nav-trigger">
				<span class="zebra-line top"></span>
				<span class="zebra-line middle"></span>
				<span class="zebra-line bottom"></span>
			</div>
			<!--
<span class="banner-hello borrar">
				<span class="job_work_type"><?php echo $wpjobus_job_type; ?></span>
				<span class="job_remuneration"><?php echo $wpjobus_job_remuneration; ?></span>
				<span class="job_remuneration_per">/<?php echo $wpjobus_job_remuneration_per; ?></span>
			</span>
-->
	      	<h1><?php echo $wpjobus_job_fullname; ?></h1>
	      	<h2><i class="fa fa-briefcase"></i><?php $wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true)); echo $wpjobus_company_fullname; ?> <i class="fa fa-map-marker"></i><?php echo $job_location; ?></h2>
	      	<span class="cover-resume-breadcrumbs"><i class="fa fa-home"></i> <i class="fa fa-chevron-right"></i> <?php _e( 'Oportunidad', 'agrg' ); ?> <i class="fa fa-chevron-right"></i>  <?php echo $job_industry; ?> </span>
	    </div>

		<div class="coverImageHolder">
			<img src="<?php echo $wpjobus_job_cover_image; ?>" alt="" class="bgImg">
		</div>

	</section>

	<section id="job-menu">

		<div class="container">

			<ul class="nav navbar-nav">

				<li class="menuItem active backtophome"><a href="#resume-about-block"><i class="fa fa-file-text-o"></i><?php _e( 'Descripción', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-experience-block"><i class="fa fa-bookmark"></i><?php _e( 'Detalles', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-skills-block"><i class="fa fa-university"></i><?php _e( 'Institución', 'agrg' ); ?></a></li>
				<li class="menuItem"><a href="#resume-contact"><i class="fa fa-map-marker"></i><?php _e( 'Mapa', 'agrg' ); ?></a></li>
				
				<li class="menuItem"><a href="#resume-map"><i class="fa fa-send"></i>Contacto</a></li>
				

			</ul>

			<select id="mobile-nav-bar" onchange="location = this.options[this.selectedIndex].value;">

				<option value="#backtop"><?php _e( 'Overview', 'agrg' ); ?></option>
				<option value="#resume-skills-block"><?php _e( 'Qualifications', 'agrg' ); ?></option>
				<option value="#resume-experience-block"><?php _e( 'Sallary & Benefits', 'agrg' ); ?></option>
				<option value="#resume-contact-block"><?php _e( 'Job Application', 'agrg' ); ?></option>

			</select>

		</div>

	</section>

	<section id="resume-about-block" style="text-align: left;">

		<div class="container">

			<div class="three_fifth first" style="margin-bottom: 0; margin-top: 50px;">

				<div class="full" style="margin-bottom: 0;">
					<?php 

						$content = $job_about_me;

						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]&gt;', $content);

						echo $content;

					?>
				</div>

			</div>

			<div class="two_fifth" style="margin-top: 50px;">

				<!--
<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-square-o"></i><?php _e( 'ID', 'agrg' ); ?></span>
					<span class="job-info-data">#<?php $id = get_the_ID(); echo $id; ?></span>
				</span>
-->



				<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-rocket"></i><?php _e( 'Nombre', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $wpjobus_job_fullname; ?></span>
				</span>


				<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-map-marker"></i><?php _e( 'Ubicación', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $job_location; ?></span>
				</span>

<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-child"></i><?php _e( 'Tipo', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $wpjobus_job_type; ?></span>
				</span>

				<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-folder-o"></i><?php _e( 'Categoría', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $job_industry; ?></span>
				</span>

				<!--
<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-flask"></i><?php _e( 'Career Level', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $job_career_level; ?></span>
				</span>

				<span class="job-info-details">
					<span class="job-info-id"><i class="fa fa-home"></i><?php _e( 'Presence', 'agrg' ); ?></span>
					<span class="job-info-data"><?php echo $job_presence_type; ?></span>
				</span>
-->

			</div>

		</div>

	</section>

	

	<section id="resume-experience-block" style="margin-bottom: 30px;">

		<div class="container">

			<div class="resume-skills">

				<h1 class="resume-section-title"><i class="fa fa-bookmark"></i><?php _e( 'Detalles', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( '¿Quiénes son los beneficiarios? ¿Cómo se accede?', 'agrg' ); ?></h3>

				

				<div class="job-experience-holder">

						<span class="one_fourth first">

							<span class="work-experience-first-block-content">

								<span class="work-experience-org-name"><?php _e( 'Destinatarios', 'agrg' ); ?></span>

							</span>

						</span>

					<?php 
						if(!empty($wpjobus_job_benefits)) {
							for ($i = 0; $i < (count($wpjobus_job_benefits)); $i++) {
					?>

						<span class="three_fourth" style="float: right; margin-bottom: 0;">

							<span class="one_third first" style="margin-bottom: 0;">

								<span class="work-experience-second-block-content">

									<span class="work-experience-period"><?php echo esc_attr($wpjobus_job_benefits[$i][0]); ?></span>

								</span>

							</span>

							<span class="two_third" style="margin-bottom: 0;">

								<span class="work-experience-third-block-content">

									<span class="work-experience-notes"><?php echo esc_attr($wpjobus_job_benefits[$i][1]); ?></span>

								</span>

							</span>

						</span>

					<?php } } ?>

				</div>

			</div>

		</div>

	</section>

	<section id="resume-skills-block">

		<div class="container">

			<div class="resume-skills">

				<?php 

					$wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
					$wpjobus_company_tagline = esc_attr(get_post_meta($job_company, 'wpjobus_company_tagline',true));
					$wpjobus_company_profile_picture = esc_attr(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

				?>

				<h1 class="resume-section-title"><i class="fa fa-briefcase"></i><?php _e( 'Sobre la Institución', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle"><?php _e( 'Una breve descripción de la institución que registró esta oportunidad', 'agrg' ); ?></h3>

				<div class="full job-company-desc" style="text-align: center;">
					<span><img src="<?php echo $wpjobus_company_profile_picture; ?>" alt=""></span>
					<h1><?php echo $wpjobus_company_fullname; ?></h1>
		      		<h2><?php echo $wpjobus_company_tagline; ?></h2>
		      	</div>

				<div class="divider"></div>

				<div class="full" style="text-align: center;">

					<?php 

						$wpjobus_company_foundyear = esc_attr(get_post_meta($job_company, 'wpjobus_company_foundyear',true));
						$company_team_size = esc_attr(get_post_meta($job_company, 'company_team_size',true));

					?>

					<span class="company-est-year-block">
						<i class="fa fa-calendar"></i>
						<span class="experience-period"><?php _e( 'Desde', 'agrg' ); ?></span>
						<span class="experience-subtitle"><?php echo $wpjobus_company_foundyear; ?></span>
					</span>

					<span class="company-team-block">
						<i class="fa fa-users"></i>
						<span class="experience-period"><?php echo $company_team_size; ?></span>
						<span class="experience-subtitle"><?php _e( 'Beneficiarios', 'agrg' ); ?></span>
					</span>

					<?php 

						$id = $job_company;

						$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_company' AND $wpdb->postmeta.meta_value = $id AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'job' AND $wpdb->posts.post_date < NOW() ORDER BY $wpdb->posts.post_date DESC
							";

						$pageposts = $wpdb->get_results($querystr, OBJECT);

						$jobs_offer = 0;

					?>

					<?php if ($pageposts): ?>
					<?php global $post; ?>
					<?php foreach ($pageposts as $post): ?>
						
					<?php $jobs_offer++; ?>

					<?php endforeach; ?>
						

					<span class="company-jobs-block">
						<i class="fa fa-bullhorn"></i>
						<span class="experience-period"><?php echo $jobs_offer; ?></span>
						<span class="experience-subtitle"><?php if($jobs_offer > 1){ ?><?php _e( 'Oportunidades', 'agrg' ); ?><?php } else { ?><?php _e( 'Job', 'agrg' ); ?><?php } ?></span>
					</span>

					<?php endif; ?>

				</div>

				<?php 
					$current = -1;

					$wpjobus_company_services = get_post_meta($job_company, 'wpjobus_company_services',true);

					for ($i = 0; $i < (count($wpjobus_company_services)); $i++) {

						$current++;
				?>

				<div class="one_third <?php if($current%3 ==0) { echo 'first '; } ?>" style="text-align: center; margin-bottom: 0;">

					<span class="company-services-icon"><?php echo $wpjobus_company_services[$i][1]; ?></span>
					<span class="company-services-devider"></span>
					<span class="company-services-title"><?php echo esc_attr($wpjobus_company_services[$i][0]); ?></span>
					<span class="company-services-desc" style="margin-bottom: 0;"><?php echo esc_attr($wpjobus_company_services[$i][2]); ?></span>

				</div>

				<?php } ?>

			</div>

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
									"center": [<?php echo $wpjobus_job_latitude; ?>,<?php echo $wpjobus_job_longitude; ?>]
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
									<?php $params = array( "width" => 230, "height" => 150, "crop" => true ); $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "single-post-thumbnail" ); ?>

									latLng: [<?php echo $wpjobus_job_latitude; ?>,<?php echo $wpjobus_job_longitude; ?>],
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

					<h1 class="resume-section-title" style="margin-bottom: 10px;"><i class="fa fa-list-ul"></i><?php _e( 'Contactar a esta institución', 'agrg' ); ?></h1>
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

							<input type="text" name="receiverEmail" id="receiverEmail" value="<?php echo $wpjobus_job_email; ?>" class="input-textarea" style="display: none;"/>

							<input type="hidden" name="action" value="wpjobContactForm" />
							<?php wp_nonce_field( 'scf_html', 'scf_nonce' ); ?>

							<input style="margin-bottom: 0;" name="submit" type="submit" value="<?php _e( 'Send Message', 'agrg' ); ?>" class="input-submit">	 

							<span class="submit-loading"><i class="fa fa-refresh fa-spin"></i></span>
						  	  
						</form>

						<div id="success">
							<span>
							   	<h3><?php echo $wpcrown_contact_thankyou; ?></h3>
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
						                required: "<?php echo $wpcrown_contact_name_error; ?>"
						            },
						            email: {
						                required: "<?php echo $wpcrown_contact_email_error; ?>"
						            },
						            message: {
						                required: "<?php echo $wpcrown_contact_message_error; ?>"
						            },
						            answer: {
						                required: "<?php echo $wpcrown_contact_test_error; ?>"
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

					<h1 class="resume-section-title" style="margin-bottom: 80px;"><i class="fa fa-envelope"></i><?php _e( 'Info de contacto', 'agrg' ); ?></h1>

					<span class="resume-contact-info">

						<i class="fa fa-briefcase"></i><span><?php $wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true)); echo $wpjobus_company_fullname; ?></span>

					</span>

					<?php if(!empty($wpjobus_job_address)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-map-marker"></i><span><?php echo $wpjobus_job_address; ?></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_phone)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-mobile"></i><span><?php echo $wpjobus_job_phone; ?></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_website)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_job_website;
							$url = $wpjobus_job_website;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-link"></i><span><a href="<?php echo $return; ?>"><?php echo $wpjobus_job_website; ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_email)) { ?>

					<?php if(!empty($wpjobus_job_publish_email)) { ?>

					<span class="resume-contact-info">

						<i class="fa fa-envelope-o"></i><span><a href="mailto:<?php echo $wpjobus_job_email; ?>"><?php echo $wpjobus_job_email; ?></a></span>

					</span>

					<?php } } ?>

					<?php if(!empty($wpjobus_job_facebook)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_job_facebook;
							$url = $wpjobus_job_facebook;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-facebook-square"></i><span><a href="<?php echo $return; ?>"><?php _e( 'Facebook', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_linkedin)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_job_linkedin;
							$url = $wpjobus_job_linkedin;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-linkedin-square"></i><span><a href="<?php echo $return; ?>"><?php _e( 'LinkedIn', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_twitter)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_job_twitter;
							$url = $wpjobus_job_twitter;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-twitter-square"></i><span><a href="<?php echo $return; ?>"><?php _e( 'Twitter', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

					<?php if(!empty($wpjobus_job_googleplus)) { ?>

					<span class="resume-contact-info">

						<?php 

							$return = $wpjobus_job_googleplus;
							$url = $wpjobus_job_googleplus;
							if ((!(substr($url, 0, 7) == 'http://')) && (!(substr($url, 0, 8) == 'https://'))) { $return = 'http://' . $url; }

						?>

						<i class="fa fa-google-plus-square"></i><span><a href="<?php echo $return; ?>"><?php _e( 'Google+', 'agrg' ); ?></a></span>

					</span>

					<?php } ?>

				</div>

			</div>

		</div>

	</section>

<?php get_footer(); ?>