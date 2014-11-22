<?php 

$page = get_page($post->ID);
$current_page_id = $page->ID;

$page_slider = get_post_meta($current_page_id, 'page_slider', true); 

?>

			<?php if($page_slider == "LayerSlider") : ?>

				<!-- Parallax Container -->
				<div id="layerslider">


					<?php

						$page_layer_slider_shortcode = get_post_meta($current_page_id, 'layerslider_shortcode', true);

						if(!empty($page_layer_slider_shortcode))
						{
					?>

					<?php echo do_shortcode($page_layer_slider_shortcode); ?>

					<?php } else { ?>

					<?php echo do_shortcode('[layerslider id="1"]'); ?>

					<?php } ?>

				</div>	
				<!-- End Parallax Container -->

			<?php elseif ($page_slider == "Featured Recipes") : ?>

			<?php endif; ?>