<?php
/**
 * WPJobus functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage WPJobus
 * @since WPJobus 1.1.1
 */


add_action( 'after_setup_theme', 'WPJobus_theme_setup' );


function WPJobus_theme_setup() {

	add_theme_support( 'woocommerce' );

	// Add Page Meta Fields
	require get_template_directory() . '/inc/page_meta.php';

	// Add Shortcodes
	require get_template_directory() . '/inc/shortcode.lib.php';

	// Add Colors
	require get_template_directory() . '/inc/colors.php';

	// Add Twitter
	require get_template_directory() . '/inc/twitter.php';

	// Add Resume Custom Post Type
	require get_template_directory() . '/inc/resume.php';

	// Add Resume Custom Fields
	require get_template_directory() . '/inc/resume_meta.php';

	// Add Job Custom Post Type
	require get_template_directory() . '/inc/job.php';

	// Add Job Custom Fields
	require get_template_directory() . '/inc/job_meta.php';

	// Add Company Custom Post Type
	require get_template_directory() . '/inc/company.php';

	// Add Company Custom Fields
	require get_template_directory() . '/inc/company_meta.php';

	// Add Testimonials Custom Post Type
	require get_template_directory() . '/inc/quotes.php';

	// Add Plans Custom Post Type
	//require get_template_directory() . '/inc/plans.php';

	// Add Clients Custom Post Type
	//require get_template_directory() . '/inc/clients.php';

	// I Like This Plugin
	require get_template_directory() . '/inc/like/i-like-this.php';

	// Companies Filters
	require get_template_directory() . '/inc/companies-filters.php';

	// Jobs Filters
	require get_template_directory() . '/inc/jobs-filters.php';

	// Resumes Filters
	require get_template_directory() . '/inc/resumes-filters.php';

	// Review Pendings
	require get_template_directory() . '/inc/review-pendings.php';

	// Featured Update
	require get_template_directory() . '/inc/featured-items-update.php';

	// Post Status Update
	require get_template_directory() . '/inc/post-status.php';

	// Send Subscriptions Notification
	require get_template_directory() . '/inc/subscriptions.php';

	/**
	 * Sets up the content width value based on the theme's design.
	 * @see WPJobus_content_width() for template-specific adjustments.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 1060;

	/**
	 * WPJobus only works in WordPress 3.6 or later.
	 */
	if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )
		require get_template_directory() . '/inc/back-compat.php';

	/**
	 * Sets up theme defaults and registers the various WordPress features that
	 * WPJobus supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add Visual Editor stylesheets.
	 * @uses add_theme_support() To add support for automatic feed links, post
	 * formats, and post thumbnails.
	 * @uses register_nav_menu() To add support for a navigation menu.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since WPJobus 1.0
	 *
	 * @return void
	*/

	/*
	 * Makes WPJobus available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on WPJobus, use a find and
	 * replace to change 'WPJobus' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'agrg', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', WPJobus_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Switches default core markup for search form, comment form, and comments
	// to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'agrg' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 440, 266, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Disable Disqus commehts on woocommerce product //
	add_filter( 'woocommerce_product_tabs', 'WPJobus_disqus_override_tabs', 98);

	/* Add your nav menus function to the 'init' action hook. */
	add_action( 'init', 'WPJobus_register_my_menu' );

	// Custom admin scripts
	add_action('admin_enqueue_scripts', 'WPJobus_custom_admin_scripts' );

	// Author add new contact details
	add_filter('user_contactmethods','WPJobus_author_new_contact',10,1);

	// Lost Password and Login Error
	add_action( 'wp_login_failed', 'WPJobus_front_end_login_fail' );  // hook failed login

	// Register the custom twitter widget
	add_action( 'widgets_init', 'WPJobus_register_custom_twitter_widget' );

	 // Register the custom social widget
	add_action( 'widgets_init', 'WPJobus_register_custom_social_widget' );

	// Load scripts and styles
	add_action( 'wp_enqueue_scripts', 'WPJobus_scripts_styles' );

	//Include the TGM_Plugin_Activation class.
	require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
	add_action( 'tgmpa_register', 'WPJobus_theme_register_required_plugins' );

	// Google analitycs code
	add_action( 'wp_enqueue_scripts', 'WPJobus_google_analityc_code' );

	// Enqueue main font
	add_action( 'wp_enqueue_scripts', 'WPJobus_main_font' );

	// Enqueue second font
	add_action( 'wp_enqueue_scripts', 'WPJobus_second_font' );

	// Enqueue third font
	add_action( 'wp_enqueue_scripts', 'WPJobus_third_font' );

	// Track views
	add_action( 'wp_head', 'WPJobus_track_post_views');

	// Theme page titles
	add_filter( 'wp_title', 'WPJobus_wp_title', 10, 2 );

	// WPJobus sidebars spot
	add_action( 'widgets_init', 'WPJobus_widgets_init' );

	// WPJobus body class
	add_filter( 'body_class', 'WPJobus_body_class' );

	// WPJobus content width
	add_action( 'template_redirect', 'WPJobus_content_width' );

	// WPJobus customize register
	add_action( 'customize_register', 'WPJobus_customize_register' );

	// WPJobus customize preview
	add_action( 'customize_preview_init', 'WPJobus_customize_preview_js' );

	// Add has-submenu if the menu has sub menu
	add_filter( "nav_menu_css_class", "WPJobus_menu_item_parent_classing", 10, 2 );

	/* Add theme support for automatic feed links. */   
	add_theme_support( 'automatic-feed-links' );


	//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
	remove_filter('pre_user_description', 'wp_filter_kses');
	//add sanitization for WordPress posts
	add_filter( 'pre_user_description', 'wp_filter_post_kses');


	// Reset permalinks
	add_action( 'init', 'WPJobus_reset_permalinks' );	

	add_filter( 'import_allow_create_users', '__return_true' );
	add_filter( 'import_allow_fetch_attachments', '__return_true' );


}

function init_import() {
	if ( isset( $_POST['wpjobusImportDemo_nonce'] ) && wp_verify_nonce( $_POST['wpjobusImportDemo_nonce'], 'wpjobusImportDemo_html' ) ) {

		require_once TEMPLATEPATH . '/inc/autoimporter/autoimporter.php';
	 
		// call the function
		$args = array(
				'file'        => TEMPLATEPATH . '/inc/autoimporter/demo.xml',
				'map_user_id' => 1
		);
		 
		auto_import( $args );

	}
}

add_action( 'wp_ajax_wpjobusImportDemo', 'init_import' );
add_action( 'wp_ajax_nopriv_wpjobusImportDemo', 'init_import' );

// Add Redux Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/sample/sample-config.php' ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxFramework/sample/sample-config.php' );
}



global $redux_demo, $website_type; 
$website_type = $redux_demo['homepage-state'];

if($website_type == 2) {

	// Start Resume as home function
	add_filter( 'get_pages',  'add_my_salesletters' );

	function add_my_salesletters( $pages ) {

	     $my_salesletters_pages = new WP_Query( array( 'post_type' => 'resume' ) );

	     if ( $my_salesletters_pages->post_count > 0 )

	     {

	         $pages = array_merge( $pages, $my_salesletters_pages->posts );

	     }

	     return $pages;

	}

	add_filter( 'template_redirect', 'enable_front_page_stacks', 1);

	function enable_front_page_stacks($template) {

		if ( $_SERVER["REQUEST_URI"] == "/" ) {

			query_posts("p=".get_option("page_on_front")."&post_type=resume");

			the_post();

			include(plugin_dir_path(__FILE__) . "/template-single-resume.php");

			die;

		}

		return $template;

	}

	function enable_front_page_cpt( $query ){

	    if('' == $query->query_vars['post_type'] && 0 != $query->query_vars['page_id'])

	        $query->query_vars['post_type'] = array( 'page','resume' );

	}

	add_action( 'pre_get_posts', 'enable_front_page_cpt' );



	add_action("template_redirect", 'template_redirect_frontpage_cpt');

	function template_redirect_frontpage_cpt() {

		if (is_front_page() && is_singular('resume'))

		{

		   include(TEMPLATEPATH . "/template-single-resume.php");

		   die();

		}

	}
	// End Resume as home function

} elseif($website_type == 3) {

	// Start Company as home function
	add_filter( 'get_pages',  'add_my_salesletters' );

	function add_my_salesletters( $pages ) {

	     $my_salesletters_pages = new WP_Query( array( 'post_type' => 'company' ) );

	     if ( $my_salesletters_pages->post_count > 0 )

	     {

	         $pages = array_merge( $pages, $my_salesletters_pages->posts );

	     }

	     return $pages;

	}

	add_filter( 'template_redirect', 'enable_front_page_stacks', 1);

	function enable_front_page_stacks($template) {

		if ( $_SERVER["REQUEST_URI"] == "/" ) {

			query_posts("p=".get_option("page_on_front")."&post_type=company");

			the_post();

			include(plugin_dir_path(__FILE__) . "/template-single-company.php");

			die;

		}

		return $template;

	}

	function enable_front_page_cpt( $query ){

	    if('' == $query->query_vars['post_type'] && 0 != $query->query_vars['page_id'])

	        $query->query_vars['post_type'] = array( 'page','company' );

	}

	add_action( 'pre_get_posts', 'enable_front_page_cpt' );



	add_action("template_redirect", 'template_redirect_frontpage_cpt');

	function template_redirect_frontpage_cpt() {

		if (is_front_page() && is_singular('company'))

		{

		   include(TEMPLATEPATH . "/template-single-company.php");

		   die();

		}

	}
	// End Company as home function

}




function WPJobus_reset_permalinks() {
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%postname%/' );
}


function WPJobusisSiteAdmin(){
	$currentUser = wp_get_current_user();
	return in_array('administrator', $currentUser->roles);
}


// function to count views.
function WPJobus_setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}


/**
 * Add "has-submenu" CSS class to navigation menu items that have children in a
 * submenu.
 */
function WPJobus_menu_item_parent_classing( $classes, $item )
{
	global $wpdb;
	
	$has_children = $wpdb -> get_var( "SELECT COUNT(meta_id) FROM {$wpdb->prefix}postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'" );
	
	if ( $has_children > 0 )
	{
		array_push( $classes, "has-submenu" );
	}
	
	return $classes;
}



function WPJobus_get_avatar_url($author_id, $size){
	$get_avatar = get_avatar( $author_id, $size );
	preg_match("/src='(.*?)'/i", $get_avatar, $matches);
	return ( $matches[1] );
}

function filter_handler( $data , $postarr ){
  	global $post, $id;

  	if(('job' == $data['post_type'] && isset($data['post_type'])) or ('company' == $data['post_type'] && isset($data['post_type'])) or ('resume' == $data['post_type'] && isset($data['post_type']))) {

  		$id = $postarr['ID'];

		if($id) {

			$title = $_POST['ID'];
			$wpjobus_title = esc_attr(get_post_meta($title, 'wpjobus_post_title',true));

			if(!empty($wpjobus_title)) {
				$data['post_title'] = $wpjobus_title;
			} else {
				$data['post_title'] = $title;
			}
			
			$data['post_name'] = $title;
		}

	}

  	return $data;
}

add_filter( 'wp_insert_post_data' , 'filter_handler' , '99', 2 );


// Disable Disqus commehts on woocommerce product //
function WPJobus_disqus_override_tabs($tabs){
	if ( has_filter( 'comments_template', 'dsq_comments_template' ) ){
		remove_filter( 'comments_template', 'dsq_comments_template' );
		add_filter('comments_template', 'dsq_comments_template',90);//higher priority, so the filter is called after woocommerce filter
	}
	return $tabs;
}


// Hide text editor in resume back end
add_action('init', 'init_remove_support_resume',100);
function init_remove_support_resume(){
	$post_type = 'resume';
	remove_post_type_support( $post_type, 'editor');
}

// Hide text editor in job back end
add_action('init', 'init_remove_support_job',100);
function init_remove_support_job(){
	$post_type = 'job';
	remove_post_type_support( $post_type, 'editor');
}

// Hide text editor in job back end
add_action('init', 'init_remove_support_company',100);
function init_remove_support_company(){
	$post_type = 'company';
	remove_post_type_support( $post_type, 'editor');
}


