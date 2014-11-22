<?php

// [dropcap foo="foo-value"]
function dropcap_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'style' => 1
	), $atts));
	
	//get first char
	$first_char = substr($content, 0, 1);
	$text_len = strlen($content);
	$rest_text = substr($content, 1, $text_len);

	$return_html = '<span class="dropcap">'.$first_char.'</span>';
	$return_html.= do_shortcode($rest_text);
	
	return $return_html;
}
add_shortcode('dropcap', 'dropcap_func');


function loadTweets($user) { 

	//extract short code attr
	extract(shortcode_atts(array(
		'user' => 1
	), $user)); 
  
    // render tweets to div element  
    $return_html = '<div class="full" id="twitter"><div class="twitter-block"></div></div>';  
  
    // render javascript code to do the magic  
    echo  
    '<script type="text/javascript"> 
    var templateDir = "<?php bloginfo(template_directory) ?>"
    jQuery(function(){ 
    jQuery(".twitter-block").tweetable({ 
    username: "' . $user . '", 
    limit: "1", 
    replies: true, 
    position: "append"}); 
    }); 
    </script>'; 

    return $return_html; 
  
}  
  
// render tweets with shortcode  
function shortcode($data) {  
    return $this->loadTweets($data['user'], $data['limit']);  
}  

// set shortcode  
add_shortcode('latest-tweet', 'loadTweets'); 


// fimage path shortcode
function my_images_url($atts, $content = null) {
		 return get_template_directory_uri() . '/images'; 
}
add_shortcode("images_url", "my_images_url");


// Action Box
function action_box_func($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'bgcolor' => '',
		'action_btn_text' => '',
		'action_btn_link' => '',
		'color_btn_text' => '',
		'color_btn_link' => '',
		'color_btn_bg_color' => '',
	), $atts));

	//extract short code attr

	$output_action_box = '';
	
	$output_action_box = "<style type='text/css'>
								a.action-box-color-button { background-color: $color_btn_bg_color; }
								a.action-box-color-button:hover { background-color: #fff; color: $color_btn_bg_color; }
						  </style>

						  <div id='action-box'>

						  		<div class='container-boxed'>

							  		<div class='action-box-text'>$title</div>

							  		<a class='action-box-button' href='$action_btn_link' alt='$action_btn_text'>$action_btn_text</a>

							  		<a class='action-box-color-button' href='$color_btn_link' alt='$color_btn_text'>$color_btn_text</a>

						  		</div>


						  </div>";
	
	return $output_action_box;
}
add_shortcode('action_box', 'action_box_func');


// show homepage popular posts
function recent_news_small_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
	), $atts));

	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "<div class='post-preview'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='one_third first'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='two_third'>
									
										<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('recent_news_small_thumb', 'recent_news_small_thumb_fn');




// show homepage popular posts
function recent_news_no_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
	), $atts));
	
	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query = null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "
							
							
							
							
							<div class='post-preview'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('recent_news_no_thumb', 'recent_news_no_thumb_fn');




// show homepage popular posts
function category_news_small_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
		'category_name' => '',
	), $atts));

	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "
							
							
							
							
							<div class='post-preview'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='one_third first'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='two_third'>
									
										<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_news_small_thumb', 'category_news_small_thumb_fn');




// show homepage popular posts
function category_news_no_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
		'category_name' => '',
	), $atts));

	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "
							
							
							
							
							<div class='post-preview'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_news_no_thumb', 'category_news_no_thumb_fn');



// show homepage popular posts
function popular_news_small_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
	), $atts));

	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "
							
							
							
							
							<div class='post-preview'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='one_third first'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='two_third'>
									
										<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_news_small_thumb', 'popular_news_small_thumb_fn');


// show homepage popular posts
function popular_news_no_thumb_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'posts' => '',
	), $atts));

	$output_blog = '';

			$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts='.$posts);


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}

							
			$output_blog .= "
							
							
							
							<div class='post-preview'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h3><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h3>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a> in $categories_item</p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								

	$output_blog .= "</div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_news_no_thumb', 'popular_news_no_thumb_fn');



// show homepage post by category
function news_category_fn($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'name' => '',
	), $atts));

	$output_news_cat = '';

			$output_news_cat .= "<div class='full'><div class='entry-title'><h3><span>$name</span></h3></div>";

							global $wp_query;
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$name.'&showposts=5');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0]; 

							global $post_id;
							global $post;

      						$postID = get_post( $post_id );

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_date();

							$temp_author = get_the_author();

							$temp_excerpt = get_excerpt(75, 'content');


							if($current == 0) { 
							
			$output_news_cat .= "<div class='full'>

							<div class='one_half first'>
								<div class='circle-nav'>
									<div class='cn-nav'>
										<a href='$temp_link'>
											<div class='circle-button-text'><span>Read</span></div>
											<div class='circle-nav-smallbg'></div>
											<div class='circle-nav-bg'></div>
											<div class='circle-nav-darkbg'></div>
										</a>
										<img src='$imgsource' alt='$temp_title' />
									</div>
								</div>
							</div>

							<div class='one_half'>
								<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7; line-height: 32px;'><a href='$temp_link'>$temp_title</a></span></h4>
								<div class='post-full'>
									<p style='margin-bottom: 5px;'><i class='icon-calendar'></i>$temp_date</p>
									<p class='post-preview-excerpt'>$temp_excerpt</p>
									<div class='post-preview-excerpt-more'><a href='$temp_link'>Read More</a></div>
								</div>
							</div>

						</div>";

			} else  if($current == 1) { 


			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
			$imgsource = $image_url[0]; 	

			
			$output_news_cat .= "<div class='one_half first' style='margin-bottom: 0;'>

							<div class='homepage-post-small-image'>
								<div class='circle-nav'>
									<div class='cn-nav'>
										<a href='$temp_link'>
											<div class='circle-button-text'><span>Read</span></div>
											<div class='circle-nav-smallbg'></div>
											<div class='circle-nav-bg'></div>
											<div class='circle-nav-darkbg'></div>
										</a>
										<img src='$imgsource' alt='$temp_title' />
									</div>
								</div>
							</div>

							<div class='homepage-post-small-text'>
								<h5><span style='margin-bottom: 10px; float: left; font-weight: bold; line-height: 24px;'><a href='$temp_link'>$temp_title</a></span></h5>
								<div class='post-full'>
									<p style='margin-bottom: 0;'><i class='icon-calendar'></i>$temp_date</p>
								</div>
							</div>

						</div>";

			} else  if($current == 2) { 

			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
			$imgsource = $image_url[0];
			

			$output_news_cat .= "<div class='one_half' style='margin-bottom: 0;'>

							<div class='homepage-post-small-image'>
								<div class='circle-nav'>
									<div class='cn-nav'>
										<a href='$temp_link'>
											<div class='circle-button-text'><span>Read</span></div>
											<div class='circle-nav-smallbg'></div>
											<div class='circle-nav-bg'></div>
											<div class='circle-nav-darkbg'></div>
										</a>
										<img src='$imgsource' alt='$temp_title' />
									</div>
								</div>
							</div>

							<div class='homepage-post-small-text'>
								<h5><span style='margin-bottom: 10px; float: left; font-weight: bold; line-height: 24px;'><a href='$temp_link'>$temp_title</a></span></h5>
								<div class='post-full'>
									<p style='margin-bottom: 0;'><i class='icon-calendar'></i>$temp_date</p>
								</div>
							</div>

						</div>";	

			} else  if($current == 3) { 

			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
			$imgsource = $image_url[0];	

			
			$output_news_cat .= "<div class='one_half first' style='margin-bottom: 0;'>

							<div class='homepage-post-small-image'>
								<div class='circle-nav'>
									<div class='cn-nav'>
										<a href='$temp_link'>
											<div class='circle-button-text'><span>Read</span></div>
											<div class='circle-nav-smallbg'></div>
											<div class='circle-nav-bg'></div>
											<div class='circle-nav-darkbg'></div>
										</a>
										<img src='$imgsource' alt='$temp_title' />
									</div>
								</div>
							</div>

							<div class='homepage-post-small-text'>
								<h5><span style='margin-bottom: 10px; float: left; font-weight: bold; line-height: 24px;'><a href='$temp_link'>$temp_title</a></span></h5>
								<div class='post-full'>
									<p style='margin-bottom: 0;'><i class='icon-calendar'></i>$temp_date</p>
								</div>
							</div>

						</div>";

			} else  if($current == 4) { 

			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'square_image', true);
			$imgsource = $image_url[0];
			

			$output_news_cat .= "<div class='one_half' style='margin-bottom: 0;'>

							<div class='homepage-post-small-image'>
								<div class='circle-nav'>
									<div class='cn-nav'>
										<a href='$temp_link'>
											<div class='circle-button-text'><span>Read</span></div>
											<div class='circle-nav-smallbg'></div>
											<div class='circle-nav-bg'></div>
											<div class='circle-nav-darkbg'></div>
										</a>
										<img src='$imgsource' alt='$temp_title' />
									</div>
								</div>
							</div>

							<div class='homepage-post-small-text'>
								<h5><span style='margin-bottom: 10px; float: left; font-weight: bold; line-height: 24px;'><a href='$temp_link'>$temp_title</a></span></h5>
								<div class='post-full'>
									<p style='margin-bottom: 0;'><i class='icon-calendar'></i>$temp_date</p>
								</div>
							</div>

						</div>";

			}									
						
						endwhile;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			$output_news_cat .= "<div class='full'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";		
	
	return $output_news_cat;
}
add_shortcode('news_category', 'news_category_fn');



// [quote foo="foo-value"]
function quote_func($atts, $content) {
	
	$return_html = '<blockquote><p>'.do_shortcode($content).'</p></blockquote>';
	
	return $return_html;
}
add_shortcode('quote', 'quote_func');



// pre function
function pre_func($atts, $content) {
	
	$return_html = '<pre>'.strip_tags($content).'</pre>';
	
	return $return_html;
}
add_shortcode('pre', 'pre_func');



// social facebook
function social_facebook($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="facebook-icon" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/facebook.png" alt="facebook"/></a></div>';
	
	return $return_html;
}
add_shortcode('facebook', 'social_facebook');



// social behance
function social_behance($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="behance-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/behance.png" alt="behance"/></a></div>';
	
	return $return_html;
}
add_shortcode('behance', 'social_behance');



// social dribbble
function social_dribbble($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="dribbble-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/dribbble.png" alt="dribbble"/></a></div>';
	
	return $return_html;
}
add_shortcode('dribbble', 'social_dribbble');



// social envato
function social_envato($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/envato.png" alt="envato"/></a></div>';
	
	return $return_html;
}
add_shortcode('envato', 'social_envato');




// social evernote
function social_evernote($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="evernote-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/evernote.png" alt="evernote"/></a></div>';
	
	return $return_html;
}
add_shortcode('evernote', 'social_evernote');



// social flickr
function social_flickr($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="flickr-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/flickr.png" alt="flickr"/></a></div>';
	
	return $return_html;
}
add_shortcode('flickr', 'social_flickr');



// social forrst
function social_forrst($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="forrst-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/forrst.png" alt="forrst"/></a></div>';
	
	return $return_html;
}
add_shortcode('forrst', 'social_forrst');



// social google
function social_google($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="google-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/google.png" alt="google"/></a></div>';
	
	return $return_html;
}
add_shortcode('google', 'social_google');



// social google+
function social_googleplus($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="googleplus-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/googleplus.png" alt="google+"/></a></div>';
	
	return $return_html;
}
add_shortcode('googleplus', 'social_googleplus');



// social gowalla
function social_gowalla($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="gowalla-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/gowalla.png" alt="gowalla"/></a></div>';
	
	return $return_html;
}
add_shortcode('gowalla', 'social_gowalla');



// social icloud
function social_icloud($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="icloud-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/icloud.png" alt="icloud"/></a></div>';
	
	return $return_html;
}
add_shortcode('icloud', 'social_icloud');



// social linkedin
function social_linkedin($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="linkedin-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/linkedin.png" alt="linkedin"/></a></div>';
	
	return $return_html;
}
add_shortcode('linkedin', 'social_linkedin');



// social paypal
function social_paypal($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="paypal-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/paypal.png" alt="paypal"/></a></div>';
	
	return $return_html;
}
add_shortcode('paypal', 'social_paypal');



// social pinterest
function social_pinterest($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="pinterest-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/pinterest.png" alt="pinterest"/></a></div>';
	
	return $return_html;
}
add_shortcode('pinterest', 'social_pinterest');



