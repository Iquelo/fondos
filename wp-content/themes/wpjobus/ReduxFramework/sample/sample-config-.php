<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/


/**
 
	Most of your editing will be done in this section.

	Here you can override default values, uncomment args and change their values.
	No $args are required, but they can be overridden if needed.
	
**/
$args = array();


// For use with a tab example below
$tabs = array();

ob_start();

$ct = wp_get_theme();
$theme_data = $ct;
$item_name = $theme_data->get('Name'); 
$tags = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class = $screenshot ? 'has-screenshot' : '';

$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework-demo' ), $ct->display('Name') );

?>
<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $screenshot ) : ?>
		<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
		<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
			<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		</a>
		<?php endif; ?>
		<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
	<?php endif; ?>

	<h4>
		<?php echo $ct->display('Name'); ?>
	</h4>

	<div>
		<ul class="theme-info">
			<li><?php printf( __('By %s','redux-framework-demo'), $ct->display('Author') ); ?></li>
			<li><?php printf( __('Version %s','redux-framework-demo'), $ct->display('Version') ); ?></li>
			<li><?php echo '<strong>'.__('Tags', 'redux-framework-demo').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
		</ul>
		<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
		<?php if ( $ct->parent() ) {
			printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
				__( 'http://codex.wordpress.org/Child_Themes','redux-framework-demo' ),
				$ct->parent()->display( 'Name' ) );
		} ?>
		
	</div>

</div>

<?php
$item_info = ob_get_contents();
    
ob_end_clean();

$sampleHTML = '';
if( file_exists( dirname(__FILE__).'/info-html.html' )) {
	/** @global WP_Filesystem_Direct $wp_filesystem  */
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}  		
	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
}

// BEGIN Sample Config

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode'] = true;

// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'redux_demo';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;


// Set the icon for the system info tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['system_info_icon'] = 'info-sign';

// Set the class for the system info tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
//$args['system_info_icon_class'] = 'icon-large';

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
//$args['last_tab'] = '0';

// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';

// Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
    'link' => 'http://twitter.com/ghost1227',
    'title' => 'Follow me on Twitter', 
    'img' => ReduxFramework::$_url . 'assets/img/social/Twitter.png'
);
$args['share_icons']['linked_in'] = array(
    'link' => 'http://www.linkedin.com/profile/view?id=52559281',
    'title' => 'Find me on LinkedIn', 
    'img' => ReduxFramework::$_url . 'assets/img/social/LinkedIn.png'
);

// Enable the import/export feature.
// Default: true
//$args['show_import_export'] = false;

// Set the icon for the import/export tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: refresh
//$args['import_icon'] = 'refresh';

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('WPJobus Settings', 'redux-framework-demo');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('WPJobus Settings', 'redux-framework-demo');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'redux_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Set a custom page capability.
// Default: manage_options
//$args['page_cap'] = 'manage_options';

// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
// Default: menu
//$args['page_type'] = 'submenu';

// Set the parent menu.
// Default: themes.php
// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'options_general.php';

// Set a custom page location. This allows you to place your menu where you want in the menu order.
// Must be unique or it will override other items!
// Default: null
//$args['page_position'] = null;

// Set a custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
// Redux no longer ships with standard icons!
// Default: iconfont
//$args['icon_type'] = 'image';

// Disable the panel sections showing as submenu items.
// Default: true
//$args['allow_sub_menu'] = false;
    
// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
$args['help_tabs'][] = array(
    'id' => 'redux-opts-1',
    'title' => __('Theme Information 1', 'redux-framework-demo'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
);
$args['help_tabs'][] = array(
    'id' => 'redux-opts-2',
    'title' => __('Theme Information 2', 'redux-framework-demo'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
);

// Set the help sidebar for the options page.                                        
$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');


// Add HTML before the form.
/*
if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
}

// Add content after the form.
$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
*/

// Set footer/credit line.
//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'redux-framework-demo');


$sections = array();              

//Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) :
	
  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
  	$sample_patterns = array();

    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
      	$name = explode(".", $sample_patterns_file);
      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
      }
    }
  endif;
endif;