function WPJobus_getUrl() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return $url;
}


if ( current_user_can('subscriber') && !current_user_can('upload_files') )
	add_action('admin_init', 'WPJobus_allow_contributor_uploads');
function WPJobus_allow_contributor_uploads() {
	$contributor = get_role('subscriber');
	$contributor->add_cap('upload_files');
}

add_filter( 'posts_where', 'WPJobus_devplus_attachments_wpquery_where' );
function WPJobus_devplus_attachments_wpquery_where( $where ){
	global $current_user;

	if( is_user_logged_in() ){
		// we spreken over een ingelogde user
		if( isset( $_POST['action'] ) ){
			// library query
			if( $_POST['action'] == 'query-attachments' ){
				$where .= ' AND post_author='.$current_user->data->ID;
			}
		}
	}

	return $where;
}


/*
 *  Setup main navigation menu
 */
function WPJobus_register_my_menu() {
	// register menu
	register_nav_menus (
		array(
		'primary' =>__('Main menu'),
		'secondary' =>__('Top menu'),
		'third' =>__('Footer menu'),
		)
	);
}


// Custom admin scripts
function WPJobus_custom_admin_scripts() {
	wp_enqueue_media();
}


// Author add new contact details
function WPJobus_author_new_contact( $contactmethods ) {

	// Add telefone
	$contactmethods['phone'] = 'Phone';
	// add address
	$contactmethods['address'] = 'Address';
 
	return $contactmethods;
	
}


// Lost Password and Login Error
function WPJobus_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
		exit;
   } elseif ( is_wp_error($user_verify) )  {
		wp_redirect( $referrer . '?login=failed-user' );  // let's append some information (login=failed) to the URL for the theme to use
		exit;
   }
}
// End


// Display 8 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 20 );

// Redefine WPJobus_woocommerce_output_related_products()
function WPJobus_woocommerce_output_related_products() {
  woocommerce_related_products(4,4); // Display 4 products in rows of 2
}


// Insert attachments front end
function WPJobus_wpcads_insert_attachment($file_handler,$post_id,$setthumb='false') {

  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );

  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}


function WPJobus_get_attachment_id_from_src($image_src) {

	global $wpdb;
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	return $id;

}


// count comments by author functions
function WPJobus_author_comment_count($author_email){
 
	$oneText = '1';
	$moreText = '%';
 
	global $wpdb;
 
	$result = $wpdb->get_var('
		SELECT
			COUNT(comment_ID)
		FROM
			'.$wpdb->comments.'
		WHERE
			comment_author_email = "'.$author_email.'"'
	);
 
	echo $result;
 
}


/**
*	Begin Twitter Custom Widgets
**/
class WPJobus_custom_twitter extends WP_Widget {
	function WPJobus_custom_twitter() {
		$widget_ops = array('classname' => 'WPJobus_custom_twitter', 'description' => 'Display your recent Twitter feed' );
		$this->WP_Widget('WPJobus_custom_twitter', 'WPJobus Custom Twitter', $widget_ops);
	}

	function widget($args, $instance) {
	// outputs the content of the widget
	extract($args); // Make before_widget, etc available.

	$twitter_consumer_key = isset($instance['twitter_consumer_key']) ? $instance['twitter_consumer_key'] : "";
	$twitter_consumer_secret = isset($instance['twitter_consumer_secret']) ? $instance['twitter_consumer_secret'] : "";
	$twitter_user_token = isset($instance['twitter_user_token']) ? $instance['twitter_user_token'] : "";
	$twitter_user_secret = isset($instance['twitter_user_secret']) ? $instance['twitter_user_secret'] : "";
	$twitter_username = isset($instance['twitter_username']) ? $instance['twitter_username'] : "";
	$twitter_count = isset($instance['twitter_count']) ? $instance['twitter_count'] : "";

	$twitter_title = empty($instance['title']) ? __('Twitter', TEMPLATE_DOMAIN) : apply_filters('widget_title', $instance['title']);
	$unique_id = $args['widget_id'];


	echo $before_widget;
	echo $before_title . $twitter_title . $after_title; ?>
	<ul class="twitterbox" id="twitter_update_list_<?php echo $unique_id; ?>">


	<?php echo agurghis_twitter_timeline (
	$twitter_username,
	$twitter_count,
	$twitter_consumer_key,
	$twitter_consumer_secret,
	$twitter_user_token,
	$twitter_user_secret ); ?>

	<li class="followme"><?php  _e("Joined ",'TEMPLATE_DOMAIN'); ?>
	<?php echo agurghis_twitter_count (
	$twitter_username,
	$twitter_consumer_key,
	$twitter_consumer_secret,
	$twitter_user_token,
	$twitter_user_secret );
	?> <?php  _e("Followers ",'TEMPLATE_DOMAIN'); ?><a href="https://twitter.com/<?php echo $twitter_username; ?>"><?php  _e("@",'TEMPLATE_DOMAIN'); ?><?php echo $twitter_username; ?></a></li>

	</ul>
	<?php echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//update and save the widget
	return $new_instance;
	}

	function form($instance) {
	// Get the options into variables, escaping html characters on the way
	$twitter_consumer_key = isset($instance['twitter_consumer_key']) ? $instance['twitter_consumer_key'] : "";
	$twitter_consumer_secret = isset($instance['twitter_consumer_secret']) ? $instance['twitter_consumer_secret'] : "";
	$twitter_user_token = isset($instance['twitter_user_token']) ? $instance['twitter_user_token'] : "";
	$twitter_user_secret = isset($instance['twitter_user_secret']) ? $instance['twitter_user_secret'] : "";
	$twitter_username = isset($instance['twitter_username']) ? $instance['twitter_username'] : "";
	$twitter_count = isset($instance['twitter_count']) ? $instance['twitter_count'] : "";
	$twitter_title = empty($instance['title']) ? __('Twitter', TEMPLATE_DOMAIN) : apply_filters('widget_title', $instance['title']);
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Twitter Title:",TEMPLATE_DOMAIN); ?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $twitter_title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_consumer_key'); ?>">
	<?php echo __('Twitter Consumer Key:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_consumer_key'); ?>" name="<?php echo $this->get_field_name('twitter_consumer_key'); ?>" value="<?php echo $twitter_consumer_key; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_consumer_secret'); ?>">
	<?php echo __('Twitter Consumer Secret:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_consumer_secret'); ?>" name="<?php echo $this->get_field_name('twitter_consumer_secret'); ?>" value="<?php echo $twitter_consumer_secret; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_user_token'); ?>">
	<?php echo __('Twitter User Token:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_user_token'); ?>" name="<?php echo $this->get_field_name('twitter_user_token'); ?>" value="<?php echo $twitter_user_token; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_user_secret'); ?>">
	<?php echo __('Twitter User Secret:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_user_secret'); ?>" name="<?php echo $this->get_field_name('twitter_user_secret'); ?>" value="<?php echo $twitter_user_secret; ?>" />
	</p>


	<p><label for="<?php echo $this->get_field_id('twitter_username'); ?>">
	<?php echo __('Twitter ID:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" value="<?php echo $twitter_username; ?>" />
	</p>
	
	<p>
	<label for="<?php echo $this->get_field_id('twitter_count'); ?>"><?php echo __('Number Of Tweets:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_count'); ?>" name="<?php echo $this->get_field_name('twitter_count'); ?>" value="<?php echo $twitter_count; ?>" />
	</p>

	<?php
	}
}

function WPJobus_register_custom_twitter_widget() {
	register_widget('WPJobus_custom_twitter');
}
/**
*	End Twitter Feed Custom Widgets
**/



/**
* Begin Social Count Custom Widgets
**/

class WPJobus_custom_social_count extends WP_Widget {

  function WPJobus_custom_social_count() {
	$widget_ops = array('classname' => 'WPJobus_custom_social_count', 'description' => 'Display your Twitter & RSS followers' );
	$this->WP_Widget('WPJobus_custom_social_count', 'WPJobus Custom Social Count', $widget_ops);
  }

  function widget($args, $instance) {
	extract($args, EXTR_SKIP);

	echo $before_widget;
	
	$title = $instance['title'];
	$rss_username = $instance['rss_username'];
	$facebook_page = $instance['facebook_username'];
	
	$twitter_consumer_key = isset($instance['twitter_consumer_key']) ? $instance['twitter_consumer_key'] : "";
	$twitter_consumer_secret = isset($instance['twitter_consumer_secret']) ? $instance['twitter_consumer_secret'] : "";
	$twitter_user_token = isset($instance['twitter_user_token']) ? $instance['twitter_user_token'] : "";
	$twitter_user_secret = isset($instance['twitter_user_secret']) ? $instance['twitter_user_secret'] : "";
	$twitter_username = isset($instance['twitter_username']) ? $instance['twitter_username'] : "";
	$twitter_count = isset($instance['twitter_count']) ? $instance['twitter_count'] : "";

	$templateURL = get_template_directory_uri();
	
	if(!empty($title)){
	
	  echo '<h4 class="block-title">'.$title.'</h4>';
	  
	}

	echo '<div class="social-widget">';
	  
	echo '<div class="one_third first twitter-count" style="margin-bottom: 0; margin-top: 20px; margin-bottom: 20px;"><a href="https://twitter.com/'.$twitter_username.'"><img src="'.$templateURL.'/images/twitter.png" alt="twitter" /></a><span class="twitter-count-text">';
	
	echo agurghis_twitter_count ($twitter_username,$twitter_consumer_key,$twitter_consumer_secret,$twitter_user_token,$twitter_user_secret );
  
	echo '</span><span class="twitter-count-title">Followers</span></div>';

	echo '<div class="one_third rss-count" style="margin-bottom: 0; margin-top: 20px; margin-bottom: 20px;"><a href="http://feeds.feedburner.com/'.$rss_username.'"><img src="'.$templateURL.'/images/rss.png" alt="rss" /></a><span class="rss-count-text">RSS</span><span class="rss-count-title">Subscribers</span></div>';
	
	if(WPJobus_get_facebook_count($facebook_page) === false) {
	
	   echo '<div class="one_third rss-count" style="margin-bottom: 0; margin-top: 20px; margin-bottom: 20px;"><a href="http://www.facebook.com/'.$facebook_page.'"><img src="'.$templateURL.'/images/facebook.png" alt="rss" /></a><span class="rss-count-text">Facebook</span><span class="rss-count-title">Fans</span></div>';
	
	} else {
	  
	  echo '<div class="one_third rss-count" style="margin-bottom: 0; margin-top: 20px; margin-bottom: 20px;"><a href="http://www.facebook.com/'.$facebook_page.'"><img src="'.$templateURL.'/images/facebook.png" alt="rss" /></a><span class="rss-count-text">'. WPJobus_get_facebook_count($facebook_page) .'</span><span class="rss-count-title">Fans</span></div>';
	
	}

	echo '</div>';

	echo $after_widget;
  }

  function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['rss_username'] = strip_tags($new_instance['rss_username']);
	$instance['facebook_username'] = strip_tags($new_instance['facebook_username']);
	
	$instance['twitter_consumer_key'] = strip_tags($new_instance['twitter_consumer_key']);
	$instance['twitter_consumer_secret'] = strip_tags($new_instance['twitter_consumer_secret']);
	$instance['twitter_user_token'] = strip_tags($new_instance['twitter_user_token']);
	$instance['twitter_user_secret'] = strip_tags($new_instance['twitter_user_secret']);
	$instance['twitter_username'] = strip_tags($new_instance['twitter_username']);
	$instance['twitter_count'] = strip_tags($new_instance['twitter_count']);

	return $instance;
  }