// social rss
function social_rss($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="rss-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/rss.png" alt="rss"/></a></div>';
	
	return $return_html;
}
add_shortcode('rss', 'social_rss');



// social tumblr
function social_tumblr($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="tumblr-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/tumblr.png" alt="tumblr"/></a></div>';
	
	return $return_html;
}
add_shortcode('tumblr', 'social_tumblr');



// social twitter
function social_twitter($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="twitter-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/twitter.png" alt="twitter"/></a></div>';
	
	return $return_html;
}
add_shortcode('twitter', 'social_twitter');



// social vimeo
function social_vimeo($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="vimeo-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/vimeo.png" alt="vimeo"/></a></div>';
	
	return $return_html;
}
add_shortcode('vimeo', 'social_vimeo');



// social wordpress
function social_wordpress($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="wordpress-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/wordpress.png" alt="wordpress"/></a></div>';
	
	return $return_html;
}
add_shortcode('wordpress', 'social_wordpress');



// social youtube
function social_youtube($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
	), $atts));
	
	$return_html = '<div class="social-image"><a class="youtube-icon" class="social-image" href="'.$url.'"><img src="' . get_template_directory_uri() . '/images/social/youtube.png" alt="youtube"/></a></div>';
	
	return $return_html;
}
add_shortcode('youtube', 'social_youtube');














// [quote foo="foo-value"]
function sidebar_widget_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
	), $atts));
	
	$return_html = '<div class="sidebar_'.$type.'">
						<div class="sidebar columns">
							<div class="inner_sidebar">'.get_sidebar('pages').'</div>
						</div>	
					</div>';
	
	return $return_html;

}
add_shortcode('sidebar_widget', 'sidebar_widget_func');


// [Gray Area]
function colored_area_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'bg_color' => '',
		'text_color' => '',
	), $atts));
	
	$return_html = '<style>.colored-area p, .colored-area h1, .colored-area h2, .colored-area h3, .colored-area h4, .colored-area h5, .colored-area h6 { color: #'.$text_color.'; }</style><div class="colored-area"  style="background-color: #'.$bg_color.'; color: #'.$text_color.';"><div class="container">'.do_shortcode($content).'</div></div>';
	
	return $return_html;
}
add_shortcode('colored_area', 'colored_area_func');



// [Circle Navigation]
function circle_navigation_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
		'img_url' => '',
	), $atts));
	
	$return_html = '<div class="full"><div class="circle-nav">
	   <div class="cn-nav">
	      <a href="'.$url.'">
	        <div class="circle-button-text"><span>'.do_shortcode($content).'</span></div>
	        <div class="circle-nav-smallbg"></div>
	        <div class="circle-nav-bg"></div>
	      </a>
	      <img class="circle-nav-img" src="'.$img_url.'" alt=""/>
	   </div>
	</div></div>';
	
	return $return_html;
}
add_shortcode('circle_navigation', 'circle_navigation_func');



function colored_box_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'bg_color' => '',
		'text_color' => '',
	), $atts));
	
	$return_html = '<div class="'.$type.'-box" style="margin-bottom: 30px; background-color: #'.$bg_color.'; color: #'.$text_color.';">' . do_shortcode( $content ) . '</div>';
	
	return $return_html;
}
add_shortcode('colored_box', 'colored_box_func');


function flat_icon_box_func($atts, $content) {

	$theme_link = get_template_directory_uri();

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'box_title' => 'text',
	), $atts));
	
	$return_html = '<div class="tile"><img class="tile-image big-illustration" alt="" src="'.$theme_link.'/images/illustrations/'.$type.'.png" /><h3 class="tile-title">'.$box_title.'</h3><p>' . do_shortcode( $content ) . '</p></div>';
	
	return $return_html;
}
add_shortcode('flat_icon_box', 'flat_icon_box_func');



// [Progress Bar]
function progress_bar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'percent' => '',
		'color' => '',
	), $atts));
	
	$return_html = '<div class="progress-bar-content">
					    <div class="progress-bar-title">'.$title.' - '.$percent.'%</div>
					    <div class="meter">
							<span style="width: '.$percent.'%; background-color: '.$color.';"></span>
					    </div>
					</div>';
	
	return $return_html;
}
add_shortcode('progress_bar', 'progress_bar_func');


// [Entry title]
function entry_title_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
	), $atts));
	
	$return_html = '<div class="entry-title">
						<h3><span>'.$title.'</span></h3>
						<span class="post-subtitle-span">'.$subtitle.'</span>
					</div>';
	
	return $return_html;
}
add_shortcode('entry_title', 'entry_title_func');



// [Normal button]
function normal_button_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
		'type' => '',
	), $atts));
	
	$return_html = '<a href="'.$url.'" class="button-ag '.$type.'"><span class="button-inner">' . do_shortcode( $content ) . '</span></a>';
	
	return $return_html;
}
add_shortcode('normal_button', 'normal_button_func');


// [Large button]
function large_button_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
		'type' => '',
	), $atts));
	
	$return_html = '<a href="'.$url.'" class="button-ag large '.$type.'"><span class="button-inner">' . do_shortcode( $content ) . '</span></a>';
	
	return $return_html;
}
add_shortcode('large_button', 'large_button_func');


// [Big button]
function big_button_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'url' => '',
		'type' => '',
	), $atts));
	
	$return_html = '<a href="'.$url.'" class="button-ag big '.$type.'"><span class="button-inner">' . do_shortcode( $content ) . '</span></a>';
	
	return $return_html;
}
add_shortcode('big_button', 'big_button_func');



function notification_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="box-notification"><div class="box-notification-content">'.html_entity_decode(do_shortcode($content)).'</div></div>';
	
	return $return_html;
}
add_shortcode('notification_box', 'notification_func');

function error_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="box-error"><div class="box-error-content">'.html_entity_decode(do_shortcode($content)).'</div></div>';
	
	return $return_html;
}
add_shortcode('error_box', 'error_func');

function download_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="box-download"><div class="box-download-content">'.html_entity_decode(do_shortcode($content)).'</div></div>';
	
	return $return_html;
}
add_shortcode('download_box', 'download_func');

function information_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="box-information"><div class="box-information-content">'.html_entity_decode(do_shortcode($content)).'</div></div>';
	
	return $return_html;
}
add_shortcode('information_box', 'information_func');


function frame_left_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_left">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_left', 'frame_left_func');




function frame_right_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_right">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_right', 'frame_right_func');



function frame_center_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_center">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_center', 'frame_center_func');



function big_button_left_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="big_button_'.$type.' alignleft">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('big_button_left', 'big_button_left_func');


function big_button_right_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="big_button_'.$type.' alignright">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('big_button_right', 'big_button_right_func');


function big_button_center_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="big_button_'.$type.' aligncenter">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('big_button_center', 'big_button_center_func');



function medium_button_left_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="medium_button_'.$type.' alignleft">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('medium_button_left', 'medium_button_left_func');


function medium_button_right_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="medium_button_'.$type.' alignright">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('medium_button_right', 'medium_button_right_func');


function medium_button_center_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="medium_button_'.$type.' aligncenter">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('medium_button_center', 'medium_button_center_func');


function small_button_left_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'link' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="small_button_'.$type.' alignleft">
						<a href="'.$link.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('small_button_left', 'small_button_left_func');


function small_button_right_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'href' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="small_button_'.$type.' alignright">
						<a href="'.$href.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('small_button_right', 'small_button_right_func');


function small_button_center_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
		'href' => '',
		'text' => '',
	), $atts));
	
	$return_html = '<div class="small_button_'.$type.' aligncenter">
						<a href="'.$href.'">'.$text.'</a>
					</div>';
	
	return $return_html;
}
add_shortcode('small_button_center', 'small_button_center_func');




function list_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => '',
	), $atts));
	
	$return_html = '<ul class="lists '.$type.'">'.$content.'</ul>';
	
	return $return_html;
}
add_shortcode('list', 'list_func');


// Toggle
function toggle_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="toggle">
				        <h4 class="trigger">'.$title.'</h4>
				        <div class="togglebox">
				          <div><p>'. $content .'</p></div>
				        </div>
				    </div>';
	
	return $return_html;
}
add_shortcode('toggle', 'toggle_func');


// FAQ Toggle
function faq_toggle_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$return_html = '<div class="toggle">
				        <h4 class="trigger"><i class="icon-plus"></i><i class="icon-minus"></i> '.$title.'</h4>
				        <div class="togglebox">
				          <div><p>'. $content .'</p></div>
				        </div>
				    </div>';
	
	return $return_html;
}
add_shortcode('faq_toggle', 'faq_toggle_func');


/*
* jQuery Tools - Tabs shortcode
*/
add_shortcode( 'tabgroup', 'etdc_tab_group' );

function etdc_tab_group( $atts, $content ){
	$GLOBALS['tab_count'] = 0;

	do_shortcode( $content );

	if( is_array( $GLOBALS['tabs'] ) ){
	foreach( $GLOBALS['tabs'] as $tab ){
	$tabs[] = '<li><a class="" href="#">'.$tab['title'].'</a></li>';
	$panes[] = '<div class="pane">'.$tab['content'].'</div>';
	}
	$return = "\n".'<!-- the tabs --><ul class="custom-tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" --><div class="panes">'.implode( "\n", $panes ).'</div>'."\n";
	}
	return $return;
	}

	add_shortcode( 'tab', 'etdc_tab' );
	function etdc_tab( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'Tab %d'
	), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );

	$GLOBALS['tab_count']++;
}


function highlight_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => 'red',
	), $atts));
	
	$return_html = '<span class="highlight_'.$type.'">'.strip_tags($content).'</span>';
	
	return $return_html;
}
add_shortcode('highlight', 'highlight_func');



function tagline_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'button' => '',
		'href' => '',
	), $atts));
	
	$return_html = '
		<div class="tagline" style="width:92%">
			<div class="tagline_text">
			    <h2 class="cufon">'.$title.'</h2>
			    <p>'.strip_tags(strip_shortcodes($content)).'</p>
			</div>
			<div class="tagline_button">
			    <a href="'.$href.'" class="button medium">'.$button.'</a>
			</div>
			<br class="clear"/>
		</div>
	';
	
	return $return_html;
}
add_shortcode('tagline', 'tagline_func');



