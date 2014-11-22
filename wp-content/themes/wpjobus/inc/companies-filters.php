<?php

function wpjobusSubmitCompaniesFilter() {

  	if ( isset( $_POST['wpjobusSubmitCompaniesFilter_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitCompaniesFilter_nonce'], 'wpjobusSubmitCompaniesFilter_html' ) ) {

  		$companies_map_block = $_POST['companies_map_block'];

  		if($companies_map_block == 0) {

			global $wpdb, $companies_per_page, $total_companies, $total_pages, $current_page;

			$companies_per_page = 18;

			$total_companies = 0;

			$current_page = $_POST['companies_current_page'];

			$job_presence_type = $_POST['job_presence_type'];
			$job_presence_type_all = $_POST['job_presence_type_all'];
			$filters_has_jobs_all = $_POST['filters_has_jobs_all'];
			$filters_has_jobs_no = $_POST['filters_has_jobs_no'];

			$company_category_all = $_POST['company_category_all'];
			$company_category = $_POST['company_category'];

			$company_location_all = $_POST['company_location_all'];
			$company_location = $_POST['company_location'];

			$comp_est_year = $_POST['comp_est_year'];

			$companies_map_block = $_POST['companies_map_block'];

			$comp_min_team = $_POST['comp_min_team'];
			$comp_max_team = $_POST['comp_max_team'];

			if(!empty($comp_min_team)) {

			  	$string_comp_min_team = "AND m6.meta_key = 'company_team_size' AND m6.meta_value >= ".$comp_min_team."";

			} else {

			  	$string_comp_min_team = "";

			}

			if(!empty($comp_max_team)) {

			  	$string_comp_max_team = "AND m7.meta_key = 'company_team_size' AND m7.meta_value <= ".$comp_max_team."";

			} else {

			  	$string_comp_max_team = "";

			}

			if(!empty($comp_est_year)) {

			  	$stringEstYear = "AND m5.meta_key = 'wpjobus_company_foundyear' AND m5.meta_value >= ".$comp_est_year."";

			} else {

			  	$stringEstYear = "";

			}

			$stringOriginalCat = '';
			$stringOriginalCountCat = 0;

			for ($countP = 0; $countP < count($company_category); $countP++) { 

			  	if(!empty($company_category[$countP])) { 

					if($stringOriginalCountCat != 0) {
					  $stringOriginalCountCatPrim = " OR ";
					} else {
					  $stringOriginalCountCatPrim = "";
					}

					$stringOriginalCat .= $stringOriginalCountCatPrim."m4.meta_value = '". $company_category[$countP] ."'";

					$stringOriginalCountCat++;

			  	} 

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			}

			$stringOriginalLoc = '';
			$stringOriginalCountLoc = 0;

			for ($countS = 0; $countS < count($company_location); $countS++) { 

			  	if(!empty($company_location[$countS])) { 

					if($stringOriginalCountLoc != 0) {
					  $stringOriginalCountLocPrim = " OR ";
					} else {
					  $stringOriginalCountLocPrim = "";
					}

					$stringOriginalLoc .= $stringOriginalCountLocPrim."m3.meta_value = '". $company_location[$countS] ."'";

					$stringOriginalCountLoc++;

			  	} 

			}

			$stringOriginal = '';
			$stringOriginalCount = 0;

			if($job_presence_type_all == 1) {

			  	global $redux_demo; 
			  	for ($i = 0; $i < count($redux_demo['job-type']); $i++) {

					if($stringOriginalCount != 0) {
					  $stringOriginalCountPrim = " OR ";
					} else {
					  $stringOriginalCountPrim = "";
					}

					$stringOriginal .= $stringOriginalCountPrim."m.meta_value = '". $redux_demo['job-type'][$i] ."'";

					$stringOriginalCount++;

			 	}

			} else {

			  	for ($countQ = 0; $countQ < count($job_presence_type); $countQ++) { 

					if(!empty($job_presence_type[$countQ])) { 

					  	if($stringOriginalCount != 0) {
							$stringOriginalCountPrim = " OR ";
					  	} else {
							$stringOriginalCountPrim = "";
					  	}

					  	$stringOriginal .= $stringOriginalCountPrim."m.meta_value = '". $job_presence_type[$countQ] ."'";

					  	$stringOriginalCount++;

					}

			  	}

			}

			if($filters_has_jobs_all == 1 ) { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter

			  	$wpjobus_companies = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

			  	$id_name_status = 1;

			} elseif($filters_has_jobs_no == 1) { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLocJob = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLocJob = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCatJob = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCatJob = "";

			  	}

			  	if(!empty($stringOriginal)) {

			  		$string = "AND m.meta_key = 'wpjobus_job_type'  AND (" . $stringOriginal . ")";

			  	} else {

					$string = "";

			  	}

			  	$wpjobus_companies_jobs = $wpdb->get_results( "SELECT DISTINCT m2.meta_value as post_name
														FROM `{$wpdb->prefix}posts` p
														LEFT JOIN `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														WHERE p.post_type = 'job'
														AND p.post_status = 'publish'
														".$string."
														AND m2.meta_key = 'job_company'
														ORDER BY `p`.`ID` DESC");

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter



			  	$wpjobus_companies_all = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

			  	function compare_by_area($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies = array_udiff($wpjobus_companies_all, $wpjobus_companies_jobs, 'compare_by_area');

			  	$id_name_status = 1;

			} else { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLocJob = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLocJob = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCatJob = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCatJob = "";

			  	}

			  	if(!empty($stringOriginal)) {

			  		$string = "AND m.meta_key = 'wpjobus_job_type'  AND (" . $stringOriginal . ")";

			  	} else {

					$string = "";

			  	}

			  	$wpjobus_companies_jobs = $wpdb->get_results( "SELECT DISTINCT m2.meta_value as post_name
														FROM `{$wpdb->prefix}posts` p
														LEFT JOIN `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														WHERE p.post_type = 'job'
														AND p.post_status = 'publish'
														".$string."
														AND m2.meta_key = 'job_company'
														ORDER BY `p`.`ID` DESC");

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter

			  	$wpjobus_companies_all = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

				function compare_by_area1($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies_no_jobs = array_udiff($wpjobus_companies_all, $wpjobus_companies_jobs, 'compare_by_area1');


			  	function compare_by_area($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies = array_udiff($wpjobus_companies_all, $wpjobus_companies_no_jobs, 'compare_by_area');

			  	$id_name_status = 1;

			}

			?>

			<ul id="companies-block-list-ul">

			<?php
						  
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

					if($id_name_status == 0) {
					  $company_id = $q->meta_value;
					} else {
					  $company_id = $q->post_name;
					}

					$current_element_id++;

					$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
					$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
					$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
					$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
					$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

					$wpjobus_company_longitude = get_post_meta($company_id, 'wpjobus_company_longitude',true);
					$wpjobus_company_latitude = get_post_meta($company_id, 'wpjobus_company_latitude',true);

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
							  	<span class="company-list-location"><i class="fa fa-map-marker"></i><?php echo $company_location; ?></span>
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

			  	$wpcook_pagination['base'] = '#%#%';

			  	if( !empty($wp_query->query_vars['s']) )
					$wpcook_pagination['add_args'] = array('s'=>get_query_var('s'));

					echo '<div class="pagination">' . paginate_links($wpcook_pagination) . '</div>'; 

			}

			$response = ob_get_contents();

		} elseif($companies_map_block == 1) {

			global $wpdb, $companies_per_page, $total_companies, $total_pages, $current_page;

			$companies_per_page = 18;

			$total_companies = 0;

			$current_page = $_POST['companies_current_page'];

			$job_presence_type = $_POST['job_presence_type'];
			$job_presence_type_all = $_POST['job_presence_type_all'];
			$filters_has_jobs_all = $_POST['filters_has_jobs_all'];
			$filters_has_jobs_no = $_POST['filters_has_jobs_no'];

			$company_category_all = $_POST['company_category_all'];
			$company_category = $_POST['company_category'];

			$company_location_all = $_POST['company_location_all'];
			$company_location = $_POST['company_location'];

			$comp_est_year = $_POST['comp_est_year'];

			$companies_map_block = $_POST['companies_map_block'];

			$comp_min_team = $_POST['comp_min_team'];
			$comp_max_team = $_POST['comp_max_team'];

			if(!empty($comp_min_team)) {

			  	$string_comp_min_team = "AND m6.meta_key = 'company_team_size' AND m6.meta_value >= ".$comp_min_team."";

			} else {

			  	$string_comp_min_team = "";

			}

			if(!empty($comp_max_team)) {

			  	$string_comp_max_team = "AND m7.meta_key = 'company_team_size' AND m7.meta_value <= ".$comp_max_team."";

			} else {

			  	$string_comp_max_team = "";

			}

			if(!empty($comp_est_year)) {

			  	$stringEstYear = "AND m5.meta_key = 'wpjobus_company_foundyear' AND m5.meta_value >= ".$comp_est_year."";

			} else {

			  	$stringEstYear = "";

			}

			$stringOriginalCat = '';
			$stringOriginalCountCat = 0;

			for ($countP = 0; $countP < count($company_category); $countP++) { 

			  	if(!empty($company_category[$countP])) { 

					if($stringOriginalCountCat != 0) {
					  $stringOriginalCountCatPrim = " OR ";
					} else {
					  $stringOriginalCountCatPrim = "";
					}

					$stringOriginalCat .= $stringOriginalCountCatPrim."m4.meta_value = '". $company_category[$countP] ."'";

					$stringOriginalCountCat++;

			  	} 

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			}

			$stringOriginalLoc = '';
			$stringOriginalCountLoc = 0;

			for ($countS = 0; $countS < count($company_location); $countS++) { 

			  	if(!empty($company_location[$countS])) { 

					if($stringOriginalCountLoc != 0) {
					  $stringOriginalCountLocPrim = " OR ";
					} else {
					  $stringOriginalCountLocPrim = "";
					}

					$stringOriginalLoc .= $stringOriginalCountLocPrim."m3.meta_value = '". $company_location[$countS] ."'";

					$stringOriginalCountLoc++;

			  	} 

			}

			$stringOriginal = '';
			$stringOriginalCount = 0;

			if($job_presence_type_all == 1) {

			  	global $redux_demo; 
			  	for ($i = 0; $i < count($redux_demo['job-type']); $i++) {

					if($stringOriginalCount != 0) {
					  $stringOriginalCountPrim = " OR ";
					} else {
					  $stringOriginalCountPrim = "";
					}

					$stringOriginal .= $stringOriginalCountPrim."m.meta_value = '". $redux_demo['job-type'][$i] ."'";

					$stringOriginalCount++;

			 	}

			} else {

			  	for ($countQ = 0; $countQ < count($job_presence_type); $countQ++) { 

					if(!empty($job_presence_type[$countQ])) { 

					  	if($stringOriginalCount != 0) {
							$stringOriginalCountPrim = " OR ";
					  	} else {
							$stringOriginalCountPrim = "";
					  	}

					  	$stringOriginal .= $stringOriginalCountPrim."m.meta_value = '". $job_presence_type[$countQ] ."'";

					  	$stringOriginalCount++;

					}

			  	}

			}

			if($filters_has_jobs_all == 1 ) { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter

			  	$wpjobus_companies = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

			  	$id_name_status = 1;

			} elseif($filters_has_jobs_no == 1) { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLocJob = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLocJob = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCatJob = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCatJob = "";

			  	}

			  	if(!empty($stringOriginal)) {

			  		$string = "AND m.meta_key = 'wpjobus_job_type'  AND (" . $stringOriginal . ")";

			  	} else {

					$string = "";

			  	}

			  	$wpjobus_companies_jobs = $wpdb->get_results( "SELECT DISTINCT m2.meta_value as post_name
														FROM `{$wpdb->prefix}posts` p
														LEFT JOIN `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														WHERE p.post_type = 'job'
														AND p.post_status = 'publish'
														".$string."
														AND m2.meta_key = 'job_company'
														ORDER BY `p`.`ID` DESC");

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter

			  	$wpjobus_companies_all = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

			  	function compare_by_area($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies = array_udiff($wpjobus_companies_all, $wpjobus_companies_jobs, 'compare_by_area');

			  	$id_name_status = 1;

			} else { 

			  	if(!empty($stringOriginalLoc)) {

					$stringLocJob = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLocJob = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCatJob = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCatJob = "";

			  	}

			  	if(!empty($stringOriginal)) {

			  		$string = "AND m.meta_key = 'wpjobus_job_type'  AND (" . $stringOriginal . ")";

			  	} else {

					$string = "";

			  	}

			  	$wpjobus_companies_jobs = $wpdb->get_results( "SELECT DISTINCT m2.meta_value as post_name
														FROM `{$wpdb->prefix}posts` p
														LEFT JOIN `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														WHERE p.post_type = 'job'
														AND p.post_status = 'publish'
														".$string."
														AND m2.meta_key = 'job_company'
														ORDER BY `p`.`ID` DESC");

			  	if(!empty($stringOriginalLoc)) {

					$stringLoc = "AND m3.meta_key = 'company_location'  AND (" . $stringOriginalLoc . ")";

			  	} else {

					$stringLoc = "";

			  	}

			  	if(!empty($stringOriginalCat)) {

					$stringCat = "AND m4.meta_key = 'company_industry'  AND (" . $stringOriginalCat . ")";

			  	} else {

					$stringCat = "";

			  	}

			  	// Keyword search filter
				$keyword = $_POST['comp_keyword'];

				if(!empty($keyword)) {

					$stringKeyword = "AND (m11.meta_key = 'wpjobus_company_fullname' AND m11.meta_value LIKE '%" . $keyword . "%')";

				} else {

					$stringKeyword = "";

				}
				// End keyword search filter

			  	$wpjobus_companies_all = $wpdb->get_results( "SELECT DISTINCT p.post_name
														FROM  `{$wpdb->prefix}posts` p
														LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m2 ON p.ID = m2.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m3 ON p.ID = m3.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m4 ON p.ID = m4.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m5 ON p.ID = m5.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m6 ON p.ID = m6.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m7 ON p.ID = m7.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m8 ON p.ID = m8.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m9 ON p.ID = m9.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m10 ON p.ID = m10.post_id
														LEFT JOIN  `{$wpdb->prefix}postmeta` m11 ON p.ID = m11.post_id
														WHERE p.post_type =  'company'
														AND p.post_status =  'publish'
														".$stringCat."
														".$stringLoc."
														".$stringEstYear."
														".$string_comp_min_team."
														".$string_comp_max_team."
														".$stringKeyword."
														ORDER BY  `p`.`ID` DESC");

				function compare_by_area1($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies_no_jobs = array_udiff($wpjobus_companies_all, $wpjobus_companies_jobs, 'compare_by_area1');


			  	function compare_by_area($a, $b) {
				  	$areaA = $a->post_name;
				  	$areaB = $b->post_name;
				  
				  	if ($areaA < $areaB) {
						return -1;
				  	} elseif ($areaA > $areaB) {
					  	return 1;
				  	} else {
					  	return 0;
				  	}
			  	}

			  	$wpjobus_companies = array_udiff($wpjobus_companies_all, $wpjobus_companies_no_jobs, 'compare_by_area');

			  	$id_name_status = 1;

			}

			?>

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

					if($id_name_status == 0) {
					  $company_id = $q->meta_value;
					} else {
					  $company_id = $q->post_name;
					}

					$current_element_id++;

					$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
					$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
					$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
					$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
					$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

					$wpjobus_company_longitude = get_post_meta($company_id, 'wpjobus_company_longitude',true);
					$wpjobus_company_latitude = get_post_meta($company_id, 'wpjobus_company_latitude',true);

					$iconPath = get_template_directory_uri() .'/images/icon-company.png';

					$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
					$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));

					if(!empty($wpjobus_company_latitude)) {

			?> 

				{

			  		latLng: [<?php echo $wpjobus_company_latitude; ?>,<?php echo $wpjobus_company_longitude; ?>],
					options: {
						icon: "<?php echo $iconPath; ?>",
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

			<?php

			$response = ob_get_contents();

		}


	} else {

		$response = 0;

  	}

  	die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitCompaniesFilter', 'wpjobusSubmitCompaniesFilter' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitCompaniesFilter', 'wpjobusSubmitCompaniesFilter' );

