<?php
/**
 * Template name: Blog
 */

get_header(); ?>

	<section id="page-title">

		<div class="container">

			<h1 class="page-title"><?php if ( is_day() ) : ?>
								<?php printf( __( 'Daily Archives: %s', 'agrg' ), get_the_date() ); ?>
								<?php elseif ( is_month() ) : ?>
								<?php printf( __( 'Monthly Archives: %s', 'agrg' ), get_the_date('F Y') ); ?>
								<?php elseif ( is_year() ) : ?>
								<?php printf( __( 'Yearly Archives: %s', 'agrg' ), get_the_date('Y') ); ?>
								<?php elseif ( is_tag() ) : ?>
								<?php printf( __( single_tag_title('Tag: ')) ); ?>
								<?php else : ?>
								<?php _e( 'Blog Archives: ', 'agrg' ); ?>
								<?php endif; ?>
								
								<?php if(get_query_var('author_name')) :
								    $curauth = get_user_by('slug', get_query_var('author_name'));
								else :
								    $curauth = get_userdata(get_query_var('author'));
								endif;
								?>
								<?php global $curauth; if(!empty($curauth)) { echo $curauth->display_name; } ?></h1>

		</div>

	</section>

	<section id="blog" style="padding-top: 0;">

		<div class="container">

			<div class="resume-skills">

				<div class="two_third first">

					<?php

						global $more; $more = false; # some wordpress wtf logic

						$cat_id = get_cat_ID(single_cat_title('', false));
						if(!empty($cat_id))
						{
							$query_string.= '&cat='.$cat_id;
						}
								
						query_posts($query_string);

						if (have_posts()) : while (have_posts()) : the_post(); 

					?>   

							<div class="post-block-content">

								<div class="post-block-title"><h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a><h2></div>

								<?php if ( has_post_thumbnail() ) { ?>

								<div class="two_third first" style="margin-bottom: 0;">

									<div class="post-block-featured-image">

										<?php require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); ?>

											<?php 

											$params = array( 'width' => 550, 'height' => 380, 'crop' => true );

											$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
											$large_image_id = get_post_thumbnail_id($post->ID);

											echo "<img src='" . bfi_thumb( "$large_image_url[0]", $params ) . "' alt=''/>";

										?>

										<div class="post-block-featured-image-shadow"></div>

									</div>

								</div>

								<div class="one_third" style="margin-bottom: 0; padding-right: 20px;">

									<div class="full" style="padding: 20px 0; padding-bottom: 0;">
										<span class="post-block-date"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span><span class="post-block-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M j, Y') ?></a></span><span class="post-block-category"><i class="fa fa-folder"></i><?php the_category(', '); ?></span><span class="post-block-comment"><i class="fa fa-comment"></i><a href="<?php comments_link(); ?>"><?php $my_comments = get_comments_number( $post->ID ); echo $my_comments; ?></a></span>
									</div>

									<div class="full">
										<?php
											$content = get_the_content();
											echo wp_trim_words( $content , '23' ); 
										?>
									</div>

									<p><a href="<?php the_permalink() ?>"><?php _e( 'Read More', 'agrg' ); ?></a></p>

								</div>

								<?php } else { ?>

								<div class="full" style="margin-bottom: 0;">

									<div class="full" style="padding: 20px; padding-bottom: 0;">
										<span class="post-block-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M j, Y') ?></a></span><span class="post-block-category"><i class="fa fa-folder"></i><?php the_category(', '); ?></span><span class="post-block-comment"><i class="fa fa-comment"></i><a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '%' ); ?></a></span>
									</div>

									<div class="full" style="padding: 0 20px;">
										<?php
											$content = get_the_content();
											echo wp_trim_words( $content , '165' ); 
										?>
									</div>
									<p style="padding: 0 20px;"><a href="<?php the_permalink() ?>"><?php _e( 'Read More', 'agrg' ); ?></a></p>

								</div>
													
								<?php } ?> 

							</div>

					<?php endwhile; ?>
							
					<!-- Begin Pagination-->	
					<?php get_template_part('pagination'); ?>
					<!-- End Pagination-->	
									
					<?php endif; ?>

				</div>

				<div class="one_third sidebar-widgets">
					<?php get_sidebar('blog'); ?>
				</div>

			</div>

		</div>

	</section>

<?php get_footer(); ?>