function arrow_list_func($atts, $content) {
	
	$return_html = '<ul class="arrow_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('arrow_list', 'arrow_list_func');




function check_list_func($atts, $content) {
	
	$return_html = '<ul class="check_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('check_list', 'check_list_func');




function star_list_func($atts, $content) {
	
	$return_html = '<ul class="star_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('star_list', 'star_list_func');


function full_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="full">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('full', 'full_func');

function one_half_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half', 'one_half_func');




function one_half_first_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half_first', 'one_half_first_func');



function one_third_func($atts, $content) {
	
	$return_html = '<div class="one_third">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third', 'one_third_func');




function one_third_first_func($atts, $content) {
	
	$return_html = '<div class="one_third first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third_first', 'one_third_first_func');



function two_third_func($atts, $content) {
	
	$return_html = '<div class="span8">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third', 'two_third_func');




function two_third_first_func($atts, $content) {
	
	$return_html = '<div class="span8 first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third_first', 'two_third_first_func');




function one_fourth_func($atts, $content) {
	
	$return_html = '<div class="one_fourth">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth', 'one_fourth_func');




function one_fourth_first_func($atts, $content) {
	
	$return_html = '<div class="one_fourth first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth_first', 'one_fourth_first_func');

function three_fourth_func($atts, $content) {
	
	$return_html = '<div class="span9">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('three_fourth', 'three_fourth_func');


function three_fourth_first_func($atts, $content) {
	
	$return_html = '<div class="span9 first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('three_fourth_first', 'three_fourth_first_func');




function full_services_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="full column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('full_services', 'full_services_func');

function one_half_services_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half_services', 'one_half_services_func');




function one_half_services_first_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half first">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half_services_first', 'one_half_services_first_func');



function one_third_services_func($atts, $content) {
	
	$return_html = '<div class="one_third column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third_services', 'one_third_services_func');




function one_third_services_first_func($atts, $content) {
	
	$return_html = '<div class="one_third first column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third_services_first', 'one_third_services_first_func');



function two_third_services_func($atts, $content) {
	
	$return_html = '<div class="two_third column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third_services', 'two_third_services_func');




function two_third_services_first_func($atts, $content) {
	
	$return_html = '<div class="two_third first column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third_services_first', 'two_third_services_first_func');




function one_fourth_services_func($atts, $content) {
	
	$return_html = '<div class="one_fourth column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth_services', 'one_fourth_services_func');




function one_fourth_services_first_func($atts, $content) {
	
	$return_html = '<div class="one_fourth first column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth_services_first', 'one_fourth_services_first_func');



function three_fourth_services_func($atts, $content) {
	
	$return_html = '<div class="three_fourth column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('three_fourth_services', 'three_fourth_services_func');


// slideshow with attached images
function attached_images_slideshow($atts, $content) {
	
	//extract short code attr

	$output_att_img = '';
	
	$output_att_img .= "<div class='flexslider'>

					<ul class='slides'>";

						global $post;

						$argsThumb = array(
							'order'          => 'ASC',
							'post_type'      => 'attachment',
							'post_parent'    => $post->ID,
							'post_mime_type' => 'image',
							'post_status'    => null
						);

						$attachments = get_posts($argsThumb);

						if ($attachments) {

							foreach ($attachments as $attachment) {

								$full_img_url = wp_get_attachment_url($attachment->ID);

								$postTitle = $attachment->post_title;

				$output_att_img .= "<li><img src=" . $full_img_url  ." alt=" . $postTitle . " /></li>";

											
			}
		}
											

		$output_att_img .= "</ul>

				</div>";	
	
	return $output_att_img;
}
add_shortcode('slideshow', 'attached_images_slideshow');



function three_fourth_services_first_func($atts, $content) {
	
	$return_html = '<div class="three_fourth first column_container">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('three_fourth_services_first', 'three_fourth_services_first_func');




function four_projects_row_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'projects' => '',
	), $atts));
	
	$custom_id = time().rand();
	
	$output_four_proj = '';

	$output_four_proj .= "<div class='full' style='margin-bottom: 0;'>";
			
							global $paged, $wp_query, $wp, $id, $post;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=project&posts_per_page='.$projects);

							$current = -1;

						
							if (have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; 
							
							$sort_classes = "";
							$sort_classes_name = "";
							
							$item_categories = get_the_terms( $id, 'portfoliosets' );

							if(is_object($item_categories) || is_array($item_categories))
							{
								foreach ($item_categories as $cat)
								{
									$sort_classes .= $cat->slug.'_sort ';
									$sort_classes_name .= ' <span style="margin-right: 10px;">'.$cat->slug.'</span>';
								}
							}
						
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(450,328) );
							$imgsource = $image_url[0]; 

							$temp_title = get_the_title($post->ID);

							global $post_id;

      						$postID = get_post( $post_id );

      						$template_link = get_template_directory_uri();

      						$proj_cont = wpcrown_substr(strip_tags(strip_shortcodes($postID->post_content)), 130);
							
							

      						$portfolio_link_url = get_post_meta(get_the_ID(), 'portfolio_link_url', true);
													
							if(empty($portfolio_link_url))
							{
								$temp_link = get_permalink($post->ID);
							}
							else
							{
								$temp_link = $portfolio_link_url;
							}
							
							
							
							$portfolio_link_type = get_post_meta(get_the_ID(), 'portfolio_link_type', true);
							$image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail') );


							global $agurghis_config, $permalink_url;
							$agurghis_config['agurghis_is_overview'] = true;


					$output_four_proj .= "<div class='one_fourth "; 
									if($current%4 ==0) { ;
							$output_four_proj .= "first "; 
									}; 
							$output_four_proj .= "project'>
							
							
						<div class='portfolio-image-holder'>
					
							<a href='$temp_link'>
							
								<div class='overlay'>
									
									<div class='overlay-background'></div>
								
								</div>
								
								<img src='$imgsource' alt='$temp_title' />
							
							</a>
						
						</div>
						
						<div class='project-title'>
							<h5><a href='$temp_link'>$temp_title</a></h5>
						</div>
						
					</div>";
						
						endwhile;
						
						wp_reset_query();

					endif;
					
						

		$output_four_proj .= "</div>";		
	
	return $output_four_proj;
}
add_shortcode('four_projects_row', 'four_projects_row_func');


function three_projects_row_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'projects' => '',
	), $atts));
	
	$custom_id = time().rand();
	
	$output_three_proj = '';

	$output_three_proj .= "<div class='full' style='margin-bottom: 0;'>";
			
							global $paged, $wp_query, $wp, $id, $post;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=project&posts_per_page='.$projects);

							$current = -1;

						
							if (have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; 
							
							$sort_classes = "";
							$sort_classes_name = "";
							
							$item_categories = get_the_terms( $id, 'portfoliosets' );

							if(is_object($item_categories) || is_array($item_categories))
							{
								foreach ($item_categories as $cat)
								{
									$sort_classes .= $cat->slug.'_sort ';
									$sort_classes_name .= ' <span style="margin-right: 10px;">'.$cat->slug.'</span>';
								}
							}
						
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'project_small_image', true);
							$imgsource = $image_url[0]; 

							$temp_title = get_the_title($post->ID);

							global $post_id;

      						$postID = get_post( $post_id );

      						$template_link = get_template_directory_uri();

      						$proj_cont = wpcrown_substr(strip_tags(strip_shortcodes($postID->post_content)), 130);
							
							

      						$portfolio_link_url = get_post_meta(get_the_ID(), 'portfolio_link_url', true);
													
							if(empty($portfolio_link_url))
							{
								$temp_link = get_permalink($post->ID);
							}
							else
							{
								$temp_link = $portfolio_link_url;
							}
							
							
							
							$portfolio_link_type = get_post_meta(get_the_ID(), 'portfolio_link_type', true);
							$image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail') );
							$imgsource = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'project_small_image') );


							global $agurghis_config, $permalink_url;
							$agurghis_config['agurghis_is_overview'] = true;


					$output_three_proj .= "<div class='one_third "; 
									if($current%3 ==0) { ;
							$output_three_proj .= "first "; 
									}; 
							$output_three_proj .= "project'>

						
						
						<div class='portfolio-image-holder'>
					
							<a href='$temp_link'>
							
								<div class='overlay'>
									
									<div class='overlay-background'></div>
								
								</div>
								
								<img src='$imgsource' alt='$temp_title' />
							
							</a>
						
						</div>
						
						<div class='project-title'>
							<h5><a href='$temp_link'>$temp_title</a></h5>
						</div>
						
					</div>";
						
						endwhile;
						
						wp_reset_query();

					endif;
					
						

		$output_three_proj .= "</div>";		
	
	return $output_three_proj;
}
add_shortcode('three_projects_row', 'three_projects_row_func');

function two_projects_row_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'projects' => '',
	), $atts));
	
	$custom_id = time().rand();
	
	$output_two_proj = '';

	$output_two_proj .= "<div class='full' style='margin-bottom: 0;'>";
			
							global $paged, $wp_query, $wp, $id, $post;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=project&posts_per_page='.$projects);

							$current = -1;

						
							if (have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; 
							
							$sort_classes = "";
							$sort_classes_name = "";
							
							$item_categories = get_the_terms( $id, 'portfoliosets' );

							if(is_object($item_categories) || is_array($item_categories))
							{
								foreach ($item_categories as $cat)
								{
									$sort_classes .= $cat->slug.'_sort ';
									$sort_classes_name .= ' <span style="margin-right: 10px;">'.$cat->slug.'</span>';
								}
							}
						
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'project_small_image', true);
							$imgsource = $image_url[0]; 

							$temp_title = get_the_title($post->ID);

							global $post_id;

      						$postID = get_post( $post_id );

      						$template_link = get_template_directory_uri();

      						$proj_cont = wpcrown_substr(strip_tags(strip_shortcodes($postID->post_content)), 130);
							
							

      						$portfolio_link_url = get_post_meta(get_the_ID(), 'portfolio_link_url', true);
													
							if(empty($portfolio_link_url))
							{
								$temp_link = get_permalink($post->ID);
							}
							else
							{
								$temp_link = $portfolio_link_url;
							}
							
							
							
							$portfolio_link_type = get_post_meta(get_the_ID(), 'portfolio_link_type', true);
							$image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'thumbnail') );
							$imgsource = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID(), 'project_small_image') );


							global $agurghis_config, $permalink_url;
							$agurghis_config['agurghis_is_overview'] = true;


					$output_two_proj .= "<div class='one_half "; 
									if($current%2 ==0) { ;
							$output_two_proj .= "first "; 
									}; 
							$output_two_proj .= "project'>

						
						
						<div class='portfolio-image-holder'>
					
							<a href='$temp_link'>
							
								<div class='overlay'>
									
									<div class='overlay-background'></div>
								
								</div>
								
								<img src='$imgsource' alt='$temp_title' />
							
							</a>
						
						</div>
						
						<div class='project-title'>
							<h5><a href='$temp_link'>$temp_title</a></h5>
						</div>
						
					</div>";
						
						endwhile;
						
						wp_reset_query();

					endif;
					
						

		$output_two_proj .= "</div>";		
	
	return $output_two_proj;
}
add_shortcode('two_projects_row', 'two_projects_row_func');




// Team Shortcode
function chefs_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'amount' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_three_team = '';
	
	$output_three_team = "<div class='full' style='margin-bottom: 0;'>";

							$current_author = -1;

							global $wpdb;

							$wpcook_cheefs_latest = $wpdb->get_results( "SELECT post_author, count(*) as ct FROM `{$wpdb->prefix}posts` WHERE post_type = 'recipe' and post_status = 'publish' group by post_author ORDER BY post_author DESC");

							foreach($wpcook_cheefs_latest as $chefs_latest) {	

								$current_author++;

								if ($current_author < $amount) {

									$latest_post_by_author = get_posts( array(
										'author'         => $chefs_latest->post_author,
										'orderby'        => 'post_date',
										'order'          => 'DESC',
										'post_type'      => 'recipe',
										'post_status'    => 'publish',
										'posts_per_page' => 1
									));

									$post_url = $latest_post_by_author[0]->guid;
									$post_title = $latest_post_by_author[0]->post_title;

									$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($latest_post_by_author[0]->ID), 'large');



	      						$output_three_team .= "<div class='one_fourth "; 
										if($current_author%4 ==0) { ;
								$output_three_team .= "first"; 
										}; 
								$output_three_team .= " author-block-home '>";

								$output_three_team .= "<div class='author-block-home-bg'>";

									require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');

									$params = array( 'width' => 500, 'height' => 500, 'crop' => true );

									$output_three_team .= "<img src='" . bfi_thumb( "$large_image_url[0]", $params ) . "' alt=''/>";

								$output_three_team .= "</div>

								<div class='author-block-home-border'></div>

								<div class='author-block-home-content'>

									<div class='author-list-avatar'>

										<div class='recipe-author-image'>";

											require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');
														
											$author_id = $chefs_latest->post_author;

											$author_avatar_url = get_user_meta($author_id, "wpcook_author_avatar_url", true); 

											if(!empty($author_avatar_url)) {

													$params = array( 'width' => 50, 'height' => 50, 'crop' => true );

													$output_three_team .= "<img class='author-avatar' src='" . bfi_thumb( "$author_avatar_url", $params ) . "' alt='' />";

											} else { 

												$avatar_url = wpcrown_get_avatar_url ( get_the_author_meta('user_email', $author_id), $size = '50' );
												$output_three_team .= "<img class='author-avatar' src='". $avatar_url . "'' alt='' />";

											}

										$output_three_team .= "</div>

									</div>

									<div class='author-list-name'>" . get_the_author_meta('display_name', $chefs_latest->post_author) . "</div>

									<div class='author-list-total-posts'>";

										$author_total_recipes = count( get_posts( array( 
										    'post_type' => 'recipe', 
										    'author'    => $chefs_latest->post_author, 
										    'nopaging'  => true, // display all posts
										) ) );

										$output_three_team .= "Wrote ". $author_total_recipes ." recipes
									</div>

									<div class='author-list-link-profile'>
										<a href='" . get_author_posts_url($chefs_latest->post_author) . "'><i class='fa fa-user'></i>View Profile</a>
									</div>

								</div>";

								}
							
							}

					wp_reset_query();

				$output_three_team = "</div>";
	
	return $output_three_team;
}
add_shortcode('chefs', 'chefs_func');


