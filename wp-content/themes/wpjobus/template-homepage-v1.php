<?php
/**
 * Template name: Homepage
 */

$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<?php
		include (TEMPLATEPATH . "/part-sliders.php");
	?>

	<?php
		$page_title_state = get_post_meta($current_page_id, 'page_title_state', true);
		if($page_title_state == "off")
		{
	?>

	<section id="page-title">

		<div class="container">

			<h1 class="page-title"><?php the_title(); ?></h1>

		</div>

	</section>

	<?php } ?>

	<section id="page" style="padding: 0;">

		<div class="container">

			<div class="full" style="margin-bottom: 0;">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
				<?php the_content(); ?>
															
				<?php endwhile; endif; ?> 
				
			</div>

		</div>

	</section>

	<section id="big-map">

		<div id="wpjobus-main-map-preloader"><div class="loading-map"><i class="fa fa-spinner fa-spin"></i></div></div>

		<div id="wpjobus-main-map" style="float: left;"></div>

		<div id="search-widget">

			<div class="container">

				<div class="resume-skills" style="padding-bottom: 0;">

					<div class="full" style="margin-bottom: 50px;">
						<h1 class="resume-section-title"><i class="fa fa-search"></i><?php _e( 'Search', 'agrg' ); ?></h1>
						<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Use our awesome search tool to find jobs, companies or resumes!', 'agrg' ); ?></h3>
					</div>

					<div class="full" style="margin-bottom: 0;">

						<ul id="homepage-posts-block" class="tabs-search quicktabs-tabs quicktabs-style-nostyle"> 
						    <li class="grid-feat-ad-style active"><a class="current" href="#"><i class="fa fa-bullhorn"></i><?php _e( 'Jobs', 'agrg' ); ?></a></li>
						   	<li class="list-feat-ad-style"><a class="" href="#"><i class="fa fa-file-text-o"></i><?php _e( 'Resumes', 'agrg' ); ?></a></li>
						   	<li class="list-feat-ad-style"><a class="" href="#"><i class="fa fa-briefcase"></i><?php _e( 'Companies', 'agrg' ); ?></a></li>
			            </ul>

			            <div class="pane" style="display: block;">

			            	<div class="full" style="margin-top: 30px; margin-bottom: 0;">

			            		<form action="<?php echo home_url(); ?>/jobs" method="get" id="search-jobs-form" accept-charset="UTF-8">

				            		<div class="one_fourth first" style="margin-bottom: 0">

				            			<input type="text" name="keyword" id="fullName" value="" class="input-textarea" placeholder="Keyword" style="margin-bottom: 0;"/>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="job_location" id="job_location" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Location</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
											?>
											<option value='<?php echo $redux_demo['resume-locations'][$i]; ?>' ><?php echo $redux_demo['resume-locations'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="job_type" id="job_type" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Type</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['job-type']); $i++) {
											?>
											<option value='<?php echo $redux_demo['job-type'][$i]; ?>' ><?php echo $redux_demo['job-type'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<span onclick="document.getElementById('search-jobs-form').submit(); return false;" id="comp-reset" class="button-ag-full" style="width: 100%; text-align: center;" ><i class="fa fa-search"></i><?php _e( 'Search', 'agrg' ); ?></span>

				            		</div>

				            	</form>

			            	</div>

			            </div>

			            <div class="pane" style="display: block;">

			            	<div class="full" style="margin-top: 30px; margin-bottom: 0;">

			            		<form action="<?php echo home_url(); ?>/resumes" method="get" id="search-resumes-form" accept-charset="UTF-8">

				            		<div class="one_fourth first" style="margin-bottom: 0">

				            			<input type="text" name="keyword" id="fullName" value="" class="input-textarea" placeholder="Keyword" style="margin-bottom: 0;"/>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="resume_location" id="job_location" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Location</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
											?>
											<option value='<?php echo $redux_demo['resume-locations'][$i]; ?>' ><?php echo $redux_demo['resume-locations'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="resume_type" id="job_type" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Type</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['job-type']); $i++) {
											?>
											<option value='<?php echo $redux_demo['job-type'][$i]; ?>' ><?php echo $redux_demo['job-type'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<span onclick="document.getElementById('search-resumes-form').submit(); return false;" id="comp-reset" class="button-ag-full" style="width: 100%; text-align: center;" ><i class="fa fa-search"></i><?php _e( 'Search', 'agrg' ); ?></span>

				            		</div>

				            	</form>

			            	</div>

			            </div>

			            <div class="pane" style="display: block;">

			            	<div class="full" style="margin-top: 30px; margin-bottom: 0;">

			            		<form action="<?php echo home_url(); ?>/companies" method="get" id="search-companies-form" accept-charset="UTF-8">

				            		<div class="one_fourth first" style="margin-bottom: 0">

				            			<input type="text" name="keyword" id="fullName" value="" class="input-textarea" placeholder="Keyword" style="margin-bottom: 0;"/>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="company_location" id="job_location" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Location</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
											?>
											<option value='<?php echo $redux_demo['resume-locations'][$i]; ?>' ><?php echo $redux_demo['resume-locations'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<select name="company_industry" id="job_type" style="width: 100%; margin-bottom: 0;">
				            				<option value='all' >Any Category</option>
											<?php 
												global $redux_demo, $job_location; 
												for ($i = 0; $i < count($redux_demo['resume-industries']); $i++) {
											?>
											<option value='<?php echo $redux_demo['resume-industries'][$i]; ?>' ><?php echo $redux_demo['resume-industries'][$i]; ?></option>
											<?php 
												}
											?>
										</select>

				            		</div>

				            		<div class="one_fourth" style="margin-bottom: 0">

				            			<span onclick="document.getElementById('search-companies-form').submit(); return false;" id="comp-reset" class="button-ag-full" style="width: 100%; text-align: center;" ><i class="fa fa-search"></i><?php _e( 'Search', 'agrg' ); ?></span>

				            		</div>

				            	</form>

			            	</div>

			            </div>

					</div>

				</div>

			</div>

		</div>

		<div id="big-map-holder">

			<script type="text/javascript">
			var mapDiv,
				map,
				infobox;
			jQuery(document).ready(function($) {

				mapDiv = $("#wpjobus-main-map");
				mapDiv.height(500).gmap3({
					map: {
						options: {
							"draggable": true
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

								global $companies_per_page, $total_companies, $total_pages, $current_page;

								$total_companies = 0;

								$current_page = max(1, get_query_var('paged'));

								$wpjobus_companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE (post_type = 'company' or post_type = 'job' or post_type = 'resume') and post_status = 'publish' ORDER BY `ID` DESC");

								$current_pos = -1; 

								$current_element_id = 0;

								foreach($wpjobus_companies as $q) {	

									$current_pos++;

									$current_element_id++;

									$company_id = $q->ID;

									if(get_post_type( $company_id ) == "company") {

										$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
										$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
										$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
										$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

										$wpjobus_company_longitude = get_post_meta($company_id, 'wpjobus_company_longitude',true);
										$wpjobus_company_latitude = get_post_meta($company_id, 'wpjobus_company_latitude',true);


										$iconPath = get_template_directory_uri() .'/images/icon-company.png';

										$companylink = home_url()."/company/".$company_id;

									} elseif(get_post_type( $company_id ) == "job") {

										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_job_fullname',true));
										$wpjobus_company_longitude = get_post_meta($company_id, 'wpjobus_job_longitude',true);
										$wpjobus_company_latitude = get_post_meta($company_id, 'wpjobus_job_latitude',true);
										$job_company = esc_attr(get_post_meta($company_id, 'job_company',true));
										$wpjobus_company_profile_picture = esc_attr(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

										$iconPath = get_template_directory_uri() .'/images/icon-job.png';

										$companylink = home_url()."/job/".$company_id;

									} elseif(get_post_type( $company_id ) == "resume") {

										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_resume_fullname',true));
										$wpjobus_company_longitude = get_post_meta($company_id, 'wpjobus_resume_longitude',true);
										$wpjobus_company_latitude = get_post_meta($company_id, 'wpjobus_resume_latitude',true);
										$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_resume_profile_picture',true));

										$iconPath = get_template_directory_uri() .'/images/icon-resume.png';

										$companylink = home_url()."/resume/".$company_id;

									} 

									if(!empty($wpjobus_company_latitude)) {

							?> 
								{

									latLng: [<?php echo $wpjobus_company_latitude; ?>,<?php echo $wpjobus_company_longitude; ?>],
									options: {
										icon: "<?php echo $iconPath; ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									},
									data: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><span class="helper"></span><img src="<?php echo $wpjobus_company_profile_picture; ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><?php echo $wpjobus_company_fullname; ?></div><div class="marker-info-link"><a href="<?php echo $companylink; ?>"><?php _e( "View Profile", "agrg" ); ?></a></div></div></div><div class="arrow-down"></div><div class="close"></div></div></div>'

								}
							,

							<?php } } ?>
							
						],
						options:{
							draggable: false
						},
						cluster:{
			          		radius: 20,
							// This style will be used for clusters with more than 0 markers
							0: {
								content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
								width: 62,
								height: 62
							},
							// This style will be used for clusters with more than 20 markers
							20: {
								content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
								width: 82,
								height: 82
							},
							// This style will be used for clusters with more than 50 markers
							50: {
								content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
								width: 102,
								height: 102
							},
							events: {
								click: function(cluster) {
									map.panTo(cluster.main.getPosition());
									map.setZoom(map.getZoom() + 2);
								}
							}
			          	},
						events: {
							click: function(marker, event, context){
								map.panTo(marker.getPosition());

								var ibOptions = {
								    pixelOffset: new google.maps.Size(-125, -88),
								    alignBottom: true
								};

								infobox.setOptions(ibOptions)

								infobox.setContent(context.data);
								infobox.open(map,marker);

								// if map is small
								var iWidth = 260;
								var iHeight = 300;
								if((mapDiv.width() / 2) < iWidth ){
									var offsetX = iWidth - (mapDiv.width() / 2);
									map.panBy(offsetX,0);
								}
								if((mapDiv.height() / 2) < iHeight ){
									var offsetY = -(iHeight - (mapDiv.height() / 2));
									map.panBy(0,offsetY);
								}

							}
						}
					}
				},"autofit");

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

		</div>

	</section>

<?php get_footer(); ?>