  function form($instance) {
	$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'twitter_username' => '', 'title' => '', 'rss_username' => '', 'facebook_username' => '') );
	$rss_username = strip_tags($instance['rss_username']);
	$facebook_username = strip_tags($instance['facebook_username']);
	$title = strip_tags($instance['title']);
	
	$twitter_consumer_key = isset($instance['twitter_consumer_key']) ? $instance['twitter_consumer_key'] : "";
	$twitter_consumer_secret = isset($instance['twitter_consumer_secret']) ? $instance['twitter_consumer_secret'] : "";
	$twitter_user_token = isset($instance['twitter_user_token']) ? $instance['twitter_user_token'] : "";
	$twitter_user_secret = isset($instance['twitter_user_secret']) ? $instance['twitter_user_secret'] : "";
	$twitter_username = isset($instance['twitter_username']) ? $instance['twitter_username'] : "";
	$twitter_count = isset($instance['twitter_count']) ? $instance['twitter_count'] : "";

?>    

	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

	<p><label for="<?php echo $this->get_field_id('rss_username'); ?>">RSS Username: <input class="widefat" id="<?php echo $this->get_field_id('rss_username'); ?>" name="<?php echo $this->get_field_name('rss_username'); ?>" type="text" value="<?php echo esc_attr($rss_username); ?>" /></label></p>

	<p><label for="<?php echo $this->get_field_id('facebook_username'); ?>">Facebook Page ID: <input class="widefat" id="<?php echo $this->get_field_id('facebook_username'); ?>" name="<?php echo $this->get_field_name('facebook_username'); ?>" type="text" value="<?php echo esc_attr($facebook_username); ?>" /></label></p>
	
	
	<p><label for="<?php echo $this->get_field_id('twitter_username'); ?>">
	<?php echo __('Twitter ID:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" value="<?php echo $twitter_username; ?>" />
	</p>
	
	<p><label for="<?php echo $this->get_field_id('twitter_consumer_key'); ?>">
	<?php echo __('Twitter Consumer Key:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_consumer_key'); ?>" name="<?php echo $this->get_field_name('twitter_consumer_key'); ?>" value="<?php echo $twitter_consumer_key; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_consumer_secret'); ?>">
	<?php echo __('Twitter Consumer Secret:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_consumer_secret'); ?>" name="<?php echo $this->get_field_name('twitter_consumer_secret'); ?>" value="<?php echo $twitter_consumer_secret; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_user_token'); ?>">
	<?php echo __('Twitter User Token:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_user_token'); ?>" name="<?php echo $this->get_field_name('twitter_user_token'); ?>" value="<?php echo $twitter_user_token; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id('twitter_user_secret'); ?>">
	<?php echo __('Twitter User Secret:', TEMPLATE_DOMAIN)?></label>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_user_secret'); ?>" name="<?php echo $this->get_field_name('twitter_user_secret'); ?>" value="<?php echo $twitter_user_secret; ?>" />
	</p>
	  
	  
<?php
  }
}

function WPJobus_register_custom_social_widget() {
	register_widget('WPJobus_custom_social_count');
}
/**
* End Twitter Feed Custom Widgets
**/

/* Twitter followers count */
function wpcrown_twitter_user( $username, $field, $display = false ) {
  $interval = 3600;
  $cache = get_option('rarst_twitter_user');
  $url = 'http://api.twitter.com/1/users/show.json?screen_name='.urlencode($username);

  if ( false == $cache )
  $cache = array();

  // if first time request add placeholder and force update
  if ( !isset( $cache[$username][$field] ) ) {
  $cache[$username][$field] = NULL;
  $cache[$username]['lastcheck'] = 0;
  }

  // if outdated
  if( $cache[$username]['lastcheck'] < (time()-$interval) ) {

  // holds decoded JSON data in memory
  static $memorycache;

  if ( isset($memorycache[$username]) ) {
  $data = $memorycache[$username];
  }
  else {
  $result = wp_remote_retrieve_body(wp_remote_request($url));
  $data = json_decode( $result );
  if ( is_object($data) )
  $memorycache[$username] = $data;
  }

  if ( is_object($data) ) {
  // update all fields, known to be requested
  foreach ($cache[$username] as $key => $value)
  if( isset($data->$key) )
  $cache[$username][$key] = $data->$key;

  $cache[$username]['lastcheck'] = time();
  }
  else {
  $cache[$username]['lastcheck'] = time()+60;
  }

  update_option( 'rarst_twitter_user', $cache );
  }

  if ( false != $display )
  echo $cache[$username][$field];
  return $cache[$username][$field];
}

//returns num of likes on facebook
function WPJobus_get_facebook_count ($facebook_page) {
	
  $facebook_count = get_transient('facebook_count');

  if (!$facebook_count) {
	if (!empty($facebook_page)) {
	  $facebook_data = wp_remote_get("http://graph.facebook.com/" . $facebook_page);
	  $facebook_data = json_decode($facebook_data['body']);

	  if (isset($facebook_data->likes)) {
		$facebook_count = $facebook_data->likes;
		set_transient('facebook_count', $facebook_count, 60*20);
	  } else {
		$facebook_count = false;
	  }
	} else {
	  $facebook_count = 0;
	  set_transient('facebook_count', $facebook_count, 60*20);
	}
  }

  return $facebook_count;
}


/*--------------------------------------*/
/*          Custom Post Meta           */
/*--------------------------------------*/
// Add the Post Meta Boxes
function WPJobus_add_posts_metaboxes() {
	add_meta_box('WPJobus_featured_post', 'Featured Post', 'WPJobus_featured_post', 'recipe', 'side', 'default');
}

function WPJobus_featured_post_option() {
	global $current_user;
	if($current_user->roles[0] == 'administrator') {
	  // Add custom metas
	  add_action( 'add_meta_boxes', 'WPJobus_add_posts_metaboxes' );
	}
}
add_action('admin_init','WPJobus_featured_post_option');

// Show The Post On Slider Option
function WPJobus_featured_post() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the location data if its already been entered
	$featured_post = get_post_meta($post->ID, 'featured_post', true);
	
	// Echo out the field
	echo '<span class="text overall" style="margin-right: 20px;">Check to have this as featured post:</span>';
	
	$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";
	
	echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';

}



