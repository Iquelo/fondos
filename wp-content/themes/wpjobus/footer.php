<?php
/**
 * The template for displaying the footer.
 */
?>
	<footer>

		<div class="container">
					
			<div class="full" style="margin-bottom: 0;">
				
				<div class="one_fourth first" style="margin-bottom: 0;"><?php get_sidebar( 'footer-one' ); ?></div>

				<div class="one_fourth" style="margin-bottom: 0;"><?php get_sidebar( 'footer-two' ); ?></div>

				<div class="one_fourth" style="margin-bottom: 0;"><?php get_sidebar( 'footer-three' ); ?></div>

				<div class="one_fourth" style="margin-bottom: 0;"><?php get_sidebar( 'footer-four' ); ?></div>

			</div>

			

		</div>
					
	</footer>

	<section class="socket">

		<div class="container">

			<div class="site-info">
				<?php 

					global $redux_demo; 
					$footer_copyright = $redux_demo['footer_copyright'];

				?>

				<?php if(!empty($footer_copyright)) { 
						echo $footer_copyright;
					} else {
				?>
				 Made with <i class="fa fa-heart"></i> by <a class="target-blank" href="http://themeforest.net/user/agurghis/portfolio?ref=agurghis">Alex Gurghis</a> and <a class="target-blank" href="http://www.rtdesignstudio.com/">Radu Trifan</a>. Powered by <a href="#">WordPress</a>
				<?php } ?>
				
			</div>

			<div class="footer_menu">
				<?php wp_nav_menu(array('theme_location' => 'third', 'container' => 'false')); ?>
			</div>

			<div class="backtop">
				<a href="#backtop"><i class="fa fa-chevron-up"></i></a>
			</div>

		</div>

	</section>

	<?php wp_footer(); ?>

</body>
</html>