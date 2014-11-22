<?php
/**
 * Index page
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

	<section id="blog">

		<div class="container">

				<div class="resume-skills">

					<div class="two_third first" style="margin-bottom: 0;">

						<?php

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							if ( !empty ( $args['paged'] ) && 0 == $paged ) {

								$wp_query->set('paged', $args['paged']);

								$paged = $args['paged'];

							}

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=post&paged='.$paged);

						?>

						<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

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
										
						<?php $wp_query = null; $wp_query = $temp;?>

					</div>

					<div class="one_third sidebar-widgets">
						<?php get_sidebar('blog'); ?>
					</div>

				</div>

			</div>

		</div>

	</section>

<?php get_footer(); ?>