// WPJobus_pagination function
function WPJobus_pagination($pages = '', $range = 2)
{  
	 $showitems = ($range * 2)+1;  

	 global $paged;
	 if(empty($paged)) $paged = 1;

	 if($pages == '')
	 {
		 global $wp_query;
		 $pages = $wp_query->max_num_pages;
		 if(!$pages)
		 {
			 $pages = 1;
		 }
	 }   

	 if(1 != $pages)
	 {
		 echo "<div class='WPJobus_pagination'><span class='WPJobus_pagination_pages'>Page ".$paged." of ".$pages."</span>";
		 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
		 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

		 for ($i=1; $i <= $pages; $i++)
		 {
			 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			 {
				 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
			 }
		 }

		 if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
		 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
		 echo "</div>\n";
	 }
}


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since WPJobus 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function WPJobus_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'WPJobus' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'WPJobus' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function WPJobus_theme_register_required_plugins() {
 
	/**
	 * Array of plugin arrays. Required keys are name, slug and required.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// Facebook Connect
        array(
            'name' => 'Nextend Facebook Connect',
            'slug' => 'nextend-facebook-connect',
            'required' => false,
            'force_activation' => true,
            'force_deactivation' => true
        ),

        // Twitter Connect
        array(
            'name' => 'Nextend Twitter Connect',
            'slug' => 'nextend-twitter-connect',
            'required' => false,
            'force_activation' => true,
            'force_deactivation' => true
        ),

        // Google Connect
        array(
            'name' => 'Nextend Google Connect',
            'slug' => 'nextend-google-connect',
            'required' => false,
            'force_activation' => true,
            'force_deactivation' => true
        ),
	
		// Layer SLider
		array(
			'name' => 'LayerSlider WP',
			'slug' => 'LayerSlider',
			'source' => get_stylesheet_directory() . '/inc/plugins/layersliderwp-5.1.1.installable.zip',
			'required' => false,
			'version' => '5.0.2',
			'force_activation' => true,
			'force_deactivation' => true
		),

		// Forum
		array(
			'name'      => 'bbPress',
			'slug'      => 'bbpress',
			'required'  => false,
			'force_activation' => true,
			'force_deactivation' => true
		),
 
	);
 
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'wpcrown';
 
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
		'default_path'      => '',                           // Default absolute path to pre-packaged plugins
		'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
		'parent_url_slug'   => 'themes.php',         // Default parent URL slug
		'menu'              => 'install-required-plugins',   // Menu slug
		'has_notices'       => true,                         // Show admin notices or not
		'is_automatic'      => false,            // Automatically activate plugins after installation or not
		'message'           => '',               // Message to output right before the plugins table
		'strings'           => array(
			'page_title'                                => __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                                => __( 'Install Plugins', $theme_text_domain ),
			'installing'                                => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                                      => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                                    => __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                          => __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete'                                  => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ) // %1$s = dashboard link
		)
	);
 
	tgmpa( $plugins, $config );
 
}



/**
* Google analytic code
*/
function WPJobus_google_analityc_code() { ?>

	<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php global $redux_demo; $google_id = $redux_demo['google_id']; echo $google_id; ?>']);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
	
<?php }



/**
 * Enqueues scripts and styles for front end.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_scripts_styles() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );


	wp_register_style( 'agurghis-flexslider-css', get_template_directory_uri() . '/css/flexslider.css' );
	wp_enqueue_style( 'agurghis-flexslider-css' );

	// Loads JavaScript file with functionality specific to WPJobus.
	wp_enqueue_script( 'WPJobus-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-07-18', true );

	// Add Open Sans and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'WPJobus-fonts', WPJobus_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'WPJobus-style', get_stylesheet_uri(), array(), '2013-07-18' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'WPJobus-ie', get_template_directory_uri() . '/css/ie.css', array( 'WPJobus-style' ), '2013-11-08' );
	wp_style_add_data( 'WPJobus-ie', 'conditional', 'lt IE 9' );





	// Custom scripts ans styles //

	wp_enqueue_script( 'wpjobus-google-maps-script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'wpjobus-gmap-script', get_template_directory_uri() . '/js/gmap3.min.js', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'wpjobus-infobox', get_template_directory_uri() . '/js/gmap3.infobox.js', array( 'jquery' ),'',true );

	wp_enqueue_script( 'agurghis-flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ),'',true );

	// Load isotope script
	wp_enqueue_script( 'WPJobus-easing-script', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), '2013-07-18', true );

	// Load form script
	wp_enqueue_script( 'WPJobus-form-script', get_template_directory_uri() . '/js/jquery.form.js', array( 'jquery' ), '2013-07-18', true );

	// Load validate script
	wp_enqueue_script( 'WPJobus-validate-script', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), '2013-07-18', true );

	// Load isotope script
	wp_enqueue_script( 'WPJobus-isotope-script', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '2013-07-18', true );

	// Load jQuery UI script
	wp_enqueue_script( 'WPJobus-jquery-ui-script', '//code.jquery.com/ui/1.10.4/jquery-ui.js', array( 'jquery' ), '2013-07-18', true );

	// Load jQuery tools forms script
	wp_enqueue_script( 'WPJobus-jquery-tools-forms-script', get_template_directory_uri() . '/js/jquery.tools.min.js', array( 'jquery' ), '2013-07-18', true );

	// Load jQuery ui script
	wp_enqueue_script( 'WPJobus-jquery-tools-forms-script', get_template_directory_uri() . '/js/jquery-ui.min.js', array( 'jquery' ), '2013-07-18', true );

	// Load jQuery geolocation script

	wp_enqueue_script( 'admin-gmap-script', get_template_directory_uri() . '/js/gmap3.min.js', array( 'jquery' ), '2013-07-18', true );

	if ( is_page_template('template-add-company.php') or is_page_template('template-add-resume.php') or is_page_template('template-add-job.php') ) {

	  wp_enqueue_script( 'admin-geo-google-map', get_template_directory_uri() . '/js/getlocation-map-script.js', array( 'jquery' ), '2013-07-18', true );

	  wp_enqueue_script( 'admin-jquery-ui-script', '//code.jquery.com/ui/1.10.4/jquery-ui.js', array( 'jquery' ), '2013-07-18', true );

	}



	if( is_single() ) {
		// Load flexslider
		wp_enqueue_script( 'WPJobus-flexslider-script', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '2013-07-18', true );
	}

	// Load stick top script
	wp_enqueue_script( 'WPJobus-sticktop-script', get_template_directory_uri() . '/js/stickTop.js', array( 'jquery' ), '2013-07-18', true );

	// Load menu script
	wp_enqueue_script( 'WPJobus-custom-menu', get_template_directory_uri() . '/js/menu.js', array( 'jquery' ), '2013-07-18', true );

	 // Load like script
	wp_enqueue_script( 'WPJobus-like-script', get_template_directory_uri() . '/inc/like/i-like-this.js', array( 'jquery' ), '2013-07-18', true );


	// Load inview script
	wp_enqueue_script( 'WPJobus-inview-script', get_template_directory_uri() . '/js/jquery.inview.js', array( 'jquery' ), '2013-07-18', true );

	// Load lightbox script
	wp_enqueue_script( 'WPJobus-lightbox-script', get_template_directory_uri() . '/js/lightbox.min.js', array( 'jquery' ), '2013-07-18', true );

	// Load custom script
	wp_enqueue_script( 'WPJobus-custom-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '2013-07-18', true );

	// Load Stripe script
	wp_enqueue_script( 'WPJobus-stripe-script', 'https://checkout.stripe.com/checkout.js', array( 'jquery' ), '2013-07-18', true );


	wp_enqueue_script( 'WPJobus-imag-gallery-carousel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), '2013-07-18', true );

	
	wp_enqueue_script( 'WPJobus-classie', get_template_directory_uri() . '/js/classie.js', array( 'jquery' ), '2013-07-18', true );
	wp_enqueue_script( 'WPJobus-anime-by-scroll', get_template_directory_uri() . '/js/AnimOnScroll.js', array( 'jquery' ), '2013-07-18', true );

	// Load owl script
	wp_enqueue_script( 'WPJobus-owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '2013-07-18', true );



	// Load main style
	wp_enqueue_style( 'WPJobus-owl-style', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1' );

	// Load main style
	wp_enqueue_style( 'WPJobus-owl-theme-style', get_template_directory_uri() . '/css/owl.theme.css', array(), '1' );

	// Load main style
	wp_enqueue_style( 'WPJobus-owl-transitions-style', get_template_directory_uri() . '/css/owl.transitions.css', array(), '1' );

	// Load main style
	wp_enqueue_style( 'WPJobus-lightbox-style', get_template_directory_uri() . '/css/lightbox.css', array(), '1' );


	global $redux_demo;
	if (isset($redux_demo['opt-select-colors'])) {
		$wpcrown_opt_color_schemes = $redux_demo['opt-select-colors'];

	  if($wpcrown_opt_color_schemes == 1) {
		// Load main style
		wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css', array(), '1' );
	  } elseif($wpcrown_opt_color_schemes == 2) {
		// Load main style
		wp_enqueue_style( 'main-style-yellow', get_template_directory_uri() . '/css/main-yellow.css', array(), '1' );
	  } elseif($wpcrown_opt_color_schemes == 3) {
		// Load main style
		wp_enqueue_style( 'main-style-red', get_template_directory_uri() . '/css/main-red.css', array(), '1' );
	  } elseif($wpcrown_opt_color_schemes == 4) {
		// Load main style
		wp_enqueue_style( 'main-style-green', get_template_directory_uri() . '/css/main-green.css', array(), '1' );
	  } elseif($wpcrown_opt_color_schemes == 5) {
		// Load main style
		wp_enqueue_style( 'main-style-blue', get_template_directory_uri() . '/css/main-blue.css', array(), '1' );
	  } elseif($wpcrown_opt_color_schemes == 6) {
		// Load main style
		wp_enqueue_style( 'main-style-light-blue', get_template_directory_uri() . '/css/main-light-blue.css', array(), '1' );
	  } 

	} else {

	  // Load main style
	  wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css', array(), '1' );

	}

	// Load main style
	wp_enqueue_style( 'responsive-style', get_template_directory_uri() . '/css/responsive.css', array(), '1' );

	// Load boostratp style
	wp_enqueue_style( 'awesomefont-style', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array(), '4.0.3' );

	// Load flexslider style
	wp_enqueue_style( 'flexslider-style', get_template_directory_uri() . '/css/flexslider.css', array(), '1' );

	// Load print recipe style
	wp_enqueue_style( 'print-style', get_template_directory_uri() . '/css/print.css', array(), '1', 'print' );


	 if(is_admin_bar_showing()) echo "<style type=\"text/css\">.navbar-fixed-top { margin-top: 28px; } </style>";

}

function WPJobus_admin_enqueue() {

	wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/inc/admin/admin_script.js', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'admin-google-maps-script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'admin-gmap-script', get_template_directory_uri() . '/js/gmap3.min.js', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'admin-geo-google-map', get_template_directory_uri() . '/js/getlocation-map-script.js', array( 'jquery' ), '2013-07-18', true );

	wp_enqueue_script( 'admin-jquery-ui-script', '//code.jquery.com/ui/1.10.4/jquery-ui.js', array( 'jquery' ), '2013-07-18', true );

}

add_action( 'admin_enqueue_scripts', 'WPJobus_admin_enqueue' );

function WPJobus_main_font() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'mytheme-montserat', "$protocol://fonts.googleapis.com/css?family=Montserrat:400,70" );
}

function WPJobus_second_font() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'mytheme-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic" );
}

function WPJobus_third_font() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'mytheme-ptserifa', "$protocol://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic,700italic" );
}


function WPJobus_add_media_upload_scripts() {
	if ( is_admin() ) {
		 return;
	   }
	wp_enqueue_media();
}
add_action('wp_enqueue_scripts', 'WPJobus_add_media_upload_scripts');


wp_enqueue_script('jquery');

function wpjobContactForm() {

  if ( isset( $_POST['scf_nonce'] ) && wp_verify_nonce( $_POST['scf_nonce'], 'scf_html' ) ) {

	$name = sanitize_text_field($_POST['contactName']);
	$email = sanitize_email($_POST['email']);
	$receiverEmail = sanitize_email($_POST['receiverEmail']);
	$message = wp_kses_data($_POST['message']);

	$blog_title = get_bloginfo('name');

	$emailTo = $receiverEmail;
	$subject = "Message from ".$blog_title; 
	$body = "Name: $name \n\nEmail: $email \n\nMessage: $message";
	$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
	  
	wp_mail($emailTo, $subject, $body, $headers);

  } else {

  }

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobContactForm', 'wpjobContactForm' );
add_action( 'wp_ajax_nopriv_wpjobContactForm', 'wpjobContactForm' );



function wpjobusRegisterForm() {

  if ( isset( $_POST['wpjobusRegister_nonce'] ) && wp_verify_nonce( $_POST['wpjobusRegister_nonce'], 'wpjobusRegister_html' ) ) {

	$username = sanitize_text_field($_POST['userName']);
	$email = sanitize_email($_POST['userEmail']);
	$password = $_POST['userPassword'];

	$registerSuccess = 1;
	$registerName = 1;
	$registerEmail = 1;

	if (username_exists($username)) {

	  $registerSuccess = 0;
	  $registerName = 0;

	} 

	if( email_exists( $email )) {

	  $registerSuccess = 0;
	  $registerEmail = 0;

	} 

	if($registerName == 0 AND $registerEmail == 0) {
	  $registerUserSuccess = 3;
	} elseif($registerEmail == 0) {
	  $registerUserSuccess = 2;
	} elseif($registerName == 0) {
	  $registerUserSuccess = 1;
	}

	if($registerSuccess == 1) {

	  wp_create_user( $username, $password, $email );

	  $from = get_option('admin_email');
	  $headers = 'From: '.$from . "\r\n";
	  $subject = "Registration successful";
	  $msg = "Registration successful.\nYour login details\nUsername: $username\nPassword: $password";
	  wp_mail( $email, $subject, $msg, $headers );

	  $login_data = array();
	  $login_data['user_login'] = $username;
	  $login_data['user_password'] = $password;
	  wp_signon( $login_data, false );

	  $registerUserSuccess = 4;

	}

  } else {

	$registerUserSuccess = 5;

  }

  echo $registerUserSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusRegisterForm', 'wpjobusRegisterForm' );
add_action( 'wp_ajax_nopriv_wpjobusRegisterForm', 'wpjobusRegisterForm' );


function wpjobusLoginForm() {

  if ( isset( $_POST['wpjobusLogin_nonce'] ) && wp_verify_nonce( $_POST['wpjobusLogin_nonce'], 'wpjobusLogin_html' ) ) {

	$username = sanitize_text_field($_POST['userName']);
	$password = $_POST['userPassword'];

	$registerSuccess = 1;
	$registerName = 1;
	$registerEmail = 1;

	if ( username_exists( $username ) ) {

	  	$registerSuccess = 1;
	  	$registerName = 1;

	} else {

		$registerSuccess = 0;
	  	$registerName = 0;

	}

	$user = get_user_by( 'login', $username );

	if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID) ) {

	   	$registerSuccess = 1;
	  	$registerPassword = 1;

	} else {

		$registerSuccess = 0;
	  	$registerPassword = 0;

	}

	if($registerName == 0) {

	  	$registerUserSuccess = 1;

	} elseif($registerPassword == 0) {

	  	$registerUserSuccess = 2;

	} elseif($registerName == 0 AND $registerPassword == 0) {

	  	$registerUserSuccess = 3;

	} 

	if($registerSuccess == 1) {

	  $login_data = array();
	  $login_data['user_login'] = $username;
	  $login_data['user_password'] = $password;
	  $login_data['remember'] = $remember;
	  wp_signon( $login_data, false );

	  $registerUserSuccess = 4;

	}

  } else {

	$registerUserSuccess = 5;

  }

  echo $registerUserSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusLoginForm', 'wpjobusLoginForm' );
add_action( 'wp_ajax_nopriv_wpjobusLoginForm', 'wpjobusLoginForm' );


function wpjobusUpdateAccountForm() {

  if ( isset( $_POST['wpjobusUpdateAccount_nonce'] ) && wp_verify_nonce( $_POST['wpjobusUpdateAccount_nonce'], 'wpjobusUpdateAccount_html' ) ) {

	$email = sanitize_email($_POST['userEmail']);
	$password = $_POST['userPassword'];
	$user_ID = $_POST['userID'];

	$registerEmail = 0;
	$registerPass = 0;

	if (!empty($email)) {

		if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 

			wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;

			$registerEmail = 1;

		} else {

			$registerEmail = 0;

		}

	} 

	if (!empty($password)) {

		$update = wp_set_password( $password, $user_ID ); 

		$registerPass = 1;

	}

	if($registerPass == 1 AND $registerEmail = 0) {

		$registerUserSuccess = 1;

	}

	if($registerPass == 0 AND $registerEmail = 1) {

		$registerUserSuccess = 2;

	}

	if($registerPass == 1 AND $registerEmail = 1) {

		$registerUserSuccess = 3;

	}


  } else {

	$registerUserSuccess = 5;

  }

  echo $registerUserSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusUpdateAccountForm', 'wpjobusUpdateAccountForm' );
add_action( 'wp_ajax_nopriv_wpjobusUpdateAccountForm', 'wpjobusUpdateAccountForm' );


function wpjobusResetForm() {

  if ( isset( $_POST['wpjobusReset_nonce'] ) && wp_verify_nonce( $_POST['wpjobusReset_nonce'], 'wpjobusReset_html' ) ) {

	$email = sanitize_email($_POST['userEmail']);
	
	$user = get_user_by( 'email', $email );
	$user_ID = $user->ID;

	if( !empty($user_ID)) {

		$new_password = wp_generate_password( 12, false ); 

		if ( isset($new_password) ) {

			wp_set_password( $new_password, $user_ID );

			$from = get_option('admin_email');
			$headers = 'From: '.$from . "\r\n";
			$subject = "Password reset!";
			$msg = "Reset password.\nYour login details\nNew Password: $new_password";
			wp_mail( $email, $subject, $msg, $headers );

			$resetSuccess = 1;

		}

	} else {

		$resetSuccess = 2;

		$message = "There is no user available for this email.";

	} // end if/else


  } else {

	$resetSuccess = 3;

  }

  echo $resetSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusResetForm', 'wpjobusResetForm' );
add_action( 'wp_ajax_nopriv_wpjobusResetForm', 'wpjobusResetForm' );


function wpjobusAdminFeaturedCompanyForm() {

  	if ( isset( $_POST['wpjobusAdminFeaturedCompanyForm_nonce'] ) && wp_verify_nonce( $_POST['wpjobusAdminFeaturedCompanyForm_nonce'], 'wpjobusAdminFeaturedCompanyForm_html' ) ) {

  		$featPostId = $_POST['featPostId'];
  		$featPostStatus = $_POST['post-status'];
  		$featPostType = $_POST['post-type'];
  		$featPostValid = $_POST['exp-time'];
  		$str = preg_replace('/\D/', '', $featPostValid);
  		$currentDate = current_time('timestamp');
  		$timestamp = strtotime('+'.$str.' days', $currentDate);

  		update_post_meta($featPostId, 'wpjobus_featured_post_status', $featPostType);

  		if($featPostType == "featured") {

		  	update_post_meta($featPostId, 'wpjobus_featured_activation_date', $currentDate);
		  	update_post_meta($featPostId, 'wpjobus_featured_expiration_date', $timestamp);
		  	update_post_meta($featPostId, 'wpjobus_featured_active_time', $str);

		} else {

			update_post_meta($featPostId, 'wpjobus_featured_activation_date', '');
		  	update_post_meta($featPostId, 'wpjobus_featured_expiration_date', '');
		  	update_post_meta($featPostId, 'wpjobus_featured_active_time', '');

		}

  		$my_post = array(
  			'ID' => $featPostId,
  			'post_status' => $featPostStatus
  		);

  		wp_update_post( $my_post );

  		global $redux_demo; 
		$contact_email = $redux_demo['contact-email'];
  		$email = $contact_email;
  		$blog_title = get_bloginfo('name');

  		$post_type_id = get_post_type($featPostId);

  		if($post_type_id == "job") {
  			$post_title = get_post_meta($featPostId, 'wpjobus_job_fullname',true);
  		} elseif($post_type_id == "company") {
  			$post_title = get_post_meta($featPostId, 'wpjobus_company_fullname',true);
  		} elseif($post_type_id == "resume") {
  			$post_title = get_post_meta($featPostId, 'wpjobus_resume_fullname',true);
  		}

  		if($featPostType == "featured") {

  			$message = "Hello,\n\nThe status of your ".$post_type_id." (".$post_title.") has beed changed to: '".$featPostStatus."' and type to: '".$featPostType."'. It will expire in ".$featPostValid." days.";

  		} else {

  			$message = "Hello,\n\nThe status of your ".$post_type_id." (".$post_title.") has beed changed to: '".$featPostStatus."' and type to: '".$featPostType."'.";

  		}

  		

		$emailTo = get_post_meta($featPostId, 'wpjobus_'.$post_type_id.'_email',true);
		$subject = "Message from ".$blog_title; 
		$body = $message;
		$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			  
		wp_mail($emailTo, $subject, $body, $headers);

  	} else {

		$SubmitResumeSuccess = 0;

  	}

  	echo $SubmitResumeSuccess;

  	die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusAdminFeaturedCompanyForm', 'wpjobusAdminFeaturedCompanyForm' );
add_action( 'wp_ajax_nopriv_wpjobusAdminFeaturedCompanyForm', 'wpjobusAdminFeaturedCompanyForm' );


function wpjobusSaveSubscriptionsForm() {

  if ( isset( $_POST['wpjobusSaveSubscriptions_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSaveSubscriptions_nonce'], 'wpjobusSaveSubscriptions_html' ) ) {

	$job_locations = $_POST['job-locations'];
	$job_categories = $_POST['job-categories'];

	$resume_locations = $_POST['resume-locations'];
	$resume_categories = $_POST['resume-categories'];

	$company_locations = $_POST['company-locations'];
	$company_categories = $_POST['company-categories'];

	$user_id = $_POST['user_id'];

	update_user_meta($user_id, 'user_job_locations_subcriptions', $job_locations);
	update_user_meta($user_id, 'user_job_categories_subcriptions', $job_categories);

	update_user_meta($user_id, 'user_resume_locations_subcriptions', $resume_locations);
	update_user_meta($user_id, 'user_resume_categories_subcriptions', $resume_categories);

	update_user_meta($user_id, 'user_company_locations_subcriptions', $company_locations);
	update_user_meta($user_id, 'user_company_categories_subcriptions', $company_categories);

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSaveSubscriptionsForm', 'wpjobusSaveSubscriptionsForm' );
add_action( 'wp_ajax_nopriv_wpjobusSaveSubscriptionsForm', 'wpjobusSaveSubscriptionsForm' );


function wpjobusSubmitResumeForm() {

  if ( isset( $_POST['wpjobusSubmitResume_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitResume_nonce'], 'wpjobusSubmitResume_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	if (current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'resume',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

	  	$post_id = wp_insert_post($post_information);

		$my_post = array(
			'ID' => $post_id,
			'post_title' => $_POST['fullName'],
			'post_name' => $post_id
		);

		wp_update_post( $my_post );

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		  	

		}

		update_post_meta($post_id, 'wpjobus_featured_post_status', 'regular');

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'resume',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'draft'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $post_id,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

				global $redux_demo; 
			  	$comp_reg_price = $redux_demo['resume-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($post_id, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'publish'
				  	);

				  	

				} else {

					$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'resume',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

	  	}

	}

	update_post_meta($post_id, 'wpjobus_resume_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'resume_gender', wp_kses($_POST['resume_gender'], $allowed));
	update_post_meta($post_id, 'resume_month_birth', wp_kses($_POST['resume_month_birth'], $allowed));
	update_post_meta($post_id, 'resume_day_birth', wp_kses($_POST['resume_day_birth'], $allowed));
	update_post_meta($post_id, 'resume_year_birth', wp_kses($_POST['resume_year_birth'], $allowed));
	update_post_meta($post_id, 'resume_years_of_exp', wp_kses($_POST['resume_years_of_exp'], $allowed));
	update_post_meta($post_id, 'resume_industry', wp_kses($_POST['resume_industry'], $allowed));
	update_post_meta($post_id, 'resume_location', wp_kses($_POST['resume_location'], $allowed));
	update_post_meta($post_id, 'resume-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'wpjobus_resume_profile_picture', wp_kses($_POST['wpjobus_resume_profile_picture'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_cover_image', wp_kses($_POST['wpjobus_resume_cover_image'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_prof_title', wp_kses($_POST['wpjobus_resume_prof_title'], $allowed));
	update_post_meta($post_id, 'resume_career_level', wp_kses($_POST['resume_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_comm_level', wp_kses($_POST['wpjobus_resume_comm_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_comm_note', $_POST['skillsNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_org_level', wp_kses($_POST['wpjobus_resume_org_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_org_note', $_POST['orgNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_job_rel_level', wp_kses($_POST['wpjobus_resume_job_rel_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_job_rel_note', $_POST['jobNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_skills', $_POST['wpjobus_resume_skills']);

	update_post_meta($post_id, 'wpjobus_resume_native_language', wp_kses($_POST['wpjobus_resume_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_languages', $_POST['wpjobus_resume_languages']);

	update_post_meta($post_id, 'wpjobus_resume_hobbies', wp_kses($_POST['wpjobus_resume_hobbies'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_education', $_POST['wpjobus_resume_education']);

	update_post_meta($post_id, 'wpjobus_resume_award', $_POST['wpjobus_resume_award']);

	update_post_meta($post_id, 'wpjobus_resume_testimonials', $_POST['wpjobus_resume_testimonials']);

	update_post_meta($post_id, 'wpjobus_resume_remuneration', $_POST['wpjobus_resume_remuneration']);
	update_post_meta($post_id, 'wpjobus_resume_remuneration_per', $_POST['wpjobus_resume_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_resume_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_resume_remuneration_raw', $str);

	update_post_meta($post_id, 'wpjobus_resume_job_type', $_POST['wpjobus_resume_job_type']);

	update_post_meta($post_id, 'wpjobus_resume_portfolio', $_POST['wpjobus_resume_portfolio']);

	update_post_meta($post_id, 'wpjobus_resume_address', $_POST['wpjobus_resume_address']);
	update_post_meta($post_id, 'wpjobus_resume_phone', $_POST['wpjobus_resume_phone']);
	update_post_meta($post_id, 'wpjobus_resume_website', $_POST['wpjobus_resume_website']);
	update_post_meta($post_id, 'wpjobus_resume_email', $_POST['wpjobus_resume_email']);
	update_post_meta($post_id, 'wpjobus_resume_publish_email', $_POST['wpjobus_resume_publish_email']);
	update_post_meta($post_id, 'wpjobus_resume_facebook', $_POST['wpjobus_resume_facebook']);
	update_post_meta($post_id, 'wpjobus_resume_linkedin', $_POST['wpjobus_resume_linkedin']);
	update_post_meta($post_id, 'wpjobus_resume_twitter', $_POST['wpjobus_resume_twitter']);
	update_post_meta($post_id, 'wpjobus_resume_googleplus', $_POST['wpjobus_resume_googleplus']);
	update_post_meta($post_id, 'wpjobus_resume_googleaddress', $_POST['wpjobus_resume_googleaddress']);
	update_post_meta($post_id, 'wpjobus_resume_longitude', $_POST['wpjobus_resume_longitude']);
	update_post_meta($post_id, 'wpjobus_resume_latitude', $_POST['wpjobus_resume_latitude']);

	update_post_meta($post_id, 'wpjobus_resume_file', $_POST['wpjobus_resume_file']);
	update_post_meta($post_id, 'wpjobus_resume_file_name', $_POST['wpjobus_resume_file_name']);

	if ( get_post_status ( $post_id ) == 'publish' ) {
		wpjobusSendNotifications($post_id);
	}

	$SubmitResumeSuccess = home_url()."/resume/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitResumeForm', 'wpjobusSubmitResumeForm' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitResumeForm', 'wpjobusSubmitResumeForm' );



function wpjobusEditResumeForm() {

  if ( isset( $_POST['wpjobusEditResume_nonce'] ) && wp_verify_nonce( $_POST['wpjobusEditResume_nonce'], 'wpjobusEditResume_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	$current_post = $_POST['postID'];

	if (current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'resume',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		}

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'resume',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'draft'
		  	);

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $current_post,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

				global $redux_demo; 
			  	$comp_reg_price = $redux_demo['resume-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($current_post, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'publish'
				  	);

				} else {

					$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'resume',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

	  	}

	}

	$my_post = array(
		'ID' => $current_post,
		'post_title' => $_POST['fullName']
	);

	wp_update_post( $my_post );

	$post_id = $current_post;

	update_post_meta($post_id, 'wpjobus_resume_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'resume_gender', wp_kses($_POST['resume_gender'], $allowed));
	update_post_meta($post_id, 'resume_month_birth', wp_kses($_POST['resume_month_birth'], $allowed));
	update_post_meta($post_id, 'resume_day_birth', wp_kses($_POST['resume_day_birth'], $allowed));
	update_post_meta($post_id, 'resume_year_birth', wp_kses($_POST['resume_year_birth'], $allowed));
	update_post_meta($post_id, 'resume_years_of_exp', wp_kses($_POST['resume_years_of_exp'], $allowed));
	update_post_meta($post_id, 'resume_industry', wp_kses($_POST['resume_industry'], $allowed));
	update_post_meta($post_id, 'resume_location', wp_kses($_POST['resume_location'], $allowed));
	update_post_meta($post_id, 'resume-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'wpjobus_resume_profile_picture', wp_kses($_POST['wpjobus_resume_profile_picture'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_cover_image', wp_kses($_POST['wpjobus_resume_cover_image'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_prof_title', wp_kses($_POST['wpjobus_resume_prof_title'], $allowed));
	update_post_meta($post_id, 'resume_career_level', wp_kses($_POST['resume_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_comm_level', wp_kses($_POST['wpjobus_resume_comm_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_comm_note', $_POST['skillsNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_org_level', wp_kses($_POST['wpjobus_resume_org_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_org_note', $_POST['orgNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_job_rel_level', wp_kses($_POST['wpjobus_resume_job_rel_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_resume_job_rel_note', $_POST['jobNotes'], $allowed);

	update_post_meta($post_id, 'wpjobus_resume_skills', $_POST['wpjobus_resume_skills']);

	update_post_meta($post_id, 'wpjobus_resume_native_language', wp_kses($_POST['wpjobus_resume_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_languages', $_POST['wpjobus_resume_languages']);

	update_post_meta($post_id, 'wpjobus_resume_hobbies', wp_kses($_POST['wpjobus_resume_hobbies'], $allowed));

	update_post_meta($post_id, 'wpjobus_resume_education', $_POST['wpjobus_resume_education']);

	update_post_meta($post_id, 'wpjobus_resume_award', $_POST['wpjobus_resume_award']);

	update_post_meta($post_id, 'wpjobus_resume_testimonials', $_POST['wpjobus_resume_testimonials']);

	update_post_meta($post_id, 'wpjobus_resume_remuneration', $_POST['wpjobus_resume_remuneration']);
	update_post_meta($post_id, 'wpjobus_resume_remuneration_per', $_POST['wpjobus_resume_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_resume_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_resume_remuneration_raw', $str);

	update_post_meta($post_id, 'wpjobus_resume_job_type', $_POST['wpjobus_resume_job_type']);

	update_post_meta($post_id, 'wpjobus_resume_portfolio', $_POST['wpjobus_resume_portfolio']);

	update_post_meta($post_id, 'wpjobus_resume_address', $_POST['wpjobus_resume_address']);
	update_post_meta($post_id, 'wpjobus_resume_phone', $_POST['wpjobus_resume_phone']);
	update_post_meta($post_id, 'wpjobus_resume_website', $_POST['wpjobus_resume_website']);
	update_post_meta($post_id, 'wpjobus_resume_email', $_POST['wpjobus_resume_email']);
	update_post_meta($post_id, 'wpjobus_resume_publish_email', $_POST['wpjobus_resume_publish_email']);
	update_post_meta($post_id, 'wpjobus_resume_facebook', $_POST['wpjobus_resume_facebook']);
	update_post_meta($post_id, 'wpjobus_resume_linkedin', $_POST['wpjobus_resume_linkedin']);
	update_post_meta($post_id, 'wpjobus_resume_twitter', $_POST['wpjobus_resume_twitter']);
	update_post_meta($post_id, 'wpjobus_resume_googleplus', $_POST['wpjobus_resume_googleplus']);
	update_post_meta($post_id, 'wpjobus_resume_googleaddress', $_POST['wpjobus_resume_googleaddress']);
	update_post_meta($post_id, 'wpjobus_resume_longitude', $_POST['wpjobus_resume_longitude']);
	update_post_meta($post_id, 'wpjobus_resume_latitude', $_POST['wpjobus_resume_latitude']);

	update_post_meta($post_id, 'wpjobus_resume_file', $_POST['wpjobus_resume_file']);
	update_post_meta($post_id, 'wpjobus_resume_file_name', $_POST['wpjobus_resume_file_name']);

	$SubmitResumeSuccess = home_url()."/resume/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusEditResumeForm', 'wpjobusEditResumeForm' );
add_action( 'wp_ajax_nopriv_wpjobusEditResumeForm', 'wpjobusEditResumeForm' );



function wpjobusSubmitCompanyForm() {

  if ( isset( $_POST['wpjobusSubmitCompany_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitCompany_nonce'], 'wpjobusSubmitCompany_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	if(current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'company',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

	  	$post_id = wp_insert_post($post_information);

		$my_post = array(
			'ID' => $post_id,
			'post_title' => $_POST['fullName'],
			'post_name' => $post_id
		);

		wp_update_post( $my_post );

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		  	

		}

		update_post_meta($post_id, 'wpjobus_featured_post_status', 'regular');

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'company',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'draft'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $post_id,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

				global $redux_demo; 
			  	$comp_reg_price = $redux_demo['company-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($post_id, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'publish'
				  	);

				  	

				} else {

					$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'company',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

	  	}

	}

	update_post_meta($post_id, 'wpjobus_company_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_tagline', wp_kses($_POST['wpjobus_company_tagline'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_foundyear', wp_kses($_POST['wpjobus_company_foundyear'], $allowed));
	update_post_meta($post_id, 'company_team_size', wp_kses($_POST['company_team_size'], $allowed));
	update_post_meta($post_id, 'resume_day_birth', wp_kses($_POST['resume_day_birth'], $allowed));
	update_post_meta($post_id, 'resume_year_birth', wp_kses($_POST['resume_year_birth'], $allowed));
	update_post_meta($post_id, 'resume_years_of_exp', wp_kses($_POST['resume_years_of_exp'], $allowed));
	update_post_meta($post_id, 'company_industry', wp_kses($_POST['company_industry'], $allowed));
	update_post_meta($post_id, 'company_location', wp_kses($_POST['company_location'], $allowed));
	update_post_meta($post_id, 'company-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'wpjobus_company_profile_picture', wp_kses($_POST['wpjobus_company_profile_picture'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_cover_image', wp_kses($_POST['wpjobus_company_cover_image'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_prof_title', wp_kses($_POST['wpjobus_company_prof_title'], $allowed));
	update_post_meta($post_id, 'resume_career_level', wp_kses($_POST['resume_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_services', $_POST['wpjobus_company_services']);

	update_post_meta($post_id, 'wpjobus_company_native_language', wp_kses($_POST['wpjobus_company_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_languages', $_POST['wpjobus_company_languages']);

	update_post_meta($post_id, 'wpjobus_company_expertise', wp_kses($_POST['wpjobus_company_expertise'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_award', $_POST['wpjobus_company_award']);

	update_post_meta($post_id, 'wpjobus_company_clients', $_POST['wpjobus_company_clients']);

	update_post_meta($post_id, 'wpjobus_company_testimonials', $_POST['wpjobus_company_testimonials']);

	update_post_meta($post_id, 'wpjobus_company_file', $_POST['wpjobus_company_file']);
	update_post_meta($post_id, 'wpjobus_company_file_name', $_POST['wpjobus_company_file_name']);

	update_post_meta($post_id, 'wpjobus_company_remuneration', $_POST['wpjobus_company_remuneration']);
	update_post_meta($post_id, 'wpjobus_company_remuneration_per', $_POST['wpjobus_company_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_job_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_company_remuneration_raw', $str);
	
	update_post_meta($post_id, 'wpjobus_company_job_freelance', $_POST['wpjobus_company_job_freelance']);
	update_post_meta($post_id, 'wpjobus_company_job_part_time', $_POST['wpjobus_company_job_part_time']);
	update_post_meta($post_id, 'wpjobus_company_job_full_time', $_POST['wpjobus_company_job_full_time']);
	update_post_meta($post_id, 'wpjobus_company_job_internship', $_POST['wpjobus_company_job_internship']);
	update_post_meta($post_id, 'wpjobus_company_job_volunteer', $_POST['wpjobus_company_job_volunteer']);

	update_post_meta($post_id, 'wpjobus_company_portfolio', $_POST['wpjobus_company_portfolio']);

	update_post_meta($post_id, 'wpjobus_company_address', $_POST['wpjobus_company_address']);
	update_post_meta($post_id, 'wpjobus_company_phone', $_POST['wpjobus_company_phone']);
	update_post_meta($post_id, 'wpjobus_company_website', $_POST['wpjobus_company_website']);
	update_post_meta($post_id, 'wpjobus_company_email', $_POST['wpjobus_company_email']);
	update_post_meta($post_id, 'wpjobus_company_publish_email', $_POST['wpjobus_company_publish_email']);
	update_post_meta($post_id, 'wpjobus_company_facebook', $_POST['wpjobus_company_facebook']);
	update_post_meta($post_id, 'wpjobus_company_linkedin', $_POST['wpjobus_company_linkedin']);
	update_post_meta($post_id, 'wpjobus_company_twitter', $_POST['wpjobus_company_twitter']);
	update_post_meta($post_id, 'wpjobus_company_googleplus', $_POST['wpjobus_company_googleplus']);
	update_post_meta($post_id, 'wpjobus_company_googleaddress', $_POST['wpjobus_company_googleaddress']);
	update_post_meta($post_id, 'wpjobus_company_longitude', $_POST['wpjobus_company_longitude']);
	update_post_meta($post_id, 'wpjobus_company_latitude', $_POST['wpjobus_company_latitude']);

	if ( get_post_status ( $post_id ) == 'publish' ) {
		wpjobusSendNotifications($post_id);
	}

	$SubmitResumeSuccess = home_url()."/company/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitCompanyForm', 'wpjobusSubmitCompanyForm' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitCompanyForm', 'wpjobusSubmitCompanyForm' );



function wpjobusEditCompanyForm() {

  if ( isset( $_POST['wpjobusEditCompany_nonce'] ) && wp_verify_nonce( $_POST['wpjobusEditCompany_nonce'], 'wpjobusEditCompany_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	$current_post = $_POST['postID'];

	if (current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'company',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		}

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'company',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'publish'
		  	);

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $current_post,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

			  	global $redux_demo; 
			  	$comp_reg_price = $redux_demo['company-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($current_post, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'publish'
				  	);

				} else {

					$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'company',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

	  	}

	}

	$my_post = array(
		'ID' => $current_post,
		'post_title' => $_POST['fullName']
	);

	wp_update_post( $my_post );

	$post_id = $current_post;

	update_post_meta($post_id, 'wpjobus_company_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_tagline', wp_kses($_POST['wpjobus_company_tagline'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_foundyear', wp_kses($_POST['wpjobus_company_foundyear'], $allowed));
	update_post_meta($post_id, 'company_team_size', wp_kses($_POST['company_team_size'], $allowed));
	update_post_meta($post_id, 'resume_day_birth', wp_kses($_POST['resume_day_birth'], $allowed));
	update_post_meta($post_id, 'resume_year_birth', wp_kses($_POST['resume_year_birth'], $allowed));
	update_post_meta($post_id, 'resume_years_of_exp', wp_kses($_POST['resume_years_of_exp'], $allowed));
	update_post_meta($post_id, 'company_industry', wp_kses($_POST['company_industry'], $allowed));
	update_post_meta($post_id, 'company_location', wp_kses($_POST['company_location'], $allowed));
	update_post_meta($post_id, 'company-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'wpjobus_company_profile_picture', wp_kses($_POST['wpjobus_company_profile_picture'], $allowed));
	update_post_meta($post_id, 'wpjobus_company_cover_image', wp_kses($_POST['wpjobus_company_cover_image'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_prof_title', wp_kses($_POST['wpjobus_company_prof_title'], $allowed));
	update_post_meta($post_id, 'resume_career_level', wp_kses($_POST['resume_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_services', $_POST['wpjobus_company_services']);

	update_post_meta($post_id, 'wpjobus_company_native_language', wp_kses($_POST['wpjobus_company_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_languages', $_POST['wpjobus_company_languages']);

	update_post_meta($post_id, 'wpjobus_company_expertise', wp_kses($_POST['wpjobus_company_expertise'], $allowed));

	update_post_meta($post_id, 'wpjobus_company_award', $_POST['wpjobus_company_award']);

	update_post_meta($post_id, 'wpjobus_company_clients', $_POST['wpjobus_company_clients']);

	update_post_meta($post_id, 'wpjobus_company_testimonials', $_POST['wpjobus_company_testimonials']);

	update_post_meta($post_id, 'wpjobus_company_file', $_POST['wpjobus_company_file']);
	update_post_meta($post_id, 'wpjobus_company_file_name', $_POST['wpjobus_company_file_name']);

	update_post_meta($post_id, 'wpjobus_company_remuneration', $_POST['wpjobus_company_remuneration']);
	update_post_meta($post_id, 'wpjobus_company_remuneration_per', $_POST['wpjobus_company_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_job_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_company_remuneration_raw', $str);
	
	update_post_meta($post_id, 'wpjobus_company_job_freelance', $_POST['wpjobus_company_job_freelance']);
	update_post_meta($post_id, 'wpjobus_company_job_part_time', $_POST['wpjobus_company_job_part_time']);
	update_post_meta($post_id, 'wpjobus_company_job_full_time', $_POST['wpjobus_company_job_full_time']);
	update_post_meta($post_id, 'wpjobus_company_job_internship', $_POST['wpjobus_company_job_internship']);
	update_post_meta($post_id, 'wpjobus_company_job_volunteer', $_POST['wpjobus_company_job_volunteer']);

	update_post_meta($post_id, 'wpjobus_company_portfolio', $_POST['wpjobus_company_portfolio']);

	update_post_meta($post_id, 'wpjobus_company_address', $_POST['wpjobus_company_address']);
	update_post_meta($post_id, 'wpjobus_company_phone', $_POST['wpjobus_company_phone']);
	update_post_meta($post_id, 'wpjobus_company_website', $_POST['wpjobus_company_website']);
	update_post_meta($post_id, 'wpjobus_company_email', $_POST['wpjobus_company_email']);
	update_post_meta($post_id, 'wpjobus_company_publish_email', $_POST['wpjobus_company_publish_email']);
	update_post_meta($post_id, 'wpjobus_company_facebook', $_POST['wpjobus_company_facebook']);
	update_post_meta($post_id, 'wpjobus_company_linkedin', $_POST['wpjobus_company_linkedin']);
	update_post_meta($post_id, 'wpjobus_company_twitter', $_POST['wpjobus_company_twitter']);
	update_post_meta($post_id, 'wpjobus_company_googleplus', $_POST['wpjobus_company_googleplus']);
	update_post_meta($post_id, 'wpjobus_company_googleaddress', $_POST['wpjobus_company_googleaddress']);
	update_post_meta($post_id, 'wpjobus_company_longitude', $_POST['wpjobus_company_longitude']);
	update_post_meta($post_id, 'wpjobus_company_latitude', $_POST['wpjobus_company_latitude']);

	$SubmitResumeSuccess = home_url()."/company/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusEditCompanyForm', 'wpjobusEditCompanyForm' );
add_action( 'wp_ajax_nopriv_wpjobusEditCompanyForm', 'wpjobusEditCompanyForm' );



function wpjobusSubmitJobForm() {

  if ( isset( $_POST['wpjobusSubmitJob_nonce'] ) && wp_verify_nonce( $_POST['wpjobusSubmitJob_nonce'], 'wpjobusSubmitJob_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	if (current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'job',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

	  	$post_id = wp_insert_post($post_information);

		$my_post = array(
			'ID' => $post_id,
			'post_title' => $_POST['fullName'],
			'post_name' => $post_id
		);

		wp_update_post( $my_post );

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $post_id,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		  	

		}

		update_post_meta($post_id, 'wpjobus_featured_post_status', 'regular');

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'job',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'draft'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $post_id,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

			  	global $redux_demo; 
			  	$comp_reg_price = $redux_demo['job-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($post_id, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'publish'
				  	);



				} else {

					$my_post = array(
					  	'ID' => $post_id,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'job',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

		  	$post_id = wp_insert_post($post_information);

			$my_post = array(
				'ID' => $post_id,
				'post_title' => $_POST['fullName'],
				'post_name' => $post_id
			);

			wp_update_post( $my_post );

	  	}

	}

	update_post_meta($post_id, 'wpjobus_job_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'job_industry', wp_kses($_POST['job_industry'], $allowed));
	update_post_meta($post_id, 'job_location', wp_kses($_POST['job_location'], $allowed));
	update_post_meta($post_id, 'job_company', wp_kses($_POST['job_company'], $allowed));
	update_post_meta($post_id, 'job-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'job_years_of_exp', wp_kses($_POST['job_years_of_exp'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_cover_image', wp_kses($_POST['wpjobus_job_cover_image'], $allowed));
	update_post_meta($post_id, 'job_presence_type', $_POST['job_presence_type']);

	update_post_meta($post_id, 'wpjobus_job_prof_title', wp_kses($_POST['wpjobus_job_prof_title'], $allowed));
	update_post_meta($post_id, 'job_career_level', wp_kses($_POST['job_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_skills', $_POST['wpjobus_job_skills']);

	update_post_meta($post_id, 'wpjobus_job_comm_level', wp_kses($_POST['wpjobus_job_comm_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_comm_note', strip_tags($_POST['skillsNotes']));

	update_post_meta($post_id, 'wpjobus_job_org_level', wp_kses($_POST['wpjobus_job_org_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_org_note', strip_tags($_POST['orgNotes']));

	update_post_meta($post_id, 'wpjobus_job_job_rel_level', wp_kses($_POST['wpjobus_job_job_rel_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_job_rel_note', strip_tags($_POST['jobNotes']));

	update_post_meta($post_id, 'wpjobus_job_native_language', wp_kses($_POST['wpjobus_job_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_languages', $_POST['wpjobus_job_languages']);

	update_post_meta($post_id, 'wpjobus_job_hobbies', wp_kses($_POST['wpjobus_job_hobbies'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_benefits', $_POST['wpjobus_job_benefits']);

	update_post_meta($post_id, 'wpjobus_job_remuneration', $_POST['wpjobus_job_remuneration']);
	update_post_meta($post_id, 'wpjobus_job_remuneration_per', $_POST['wpjobus_job_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_job_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_job_remuneration_raw', $str);
	
	update_post_meta($post_id, 'wpjobus_job_type', $_POST['wpjobus_job_type']);

	update_post_meta($post_id, 'wpjobus_job_address', $_POST['wpjobus_job_address']);
	update_post_meta($post_id, 'wpjobus_job_phone', $_POST['wpjobus_job_phone']);
	update_post_meta($post_id, 'wpjobus_job_website', $_POST['wpjobus_job_website']);
	update_post_meta($post_id, 'wpjobus_job_email', $_POST['wpjobus_job_email']);
	update_post_meta($post_id, 'wpjobus_job_publish_email', $_POST['wpjobus_job_publish_email']);
	update_post_meta($post_id, 'wpjobus_job_facebook', $_POST['wpjobus_job_facebook']);
	update_post_meta($post_id, 'wpjobus_job_linkedin', $_POST['wpjobus_job_linkedin']);
	update_post_meta($post_id, 'wpjobus_job_twitter', $_POST['wpjobus_job_twitter']);
	update_post_meta($post_id, 'wpjobus_job_googleplus', $_POST['wpjobus_job_googleplus']);
	update_post_meta($post_id, 'wpjobus_job_googleaddress', $_POST['wpjobus_job_googleaddress']);
	update_post_meta($post_id, 'wpjobus_job_longitude', $_POST['wpjobus_job_longitude']);
	update_post_meta($post_id, 'wpjobus_job_latitude', $_POST['wpjobus_job_latitude']);

	if ( get_post_status ( $post_id ) == 'publish' ) {
		wpjobusSendNotifications($post_id);
	}

	$SubmitResumeSuccess = home_url()."/job/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusSubmitJobForm', 'wpjobusSubmitJobForm' );
add_action( 'wp_ajax_nopriv_wpjobusSubmitJobForm', 'wpjobusSubmitJobForm' );



function wpjobusEditJobForm() {

  if ( isset( $_POST['wpjobusEditJob_nonce'] ) && wp_verify_nonce( $_POST['wpjobusEditJob_nonce'], 'wpjobusEditJob_html' ) ) {

	global $redux_demo; 
	$recipe_state = $redux_demo['resume-state'];

	$current_post = $_POST['postID'];

	if (current_user_can('administrator')) {

	  	$post_information = array(
			'ID' => $current_post,
			'post_title' => $_POST['fullName'],
			'post_content' => strip_tags($_POST['postContent']),
			'post_type' => 'job',
				'comment_status' => 'open',
				'ping_status' => 'open',
			'post_status' => 'publish'
	  	);

		$postStatus = $_POST['postStatus'];

		if($postStatus == 'draft') {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'draft'
		  	);

		  	wp_update_post( $my_post );

		} else {

		  	$my_post = array(
			  	'ID' => $current_post,
			  	'post_status' => 'publish'
		  	);

		  	wp_update_post( $my_post );

		}

	} else {

	  	if($recipe_state == "1") {
	
			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'job',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'draft'
		  	);

			$postStatus = $_POST['postStatus'];

			if($postStatus == 'draft') {

			  	$my_post = array(
				  	'ID' => $current_post,
				  	'post_status' => 'draft'
			  	);

			  	wp_update_post( $my_post );

			} else {

			  	global $redux_demo; 
			  	$comp_reg_price = $redux_demo['job-regular-price'];
				$wpjobus_post_reg_status = esc_attr(get_post_meta($current_post, 'wpjobus_featured_post_status',true));

			  	if(($wpjobus_post_reg_status == "featured") || ($wpjobus_post_reg_status == "regular") or (empty($comp_reg_price))) {

				  	$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'publish'
				  	);

				} else {

					$my_post = array(
					  	'ID' => $current_post,
					  	'post_status' => 'draft'
				  	);

				}

			  	wp_update_post( $my_post );

			}

	  	} else {

			$post_information = array(
				'ID' => $current_post,
				'post_title' => $_POST['fullName'],
				'post_content' => strip_tags($_POST['postContent']),
				'post_type' => 'job',
					'comment_status' => 'open',
					'ping_status' => 'open',
				'post_status' => 'pending'
		  	);

	  	}

	}

	$my_post = array(
		'ID' => $current_post,
		'post_title' => $_POST['fullName']
	);

	wp_update_post( $my_post );

	$post_id = $current_post;

	update_post_meta($post_id, 'wpjobus_job_fullname', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'wpjobus_post_title', wp_kses($_POST['fullName'], $allowed));
	update_post_meta($post_id, 'job_industry', wp_kses($_POST['job_industry'], $allowed));
	update_post_meta($post_id, 'job_location', wp_kses($_POST['job_location'], $allowed));
	update_post_meta($post_id, 'job_company', wp_kses($_POST['job_company'], $allowed));
	update_post_meta($post_id, 'job-about-me', htmlentities(stripslashes($_POST['postContent'])));
	update_post_meta($post_id, 'job_years_of_exp', wp_kses($_POST['job_years_of_exp'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_cover_image', wp_kses($_POST['wpjobus_job_cover_image'], $allowed));
	update_post_meta($post_id, 'job_presence_type', $_POST['job_presence_type']);

	update_post_meta($post_id, 'wpjobus_job_prof_title', wp_kses($_POST['wpjobus_job_prof_title'], $allowed));
	update_post_meta($post_id, 'job_career_level', wp_kses($_POST['job_career_level'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_skills', $_POST['wpjobus_job_skills']);

	update_post_meta($post_id, 'wpjobus_job_comm_level', wp_kses($_POST['wpjobus_job_comm_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_comm_note', strip_tags($_POST['skillsNotes']));

	update_post_meta($post_id, 'wpjobus_job_org_level', wp_kses($_POST['wpjobus_job_org_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_org_note', strip_tags($_POST['orgNotes']));

	update_post_meta($post_id, 'wpjobus_job_job_rel_level', wp_kses($_POST['wpjobus_job_job_rel_level'], $allowed));
	update_post_meta($post_id, 'wpjobus_job_job_rel_note', strip_tags($_POST['jobNotes']));

	update_post_meta($post_id, 'wpjobus_job_native_language', wp_kses($_POST['wpjobus_job_native_language'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_languages', $_POST['wpjobus_job_languages']);

	update_post_meta($post_id, 'wpjobus_job_hobbies', wp_kses($_POST['wpjobus_job_hobbies'], $allowed));

	update_post_meta($post_id, 'wpjobus_job_benefits', $_POST['wpjobus_job_benefits']);

	update_post_meta($post_id, 'wpjobus_job_remuneration', $_POST['wpjobus_job_remuneration']);
	update_post_meta($post_id, 'wpjobus_job_remuneration_per', $_POST['wpjobus_job_remuneration_per']);

	$remuneration_ammount = $_POST['wpjobus_job_remuneration'];
	$str = preg_replace('/\D/', '', $remuneration_ammount);
	update_post_meta($post_id, 'wpjobus_job_remuneration_raw', $str);
	
	update_post_meta($post_id, 'wpjobus_job_type', $_POST['wpjobus_job_type']);

	update_post_meta($post_id, 'wpjobus_job_address', $_POST['wpjobus_job_address']);
	update_post_meta($post_id, 'wpjobus_job_phone', $_POST['wpjobus_job_phone']);
	update_post_meta($post_id, 'wpjobus_job_website', $_POST['wpjobus_job_website']);
	update_post_meta($post_id, 'wpjobus_job_email', $_POST['wpjobus_job_email']);
	update_post_meta($post_id, 'wpjobus_job_publish_email', $_POST['wpjobus_job_publish_email']);
	update_post_meta($post_id, 'wpjobus_job_facebook', $_POST['wpjobus_job_facebook']);
	update_post_meta($post_id, 'wpjobus_job_linkedin', $_POST['wpjobus_job_linkedin']);
	update_post_meta($post_id, 'wpjobus_job_twitter', $_POST['wpjobus_job_twitter']);
	update_post_meta($post_id, 'wpjobus_job_googleplus', $_POST['wpjobus_job_googleplus']);
	update_post_meta($post_id, 'wpjobus_job_googleaddress', $_POST['wpjobus_job_googleaddress']);
	update_post_meta($post_id, 'wpjobus_job_longitude', $_POST['wpjobus_job_longitude']);
	update_post_meta($post_id, 'wpjobus_job_latitude', $_POST['wpjobus_job_latitude']);

	$SubmitResumeSuccess = home_url()."/job/".$post_id;

  } else {

	$SubmitResumeSuccess = 0;

  }

  echo $SubmitResumeSuccess;

  die(); // this is required to return a proper result

}
add_action( 'wp_ajax_wpjobusEditJobForm', 'wpjobusEditJobForm' );
add_action( 'wp_ajax_nopriv_wpjobusEditJobForm', 'wpjobusEditJobForm' );



// Post views
function wpb_set_post_views($postID) {
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
//To keep the count accurate, lets get rid of prefetching


function WPJobus_track_post_views ($post_id) {
	if ( !is_single() ) return;
	if ( empty ( $post_id) ) {
		global $post;
		$post_id = $post->ID;    
	}
	wpb_set_post_views($post_id);
}


function wpb_get_post_views($postID){
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}



// Profile views
function wpb_set_profile_views($authorID) {
	$count_key = 'wpb_profile_views_count';
	$count = get_user_meta($authorID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_user_meta($authorID, $count_key);
		update_user_meta($authorID, $count_key, '0');
	}else{
		$count++;
		update_user_meta($authorID, $count_key, $count);
	}
}

function wpb_get_profile_views($authorID){
	$count_key = 'wpb_profile_views_count';
	$count = get_user_meta($authorID, $count_key, true);
	if($count==''){
		delete_user_meta($authorID, $count_key);
		update_user_meta($authorID, $count_key, '0');
		return "0";
	}
	return $count;
}




/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since WPJobus 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */

function WPJobus_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	return $title;
}