// Team Shortcode
function top_chefs_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'amount' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_three_team = '';
	
	$output_three_team = "<div class='full' style='margin-bottom: 0;'>";

							$current_author = -1;

							global $wpdb;

							$wpcook_cheefs_latest = $wpdb->get_results( "SELECT post_author, count(*) as ct FROM `{$wpdb->prefix}posts` WHERE post_type = 'recipe' and post_status = 'publish' group by post_author ORDER BY ct DESC");

							foreach($wpcook_cheefs_latest as $chefs_latest) {	

								$current_author++;

								if ($current_author < $amount) {

									$latest_post_by_author = get_posts( array(
										'author'         => $chefs_latest->post_author,
										'orderby'        => 'post_date',
										'order'          => 'DESC',
										'post_type'      => 'recipe',
										'post_status'    => 'publish',
										'posts_per_page' => 1
									));

									$post_url = $latest_post_by_author[0]->guid;
									$post_title = $latest_post_by_author[0]->post_title;

									$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($latest_post_by_author[0]->ID), 'large');



	      						$output_three_team .= "<div class='one_fourth "; 
										if($current_author%4 ==0) { ;
								$output_three_team .= "first"; 
										}; 
								$output_three_team .= " author-block-home '>";

								$output_three_team .= "<div class='author-block-home-bg'>";

									require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');

									$params = array( 'width' => 500, 'height' => 500, 'crop' => true );

									$output_three_team .= "<img src='" . bfi_thumb( "$large_image_url[0]", $params ) . "' alt=''/>";

								$output_three_team .= "</div>

								<div class='author-block-home-border'></div>

								<div class='author-block-home-content'>

									<div class='author-list-avatar'>

										<div class='recipe-author-image'>";

											require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');
														
											$author_id = $chefs_latest->post_author;

											$author_avatar_url = get_user_meta($author_id, "wpcook_author_avatar_url", true); 

											if(!empty($author_avatar_url)) {

													$params = array( 'width' => 50, 'height' => 50, 'crop' => true );

													$output_three_team .= "<img class='author-avatar' src='" . bfi_thumb( "$author_avatar_url", $params ) . "' alt='' />";

											} else { 

												$avatar_url = wpcrown_get_avatar_url ( get_the_author_meta('user_email', $author_id), $size = '50' );
												$output_three_team .= "<img class='author-avatar' src='". $avatar_url . "'' alt='' />";

											}

										$output_three_team .= "</div>

									</div>

									<div class='author-list-name'>" . get_the_author_meta('display_name', $chefs_latest->post_author) . "</div>

									<div class='author-list-total-posts'>";

										$author_total_recipes = count( get_posts( array( 
										    'post_type' => 'recipe', 
										    'author'    => $chefs_latest->post_author, 
										    'nopaging'  => true, // display all posts
										) ) );

										$output_three_team .= "Wrote ". $author_total_recipes ." recipes
									</div>

									<div class='author-list-link-profile'>
										<a href='" . get_author_posts_url($chefs_latest->post_author) . "'><i class='fa fa-user'></i>View Profile</a>
									</div>

								</div>";

								}
							
							}

					wp_reset_query();

				$output_three_team = "</div>";
	
	return $output_three_team;
}
add_shortcode('top_chefs', 'top_chefs_func');


// Team Shortcode
function recent_recipes_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'amount' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_three_team = '';
	
	$output_three_team = "<div class='full' style='margin-bottom: 0;'>";


							global $paged, $wp_query, $wp;

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$current = -1;

							echo $amount;

							$wp_query->query('post_type=recipe&posts_per_page='.$amount);

							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

	      					$output_three_team .= "<a href='" . the_permalink() . "' class='one_fourth "; 
									if($current%4 ==0) { ;
							$output_three_team .= "first"; 
										}; 
							$output_three_team .= " author-recipe-block '>";

							$output_three_team .= "<span class='block-recipe-image'>";

							require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');

							$params = array( 'width' => 500, 'height' => 500, 'crop' => true );

							$output_three_team .= "<img src='" . bfi_thumb( "$large_image_url[0]", $params ) . "' alt=''/>";

							$output_three_team .= "</span>

								<span class='block-recipe-border'></span>

								<span class='block-recipe-info-box'>

									<span class='author-list-avatar'>

										<span class='block-recipe-info-image'>";

											require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');
														
											$author_id = $chefs_latest->post_author;

											$author_avatar_url = get_user_meta($author_id, "wpcook_author_avatar_url", true); 

											if(!empty($author_avatar_url)) {

													$params = array( 'width' => 50, 'height' => 50, 'crop' => true );

													$output_three_team .= "<img class='author-avatar' src='" . bfi_thumb( "$author_avatar_url", $params ) . "' alt='' />";

											} else { 

												$avatar_url = wpcrown_get_avatar_url ( get_the_author_meta('user_email', $author_id), $size = '50' );
												$output_three_team .= "<img class='author-avatar' src='". $avatar_url . "'' alt='' />";

											}

										$output_three_team .= "</span>

									<span class='block-recipe-info-title'>" . the_title() . "</span>

									<span class='block-recipe-info-details'><i class='fa fa-clock-o'></i>". $wpcrown_review_duration = esc_attr(get_post_meta($post->ID, 'wpcrown_review_duration',true)) . "<i class='fa fa-users'></i>" .$menu_portions = get_post_meta($post->ID, 'menu_portions', true) . "<i class='fa fa-flask></i>" . $menu_difficulty = get_post_meta($post->ID, 'menu_difficulty', true) . "</span> </span>

									<span class='block-recipe-info-hover'>

									<span class='block-recipe-info-hover-title>" . the_title() . "</span>

									<span class='block-recipe-info-hover-link'><span>Discover Recipe</span></span>

									<span class='block-recipe-info-details'><i class='fa fa-clock-o'></i>" . $wpcrown_review_duration = esc_attr(get_post_meta($post->ID, 'wpcrown_review_duration',true)) . "<i class='fa fa-users'></i>" . $menu_portions = get_post_meta($post->ID, 'menu_portions', true) . "<i class='fa fa-flask'></i>" . $menu_difficulty = get_post_meta($post->ID, 'menu_difficulty', true) . "</span>
									</a>";

							endwhile;

						$wp_query = null; $wp_query = $temp;

					wp_reset_query();

		$output_three_team = "</div>";			
	
	return $output_three_team;
}
add_shortcode('recent_recipes', 'recent_recipes_func');



// Testimonials
function price_plan_func($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'bgcolor' => '',
	), $atts));

	//extract short code attr

	$output_price_plan = '';
	
	$output_price_plan = "<style type='text/css'> #home-price-plans { background-color: $bgcolor ; }</style>

						  <div id='home-price-plans' style='padding-bottom: 50px; margin-top: 0!important;'>

							<div class='rounded-box-page' style='margin-top: 70px; margin-bottom: 30px;'>
								<div class='full entry-title'>
									<h3><span style='color: #fff;''>$title</span></h3>
									<span class='post-subtitle-span' style='color: #d4d4d4;'>$subtitle</span>
								</div>	
							</div>";

			$output_price_plan .= "<div class='rounded-box-page' style='margin-bottom: 0;'>";

							$current = -1;
		
							query_posts( array('post_type' => 'priceplans', 'posts_per_page' => -1));
						
							if (have_posts()) : while (have_posts()) : the_post(); $current++;

							global $post;

      						$quote_cont = get_the_content($post->ID);

      						$quote_title = get_the_title($post->ID);

      						$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'large', true);
							$imgsource = $image_url[0];
													
							$custom = get_post_custom($post->ID);
														
							$planPrice = $custom["planPrice"][0];
							$planURL = $custom["planURL"][0];
							$planURLName = $custom["planURLName"][0];

							$price_plan_cont = get_the_content($post->ID);

      						$price_plan_title = get_the_title($post->ID);

							$featured_price_plan = get_post_meta($post->ID, 'featured_price_plan', true);

							$output_price_plan .= "<div class='one_third priceplan"; 
									if($current%3 ==0) { ;
							$output_price_plan .= " first"; 
									}; 
									if($featured_price_plan == "1") { ;
										$output_price_plan .= " featured-price-plan";
									};
							$output_price_plan .= "''>";

				$output_price_plan .= "<div class='price-plan-left-box'>
										<div class='price-plan-icon'>
											<img src='$imgsource' alt'' />
										</div>
										<div class='price-plan-name'>
											$price_plan_title
										</div>
										<div class='price-plan-price'>
											$planPrice
										</div>
									</div>

									<div class='price-plan-right-box'>
										$price_plan_cont
									</div>

									<div class='prie-plan-button'>
										<a href='$planURL' alt=''>$planURLName</a>
									</div>

								</div>";
						
						endwhile;

					$output_price_plan .= "</div></div>";

					endif;
					wp_reset_query();
	
	return $output_price_plan;
}
add_shortcode('price_plan', 'price_plan_func');



// Testimonials
function testimonials_slideshow($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'img_url' => '',
	), $atts));

	//extract short code attr

	$output_testimonials = '';
	
	$output_testimonials = "<div id='home-testimonials' style='margin-bottom: 0px; !important; margin-top: 0!important;'><div class='container'>";

							if(!empty($title)) {

			$output_testimonials .= "<div class='full'>
										<h1 class='resume-section-title' style='margin-top: 50px;'><i class='fa fa-comment'></i>".$title."</h1>
										<h3 class='resume-section-subtitle' style='margin-bottom: 30px;''>".$subtitle."</h3>
									</div>";

							}

			$output_testimonials .= "<div class='full' style='margin-bottom: 0;'>

							<div id='owl-demo' class='owl-carousel owl-theme'>";
		
							query_posts( array('post_type' => 'quote', 'posts_per_page' => -1));
						
							if (have_posts()) : while (have_posts()) : the_post();

							global $post;

      						$quote_cont = get_the_content($post->ID);

      						$quote_title = get_the_title($post->ID);

				$output_testimonials .= "<div class='item'>

									  		<div class='resume-testimonials'>

									  			<span class='resume-testimonials-image'>"; 

										  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
														$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
														$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');

								$output_testimonials .= "<img src='" . bfi_thumb( "$large_image_url[0]", $params ) . "' alt='" . $quote_title . "'/>";

						$output_testimonials .= "</span>

									  			<span class='resume-testimonials-quote'><i class='fa fa-quote-right'></i></span>

									  			<div class='resume-testimonials-note'>" . $quote_cont . "</div>

									  			<div class='resume-testimonials-author-box'><span class='resume-testimonial-author'>" . $quote_title . "</span></div>

									  		</div>

									  	</div>";
						
						endwhile;

					$output_testimonials .= "</div></div></div></div>";

					endif;
					wp_reset_query();
	
	return $output_testimonials;
}
add_shortcode('testimonials', 'testimonials_slideshow');



// Featured Companies
function function_featured_companies($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
	), $atts));

	//extract short code attr

	$output_testimonials = '';
	
	$output_testimonials = "<div id='home-featured-companies' style='margin-bottom: 0px; !important; margin-top: 0!important;'><div class='container'>";

							if(!empty($title)) {

			$output_testimonials .= "<div class='full' style='margin-bottom: 0;'>
										<h1 class='resume-section-title' style='margin-top: 50px;'><i class='fa fa-star'></i>".$title."</h1>
										<h3 class='resume-section-subtitle' style='margin-bottom: 30px;''>".$subtitle."</h3>
									</div>";

							}

			$output_testimonials .= "<div class='partners'><div class='partners-container'><p style='text-align: center;'>";
		
							global $wpdb, $currentDate;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																LEFT JOIN  `wp_postmeta` m2 ON p.ID = m2.post_id
																WHERE p.post_type = 'company'
																AND p.post_status = 'publish'
																AND m.meta_key = 'wpjobus_featured_post_status'
																AND m.meta_value = 'featured'
																AND m2.meta_key = 'wpjobus_featured_expiration_date' 
																AND m2.meta_value >= '".$currentDate."'
																ORDER BY ID");

							foreach($wpjobus_jobs as $job) {

								$job_id = $job->ID;

								$link = home_url()."/company/".$job_id;

								$wpjobus_company_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_company_fullname',true));

								$wpjobus_company_profile_picture = esc_attr(get_post_meta($job_id, 'wpjobus_company_profile_picture',true));


				$output_testimonials .= "<a class='partners_images' href='".$link."'><span class='helper' style='height: 120px;'></span><img src='".$wpjobus_company_profile_picture."' alt='".$wpjobus_company_fullname."' /></a>";

							}
						

					$output_testimonials .= "</p></div></div></div></div>";
	
	return $output_testimonials;
}
add_shortcode('featured_companies', 'function_featured_companies');





