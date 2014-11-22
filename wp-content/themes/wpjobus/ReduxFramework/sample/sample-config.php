<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
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
                        'id'       => 'payment-gateway-type',
                        'type'     => 'radio',
                        'title'    => __('Payment gateway type.', 'redux-framework-demo'), 
                        'subtitle' => __('Payment gateway type.', 'redux-framework-demo'),
                        'desc'     => __('Payment gateway type.', 'redux-framework-demo'),
                        //Must provide key => value pairs for radio options
                        'options'  => array(
                                '1' => 'Paypal', 
                                '2' => 'Stripe'
                            ),
                        'default' => '2'
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

            $this->sections[] = array(
                'icon' => 'el-icon-file-edit',
                'title' => __('Resume/Job/Company Settings', 'redux-framework-demo'),
                'fields' => array(

                    $fields = array(
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
                        'id'       => 'access-state',
                        'type'     => 'radio',
                        'title'    => __('Access for registered only', 'redux-framework-demo'), 
                        'subtitle' => __('Select if a user can access resume/company/job page without be logged in', 'redux-framework-demo'),
                        'desc'     => __('', 'redux-framework-demo'),
                        //Must provide key => value pairs for radio options
                        'options'  => array(
                                '1' => 'On', 
                                '2' => 'Off'
                            ),
                        'default' => '2'
                        ),

                    $fields = array(
                        'id'=>'access-state-text',
                        'type' => 'text',
                        'title' => __('Access for registered only Message', 'redux-framework-demo'),
                        'subtitle' => __('', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'default' => 'Please loggin to have access on our resume/job/company pages.'
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

            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => __('Stripe settings', 'redux-framework-demo'),
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

            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => __('Paypal settings', 'redux-framework-demo'),
                'fields' => array(

                    array(
                        'id'=>'paypal_api_environment',
                        'type' => 'radio',
                        'title' => __('PayPal environment', 'redux-framework-demo'), 
                        'subtitle' => __('', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'options' => array('1' => 'Sandbox - Testing', '2' => 'Live - Production'),//Must provide key => value pairs for radio options
                        'default' => '1'
                        ),
                    
                    array(
                        'id'=>'paypal_api_username',
                        'type' => 'text',
                        'title' => __('API Username (required)', 'redux-framework-demo'),
                        'subtitle' => __('', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'default' => ''
                        ),  

                    array(
                        'id'=>'paypal_api_password',
                        'type' => 'text',
                        'title' => __('API Password (required)', 'redux-framework-demo'),
                        'subtitle' => __('', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'default' => ''
                        ),

                    array(
                        'id'=>'paypal_api_signature',
                        'type' => 'text',
                        'title' => __('API Signature (required)', 'redux-framework-demo'),
                        'subtitle' => __('', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'default' => ''
                        ),

                    array(
                        'id'=>'paypal_success',
                        'type' => 'text',
                        'title' => __('Thank you page - after successful payment', 'redux-framework-demo'),
                        'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'validate' => 'url',
                        'default' => ''
                        ),

                    array(
                        'id'=>'paypal_fail',
                        'type' => 'text',
                        'title' => __('Thank you page - after failed payment', 'redux-framework-demo'),
                        'subtitle' => __('This must be an URL.', 'redux-framework-demo'),
                        'desc' => __('', 'redux-framework-demo'),
                        'validate' => 'url',
                        'default' => ''
                        ),

                    array(
                        'id'=>'currency_code',
                        'type' => 'select',
                        'title' => __('Currency', 'redux-framework-demo'), 
                        'subtitle' => __('Select your currency.', 'redux-framework-demo'),
                        'options' => array('AUD'=>'Australian Dollar', 'CAD'=>'Canadian Dollar', 'CZK'=>'Czech Koruna', 'BRL'=>'Brazilian real', 'DKK'=>'Danish Krone', 'EUR'=>'Euro', 'HKD'=>'Hong Kong Dollar', 'HUF'=>'Hungarian Forint', 'JPY'=>'Japanese Yen', 'NOK'=>'Norwegian Krone', 'NZD'=>'New Zealand Dollar', 'PLN'=>'Polish Zloty', 'GBP'=>'Pound Sterling', 'SEK'=>'Swedish Krona', 'SGD'=>'Singapore Dollar', 'CHF'=>'Swiss Franc', 'USD'=>'U.S. Dollar'),
                        'default' => 'USD',
                        ),

                    ),
            );

            $this->sections[] = array(
                'icon' => 'el-icon-usd',
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

            $this->sections[] = array(
                'icon' => 'el-icon-font',
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
                        'output' => array('p'),
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

            $this->sections[] = array(
                'icon' => 'el-icon-adjust',
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

            $this->sections[] = array(
                'icon' => 'el-icon-group',
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

            $this->sections[] = array(
                'icon' => 'el-icon-envelope',
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

            $this->sections[] = array(
                'type' => 'divide',
            );         
            
            $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'redux-framework-demo'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'redux_demo',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('WPJobus Options', 'redux-framework-demo'),
                'page_title'        => __('WPJobus Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

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
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
