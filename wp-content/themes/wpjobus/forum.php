<?php
/**
 * The template for forum.
 */

get_header(); ?>

	<section id="page-title">

		<div class="container">

			<h1 class="page-title"><?php _e("Forums", "agrg"); ?></h1>

		</div>

	</section>

	<section id="page" style="padding-top: 0;">

		<div class="container">

			<div class="two_third first">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
				<?php the_content(); ?>
															
				<?php endwhile; endif; ?> 

			</div>

			<div class="one_third sidebar-widgets">
				<?php get_sidebar('forum'); ?>
			</div>

		</div>

	</section>

<?php get_footer(); ?>