/* Breadcrumbs */
function WPJobus_breadcrumb() {
				echo '<ul id="crumbs">';
		if (!is_home()) {
				echo '<li><a href="';
				echo home_url();
				echo '">';
				echo 'Home';
				echo "</a><i class='fa fa-chevron-right'></i></li>";
				if (is_category() || is_single()) {
						echo '<li>';
						the_category(' <i class="fa fa-chevron-right"></i></li><li> ');
						if (is_single()) {
								echo "<i class='fa fa-chevron-right'></i></li><li>";
								the_title();
								echo '<i class="fa fa-chevron-right"></i></li>';
						}
				} elseif (is_page()) {
						echo '<li>';
						echo the_title();
						echo '<i class="fa fa-chevron-right"></i></li>';
				}
		}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'<i class="fa fa-chevron-right"></i></li>';}
		elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'<i class="fa fa-chevron-right"></i></li>';}
		elseif (is_author()) {echo"<li>Author Archive"; echo'<i class="fa fa-chevron-right"></i></li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'<i class="fa fa-chevron-right"></i></li>';}
		elseif (is_search()) {echo"<li>Search Results"; echo'<i class="fa fa-chevron-right"></i></li>';}
		echo '</ul>';
}


/**
 * Registers two widget areas.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area One', 'agrg' ),
		'id'            => 'footer-one',
		'description'   => __( 'Appears in the footer section of the site.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area Two', 'agrg' ),
		'id'            => 'footer-two',
		'description'   => __( 'Appears in the footer section of the site.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area Three', 'agrg' ),
		'id'            => 'footer-three',
		'description'   => __( 'Appears in the footer section of the site.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area Four', 'agrg' ),
		'id'            => 'footer-four',
		'description'   => __( 'Appears in the footer section of the site.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Pages Widget Area', 'agrg' ),
		'id'            => 'pages',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );

  register_sidebar( array(
	'name'          => __( 'Blog Widget Area', 'agrg' ),
	'id'            => 'blog',
	'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
	'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
  ) );

	register_sidebar( array(
		'name'          => __( 'Forum Widget Area', 'agrg' ),
		'id'            => 'forum',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4>',
	) );
}


function WPJobus_html_widget_title( $title ) {
//HTML tag opening/closing brackets
$title = str_replace( '[', '<', $title );
$title = str_replace( ']', '>', $title );
$title = str_replace( '&quot;','"', $title);
$title = str_replace( '&#039;',"'", $title);
return $title;
}
add_filter( 'widget_title', 'WPJobus_html_widget_title' );



if ( ! function_exists( 'WPJobus_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'agrg' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'agrg' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'agrg' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'WPJobus_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since WPJobus 1.0
*
* @return void
*/
function WPJobus_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'agrg' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'agrg' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'agrg' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'WPJobus_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own WPJobus_entry_meta() to override in a child theme.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'agrg' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		WPJobus_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'agrg' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'agrg' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'agrg' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'WPJobus_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own WPJobus_entry_date() to override in a child theme.
 *
 * @since WPJobus 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function WPJobus_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'agrg' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'agrg' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'WPJobus_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'WPJobus_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since WPJobus 1.0
 *
 * @return string The Link format URL.
 */
