<?php
/**
 * Template name: Companies
 */



$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<?php 

		// Retrieve the URL variables (using PHP).
		if (isset($_GET['keyword'])) {
		    $keyword = $_GET['keyword'];
		} else {
		    $keyword = "";
		}

		if (isset($_GET['company_location'])) {
		    $job_location = $_GET['company_location'];
		} else {
		    $job_location = "";
		}

		if($job_location == "all") {
			$job_location = "";
		}

		if (isset($_GET['company_industry'])) {
		    $job_type = $_GET['company_industry'];
		} else {
		    $job_type = "";
		}

		if($job_type == "all") {
			$job_type = "";
		}

		if(!empty($job_type)) {

			$string = "AND m.meta_key = 'company_industry' AND m.meta_value LIKE '%" . $job_type . "%'";

		} else {

			$string = "";

		}

		if(!empty($job_location)) {

			$stringLocation = "AND m2.meta_key = 'company_location' AND m2.meta_value = '" . $job_location . "'";

		} else {

			$stringLocation = "";

		}

		if(!empty($keyword)) {

			$stringKeyword = "AND (m4.meta_key = 'wpjobus_company_fullname' AND m4.meta_value LIKE '%" . $keyword . "%')";

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
																	WHERE p.post_type =  'company'
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
										$wpjobus_company_profile_picture = esc_url(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
										$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
										$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
										$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

										$wpjobus_company_longitude = esc_attr(get_post_meta($company_id, 'wpjobus_company_longitude',true));
										$wpjobus_company_latitude = esc_attr(get_post_meta($company_id, 'wpjobus_company_latitude',true));

										$iconPath = get_template_directory_uri() .'/images/icon-company.png';

										$wpjobus_company_profile_picture = esc_url(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));

										if(!empty($wpjobus_company_latitude)) {

							?> 
								{

									latLng: [<?php echo $wpjobus_company_latitude; ?>,<?php echo $wpjobus_company_longitude; ?>],
									options: {
										icon: "<?php echo esc_attr($iconPath); ?>",
										shadow: "<?php echo get_template_directory_uri() ?>/images/shadow.png",
									},
									data: '<div class="marker-holder"><div class="marker-content"><div class="marker-image"><span class="helper"></span><img src="<?php echo $wpjobus_company_profile_picture; ?>" /></div><div class="marker-info-holder"><div class="marker-info"><div class="marker-info-title"><?php echo $wpjobus_company_fullname; ?></div><div class="marker-info-link"><a href="<?php $companylink = home_url()."/company/".$company_id; echo $companylink; ?>"><?php _e( "View Profile", "agrg" ); ?></a></div></div></div><div class="arrow-down"></div><div class="close"></div></div></div>'

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
							<h1 class="resume-section-title"><i class="fa fa-search"></i><?php _e( 'Search for Companies', 'agrg' ); ?></h1>
							<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Use our awesome search tool to find companies’profiles!', 'agrg' ); ?></h3>
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
																	WHERE p.post_type =  'company'
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
										$wpjobus_company_profile_picture = esc_url(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
										$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
										$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
										$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
										$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

							?> 

							<li id="<?php echo $current_element_id; ?>">

								<a href="<?php $companylink = home_url()."/company/".$company_id; echo $companylink; ?>">

									<div class="company-holder-block">

										<span class="company-list-icon">
											<span class="helper"></span>
											<img src="<?php echo $wpjobus_company_profile_picture; ?>" alt="<?php echo $wpjobus_company_fullname; ?>" />
										</span>

										<span class="company-list-name-block">
											<span class="company-list-name"><?php echo $wpjobus_company_fullname; ?></span>
											<span class="company-list-location"><i class="fa fa-map-marker"></i><?php echo $company_location; ?>
											</span>
										</span>

										<span class="company-list-view-profile">

											<span class="company-view-profile">
												<span class="company-view-profile-title-holder">
													<span class="company-view-profile-title"><?php _e( 'View', 'agrg' ); ?></span>
													<span class="company-view-profile-subtitle"><?php _e( 'Profile', 'agrg' ); ?></span>
												</span>
												<i class="fa fa-eye"></i>
											</span>

										</span>

										<span class="company-list-badges">

											<span class="company-est-year-block">
												<i class="fa fa-calendar"></i>
												<span class="experience-period"><?php _e( 'Est. In', 'agrg' ); ?></span>
												<span class="experience-subtitle"><?php echo $wpjobus_company_foundyear; ?></span>
											</span>

											<span class="company-team-block">
												<i class="fa fa-users"></i>
												<span class="experience-period"><?php echo $company_team_size; ?></span>
												<span class="experience-subtitle"><?php _e( 'People', 'agrg' ); ?></span>
											</span>

											<?php 

												$jobs_offer = 0;

												$id = $company_id;

												$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_company' AND $wpdb->postmeta.meta_value = $id AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'job' AND $wpdb->posts.post_date < NOW() ORDER BY $wpdb->posts.post_date DESC
													";

												$pageposts = $wpdb->get_results($querystr, OBJECT);

												$jobs_offer = 0;

											?>

											<?php global $post; ?>
											<?php foreach ($pageposts as $post): ?>
												
											<?php $jobs_offer++; ?>

											<?php endforeach; ?>
												

											<span class="company-jobs-block">
												<i class="fa fa-bullhorn"></i>
												<span class="experience-period"><?php echo $jobs_offer; ?></span>
												<span class="experience-subtitle"><?php if($jobs_offer != 1){ ?><?php _e( 'Jobs', 'agrg' ); ?><?php } else { ?><?php _e( 'Job', 'agrg' ); ?><?php } ?></span>
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

					<div class="one_third">

						<?php 

							$currentDate = current_time('timestamp');

							$total_jobs = 0;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																WHERE p.post_type = 'company'
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

						<span class="filters-title"><i class="fa fa-star"></i><?php _e( 'Featured Companies!', 'agrg' ); ?></span>

						<div id="owl-demo" class="owl-carousel owl-theme featured-items">

							<?php foreach($wpjobus_jobs as $job) {

								$curren_job++; 
								  	
								$job_id = $job->ID;

								if($curren_job <= 5) {

							?>

							<div class="item">

						  		<a href="<?php $link_job = home_url()."/company/".$job_id; echo $link_job; ?>">

							  		<div class="featured-item">

							  			<span class="featured-item-image">

							  				<?php 

							  					$wpjobus_company_cover_image = esc_url(get_post_meta($job_id, 'wpjobus_company_cover_image',true));
							  					$wpjobus_company_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_company_fullname',true));
												$wpjobus_company_tagline = esc_attr(get_post_meta($job_id, 'wpjobus_company_tagline',true));
												$wpjobus_company_foundyear = esc_attr(get_post_meta($job_id, 'wpjobus_company_foundyear',true));
												$company_location = esc_attr(get_post_meta($job_id, 'company_location',true));
												$wpjobus_company_profile_picture = esc_url(get_post_meta($job_id, 'wpjobus_company_profile_picture',true));

									    		$total_jobs = 0;

									    		$company_jobs = $wpdb->get_results( "SELECT p.ID
																					FROM  `{$wpdb->prefix}posts` p
																					LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
																					WHERE p.post_type = 'job'
																					AND (p.post_status = 'publish' or p.post_status = 'draft' or p.post_status = 'pending')
																					AND m.meta_key = 'job_company' AND m.meta_value = '".$job_id."'
																					");
						  
												foreach($company_jobs as $job) { 
													$total_jobs++;
												}	

							  					if(!empty($wpjobus_company_cover_image)) {

									  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
													$params = array( 'width' => 340, 'height' => 200, 'crop' => true );
													echo "<img class='big-img' src='" . bfi_thumb( "$wpjobus_company_cover_image", $params ) . "' alt='" . $wpjobus_company_fullname . "'/>";

												} else {

													echo "<span class='featured-image-replacer'><i class='fa fa-briefcase'></i>";

												}

											?>

											<?php if(!empty($wpjobus_company_profile_picture)) { ?>

							  				<span class="featured-item-content-title-logo">
							  					<span class="featured-item-content-company-title-logo-img">
								  					<span class="helper"></span>
								  					<img src="<?php echo $wpjobus_company_profile_picture; ?>" alt="">
								  				</span>
							  				</span>

							  				<?php } ?>

							  			</span>

							  			<span class="featured-item-badge">

							  				<span class="featured-item-job-badge">

							  					<span class="featured-item-job-badge-title"><?php _e( 'EST. IN', 'agrg' ); ?> <?php echo $wpjobus_company_foundyear; ?></span>

							  					<span class="featured-item-job-badge-info">

							  						<span class="featured-item-job-badge-info-sum"><?php echo $total_jobs; ?></span>

													<span class="featured-item-job-badge-info-per"><?php if($total_jobs == 1) { _e( 'Job', 'agrg' ); } else { _e( 'Jobs', 'agrg' ); } ?></span>						  						

							  					</span>

							  				</span>

							  			</span>

							  			<span class="featured-item-content">

							  				<span class="featured-item-content-title"><?php echo $wpjobus_company_fullname; ?></span>
							  				<span class="featured-item-content-tagline"><?php echo $wpjobus_company_tagline; ?></span>
							  				<span class="featured-item-content-subtitle">

							  					<span><i class="fa fa-map-marker"></i><?php echo $company_location; ?></spam>

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

								<div class="three_fifth first">

									<span class="filters-subtitle"><?php _e( 'Categories', 'agrg' ); ?></span>

									<ul class="filters-lists-category">

										<li class="filters-list-category-all <?php if(empty($job_type)) { ?>active<?php }?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Categories', 'agrg' ); ?>
											<input type="hidden" class="company-category-all" name="company_category_all" value="<?php if(empty($job_type)) { ?>1<?php } ?>" />
										</li>

										<?php 
											global $redux_demo; 
											for ($i = 0; $i < count($redux_demo['resume-industries']); $i++) {
										?>
										
										<li class="filters-list-category-one <?php if($job_type == $redux_demo['resume-industries'][$i] ) { ?>active<?php } ?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['resume-industries'][$i]; ?>
											<input type="hidden" class="company-category-value" name="company_category_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['resume-industries'][$i]; ?>" />
											<input type="hidden" class="company-category" name="company_category[<?php echo $i; ?>]" value="<?php if($job_type == $redux_demo['resume-industries'][$i] ) { echo $redux_demo['resume-industries'][$i]; } ?>" />
										</li>

										<?php 
											}
										?>

									</ul>

								</div>

								<div class="two_fifth">

									<span class="filters-subtitle"><?php _e( 'Locations', 'agrg' ); ?></span>

									<ul class="filters-lists-location">

										<li class="filters-list-location-all <?php if(empty($job_location)) { ?>active<?php }?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Locations', 'agrg' ); ?>
											<input type="hidden" class="company-location-all" name="company_location_all" value="<?php if(empty($job_location)) { ?>1<?php } ?>" />
										</li>

										<?php 
											global $redux_demo; 
											for ($i = 0; $i < count($redux_demo['resume-locations']); $i++) {
										?>
										
										<li class="filters-list-location <?php if($job_location == $redux_demo['resume-locations'][$i] ) { ?>active<?php } ?>">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['resume-locations'][$i]; ?>
											<input type="hidden" class="company-location-value" name="company_location_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['resume-locations'][$i]; ?>" />
											<input type="hidden" class="company-location" name="company_location[<?php echo $i; ?>]" value="<?php if($job_location == $redux_demo['resume-locations'][$i] ) { echo $redux_demo['resume-locations'][$i]; } ?>" />
										</li>

										<?php 
											}
										?>

									</ul>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<span class="filters-subtitle"><?php _e( 'Established Since', 'agrg' ); ?></span>

								<?php

									$wpjobus_companies_est_year = $wpdb->get_results( "SELECT DISTINCT m.meta_value FROM  `{$wpdb->prefix}posts` p LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id WHERE p.post_type =  'company' AND p.post_status =  'publish' AND m.meta_key = 'wpjobus_company_foundyear' ORDER BY  m.meta_value+0 ASC");

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

									<p><?php _e( 'Older than:', 'agrg' ); ?> <span class="comp_est_year_num"><?php echo $medium; ?></span></p>

								</div>

								<div class="one_half">

									<div id="advance-search-slider" class="ui-slider-horizontal" aria-disabled="false">
										<a class="ui-slider-handle" href="#"></a>
										<input type="hidden" name="comp_est_year" id="comp_est_year" value="<?php echo $min; ?>" >
									</div>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<span class="filters-subtitle"><?php _e( 'Team Size', 'agrg' ); ?></span>

								<div class="full">

									<p class="comp_team_holder" style="margin-bottom: 0;"><?php _e( 'From', 'agrg' ); ?> <input type="text" name="comp_min_team" id="comp_min_team" value="" > <?php _e( 'to', 'agrg' ); ?> <input type="text" name="comp_max_team" id="comp_max_team" value="" > <?php _e( 'people', 'agrg' ); ?></p>

								</div>

							</div>

							<div class="full sidebar-widget-bottom-line">

								<div class="one_half first">

									<span class="filters-subtitle"><?php _e( 'Has Job Offers', 'agrg' ); ?></span>

									<ul class="filters-lists-main">
										
										<li class="filters-has-jobs-all active">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Companies', 'agrg' ); ?>
											<input type="hidden" class="filters-has-jobs-all-input" name="filters_has_jobs_all" value="1" />
										</li>

										<li class="filters-has-jobs-yes">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'Has Job Offer', 'agrg' ); ?>
											<input type="hidden" class="filters-has-jobs-yes-input" name="filters_has_jobs_yes" value="" />
										</li>

										<li class="filters-has-jobs-no">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'No Job Offer', 'agrg' ); ?>
											<input type="hidden" class="filters-has-jobs-no-input" name="filters_has_jobs_no" value="" />
										</li>

									</ul>

								</div>

								<div class="one_half">

									<span class="filters-subtitle"><?php _e( 'Job Offers', 'agrg' ); ?></span>

									<ul class="filters-lists">

										<li class="filters-list-all">
											<i class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php _e( 'All Types', 'agrg' ); ?>
											<input type="hidden" class="job_presence_type_option" name="job_presence_type_all" value="1" />
										</li>

										<?php 
											global $redux_demo; 
											for ($i = 0; $i < count($redux_demo['job-type']); $i++) {
										?>
										
										<li class="filters-list-one">
											<i id="job-type[<?php echo $i; ?>]" class="fa fa-square-o"></i><i class="fa fa-check-square"></i><?php echo $redux_demo['job-type'][$i]; ?>
											<input type="hidden" class="job_presence_type_option_value" name="job_presence_type_value[<?php echo $i; ?>]" value="<?php echo $redux_demo['job-type'][$i]; ?>" />
											<input type="hidden" class="job_presence_type_option" name="job_presence_type[<?php echo $i; ?>]" value="" />
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

					<input type="hidden" name="action" value="wpjobusSubmitCompaniesFilter" />
					<?php wp_nonce_field( 'wpjobusSubmitCompaniesFilter_html', 'wpjobusSubmitCompaniesFilter_nonce' ); ?>

				</form>

				<script type="text/javascript">

				jQuery(function($) {

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

					jQuery("#comp_max_team").focusout(function() {
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

					jQuery(document).on("click","#comp-team-submit-clear",function(e){
					    jQuery('#comp_min_team').val('');
					    jQuery('#comp_max_team').val('');
					});

					jQuery(document).on("click","#comp-reset",function(e){

						jQuery('#comp_min_team').val('');
					    jQuery('#comp_max_team').val('');
					    jQuery('#comp_keyword').val('');

					    jQuery('#companies_current_page').val('1');

					    jQuery('.filters-list-category-all').addClass('active');
					    jQuery('.company-category-all').val('1');

					    jQuery('.filters-list-category-one').removeClass('active');
					    jQuery('.company-category').val('');

					    jQuery('.filters-list-location-all').addClass('active');
					    jQuery('.company-location-all').val('1');

					    jQuery('.filters-list-location').removeClass('active');
					    jQuery('.company-location').val('');

					    jQuery( "#comp_est_year" ).val( '<?php echo $min; ?>' );

					    jQuery('.filters-has-jobs-all').addClass('active');
					    jQuery('.filters-has-jobs-all-input').val('1');

					    jQuery('.filters-has-jobs-yes').removeClass('active');
					   	jQuery('.filters-has-jobs-yes-input').val('');

					    jQuery('.filters-has-jobs-no').removeClass('active');
					   	jQuery('.filters-has-jobs-no-input').val('');

					    jQuery('.filters-lists li').removeClass('active');
					    jQuery('.filters-lists input.job_presence_type_option').val('');

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

					       	jQuery('.filters-has-jobs-yes').addClass('active');
					       	jQuery('.filters-has-jobs-yes-input').val('1');

					       	jQuery('.filters-has-jobs-all').removeClass('active');
					       	jQuery('.filters-has-jobs-all-input').val('');

					       	jQuery('.filters-has-jobs-no').removeClass('active');
					       	jQuery('.filters-has-jobs-no-input').val('');

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

					       	jQuery('.filters-has-jobs-yes').addClass('active');
					       	jQuery('.filters-has-jobs-yes-input').val('1');

					       	jQuery('.filters-has-jobs-all').removeClass('active');
					       	jQuery('.filters-has-jobs-all-input').val('');

					       	jQuery('.filters-has-jobs-no').removeClass('active');
					       	jQuery('.filters-has-jobs-no-input').val('');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					    }
					});

					jQuery(document).on("click",".filters-has-jobs-all",function(e){

				     	if (jQuery(this).hasClass('active')) {
					        jQuery(this).removeClass('active');
					        jQuery('.filters-has-jobs-all-input').val('');
					    } else {

					    	jQuery('#companies_current_page').val('1');

					       	jQuery(this).addClass('active');
					       	jQuery('.filters-has-jobs-all-input').val('1');

					       	jQuery('.filters-has-jobs-yes').removeClass('active');
					       	jQuery('.filters-has-jobs-yes-input').val('');

					       	jQuery('.filters-has-jobs-no').removeClass('active');
					       	jQuery('.filters-has-jobs-no-input').val('');

					       	jQuery('.filters-lists li').removeClass('active');
					       	jQuery('.filters-lists input.job_presence_type_option').val('');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					    }
					});

					jQuery(document).on("click",".filters-has-jobs-yes",function(e){

				     	if (jQuery(this).hasClass('active')) {
					        jQuery(this).removeClass('active');
					        jQuery('.filters-has-jobs-yes-input').val('');
					    } else {

					    	jQuery('#companies_current_page').val('1');

					       	jQuery(this).addClass('active');
					       	jQuery('.filters-has-jobs-yes-input').val('1');

					       	jQuery('.filters-has-jobs-all').removeClass('active');
					       	jQuery('.filters-has-jobs-all-input').val('');

					       	jQuery('.filters-has-jobs-no').removeClass('active');
					       	jQuery('.filters-has-jobs-no-input').val('');

					       	jQuery('.filters-lists li').removeClass('active');
					       	jQuery('.filters-lists input.job_presence_type_option').val('');

					       	jQuery('.filters-list-all').addClass('active');
					       	jQuery('.filters-list-all .job_presence_type_option').val('1');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					    }
					});

					jQuery(document).on("click",".filters-has-jobs-no",function(e){

				     	if (jQuery(this).hasClass('active')) {
					        jQuery(this).removeClass('active');
					        jQuery('.filters-has-jobs-no-input').val('');
					    } else {

					    	jQuery('#companies_current_page').val('1');

					       	jQuery(this).addClass('active');
					       	jQuery('.filters-has-jobs-no-input').val('1');

					       	jQuery('.filters-has-jobs-yes').removeClass('active');
					       	jQuery('.filters-has-jobs-yes-input').val('');

					       	jQuery('.filters-has-jobs-all').removeClass('active');
					       	jQuery('.filters-has-jobs-all-input').val('');

					       	jQuery('.filters-lists li').removeClass('active');
					       	jQuery('.filters-lists input.job_presence_type_option').val('');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					    }
					});

					jQuery(document).on("click",".filters-list-category-all",function(e){

				     	if (jQuery(this).hasClass('active')) {

					        jQuery(this).removeClass('active');
					        jQuery('.company-category-all').val('');

					    } else {

					    	jQuery('#companies_current_page').val('1');

					       	jQuery(this).addClass('active');
					       	jQuery('.company-category-all').val('1');

					       	jQuery('.filters-list-category-one').removeClass('active');
					       	jQuery('.company-category').val('');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					    }
					});

					jQuery(document).on("click",".filters-list-category-one",function(e){

						jQuery('#companies_current_page').val('1');
				     	if (jQuery(this).hasClass('active')) {

					        jQuery(this).removeClass('active');
					        jQuery(this).find('.company-category').val('');

					        $.fn.wpjobusSubmitFormFunction();
					        $.fn.wpjobusSubmitFormMapFunction();

					        e.preventDefault();
							return false;

					    } else {

					       	jQuery(this).addClass('active');
					       	var id = jQuery(this).find('.company-category-value').val();
					       	jQuery(this).find('.company-category').val(id);
					       	jQuery(this).parent().find('.filters-list-category-all').removeClass('active');
					       	jQuery(this).parent().find('.company-category-all').val('');

					       	$.fn.wpjobusSubmitFormFunction();
					       	$.fn.wpjobusSubmitFormMapFunction();

					       	e.preventDefault();
							return false;

					   }

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
					}

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