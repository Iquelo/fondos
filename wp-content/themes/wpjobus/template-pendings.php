<?php
/**
 * Template name: Pendings
 */



$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<section id="blog" >

		<div class="container">

			<div class="resume-skills">

				<form id="wpjobus-pending-posts" type="post" action="" >

					<div class="full">

						<div class="full">
							<h1 class="resume-section-title"><i class="fa fa-gavel"></i><?php _e( 'Pending Items', 'agrg' ); ?></h1>
							<h3 class="resume-section-subtitle" style="margin-bottom: 0;"><?php _e( 'Hello Almighty Master! Take some time and review the pending items.', 'agrg' ); ?></h3>
						</div>

						<div id="companies-block" style="margin-top: 20px;">

							<?php 

								global $companies_per_page, $total_companies, $total_pages, $current_page;

								$chefs_per_page = 16;

								$total_cheefs = 0;

								$current_page = max(1, get_query_var('paged'));

								$wpjobus_companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE (post_type = 'company' or post_type = 'job' or post_type = 'resume') and post_status = 'pending' ORDER BY `ID` DESC ");

								foreach($wpjobus_companies as $posts_pub) { 
									$total_cheefs++;
								}

								$total_pages = ceil($total_cheefs/$chefs_per_page);

								$current_pos = -1; 

								foreach($wpjobus_companies as $q) {	

									$current_pos++;

									if($current_page == 1) {
										$start_loop = 0;
									} else {
										$start_loop = ($current_page - 1) * $chefs_per_page;
									}

									$end_loop = $current_page * $chefs_per_page;

									if($current_pos >= $start_loop && $current_pos <= ($end_loop-1)) {

										$post_id = $q->ID;

										$post_type = $q->post_type;

										if($post_type == "resume") {

											$wpjobus_post_picture = esc_url(get_post_meta($post_id, 'wpjobus_resume_profile_picture',true));
											$wpjobus_post_fullname = esc_attr(get_post_meta($post_id, 'wpjobus_resume_fullname',true));

										} elseif($post_type == "company") {

											$wpjobus_post_picture = esc_url(get_post_meta($post_id, 'wpjobus_company_profile_picture',true));
											$wpjobus_post_fullname = esc_attr(get_post_meta($post_id, 'wpjobus_company_fullname',true));

										} elseif($post_type == "job") {

											
											$job_company = esc_attr(get_post_meta($post_id, 'job_company',true));
											$wpjobus_post_fullname = esc_attr(get_post_meta($post_id, 'wpjobus_job_fullname',true));
											$wpjobus_post_fullname_company = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
											$wpjobus_post_picture = esc_url(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

										}

							?> 

							<div id="post-<?php echo $post_id; ?>" class="pending-post-single">

								<div id="post-preloader-<?php echo $post_id; ?>" class="pending-post-single-loading">
									<i class="fa fa-spinner fa-spin"></i>
								</div>

								<?php

									if($post_type == "resume") {

								?>

								<div class="pending-post-resume"><?php _e( 'Resume', 'agrg' ); ?></div>

								<?php } elseif($post_type == "job") { ?>

								<div class="pending-post-job"><?php _e( 'Job', 'agrg' ); ?></div>

								<?php } elseif($post_type == "company") { ?>

								<div class="pending-post-company"><?php _e( 'Company', 'agrg' ); ?></div>

								<?php

								}

								if($post_type == "resume") {

								?>

								<span class="company-list-icon rounded-img" style="margin: 20px 0;">
									<?php 
										require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
										$params = array( 'width' => 50, 'height' => 50, 'crop' => true );
									?>
									<img src="<?php echo bfi_thumb( "$wpjobus_post_picture", $params ); ?>" alt="<?php echo $wpjobus_post_fullname; ?>" />
								</span>

								<?php 

									} else {

								?>

								<span class="company-list-icon" style="margin: 20px 0;">
									<span class="helper"></span>
									<img src="<?php echo $wpjobus_post_picture; ?>" alt="<?php echo $wpjobus_post_fullname; ?>" />
								</span>

								<?php } ?>

								<?php

									if($post_type == "resume") {

										$post_link = "resume";

									} elseif($post_type == "job") { 

										$post_link = "job";

									} elseif($post_type == "company") {

										$post_link = "company";

									}

								?>

								<div class="pending-post-name"><a href="<?php $companylink = home_url()."/?post_type=".$post_link."&p=".$post_id."&preview=true"; echo $companylink; ?>"><?php echo $wpjobus_post_fullname; ?></a></div>

								<?php 

								if($post_type == "job") {

								?>

								<div class="pending-post-company-name"><?php _e( 'by', 'agrg' ); ?> <?php echo $wpjobus_post_fullname_company; ?></div>

								<?php } ?>

								<div class="pending-post-approve">
									<span class="pending-post-approve-link">
										<i class="fa fa-check"></i><?php _e( 'Approve', 'agrg' ); ?>
										<input type="hidden" class="review_post_id" name="review_post_id" value="<?php echo $post_id; ?>" />
									</span>
								</div>

								<div class="pending-post-reject">
									<span class="pending-post-reject-link">
										<i class="fa fa-times"></i><?php _e( 'Reject', 'agrg' ); ?>
										<input type="hidden" class="review_post_id" name="review_post_id" value="<?php echo $post_id; ?>" />
									</span>
								</div>

							</div>

							<?php } } ?> 

							<?php  

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
										$wpcook_pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');

									if( !empty($wp_query->query_vars['s']) )
										$wpcook_pagination['add_args'] = array('s'=>get_query_var('s'));

									echo '<div class="pagination">' . paginate_links($wpcook_pagination) . '</div>'; 

								}
								
							?>

						</div>

					</div>

					<input type="hidden" id="review_post_status" name="review_post_status" value="" />
					<input type="hidden" id="review_post_current_id" name="review_post_current_id" value="" />

					<input type="hidden" name="action" value="wpjobusSubmitReviewStat" />
					<?php wp_nonce_field( 'wpjobusSubmitReviewStat_html', 'wpjobusSubmitReviewStat_nonce' ); ?>

				</form>

				<script type="text/javascript">

				jQuery(function($) {

					jQuery(document).on("click",".pending-post-reject-link",function(e){

						jQuery('#review_post_status').val('reject');

						var globalVar = jQuery(this).find('.review_post_id').val();
						jQuery('#review_post_current_id').val(globalVar);

						jQuery('#post-preloader-'+globalVar).fadeIn(500);

				        $.fn.wpjobusSubmitFormFunction();

					});

					jQuery(document).on("click",".pending-post-approve-link",function(e){

						jQuery('#review_post_status').val('approve');

						var globalVar = jQuery(this).find('.review_post_id').val();
						jQuery('#review_post_current_id').val(globalVar);

						jQuery('#post-preloader-'+globalVar).fadeIn(500);

				        $.fn.wpjobusSubmitFormFunction();

					});

					$.fn.wpjobusSubmitFormFunction = function() {

						var globalVar = jQuery('#review_post_current_id').val();

						jQuery('#wpjobus-pending-posts').ajaxSubmit({
							type: "POST",
							data: jQuery('#wpjobus-pending-posts').serialize(),
							url: '<?php echo admin_url('admin-ajax.php'); ?>',	 
							success: function(response) {
								jQuery('#post-preloader-'+response).fadeOut(100);
								jQuery('#post-'+response).fadeOut(100, function(){
						        	jQuery(this).css('display', 'none');
						        });
							    return false;
							}
						});
					}

				});

				</script>

			</div>
			
		</div>

	</section>

<?php get_footer(); ?>