// WPJobus Stats
function function_wpjobus_stats($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'button_text' => '',
		'button_url' => '',
	), $atts));

	//extract short code attr

	$output_wpjobus_stats = '';
	
	$output_wpjobus_stats = "<div id='home-wpjobus-stats'><div class='container'>";

							if(!empty($title)) {

			$output_wpjobus_stats .= "<div class='full'>
										<h1 class='resume-section-title' style='margin-top: 50px;'><i class='fa fa-bar-chart-o'></i>".$title."</h1>
										<h3 class='resume-section-subtitle' style='margin-bottom: 30px;''>".$subtitle."</h3>
									</div>";

							}

			$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 0;'>

										<div class='one_fourth first' style='text-align: center;'>

											<div class='wpjobus-stat-circle'>";

											global $wpdb;

											$jobs = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'job' and post_status = 'publish'");

											$jobsNum = 0;

											foreach ($jobs as $key => $value) {
												$jobsNum++;
											}

											$st_size = 36;
											$st_margin = 50;

											if(strlen($jobsNum) == 4) {
												$st_size = 32;
												$st_margin = 60;
											}

											if(strlen($jobsNum) == 6) {
												$st_size = 26;
												$st_margin = 63;
											}

											if(strlen($jobsNum) == 8) {
												$st_size = 22;
												$st_margin = 66;
											}

											if(strlen($jobsNum) == 10) {
												$st_size = 18;
												$st_margin = 72;
											}

						$output_wpjobus_stats .= "<span class='wpjobus-stat-circle-title' style='font-size: ".$st_size."px; margin-top: ".$st_margin."px;'><i class='fa fa-bullhorn' style='font-size: ".$st_size."px;'></i><span class='count'>".$jobsNum."</span></span>
												<span class='wpjobus-stat-circle-subtitle'>Job Offers</span>

											</div>

										</div>

										<div class='one_fourth' style='text-align: center;'>

											<span class='wpjobus-stat-circle'>";

											$resumes = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'resume' and post_status = 'publish'");

											$resumesNum = 0;

											foreach ($resumes as $key => $value) {
												$resumesNum++;
											}

											$st_size = 36;
											$st_margin = 50;

											if(strlen($resumesNum) == 4) {
												$st_size = 32;
												$st_margin = 60;
											}

											if(strlen($resumesNum) == 6) {
												$st_size = 26;
												$st_margin = 63;
											}

											if(strlen($resumesNum) == 8) {
												$st_size = 22;
												$st_margin = 66;
											}

											if(strlen($resumesNum) == 10) {
												$st_size = 18;
												$st_margin = 72;
											}

						$output_wpjobus_stats .= "<span class='wpjobus-stat-circle-title' style='font-size: ".$st_size."px; margin-top: ".$st_margin."px;'><i class='fa fa-file-text-o' style='font-size: ".$st_size."px;'></i><span class='count'>".$resumesNum."</span></span>
												<span class='wpjobus-stat-circle-subtitle'>Resumes</span>

											</span>

										</div>

										<div class='one_fourth' style='text-align: center;'>

											<span class='wpjobus-stat-circle'>";

											$companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'company' and post_status = 'publish'");

											$compNum = 0;

											foreach ($companies as $key => $value) {
												$compNum++;
											}

											$st_size = 36;
											$st_margin = 50;

											if(strlen($compNum) == 4) {
												$st_size = 32;
												$st_margin = 60;
											}

											if(strlen($compNum) == 6) {
												$st_size = 26;
												$st_margin = 63;
											}

											if(strlen($compNum) == 8) {
												$st_size = 22;
												$st_margin = 66;
											}

											if(strlen($compNum) == 10) {
												$st_size = 18;
												$st_margin = 72;
											}

						$output_wpjobus_stats .= "<span class='wpjobus-stat-circle-title' style='font-size: ".$st_size."px; margin-top: ".$st_margin."px;'><i class='fa fa-briefcase' style='font-size: ".$st_size."px;'></i><span class='count'>".$compNum."</span></span>
												<span class='wpjobus-stat-circle-subtitle'>Companies</span>

											</span>

										</div>

										<div class='one_fourth' style='text-align: center;'>

											<span class='wpjobus-stat-circle'>";

											$users = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}users` ");

											$usersNum = 0;

											foreach ($users as $key => $value) {
												$usersNum++;
											}

											$st_size = 36;
											$st_margin = 50;

											if(strlen($usersNum) == 4) {
												$st_size = 32;
												$st_margin = 60;
											}

											if(strlen($usersNum) == 6) {
												$st_size = 26;
												$st_margin = 63;
											}

											if(strlen($usersNum) == 8) {
												$st_size = 22;
												$st_margin = 66;
											}

											if(strlen($usersNum) == 10) {
												$st_size = 18;
												$st_margin = 72;
											}

						$output_wpjobus_stats .= "<span class='wpjobus-stat-circle-title' style='font-size: ".$st_size."px; margin-top: ".$st_margin."px;'><i class='fa fa-user' style='font-size: ".$st_size."px;'></i><span class='count'>".$usersNum."</span></span>
												<span class='wpjobus-stat-circle-subtitle'>Members</span>

											</span>

										</div>

									</div>";

							if(!empty($button_text)) {

		$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 50px; text-align: center;'><a href='".$button_url."' id='comp-reset' class='button-ag-full' style='border: 0;'>".$button_text."</a><span class='button-hr-line'></span></div>";	

							}

		$output_wpjobus_stats .= "</div>

							</div>";

	
	return $output_wpjobus_stats;
}
add_shortcode('wpjobus_stats', 'function_wpjobus_stats');


// WPJobus Recent News
function function_recent_news($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'button_text' => '',
		'button_url' => '',
	), $atts));

	global $post;

	//extract short code attr

	$output_wpjobus_stats = '';
	
	$output_wpjobus_stats = "<div id='home-wpjobus-posts'><div class='container'><div class='full'>";

							if(!empty($title)) {

			$output_wpjobus_stats .= "<div class='full'>
										<h1 class='resume-section-title' style='margin-top: 50px;'><i class='fa fa-files-o'></i>".$title."</h1>
										<h3 class='resume-section-subtitle' style='margin-bottom: 30px;''>".$subtitle."</h3>
									</div>";

							}

							global $paged, $wp_query, $wp;

							$args = wp_parse_args($wp->matched_query);

							$temp = $wp_query;

							$wp_query= null;

							$wp_query = new WP_Query();

							$wp_query->query('post_type=post&posts_per_page=3');

							$current_post = 0;

							while ($wp_query->have_posts()) : $wp_query->the_post(); $current_post++; if($current_post <= 3) {

			$output_wpjobus_stats .= "<div class='one_third ";

							if($current_post == 1) { 
								$output_wpjobus_stats .= "first ";
							}
				$output_wpjobus_stats .= "' style='text-align: center; '>";

				$permalink = get_permalink( $post->ID );
				$theTitle = get_the_title( $post->ID );

				if ( has_post_thumbnail() ) {

				$output_wpjobus_stats .= "<div class='full'>";

					require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php');

					$params = array( 'width' => 550, 'height' => 380, 'crop' => true );
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');

				$output_wpjobus_stats .= "<a href='".$permalink."'><img src='".bfi_thumb( "$large_image_url[0]", $params )."' alt='".$theTitle."' style='width: 100%; height: auto;'></a>

				</div>";

				}

				$my_comments = get_comments_number( $post->ID );
				$content = get_the_content();
				$my_comments_link = get_comments_link( $post->ID );
				$post_time = get_the_date();

				$output_wpjobus_stats .= "<h3 style='float: left; width: 100%; text-align: center; margin: 0;''><a href='".$permalink."'>".$theTitle."</a></h3>

				<div class='full post-meta' style='margin-bottom: 0;''>
					<p><i class='fa fa-user' style='margin: 0 10px;'></i>".get_the_author_link()."<i class='fa fa-clock-o' style='margin: 0 10px;''></i>".$post_time."<i class='fa fa-comment' style='margin: 0 10px;'></i><a href='".$my_comments_link."'>".$my_comments."</a></p>
				</div>

				<div class='full' style='margin-bottom: 0;'>".wp_trim_words( $content , '25' )."</div>

			</div>";

			} endwhile;
							
			$wp_query = null; $wp_query = $temp;

			if(!empty($button_text)) {

			$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 50px; text-align: center;'><a href='".$button_url."' id='comp-reset' class='button-ag-full' style='border: 0;'><i class='fa fa-eye'></i>".$button_text."</a><span class='button-hr-line'></span></div>";	

							}

			$output_wpjobus_stats .= "</div></div></div>";

	
	return $output_wpjobus_stats;
}
add_shortcode('recent_news', 'function_recent_news');


// WPJobus Stats
function function_wpjobus_recent_resumes($atts, $content) {

	//extract short code attr

	$output_wpjobus_stats = '';
	
	$output_wpjobus_stats = "<div class='resume-skills' style='margin-top: 50px; padding-bottom: 0; margin-bottom: 50px;'><div id='tabs' class='full' style='margin-bottom: 0;'>

							<ul id='homepage-posts-block' class='tabs quicktabs-tabs quicktabs-style-nostyle'> 
						    	<li class='grid-feat-ad-style'><a class='' href='#'><i class='fa fa-bullhorn'></i>Latest Jobs</a></li>
						    	<li class='list-feat-ad-style'><a class='' href='#'><i class='fa fa-file-text-o'></i>Latest Resumes</a></li>
						    	<li class='list-feat-ad-style'><a class='' href='#'><i class='fa fa-briefcase'></i>Latest Companies</a></li>
			                </ul>";

	$output_wpjobus_stats .= "<div class='pane'><div class='two_third first shortcode-resume-block'><ul id='companies-block-list-ul'>";

							global $wpdb;

							$current_element_id = 0;

							$wpjobus_companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'job' and post_status = 'publish' ORDER BY `ID` DESC");

							foreach($wpjobus_companies as $company) {

								$current_element_id++;

								$company_id = $company->ID;

								$result_company_date = get_the_date("Y-m-d h:m:s", $company_id );
										
								$wpjobus_job_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_job_fullname',true));

								$wpjobus_job_longitude = get_post_meta($company_id, 'wpjobus_job_longitude',true);
								$wpjobus_job_latitude = get_post_meta($company_id, 'wpjobus_job_latitude',true);

								$job_company = esc_attr(get_post_meta($company_id, 'job_company',true));
								$wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
								$wpjobus_company_profile_picture = esc_attr(get_post_meta($job_company, 'wpjobus_company_profile_picture',true));

								$job_location = esc_attr(get_post_meta($company_id, 'job_location',true));

								$job_time = human_time_diff( strtotime($result_company_date), current_time('timestamp') );

								$companylink = home_url().'/job/'.$company_id;

								if($current_element_id <= 6) {

	$output_wpjobus_stats .= "<li id='".$current_element_id."'>

									<a href='".$companylink."'>

										<div class='company-holder-block'>

											<span class='company-list-icon'>
												<span class='helper'></span>
												<img src='".$wpjobus_company_profile_picture."' alt='".$wpjobus_job_fullname."' />
											</span>

											<span class='company-list-name-block' style='max-width: 380px;'>
												<span class='company-list-name'>".$wpjobus_job_fullname."</span>
												<span class='company-list-location'><i class='fa fa-briefcase'></i>".$wpjobus_company_fullname."<i class='fa fa-map-marker' style='margin-left: 10px;''></i>".$job_location."<i class='fa fa-calendar-o' style='margin-left: 10px;'></i>". $job_time ." ago'
												</span>
											</span>

											<span class='company-list-view-profile'>

												<span class='company-view-profile'>
													<span class='company-view-profile-title-holder'>
														<span class='company-view-profile-title'>View</span>
														<span class='company-view-profile-subtitle'>Job Offer</span>
													</span>
													<i class='fa fa-eye'></i>
												</span>

											</span>

											<span class='company-list-badges' style='margin-top: 19px;'>";

													global $redux_demo;
													$colorState = 0;

													if(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][0] ) {
														$colorState = 1;
														$color = '#16a085';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][1] ) {
														$colorState = 1;
														$color = '#3498db';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][2] ) {
														$colorState = 1;
														$color = '#e74c3c';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][3] ) {
														$colorState = 1;
														$color = '#1abc9c';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][4] ) {
														$colorState = 1;
														$color = '#8e44ad';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][5] ) {
														$colorState = 1;
														$color = '#9b59b6';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][6] ) {
														$colorState = 1;
														$color = '#34495e';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][7] ) {
														$colorState = 1;
														$color = '#e67e22';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][8] ) {
														$colorState = 1;
														$color = '#e74c3c';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][9] ) {
														$colorState = 1;
														$color = '#16a085';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][10] ) {
														$colorState = 1;
														$color = '#2980b9';
													} elseif(($wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)) == $redux_demo['job-type'][11] ) {
														$colorState = 1;
														$color = '#2ecc71';
													}

						$output_wpjobus_stats .= "<span class='job-offers-post-badge' style='max-width: 220px; ";

						if($colorState ==1) { 
							$output_wpjobus_stats .= "background-color: ".$color."; border: solid 2px ".$color.";";
						} 
							$output_wpjobus_stats .= "'>
													<span class='job-offers-post-badge-job-type' style='width: 110px; ";
						if($colorState ==1) { 
							$output_wpjobus_stats .= "color: ".$color.";";
						} 
							$output_wpjobus_stats .= "'>".$wpjobus_job_type = get_post_meta($company_id, 'wpjobus_job_type',true)."</span>
													<span class='job-offers-post-badge-amount'>".$wpjobus_job_remuneration = get_post_meta($company_id, 'wpjobus_job_remuneration',true)."</span>
													<span class='job-offers-post-badge-amount-per'>/".$wpjobus_job_remuneration_per = get_post_meta($company_id, 'wpjobus_job_remuneration_per',true)."</span>
												</span>

											</span>

										</div>

									</a>

								</li>";

								}

							}

	$output_wpjobus_stats .= "<ul></div><div class='one_third' style='margin-bottom: 0;'>";
 

							$currentDate = current_time('timestamp');

							$total_jobs = 0;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																WHERE p.post_type = 'job'
																AND p.post_status = 'publish'
																AND m.meta_key = 'wpjobus_featured_expiration_date' 
																AND m.meta_value >= '".$currentDate."'
																ORDER BY RAND()");

							foreach($wpjobus_jobs as $q) { 
							  	$total_jobs++;
							}

							if($total_jobs > 0) {

								$curren_job = 0;

		$output_wpjobus_stats .= "<span class='filters-title'><i class='fa fa-star'></i>Featured Job!</span>";

									foreach($wpjobus_jobs as $job) {

										$curren_job++; 
										  	
										$job_id = $job->ID;

										$link_job = home_url()."/job/".$job_id;

										if($curren_job <= 1) {

			$output_wpjobus_stats .= "<div class='item'>

								  		<a href='".$link_job."'>

									  		<div class='featured-item'>

									  			<span class='featured-item-image'>";

									  					$wpjobus_job_cover_image = esc_attr(get_post_meta($job_id, 'wpjobus_job_cover_image',true));
									  					$wpjobus_job_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_job_fullname',true));
									  					$wpjobus_job_type = get_post_meta($job_id, 'wpjobus_job_type',true);
									  					$wpjobus_job_remuneration_per = get_post_meta($job_id, 'wpjobus_job_remuneration_per',true);
														$wpjobus_job_remuneration = get_post_meta($job_id, 'wpjobus_job_remuneration',true);
														$job_company = esc_attr(get_post_meta($job_id, 'job_company',true));
														$wpjobus_company_fullname = esc_attr(get_post_meta($job_company, 'wpjobus_company_fullname',true));
														$job_location = esc_attr(get_post_meta($job_id, 'job_location',true));

									  					if(!empty($wpjobus_job_cover_image)) {

											  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
															$params = array( 'width' => 340, 'height' => 200, 'crop' => true );
															$output_wpjobus_stats .= "<img class='big-img' src='" . bfi_thumb( "$wpjobus_job_cover_image", $params ) . "' alt='" . $wpjobus_job_fullname . "'/>";

														} else {

															$output_wpjobus_stats .= "<span class='featured-image-replacer'><i class='fa fa-bullhorn'></i>";

														}

						$output_wpjobus_stats .= "</span>

									  			<span class='featured-item-badge'>

									  				<span class='featured-item-job-badge'>

									  					<span class='featured-item-job-badge-title'>".$wpjobus_job_type."</span>

									  					<span class='featured-item-job-badge-info'>

									  						<span class='featured-item-job-badge-info-sum'>".$wpjobus_job_remuneration." / </span>

															<span class='featured-item-job-badge-info-per'> ".$wpjobus_job_remuneration_per."</span>						  						

									  					</span>

									  				</span>

									  			</span>

									  			<span class='featured-item-content'>

									  				<span class='featured-item-content-title'>".$wpjobus_job_fullname."</span>
									  				<span class='featured-item-content-subtitle'>

									  					<span><i class='fa fa-briefcase'></i>".$wpjobus_company_fullname."</span><span><i class='fa fa-map-marker' style='margin-left: 15px;''></i>".$job_location."</spam>

									  				</span>

									  			</span>

									  		</div>

									  	</a>

								  	";

									} }

									$jobs = home_url()."/jobs/";

			$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 0; text-align: center;'><a href='".$jobs."' id='comp-reset' class='button-ag-full'><i class='fa fa-eye'></i>Browse All Jobs</a></div></div>";

								}

		$output_wpjobus_stats .= "</div></div>";

	$output_wpjobus_stats .= "<div class='pane'><div class='two_third first shortcode-resume-block'><ul id='companies-block-list-ul'>";

							global $wpdb;

							$current_element_id = 0;

							$wpjobus_companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'resume' and post_status = 'publish' ORDER BY `ID` DESC");

							foreach($wpjobus_companies as $company) {

								$current_element_id++;

								$company_id = $company->ID;

								$result_company_date = get_the_date("Y-m-d h:m:s", $company_id );
										
								$wpjobus_resume_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_resume_fullname',true));

								$wpjobus_resume_longitude = get_post_meta($company_id, 'wpjobus_resume_longitude',true);
								$wpjobus_resume_latitude = get_post_meta($company_id, 'wpjobus_resume_latitude',true);

								$wpjobus_resume_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_resume_profile_picture',true));

								$resume_location = esc_attr(get_post_meta($company_id, 'resume_location',true));

								$wpjobus_resume_job_type = get_post_meta($company_id, 'wpjobus_resume_job_type',true);

								$wpjobus_resume_prof_title = esc_attr(get_post_meta($company_id, 'wpjobus_resume_prof_title',true));

								$wpjobus_resume_remuneration = get_post_meta($company_id, 'wpjobus_resume_remuneration',true);
								$wpjobus_resume_remuneration_per = get_post_meta($company_id, 'wpjobus_resume_remuneration_per',true);

								$resume_years_of_exp = esc_attr(get_post_meta($company_id, 'resume_years_of_exp',true));

								$companylink = home_url()."/resume/".$company_id;

								if($current_element_id <= 6) {

	$output_wpjobus_stats .= "<li id='".$current_element_id."'>

								<a href='".$companylink."'>

									<div class='company-holder-block'>

										<span class='company-list-icon rounded-img'>";

												require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 

												$params = array( 'width' => 50, 'height' => 50, 'crop' => true );

				$output_wpjobus_stats .= "<img src='".bfi_thumb( "$wpjobus_resume_profile_picture", $params )."'' alt='".$wpjobus_resume_fullname."' />
										</span>

										<span class='company-list-name-block' style='max-width: 380px;'>
											<span class='company-list-name'>".$wpjobus_resume_fullname." <span class='resume-prof-title'>".$wpjobus_resume_prof_title."</span></span>
											<span class='company-list-location'>";

												if(!empty($wpjobus_resume_job_type)) {

														for ($i = 0; $i < (count($wpjobus_resume_job_type)); $i++) {

															if(!empty($wpjobus_resume_job_type[$i][1])) {

						$output_wpjobus_stats .= "<span class='resume_job_".$wpjobus_resume_job_type[$i][0]."'>".$wpjobus_resume_job_type[$i][1]." </span>";

												} } }

						$output_wpjobus_stats .= "<span><i class='fa fa-map-marker' style='margin-left: 10px;''></i>".$resume_location."</span>

											</span>
										</span>

										<span class='company-list-view-profile'>

											<span class='company-view-profile'>
												<span class='company-view-profile-title-holder'>
													<span class='company-view-profile-title'>View</span>
													<span class='company-view-profile-subtitle'>Resume</span>
												</span>
												<i class='fa fa-eye'></i>
											</span>

										</span>

										<span class='company-list-badges' style='margin-top: 19px;''>

											<span class='job-offers-post-badge' style='max-width: 220px; background-color: #7f8c8d; border: solid 2px #7f8c8d;'>
												<span class='job-offers-post-badge-job-type' style='width: 110px; color: #7f8c8d; line-height: 16px; padding-top: 9px; text-align: right;'>".$resume_years_of_exp."+ Years Experience</span>
												<span class='job-offers-post-badge-amount'>".$wpjobus_resume_remuneration."</span>
												<span class='job-offers-post-badge-amount-per'>/".$wpjobus_resume_remuneration_per."</span>
											</span>

										</span>

									</div>

								</a>

							</li>";

								}

							}

	$output_wpjobus_stats .= "<ul></div><div class='one_third' style='margin-bottom: 0;'>";
 

							$currentDate = current_time('timestamp');

							$total_jobs = 0;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																WHERE p.post_type = 'resume'
																AND p.post_status = 'publish'
																AND m.meta_key = 'wpjobus_featured_expiration_date' 
																AND m.meta_value >= '".$currentDate."'
																ORDER BY RAND()");

							foreach($wpjobus_jobs as $q) { 
							  	$total_jobs++;
							}

							if($total_jobs > 0) {

								$curren_job = 0;

		$output_wpjobus_stats .= "<span class='filters-title'><i class='fa fa-star'></i>Featured Resume!</span>";

									foreach($wpjobus_jobs as $job) {

										$curren_job++; 
										  	
										$job_id = $job->ID;

										$link_job = home_url()."/resume/".$job_id;

										if($curren_job <= 1) {

			$output_wpjobus_stats .= "<div class='item'>

								  		<a href='".$link_job."'>

									  		<div class='featured-item'>

									  			<span class='featured-item-image'>";

									  					$wpjobus_resume_cover_image = esc_attr(get_post_meta($job_id, 'wpjobus_resume_cover_image',true));
														$wpjobus_resume_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_resume_fullname',true));
														$wpjobus_resume_profile_picture = esc_attr(get_post_meta($job_id, 'wpjobus_resume_profile_picture',true));
														$wpjobus_resume_prof_title = esc_attr(get_post_meta($job_id, 'wpjobus_resume_prof_title',true));
														$resume_career_level = esc_attr(get_post_meta($job_id, 'resume_career_level',true));
														$resume_location = esc_attr(get_post_meta($job_id, 'resume_location',true));
														$resume_years_of_exp = esc_attr(get_post_meta($job_id, 'resume_years_of_exp',true));
														$wpjobus_resume_remuneration = get_post_meta($job_id, 'wpjobus_resume_remuneration',true);
														$wpjobus_resume_remuneration_per = get_post_meta($job_id, 'wpjobus_resume_remuneration_per',true);
														$wpjobus_resume_job_type = get_post_meta($job_id, 'wpjobus_resume_job_type',true);

									  					if(!empty($wpjobus_resume_cover_image)) {

											  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
															$params = array( 'width' => 340, 'height' => 200, 'crop' => true );
															$output_wpjobus_stats .= "<img class='big-img' src='" . bfi_thumb( "$wpjobus_resume_cover_image", $params ) . "' alt='" . $wpjobus_resume_fullname . "'/>";

														} else {

															$output_wpjobus_stats .= "<span class='featured-image-replacer'><i class='fa fa-bullhorn'></i>";

														}

														if(!empty($wpjobus_resume_profile_picture)) {

									$output_wpjobus_stats .= "<span class='featured-item-content-title-logo'>
											  					<span class='featured-item-content-title-logo-img'>
												  					<span class='helper'></span>";
												  					
												  						require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
																		$params = array( 'width' => 70, 'height' => 70, 'crop' => true );
												  					
											$output_wpjobus_stats .= "<img src='".bfi_thumb( "$wpjobus_resume_profile_picture", $params )."' alt=''>
												  				</span>
											  				</span>";

											  			}

						$output_wpjobus_stats .= "</span>

									  			<span class='featured-item-badge'>

									  				<span class='featured-item-job-badge'>

									  					<span class='featured-item-job-badge-title'>".$resume_years_of_exp." Years</span>

									  					<span class='featured-item-job-badge-info'>

									  						<span class='featured-item-job-badge-info-sum'>".$wpjobus_resume_remuneration." / </span>

															<span class='featured-item-job-badge-info-per'>".$wpjobus_resume_remuneration_per."</span>						  						

									  					</span>

									  				</span>

									  			</span>

									  			<span class='featured-item-content'>

									  				<span class='featured-item-content-title'>".$wpjobus_resume_fullname."</span>
									  				<span class='featured-item-content-tagline'>".$resume_career_level." ".$wpjobus_resume_prof_title."</span>
									  				<span class='featured-item-content-subtitle'>";

										  				if(!empty($wpjobus_resume_job_type)) {

															for ($i = 0; $i < (count($wpjobus_resume_job_type)); $i++) {

																if(!empty($wpjobus_resume_job_type[$i][1])) {

													$output_wpjobus_stats .= " <span class='resume_job_".$wpjobus_resume_job_type[$i][0]."''>".$wpjobus_resume_job_type[$i][1]."</span>";

															} } }

									  				$output_wpjobus_stats .= "<i class='fa fa-map-marker' style='margin-left: 15px;''></i>".$resume_location."</spam>

									  				</span>

									  			</span>

									  		</div>

									  	</a>

								  	";

									} }

									$resumes = home_url()."/resumes/";

			$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 0; text-align: center;'><a href='".$resumes."' id='comp-reset' class='button-ag-full'><i class='fa fa-eye'></i>Browse All Resumes</a></div></div>";

								}

		$output_wpjobus_stats .= "</div></div>";	


$output_wpjobus_stats .= "<div class='pane'><div class='two_third first shortcode-resume-block'><ul id='companies-block-list-ul'>";

							global $wpdb;

							$current_element_id = 0;

							$wpjobus_companies = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type = 'company' and post_status = 'publish' ORDER BY `ID` DESC");

							foreach($wpjobus_companies as $company) {

								$current_element_id++;

								$company_id = $company->ID;

								$wpjobus_company_profile_picture = esc_attr(get_post_meta($company_id, 'wpjobus_company_profile_picture',true));
								$wpjobus_company_fullname = esc_attr(get_post_meta($company_id, 'wpjobus_company_fullname',true));
								$company_location = esc_attr(get_post_meta($company_id, 'company_location',true));
								$wpjobus_company_foundyear = esc_attr(get_post_meta($company_id, 'wpjobus_company_foundyear',true));
								$company_team_size = esc_attr(get_post_meta($company_id, 'company_team_size',true));

								$companylink = home_url()."/company/".$company_id;

								if($current_element_id <= 6) {

	$output_wpjobus_stats .= "<li id='".$current_element_id."'>

								<a href='".$companylink."'>

									<div class='company-holder-block'>

										<span class='company-list-icon'>
											<span class='helper'></span>
											<img src='".$wpjobus_company_profile_picture."' alt='".$wpjobus_company_fullname."' />
										</span>

										<span class='company-list-name-block'>
											<span class='company-list-name'>".$wpjobus_company_fullname."</span>
											<span class='company-list-location'><i class='fa fa-map-marker'></i>".$company_location."
											</span>
										</span>

										<span class='company-list-view-profile'>

											<span class='company-view-profile'>
												<span class='company-view-profile-title-holder'>
													<span class='company-view-profile-title'>View</span>
													<span class='company-view-profile-subtitle'>Profile</span>
												</span>
												<i class='fa fa-eye'></i>
											</span>

										</span>

										<span class='company-list-badges'>

											<span class='company-est-year-block'>
												<i class='fa fa-calendar'></i>
												<span class='experience-period'>Est. In</span>
												<span class='experience-subtitle'>".$wpjobus_company_foundyear."</span>
											</span>

											<span class='company-team-block'>
												<i class='fa fa-users'></i>
												<span class='experience-period'>".$company_team_size."</span>
												<span class='experience-subtitle'>People</span>
											</span>";

												$jobs_offer = 0;

												$id = $company_id;

												$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_company' AND $wpdb->postmeta.meta_value = $id AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'job' AND $wpdb->posts.post_date < NOW() ORDER BY $wpdb->posts.post_date DESC
													";

												$pageposts = $wpdb->get_results($querystr, OBJECT);

												$jobs_offer = 0;

												global $post;
												foreach ($pageposts as $post): 
												
													$jobs_offer++;

												endforeach;
												

				$output_wpjobus_stats .= "<span class='company-jobs-block'>
												<i class='fa fa-bullhorn'></i>
												<span class='experience-period'>".$jobs_offer."</span>
												<span class='experience-subtitle'>";

												if($jobs_offer != 1){ 
													$output_wpjobus_stats .= "Jobs";
												} else { 
													$output_wpjobus_stats .= "Job";
												}
						$output_wpjobus_stats .= "</span>
											</span>

										</span>

									</div>

								</a>

							</li>";

								}

							}

	$output_wpjobus_stats .= "<ul></div><div class='one_third' style='margin-bottom: 0;'>";
 

							$currentDate = current_time('timestamp');

							$total_jobs = 0;

							$wpjobus_jobs = $wpdb->get_results( "SELECT DISTINCT p.ID
																FROM  `wp_posts` p
																LEFT JOIN  `wp_postmeta` m ON p.ID = m.post_id
																WHERE p.post_type = 'company'
																AND p.post_status = 'publish'
																AND m.meta_key = 'wpjobus_featured_expiration_date' 
																AND m.meta_value >= '".$currentDate."'
																ORDER BY RAND()");

							foreach($wpjobus_jobs as $q) { 
							  	$total_jobs++;
							}

							if($total_jobs > 0) {

								$curren_job = 0;

		$output_wpjobus_stats .= "<span class='filters-title'><i class='fa fa-star'></i>Featured Company!</span>";

									foreach($wpjobus_jobs as $job) {

										$curren_job++; 
										  	
										$job_id = $job->ID;

										$link_job = home_url()."/company/".$job_id;

										if($curren_job <= 1) {

			$output_wpjobus_stats .= "<div class='item'>

								  		<a href='".$link_job."'>

									  		<div class='featured-item'>

									  			<span class='featured-item-image'>";

									  					$wpjobus_company_cover_image = esc_attr(get_post_meta($job_id, 'wpjobus_company_cover_image',true));
									  					$wpjobus_company_fullname = esc_attr(get_post_meta($job_id, 'wpjobus_company_fullname',true));
														$wpjobus_company_tagline = esc_attr(get_post_meta($job_id, 'wpjobus_company_tagline',true));
														$wpjobus_company_foundyear = esc_attr(get_post_meta($job_id, 'wpjobus_company_foundyear',true));
														$company_location = esc_attr(get_post_meta($job_id, 'company_location',true));
														$wpjobus_company_profile_picture = esc_attr(get_post_meta($job_id, 'wpjobus_company_profile_picture',true));

											    		$total_jobs = 0;

											    		$company_jobs = $wpdb->get_results( "SELECT p.ID
																							FROM  `{$wpdb->prefix}posts` p
																							LEFT JOIN  `{$wpdb->prefix}postmeta` m ON p.ID = m.post_id
																							WHERE p.post_type = 'job'
																							AND (p.post_status = 'publish' or p.post_status = 'draft' or p.post_status = 'pending')
																							AND m.meta_key = 'job_company' AND m.meta_value = '".$job_id."'
																							");
								  
														foreach($company_jobs as $job) { 
															$total_jobs++;
														}

									  					if(!empty($wpjobus_company_cover_image)) {

											  				require_once(TEMPLATEPATH . '/inc/BFI_Thumb.php'); 
															$params = array( 'width' => 340, 'height' => 200, 'crop' => true );
															$output_wpjobus_stats .= "<img class='big-img' src='" . bfi_thumb( "$wpjobus_company_cover_image", $params ) . "' alt='" . $wpjobus_company_fullname . "'/>";

														} else {

															$output_wpjobus_stats .= "<span class='featured-image-replacer'><i class='fa fa-bullhorn'></i>";

														}

														if(!empty($wpjobus_company_profile_picture)) {

									$output_wpjobus_stats .= "<span class='featured-item-content-title-logo'>
											  					<span class='featured-item-content-company-title-logo-img'>
												  					<span class='helper'></span>
																	<img src='".$wpjobus_company_profile_picture."' alt=''>
												  				</span>
											  				</span>";

											  			}

						$output_wpjobus_stats .= "</span>

									  			<span class='featured-item-badge'>

									  				<span class='featured-item-job-badge'>

									  					<span class='featured-item-job-badge-title'>EST. IN ".$wpjobus_company_foundyear." </span>

									  					<span class='featured-item-job-badge-info'>

									  						<span class='featured-item-job-badge-info-sum'>".$total_jobs."</span>

															<span class='featured-item-job-badge-info-per'>";

															if($total_jobs == 1) { 
																$output_wpjobus_stats .= "Job";
															} else { 
																$output_wpjobus_stats .= "Jobs";
															}

															$output_wpjobus_stats .= "</span>						  						

									  					</span>

									  				</span>

									  			</span>

									  			<span class='featured-item-content'>

									  				<span class='featured-item-content-title'>".$wpjobus_company_fullname."</span>
									  				<span class='featured-item-content-tagline'>".$wpjobus_company_tagline."</span>
									  				<span class='featured-item-content-subtitle'>";

									  				$output_wpjobus_stats .= "<i class='fa fa-map-marker' style='margin-left: 15px;''></i>".$company_location."</spam>

									  				</span>

									  			</span>

									  		</div>

									  	</a>

								  	";

									} }

									$company = home_url()."/companies/";

			$output_wpjobus_stats .= "<div class='full' style='margin-bottom: 0; text-align: center;'><a href='".$company."' id='comp-reset' class='button-ag-full'><i class='fa fa-eye'></i>Browse All Companies</a></div></div>";

								}

		$output_wpjobus_stats .= "</div></div>";						

	$output_wpjobus_stats .= "</div></div>";

	
	return $output_wpjobus_stats;
}
add_shortcode('wpjobus_recent_resumes', 'function_wpjobus_recent_resumes');




// Blog Shortcodes
function latest_four_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_four_posts', 'latest_four_posts_func');


// Blog Shortcodes
function latest_four_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_four_posts_no_thumb', 'latest_four_posts_no_thumb_func');



// Blog Shortcodes
function popular_four_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_four_posts', 'popular_four_posts_func');


// Blog Shortcodes
function popular_four_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_four_posts_no_thumb', 'popular_four_posts_no_thumb_func');



// Blog Shortcodes
function category_four_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_four_posts', 'category_four_posts_func');


// Blog Shortcodes
function category_four_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=4');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_fourth "; 
						if($current%4 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_four_posts_no_thumb', 'category_four_posts_no_thumb_func');



// Blog Shortcodes
function latest_three_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_three_posts', 'latest_three_posts_func');


// Blog Shortcodes
function latest_three_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_three_posts_no_thumb', 'latest_three_posts_no_thumb_func');



// Blog Shortcodes
function popular_three_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_three_posts', 'popular_three_posts_func');


// Blog Shortcodes
function popular_three_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_three_posts_no_thumb', 'popular_three_posts_no_thumb_func');



// Blog Shortcodes
function category_three_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_three_posts', 'category_three_posts_func');


// Blog Shortcodes
function category_three_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=3');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(105, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_third "; 
						if($current%3 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_three_posts_no_thumb', 'category_three_posts_no_thumb_func');



// Blog Shortcodes
function latest_two_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_two_posts', 'latest_two_posts_func');


// Blog Shortcodes
function latest_two_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(320, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('latest_two_posts_no_thumb', 'latest_two_posts_no_thumb_func');
// end blog shortcodes


// Blog Shortcodes
function popular_two_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_two_posts', 'popular_two_posts_func');


// Blog Shortcodes
function popular_two_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('orderby=comment_count&showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(320, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('popular_two_posts_no_thumb', 'popular_two_posts_no_thumb_func');
// end blog shortcodes



// Blog Shortcodes
function category_two_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(220, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
								if ( has_post_thumbnail() ) { ;

		$output_blog .= "<div class='full' style='margin-bottom: 0;' >

									<div class='full'>
									
										<div class='full shortcode-blog' style='margin-bottom: 0;'>
									
											<div class='portfolio-image-holder'>
									
												<img src='$imgsource' alt='$temp_title' />
											
											</div>
											
										</div>
										
									</div>

									<div class='full' style='margin-bottom: 0;'>
									
										<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
										
										<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>
										
									</div>

								</div>";
								
								 
									} else { ;
								
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";
								
								
									} ;
								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_two_posts', 'category_two_posts_func');


// Blog Shortcodes
function category_two_posts_no_thumb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'link' => '',
		'category_name' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_blog = '';
	
	$output_blog .= "<div class='entry-title'><h3><span>$title</span></h3></div>";

							global $wp_query;

							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$wp_query->query('category_name='.$category_name.'&showposts=2');


							$current = -1;
						
							while ($wp_query->have_posts()) : $wp_query->the_post();

							$current++;

							

							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'blog_post_image', true);
							$imgsource = $image_url[0];

							global $post_id; 

      						$postID = get_post( $post_id );

      						global $post;

							$temp_link = get_permalink($post->ID);

							$temp_title = get_the_title($post->ID);

							$temp_date = get_the_time('M j, Y', $post->ID);
							
							
							$archive_year  = get_the_time('Y');
							$archive_month = get_the_time('m');
							
							
							$temp_date_link = get_month_link( $archive_year, $archive_month );
							

							$temp_author = get_the_author();
							
							$temp_author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );

							$temp_excerpt = get_excerpt(220, 'content');
							
							$temp_excerpt_big = get_excerpt(320, 'content');
							
							
							$categories = get_the_category();
							$separator = ', ';
							$output = '';
							if($categories){
								foreach($categories as $category) {
									$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", "agrg" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
								}
							$categories_item = trim($output, $separator);
							}
			
			
			$output_blog .= "<div class='one_half "; 
						if($current%2 ==0) { ;
				$output_blog .= "first "; 
						}; 
				$output_blog .= "'>";
				
							
			$output_blog .= "<div class='post-preview' style='margin-bottom: 0;'>";
								
		$output_blog .= "<div class='full' style='margin-bottom: 0;'>
									
									<h4><span style='font-weight: bold; margin-bottom: 10px; float: left; padding-bottom: 10px; border-bottom: dotted 1px #d7d7d7;'><a href='$temp_link'>$temp_title</a></span></h4>
									<div class='post-full'>
										
										<p>By <a href='$temp_author_link'>$temp_author</a> on <a href='$temp_date_link'>$temp_date</a></p>
										
										<p class='post-preview-excerpt'>$temp_excerpt_big</p>
										<span><a href='$temp_link'>Read More</a></span>
											
									</div>

								</div>";								

	$output_blog .= "</div></div>";
			
						
						endwhile;

			global $name;

			$category_id = get_cat_ID( $name );
			$category_link = get_category_link( $category_id );			

					wp_reset_query();

			

			if (!empty($link)) {

				$output_blog .= "<div class='full' style='text-align: center;'><a href='$link' class='button-ag large read-more' style='margin-right: 0; text-transform:uppercase;'><span class='button-inner'>More Items</span></a></div>";

			} else {

				$output_blog .= "";

			}
	
	return $output_blog;
}
add_shortcode('category_two_posts_no_thumb', 'category_two_posts_no_thumb_func');
// end blog shortcodes




// Partners Shortcodes
function partners_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
	), $atts));
	
	$custom_id = time().rand();

	$output_partners = '';
	
	$output_partners = "<div class='partners'><div class='partners-container'><p style='text-align: center;'>";
		
							query_posts( array('post_type' => 'spns',  'posts_per_page' => 10));

							$current = -1;
						
							if (have_posts()) : while (have_posts()) : the_post(); $current++;

      						$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'large', true);
							$imgsource = $image_url[0]; 

							global $post;

							$custom = get_post_custom( $post->ID );
							$link = $custom["brandUrl"][0];

				$output_partners .= "<a class='partners_images' href='$link'><img src='$imgsource' alt='' /></a>";
						
						endwhile;

					$output_partners .= "</p></div></div>";

					endif;
					wp_reset_query();
	
	return $output_partners;
}
add_shortcode('partners', 'partners_func');



function accordion_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'close' => 0,
	), $atts));
	
	$close_class = '';
	
	if(!empty($close))
	{
		$close_class = 'wpcrown_accordion_close';
	}
	
	$return_html = '<div class="wpcrown_accordion '.$close_class.'"><h3><a href="#">'.$title.'</a></h3>';
	$return_html = '<div><p>';
	$return_html.= do_shortcode($content);
	$return_html = '</p></div></div><br class="clear"/>';
	
	return $return_html;
}
add_shortcode('accordion', 'accordion_func');


function recent_posts_func($atts) {
	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 3,
	), $atts));

	$return_html = wpcrown_posts('recent', $items, FALSE, 'black', FALSE);
	
	return $return_html;
}
add_shortcode('recent_posts', 'recent_posts_func');



function popular_posts_func($atts) {
	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 3,
	), $atts));

	$return_html = wpcrown_posts('poopular', $items, FALSE, 'black', FALSE);
	
	return $return_html;
}
add_shortcode('popular_posts', 'popular_posts_func');


function slide_vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'video_id' => '',
	), $atts));

	if(empty($wpcrown_slider_height))
	{
		$wpcrown_slider_height = 405;
	}
	
	$wpcrown_slider_height_offset = $wpcrown_slider_height - 405;
	
	$return_html = '<li>';
	$return_html = '<object width="939" height="'.intval(400+$wpcrown_slider_height_offset).'"><param name="allowfullscreen" value="true" /><param name="wmode" value="opaque"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="939" height="'.intval(400+$wpcrown_slider_height_offset).'" wmode="transparent"></embed></object>';
	$return_html = '</li>'. PHP_EOL;
	
	return $return_html;
}
add_shortcode('slide_vimeo', 'slide_vimeo_func');


function slide_youtube_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'video_id' => '',
	), $atts));

	if(empty($wpcrown_slider_height))
	{
		$wpcrown_slider_height = 405;
	}
	
	$wpcrown_slider_height_offset = $wpcrown_slider_height - 405;
	
	$return_html = '<li>';
	$return_html = '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$video_id.'&hd=1" style="width:939px;height:'.intval(400+$wpcrown_slider_height_offset).'px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/'.$video_id.'&hd=1" /></object>';
	$return_html = '</li>'. PHP_EOL;
	
	return $return_html;
}
add_shortcode('slide_youtube', 'slide_youtube_func');

/**
*	End Portfolio slider shortcodes
**/


function pricing_func($atts, $content) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'size' => '',
		'title' => '',
		'column' => 3,
	), $atts));
	
	$width_class = 'three';
	switch($column)
	{
		case 3:
			$width_class = 'three';
		break;
		case 4:
			$width_class = 'four';
		break;
		case 5:
			$width_class = 'five';
		break;
	}
	
	$return_html = '<div class="pricing_box '.$size.' '.$width_class.'">';
	
	if(!empty($title))
	{
		$return_html = '<div class="header">';
		$return_html = '<span>'.$title.'</span>';
		$return_html = '</div><br/>';
	}
	
	$return_html.= do_shortcode($content);
	$return_html = '</div>';
	
	return $return_html;
}
add_shortcode('pricing', 'pricing_func');

function youtube_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 640,
		'height' => 385,
		'video_id' => '',
	), $atts));
	
	$custom_id = time().rand();
	
	$return_html = '<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/'.$video_id.'&hd=1" style="width:'.$width.'px;height:'.$height.'px"><param name="wmode" value="opaque"><param name="movie" value="http://www.youtube.com/v/'.$video_id.'&hd=1" /></object>';
	
	return $return_html;
}
add_shortcode('youtube-video', 'youtube_func');


function vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 640,
		'height' => 385,
		'video_id' => '',
	), $atts));
	
	$custom_id = time().rand();
	
	$return_html = '<object width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true" /><param name="wmode" value="opaque"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed></object>';
	
	return $return_html;
}
add_shortcode('vimeo-video', 'vimeo_func');


function twitter_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 5,
		'username' => ''
	), $atts));
	
	$return_html = '';
	
	if(!empty($username))
	{
		get_template_part(TEMPLATEPATH . "/lib/twitter.lib.php");
		$obj_twitter = new Twitter($username); 
		$tweets = $obj_twitter->get($items);
	
		$return_html = '<ul class="twitter">';
		
		foreach($tweets as $tweet)
		{
		    $return_html = '<li>';
		    
		    if(isset($tweet[0]))
		    {
		    	$return_html = '<a href="'.$tweet[2][0].'">'.$tweet[0].'</a>';
		    }
		    
		    $return_html = '</li>';
		}
		
		$return_html = '</ul>';
	}
	
	return $return_html;
}
add_shortcode('twitter', 'twitter_func');


function flickr_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 9,
		'flickr_id' => ''
	), $atts));
	
	$return_html = '';
	
	if(!empty($flickr_id))
	{
		$photos_arr = get_flickr(array('type' => 'user', 'id' => $flickr_id, 'items' => $items));

		$return_html = '<ul class="flickr">';
		
		foreach($photos_arr as $photo)
		{
		    $return_html = '<li>';
		    $return_html = '<a href="'.$photo['url'].'" title="'.$photo['title'].'"><img src="'.$photo['thumb_url'].'" alt="" class="frame img_nofade" /></a>';$return_html = '</li>';
		}
		
		$return_html = '</ul><br class="clear"/>';
	}
	
	return $return_html;
}
add_shortcode('flickr', 'flickr_func');


function chart_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 590,
		'height' => 250,
		'type' => '',
		'title' => '',
		'data' => '',
		'label' => '',
		'colors' => '',
	), $atts));
	
	switch($type)
	{
		case '3dpie':
			$type_q = 'p3';
		break;
		case 'pie':
			$type_q = 'p';
		break;
		case 'line':
			$type_q = 'lc';
		break;
	}
	
	$content_bg = get_option('wpcrown_content_bg_color');
	$content_bg = substr($content_bg, 1);
	
	$return_html = '<img src="http://chart.apis.google.com/chart?cht='.$type_q.'&#038;chtt='.$title.'&#038;chl='.$label.'&#038;chco='.$colors.'&#038;chs='.$width.'x'.$height.'&#038;chd=t:'.$data.'&#038;chf=bg,s,'.$content_bg.'" alt="'.$title.'"/>';
	
	return $return_html;
}
add_shortcode('chart', 'chart_func');


function table_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'color' => '',
	), $atts));
	
	switch(strtolower($color))
		{
			case 'black':
				$bg_color = '#000000';
				$text_color = '#ffffff';
			break;
			default:
			case 'gray':
				$bg_color = '#666666';
				$text_color = '#ffffff';
			break;
			case 'white':
				$bg_color = '#f5f5f5';
				$text_color = '#444444';
			break;
			case 'blue':
				$bg_color = '#004a80';
				$text_color = '#ffffff';
			break;
			case 'yellow':
				$bg_color = '#f9b601';
				$text_color = '#ffffff';
			break;
			case 'red':
				$bg_color = '#9e0b0f';
				$text_color = '#ffffff';
			break;
			case 'orange':
				$bg_color = '#fe7201';
				$text_color = '#ffffff';
			break;
			case 'green':
				$bg_color = '#7aad34';
				$text_color = '#ffffff';
			break;
			case 'pink':
				$bg_color = '#d2027d';
				$text_color = '#ffffff';
			break;
			case 'purple':
				$bg_color = '#582280';
				$text_color = '#ffffff';
			break;
		}
	
	$bg_color_light = '#'.hex_lighter(substr($bg_color, 1), 20);
	$border_color = '#'.hex_lighter(substr($bg_color, 1), 10);
	
	$return_html = '<style>
	#content_wrapper .table_'.strtolower($color).' table 
	{
		border:1px solid '.$border_color.';
	}
	#content_wrapper .table_'.strtolower($color).' table tr th
	{
		background: -webkit-gradient(linear, left top, left bottom, from('.$bg_color_light.'), to('.$bg_color.'));background: -moz-linear-gradient(top,  '.$bg_color_light.',  '.$bg_color.');filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr=\''.$bg_color_light.'\', endColorstr=\''.$bg_color.'\');color:'.$text_color.';
	}
	#content_wrapper .table_'.strtolower($color).' table tr th, #content_wrapper .table_'.strtolower($color).' table tr td
	{
		border-bottom:1px solid '.$border_color.';
	}
	#content_wrapper table tr:last-child
	{
		border-bottom: 0;
	}
	</style>';
	$return_html = '<div class="table_'.strtolower($color).'">';
	$return_html.= html_entity_decode(do_shortcode($content));
	$return_html = '</div>';
	
	return $return_html;
}
add_shortcode('table', 'table_func');

?>