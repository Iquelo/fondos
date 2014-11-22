<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

    <?php
         include (TEMPLATEPATH . "/part-sliders.php");
    ?>

	<section id="seacrh-result-title">

		 <div class="container">

        	<h2><?php _e( 'Not found', 'wpads' ); ?></h2>

        </div>

	</section>

    <section id="ads-homepage">
        
        <div class="container">

        	<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'wpads' ); ?></h2>
			<p><?php _e( 'It looks like nothing was found at this location.', 'wpads' ); ?></p>

        </div>

    </section>

<?php get_footer(); ?>