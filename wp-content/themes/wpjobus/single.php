<?php
/**
 * The Template for displaying all single posts.
 */

if($post->post_type == 'resume')
{
	get_template_part( 'template-single-resume', 'resume' );
    exit;
}

if($post->post_type == 'company')
{
	get_template_part( 'template-single-company', 'company' );
    exit;
}

if($post->post_type == 'job')
{
	get_template_part( 'template-single-job', 'job' );
    exit;
}

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<section id="page-title">

		<div class="container">

			<h1 class="page-title"><?php the_title(); ?></h1>

		</div>

	</section>

	<section id="blog-post" style="padding-top: 0;">

		<div class="container">

			<div class="resume-skills">

				<div class="two_third first">

					<div class="post-block-content">

						<?php if ( has_post_thumbnail() ) { ?>

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

						<div class="blog-post-meta">
							<span class="post-block-date"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span><span class="post-block-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M j, Y') ?></a></span><span class="post-block-comment"><span class="post-block-category"><i class="fa fa-folder"></i><?php the_category(', '); ?></span><i class="fa fa-comment"></i><a href="<?php comments_link(); ?>"><?php $my_comments = get_comments_number( $post->ID ); echo $my_comments; ?></a></span>
						</div>

						<?php } else { ?>

						<div class="full" style="margin-bottom: 0;">

							<div class="blog-post-meta">
								<span class="post-block-date"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span><span class="post-block-date"><i class="fa fa-clock-o"></i><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time('M j, Y') ?></a></span><span class="post-block-comment"><span class="post-block-category"><i class="fa fa-folder"></i><?php the_category(', '); ?></span><i class="fa fa-comment"></i><a href="<?php comments_link(); ?>"><?php $my_comments = get_comments_number( $post->ID ); echo $my_comments; ?></a></span>
							</div>

						</div>

						<?php } ?>

						<?php echo the_content(); ?>

						<?php wp_link_pages(); ?>

						<div class="blog-post-tags">

							<i class="fa fa-tag"></i><span><?php the_tags('','',''); ?></span>

						</div>

						<ul class="links">

							<li>
								<?php _e( 'Share:', 'agrg' ); ?>
							</li>

							<li class="service-links-pinterest-button">
								<a href="//www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=&amp;description=<?php the_title(); ?>" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
								<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
							</li>

							<li class="service-links-facebook-share">
								<div id="fb-root"></div>
								<script>(function(d, s, id) {
									var js, fjs = d.getElementsByTagName(s)[0];
									if (d.getElementById(id)) return;
									js = d.createElement(s); js.id = id;
									js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=247363645312964";
									fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
								<div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-type="button_count"></div>
							</li>

							<li class="service-links-google-plus-one last">
								<!-- Place this tag where you want the share button to render. -->
								<div class="g-plus" data-action="share" data-annotation="bubble"></div>

								<!-- Place this tag after the last share tag. -->
								<script type="text/javascript">
									(function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/platform.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									})();
								</script>
							</li>

							<li class="service-links-twitter-widget first">
								<iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" src="http://platform.twitter.com/widgets/tweet_button.1384205748.html#_=1384949257081&amp;count=horizontal&amp;counturl=<?php the_permalink(); ?>&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=<?php the_permalink(); ?>&amp;size=m&amp;text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>&amp;via=drupads" class="twitter-share-button service-links-twitter-widget twitter-tweet-button twitter-count-horizontal" title="Twitter Tweet Button" data-twttr-rendered="true" style="width: 107px; height: 20px;"></iframe>
							</li>
						</ul>

					</div>

					<div class="post-block-content">

						<span class="prev-post"><?php previous_post_link(); ?></span>

						<span class="next-post"><?php next_post_link(); ?></span>

					</div>

					<div id="ad-comments">

		    			<?php comments_template( '' ); ?>  

		    		</div>

				</div>

				<div class="one_third sidebar-widgets">
					<?php get_sidebar('blog'); ?>
				</div>

			</div>

		</div>

	</section>

	<?php endwhile; ?>

<?php get_footer(); ?>