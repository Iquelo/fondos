<?php

/**************************************
Custom Post Meta Boxes
***************************************/

	add_action('add_meta_boxes', 'register_resume_settings');
	function register_resume_settings () {
		add_meta_box('wpjobus_resume_basic_settings', 'Basic Info', 'display_wpjobus_resume_basic_settings','resume');
		add_meta_box('wpjobus_resume_skills_settings', 'Skills', 'display_wpjobus_resume_skills_settings','resume');
		add_meta_box('wpjobus_resume_education_settings', 'Education', 'display_wpjobus_resume_education_settings','resume');
		add_meta_box('wpjobus_resume_work_settings', 'Work Experience', 'display_wpjobus_resume_work_settings','resume');
		add_meta_box('wpjobus_resume_testimonials_settings', 'Testimonials', 'display_wpjobus_resume_testimonials_settings','resume');
		add_meta_box('wpjobus_resume_salary_settings', 'Salary & Job Types', 'display_wpjobus_resume_salary_settings','resume');
		add_meta_box('wpjobus_resume_portfolio_settings', 'Portfolio', 'display_wpjobus_resume_portfolio_settings','resume');
		add_meta_box('wpjobus_resume_contact_settings', 'Contact', 'display_wpjobus_resume_contact_settings','resume');
	}

	function display_wpjobus_resume_basic_settings ($post) {
		//get the post meta data
		
		$wpjobus_resume_fullname = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_fullname',true));
		$resume_gender = esc_attr(get_post_meta($post->ID, 'resume_gender',true));
		$resume_month_birth = esc_attr(get_post_meta($post->ID, 'resume_month_birth',true));
		$resume_day_birth = esc_attr(get_post_meta($post->ID, 'resume_day_birth',true));
		$resume_year_birth = esc_attr(get_post_meta($post->ID, 'resume_year_birth',true));
		$resume_years_of_exp = esc_attr(get_post_meta($post->ID, 'resume_years_of_exp',true));
		$resume_industry = esc_attr(get_post_meta($post->ID, 'resume_industry',true));
		$resume_location = esc_attr(get_post_meta($post->ID, 'resume_location',true));
		$resume_about_me = esc_attr(get_post_meta($post->ID, 'resume-about-me',true));
		$wpjobus_resume_profile_picture = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_profile_picture',true));
		$wpjobus_resume_cover_image = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_cover_image',true));
		$wpjobus_resume_file = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_file',true));
		$wpjobus_resume_file_name = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_file_name',true));

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<style>
			#review_options_popup {
				display: block;
			}

			#poststuff #titlewrap, #post-body #normal-sortables {
				display: none;
			}

			#review_options_popup .option_item {
				background: #FFF;
				margin: 0 -10px 0 -10px;
				border-bottom: 1px solid #EEE;
				padding: 14px 10px 14px 10px;
				width: 100%;
			}

			#review_options_popup .option_item span.text {
				float: left;
				display: block;
				width: 96px;
				margin-top: 5px;
			}

			#review_options_popup .option_item .criteria_name {
				float: left;
				margin-right: 36px;
				width: 400px;
			}

			#review_options_popup .option_item span.text {
				width: 100px;
				margin-right: 10px;
			}

			#review_options_popup .option_item input {
				float: left;
				margin-right: 20px;
			}

			.full {
				width: 100%;
				display: inline-block;
			}

			.recipe-desc {
				float: left;
			}

			.info-text {
				font-style: italic;
				float: left;
				margin-top: 10px;
				width: 70%;
				margin-left: 113px;
			}

			.criteria-image {
				max-width: 590px;
				height: auto;
			}

		</style>

		<div id='review_options_popup'>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Full Name:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_fullname' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_fullname; ?>' placeholder="" />
				
			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall'>Gender:</span>

					<div style="float: left;">
						<select name="resume_gender" id="resume_gender" style="width: 260px;">
							<option value="Male" <?php selected( $resume_gender, 'Male' ); ?>>Male</option>
							<option value="Female" <?php selected( $resume_gender, 'Female' ); ?>>Female</option>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall'>Date of birth:</span>

					<div style="float: left;">
						<select name="resume_month_birth" id="resume_month_birth" style="width: 60px; margin-right: 10px;">
							<?php 
								echo $resume_month_birth;

								for ($i = 1; $i <= 12; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php selected( $resume_month_birth, $i ); ?>><?php echo $i; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

					<div style="float: left;">
						<select name="resume_day_birth" id="resume_day_birth" style="width: 60px; margin-right: 10px;">
							<?php 
								for ($i = 1; $i <= 31; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php selected( $resume_day_birth, $i ); ?>><?php echo $i; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

					<div style="float: left;">
						<select name="resume_year_birth" id="resume_year_birth" style="width: 120px; margin-right: 10px;">
							<?php 
								$thisYear = date("Y");
								for ($i = $thisYear; $i >= 1934; $i--) {
							?>
							<option value='<?php echo $i; ?>' <?php selected( $resume_year_birth, $i ); ?>><?php echo $i; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall'>Years of experience:</span>

					<div style="float: left;">
						<select name="resume_years_of_exp" id="resume_years_of_exp" style="width: 260px; margin-right: 10px;">
							<?php 
								for ($i = 1; $i <= 20; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php selected( $resume_years_of_exp, $i ); ?>><?php echo $i; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall'>Industry:</span>

					<div style="float: left;">
						<select name="resume_industry" id="resume_industry" style="width: 260px; margin-right: 10px;">
							<?php 
								global $redux_demo; 
								for ($i = 0; $i < count($redux_demo['resume-industries']); $i++) {
							?>
							<option value='<?php echo $redux_demo['resume-industries'][$i]; ?>' <?php selected( $resume_industry, $redux_demo["resume-industries"][$i] ); ?>><?php echo $redux_demo['resume-industries'][$i]; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall'>Location:</span>

					<div style="float: left;">
						<select name="resume_location" id="resume_location" style="width: 260px; margin-right: 10px;">
							<?php 
								global $redux_demo; 
								for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
							?>
							<option value='<?php echo $redux_demo['resume-locations'][$i]; ?>' <?php selected( $resume_location, $redux_demo["resume-locations"][$i] ); ?>><?php echo $redux_demo['resume-locations'][$i]; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">About Me:</span>
					<textarea class="recipe-desc" name="resume-about-me" id='resume-about-me' cols="70" rows="7" ><?php echo $resume_about_me; ?></textarea>
				</span>
				
			</div>

			<div class="option_item">

				<span class="full">
						<span class="text">Profile Picture</span>

						<span>

						<?php if(!empty($wpjobus_resume_profile_picture)) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img" src="<?php if (!empty($wpjobus_resume_profile_picture)) echo $wpjobus_resume_profile_picture; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url" type="text" size="36" name="wpjobus_resume_profile_picture" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_profile_picture)) echo $wpjobus_resume_profile_picture; ?>" />
			                <input class="criteria-image-button-remove button" id="wpjobus_resume_profile_picture" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img" src="<?php if (!empty($wpjobus_resume_profile_picture)) echo $wpjobus_resume_profile_picture; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url" type="text" size="36" name="wpjobus_resume_profile_picture" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_profile_picture)) echo $wpjobus_resume_profile_picture; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </span>

			</div>

			<div class="option_item">

				<span class="full">
						<span class="text">Cover Image</span>

						<span>

						<?php if(!empty($wpjobus_resume_cover_image)) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img" src="<?php if (!empty($wpjobus_resume_cover_image)) echo $wpjobus_resume_cover_image; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url" type="text" size="36" name="wpjobus_resume_cover_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_cover_image)) echo $wpjobus_resume_cover_image; ?>" />
			                <input class="criteria-image-button-remove button" id="wpjobus_resume_cover_image" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img" src="<?php if (!empty($wpjobus_resume_cover_image)) echo $wpjobus_resume_cover_image; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>2" type="text" size="36" name="wpjobus_resume_cover_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_cover_image)) echo $wpjobus_resume_cover_image; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </span>

			</div>


			<div class="option_item">

				<span class="full">
						<span class="text">CV File (PDF, doc, docx)</span>

						<span>

						<?php if(!empty($wpjobus_resume_file)) { ?>

			                <span class="file-name" style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><?php echo $wpjobus_resume_file_name; ?></span>
			                <input class="criteria-image-url" type="text" size="36" name="wpjobus_resume_file" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_file)) echo $wpjobus_resume_file; ?>" />
			                <input class="criteria-image-url-name" type="text" size="36" name="wpjobus_resume_file_name" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_file_name)) echo $wpjobus_resume_file_name; ?>" />
			                <input class="criteria-file-remove button" id="wpjobus_resume_file" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>
			                <input class="criteria-file button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload File" /> </br>

			            <?php } else { ?>

			                <span class="file-name" style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"></span>
			                <input class="criteria-image-url" type="text" size="36" name="wpjobus_resume_file" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-image-url-name" type="text" size="36" name="wpjobus_resume_file_name" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-file-remove button" id="your_image_url_button_remove" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>
			                <input class="criteria-file button" id="your_image_url_button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload File" /> </br>
			                

			            <?php } ?>

			            <script>
				            var image_custom_uploader_file;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-file', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader_file = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose File',
				                    button: {
				                        text: 'Choose File'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader_file.on('select', function() {
				                    attachment = image_custom_uploader_file.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    var filename ='';
				                    filename = attachment['filename'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find('.criteria-image-url-name').val(filename);
				                    $thisItem.parent().find('.file-name').text(filename);
				                    $thisItem.parent().find('.criteria-file').css("display", "none");
				                    $thisItem.parent().find('.criteria-file-remove').css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader_file.open();
				             });

				             jQuery(document).on('click','.criteria-file-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find('.criteria-image-url-name').val('');
				                jQuery(this).parent().find('.file-name').empty();
				                jQuery(this).parent().find('.criteria-file').css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </span>

			</div>

			<br>

		</div>	<!-- end review_options_pop -->


		<?php

		}

		// Ingredients Post Meta //


		function display_wpjobus_resume_skills_settings ($post) {
		//get the post meta data

			$wpjobus_resume_prof_title = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_prof_title',true));
			$resume_career_level = esc_attr(get_post_meta($post->ID, 'resume_career_level',true));

			$wpjobus_resume_comm_level = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_comm_level',true));
			$wpjobus_resume_comm_note = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_comm_note',true));

			$wpjobus_resume_org_level = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_org_level',true));
			$wpjobus_resume_org_note = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_org_note',true));

			$wpjobus_resume_job_rel_level = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_job_rel_level',true));
			$wpjobus_resume_job_rel_note = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_job_rel_note',true));

			$wpjobus_resume_skills = get_post_meta($post->ID, 'wpjobus_resume_skills',true);

			$wpjobus_resume_native_language = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_native_language',true));

			$wpjobus_resume_languages = get_post_meta($post->ID, 'wpjobus_resume_languages',true);

			$wpjobus_resume_hobbies = esc_attr(get_post_meta($post->ID, 'wpjobus_resume_hobbies',true));

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Profesional Title:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_prof_title' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_prof_title; ?>' placeholder="" />
				
			</div>
		
			<div class="option_item">	

				<div class="full">

					<span class='text overall'>Career Level:</span>

					<div style="float: left;">
						<select name="resume_career_level" id="resume_career_level" style="width: 260px; margin-right: 10px;">
							<?php 
								global $redux_demo; 
								for ($i = 0; $i < count($redux_demo['resume_career_level']); $i++) {
							?>
							<option value='<?php echo $redux_demo['resume_career_level'][$i]; ?>' <?php selected( $resume_career_level, $redux_demo["resume_career_level"][$i] ); ?>><?php echo $redux_demo['resume_career_level'][$i]; ?></option>

							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Communication level:</span>
					<input type='text' id="review-name" class='' name='wpjobus_resume_comm_level' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_comm_level; ?>' placeholder="70%" />
					<span class="info-text" style="margin-left: 0;">%(1 to 100 value)</span>
				</span>
				
			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Communication notes:</span>
					<textarea class="recipe-desc" name="wpjobus_resume_comm_note" id='wpjobus_resume_comm_note' cols="70" rows="7" ><?php echo $wpjobus_resume_comm_note; ?></textarea>
				</span>
				
			</div>


			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Organisational level:</span>
					<input type='text' id="review-name" class='' name='wpjobus_resume_org_level' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_org_level; ?>' placeholder="70%" />
					<span class="info-text" style="margin-left: 0;">%(1 to 100 value)</span>
				</span>
				
			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Organisational notes:</span>
					<textarea class="recipe-desc" name="wpjobus_resume_org_note" id='wpjobus_resume_org_note' cols="70" rows="7" ><?php echo $wpjobus_resume_org_note; ?></textarea>
				</span>
				
			</div>


			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Job Related level:</span>
					<input type='text' id="review-name" class='' name='wpjobus_resume_job_rel_level' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_job_rel_level; ?>' placeholder="70%" />
					<span class="info-text" style="margin-left: 0;">%(1 to 100 value)</span>
				</span>
				
			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Job Related notes:</span>
					<textarea class="recipe-desc" name="wpjobus_resume_job_rel_note" id='wpjobus_resume_job_rel_note' cols="70" rows="7" ><?php echo $wpjobus_resume_job_rel_note; ?></textarea>
				</span>
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text'>Skills</span>
				
			</div>

			<div id="review_criteria">
				<?php 
					for ($i = 0; $i < (count($wpjobus_resume_skills)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Skill <?php echo ($i+1); ?></span>
					<input type='text' id='wpjobus_resume_skills[<?php echo $i; ?>][0]' name='wpjobus_resume_skills[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_skills[$i][0])) echo $wpjobus_resume_skills[$i][0]; ?>' class='criteria_name' placeholder="Title">
					<input type='text' id='wpjobus_resume_skills[<?php echo $i; ?>][1]' name='wpjobus_resume_skills[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_skills[$i][1])) {echo $wpjobus_resume_skills[$i][1];} else {echo 0;} ?>' class='slider_value' placeholder="70%">
					<button name="button_del_criteria" type="button" class="button-secondary button_del_criteria">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_criterion">
				
				<div class="option_item" id="999">
					<span class='text'>Skill 999</span>
					<input type='text' id='' name='' value='' class='criteria_name' placeholder="Title">
					<input type='text' id='' name='' value='' class='slider_value' placeholder="70%">
					<button name="button_del_criteria" type="button" class="button-secondary button_del_criteria">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_criteria" id='submit_add_criteria' value="add" class="button-secondary">Add new skill</button>
			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Native Language:</span>
					<input type='text' id="review-name" class='' name='wpjobus_resume_native_language' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_native_language; ?>' placeholder="" />
				</span>
				
			</div>

			<div id="resume_languages">
				<?php 
					for ($i = 0; $i < (count($wpjobus_resume_languages)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Language <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px;">

						<span class="text">Name</span>
						<input type='text' id="wpjobus_resume_languages[<?php echo $i; ?>][0]" class="resume_lang_title" name='wpjobus_resume_languages[<?php echo $i; ?>][0]' style="width: 300px; float: left;" value='<?php if (!empty($wpjobus_resume_languages[$i][0])) echo $wpjobus_resume_languages[$i][0]; ?>' placeholder="" />

					</div>

					<div class="full" style="margin-top: 20px;">

						<span class='text'>Understanding</span>
						<select class="resume_lang_understanding" name="wpjobus_resume_languages[<?php echo $i; ?>][1]" id="wpjobus_resume_languages[<?php echo $i; ?>][1]" style="width: 260px; margin-right: 10px;">
							<option value='Level 1' <?php if(!empty($wpjobus_resume_languages[$i][1])) { selected( $wpjobus_resume_languages[$i][1], "Level 1" ); } ?>>Level 1</option>
							<option value='Level 2' <?php if(!empty($wpjobus_resume_languages[$i][1])) { selected( $wpjobus_resume_languages[$i][1], "Level 2" ); } ?>>Level 2</option>
							<option value='Level 3' <?php if(!empty($wpjobus_resume_languages[$i][1])) { selected( $wpjobus_resume_languages[$i][1], "Level 3" ); } ?>>Level 3</option>
							<option value='Level 4' <?php if(!empty($wpjobus_resume_languages[$i][1])) { selected( $wpjobus_resume_languages[$i][1], "Level 4" ); } ?>>Level 4</option>
							<option value='Level 5' <?php if(!empty($wpjobus_resume_languages[$i][1])) { selected( $wpjobus_resume_languages[$i][1], "Level 5" ); } ?>>Level 5</option>
						</select>

					</div>

					<div class="full" style="margin-top: 20px;">

						<span class='text'>Speaking</span>
						<select class="resume_lang_speaking" name="wpjobus_resume_languages[<?php echo $i; ?>][2]" id="wpjobus_resume_languages[<?php echo $i; ?>][2]" style="width: 260px; margin-right: 10px;">
							<option value='Level 1' <?php if(!empty($wpjobus_resume_languages[$i][2])) { selected( $wpjobus_resume_languages[$i][2], "Level 1" ); } ?>>Level 1</option>
							<option value='Level 2' <?php if(!empty($wpjobus_resume_languages[$i][2])) { selected( $wpjobus_resume_languages[$i][2], "Level 2" ); } ?>>Level 2</option>
							<option value='Level 3' <?php if(!empty($wpjobus_resume_languages[$i][2])) { selected( $wpjobus_resume_languages[$i][2], "Level 3" ); } ?>>Level 3</option>
							<option value='Level 4' <?php if(!empty($wpjobus_resume_languages[$i][2])) { selected( $wpjobus_resume_languages[$i][2], "Level 4" ); } ?>>Level 4</option>
							<option value='Level 5' <?php if(!empty($wpjobus_resume_languages[$i][2])) { selected( $wpjobus_resume_languages[$i][2], "Level 5" ); } ?>>Level 5</option>
						</select>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class='text'>Writing</span>
						<select class="resume_lang_writing" name="wpjobus_resume_languages[<?php echo $i; ?>][3]" id="wpjobus_resume_languages[<?php echo $i; ?>][3]" style="width: 260px; margin-right: 10px;">
							<option value='Level 1' <?php if(!empty($wpjobus_resume_languages[$i][3])) { selected( $wpjobus_resume_languages[$i][3], "Level 1" ); } ?>>Level 1</option>
							<option value='Level 2' <?php if(!empty($wpjobus_resume_languages[$i][3])) { selected( $wpjobus_resume_languages[$i][3], "Level 2" ); } ?>>Level 2</option>
							<option value='Level 3' <?php if(!empty($wpjobus_resume_languages[$i][3])) { selected( $wpjobus_resume_languages[$i][3], "Level 3" ); } ?>>Level 3</option>
							<option value='Level 4' <?php if(!empty($wpjobus_resume_languages[$i][3])) { selected( $wpjobus_resume_languages[$i][3], "Level 4" ); } ?>>Level 4</option>
							<option value='Level 5' <?php if(!empty($wpjobus_resume_languages[$i][3])) { selected( $wpjobus_resume_languages[$i][3], "Level 5" ); } ?>>Level 5</option>
						</select>

					</div>

					<button name="button_del_language" type="button" class="button-secondary button_del_language">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_language">
				
				<div class="option_item" id="999">
					<span class='text'>Language 999</span>

					<div class="full" style="margin-top: 20px;">

						<span class="text">Name:</span>
						<input type='text' id="" class="resume_lang_title" name='' style="width: 300px; float: left;" value='' placeholder="" />

					</div>
					
					<div class="full" style="margin-top: 20px;">

						<span class='text'>Understanding</span>
						<select name="" id="" style="width: 260px; margin-right: 10px;" class="resume_lang_understanding">
							<option value='Level 1' >Level 1</option>
							<option value='Level 2' >Level 2</option>
							<option value='Level 3' >Level 3</option>
							<option value='Level 4' >Level 4</option>
							<option value='Level 5' >Level 5</option>
						</select>

					</div>

					<div class="full" style="margin-top: 20px;">

						<span class='text'>Speaking</span>
						<select name="" id="" style="width: 260px; margin-right: 10px;" class="resume_lang_speaking">
							<option value='Level 1' >Level 1</option>
							<option value='Level 2' >Level 2</option>
							<option value='Level 3' >Level 3</option>
							<option value='Level 4' >Level 4</option>
							<option value='Level 5' >Level 5</option>
						</select>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class='text'>Writing</span>
						<select name="" id="" style="width: 260px; margin-right: 10px;">
							<option value='Level 1' >Level 1</option>
							<option value='Level 2' >Level 2</option>
							<option value='Level 3' >Level 3</option>
							<option value='Level 4' >Level 4</option>
							<option value='Level 5' >Level 5</option>
						</select>

					</div>

					<button name="button_del_language" type="button" class="button-secondary button_del_language">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_language" id='submit_add_language' value="add" class="button-secondary">Add new language</button>
			</div>

			<div class="option_item">
				
				<span class='full'>	
					<span class="text">Hobbies:</span>
					<input type='text' id="review-name" class='' name='wpjobus_resume_hobbies' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_hobbies; ?>' placeholder="" />
					<span class="info-text" style="margin-left: 0;">Insert multiple hobbies and separate them using commas</span>
				</span>
				
			</div>

			<br>


		</div>	<!-- end review_options_pop -->



		<?php

		}

		function display_wpjobus_resume_education_settings ($post) {

			//get the post meta data
			$wpjobus_resume_education = get_post_meta($post->ID, 'wpjobus_resume_education',true);
			$wpjobus_resume_award = get_post_meta($post->ID, 'wpjobus_resume_award',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div id="resume_institution">
				<?php 
					for ($i = 0; $i < (count($wpjobus_resume_education)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Institution <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Institution Name:</span>
						<input type='text' id='wpjobus_resume_education[<?php echo $i; ?>][0]' name='wpjobus_resume_education[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_education[$i][0])) echo $wpjobus_resume_education[$i][0]; ?>' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Qualification & Faculty:</span>
						<input type='text' id='wpjobus_resume_education[<?php echo $i; ?>][1]' name='wpjobus_resume_education[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_education[$i][1])) echo $wpjobus_resume_education[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period from:</span>
						<input type='text' id='wpjobus_resume_education[<?php echo $i; ?>][2]' name='wpjobus_resume_education[<?php echo $i; ?>][2]' value='<?php if (!empty($wpjobus_resume_education[$i][2])) echo $wpjobus_resume_education[$i][2]; ?>' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period to:</span>
						<input type='text' id='wpjobus_resume_education[<?php echo $i; ?>][3]' name='wpjobus_resume_education[<?php echo $i; ?>][3]' value='<?php if (!empty($wpjobus_resume_education[$i][3])) echo $wpjobus_resume_education[$i][3]; ?>' class='criteria_to_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Location:</span>
						<input type='text' id='wpjobus_resume_education[<?php echo $i; ?>][4]' name='wpjobus_resume_education[<?php echo $i; ?>][4]' value='<?php if (!empty($wpjobus_resume_education[$i][4])) echo $wpjobus_resume_education[$i][4]; ?>' class='criteria_location' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Notes:</span>
						<textarea class="criteria_notes" name="wpjobus_resume_education[<?php echo $i; ?>][5]" id='wpjobus_resume_education[<?php echo $i; ?>][5]' cols="70" rows="7" ><?php if (!empty($wpjobus_resume_education[$i][5])) echo $wpjobus_resume_education[$i][5]; ?></textarea>

					</div>

					<button name="button_del_institution" type="button" class="button-secondary button_del_institution">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_education">
				
				<div class="option_item" id="999">
					<span class='text'>Institution 999</span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Institution Name:</span>
						<input type='text' id='' name='' value='' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Qualification & Faculty:</span>
						<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period from:</span>
						<input type='text' id='' name='' value='' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period to:</span>
						<input type='text' id='' name='' value='' class='criteria_to_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Location:</span>
						<input type='text' id='' name='' value='' class='criteria_location' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Notes:</span>
						<textarea class="criteria_notes" name="" id='' cols="70" rows="7" ></textarea>

					</div>

					<button name="button_del_institution" type="button" class="button-secondary button_del_institution">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_institution" id='submit_add_institution' value="add" class="button-secondary">Add new institution</button>
			</div>




			<div id="resume_award">
				<?php 
					for ($i = 0; $i < (count($wpjobus_resume_award)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Award <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Prize:</span>
						<input type='text' id='wpjobus_resume_award[<?php echo $i; ?>][0]' name='wpjobus_resume_award[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_award[$i][0])) echo $wpjobus_resume_award[$i][0]; ?>' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Competition Name:</span>
						<input type='text' id='wpjobus_resume_award[<?php echo $i; ?>][1]' name='wpjobus_resume_award[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_award[$i][1])) echo $wpjobus_resume_award[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Year:</span>
						<input type='text' id='wpjobus_resume_award[<?php echo $i; ?>][2]' name='wpjobus_resume_award[<?php echo $i; ?>][2]' value='<?php if (!empty($wpjobus_resume_award[$i][2])) echo $wpjobus_resume_award[$i][2]; ?>' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Location:</span>
						<input type='text' id='wpjobus_resume_award[<?php echo $i; ?>][3]' name='wpjobus_resume_award[<?php echo $i; ?>][3]' value='<?php if (!empty($wpjobus_resume_award[$i][3])) echo $wpjobus_resume_award[$i][3]; ?>' class='criteria_location' placeholder="" style="width: 400px;">

					</div>

					<button name="button_del_award" type="button" class="button-secondary button_del_award">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_award">
				
				<div class="option_item" id="999">
					<span class='text'>Award 999</span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Prize:</span>
						<input type='text' id='' name='' value='' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Competition Name:</span>
						<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Year:</span>
						<input type='text' id='' name='' value='' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Location:</span>
						<input type='text' id='' name='' value='' class='criteria_location' placeholder="" style="width: 400px;">

					</div>

					<button name="button_del_award" type="button" class="button-secondary button_del_award">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_award" id='submit_add_award' value="add" class="button-secondary">Add new award</button>
			</div>


			<br>


		</div>	<!-- end review_options_pop -->



		<?php

		}

		function display_wpjobus_resume_work_settings ($post) {

			//get the post meta data
			$wpjobus_resume_work = get_post_meta($post->ID, 'wpjobus_resume_work',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div id="resume_work">
				<?php 
					for ($i = 0; $i < (count($wpjobus_resume_work)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Work Experience <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Organisation Name:</span>
						<input type='text' id='wpjobus_resume_work[<?php echo $i; ?>][0]' name='wpjobus_resume_work[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_work[$i][0])) echo $wpjobus_resume_work[$i][0]; ?>' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Job Position:</span>
						<input type='text' id='wpjobus_resume_work[<?php echo $i; ?>][1]' name='wpjobus_resume_work[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_work[$i][1])) echo $wpjobus_resume_work[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period from:</span>
						<input type='text' id='wpjobus_resume_work[<?php echo $i; ?>][2]' name='wpjobus_resume_work[<?php echo $i; ?>][2]' value='<?php if (!empty($wpjobus_resume_work[$i][2])) echo $wpjobus_resume_work[$i][2]; ?>' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period to:</span>
						<input type='text' id='wpjobus_resume_work[<?php echo $i; ?>][3]' name='wpjobus_resume_work[<?php echo $i; ?>][3]' value='<?php if (!empty($wpjobus_resume_work[$i][3])) echo $wpjobus_resume_work[$i][3]; ?>' class='criteria_to_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Job type:</span>
						<select class="resume_work_job_type" name="wpjobus_resume_work[<?php echo $i; ?>][4]" id="wpjobus_resume_work[<?php echo $i; ?>][4]" style="width: 260px; margin-right: 10px;">
							<?php 
								global $redux_demo; 
								for ($q = 0; $q < count($redux_demo['job-type']); $q++) {
							?>
								<option value='<?php echo $redux_demo['job-type'][$q]; ?>' <?php if(!empty($wpjobus_resume_work[$i][4])) { selected( $wpjobus_resume_work[$i][4], $redux_demo["job-type"][$q] ); } ?>><?php echo $redux_demo['job-type'][$q]; ?></option>
							<?php 
								}
							?>
						</select>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Notes:</span>
						<textarea class="criteria_notes" name="wpjobus_resume_work[<?php echo $i; ?>][5]" id='wpjobus_resume_work[<?php echo $i; ?>][5]' cols="70" rows="7" ><?php if (!empty($wpjobus_resume_work[$i][5])) echo $wpjobus_resume_work[$i][5]; ?></textarea>

					</div>

					<button name="button_del_work" type="button" class="button-secondary button_del_work">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_work">
				
				<div class="option_item" id="999">
					<span class='text'>Work Experience 999</span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Organisation Name:</span>
						<input type='text' id='' name='' value='' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Job Position:</span>
						<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period from:</span>
						<input type='text' id='' name='' value='' class='criteria_from_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Period to:</span>
						<input type='text' id='' name='' value='' class='criteria_to_time' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Job type:</span>
						<select class="resume_work_job_type" name="" id="" style="width: 260px; margin-right: 10px;">
							<?php 
								global $redux_demo; 
								for ($q = 0; $q < count($redux_demo['job-type']); $q++) {
							?>
								<option value='<?php echo $redux_demo['job-type'][$q]; ?>' <?php if(!empty($wpjobus_resume_work[$i][4])) { selected( $wpjobus_resume_work[$i][4], $redux_demo["job-type"][$q] ); } ?>><?php echo $redux_demo['job-type'][$q]; ?></option>
							<?php 
								}
							?>
						</select>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Notes:</span>
						<textarea class="criteria_notes" name="" id='' cols="70" rows="7" ></textarea>

					</div>

					<button name="button_del_work" type="button" class="button-secondary button_del_work">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_work" id='submit_add_work' value="add" class="button-secondary">Add new work epxerience</button>
			</div>


			<br>


		</div>	<!-- end review_options_pop -->






		<?php

		}

		function display_wpjobus_resume_testimonials_settings ($post) {

			//get the post meta data
			$wpjobus_resume_testimonials = get_post_meta($post->ID, 'wpjobus_resume_testimonials',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div id="resume_testimonials">

				<?php 

					for ($i = 0; $i < (count($wpjobus_resume_testimonials)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Testimonial <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Full Name:</span>
						<input type='text' id='wpjobus_resume_testimonials[<?php echo $i; ?>][0]' name='wpjobus_resume_testimonials[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_testimonials[$i][0])) echo $wpjobus_resume_testimonials[$i][0]; ?>' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Organisation:</span>
						<input type='text' id='wpjobus_resume_testimonials[<?php echo $i; ?>][1]' name='wpjobus_resume_testimonials[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_testimonials[$i][1])) echo $wpjobus_resume_testimonials[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Testimonial:</span>
						<textarea class="criteria_notes" name="wpjobus_resume_testimonials[<?php echo $i; ?>][2]" id='wpjobus_resume_testimonials[<?php echo $i; ?>][2]' cols="70" rows="7" ><?php if (!empty($wpjobus_resume_testimonials[$i][2])) echo $wpjobus_resume_testimonials[$i][2]; ?></textarea>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">
						<span class="text">Image:</span>

						<span>

						<?php if(!empty($wpjobus_resume_testimonials[$i][3])) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="<?php if (!empty($wpjobus_resume_testimonials[$i][3])) echo $wpjobus_resume_testimonials[$i][3]; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="wpjobus_resume_testimonials[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_testimonials[$i][3])) echo $wpjobus_resume_testimonials[$i][3]; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="<?php if (!empty($wpjobus_resume_testimonials[$i][3])) echo $wpjobus_resume_testimonials[$i][3]; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="wpjobus_resume_testimonials[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_testimonials[$i][3])) echo $wpjobus_resume_testimonials[$i][3]; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </div>

					<button name="button_del_testimonial" type="button" class="button-secondary button_del_testimonial">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_testimonials">
				
				<div class="option_item" id="999">
					<span class='text'>Testimonial 999</span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Full Name:</span>
						<input type='text' id='' name='' value='' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Organisation:</span>
						<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 400px;">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Testimonial:</span>
						<textarea class="criteria_notes" name="" id='' cols="70" rows="7" ></textarea>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">
						<span class="text">Image:</span>

						<span>

						<?php if(!empty($wpjobus_resume_testimonials[$i][3])) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="" src="" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-image-button-remove button" id="" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </div>

					<button name="button_del_testimonial" type="button" class="button-secondary button_del_testimonial">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_testimonial" id='submit_add_testimonial' value="add" class="button-secondary">Add new testimonial</button>
			</div>


			<br>


		</div>	<!-- end review_options_pop -->





		<?php

		}

		function display_wpjobus_resume_salary_settings ($post) {

			//get the post meta data
			$wpjobus_resume_remuneration = get_post_meta($post->ID, 'wpjobus_resume_remuneration',true);
			$wpjobus_resume_remuneration_per = get_post_meta($post->ID, 'wpjobus_resume_remuneration_per',true);

			$wpjobus_resume_job_type = get_post_meta($post->ID, 'wpjobus_resume_job_type',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall' style="width: 200px;">Remuneration Amount:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_remuneration' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_remuneration; ?>' placeholder="" />
				
			</div>

			<div class="option_item">

				<div class="full">

					<span class='text overall' style="width: 200px;">Per:</span>

					<div style="float: left;">
						<select name="wpjobus_resume_remuneration_per" id="wpjobus_resume_remuneration_per" style="width: 260px;">
							<?php 
								global $redux_demo; 
								for ($i = 0; $i < count($redux_demo['job-remuneration-per']); $i++) {
							?>
							<option value='<?php echo $redux_demo['job-remuneration-per'][$i]; ?>' <?php selected( $wpjobus_resume_remuneration_per, $redux_demo["job-remuneration-per"][$i] ); ?>><?php echo $redux_demo['job-remuneration-per'][$i]; ?></option>
							<?php 
								}
							?>
						</select>
					</div>

				</div>

			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall' style="width: 200px;">Job Types:</span>

				<?php 
					global $redux_demo; 
					for ($i = 0; $i < count($redux_demo['job-type']); $i++) {
				?>

				<span style="margin-right: 20px; float: left;">
					<input type="hidden" class='' name='wpjobus_resume_job_type[<?php echo $i; ?>][0]' value='<?php echo $i; ?>'/>
					<input type="checkbox" class='' name='wpjobus_resume_job_type[<?php echo $i; ?>][1]' style="width: 10px; margin-right: 5px; float: left; margin-top: 7px; margin-bottom: 10px;" value='<?php echo $redux_demo['job-type'][$i]; ?>' placeholder="" <?php if (!empty($wpjobus_resume_job_type[$i][1])) { ?>checked<?php } ?>/><?php echo $redux_demo['job-type'][$i]; ?>
				</span>

				<?php 
					}
				?>
				
			</div>

			<br>


		</div>	<!-- end review_options_pop -->




		<?php

		}

		function display_wpjobus_resume_portfolio_settings ($post) {

			//get the post meta data
			$wpjobus_resume_portfolio = get_post_meta($post->ID, 'wpjobus_resume_portfolio',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div id="resume_portfolio">

				<?php 

					for ($i = 0; $i < (count($wpjobus_resume_portfolio)); $i++) {
				?>
				
				<div class="option_item" id="<?php echo $i; ?>">
					
					<span class='text'>Project <?php echo ($i+1); ?></span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Name:</span>
						<input type='text' id='wpjobus_resume_portfolio[<?php echo $i; ?>][0]' name='wpjobus_resume_portfolio[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_resume_portfolio[$i][0])) echo $wpjobus_resume_portfolio[$i][0]; ?>' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Category:</span>
						<input type='text' id='wpjobus_resume_portfolio[<?php echo $i; ?>][1]' name='wpjobus_resume_portfolio[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_resume_portfolio[$i][1])) echo $wpjobus_resume_portfolio[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 400px;">
						<span class="info-text" style="margin-left: 0;">You can leave it empty</span>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Note:</span>
						<textarea class="criteria_notes" name="wpjobus_resume_portfolio[<?php echo $i; ?>][2]" id='wpjobus_resume_portfolio[<?php echo $i; ?>][2]' cols="70" rows="7" ><?php if (!empty($wpjobus_resume_portfolio[$i][2])) echo $wpjobus_resume_portfolio[$i][2]; ?></textarea>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">
						<span class="text">Image:</span>

						<span>

						<?php if(!empty($wpjobus_resume_portfolio[$i][3])) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="<?php if (!empty($wpjobus_resume_portfolio[$i][3])) echo $wpjobus_resume_portfolio[$i][3]; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="wpjobus_resume_portfolio[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_portfolio[$i][3])) echo $wpjobus_resume_portfolio[$i][3]; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="<?php if (!empty($wpjobus_resume_portfolio[$i][3])) echo $wpjobus_resume_portfolio[$i][3]; ?>" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="wpjobus_resume_portfolio[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_resume_portfolio[$i][3])) echo $wpjobus_resume_portfolio[$i][3]; ?>" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </div>

					<button name="button_del_portfolio" type="button" class="button-secondary button_del_portfolio">delete</button>
					
				</div>
				
				<?php 
					}
				?>


			</div>

			<div id="template_portfolio">
				
				<div class="option_item" id="999">
					<span class='text'>Project 999</span>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Name:</span>
						<input type='text' id='' name='' value='' class='criteria_name' placeholder="">

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Category:</span>
						<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 400px;">
						<span class="info-text" style="margin-left: 0;">You can leave it empty</span>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">

						<span class="text">Note:</span>
						<textarea class="criteria_notes" name="" id='' cols="70" rows="7" ></textarea>

					</div>

					<div class="full" style="margin-top: 20px; margin-bottom: 20px;">
						<span class="text">Image:</span>

						<span>

						<?php if(!empty($wpjobus_resume_testimonials[$i][3])) { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="" src="" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-image-button-remove button" id="" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>

			            <?php } else { ?>

			                <div style="width: 90%; width: -webkit-calc(100% - 120px); width: calc(100% - 120px);  float: left;"><img class="criteria-image" id="your_image_url_img<?php echo $i; ?>3" src="" style="float: left; margin-bottom: 20px;" /> </div>
			                <input class="criteria-image-url" id="your_image_url<?php echo $i; ?>3" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
			                <input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px; margin-left: 112px; display: none;" value="Remove" /> </br>
			                <input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>3" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>

			            <?php } ?>

			            <script>
				            var image_custom_uploader;
				            var $thisItem = '';

				            jQuery(document).on('click','.criteria-image-button', function(e) {
				                e.preventDefault();

				                $thisItem = jQuery(this);

				                //If the uploader object has already been created, reopen the dialog
				                if (image_custom_uploader) {
				                    image_custom_uploader.open();
				                    return;
				                }

				                //Extend the wp.media object
				                image_custom_uploader = wp.media.frames.file_frame = wp.media({
				                    title: 'Choose Image',
				                    button: {
				                        text: 'Choose Image'
				                    },
				                    multiple: false
				                });

				                //When a file is selected, grab the URL and set it as the text field's value
				                image_custom_uploader.on('select', function() {
				                    attachment = image_custom_uploader.state().get('selection').first().toJSON();
				                    var url = '';
				                    url = attachment['url'];
				                    $thisItem.parent().find('.criteria-image-url').val(url);
				                    $thisItem.parent().find( "img.criteria-image" ).attr({
				                        src: url
				                    });
				                    $thisItem.parent().find(".criteria-image-button").css("display", "none");
				                    $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
				                });

				                //Open the uploader dialog
				                image_custom_uploader.open();
				             });

				             jQuery(document).on('click','.criteria-image-button-remove', function(e) {
				                jQuery(this).parent().find('.criteria-image-url').val('');
				                jQuery(this).parent().find( "img.criteria-image" ).attr({
				                    src: ''
				                });
				                jQuery(this).parent().find(".criteria-image-button").css("display", "block");
				                jQuery(this).css("display", "none");
				             });
						</script>

			        	</span>

			        </div>

					<button name="button_del_portfolio" type="button" class="button-secondary button_del_portfolio">delete</button>
				</div>

			</div>

			<div class="option_item">
				<button type="button" name="submit_add_portfolio" id='submit_add_portfolio' value="add" class="button-secondary">Add new project</button>
			</div>

			

			<br>


		</div>	<!-- end review_options_pop -->





		<?php

		}

		function display_wpjobus_resume_contact_settings ($post) {

			//get the post meta data
			$wpjobus_resume_address = get_post_meta($post->ID, 'wpjobus_resume_address',true);
			$wpjobus_resume_phone = get_post_meta($post->ID, 'wpjobus_resume_phone',true);
			$wpjobus_resume_website = get_post_meta($post->ID, 'wpjobus_resume_website',true);
			$wpjobus_resume_email = get_post_meta($post->ID, 'wpjobus_resume_email',true);
			$wpjobus_resume_publish_email = get_post_meta($post->ID, 'wpjobus_resume_publish_email',true);
			$wpjobus_resume_facebook = get_post_meta($post->ID, 'wpjobus_resume_facebook',true);
			$wpjobus_resume_linkedin = get_post_meta($post->ID, 'wpjobus_resume_linkedin',true);
			$wpjobus_resume_twitter = get_post_meta($post->ID, 'wpjobus_resume_twitter',true);
			$wpjobus_resume_googleplus = get_post_meta($post->ID, 'wpjobus_resume_googleplus',true);

			$wpjobus_resume_googleaddress = get_post_meta($post->ID, 'wpjobus_resume_googleaddress',true);
			$wpjobus_resume_longitude = get_post_meta($post->ID, 'wpjobus_resume_longitude',true);
			$wpjobus_resume_latitude = get_post_meta($post->ID, 'wpjobus_resume_latitude',true);

		?>
		
		<input type="hidden" name="cmb_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

		<div id='review_options_popup'>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Address:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_address' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_address; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Phone number:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_phone' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_phone; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Website:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_website' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_website; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>E-mail:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_email' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_email; ?>' placeholder="" />

				<span style="margin-right: 20px; float: left;">
					<input type="checkbox" class='' name='wpjobus_resume_publish_email' style="width: 10px; margin-right: 5px; float: left; margin-top: 1px;" value='publish_email' placeholder="" <?php if (!empty($wpjobus_resume_publish_email)) { ?>checked<?php } ?>/>Publish my email address
				</span>
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Facebook:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_facebook' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_facebook; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>LinkedIn:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_linkedin' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_linkedin; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Twitter:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_twitter' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_twitter; ?>' placeholder="" />
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Google+:</span>

				<input type='text' id="review-name" class='' name='wpjobus_resume_googleplus' style="width: 300px; float: left;" value='<?php echo $wpjobus_resume_googleplus; ?>' placeholder="" />
				
			</div>



			<div id="map-container">

			<div class="option_item" style="height: 24px; margin-bottom: 20px;">
				
				<span class='text overall' style="width: 170px;">Google Map Address</span>

				<input id="address" name="wpjobus_resume_googleaddress" type="text" value="<?php echo $wpjobus_resume_googleaddress; ?>" style="width: 300px; float: left;">

				<p class="help-block"><?php _e('Start typing an address and select from the dropdown.', 'agrg') ?></p>
				
			</div>

				
				<div id="map-canvas"></div>

				<style>

					#map-canvas {
						display: block;
						width: 575px;
						height: 370px;
						position: relative;
						margin-bottom: 10px;
					}

				</style>

				<script type="text/javascript">

								jQuery(document).ready(function($) {

									var geocoder;
									var map;
									var marker;

									var geocoder = new google.maps.Geocoder();

									function geocodePosition(pos) {
									  geocoder.geocode({
									    latLng: pos
									  }, function(responses) {
									    if (responses && responses.length > 0) {
									      updateMarkerAddress(responses[0].formatted_address);
									    } else {
									      updateMarkerAddress('Cannot determine address at this location.');
									    }
									  });
									}

									function updateMarkerPosition(latLng) {
									  jQuery('#latitude').val(latLng.lat());
									  jQuery('#longitude').val(latLng.lng());
									}

									function updateMarkerAddress(str) {
									  jQuery('#address').val(str);
									}

									function initialize() {

									  var latlng = new google.maps.LatLng(<?php echo $wpjobus_resume_latitude; ?>, <?php echo $wpjobus_resume_longitude; ?>);
									  var mapOptions = {
									    zoom: 16,
									    center: latlng
									  }

									  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

									  geocoder = new google.maps.Geocoder();

									  marker = new google.maps.Marker({
									  	position: latlng,
									    map: map,
									    draggable: true
									  });

									  // Add dragging event listeners.
									  google.maps.event.addListener(marker, 'dragstart', function() {
									    updateMarkerAddress('Dragging...');
									  });
									  
									  google.maps.event.addListener(marker, 'drag', function() {
									    updateMarkerPosition(marker.getPosition());
									  });
									  
									  google.maps.event.addListener(marker, 'dragend', function() {
									    geocodePosition(marker.getPosition());
									  });

									}

									google.maps.event.addDomListener(window, 'load', initialize);

									jQuery(document).ready(function() { 
									         
									  initialize();
									          
									  jQuery(function() {
									    jQuery("#address").autocomplete({
									      //This bit uses the geocoder to fetch address values
									      source: function(request, response) {
									        geocoder.geocode( {'address': request.term }, function(results, status) {
									          response(jQuery.map(results, function(item) {
									            return {
									              label:  item.formatted_address,
									              value: item.formatted_address,
									              latitude: item.geometry.location.lat(),
									              longitude: item.geometry.location.lng()
									            }
									          }));
									        })
									      },
									      //This bit is executed upon selection of an address
									      select: function(event, ui) {
									        jQuery("#latitude").val(ui.item.latitude);
									        jQuery("#longitude").val(ui.item.longitude);

									        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);

									        marker.setPosition(location);
									        map.setZoom(16);
									        map.setCenter(location);

									      }
									    });
									  });
									  
									  //Add listener to marker for reverse geocoding
									  google.maps.event.addListener(marker, 'drag', function() {
									    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
									      if (status == google.maps.GeocoderStatus.OK) {
									        if (results[0]) {
									          jQuery('#address').val(results[0].formatted_address);
									          jQuery('#latitude').val(marker.getPosition().lat());
									          jQuery('#longitude').val(marker.getPosition().lng());
									        }
									      }
									    });
									  });
									  
									});

								});

				</script>

			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Latitude</span>

				<input type="text" id="latitude" name="wpjobus_resume_latitude" value="<?php echo $wpjobus_resume_latitude; ?>" size="12" maxlength="10" class="form-text required">
				
			</div>

			<div class="option_item" style="height: 24px;">
				
				<span class='text overall'>Longitude</span>

				<input type="text" id="longitude" name="wpjobus_resume_longitude" value="<?php echo $wpjobus_resume_longitude; ?>" size="12" maxlength="10" class="form-text required">
				
			</div>

			<br>


		</div>	<!-- end review_options_pop -->



		<?php


		}


	
		add_action ('save_post', 'update_wpjobus_post_settings');
		function update_wpjobus_post_settings ( $post_id ) {
		// verify nonce.  

		if (!isset($_POST['cmb_nonce'])) {
			return false;		
		}

		if (!wp_verify_nonce($_POST['cmb_nonce'], basename(__FILE__))) {
			return false;
		}

		global $allowed;

		//regular update		
		update_post_meta($post_id, 'wpjobus_resume_fullname', wp_kses($_POST['wpjobus_resume_fullname'], $allowed));
		update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['wpjobus_resume_fullname'], $allowed));
		update_post_meta($post_id, 'resume_gender', wp_kses($_POST['resume_gender'], $allowed));
		update_post_meta($post_id, 'resume_month_birth', wp_kses($_POST['resume_month_birth'], $allowed));
		update_post_meta($post_id, 'resume_day_birth', wp_kses($_POST['resume_day_birth'], $allowed));
		update_post_meta($post_id, 'resume_year_birth', wp_kses($_POST['resume_year_birth'], $allowed));
		update_post_meta($post_id, 'resume_years_of_exp', wp_kses($_POST['resume_years_of_exp'], $allowed));
		update_post_meta($post_id, 'resume_industry', wp_kses($_POST['resume_industry'], $allowed));
		update_post_meta($post_id, 'resume_location', wp_kses($_POST['resume_location'], $allowed));
		update_post_meta($post_id, 'resume-about-me', wp_kses($_POST['resume-about-me'], $allowed));
		update_post_meta($post_id, 'wpjobus_resume_profile_picture', wp_kses($_POST['wpjobus_resume_profile_picture'], $allowed));
		update_post_meta($post_id, 'wpjobus_resume_cover_image', wp_kses($_POST['wpjobus_resume_cover_image'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_prof_title', wp_kses($_POST['wpjobus_resume_prof_title'], $allowed));
		update_post_meta($post_id, 'resume_career_level', wp_kses($_POST['resume_career_level'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_comm_level', wp_kses($_POST['wpjobus_resume_comm_level'], $allowed));
		update_post_meta($post_id, 'wpjobus_resume_comm_note', wp_kses($_POST['wpjobus_resume_comm_note'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_org_level', wp_kses($_POST['wpjobus_resume_org_level'], $allowed));
		update_post_meta($post_id, 'wpjobus_resume_org_note', wp_kses($_POST['wpjobus_resume_org_note'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_job_rel_level', wp_kses($_POST['wpjobus_resume_job_rel_level'], $allowed));
		update_post_meta($post_id, 'wpjobus_resume_job_rel_note', wp_kses($_POST['wpjobus_resume_job_rel_note'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_skills', $_POST['wpjobus_resume_skills']);

		update_post_meta($post_id, 'wpjobus_resume_native_language', wp_kses($_POST['wpjobus_resume_native_language'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_languages', $_POST['wpjobus_resume_languages']);

		update_post_meta($post_id, 'wpjobus_resume_hobbies', wp_kses($_POST['wpjobus_resume_hobbies'], $allowed));

		update_post_meta($post_id, 'wpjobus_resume_education', $_POST['wpjobus_resume_education']);

		update_post_meta($post_id, 'wpjobus_resume_award', $_POST['wpjobus_resume_award']);

		update_post_meta($post_id, 'wpjobus_resume_work', $_POST['wpjobus_resume_work']);

		update_post_meta($post_id, 'wpjobus_resume_testimonials', $_POST['wpjobus_resume_testimonials']);

		update_post_meta($post_id, 'wpjobus_resume_file', $_POST['wpjobus_resume_file']);
		update_post_meta($post_id, 'wpjobus_resume_file_name', $_POST['wpjobus_resume_file_name']);

		update_post_meta($post_id, 'wpjobus_resume_remuneration', $_POST['wpjobus_resume_remuneration']);
		update_post_meta($post_id, 'wpjobus_resume_remuneration_per', $_POST['wpjobus_resume_remuneration_per']);

		$remuneration_ammount = $_POST['wpjobus_resume_remuneration'];
		$str = preg_replace('/\D/', '', $remuneration_ammount);
		update_post_meta($post_id, 'wpjobus_resume_remuneration_raw', $str);

		update_post_meta($post_id, 'wpjobus_resume_job_type', $_POST['wpjobus_resume_job_type']);

		update_post_meta($post_id, 'wpjobus_resume_portfolio', $_POST['wpjobus_resume_portfolio']);

		update_post_meta($post_id, 'wpjobus_resume_address', $_POST['wpjobus_resume_address']);
		update_post_meta($post_id, 'wpjobus_resume_phone', $_POST['wpjobus_resume_phone']);
		update_post_meta($post_id, 'wpjobus_resume_website', $_POST['wpjobus_resume_website']);
		update_post_meta($post_id, 'wpjobus_resume_email', $_POST['wpjobus_resume_email']);
		update_post_meta($post_id, 'wpjobus_resume_facebook', $_POST['wpjobus_resume_facebook']);
		update_post_meta($post_id, 'wpjobus_resume_linkedin', $_POST['wpjobus_resume_linkedin']);
		update_post_meta($post_id, 'wpjobus_resume_twitter', $_POST['wpjobus_resume_twitter']);
		update_post_meta($post_id, 'wpjobus_resume_googleplus', $_POST['wpjobus_resume_googleplus']);
		update_post_meta($post_id, 'wpjobus_resume_googleaddress', $_POST['wpjobus_resume_googleaddress']);
		update_post_meta($post_id, 'wpjobus_resume_longitude', $_POST['wpjobus_resume_longitude']);
		update_post_meta($post_id, 'wpjobus_resume_latitude', $_POST['wpjobus_resume_latitude']);

	}