$sections[] = array(
	'icon' => 'el-icon-cogs',
	'icon_class' => 'icon-large',
    'title' => __('General Settings', 'redux-framework-demo'),
	'fields' => array(
		
		array(
			'id'=>'logo',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Logo', 'redux-framework-demo'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your logo.', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'default'=>array('url'=>'http://alexgurghis.com/themes/wpjobus/wp-content/uploads/2014/05/logo.png'),
			),

		array(
			'id'=>'stripe-logo',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Stripe Block Logo', 'redux-framework-demo'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your logo for stripe (76x75px).', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'default'=>array('url'=>'http://alexgurghis.com/themes/wpjobus/wp-content/uploads/2014/07/logo-stripe.png'),
			),	

		array(
			'id'=>'favicon',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Favicon', 'redux-framework-demo'),
			'compiler' => 'true',
			//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'desc'=> __('Upload your favicon.', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'default'=>array('url'=>'http://alexgurghis.com/themes/wpcads/wp-content/themes/wpads/images/favicon.png'),
			),

		array(
		    'id'       => 'homepage-state',
		    'type'     => 'radio',
		    'title'    => __('Website type', 'redux-framework-demo'), 
		    'subtitle' => __('Select the type of your website', 'redux-framework-demo'),
		    'desc'     => __('Select the type of your website', 'redux-framework-demo'),
		    //Must provide key => value pairs for radio options
		    'options'  => array(
		        	'1' => 'Default', 
		        	'2' => 'Resume Page',
		        	'3' => 'Company Profile Page'
		    	),
		    'default' => '1'
		    ),

		array(
			'id'=>'job-reject-message',
			'type' => 'text',
			'title' => __('Custom Job Reject Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the job reject text the user will get in email.', 'redux-framework-demo'),
			'default' => 'Your job offer has been rejected.'
			),

		array(
			'id'=>'job-approve-message',
			'type' => 'text',
			'title' => __('Custom Job Approve Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the job approve message the user will get in email.', 'redux-framework-demo'),
			'default' => 'Congratulations! Your job offer has beed approved.'
			),

		array(
			'id'=>'resume-reject-message',
			'type' => 'text',
			'title' => __('Custom Resume Reject Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the resume reject text the user will get in email.', 'redux-framework-demo'),
			'default' => 'Your resume has been rejected.'
			),

		array(
			'id'=>'resume-approve-message',
			'type' => 'text',
			'title' => __('Custom Resume Approve Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the resume approve message the user will get in email.', 'redux-framework-demo'),
			'default' => 'Congratulations! Your resume has beed approved.'
			),

		array(
			'id'=>'company-reject-message',
			'type' => 'text',
			'title' => __('Custom Company Reject Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the company reject text the user will get in email.', 'redux-framework-demo'),
			'default' => 'Your company profile has been rejected.'
			),

		array(
			'id'=>'company-approve-message',
			'type' => 'text',
			'title' => __('Custom Company Approve Message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add here the company approve message the user will get in email.', 'redux-framework-demo'),
			'default' => 'Congratulations! Your company profile has beed approved.'
			),

		array(
			'id'=>'map-style',
	        'type' => 'textarea',
	        'title' => __('Map Styles', 'redux-framework-demo'), 
	        'subtitle' => __('Check <a href="http://snazzymaps.com/" target="_blank">snazzymaps.com</a> for a list of nice google map styles.', 'redux-framework-demo'),
	        'desc' => __('Ad here your google map style.', 'redux-framework-demo'),
	        'validate' => 'html_custom',
	        'default' => '',
	        'allowed_html' => array(
	            'a' => array(
	                'href' => array(),
	                'title' => array()
	            ),
	            'br' => array(),
	            'em' => array(),
	            'strong' => array()
	       		)
			),

		array(
			'id'=>'google_id',
			'type' => 'text',
			'title' => __('Google Analytics Domain ID', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Get analytics on your site. Enter Google Analytics Domain ID (ex: UA-123456-1)', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'footer_copyright',
			'type' => 'text',
			'title' => __('Footer Copyright Text', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('You can add text and HTML in here.', 'redux-framework-demo'),
			'default' => ''
			),


		),
	);	

$sections[] = array(
	'icon' => 'el-icon-file-edit',
	'icon_class' => 'icon-large',
    'title' => __('Resume/Job/Company Settings', 'redux-framework-demo'),
	'fields' => array(

		array(
		    'id'       => 'resume-state',
		    'type'     => 'radio',
		    'title'    => __('Resume/Job/Company Upload State', 'redux-framework-demo'), 
		    'subtitle' => __('Select the state when user uploads a resume/job/company', 'redux-framework-demo'),
		    'desc'     => __('Select Pending for admin review.', 'redux-framework-demo'),
		    //Must provide key => value pairs for radio options
		    'options'  => array(
		        	'1' => 'Publish', 
		        	'2' => 'Pending for Review'
		    	),
		    'default' => '1'
		    ),

		$fields = array(
			    'id'=>'resume-industries',
			    'type' => 'multi_text',
			    'title' => __('Resume industries options list', 'redux-framework-demo'),
			    'subtitle' => __('Add industries options list (ex: Informational Technology).', 'redux-framework-demo')
			),

		$fields = array(
			    'id'=>'resume-locations',
			    'type' => 'multi_text',
			    'title' => __('Resume locations options list', 'redux-framework-demo'),
			    'subtitle' => __('Add locations options list (ex: New York).', 'redux-framework-demo')
			),

		$fields = array(
			    'id'=>'resume_career_level',
			    'type' => 'multi_text',
			    'title' => __('Resume career level options list', 'redux-framework-demo'),
			    'subtitle' => __('Add career levels options list (ex: Senior).', 'redux-framework-demo')
			),

		$fields = array(
			    'id'=>'job_presence_type',
			    'type' => 'multi_text',
			    'title' => __('Job presence options list', 'redux-framework-demo'),
			    'subtitle' => __('Add job presence options list (ex: Remote).', 'redux-framework-demo')
			),

		$fields = array(
			    'id'=>'job-type',
			    'type' => 'multi_text',
			    'title' => __('Job type options list', 'redux-framework-demo'),
			    'subtitle' => __('Add job type options list (ex: Full-Time).', 'redux-framework-demo')
			),

		$fields = array(
			    'id'=>'job-remuneration-per',
			    'type' => 'multi_text',
			    'title' => __('Job remuneration per options list', 'redux-framework-demo'),
			    'subtitle' => __('Add job remuneration per options list (ex: Month, Hour, Project).', 'redux-framework-demo')
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-wrench',
	'icon_class' => 'icon-large',
    'title' => __('Payment settings', 'redux-framework-demo'),
	'fields' => array(

		array(
		    'id'       => 'stripe-state',
		    'type'     => 'radio',
		    'title'    => __('Stripe Test Mode', 'redux-framework-demo'), 
		    'subtitle' => __('Place Stripe in Test mode using your test API keys.', 'redux-framework-demo'),
		    'desc'     => __('Place Stripe in Test mode using your test API keys.', 'redux-framework-demo'),
		    //Must provide key => value pairs for radio options
		    'options'  => array(
		        	'1' => 'Live', 
		        	'2' => 'Test'
		    	),
		    'default' => '2'
		    ),

		array(
			'id'=>'stripe-test-secret-key',
			'type' => 'text',
			'title' => __('Test Secret Key', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Enter your test secret key, found in your Stripe account settings.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'stripe-test-publishable-key',
			'type' => 'text',
			'title' => __('Test Publishable Key', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Enter your test publishable key, found in your Stripe account settings.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'stripe-live-secret-key',
			'type' => 'text',
			'title' => __('Live Secret Key', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Enter your live secret key, found in your Stripe account settings.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'stripe-live-publishable-key',
			'type' => 'text',
			'title' => __('Live Publishable Key', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Enter your live publishable key, found in your Stripe account settings.', 'redux-framework-demo'),
			'default' => ''
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-usd',
	'icon_class' => 'icon-large',
    'title' => __('Prices', 'redux-framework-demo'),
	'fields' => array(

		array(
			'id'=>'job-price-symbol',
			'type' => 'text',
			'title' => __('Currency Symbol', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Ex: $ for dollar (USD).', 'redux-framework-demo'),
			'default' => '$'
			),

		array(
			'id'=>'job-regular-price',
			'type' => 'text',
			'title' => __('Regular Jobs', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for free. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'job-featured-price',
			'type' => 'text',
			'title' => __('Featured Jobs', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for no featured jobs. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => '50'
			),

		array(
			'id'=>'job-featured-validity',
			'type' => 'text',
			'title' => __('Featured Jobs Validity', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add the number of days the featured job will be valid. Will become regular at expiration.', 'redux-framework-demo'),
			'default' => '10'
			),

		array(
			'id'=>'company-regular-price',
			'type' => 'text',
			'title' => __('Regular Company Profiles', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for free. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'company-featured-price',
			'type' => 'text',
			'title' => __('Featured Company Profiles', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for no featured company profiles. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => '50'
			),

		array(
			'id'=>'company-featured-validity',
			'type' => 'text',
			'title' => __('Featured Company Profiles Validity', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add the number of days the featured company profile will be valid. Will become regular at expiration.', 'redux-framework-demo'),
			'default' => '10'
			),

		array(
			'id'=>'resume-regular-price',
			'type' => 'text',
			'title' => __('Regular Resumes', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for free. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'resume-featured-price',
			'type' => 'text',
			'title' => __('Featured Resumes', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Leave empty for no featured resumes. Use smallest common currency unit (<a href="https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support" target="_blank">read more</a>). U.S. amounts are in cents. 100 (equals $1.00 US) Minimum 50.', 'redux-framework-demo'),
			'default' => '50'
			),

		array(
			'id'=>'resume-featured-validity',
			'type' => 'text',
			'title' => __('Featured Resume Validity', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('Add the number of days the featured resume will be valid. Will become regular at expiration.', 'redux-framework-demo'),
			'default' => '10'
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-font',
	'icon_class' => 'icon-large',
    'title' => __('Fonts', 'redux-framework-demo'),
	'fields' => array(
		
		array(
            'id' => 'heading1-font',
            'type' => 'typography',
            'title' => __('H1 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h1, h1 a, h1 span, .page-title, h1 strong'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '38.5px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '42px',
                ),
         	),

		array(
            'id' => 'heading2-font',
            'type' => 'typography',
            'title' => __('H2 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h2, h2 a, h2 span, #carousel-feat-recipes .feat-post-black-box .feat-post-black-box-content .feat-post-title a, h2 strong'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '31.5px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '36px',
                ),
         	),

		array(
            'id' => 'heading3-font',
            'type' => 'typography',
            'title' => __('H3 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h3, h3 a, h3 span, h3 strong'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '24.5px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '32px',
                ),
         	),

		array(
            'id' => 'heading4-font',
            'type' => 'typography',
            'title' => __('H4 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h4, h4 a, h4 span, h4 strong, .sidebar-widgets .widget .block-title, .recipe-page-title, .recipe-step-status-number, .step-id, .my-account-recipes-title'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '17.5px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '24px',
                ),
         	),

		array(
            'id' => 'heading5-font',
            'type' => 'typography',
            'title' => __('H5 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h5, h5 a, h5 span, h5 strong'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '14px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '20px',
                ),
         	),

		array(
            'id' => 'heading6-font',
            'type' => 'typography',
            'title' => __('H6 Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the headings font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('h6, h6 a, h6 span, h6 strong'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '11.9px',
                'font-family' => 'PT Serif',
                'font-weight' => '300',
                'line-height' => '16px',
                ),
         	),

		array(
            'id' => 'body-font',
            'type' => 'typography',
            'title' => __('Body Font', 'redux-framework-demo'),
            'subtitle' => __('Specify the body font properties.', 'redux-framework-demo'),
            'google' => true,
            'output' => array('html, body, div, applet, object, iframe p, blockquote, a, abbr, acronym, address, big, cite, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video, .btn'),
            'default' => array(
                'color' => '#484848',
                'font-size' => '12px',
                'font-family' => 'Open Sans',
                'font-weight' => 'Normal',
                'line-height' => '24px',
                ),
         	),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-adjust',
	'icon_class' => 'icon-large',
    'title' => __('Colors', 'redux-framework-demo'),
	'fields' => array(

		array(
		    'id'       => 'opt-colors',
		    'type'     => 'switch', 
		    'title'    => __('Custom color generator', 'redux-framework-demo'),
		    'subtitle' => __('Turn it on to generate your own color scheme.', 'redux-framework-demo'),
		    'default'  => false,
			),
		
		array(
			'id'       => 'color-main',
	        'type'     => 'color',
	        'title'    => __('Link Color', 'redux-framework-demo'), 
	        'subtitle' => __('Pick a color for link (default: #2980b9).', 'redux-framework-demo'),
	        'default'  => '#2980b9',
	        'validate' => 'color',
	        'transparent' => false,
			),

		array(
			'id'       => 'color-main-hover',
	        'type'     => 'color',
	        'title'    => __('Hover/Active Link State Color', 'redux-framework-demo'), 
	        'subtitle' => __('Pick a color for hover/active link state (default: #1f6797).', 'redux-framework-demo'),
	        'default'  => '#1f6797',
	        'validate' => 'color',
	        'transparent' => false,
			),

		array(
			'id'       => 'color-second',
	        'type'     => 'color',
	        'title'    => __('Second Color', 'redux-framework-demo'), 
	        'subtitle' => __('Pick the second color (default: #16a085).', 'redux-framework-demo'),
	        'default'  => '#16a085',
	        'validate' => 'color',
	        'transparent' => false,
			),

		array(
			'id'       => 'color-second-hover',
	        'type'     => 'color',
	        'title'    => __('Second Hover State Color', 'redux-framework-demo'), 
	        'subtitle' => __('Pick the second color hover state (default: #107C67).', 'redux-framework-demo'),
	        'default'  => '#107C67',
	        'validate' => 'color',
	        'transparent' => false,
			),	

		),
	);

$sections[] = array(
	'icon' => 'el-icon-group',
	'icon_class' => 'icon-large',
    'title' => __('Top Social Links', 'redux-framework-demo'),
	'fields' => array(
		
		array(
			'id'=>'facebook-link',
			'type' => 'text',
			'title' => __('Facebook Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'twitter-link',
			'type' => 'text',
			'title' => __('Twitter Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'dribbble-link',
			'type' => 'text',
			'title' => __('Dribbble Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'flickr-link',
			'type' => 'text',
			'title' => __('Flickr Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'github-link',
			'type' => 'text',
			'title' => __('Github Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'pinterest-link',
			'type' => 'text',
			'title' => __('Pinterest Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'youtube-link',
			'type' => 'text',
			'title' => __('Youtube Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'google-plus-link',
			'type' => 'text',
			'title' => __('Google+ Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'linkedin-link',
			'type' => 'text',
			'title' => __('LinkedIn Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'tumblr-link',
			'type' => 'text',
			'title' => __('Tumblr Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'vimeo-link',
			'type' => 'text',
			'title' => __('Vimeo Page URL', 'redux-framework-demo'),
			'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'url',
			'default' => ''
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-envelope',
	'icon_class' => 'icon-large',
    'title' => __('Contact Page', 'redux-framework-demo'),
	'fields' => array(
		
		array(
			'id'=>'contact-email',
			'type' => 'text',
			'title' => __('Your email address', 'redux-framework-demo'),
			'subtitle' => __('This must be an email address.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'validate' => 'email',
			'default' => ''
			),

		array(
			'id'=>'contact-address',
			'type' => 'text',
			'title' => __('Your address', 'redux-framework-demo'),
			'subtitle' => __('This must be an address.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-phone',
			'type' => 'text',
			'title' => __('Your phone', 'redux-framework-demo'),
			'subtitle' => __('This must be phone number.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-linkedin',
			'type' => 'text',
			'title' => __('Your LinkedIn link', 'redux-framework-demo'),
			'subtitle' => __('This must be a link.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-twitter',
			'type' => 'text',
			'title' => __('Your Twitter link', 'redux-framework-demo'),
			'subtitle' => __('This must be a link.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-googleplus',
			'type' => 'text',
			'title' => __('Your Google+ link', 'redux-framework-demo'),
			'subtitle' => __('This must be a link.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-facebook',
			'type' => 'text',
			'title' => __('Your Facebook link', 'redux-framework-demo'),
			'subtitle' => __('This must be a link.', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-email-error',
			'type' => 'text',
			'title' => __('Email error message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => 'No email, no message.'
			),

		array(
			'id'=>'contact-name-error',
			'type' => 'text',
			'title' => __('Name error message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => 'Come on, you have a name don’t you?'
			),

		array(
			'id'=>'contact-message-error',
			'type' => 'text',
			'title' => __('Message error', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => 'You have to write something to send this form.'
			),

		array(
			'id'=>'contact-test-error',
			'type' => 'text',
			'title' => __('Human test error', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => 'Sorry, wrong answer!'
			),

		array(
			'id'=>'contact-thankyou-message',
			'type' => 'text',
			'title' => __('Thank you message', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => 'Thank you! We will get back to you as soon as possible.'
			),

		array(
			'id'=>'contact-latitude',
			'type' => 'text',
			'title' => __('Latitude', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-longitude',
			'type' => 'text',
			'title' => __('Longitude', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		array(
			'id'=>'contact-zoom',
			'type' => 'text',
			'title' => __('Zoom level', 'redux-framework-demo'),
			'subtitle' => __('', 'redux-framework-demo'),
			'desc' => __('', 'redux-framework-demo'),
			'default' => ''
			),

		),
	);



$sections[] = array(
	'type' => 'divide',
);	

if (function_exists('wp_get_theme')){
$theme_data = wp_get_theme();
$theme_uri = $theme_data->get('ThemeURI');
$description = $theme_data->get('Description');
$author = $theme_data->get('Author');
$version = $theme_data->get('Version');
$tags = $theme_data->get('Tags');
}else{
$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
$theme_uri = $theme_data['URI'];
$description = $theme_data['Description'];
$author = $theme_data['Author'];
$version = $theme_data['Version'];
$tags = $theme_data['Tags'];
}	

$theme_info = '<div class="redux-framework-section-desc">';
$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'redux-framework-demo').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'redux-framework-demo').$author.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'redux-framework-demo').$version.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
if ( !empty( $tags ) ) {
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'redux-framework-demo').implode(', ', $tags).'</p>';	
}
$theme_info .= '</div>';

if(file_exists(dirname(__FILE__).'/README.md')){
$sections['theme_docs'] = array(
			'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
			'title' => __('Documentation', 'redux-framework-demo'),
			'fields' => array(
				array(
					'id'=>'17',
					'type' => 'raw',
					'content' => file_get_contents(dirname(__FILE__).'/README.md')
					),				
			),
			
			);
}//if


$sections[] = array(
	'icon' => 'el-icon-info-sign',
	'title' => __('Theme Information', 'redux-framework-demo'),
	'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
	'fields' => array(
		array(
			'id'=>'raw_new_info',
			'type' => 'raw',
			'content' => $item_info,
			)
		),   
	);


if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
    $tabs['docs'] = array(
		'icon' => 'el-icon-book',
		'icon_class' => 'icon-large',
        'title' => __('Documentation', 'redux-framework-demo'),
        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
    );
}

global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// END Sample Config


/**

	Filter hook for filtering the args array given by a theme, good for child themes to override or add to the args array.

**/
function change_framework_args($args){
    //$args['dev_mode'] = true;
    
    return $args;
}
add_filter('redux/options/redux_demo/args', 'change_framework_args');
// replace redux_demo with your opt_name

/**

	Filter hook for filtering the default value of any given field. Very useful in development mode.

**/
function change_option_defaults($defaults){
    $defaults['str_replace'] = "Testing filter hook!";
    
    return $defaults;
}
add_filter('redux/options/redux_demo/defaults', 'change_option_defaults');
// replace redux_demo with your opt_name


/** 

	Custom function for the callback referenced above

 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}


/**
 
	Custom function for the callback validation referenced above

**/
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/**

	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.

**/
function testCompiler() {
	echo "Compiler hook!";
}
//add_filter('redux/options/redux_demo/compiler', 'testCompiler');
// replace redux_demo with your opt_name




/**

	Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.

**/
if ( class_exists('ReduxFrameworkPlugin') ) {
	//remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	
}


/**

	Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.

**/
function removeDemoModeLink() {
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
	}
}
//add_action('init', 'removeDemoModeLink');




