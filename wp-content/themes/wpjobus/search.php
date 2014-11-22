<?php
/**
 * The main template file for search
 */

$page = get_page($post->ID);
$current_page_id = $page->ID;

get_header(); ?>

	<section id="page-title">

		<div class="container">

			<h1 class="page-title"><?php _e( 'Search results for: ', 'agrg' ); ?><?php the_search_query(); ?></h1>

		</div>

	</section>

	<section id="page" style="padding-top: 0;">

		<div class="container">

			<div class="two_third first">

				<?php if (have_posts()) : while (have_posts()) : the_post(); $current++; ?>	
						
				<div class="full">
							
					<div class="full"><h2><?php the_title(); ?></h2></div>
					<div class="full"><?php the_excerpt(); ?></div>
					<div class="full"><a href="<?php the_permalink() ?>"><?php echo the_permalink() ?></a></div>
							
				</div>
					
				<?php endwhile; ?>

				<!-- Begin Pagination-->	
				<?php get_template_part('pagination'); ?>
				<!-- End Pagination-->								
							
							
				<?php else: ?>

				<div class="full">
					<p><strong><?php _e('Nothing Found', 'agrg'); ?></strong><br/>
						<?php _e('Sorry, no posts matched your criteria. Try another search?', 'agrg'); ?>
					</p>
								
					<?php _e('You might want to consider some of our suggestions to get better results:', 'agrg'); ?></p>
					<ul>
						<li><?php _e('Check your spelling.', 'agrg'); ?></li>
						<li><?php _e('Try a similar keyword, for example: tablet instead of laptop.', 'agrg'); ?></li>
						<li><?php _e('Try using more than one keyword.', 'agrg'); ?></li>
					</ul>

				</div>

				<?php endif; ?> 

			</div>

			<div class="one_third sidebar-widgets">
				<?php get_sidebar('pages'); ?>
			</div>

		</div>

	</section>

<?php get_footer(); ?>