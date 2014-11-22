<?php
/**
 * Template name: Jobs
 */



$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<?php 

		global $keyword;

		// Retrieve the URL variables (using PHP).
		if (isset($_GET['keyword'])) {
		    $keyword = $_GET['keyword'];
		} else {
		    $keyword = "";
		}

		if (isset($_GET['job_location'])) {
		    $job_location_search = $_GET['job_location'];
		} else {
		    $job_location_search = "";
		}

		if($job_location_search == "all") {
			$job_location_search = "";
		}

		if (isset($_GET['job_type'])) {
		    $job_type = $_GET['job_type'];
		} else {
		    $job_type = "";
		}

		if($job_type == "all") {
			$job_type = "";
		}

		if(!empty($job_type)) {

			$string = "AND m.meta_key = 'wpjobus_job_type' AND m.meta_value = '" . $job_type . "'";

		} else {

			$string = "";

		}

		if(!empty($job_location_search)) {

			$stringLocation = "AND m2.meta_key = 'job_location' AND m2.meta_value = '" . $job_location_search . "'";

		} else {

			$stringLocation = "";

		}

		if(!empty($keyword)) {

			$stringKeyword = "AND (m3.meta_key = 'wpjobus_job_fullname' AND m3.meta_value LIKE '%" . $keyword . "%')";

		} else {

			$stringKeyword = "";

		}

	?>

	<section id="big-map">

		<div id="wpjobus-main-map-preloader"><div class="loading-map"><i class="fa fa-spinner fa-spin"></i></div></div>

		<div id="wpjobus-main-map"></div>

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

								$companies_per_page = 18;

								$total_companies = 0;

								$current_page = max(1, get_query_var('paged'));

								$wpjobus_companies = $wpdb->get_results( "SELECT DISTINCT p.ID
																	FROM  `{$wpdb->prefix}posts` p
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
																	WHERE p.post_type =  'job'
																	AND p.post_status =  'publish'
																	".$string."
																	".$stringLocation."
																	".$stringKeyword."
																	ORDER BY  `p`.`ID` DESC");
								  
								foreach($wpjobus_companies as $company) { 
									$total_companies++;
								}

								$total_pages = ceil($total_companies/$companies_per_page);

								$current_pos = -1; 

								$current_element_id = 0;

								foreach($wpjobus_companies as $q) {	

									$current_pos++;

									if($current_page == 1) {
										$start_loop = 0;
									} else {
										$start_loop = ($current_page - 1) * $companies_per_page;
									}

									$end_loop = $current_page * $companies_per_page;

									if($current_pos >= $start_loop && $current_pos <= ($end_loop-1)) {

										$current_element_id++;

										$company_id = $q->ID;

										$iconPath = get_template_directory_uri() .'/images/icon-job.png';

										$wpjobus_job_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_job_fullname',true));

										$wpjobus_job_longitude = esc_attr(get_post_meta($company_id, 'wpjobus_job_longitude',true));
										$wpjobus_job_latitude = esc_attr(get_post_meta($company_id, 'wpjobus_job_latitude',true));

										$job_company = esc_attr(get_post_meta($company_id, 'job_company',true));
										$wpjobus_company_profile_picture = esc_url(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

										if(!empty($wpjobus_job_latitude)) {

							?> 
								{

									latLng: [<?php echo $wpjobus_job_latitude; ?>,<?php echo $wpjobus_job_longitude; ?>],
									options: {
										icon: "<?php echo esc_url($iconPath); ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									},
									data: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><span class="helper"></span><img src="<?php echo $wpjobus_company_profile_picture; ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><?php echo $wpjobus_job_fullname; ?></div><div class="marker-info-link"><a href="<?php $companylink = home_url()."/job/".$company_id; echo $companylink; ?>"><?php _e( "View Job Offer", "agrg" ); ?></a></div></div></div><div class="arrow-down"></div><div class="close"></div></div></div>'

								}
							,

							<?php } } } ?>
							
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

	<section id="blog" style="padding-top: 0; margin-top: -50px;">

		<div class="container">

			<div class="resume-skills">

				<form id="wpjobus-companies" type="post" action="" >

					<div class="two_third first">

						<div class="full">
							<h1 class="resume-section-title"><i class="fa fa-search"></i><?php _e( 'Search for Jobs', 'agrg' ); ?></h1>
							<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Use our awesome search tool to find job offers!', 'agrg' ); ?></h3>
						</div>

						<div class="full" style="margin-bottom: 0;">
							<div class="loading"><i class="fa fa-spinner fa-spin"></i></div>
						</div>

						<div id="companies-block">

							<ul id="companies-block-list-ul">

							<?php 

								global $companies_per_page, $total_companies, $total_pages, $current_page;

								$companies_per_page = 18;

								$total_companies = 0;

								$current_page = max(1, get_query_var('paged'));

								$wpjobus_companies = $wpdb->get_results( "SELECT DISTINCT p.ID
																	FROM  `{$wpdb->prefix}posts` p
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
																	LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
																	WHERE p.post_type =  'job'
																	AND p.post_status =  'publish'
																	".$string."
																	".$stringLocation."
																	".$stringKeyword."
																	ORDER BY  `p`.`ID` DESC");
								  
								foreach($wpjobus_companies as $company) { 
									$total_companies++;
								}

								$total_pages = ceil($total_companies/$companies_per_page);

								$current_pos = -1; 

								$current_element_id = 0;

								foreach($wpjobus_companies as $q) {	

									$current_pos++;

									if($current_page == 1) {
										$start_loop = 0;
									} else {
										$start_loop = ($current_page - 1) * $companies_per_page;
									}

									$end_loop = $current_page * $companies_per_page;

									if($current_pos >= $start_loop && $current_pos <= ($end_loop-1)) {

										$current_element_id++;

										$company_id = $q->ID;

										$result_company_date = get_the_date("Y-m-d h:m:s", $company_id );
										
										$wpjobus_job_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_job_fullname',true));

										$wpjobus_job_longitude = esc_attr(get_post_meta($company_id, 'wpjobus_job_longitude',true));
										$wpjobus_job_latitude = esc_attr(get_post_meta($company_id, 'wpjobus_job_latitude',true));

										$job_company = esc_attr(get_post_meta($company_id, 'job_company',true));
										$wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
										$wpjobus_company_profile_picture = esc_url(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

										$job_location = esc_attr(get_post_meta($company_id, 'job_location',true));

							?> 

							<li id="<?php echo $current_element_id; ?>">

								<a href="<?php $companylink = home_url()."/job/".$company_id; echo $companylink; ?>">

									<div class="company-holder-block">

										<span class="company-list-icon">
											<span class="helper"></span>
											<img src="<?php echo $wpjobus_company_profile_picture; ?>" alt="<?php echo $wpjobus_job_fullname; ?>" />
										</span>

										<span class="company-list-name-block" style="max-width: 380px;">
											<span class="company-list-name"><?php echo $wpjobus_job_fullname; ?></span>
											<span class="company-list-location"><i class="fa fa-briefcase"></i><?php echo $wpjobus_company_fullname; ?><i class="fa fa-map-marker" style="margin-left: 10px;"></i><?php echo $job_location; ?><i class="fa fa-calendar-o" style="margin-left: 10px;"></i><?php echo human_time_diff( strtotime($result_company_date), current_time('timestamp') ) . ' '; _e( 'ago', 'agrg' ); ?>
											</span>
										</span>

										<span class="company-list-view-profile">

											<span class="company-view-profile">
												<span class="company-view-profile-title-holder">
													<span class="company-view-profile-title"><?php _e( 'View', 'agrg' ); ?></span>
													<span class="company-view-profile-subtitle"><?php _e( 'Job Offer', 'agrg' ); ?></span>
												</span>
												<i class="fa fa-eye"></i>
											</span>

										</span>

										<span class="company-list-badges" style="margin-top: 19px;">

											<?php

												global $redux_demo;
												$colorState = 0;

												if(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][0] ) {
													$colorState = 1;
													$color = "#16a085";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][1] ) {
													$colorState = 1;
													$color = "#3498db";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][2] ) {
													$colorState = 1;
													$color = "#e74c3c";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][3] ) {
													$colorState = 1;
													$color = "#1abc9c";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][4] ) {
													$colorState = 1;
													$color = "#8e44ad";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][5] ) {
													$colorState = 1;
													$color = "#9b59b6";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][6] ) {
													$colorState = 1;
													$color = "#34495e";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][7] ) {
													$colorState = 1;
													$color = "#e67e22";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][8] ) {
													$colorState = 1;
													$color = "#e74c3c";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][9] ) {
													$colorState = 1;
													$color = "#16a085";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][10] ) {
													$colorState = 1;
													$color = "#2980b9";
												} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][11] ) {
													$colorState = 1;
													$color = "#2ecc71";
												}

											?>

											<span class="job-offers-post-badge" style="max-width: 220px; <?php if($colorState ==1) { ?>background-color: <?php echo $color; ?>; border: solid 2px <?php echo $color; ?>;<?php } ?>">
												<span class="job-offers-post-badge-job-type" style="width: 110px; <?php if($colorState ==1) { ?>color: <?php echo $color; ?>;<?php } ?>"><?php echo $wpjobus_job_type = esc_attr(get_post_meta($company_id, 'wpjobus_job_type',true)); ?></span>
												<span class="job-offers-post-badge-amount"><?php echo $wpjobus_job_remuneration = esc_attr(get_post_meta($company_id, 'wpjobus_job_remuneration',true)); ?></span>
												<span class="job-offers-post-badge-amount-per">/<?php echo $wpjobus_job_remuneration_per = esc_attr(get_post_meta($company_id, 'wpjobus_job_remuneration_per',true)); ?></span>
											</span>

										</span>

									</div>

								</a>

							</li>

							<?php } } ?> 

							</ul> 

							<?php if($current_element_id == 0) { ?>

						      	<div class="full"><h4><?php _e( 'Well, it looks like there are no results matching your criterias.', 'agrg' ); ?></h4></div>

						    <?php } 

								if($total_pages > 1) {  

					                $wpcook_pagination = array(
										'base' => @add_query_arg('page','%#%'),
										'format' => '',
										'total' => $total_pages,
										'current' => $current_page,
										'prev_next' => true,
										'prev_text'    => __('« Previous', 'agrg'),
										'next_text'    => __('Next »', 'agrg'),
										'type' => 'plain',
										);

									if( $wp_rewrite->using_permalinks() )
										$wpcook_pagination['base'] = '#%#%';

									if( !empty($wp_query->query_vars['s']) )
										$wpcook_pagination['add_args'] = array('s'=>get_query_var('s'));

									echo '<div class="pagination">' . paginate_links($wpcook_pagination) . '</div>'; 

								}
								
							?> 

						</div>

					</div>

					<div class="one_third" >

						<?php 

							$currentDate = current_time('timestamp');

							$total_jobs = 0;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																WHERE p.post_type = 'job'
																AND p.post_status = 'publish'
																AND m.meta_key = 'wpjobus_featured_expiration_date' 
																AND m.meta_value >= '".$currentDate."'
																ORDER BY RAND()");

							foreach($wpjobus_jobs as $q) { 
							  	$total_jobs++;
							}

							if($total_jobs > 0) {

								$curren_job = 0;

						?>

						<span class="filters-title"><i class="fa fa-star"></i><?php _e( 'Featured Jobs!', 'agrg' ); ?></span>

						<div id="owl-demo" class="owl-carousel owl-theme featured-items">

							<?php foreach($wpjobus_jobs as $job) {

								$curren_job++; 
								  	
								$job_id = $job->ID;

								if($curren_job <= 5) {

							?>

							<div class="item">

						  		<a href="<?php $link_job = home_url()."/job/".$job_id; echo $link_job; ?>">

							  		<div class="featured-item">

							  			<span class="featured-item-image">

							  				<?php 

							  					$wpjobus_job_cover_image = esc_url(get_post_meta($job_id, 'wpjobus_job_cover_image',true));
							  					$wpjobus_job_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_job_fullname',true));
							  					$wpjobus_job_type = esc_attr(get_post_meta($job_id, 'wpjobus_job_type',true));
							  					$wpjobus_job_remuneration_per = esc_attr(get_post_meta($job_id, 'wpjobus_job_remuneration_per',true));
												$wpjobus_job_remuneration = esc_attr(get_post_meta($job_id, 'wpjobus_job_remuneration',true));
												$job_company = esc_attr(get_post_meta($job_id, 'job_company',true));
												$wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
												$job_location = esc_attr(get_post_meta($job_id, 'job_location',true));

							  					if(!empty($wpjobus_job_cover_image)) {

									  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
													$params = array( 'width' => 340, 'height' => 200, 'crop' => true );
													echo "<img class='big-img' src='" . bfi_thumb( "$wpjobus_job_cover_image", $params ) . "' alt='" . $wpjobus_job_fullname . "'/>";

												} else {

													echo "<span class='featured-image-replacer'><i class='fa fa-bullhorn'></i>";

												}

											?>

							  			</span>

							  			<span class="featured-item-badge">

							  				<span class="featured-item-job-badge">

							  					<span class="featured-item-job-badge-title"><?php echo $wpjobus_job_type; ?></span>

							  					<span class="featured-item-job-badge-info">

							  						<span class="featured-item-job-badge-info-sum"><?php echo $wpjobus_job_remuneration; ?> / </span>

													<span class="featured-item-job-badge-info-per"> <?php echo $wpjobus_job_remuneration_per; ?></span>						  						

							  					</span>

							  				</span>

							  			</span>

							  			<span class="featured-item-content">

							  				<span class="featured-item-content-title"><?php echo $wpjobus_job_fullname; ?></span>
							  				<span class="featured-item-content-subtitle">

							  					<span><i class="fa fa-briefcase"></i><?php echo $wpjobus_company_fullname; ?></span><span><i class="fa fa-map-marker" style="margin-left: 15px;"></i><?php echo $job_location; ?></spam>

							  				</span>

							  			</span>

							  		</div>

							  	</a>

						  	</div>

							<?php } } ?>

						</div>

						<?php } ?>

						<div class="filters">

							<span class="filters-title"><?php _e( 'Search & Refinements', 'agrg' ); ?></span>

							<div class="full sidebar-widget-bottom-line">

								<div class="full" style="margin-bottom: 0;">

									<input type="text" name="comp_keyword" id="comp_keyword" value="<?php if (!empty($keyword)) { echo $keyword; } ?>" placeholder="<?php _e( 'Type and press enter...', 'agrg' ); ?>" style="margin-bottom: 15px;" >
									<div id="search-results"></div>

								</div>

								<div class="full">

									<div class="one_half first" style="margin-bottom: 0;">

										<span class="filters-subtitle"><?php _e( 'Career Level', 'agrg' ); ?></span>

										<ul class="filters-lists">

											<li class="filters-list-career-all active">
												<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Types', 'agrg' ); ?>
												<input type="hidden" class="job_career_level_option" name="job_career_level_all" value="1" />
											</li>

											<?php 
												global $redux_demo; 
												for ($i = 0; $i < count($redux_demo['resume_career_level']); $i++) {
											?>
											
											<li class="filters-list-career-one">
												<i id="job-type[<?php echo $i; ?>]" class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['resume_career_level'][$i]; ?>
												<input type="hidden" class="job_career_level_option_value" name="job_career_level_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['resume_career_level'][$i]; ?>" />
												<input type="hidden" class="job_career_level_option" name="job_career_level[<?php echo $i; ?>]" value="" />
											</li>

											<?php 
												}
											?>

										</ul>

									</div>

									<div class="one_half" style="margin-bottom: 0;">

										<span class="filters-subtitle"><?php _e( 'Presence', 'agrg' ); ?></span>

										<ul class="filters-lists-main">
											
											<li class="filters-list-presence-all active">
												<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Types', 'agrg' ); ?>
												<input type="hidden" class="filters-presence-all-input" name="filters_presence_all" value="1" />
											</li>

											<?php 
												global $redux_demo; 
												for ($i = 0; $i < count($redux_demo['job_presence_type']); $i++) {
											?>
											
											<li class="filters-list-presence">
												<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['job_presence_type'][$i]; ?>
												<input type="hidden" class="company-presence-value" name="company_presence_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['job_presence_type'][$i]; ?>" />
												<input type="hidden" class="company-presence" name="company_presence[<?php echo $i; ?>]" value="" />
											</li>

											<?php 
												}
											?>

										</ul>

									</div>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<span class="filters-subtitle"><?php _e( 'Experience', 'agrg' ); ?></span>

								<?php

									$wpjobus_companies_est_year = $wpdb->get_results( "SELECT DISTINCT m.meta_value FROM  `{$wpdb->prefix}posts` p LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id WHERE p.post_type =  'job' AND p.post_status =  'publish' AND m.meta_key = 'job_years_of_exp' ORDER BY  m.meta_value+0 ASC");

									$total_years = 0;
								  
									foreach($wpjobus_companies_est_year as $year) { 
										$total_years++;
									}

									$s = 0;
									$m = $total_years;
									$min = $wpjobus_companies_est_year[$s] -> meta_value;
        							$max = $wpjobus_companies_est_year[count($wpjobus_companies_est_year)-1] -> meta_value;

        							foreach($wpjobus_companies_est_year as $year) { 

										if(empty($min)) {
	        								$s++;
	        								$min = $wpjobus_companies_est_year[$s] -> meta_value;
	        							}

									}

									for($countQ = $total_years; $countQ > 0; $countQ--) {

										if(empty($max)) {
	        								$m--;
	        								$max = $wpjobus_companies_est_year[$m] -> meta_value;
	        							}

									}

									$medium = floor(($max + $min)/2);

								?>

								<div class="one_half first">

									<p><?php _e( 'More than', 'agrg' ); ?> <span class="comp_est_year_num"><?php echo $medium; ?></span> <?php _e( 'years', 'agrg' ); ?></p>

								</div>

								<div class="one_half">

									<div id="advance-search-slider" class="ui-slider-horizontal" aria-disabled="false">
										<a class="ui-slider-handle" href="#"></a>
										<input type="hidden" name="comp_est_year" id="comp_est_year" value="<?php echo $min; ?>" >
									</div>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<span class="filters-subtitle"><?php _e( 'Salary', 'agrg' ); ?></span>

								<div class="full">

									<p class="comp_team_holder" style="margin-bottom: 0;"><?php _e( 'From', 'agrg' ); ?> <input type="text" name="comp_min_team" id="comp_min_team" value="" > <?php _e( 'to', 'agrg' ); ?> <input type="text" name="comp_max_team" id="comp_max_team" value="" ></p>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<div class="one_half first">

									<span class="filters-subtitle"><?php _e( 'Job Types', 'agrg' ); ?></span>

									<ul class="filters-lists">

										<li class="filters-list-all <?php if(empty($job_type)) { ?>active<?php }?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Types', 'agrg' ); ?>
											<input type="hidden" class="job_presence_type_option" name="job_presence_type_all" value="<?php if(empty($job_type)) { ?>1<?php }?>" />
										</li>

										<?php 
											global $redux_demo; 
											for ($i = 0; $i < count($redux_demo['job-type']); $i++) {
										?>
											
										<li class="filters-list-one <?php if($job_type == $redux_demo['job-type'][$i] ) { ?>active<?php } ?>">
											<i id="job-type[<?php echo $i; ?>]" class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['job-type'][$i]; ?>
											<input type="hidden" class="job_presence_type_option_value" name="job_presence_type_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['job-type'][$i]; ?>" />
											<input type="hidden" class="job_presence_type_option" name="job_presence_type[<?php echo $i; ?>]" value="<?php if($job_type == $redux_demo['job-type'][$i] ) { echo $redux_demo['job-type'][$i]; } ?>" />
										</li>

										<?php 
											}
										?>

									</ul>

								</div>

								<div class="one_half">

									<span class="filters-subtitle"><?php _e( 'Locations', 'agrg' ); ?></span>

									<ul class="filters-lists-location">

										<li class="filters-list-location-all <?php if(empty($job_location_search)) { ?>active<?php }?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Locations', 'agrg' ); ?>
											<input type="hidden" class="company-location-all" name="company_location_all" value="<?php if(empty($job_location_search)) { ?>1<?php } ?>" />
										</li>

										<?php 
											global $redux_demo; 
											for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
										?>
										
										<li class="filters-list-location <?php if($job_location_search == $redux_demo['resume-locations'][$i] ) { ?>active<?php } ?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['resume-locations'][$i]; ?>
											<input type="hidden" class="company-location-value" name="company_location_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['resume-locations'][$i]; ?>" />
											<input type="hidden" class="company-location" name="company_location[<?php echo $i; ?>]" value="<?php if($job_location_search == $redux_demo['resume-locations'][$i] ) { echo $redux_demo['resume-locations'][$i]; } ?>" />
										</li>

										<?php 
											}
										?>

									</ul>

								</div>

							</div>

							<div class="full" style="margin-bottom: 0; text-align: center;">

								<span id="comp-reset" class="button-ag-full" ><i class="fa fa-check"></i><?php _e( 'Reset Filters', 'agrg' ); ?></span>

							</div>

						</div>

					</div>

					<input type="hidden" id="companies_current_page" name="companies_current_page" value="1" />

					<input type="hidden" id="companies_map_block" name="companies_map_block" value="" />

					<input type="hidden" name="action" value="wpjobusSubmitJobsFilter" />
					<?php wp_nonce_field( 'wpjobusSubmitJobsFilter_html', 'wpjobusSubmitJobsFilter_nonce' ); ?>

				</form>

				<script type="text/javascript">

					jQuery(function($) {

						$(document).ready( function() {

							jQuery( "#advance-search-slider" ).slider({
						      	range: "min",
						      	value: <?php echo $medium; ?>,
						      	min: <?php echo $min; ?>,
						      	max: <?php echo $max; ?>,
						      	slide: function( event, ui ) {
						       		jQuery( "#comp_est_year" ).val( ui.value );
						       		jQuery( ".comp_est_year_num" ).text( ui.value );
						      	},
						      	stop: function() {
						      		jQuery('#companies_current_page').val('1');
					              	$.fn.wpjobusSubmitFormFunction();
					              	$.fn.wpjobusSubmitFormMapFunction();
					          	}  
						    });

							jQuery("#comp_min_team").focusout(function() {
								jQuery('#companies_current_page').val('1');
					            $.fn.wpjobusSubmitFormFunction();
					            $.fn.wpjobusSubmitFormMapFunction();
							});

							jQuery("#comp_keyword").focusout(function() {
					            $.fn.wpjobusSubmitFormFunction();
					            $.fn.wpjobusSubmitFormMapFunction();
							});

							jQuery("#comp_keyword").keydown(function() {
								if (event.keyCode == 13) {
						            $.fn.wpjobusSubmitFormFunction();
						            $.fn.wpjobusSubmitFormMapFunction();
						        }
							});

							jQuery("#comp_max_team").focusout(function() {
								jQuery('#companies_current_page').val('1');
					            $.fn.wpjobusSubmitFormFunction();
					            $.fn.wpjobusSubmitFormMapFunction();
							});

							jQuery(document).on("click","ul.filters-lists li.filters-list-one",function(e){

								jQuery('#companies_current_page').val('1');
						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery(this).find('.job_presence_type_option').val('');

							        $.fn.wpjobusSubmitFormFunction();
							        $.fn.wpjobusSubmitFormMapFunction();

							        e.preventDefault();
									return false;

							    } else {

							       	jQuery(this).addClass('active');
							       	var id = jQuery(this).find('.job_presence_type_option_value').val();
							       	jQuery(this).find('.job_presence_type_option').val(id);
							       	jQuery(this).parent().find('.filters-list-all').removeClass('active');
							       	jQuery(this).parent().find('.filters-list-all .job_presence_type_option').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							   }

							});

							jQuery(document).on("click","ul.filters-lists li.filters-list-all",function(e){

						     	if (jQuery(this).hasClass('active')) {
							        jQuery(this).removeClass('active');
							        jQuery(this).find('.job_presence_type_option').val('');
							    } else {

							    	jQuery('#companies_current_page').val('1');

							       	jQuery(this).addClass('active');
							       	jQuery(this).find('.job_presence_type_option').val('1');
							       	jQuery(this).parent().find('.filters-list-one').removeClass('active');
							       	jQuery(this).parent().find('.filters-list-one .job_presence_type_option').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							    }
							});

							jQuery(document).on("click","ul.filters-lists li.filters-list-career-one",function(e){

								jQuery('#companies_current_page').val('1');
						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery(this).find('.job_career_level_option').val('');

							        $.fn.wpjobusSubmitFormFunction();
							        $.fn.wpjobusSubmitFormMapFunction();

							        e.preventDefault();
									return false;

							    } else {

							       	jQuery(this).addClass('active');
							       	var id = jQuery(this).find('.job_career_level_option_value').val();
							       	jQuery(this).find('.job_career_level_option').val(id);
							       	jQuery(this).parent().find('.filters-list-career-all').removeClass('active');
							       	jQuery(this).parent().find('.filters-list-career-all .job_career_level_option').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							   }

							});

							jQuery(document).on("click","ul.filters-lists li.filters-list-career-all",function(e){

						     	if (jQuery(this).hasClass('active')) {
							        jQuery(this).removeClass('active');
							        jQuery(this).find('.job_career_level_option').val('');
							    } else {

							    	jQuery('#companies_current_page').val('1');

							       	jQuery(this).addClass('active');
							       	jQuery(this).find('.job_career_level_option').val('1');
							       	jQuery(this).parent().find('.filters-list-career-one').removeClass('active');
							       	jQuery(this).parent().find('.filters-list-career-one .job_career_level_option').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							    }
							});

							jQuery(document).on("click",".pagination a.page-numbers",function(e){

						     	var hrefprim = jQuery(this).attr('href');
						     	var href = hrefprim.replace("#", "");

		                		jQuery('#companies_current_page').val(href);

						     	$.fn.wpjobusSubmitFormFunction();
						     	$.fn.wpjobusSubmitFormMapFunction();

						     	e.preventDefault();
								return false;

							});

							jQuery(".pagination a.page-numbers").click(function(e){

						     	var hrefprim = jQuery(this).attr('href');
						     	var href = hrefprim.replace("#", "");

		                		jQuery('#companies_current_page').val(href);

						     	$.fn.wpjobusSubmitFormFunction();
						     	$.fn.wpjobusSubmitFormMapFunction();

						     	e.preventDefault();
								return false;

							});

							jQuery(document).on("click",".filters-list-location-all",function(e){

						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery('.company-location-all').val('');

							    } else {

							    	jQuery('#companies_current_page').val('1');

							       	jQuery(this).addClass('active');
							       	jQuery('.company-location-all').val('1');

							       	jQuery('.filters-list-location').removeClass('active');
							       	jQuery('.company-location').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							    }
							});

							jQuery(document).on("click",".filters-list-location",function(e){

								jQuery('#companies_current_page').val('1');
						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery(this).find('.company-location').val('');

							        $.fn.wpjobusSubmitFormFunction();
							        $.fn.wpjobusSubmitFormMapFunction();

							        e.preventDefault();
									return false;

							    } else {

							       	jQuery(this).addClass('active');
							       	var id = jQuery(this).find('.company-location-value').val();
							       	jQuery(this).find('.company-location').val(id);
							       	jQuery(this).parent().find('.filters-list-location-all').removeClass('active');
							       	jQuery(this).parent().find('.company-location-all').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							   }

							});

							jQuery(document).on("click",".filters-list-presence-all",function(e){

						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery('.company-presence-all').val('');

							    } else {

							    	jQuery('#companies_current_page').val('1');

							       	jQuery(this).addClass('active');
							       	jQuery('.company-presence-all').val('1');

							       	jQuery('.filters-list-presence').removeClass('active');
							       	jQuery('.company-presence').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							    }
							});

							jQuery(document).on("click",".filters-list-presence",function(e){

								jQuery('#companies_current_page').val('1');
						     	if (jQuery(this).hasClass('active')) {

							        jQuery(this).removeClass('active');
							        jQuery(this).find('.company-presence').val('');

							        $.fn.wpjobusSubmitFormFunction();
							        $.fn.wpjobusSubmitFormMapFunction();

							        e.preventDefault();
									return false;

							    } else {

							       	jQuery(this).addClass('active');
							       	var id = jQuery(this).find('.company-presence-value').val();
							       	jQuery(this).find('.company-presence').val(id);
							       	jQuery(this).parent().find('.filters-list-presence-all').removeClass('active');
							       	jQuery(this).parent().find('.filters-presence-all-input').val('');

							       	$.fn.wpjobusSubmitFormFunction();
							       	$.fn.wpjobusSubmitFormMapFunction();

							       	e.preventDefault();
									return false;

							   }

							});

							jQuery(document).on("click","#comp-reset",function(e){

								jQuery('#comp_min_team').val('');
							    jQuery('#comp_max_team').val('');
							    jQuery('#comp_keyword').val('');

							    jQuery("#comp_est_year" ).val( '<?php echo $min; ?>' );

							    jQuery('#companies_current_page').val('1');

							    jQuery('.filters-list-all').addClass('active');
							    jQuery('.job_presence_type_option').val('1');

							    jQuery('.filters-list-one').removeClass('active');
							    jQuery('.filters-list-one .job_presence_type_option').val('');

							    jQuery('.filters-list-presence-all').addClass('active');
							    jQuery('.company-presence-all').val('1');

							    jQuery('.filters-list-presence').removeClass('active');
							    jQuery('.company-presence').val('');

							    jQuery('.filters-list-location-all').addClass('active');
							    jQuery('.company-location-all').val('1');

							    jQuery('.filters-list-location').removeClass('active');
							    jQuery('.company-location').val('');

							    jQuery('.filters-list-career-all').addClass('active');
							    jQuery('.job_career_level_option').val('1');

							    jQuery('.filters-list-career-one').removeClass('active');
							    jQuery('.filters-list-career-one .job_career_level_option').val('');

					            $.fn.wpjobusSubmitFormFunction();
					            $.fn.wpjobusSubmitFormMapFunction();

							});

							$.fn.wpjobusSubmitFormFunction = function() {

								jQuery('#companies_map_block').val('0');

								$contentheight = jQuery('#companies-block').height(),
								jQuery("html, body").animate({ scrollTop: 0 }, 800);

								jQuery('#wpjobus-companies').ajaxSubmit({
								    type: "POST",
									data: jQuery('#wpjobus-companies').serialize(),
									url: '<?php echo admin_url('admin-ajax.php'); ?>',
									beforeSend: function() { 
							        	jQuery('.loading').fadeIn(500);
							        	jQuery('#companies-block').stop().animate({'opacity' : '0'}, 250, function() {
							        		jQuery('#companies-block').css('height', $contentheight);
							        	}); 
							        },	 
								    success: function(response) {
										jQuery('.loading').fadeOut(100, function(){
							        		jQuery("#companies-block").html(response);
							        		jQuery("#companies-block").css('height', 'auto');
								            jQuery("#companies-block").stop().animate({'opacity' : '1'}, 250);

								            jQuery('#companies-block-list-ul').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
											  	if (isInView) {
											    	// element is now visible in the viewport
											    	if (jQuery(this).hasClass('animated-list')) {
											            
											        } else {
											        	jQuery(this).addClass('animated-list');

											        	jQuery('#companies-block-list-ul li').each(function(i) {
															var $li = jQuery(this);
															setTimeout(function() {
															    $li.addClass('animate');
															}, i*100); // delay 150 ms
														});
											        }

											  	}
											});
							        	});
								        return false;
								    }
								});
							}

							$.fn.wpjobusSubmitFormMapFunction = function() {

								mapDiv = jQuery("#wpjobus-main-map");

								mapDiv.gmap3('clear', 'markers');

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
									}
								},"autofit");

								map = mapDiv.gmap3("get");

								jQuery('#companies_map_block').val('1');
								
								jQuery('#wpjobus-companies').ajaxSubmit({
								    type: "POST",
									data: jQuery('#wpjobus-companies').serialize(),
									url: '<?php echo admin_url('admin-ajax.php'); ?>',
									beforeSend: function() { 
							        	jQuery('#wpjobus-main-map-preloader').fadeIn(500);
							        },	 
								    success: function(response) {
										jQuery('#wpjobus-main-map-preloader').fadeOut(100, function(){
							        		jQuery("#big-map-holder").html(response);
							        	});
								        return false;
								    }
								});
							};

						});

					});

				</script>

			</div>

			<div class="full">
				<h1 class="resume-section-title"><i class="fa fa-files-o"></i><?php _e( 'Recent News', 'agrg' ); ?></h1>
				<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'These are the latest news from our blog.', 'agrg' ); ?></h3>
			</div>

			<?php

				global $paged, $wp_query, $wp;

				$args = wp_parse_args($wp->matched_query);

				$temp = $wp_query;

				$wp_query= null;

				$wp_query = new WP_Query();

				$wp_query->query('post_type=post&posts_per_page=3');

				$current_post = 0;

			?>

			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current_post++; if($current_post <= 3) { ?>

			<div class="one_third <?php if($current_post == 1) { ?>first<?php } ?>" style="text-align: center; margin-bottom: 0;">

				<?php if ( has_post_thumbnail() ) { ?>

				<div class="full">

					<?php require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); ?>

					<?php

						$params = array( 'width' => 550, 'height' => 380, 'crop' => true );
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');

					?>

					<a href="<?php the_permalink() ?>"><img src="<?php echo bfi_thumb( "$large_image_url[0]", $params ); ?>" alt="<?php the_title(); ?>" style="width: 100%; height: auto;"></a>

				</div>

				<?php } ?>

				<h3 style="float: left; width: 100%; text-align: center; margin: 0;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

				<div class="full post-meta" style="margin-bottom: 0;">
					<p><i class="fa fa-user" style="margin: 0 10px;"></i><?php the_author_posts_link(); ?><i class="fa fa-clock-o" style="margin: 0 10px;"></i><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M j, Y') ?></a><i class="fa fa-comment" style="margin: 0 10px;"></i><a href="<?php comments_link(); ?>"><?php $my_comments = get_comments_number( $post->ID ); echo $my_comments; ?></a></p>
				</div>

				<div class="full" style="margin-bottom: 0;">
					<?php
						$content = get_the_content();
						echo wp_trim_words( $content , '25' ); 
					?>
					<p><a href="<?php the_permalink() ?>"><?php _e( 'Read More', 'agrg' ); ?></a></p>
				</div>

			</div>

			<?php } endwhile; ?>
							
			<?php $wp_query = null; $wp_query = $temp;?>
			
		</div>

	</section>

<?php get_footer(); ?>