function WPJobus_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since WPJobus 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function WPJobus_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}


/**
 * Adjusts content_width value for video post formats and attachment templates.
 *
 * @since WPJobus 1.0
 *
 * @return void
 */
function WPJobus_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since WPJobus 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function WPJobus_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}


/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since WPJobus 1.0
 */
function WPJobus_customize_preview_js() {
	wp_enqueue_script( 'WPJobus-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}




/*---------------------------------------------------
register demo content page
----------------------------------------------------*/
function wpcook_theme_settings_init(){
  	register_setting( 'theme_settings', 'theme_settings' );
}

function wpcook_load_custom_wp_admin_style() {
  	// Load form script
	wp_enqueue_script( 'WPJobus-form-admin-script', get_template_directory_uri() . '/js/jquery.form.js', array( 'jquery' ), '2013-07-18', true );

	// Load boostratp style
	wp_enqueue_style( 'awesomefont-style', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array(), '4.0.3' );
}
add_action( 'admin_enqueue_scripts', 'wpcook_load_custom_wp_admin_style' );
 
/*---------------------------------------------------
add demo content page to menu
----------------------------------------------------*/
function wpcook_add_settings_page() {
  	add_menu_page( __( 'Demo Content', 'agrg' ), __( 'Demo Content', 'agrg' ), 'manage_options', 'settings', 'wpcook_theme_settings_page');
}
 
/*---------------------------------------------------
add actions
----------------------------------------------------*/
add_action( 'admin_init', 'wpcook_theme_settings_init' );
add_action( 'admin_menu', 'wpcook_add_settings_page' );

if (!function_exists('redux_disable_dev_mode_plugin')) {
    function redux_disable_dev_mode_plugin($redux) {
        $redux->args['dev_mode'] = false;
    }
    add_action('redux/construct', 'redux_disable_dev_mode_plugin');
}
 
/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
function wpcook_theme_settings_page() {
  	global $themename,$theme_options;
  
    ?>

    <style>

    	.import-content-box h4 {
    		margin: 0;
    	}

    	.import-demo-activator {
    		background-color: #2980b9;
			padding: 10px 20px;
			text-transform: uppercase;
			color: #fff !important;
			float: left;
			font-weight: bold;
			font-size: 12px;
			-webkit-border-radius: 32px;
			-moz-border-radius: 32px;
			border-radius: 32px;
			text-align: center;
			text-decoration: none;
			margin-top: 20px;

			-webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
    	}

    	.import-demo-activator:hover {
			background-color: #1f6797;
			text-decoration: none;

			-webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.import-demo-activator .fa {
			margin-right: 5px;
		}

		.import-demo-activator .fa-spin {
			margin-right: 0;
		}

		.import-demo-activator .import-default {
			display: block;

			webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.import-demo-activator .import-progress {
			display: none;

			webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.import-demo-activator.launch .import-default {
			display: none;

			webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.import-demo-activator.launch .import-progress {
			display: block;

			webkit-transition: all 0.2s ease;
			-moz-transition: all 0.2s ease;
			-o-transition: all 0.2s ease;
			-ms-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.import-demo-activator.launch {
			pointer-events: none;
   			cursor: default;
   			background-color: #999;
		}

		.import_wait, .import_success, .import_error {
			float: left;
			width: 100%;
			margin-top: 20px;
			display: none;
		}

    </style>

    <div class="wrap">
      	<div id="icon-options-general"></div>

      	<div class="import-content-box" style="max-width: 700px; float: left; margin-right: 30px;">

	      	<h3><?php _e('Import Dummy Content: Posts, Pages, Categories', 'agrg') ?></h3>
	      	<p><?php _e('If you are new to wordpress or have problems creating posts or pages that look like the theme preview you can import dummy posts and pages here that will definitley help to understand how those tasks are done.', 'agrg') ?></p>

	      	<form id="wpjobus-companies" type="post" action="" style="float: left; width: 100%;">

		      	<a class="import-demo-activator" href="#"><span class="import-default"><i class="fa fa-cloud-download"></i><?php _e('Import Dummy Content', 'agrg') ?></span><span class="import-progress"><i class="fa fa-spinner fa-spin"></i></span></a>

		      	<div class="response"></div>

		      	<input type="hidden" name="action" value="wpjobusImportDemo" />
				<?php wp_nonce_field( 'wpjobusImportDemo_html', 'wpjobusImportDemo_nonce' ); ?>

	      	</form>

	      	<div class="import_wait"><h4><?php _e('Import started.', 'agrg') ?></h4><br><?php _e('Please wait a few seconds and dont reload the page. You will be notified as soon as the import has finished! :)', 'agrg') ?></div>

	      	<div class="import_success"><h4><i class="fa fa-check"></i> <?php _e('Great news master!', 'agrg') ?></h4><br><?php _e('Import worked out, no problems whatsoever. The page will now be reloaded to reflect the changes.', 'agrg') ?></div>

	      	<div class="import_error"><h4><?php _e('Import failed.', 'agrg') ?></h4><br><?php _e('Please reload the page and try again.', 'agrg') ?></div>

	      </div>

      	<script type="text/javascript">

			jQuery(function($) {

				jQuery(document).on("click",".import-demo-activator",function(e){

					$.fn.wpjobusSubmitFormFunction();

					e.preventDefault();
					return false;

				});

				$.fn.wpjobusSubmitFormFunction = function() {

					jQuery('#wpjobus-companies').ajaxSubmit({
						type: "POST",
						data: jQuery('#wpjobus-companies').serialize(),
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						beforeSend: function() { 
						    jQuery(".import-demo-activator").addClass('launch');
						    jQuery(".import_wait").css('display', 'block');
						},	 
						success: function(response) {
							jQuery(".import-demo-activator").removeClass('launch');
						    jQuery(".import_wait").css('display', 'none');
						    jQuery(".import_success").css('display', 'block');
						    setTimeout(function() {
								 window.location.reload(true);
							},5000)
						},
						error: function(response) {
						    jQuery(".import-demo-activator").removeClass('launch');
						    jQuery(".import_wait").css('display', 'none');
						    jQuery(".import_error").css('display', 'block');
						}
					});
				};
			});

		</script>

    </div>

  <?php
}
