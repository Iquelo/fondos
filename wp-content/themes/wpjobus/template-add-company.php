<?php
/**
 * Template name: Add Company
 */

if ( !is_user_logged_in() ) { 

	$login = home_url()."/login";
	wp_redirect( $login ); exit;

} 

$page = get_page($post->ID);
$current_page_id = $page->ID;

$wpjobus_company_longitude = esc_attr(get_post_meta($post->ID, 'wpjobus_company_longitude',true));
if(empty($wpjobus_company_longitude)) {
	$wpjobus_company_longitude = 0;
}

$wpjobus_company_latitude = esc_attr(get_post_meta($post->ID, 'wpjobus_company_latitude',true));
if(empty($wpjobus_company_latitude)) {
	$wpjobus_company_latitude = 0;
}

get_header(); ?>

	<section id="blog">

		<div class="container">

			<div class="resume-skills">

				<form id="wpjobus-add-company" type="post" action="" >

					<h1 class="resume-section-title"><i class="fa fa-briefcase"></i><?php _e( 'Add Company Profile', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Hey. It’s easier than it looks. Take a deep breath and complete the fields below. You’ll have a beautifull company page!', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div class="one_half first">

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Company Name:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" name="fullName" id="fullName" value="" class="input-textarea" placeholder="" style="margin-bottom: 0;"/>
									<label for="fullName" class="error userNameError"></label>
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Tag Line:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" name="wpjobus_company_tagline" id="wpjobus_company_tagline" value="<?php global $wpjobus_company_tagline; echo $wpjobus_company_tagline; ?>" class="input-textarea" placeholder="" style="margin-bottom: 0;"/>
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Foundation Year:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" name="wpjobus_company_foundyear" id="wpjobus_company_foundyear" value="<?php global $wpjobus_company_foundyear; echo $wpjobus_company_foundyear; ?>" class="input-textarea" placeholder="" style="margin-bottom: 0;"/>
								</span>

							</span>

							<span class="full" style="margin-bottom: 0;">

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Team Size:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<select name="company_team_size" id="company_team_size" style="width: 100%; margin-right: 10px;">
										<?php 

											global $company_team_size;

											echo $company_team_size;

											for ($i = 1; $i <= 50; $i++) {
										?>
										<option value='<?php echo $i; ?>' <?php selected( $company_team_size, $i ); ?>><?php echo $i; ?></option>
										<?php 
											}
										?>
										<option value='50+' <?php selected( $company_team_size, "50+" ); ?>>50+</option>
									</select>
								</span>

							</span>

							<span class="full" style="margin-bottom: 0;">

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Category:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<select name="company_industry" id="company_industry" style="width: 100%; margin-right: 10px;">
										<?php 
											global $redux_demo, $resume_industry; 
											for ($i = 0; $i < count($redux_demo['resume-industries']); $i++) {
										?>
										<option value='<?php echo $redux_demo['resume-industries'][$i]; ?>' <?php selected( $resume_industry, $redux_demo["resume-industries"][$i] ); ?>><?php echo $redux_demo['resume-industries'][$i]; ?></option>
										<?php 
											}
										?>
									</select>
								</span>

							</span>

							<span class="full" style="margin-bottom: 0;">

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Location:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<select name="company_location" id="company_location" style="width: 100%; margin-right: 10px;">
										<?php 
											global $redux_demo, $resume_location; 
											for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
										?>
										<option value='<?php echo $redux_demo['resume-locations'][$i]; ?>' <?php selected( $resume_location, $redux_demo["resume-locations"][$i] ); ?>><?php echo $redux_demo['resume-locations'][$i]; ?></option>
										<?php 
											}
										?>
									</select>
								</span>

							</span>

						</div>

						<div class="one_half">

							<span class="full" style="margin-bottom: 0;">

								<span class="one_half first" style="margin-bottom: 0;">
									<h3><?php _e( 'Description:', 'agrg' ); ?></h3>
								</span>

							</span>

							<?php 

								global $postContent;
									
								$settings = array(
										'wpautop' => true,
										'postContent' => 'content',
										'media_buttons' => false,
										'editor_css' => '<style>.mceToolba { background-color: #faf9f4; padding: 5px; }</style>',
										'tinymce' => array(
											'theme_advanced_buttons1' => 'bold,italic,underline,blockquote,separator,strikethrough,bullist,numlist,justifyleft,justifycenter,justifyright,undo,redo,link,unlink,fullscreen',
											'theme_advanced_buttons2' => 'pastetext,pasteword,removeformat,|,charmap,|,outdent,indent,|,undo,redo',
											'theme_advanced_buttons3' => '',
											'theme_advanced_buttons4' => ''
										),
										'quicktags' => false
								);
											
								wp_editor( $postContent, 'postContent', $settings );

							?>

						</div>

					</div>

					<div class="full">

						<div class="one_half first">

							<span class="full" style="margin-bottom: 0;">

								<span class="full" style="margin-bottom: 0;">
									<h3><i class="fa fa-camera"></i><?php _e( 'Logo:', 'agrg' ); ?></h3>
								</span>

								<div style="width: 100%; float: left;">
									<img class="criteria-image" id="your_image_url_img" src="<?php if (!empty($wpjobus_company_profile_picture)) echo $wpjobus_company_profile_picture; ?>" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 340px;" /> 
								</div>
					            <input class="criteria-image-url" id="your_image_url" type="text" size="36" name="wpjobus_company_profile_picture" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_company_profile_picture)) echo $wpjobus_company_profile_picture; ?>" />
					            <input class="criteria-image-id" id="your_image_id" type="text" size="36" name="wpjobus_company_profile_picture_id" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_company_profile_picture_id)) echo $wpjobus_company_profile_picture_id; ?>" />
					            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove" type="button" value="Delete Image" /> </br>
					            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button" type="button" value="Upload Image" />

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
									        var attachId = '';
									        attachId = attachment['id'];
									        $thisItem.parent().find('.criteria-image-id').val(attachId);
									        $thisItem.parent().find('.criteria-image-url').val(url);
									        $thisItem.parent().find( "img.criteria-image" ).attr({
									            src: url
									        });
									        $thisItem.parent().find(".criteria-image-button").css("display", "none");
									        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
									        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
									        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
									    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
									    jQuery(this).css("display", "none");
									    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
									});
								</script>

							</span>

						</div>

						<div class="one_half">

							<span class="full" style="margin-bottom: 0;">

								<span class="full" style="margin-bottom: 0;">
									<h3><i class="fa fa-picture-o"></i><?php _e( 'Cover Image:', 'agrg' ); ?></h3>
								</span>

								<div style="width: 100%; float: left;">
									<img class="criteria-image" id="your_cover_url_img" src="<?php if (!empty($wpjobus_company_cover_image)) echo $wpjobus_company_cover_image; ?>" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 340px;" /> 
								</div>
					            <input class="criteria-image-url" id="your_icover_url" type="text" size="36" name="wpjobus_company_cover_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_company_cover_image)) echo $wpjobus_company_cover_image; ?>" />
					            <input class="criteria-image-id" id="your_cover_id" type="text" size="36" name="wpjobus_company_cover_image_id" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="<?php if (!empty($wpjobus_company_cover_image_id)) echo $wpjobus_company_cover_image_id; ?>" />
					            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>2" type="button" value="Delete Image" /> </br>
					            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>2" type="button" value="Upload Image" />

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
									        var attachId = '';
									        attachId = attachment['id'];
									        $thisItem.parent().find('.criteria-image-id').val(attachId);
									        $thisItem.parent().find('.criteria-image-url').val(url);
									        $thisItem.parent().find( "img.criteria-image" ).attr({
									            src: url
									        });
									        $thisItem.parent().find(".criteria-image-button").css("display", "none");
									        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
									        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
									        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
									    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
									    jQuery(this).css("display", "none");
									    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
									});
								</script>

							</span>

						</div>

						<div class="divider"></div>

					</div>

					<h1 class="resume-section-title"><i class="fa fa-bar-chart-o"></i><?php _e( 'Services', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Describe your services and expertise.', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div id="resume_service">
							<?php 

								$wpjobus_company_services = get_post_meta($post->ID, 'wpjobus_company_services',true);

								for ($i = 0; $i < (count($wpjobus_company_services)); $i++) {

							?>
							
							<div class="full option_item" id="<?php echo $i; ?>">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Service', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
									</span>
								</div>

								<span class="one_half first" style="margin-bottom: 0;">

									<div class="full">

										<span class="two_fifth first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Service Name', 'agrg' ); ?></h3>
										</span>

										<span class="three_fifth" style="margin-bottom: 0;">
											<input type='text' id="wpjobus_company_services[<?php echo $i; ?>][0]" class="criteria_name" name='wpjobus_company_services[<?php echo $i; ?>][0]' style="width: 100%; float: left;" value='<?php if (!empty($wpjobus_company_services[$i][0])) echo $wpjobus_company_services[$i][0]; ?>' placeholder="" />
										</span>

									</div>

									<div class="full" style="margin-bottom: 0;">

										<span class="two_fifth first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Icon code', 'agrg' ); ?></h3>
										</span>

										<span class="three_fifth" style="margin-bottom: 0;">
											<input type='text' id="wpjobus_company_services[<?php echo $i; ?>][1]" class="criteria_name_two" name='wpjobus_company_services[<?php echo $i; ?>][1]' style="width: 100%; float: left;" value='<?php if (!empty($wpjobus_company_services[$i][1])) echo $wpjobus_company_services[$i][1]; ?>' placeholder="" />
										</span>

									</div>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_fourth first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Content:', 'agrg' ); ?></h3>
									</span>

									<span class="three_fourth" style="margin-bottom: 0;">
										<textarea class="criteria_notes" name="wpjobus_company_services[<?php echo $i; ?>][2]" id='wpjobus_company_services[<?php echo $i; ?>][2]' cols="70" rows="5" ><?php if (!empty($wpjobus_company_services[$i][2])) echo $wpjobus_company_services[$i][2]; ?></textarea>
									</span>

								</span>

								<button name="button_del_service" type="button" class="button-secondary button_del_service"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
								
							</div>
							
							<?php 
								}
							?>


						</div>

						<div id="template_service">
							
							<div class="full option_item" id="999">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Service', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
									</span>
								</div>

								<span class="one_half first" style="margin-bottom: 0;">

									<div class="full">

										<span class="two_fifth first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Service Name', 'agrg' ); ?></h3>
										</span>

										<span class="three_fifth" style="margin-bottom: 0;">
											<input type='text' id="" class="criteria_name" name='' style="width: 100%; float: left;" value='' placeholder="" />
										</span>

									</div>

									<div class="full" style="margin-bottom: 0;">

										<span class="two_fifth first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Icon code', 'agrg' ); ?></h3>
										</span>

										<span class="three_fifth" style="margin-bottom: 0;">
											<input type='text' id="" class="criteria_name_two" name='' style="width: 100%; float: left;" value='' placeholder="" />
										</span>

									</div>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_fourth first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Content:', 'agrg' ); ?></h3>
									</span>

									<span class="three_fourth" style="margin-bottom: 0;">
										<textarea class="criteria_notes" name="" id='' cols="70" rows="5" ></textarea>
									</span>

								</span>

								<button name="button_del_service" type="button" class="button-secondary button_del_service"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
							</div>

						</div>

						<div class="option_item">
							<button type="button" name="submit_add_service" id='submit_add_service' value="add" class="button-secondary"><i class="fa fa-plus-circle"></i><?php _e( 'Add new service', 'agrg' ); ?></button>
						</div>

						<div class="divider"></div>

					</div>

					<div class="full" style="margin-bottom: 0;">

						<div class="one_fifth first">

							<h3 class="skill-item-title"><?php _e( 'Expertise:', 'agrg' ); ?></h3>

						</div>

						<div class="four_fifth">

							<input type='text' id="review-name" class='' name='wpjobus_company_expertise' style="width: 100%; float: left; margin-bottom: 0;" value='<?php global $wpjobus_company_expertise; echo $wpjobus_company_expertise; ?>' placeholder="" />
							<span class="info-text" style="margin-left: 0;"><?php _e( 'Insert multiple expertise and separate them using commas', 'agrg' ); ?></span>

						</div>

						<div class="divider" style="margin-top: 20px;"></div>

					</div>

					<h1 class="resume-section-title"><i class="fa fa-building"></i><?php _e( 'Clients', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Name a few relevant clients from your portfolio and describe what your company was contracted for.', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div id="resume_clients">
							<?php 

								$wpjobus_company_clients = get_post_meta($post->ID, 'wpjobus_company_clients',true);

								for ($i = 0; $i < (count($wpjobus_company_clients)); $i++) {

							?>
							
							<div class="full option_item" id="<?php echo $i; ?>">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Client', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
									</span>
								</div>

								<span class="one_half first"  style="margin-bottom: 0;">

									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Client Name', 'agrg' ); ?></h3>
									</span>

									<span class="one_half" style="margin-bottom: 0;">
										<input type='text' id="wpjobus_company_clients[<?php echo $i; ?>][0]" class="criteria_name" name='wpjobus_company_clients[<?php echo $i; ?>][0]' style="width: 100%; float: left;" value='<?php if (!empty($wpjobus_company_clients[$i][0])) echo $wpjobus_company_clients[$i][0]; ?>' placeholder="" />
									</span>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Contracted for doing:', 'agrg' ); ?></h3>
									</span>

									<span class="one_half" style="margin-bottom: 0;">
										<input type='text' id='wpjobus_company_clients[<?php echo $i; ?>][1]' name='wpjobus_company_clients[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_company_clients[$i][1])) echo $wpjobus_company_clients[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 100%;">
									</span>

								</span>

								<span class="one_half first"  style="margin-bottom: 0;">

									<span class="full"  style="margin-bottom: 0;">

										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Period:', 'agrg' ); ?></h3>
										</span>

										<span class="one_half" style="margin-bottom: 0;">
											<input type='text' id='wpjobus_company_clients[<?php echo $i; ?>][2]' name='wpjobus_company_clients[<?php echo $i; ?>][2]' value='<?php if (!empty($wpjobus_company_clients[$i][2])) echo $wpjobus_company_clients[$i][2]; ?>' class='criteria_from_time' placeholder="" style="width: 40%"> <span style="float: left; margin: 10px;">-</span> <input type='text' id='wpjobus_company_clients[<?php echo $i; ?>][3]' name='wpjobus_company_clients[<?php echo $i; ?>][3]' value='<?php if (!empty($wpjobus_company_clients[$i][3])) echo $wpjobus_company_clients[$i][3]; ?>' class='criteria_to_time' placeholder="" style="width: 40%">
										</span>

									</span>

									<span class="full"  style="margin-bottom: 0;">

										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Client’s Website:', 'agrg' ); ?></h3>
										</span>

										<span class="one_half" style="margin-bottom: 0;">
											<input type='text' id='wpjobus_company_clients[<?php echo $i; ?>][4]' name='wpjobus_company_clients[<?php echo $i; ?>][4]' value='<?php if (!empty($wpjobus_company_clients[$i][4])) echo $wpjobus_company_clients[$i][4]; ?>' class='criteria_location' placeholder="" style="width: 100%;">
										</span>

									</span>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_fourth first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Notes:', 'agrg' ); ?></h3>
									</span>

									<span class="three_fourth" style="margin-bottom: 0;">
										<textarea class="criteria_notes" name="wpjobus_company_clients[<?php echo $i; ?>][5]" id='wpjobus_company_clients[<?php echo $i; ?>][5]' cols="70" rows="4" ><?php if (!empty($wpjobus_company_clients[$i][5])) echo $wpjobus_company_clients[$i][5]; ?></textarea>
									</span>

								</span>

								<button name="button_del_client" type="button" class="button-secondary button_del_client"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
								
							</div>
							
							<?php 
								}
							?>


						</div>

						<div id="template_clients">
							
							<div class="full option_item" id="999">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Client', 'agrg' ); ?> <span class="num">999</span></h3>
									</span>
								</div>

								<span class="one_half first"  style="margin-bottom: 0;">

									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Client Name', 'agrg' ); ?></h3>
									</span>

									<span class="one_half" style="margin-bottom: 0;">
										<input type='text' id="" class="criteria_name" name='' style="width: 100%; float: left;" value='' placeholder="" />
									</span>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Contracted for doing:', 'agrg' ); ?></h3>
									</span>

									<span class="one_half" style="margin-bottom: 0;">
										<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 100%;">
									</span>

								</span>

								<span class="one_half first"  style="margin-bottom: 0;">

									<span class="full"  style="margin-bottom: 0;">

										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Period:', 'agrg' ); ?></h3>
										</span>

										<span class="one_half" style="margin-bottom: 0;">
											<input type='text' id='' name='' value='' class='criteria_from_time' placeholder="" style="width: 40%"> <span style="float: left; margin: 10px;">-</span> <input type='text' id='' name='' value='' class='criteria_to_time' placeholder="" style="width: 40%">
										</span>

									</span>

									<span class="full"  style="margin-bottom: 0;">

										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Client’s Website:', 'agrg' ); ?></h3>
										</span>

										<span class="one_half" style="margin-bottom: 0;">
											<input type='text' id='' name='' value='' class='criteria_location' placeholder="" style="width: 100%;">
										</span>

									</span>

								</span>

								<span class="one_half" style="margin-bottom: 0;">

									<span class="one_fourth first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Notes:', 'agrg' ); ?></h3>
									</span>

									<span class="three_fourth" style="margin-bottom: 0;">
										<textarea class="criteria_notes" name="" id='' cols="70" rows="4" ></textarea>
									</span>

								</span>

								<button name="button_del_client" type="button" class="button-secondary button_del_client"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
							</div>

						</div>

						<div class="option_item">
							<button type="button" name="submit_add_client" id='submit_add_client' value="add" class="button-secondary"><i class="fa fa-plus-circle"></i><?php _e( 'Add new client', 'agrg' ); ?></button>
						</div>

						<div class="divider"></div>

					</div>

					<h1 class="resume-section-title"><i class="fa fa-money"></i><?php _e( 'Testimonials', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Let’s see what are people saying about you.', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div id="company_testimonials">
							<?php 

								$wpjobus_company_testimonials = get_post_meta($post->ID, 'wpjobus_company_testimonials',true);

								for ($i = 0; $i < (count($wpjobus_company_testimonials)); $i++) {

							?>
							
							<div class="full option_item" id="<?php echo $i; ?>">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Testimonial', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
									</span>
								</div>

								<div class="full" style="margin-bottom: 0;">

									<span class="one_half first"  style="margin-bottom: 0;">

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Full Name:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='wpjobus_company_testimonials[<?php echo $i; ?>][0]' name='wpjobus_company_testimonials[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_company_testimonials[$i][0])) echo $wpjobus_company_testimonials[$i][0]; ?>' class='criteria_name' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Organisation:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='wpjobus_company_testimonials[<?php echo $i; ?>][1]' name='wpjobus_company_testimonials[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_company_testimonials[$i][1])) echo $wpjobus_company_testimonials[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Testimonial:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<textarea class="criteria_notes" name="wpjobus_company_testimonials[<?php echo $i; ?>][2]" id='wpjobus_company_testimonials[<?php echo $i; ?>][2]' cols="70" rows="4" ><?php if (!empty($wpjobus_company_testimonials[$i][2])) echo $wpjobus_company_testimonials[$i][2]; ?></textarea>
											</span>

										</div>

									</span>

									<span class="one_half" style="margin-bottom: 0;">

										<span class="full" style="margin-bottom: 0;">
											<h3><i class="fa fa-picture-o"></i><?php _e( 'Picture:', 'agrg' ); ?></h3>
										</span>

										<div style="width: 100%; float: left;">
											<img class="criteria-image" id="your_cover_url_img" src="<?php if (!empty($wpjobus_company_testimonials[$i][3])) echo $wpjobus_company_testimonials[$i][3]; ?>" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 100px;" /> 
										</div>
										
							            <input class="criteria-image-url" id="your_icover_url" type="text" size="36" name="wpjobus_company_testimonials[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" />
							            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>2" type="button" value="Delete Image" /> </br>
							            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>2" type="button" value="Upload Image" />

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
											        var attachId = '';
											        attachId = attachment['id'];
											        $thisItem.parent().find('.criteria-image-url').val(url);
											        $thisItem.parent().find( "img.criteria-image" ).attr({
											            src: url
											        });
											        $thisItem.parent().find(".criteria-image-button").css("display", "none");
											        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
											        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
											        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
											    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
											    jQuery(this).css("display", "none");
											    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
											});
										</script>

									</span>

								</div>

								<button name="button_del_comp_testimonial" type="button" class="button-secondary button_del_comp_testimonial"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
								
							</div>
							
							<?php 
								}
							?>


						</div>

						<div id="template_comp_testimonials">
							
							<div class="full option_item" id="999">
								
								<div class="full" style="margin-bottom: 0;">

									<div class='full' style="margin-bottom: 0;">
										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Testimonial', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
										</span>
									</div>

									<span class="one_half first"  style="margin-bottom: 0;">

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Full Name:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='' name='' value='' class='criteria_name' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Organisation:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Testimonial:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<textarea class="criteria_notes" name="" id='' cols="70" rows="4" ></textarea>
											</span>

										</div>

									</span>

									<span class="one_half" style="margin-bottom: 0;">

										<span class="full" style="margin-bottom: 0;">
											<h3><i class="fa fa-picture-o"></i><?php _e( 'Picture:', 'agrg' ); ?></h3>
										</span>

										<div style="width: 100%; float: left;">
											<img class="criteria-image" id="your_cover_url_img" src="" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 100px;" /> 
										</div>
										
							            <input class="criteria-image-url" id="your_icover_url" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
							            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>2" type="button" value="Delete Image" /> </br>
							            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>2" type="button" value="Upload Image" />

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
											        var attachId = '';
											        attachId = attachment['id'];
											        $thisItem.parent().find('.criteria-image-url').val(url);
											        $thisItem.parent().find( "img.criteria-image" ).attr({
											            src: url
											        });
											        $thisItem.parent().find(".criteria-image-button").css("display", "none");
											        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
											        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
											        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
											    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
											    jQuery(this).css("display", "none");
											    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
											});
										</script>

									</span>

								</div>

								<button name="button_del_comp_testimonial" type="button" class="button-secondary button_del_comp_testimonial"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
							</div>

						</div>

						<div class="option_item">
							<button type="button" name="submit_add_comp_testimonial" id='submit_add_comp_testimonial' value="add" class="button-secondary"><i class="fa fa-plus-circle"></i><?php _e( 'Add new testimonial', 'agrg' ); ?></button>
						</div>

						<div class="divider"></div>

					</div>

					<h1 class="resume-section-title"><i class="fa fa-bookmark"></i><?php _e( 'Portfolio', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Upload your finest and brilliant work!', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div id="company_portfolio">
							<?php 

								global $wpjobus_company_portfolio;

								for ($i = 0; $i < (count($wpjobus_company_portfolio)); $i++) {

							?>
							
							<div class="full option_item" id="<?php echo $i; ?>">
								
								<div class='full'  style="margin-bottom: 0;">
									<span class="one_half first" style="margin-bottom: 0;">
										<h3 class="skill-item-title"><?php _e( 'Project', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
									</span>
								</div>

								<div class="full" style="margin-bottom: 0;">

									<span class="one_half first"  style="margin-bottom: 0;">

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Name:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='wpjobus_company_portfolio[<?php echo $i; ?>][0]' name='wpjobus_company_portfolio[<?php echo $i; ?>][0]' value='<?php if (!empty($wpjobus_company_portfolio[$i][0])) echo $wpjobus_company_portfolio[$i][0]; ?>' class='criteria_name' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Category:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='wpjobus_company_portfolio[<?php echo $i; ?>][1]' name='wpjobus_company_portfolio[<?php echo $i; ?>][1]' value='<?php if (!empty($wpjobus_company_portfolio[$i][1])) echo $wpjobus_company_portfolio[$i][1]; ?>' class='criteria_name_two' placeholder="" style="width: 100%;">
												<span class="info-text" style="margin-left: 0;"><?php _e( 'You can leave it empty', 'agrg' ); ?></span>
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Note:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<textarea class="criteria_notes" name="wpjobus_company_portfolio[<?php echo $i; ?>][2]" id='wpjobus_company_portfolio[<?php echo $i; ?>][2]' cols="70" rows="4" ><?php if (!empty($pjobus_resume_portfolio[$i][2])) echo $pjobus_resume_portfolio[$i][2]; ?></textarea>
											</span>

										</div>

									</span>

									<span class="one_half" style="margin-bottom: 0;">

										<span class="full" style="margin-bottom: 0;">
											<h3><i class="fa fa-picture-o"></i><?php _e( 'Picture:', 'agrg' ); ?></h3>
										</span>

										<div style="width: 100%; float: left;">
											<img class="criteria-image" id="your_cover_url_img" src="<?php if (!empty($wpjobus_company_portfolio[$i][3])) echo $pjobus_resume_portfolio[$i][3]; ?>" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 100px;" /> 
										</div>
										
							            <input class="criteria-image-url" id="your_icover_url" type="text" size="36" name="wpjobus_company_portfolio[<?php echo $i; ?>][3]" style="max-width: 200px; float: left; margin-top: 10px; display: none;" />
							            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>2" type="button" value="Delete Image" /> </br>
							            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>2" type="button" value="Upload Image" />

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
											        var attachId = '';
											        attachId = attachment['id'];
											        $thisItem.parent().find('.criteria-image-url').val(url);
											        $thisItem.parent().find( "img.criteria-image" ).attr({
											            src: url
											        });
											        $thisItem.parent().find(".criteria-image-button").css("display", "none");
											        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
											        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
											        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
											    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
											    jQuery(this).css("display", "none");
											    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
											});
										</script>

									</span>

								</div>

								<button name="button_del_comp_portfolio" type="button" class="button-secondary button_del_comp_portfolio"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
								
							</div>
							
							<?php 
								}
							?>


						</div>

						<div id="template_comp_portfolio">
							
							<div class="full option_item" id="999">
								
								<div class="full" style="margin-bottom: 0;">

									<div class='full' style="margin-bottom: 0;">
										<span class="one_half first" style="margin-bottom: 0;">
											<h3 class="skill-item-title"><?php _e( 'Project', 'agrg' ); ?> <span class="num"><?php echo ($i+1); ?></span></h3>
										</span>
									</div>

									<span class="one_half first"  style="margin-bottom: 0;">

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Name:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='' name='' value='' class='criteria_name' placeholder="" style="width: 100%;">
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Category:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<input type='text' id='' name='' value='' class='criteria_name_two' placeholder="" style="width: 100%;">
												<span class="info-text" style="margin-left: 0;"><?php _e( 'You can leave it empty', 'agrg' ); ?></span>
											</span>

										</div>

										<div class="full" style="margin-bottom: 0;">

											<span class="one_fourth first" style="margin-bottom: 0;">
												<h3 class="skill-item-title"><?php _e( 'Note:', 'agrg' ); ?></h3>
											</span>

											<span class="three_fourth" style="margin-bottom: 0;">
												<textarea class="criteria_notes" name="" id='' cols="70" rows="4" ></textarea>
											</span>

										</div>

									</span>

									<span class="one_half" style="margin-bottom: 0;">

										<span class="full" style="margin-bottom: 0;">
											<h3><i class="fa fa-picture-o"></i><?php _e( 'Picture:', 'agrg' ); ?></h3>
										</span>

										<div style="width: 100%; float: left;">
											<img class="criteria-image" id="your_cover_url_img" src="" style="float: left; width: auto; margin-bottom: 20px; margin-top: 10px; max-height: 100px;" /> 
										</div>
										
							            <input class="criteria-image-url" id="your_icover_url" type="text" size="36" name="" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="" />
							            <i class="fa fa-trash-o"></i><input class="criteria-image-button-remove button" id="your_image_url_button_remove<?php echo $i; ?>2" type="button" value="Delete Image" /> </br>
							            <i class="fa fa-cloud-upload"></i><input class="criteria-image-button button" id="your_image_url_button<?php echo $i; ?>2" type="button" value="Upload Image" />

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
											        var attachId = '';
											        attachId = attachment['id'];
											        $thisItem.parent().find('.criteria-image-url').val(url);
											        $thisItem.parent().find( "img.criteria-image" ).attr({
											            src: url
											        });
											        $thisItem.parent().find(".criteria-image-button").css("display", "none");
											        $thisItem.parent().find(".fa-cloud-upload").css("display", "none");
											        $thisItem.parent().find(".criteria-image-button-remove").css("display", "block");
											        $thisItem.parent().find(".fa-trash-o").css("display", "block");
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
											    jQuery(this).parent().find(".fa-cloud-upload").css("display", "block");
											    jQuery(this).css("display", "none");
											    jQuery(this).parent().find(".fa-trash-o").css("display", "none");
											});
										</script>

									</span>

								</div>

								<button name="button_del_comp_portfolio" type="button" class="button-secondary button_del_comp_portfolio"><i class="fa fa-trash-o"></i><?php _e( 'Delete', 'agrg' ); ?></button>
							</div>

						</div>

						<div class="option_item">
							<button type="button" name="submit_add_comp_portfolio" id='submit_add_comp_portfolio' value="add" class="button-secondary"><i class="fa fa-plus-circle"></i><?php _e( 'Add new project', 'agrg' ); ?></button>
						</div>

						<div class="divider"></div>

					</div>

					<h1 class="resume-section-title"><i class="fa fa-envelope"></i><?php _e( 'Contact Details', 'agrg' ); ?></h1>
					<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'We’re almost done! Fill in the contact deatils accuratelly.', 'agrg' ); ?></h3>

					<div class="divider"></div>

					<div class="full" style="margin-bottom: 0;">

						<div class="one_half first">

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Address:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" name="wpjobus_company_address" id="wpjobus_company_address" style="width: 100%; float: left;" value="<?php global $wpjobus_company_address; echo $wpjobus_company_address; ?>" class="input-textarea" placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Phone number:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_phone" class='input-textarea' name='wpjobus_company_phone' style="width: 100%; float: left;" value='<?php global $wpjobus_company_phone; echo $wpjobus_company_phone; ?>' placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Website:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_website" class='input-textarea' name='wpjobus_company_website' style="width: 100%; float: left;" value='<?php global $wpjobus_company_website; echo $wpjobus_company_website; ?>' placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Email:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_email" class='input-textarea' name='wpjobus_company_email' style="width: 100%; float: left;" value='<?php global $wpjobus_company_email; echo $wpjobus_company_email; ?>' placeholder="" />
									<span class="full" style="margin-bottom: 0;">
										<input type="checkbox" class='' name='wpjobus_company_publish_email' style="width: 10px; margin-right: 5px; float: left; margin-top: 7px;" value='publish_email' placeholder="" <?php if (!empty($wpjobus_company_publish_email)) { ?>checked<?php } ?>/><?php _e( 'Publish company email address', 'agrg' ); ?>
									</span>
								</span>

							</span>

						</div>

						<div class="one_half">

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Facebook:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_facebook" class='input-textarea' name='wpjobus_company_facebook' style="width: 100%; float: left;" value='<?php global $wpjobus_company_facebook; echo $wpjobus_company_facebook; ?>' placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'LinkedIn:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_linkedin" class='input-textarea' name='wpjobus_company_linkedin' style="width: 100%; float: left;" value='<?php global $wpjobus_company_linkedin; echo $wpjobus_company_linkedin; ?>' placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Twitter:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_twitter" class='input-textarea' name='wpjobus_company_twitter' style="width: 100%; float: left;" value='<?php global $wpjobus_company_twitter; echo $wpjobus_company_twitter; ?>' placeholder="" />
								</span>

							</span>

							<span class="full" >

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Google+:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type='text' id="wpjobus_company_googleplus" class='input-textarea' name='wpjobus_company_googleplus' style="width: 100%; float: left;" value='<?php global $wpjobus_company_googleplus; echo $wpjobus_company_googleplus; ?>' placeholder="" />
								</span>

							</span>

						</div>

						<div class="full" >

							<span class="one_fifth first" style="margin-bottom: 0;">
								<h3><?php _e( 'Google Maps Address:', 'agrg' ); ?></h3>
							</span>

							<span class="four_fifth" style="margin-bottom: 0;">
								<input type='text' id="address" class='input-textarea' name='wpjobus_company_googleaddress' style="width: 100%; float: left; margin-bottom: 0;" value='<?php global $wpjobus_company_googleaddress; echo $wpjobus_company_googleaddress; ?>' placeholder="" />
								<p class="help-block"><?php _e('Start typing an address and select from the dropdown.', 'agrg') ?></p>
							</span>

						</div>

						<div class="full">

							<div id="map-canvas"></div>

							<style>

								#map-canvas {
									display: block;
									width: 100%;
									height: 470px;
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

									  var latlng = new google.maps.LatLng(<?php echo $wpjobus_company_latitude; ?>, <?php echo $wpjobus_company_longitude; ?>);
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

						<div class="full" >

							<div class="one_half first" style="margin-bottom: 0;">

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Latitude:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" id="latitude" name="wpjobus_company_latitude" value="<?php echo $wpjobus_company_latitude; ?>" class="input-textarea">
								</span>

							</div>

							<div class="one_half" style="margin-bottom: 0;">

								<span class="two_fifth first" style="margin-bottom: 0;">
									<h3><?php _e( 'Longitude:', 'agrg' ); ?></h3>
								</span>

								<span class="three_fifth" style="margin-bottom: 0;">
									<input type="text" id="longitude" name="wpjobus_company_longitude" value="<?php echo $wpjobus_company_longitude; ?>" class="input-textarea">
								</span>

							</div>

						</div>

					</div>

					<div class="divider"></div>

					<div class="full save-resume-block">

						<div class="full" style="margin-bottom: 0;">

							<div id="success">
								<span>
									<h3><?php _e( 'Company Profile Saved Successful.', 'agrg' ); ?></h3>
								</span>
								<div class="divider"></div>
							</div>
										 
							<div id="error">
								<span>
									<h3><?php _e( 'Something went wrong, try refreshing and submitting the form again.', 'agrg' ); ?></h3>
								</span>
								<div class="divider"></div>
							</div>

						</div>

						<input type="hidden" name="action" value="wpjobusSubmitCompanyForm" />
						<?php wp_nonce_field( 'wpjobusSubmitCompany_html', 'wpjobusSubmitCompany_nonce' ); ?>

						<span class="draft-resume-button">

							<input style="margin-bottom: 0;" name="submit" type="submit" value="<?php _e( 'Save As Draft', 'agrg' ); ?>" class="input-submit">

							<script>
								jQuery(document).on('click','.draft-resume-button .input-submit', function() {

									$thisItem = jQuery(this);
									$thisItem.parent().parent().parent().find('#postStatus').val('draft');
									
								});
							</script>

						</span>

						<span class="submit-resume-button">

							<?php

								global $redux_demo; 
								$recipe_state = $redux_demo['resume-state'];

							?>
 
							<input style="margin-bottom: 0;" name="submit" type="submit" value="<?php if($recipe_state == "1" or current_user_can('administrator')) { _e( 'Submit Company Profile', 'agrg' ); } else { _e( 'Submit Company Profile For Review', 'agrg' ) ;} ?>" class="input-submit">
							<span class="submit-loading"><i class="fa fa-refresh fa-spin"></i></span>

							<script>
								jQuery(document).on('click','.submit-resume-button .input-submit', function() {

									$thisItem = jQuery(this);
									$thisItem.parent().parent().parent().find('#postStatus').val('published');
									
								});
							</script>

						</span>

					</div>

					<input type="hidden" id="postStatus" name="postStatus" value="">

				</form>

				<script type="text/javascript">

				jQuery(function($) {
					jQuery('#wpjobus-add-company').validate({
						rules: {
						    fullName: {
						        required: true,
						        minlength: 3
						    },
						    wpjobus_company_email: {
						        required: true,
						        email: true
						    }
						},
						messages: {
							fullName: {
							    required: "<?php _e( 'Please provide your full name', 'agrg' ); ?>",
							    minlength: "<?php _e( 'Your name must be at least 3 characters long', 'agrg' ); ?>"
							},
							wpjobus_company_email: {
							    required: "<?php _e( 'Please provide an email address', 'agrg' ); ?>",
							    email: "<?php _e( 'Please enter a valid email address', 'agrg' ); ?>"
							}
						},
						submitHandler: function(form) {
							tinyMCE.triggerSave();
						    jQuery('#wpjobus-add-company .input-submit').css('display','none');
						    jQuery('#wpjobus-add-company .submit-loading').css('display','block');
						    jQuery(form).ajaxSubmit({
						        type: "POST",
								data: jQuery(form).serialize(),
								url: '<?php echo admin_url('admin-ajax.php'); ?>', 
						        success: function(data) {
						            if(data != 0) {
						        		jQuery('#wpjobus-add-company .submit-loading').css('display','none');
						        		jQuery('#success').fadeIn(); 

      									<?php $redirect_link = home_url()."/my-account"; ?>

      									var delay = 5;
      									setTimeout(function(){ window.location = '<?php echo $redirect_link; ?>';}, delay);
      									 
						            } else {
						            	jQuery('#wpjobus-add-company .input-submit').css('display','block');
							        	jQuery('#wpjobus-add-company .submit-loading').css('display','none');

							            jQuery('#error').fadeIn();
						            }
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

	</section>

<?php get_footer(); ?>