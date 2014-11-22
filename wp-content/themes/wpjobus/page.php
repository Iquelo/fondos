<?php
/**
 * The main template for page
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

	<?php } else { ?>

	<section id="page-title">

		<div class="container">

			<div class="full"></div>

		</div>

	</section>

	<?php } ?>

	<section id="page" style="padding-top: 0;">

		<div class="container">

			<div class="two_third first">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
				<?php the_content(); ?>
															
				<?php endwhile; endif; ?> 

			</div>

			<div class="one_third sidebar-widgets">
				<?php get_sidebar('pages'); ?>
			</div>

		</div>

	</section>

<?php get_footer(); ?>