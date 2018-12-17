<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_demo";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Classiera Options', 'classiera' ),
        'page_title'           => __( 'Classiera Options', 'classiera' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyAr94kq9EE6JV2JkQav-9spfxnzBZtLT_8',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://joinwebs.co.uk/docs/classiera',
        'title' => __( 'Documentation', 'classiera' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
   
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/joinwebs',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/joinwebs',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/joinwebs',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( 'Welcome To Classiera Classifieds Ads WordPress Theme Options Panel', 'classiera' ), $v );
    } else {
        $args['intro_text'] = __( 'Welcome To Classiera Classifieds Ads WordPress Theme Options Panel', 'classiera' );
    }

    // Add content after the form.
    $args['footer_text'] = __( 'Thanks for using Classiera Options Panel.', 'classiera' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'classiera' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiera' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'classiera' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classiera' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'classiera' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */
    // -> START General Settings 
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'classiera' ),
        'id'               => 'basic-general',
        'icon'             => 'el el-cog',       
        'customizer_width' => '450px',
        'desc'=> __('Classiera General Settings', 'classiera'),
        'fields'           => array(
            array(
                'id'=>'logo',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Logo', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo Recommended image size:150x50', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'favicon',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Favicon', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your favicon.(Recommended image size:16x16)', 'classiera'),
                'subtitle' => __('Upload your favicon', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id' => 'registor-email-verify',
                'type' => 'switch',
                'title' => __('Email Verification on Register', 'classiera'),
                'subtitle' => __('Email Verification', 'classiera'),
                'desc'=> __('If you will turn On This Then User must need to put valid email and then password will be goes to user email inbox. If you will turn OFF this then there is no need for valid email, User can just set password at front-end.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_social_login',
                'type' => 'switch',
                'title' => __('Social Login Area', 'classiera'),
                'subtitle' => __('Social Login On/OFF', 'classiera'),
                'desc'=> __('If you are not using social login and you want to remove message for social login then turn OFF this option', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_pagination',
                'type' => 'radio',
                'title' => __('Select pagination type', 'classiera'),
                'subtitle' => __('Pagination type', 'classiera'),
                'desc' => __('Select pagination or Infinite Scroll', 'classiera'),
                'options' => array('pagination' => 'Pagination', 'infinite' => 'Infinite Scroll'),
                'default' => 'pagination'
            ),
            array(
                'id' => 'backtotop',
                'type' => 'switch',
                'title' => __('Back To Top Button', 'classiera'),
                'desc' => __('If you dont want to use Back To Top Button Then Just Turn OFF This', 'classiera'),
                'subtitle' => __('Turn On/OFF Back To Top', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_no_of_ads_all_page',
                'type' => 'text',
                'title' => __('Ads Count on All Ads Page', 'classiera'),
                'subtitle' => __('Put Number', 'classiera'),
                'desc' => __('How Many Ads you want to shown on All Ads Page', 'classiera'),
                'default' => '12'
            ),
            array(
                'id'=>'classiera_no_of_cats_all_page',
                'type' => 'text',
                'title' => __('Categories Count on All Categories Page', 'classiera'),
                'subtitle' => __('Put Number', 'classiera'),
                'desc' => __('How Many Categories you want to shown on All Categories Page', 'classiera'),
                'default' => '12'
            ),          
            array(
                'id' => 'newusernotification',
                'type' => 'switch',
                'title' => __('Email to Admin on Sign-up New User', 'classiera'),
                'subtitle' => __('Would You like to receive email?', 'classiera'),
                'desc' => __('If You want to receive Email on new user registration Please Turn On This option.', 'classiera'),
                'default' => 2,
            ),
            array(
                'id'=>'tags_limit',
                'type' => 'text',
                'title' => __('Number of tags in tag Cloud widget', 'classiera'),
                'subtitle' => __('Number of tags in tag Cloud widget', 'classiera'),
                'desc' => __('Put here a number. Example "16"', 'classiera'),
                'default' => '15'
            ),
            array(
                'id' => 'footer_widgets_area_on',
                'type' => 'switch',
                'title' => __('Footer Widgets Area On/OFF', 'classiera'),
                'subtitle' => __('Footer Widgets Area On/OFF', 'classiera'),
                'desc' => __('If You dont want to use widgets in footer then just turn off.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'footer_copyright',
                'type' => 'text',
                'title' => __('Footer Copyright Text', 'classiera'),
                'subtitle' => __('Footer Copyright Text', 'classiera'),
                'desc' => __('You can add text and HTML in here.', 'classiera'),
                'default' => 'All copyrights reserved &copy; 2015 - Design &amp; Development by <a href="http://joinwebs.com">Joinwebs'
            ),
            array(
                'id'=>'classiera_footer_logo',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Footer Logo', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo for footer Recommended image size:150x50', 'classiera'),
                'subtitle' => __('Upload Footer logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'classiera_email_logo',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Email LOGO Image', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your email header logo image size:200x60', 'classiera'),
                'subtitle' => __('Upload header logo for email', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'classiera_email_header_img',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Email Header Image', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your email header image size:900x180', 'classiera'),
                'subtitle' => __('Upload header for email', 'classiera'),
                'default'=>array('url'=>''),
            ),
        )
    ) );
    
    // -> START HomePage Settings 
    Redux::setSection( $opt_name, array(
        'title'            => __( 'HomePage Settings', 'classiera' ),
        'id'               => 'homepagesections',
        'desc'             => __( 'Manage All HomePage Sections!', 'classiera' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-dashboard'
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home General Settings', 'classiera' ),
        'id'               => 'basic-home',
        'icon'             => 'el el-home-alt',
        'subsection' => true,
        'customizer_width' => '500px',        
        'desc'=> __('Home General settings of Classiera', 'classiera'),
        'fields'           => array(           
           array(
                'id'=>'home-cat-counter',
                'type' => 'text',
                'title' => __('How many Categories on homepage?', 'classiera'),
                'subtitle' => __('Categories on homepage', 'classiera'),
                'desc' => __('Categories on homepage', 'classiera'),
                'default' => '6'
            ),
            array(
                'id'=>'classiera_cat_menu_count',
                'type' => 'text',
                'title' => __('How many Categories Cat Menu', 'classiera'),
                'subtitle' => __('Cat Menu Bar', 'classiera'),
                'desc' => __('Categories Menu Bar on homepage V4 and Landing Page', 'classiera'),               
                'default' => '6'
            ),
            array(
                'id' => 'classiera_cat_post_counter',
                'type' => 'switch',
                'title' => __('Post Counter on Category Box', 'classiera'),
                'subtitle' => __('Post Count on Category box On/OFF', 'classiera'),
                'desc' => __('If You want to hide count from category box then turn OFF this option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_loc_post_counter',
                'type' => 'switch',
                'title' => __('Post Counter with Location', 'classiera'),
                'subtitle' => __('Locations Post Count On/OFF', 'classiera'),
                'desc' => __('If You want to hide count from location box then turn OFF this option.', 'classiera'),
                'default' => true,
            ),
            array(
                'id'=>'home-ads-counter',
                'type' => 'text',
                'title' => __('How many Ads Regular on homepage?', 'classiera'),
                'subtitle' => __('Ads on homepage', 'classiera'),
                'desc' => __('Ads on homepage', 'classiera'),
                'default' => '6'
            ),
            array(
                'id'=>'classiera_featured_ads_count',
                'type' => 'text',
                'title' => __('How many Featured Ads on homepage', 'classiera'),
                'subtitle' => __('Ads on homepage', 'classiera'),
                'desc' => __('All Ads section on home page', 'classiera'),
                'default' => '6'
            ),
            array(
                'id'=>'home-location-counter',
                'type' => 'text',
                'title' => __('How many Locations on homepage?', 'classiera'),
                'subtitle' => __('Put a number count', 'classiera'),
                'desc' => __('How many locations you want to show on homepage, put a number like (5, 10 , 15) etc.', 'classiera'),          
                'default' => '6'
            ),
            array(
                'id'=>'home-ads-view',
                'type' => 'radio',
                'title' => __('Select Ads view type', 'classiera'),
                'subtitle' => __('Ads view type', 'classiera'),
                'desc' => __('Ads view type', 'classiera'),
                'options' => array('grid' => 'Grid view', 'list' => 'List view'),
                'default' => 'grid'
            ),      
            array(
                'id'=>'locations-sec-title',
                'type' => 'text',
                'title' => __('Locations title', 'classiera'),
                'subtitle' => __('Locations title', 'classiera'),
                'desc' => __('Put here locations title.', 'classiera'),
                'default' => 'Ads Locations'
            ),
            array(
                'id'=>'locations-desc',
                'type' => 'textarea',
                'title' => __('Locations title description', 'classiera'),
                'subtitle' => __('Locations title description', 'classiera'),
                'desc' => __('Put here location sub title.', 'classiera'),
                'default' => 'Classiera provided you a ads location section where you can add your desired locations there is no limit for the locations so do it as you would like to. '
            ),
            array(
                'id'=>'plans-title',
                'type' => 'text',
                'title' => __('Plans title', 'classiera'),
                'subtitle' => __('Plans title', 'classiera'),
                'desc' => __('Put here Plans title.', 'classiera'),
                'default' => 'Find a plan that&#44;s right for you'
            ),
            array(
                'id'=>'plans-desc',
                'type' => 'textarea',
                'title' => __('Plans title description', 'classiera'),
                'subtitle' => __('Plans title description', 'classiera'),
                'desc' => __('Put here plan sub title.', 'classiera'),
                'default' => 'A advertisement section where we have two types of ads listing one with grids and the other one with list view latest ads, popular ads & random ads also featured ads wil show below.'
            ),
            array(
                'id'=>'classiera_plans_bg',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Pricing Plans Background', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload Pricing Plans Background Image Recommended size: 1600x710', 'classiera'),
                'subtitle' => __('Upload Plans BG', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'ad-desc',
                'type' => 'textarea',
                'title' => __('Advertisement title description', 'classiera'),
                'subtitle' => __('Advertisement title description', 'classiera'),
                'desc' => __('Put here Advertisement sub title.', 'classiera'),
                'default' => 'A advertisement section where we have two types of ads listing one with grids and the other one with list view latest ads, popular ads & random ads also featured ads will show below.. '
            ),
            array(
                'id'=>'cat-sec-title',
                'type' => 'text',
                'title' => __('Categories Section Title', 'classiera'),
                'subtitle' => __('Categories Section Title', 'classiera'),
                'desc' => __('Put Categories Section Title here..', 'classiera'),
                'default' => 'Ads categories'
            ),
            array(
                'id'=>'cat-sec-desc',
                'type' => 'textarea',
                'title' => __('Categories Section Description', 'classiera'),
                'subtitle' => __('Categories Section Description', 'classiera'),
                'desc' => __('Put Categories Section Description here..', 'classiera'),
                'default' => 'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor'
            ),      
        )
    ) );    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Static Banner settings', 'classiera' ),
        'id'         => 'StaticBannersettings',
        'icon'             => 'el el-screen',
        'subsection' => true,
        'desc' => __('If You are using Image Slider on you HomePage Then you need to setup from here.)', 'classiera'), 
        'fields'     => array(
            array(
                'id'       => 'classiera_header_bg',
                'type'     => 'background',
                'title'    => __('Header Banner Background', 'classiera'),
                'subtitle' => __('Header Banner Background, color, etc.', 'classiera'),
                'desc'     => __('If you want to use image then dont select color just upload image banner Size: width:1600px and height 733px', 'classiera'),
                'default'  => array(
                    'background-color' => '#fff',
                    'background-image' => '',
                    'background-repeat' => '',
                    'background-position' => '',
                    'background-size' => '',
                    'background-attachment' => '',
                ),           
            ),
            array(
                'id'=>'homepage-v2-title',
                'type' => 'text',
                'title' => __('HomePage Header First Heading', 'classiera'),
                'subtitle' => __('HomePage Header First Heading', 'classiera'),
                'desc' => __('Put Header Title Here Note: This Title will work with HomePage V2,V3,V4', 'classiera'),
                'default' => 'WELCOME TO CLASSIERA'
            ),          
            array(
                'id'=>'homepage-v2-desc',
                'type' => 'textarea',
                'title' => __('HomePage Header Description', 'classiera'),
                'subtitle' => __('HomePage Header Description', 'classiera'),
                'desc' => __('Put Header Description Here Note: This Title will work with HomePage V2,V3,V4', 'classiera'),
                'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard1500s'
            ),
            
            array(
                'id'       => 'classiera_banner_heading_typography',
                'type'     => 'typography',
                'title'    => __( 'Header First Heading Font Settings', 'classiera' ),
                'subtitle' => __( 'Specify the font settings properties.', 'classiera' ),
                'letter-spacing'=> true,
                'google'   => true,
                'default'  => array(
                    'color'       => '#fff',
                    'font-size'   => '60px',
                    'font-family' => 'Raleway,sans-serif',
                    'font-weight' => '700',
                    'line-height' => '60px',
                    'text-align' => '',
                    'letter-spacing' => '',
                ),              
            ),
            array(
                'id'       => 'classiera_banner_desc_typography',
                'type'     => 'typography',
                'title'    => __( 'Header Description Font Settings', 'classiera' ),
                'subtitle' => __( 'Specify the font settings properties.', 'classiera' ),
                'letter-spacing'=> true,
                'google'   => true,
                'default'  => array(
                    'color'       => '#fff',
                    'font-size'   => '24px',
                    'font-family' => 'Raleway,sans-serif',
                    'font-weight' => '400',
                    'line-height' => '24px',
                    'text-align' => '',
                    'letter-spacing' => '',
                ),              
            ),
        )
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Call To Action', 'classiera' ),
        'id'         => 'call-to-section',
        'icon'             => 'el el-asl',
        'subsection' => true,
        'desc' => __('Manage Process Call To Action on homepage, If you are not using Call To Action section then no need to do anything here', 'classiera'), 
        'fields'     => array(  
        array(
            'id'=>'classiera_call_to_action_background',
            'type' => 'media', 
            'url'=> true,
            'title' => __('CTA Background', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload your CTA Background', 'classiera'),
            'subtitle' => __('Upload CTA Background', 'classiera'),
            'default'=>array('url'=>''),
            ),  
        array(
            'id'=>'classiera_call_to_action_about_icon',
            'type' => 'media', 
            'url'=> true,
            'title' => __('CTA About Icon', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload your CTA About Icon', 'classiera'),
            'subtitle' => __('Upload CTA About Icon', 'classiera'),
            'default'=>array('url'=>''),
            ),  
        array(
            'id'=>'classiera_call_to_action_about',
            'type' => 'text',
            'title' => __('Call To Action Title ', 'classiera'),
            'subtitle' => __('Call To Action Title', 'classiera'),
            'desc' => __('Put Homepage Call To Action Title', 'classiera'),
            'default' => 'About Us'
            ),
        array(
            'id'=>'classiera_call_to_action_about_desc',
            'type' => 'textarea',
            'title' => __('Homepage CTA Description ', 'classiera'),
            'subtitle' => __('CTA Description', 'classiera'),
            'desc' => __('Put Homepage CTA Description', 'classiera'),
            'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
            ),
        array(
            'id'=>'classiera_call_to_action_sell_icon',
            'type' => 'media', 
            'url'=> true,
            'title' => __('CTA Sell Icon', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload your CTA Sell Icon', 'classiera'),
            'subtitle' => __('Upload CTA Sell Icon', 'classiera'),
            'default'=>array('url'=>''),
            ),
        array(
            'id'=>'classiera_call_to_action_sell',
            'type' => 'text',
            'title' => __('CTA Sell Title ', 'classiera'),
            'subtitle' => __('CTA SELL Title', 'classiera'),
            'desc' => __('Put Homepage CTA SELL Title', 'classiera'),
            'default' => 'Sell Safely'
            ),
        array(
            'id'=>'classiera_call_to_action_sell_desc',
            'type' => 'textarea',
            'title' => __('Homepage CTA sell Description ', 'classiera'),
            'subtitle' => __('CTA sell Description', 'classiera'),
            'desc' => __('Put Homepage CTA sell Description', 'classiera'),
            'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
            ),
        array(
            'id'=>'classiera_call_to_action_buy_icon',
            'type' => 'media', 
            'url'=> true,
            'title' => __('CTA Buy Icon', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload your CTA Buy Icon', 'classiera'),
            'subtitle' => __('Upload CTA Buy Icon', 'classiera'),
            'default'=>array('url'=>''),
            ),  
        array(
            'id'=>'classiera_call_to_action_buy',
            'type' => 'text',
            'title' => __('Homepage CTA Buy Title ', 'classiera'),
            'subtitle' => __('CTA Buy Title', 'classiera'),
            'desc' => __('Put Homepage CTA Buy Title', 'classiera'),
            'default' => 'Buy Safely'
            ),
        array(
            'id'=>'classiera_call_to_action_buy_desc',
            'type' => 'text',
            'title' => __('Homepage CTA Buy Description ', 'classiera'),
            'subtitle' => __('CTA Buy Description', 'classiera'),
            'desc' => __('Put Homepage CTA Buy Description', 'classiera'),
            'default' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventor. '
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Callout Message', 'classiera' ),
        'id'         => 'basic-callout',
        'icon'             => 'el el-bullhorn',
        'subsection' => true,
        'desc'=> __('Callout Message For Home page', 'classiera'),
        'fields'     => array(
            array(
                'id' => 'classiera_parallax',
                'type' => 'switch',
                'title' => __('Parallax effect', 'classiera'),
                'subtitle' => __('Turn On/OFF', 'classiera'),
                'desc' => __('Turn On/OFF Parallax effect, this effect will work on (strobe, coral, canary)', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'callout-bg',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Callout Background', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Image.', 'classiera'),
                'subtitle' => __('Callout Background', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'callout-bg-version2',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Callout Small Image', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('This Image will be shown On HomePage v2,v3,v4 Image Size: 435px, 360px', 'classiera'),
                'subtitle' => __('Callout Small Image', 'classiera'),
                'default'=>array('url'=>''),
            ),  
            array(
                'id'=>'callout_title',
                'type' => 'text',
                'title' => __(' Callout Title', 'classiera'),
                'desc'=> __('Put here your Callout title', 'classiera'),
                'subtitle' => __('Callout Title', 'classiera'),
                'default'=>'ARE YOU READY',
            ),
            array(
                'id'       => 'classiera_title_color',
                'type'     => 'color',
                'title'    => __('Callout Title Color', 'classiera'), 
                'subtitle' => __('Pick a text color default: #ffffff.', 'classiera'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'=>'callout_title_second',
                'type' => 'text',
                'title' => __(' Callout second Title', 'classiera'),
                'desc'=> __('Put here your Callout Second title', 'classiera'),
                'subtitle' => __('Callout second Title', 'classiera'),
                'default'=>'FOR THE POSTING YOUR ADS ON <span>&quot;ClassiEra?&quot;</span>',
            ),
            array(
                'id'       => 'classiera_second_title_color',
                'type'     => 'color',
                'title'    => __('Callout second title text Color', 'classiera'), 
                'subtitle' => __('Pick a Color default: #ffffff.', 'classiera'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'=>'callout_desc',
                'type' => 'textArea',
                'title' => __(' Callout Description', 'classiera'),
                'desc'=> __('Put here your Callout Description', 'classiera'),
                'subtitle' => __('Callout Description', 'classiera'),
                'default'=>'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor..',
            ),
            array(
                'id'       => 'classiera_desc_color',
                'type'     => 'color',
                'title'    => __('Callout description Color', 'classiera'), 
                'subtitle' => __('Pick a Color for callout description text default: #ffffff.', 'classiera'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'=>'callout_btn_text',
                'type' => 'text',
                'title' => __(' Callout Button Text', 'classiera'),
                'desc'=> __('Put here your Callout Button Text', 'classiera'),
                'subtitle' => __('Callout Button Text', 'classiera'),
                'default'=>'Get Started ',
            ),
            array(
                'id'=>'callout_btn_icon_code',
                'type' => 'text',
                'title' => __('Callout First Button icon', 'classiera'),
                'desc'=> __('Put icon code from font awsome, This code is only work on Home V1 and Home V2.', 'classiera'),
                'default'=>'fa fa-plus-circle',
            ),
            array(
                'id'=>'callout_btn_url',
                'type' => 'text',
                'title' => __(' Callout Button URL', 'classiera'),
                'desc'=> __('Put here your Callout Button URL', 'classiera'),
                'subtitle' => __('Callout Button URL', 'classiera'),
                'validate' => 'url',
                'default'=>'',
            ),
            array(
                'id'=>'callout_btn_text_two',
                'type' => 'text',
                'title' => __(' Callout Second Button Text', 'classiera'),
                'desc'=> __('Put here your Second Callout Button Text', 'classiera'),
                'subtitle' => __('Callout Button Text', 'classiera'),
                'default'=>'Get Started ',
            ),
            array(
                'id'=>'callout_btn_icon_code_two',
                'type' => 'text',
                'title' => __('Callout Second Button icon', 'classiera'),
                'desc'=> __('Put icon code from font awsome, This code is only work on Home V1 and Home V2.', 'classiera'),             
                'default'=>'fa fa-shopping-cart',
            ),
            array(
                'id'=>'callout_btn_url_two',
                'type' => 'text',
                'title' => __(' Callout Second Button URL', 'classiera'),
                'desc'=> __('Put here your Second Callout Button URL', 'classiera'),
                'subtitle' => __('Callout Button URL', 'classiera'),
                'validate' => 'url',
                'default'=>'',
            ),
        )
    ) );
    // -> START Search Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Search Setting', 'classiera' ),
        'id'               => 'classiera_search',
        'customizer_width' => '500px',
        'subsection' => true,
        'icon'             => 'el el-search',
        'desc'  => __( 'Search Page Setting', 'classiera' ),
        'fields'     => array(
            array(
                'id'=>'classiera_max_price_input',
                'type' => 'text',
                'title' => __('Max Price', 'classiera'),
                'subtitle' => __('Put Value', 'classiera'),
                'desc' => __('Max Price Value for Advance Search', 'classiera'),
                'default' => '100000'
            ),
            array(
                'id' => 'classiera_search_location_on_off',
                'type' => 'switch',
                'title' => __('Location from search Bar', 'classiera'),
                'subtitle' => __('Turn On/OFF', 'classiera'),
                'desc' => __('Turn On/OFF Location from Search Bar', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_search_location_type',
                'type' => 'radio',
                'title' => __('Select locations type', 'classiera'),
                'subtitle' => __('Locations type in header', 'classiera'),
                'desc' => __('Drop-down or input select what you want to show.', 'classiera'),
                'options' => array('dropdown' => 'Dropdown', 'input' => 'Text Input'),
                'default' => 'input'
            ),
            array(
                'id'=>'location-shown-by',
                'type' => 'select',
                'title' => __('Select Location Shown by', 'classiera'),
                'subtitle' => __('Location Shown by', 'classiera'),
                'desc' => __('Location Section Shown by City or States or Country?', 'classiera'),
                'options' => array('post_location' => 'Country', 'post_state' => 'States', 'post_city' =>'City'),
                'default' => 'post_city'
            ),
            array(
                'id' => 'classiera_pricerange_on_off',
                'type' => 'switch',
                'title' => __('Price Range From Search', 'classiera'),
                'subtitle' => __('Turn On/OFF', 'classiera'),
                'desc' => __('Turn On/OFF Price Range from Search Result Page', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_pricerange_style',
                'type' => 'radio',
                'title' => __('Select Price range style', 'classiera'),
                'subtitle' => __('Search style in advanced search.', 'classiera'),
                'desc' => __('This will only work in advanced search sidebar.', 'classiera'),
                'options' => array('slider' => 'Price Range Slider with radio', 'input' => 'Min and Max Price input'),
                'default' => 'slider'
            ),
            array(
                'id' => 'classiera_adv_search_on_cats',
                'type' => 'switch',
                'title' => __('Advanced Search on Categories page', 'classiera'),
                'subtitle' => __('Turn On/OFF', 'classiera'),
                'desc' => __('Turn On/OFF Advanced search from categories page.', 'classiera'),
                'default' => 1,
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Blogs', 'classiera' ),
        'id'    => 'classiera_blogs',
        'subsection' => true,
        'desc'  => __( 'Manage Blog section On HomePage', 'classiera' ),
        'icon'  => 'el el-question',
        'fields' => array(
            array(
                'id'=>'classiera_blog_section_title',
                'type' => 'text',
                'title' => __('Blog Section Title', 'classiera'),
                'subtitle' => __('Replace text', 'classiera'),
                'desc' => __('Change blog section title from homepage.', 'classiera'),
                'default' => 'Latest From Blog'
            ),
            array(
                'id'=>'classiera_blog_section_desc',
                'type' => 'textarea',
                'title' => __('Blog Section Description', 'classiera'),
                'subtitle' => __('Replace text', 'classiera'),
                'desc' => __('Change blog section Description from homepage.', 'classiera'),
                'default' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable.'
            ),
            array(
                'id'=>'classiera_blog_section_count',
                'type' => 'text',
                'title' => __('How Many Post', 'classiera'),
                'subtitle' => __('Post Count', 'classiera'),
                'desc' => __('How many posts you want to shown in blog section on homepage?', 'classiera'),
                'default' => '6'
            ),
            array(
                'id'=>'classiera_blog_section_post_order',
                'type' => 'radio',
                'title' => __('Blog Section Post Order', 'classiera'), 
                'subtitle' => __('orderby', 'classiera'),               
                'options' => array('title' => 'Order by title','name' => 'Order by name','date' => 'Order by date','rand' => 'Order by random'),//Must provide key => value pairs for radio options
                'default' => 'title'
            ),
            array(
                'id'=>'classiera_blog_post_order',
                'type' => 'radio',
                'title' => __('Blog Post Order', 'classiera'), 
                'subtitle' => __('Order', 'classiera'),             
                'options' => array('ASC' => 'Order by ASC','DESC' => 'Order by DESC'),//Must provide key => value pairs for radio options
                'default' => 'DESC'
            ),
        )
    ) );
    // -> START Layout Manager
     Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Manager', 'classiera' ),
        'id'               => 'layoutmanager',
        'desc'             => __( 'Home Page and Landing Page Manager', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-align-justify'
    ) );
    // -> START Home Layout Manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Utilities', 'classiera' ),
        'id'               => 'classiera_design_settings',
        'subsection' => true,
        'desc'  => __( 'From This section you can select Layout Design.', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-brush',
        'fields'     => array(          
            array(
                'id'=>'nav-style',
                'type' => 'radio',
                'title' => __('Nav Styles', 'classiera'), 
                'subtitle' => __('Nav Styles', 'classiera'),
                'desc' => __('Nav Styles', 'classiera'),
                'options' => array('1' => 'Version 1(Lime)', '2' => 'Version 2(Strobe)', '3' => 'Version 3(Coral)', '4' => 'Version 4(Canary)', '5' => 'Version 5(IVY)', '6' => 'Version 6(IRIS)', '7' => 'Version 7(Allure)'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id' => 'classiera_sticky_nav',
                'type' => 'switch',
                'title' => __('Sticky Navbar', 'classiera'),
                'subtitle' => __('On/OFF', 'classiera'),
                'desc'=> __('Turn OFF this option if you dont need sticky navbar.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_search_style',
                'type' => 'radio',
                'title' => __('Search Styles', 'classiera'), 
                'subtitle' => __('Select Styles', 'classiera'),
                'desc' => __('Selection Will work on all pages other then homepage, on homepage search bar will be used from template', 'classiera'),
                'options' => array('1' => 'Version 1(Lime)', '2' => 'Version 2(Strobe)', '3' => 'Version 3(Coral)', '4' => 'Version 4(Canary)', '5' => 'Version 5(IVY)', '6' => 'Version 6(IRIS)', '7' => 'Version 7(Allure)'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id'=>'classiera_premium_style',
                'type' => 'radio',
                'title' => __('Premium Styles', 'classiera'), 
                'subtitle' => __('Select Styles', 'classiera'),
                'desc' => __('Selection Will work on all pages other then homepage, on homepage Design will be used from template', 'classiera'),
                'options' => array('1' => 'Version 1(Lime)', '2' => 'Version 2(Strobe)', '3' => 'Version 3(Coral)', '4' => 'Version 4(IVY)', '5' => 'Version 5(IRIS)', '6' => 'Version 6(Allure)'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id'=>'classiera_cat_style',
                'type' => 'radio',
                'title' => __('Categories Styles', 'classiera'), 
                'subtitle' => __('Select Styles', 'classiera'),
                'desc' => __('Selection Will work on all pages other then homepage, on homepage Design will be used from template', 'classiera'),
                'options' => array('1' => 'Version 1(Lime)', '2' => 'Version 2(Strobe)', '3' => 'Version 3(Coral)', '4' => 'Version 4(Canary)', '5' => 'Version 5(IVY)', '6' => 'Version 6(IRIS)', '7' => 'Version 7(Allure)'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id'=>'classiera_cat_icon_img',
                'type' => 'radio',
                'title' => __('Categories Icons', 'classiera'), 
                'subtitle' => __('Select Type for categories Icon', 'classiera'),
                'desc' => __('You want to show categories icons from font awesome or you have your own images icon?', 'classiera'),
                'options' => array('icon' => 'Font Awesome Icons', 'img' => 'Custom Images Icon'),//Must provide key => value pairs for radio options
                'default' => 'icon'
            ),          
            array(
                'id'=>'classiera_single_ad_style',
                'type' => 'radio',
                'title' => __('Single Ad Page', 'classiera'), 
                'subtitle' => __('Select Styles', 'classiera'),
                'desc' => __('Select Style for Single Ads Page', 'classiera'),
                'options' => array('1' => 'Version 1', '2' => 'Version 2'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            
            array(
                'id'=>'classiera_author_page_style',
                'type' => 'radio',
                'title' => __('Author Page Style', 'classiera'), 
                'subtitle' => __('Select Style', 'classiera'),
                'desc' => __('Select Style for Author Public Profile Page.', 'classiera'),
                'options' => array('fullwidth' => 'Full Width', 'sidebar' => 'With Sidebar'),//Must provide key => value pairs for radio options
                'default' => 'fullwidth'
            ),
            array(
                'id'=>'classiera_footer_style',
                'type' => 'radio',
                'title' => __('Footer Style', 'classiera'), 
                'subtitle' => __('Select Style', 'classiera'),
                'desc' => __('Select Style for Footer', 'classiera'),
                'options' => array('three' => 'Three Column', 'four' => 'Four Column'),//Must provide key => value pairs for radio options
                'default' => 'three'
            ),
            array(
                'id'=>'classiera_footer_bottom_style',
                'type' => 'radio',
                'title' => __('Footer bottom Style', 'classiera'), 
                'subtitle' => __('Select Style', 'classiera'),
                'desc' => __('Select what you want to show in footer bottom Menu or social Icons', 'classiera'),
                'options' => array('menu' => 'Menu', 'icon' => 'Social Icon'),//Must provide key => value pairs for radio options
                'default' => 'menu'
            ),
            array(
                'id' => 'classiera_categories_desc',
                'type' => 'switch',
                'title' => __('Categories description', 'classiera'),
                'subtitle' => __('On/OFF', 'classiera'),
                'desc'=> __('If you want to show category description on category page then turn On this option.', 'classiera'),
                'default' => 0,
            ),          
        )
    ) );
    // -> START Home Layout Manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Layout Manager', 'classiera' ),
        'id'               => 'homelayoutmanager',
        'subsection' => true,
        'desc'  => __( 'These Settings will work only on HomePage Version 1, If you want to disable any section just drag to Disable section.', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-home-alt',
        'fields'     => array(
            array(
                'id'       => 'opt-homepage-layout',
                'type'     => 'sorter',
                'title'    => 'Homepage Layout Manager(Lime)',
                'desc'     => 'Organize how you want the layout to appear on the homepage',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'googlemap' => 'Google MAP',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'searchv1' => 'Search Bar',
                        'premiumslider'   => 'Premium Ads Slider',                       
                        'categories'   => 'Categories',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'advertisement'   => 'Advertisement',
                        'packages'   => 'Pricing Plans',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v2',
                'type'     => 'sorter',
                'title'    => 'Homepage V2 Layout Manager(Strobe)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V2',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
                        'customads'   => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'googlemap' => 'Google MAP',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'searchv2' => 'Search Bar',
                        'premiumslider'   => 'Premium Ads Slider',
                        'categories'   => 'Categories',
                        'advertisement'   => 'Advertisement',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'packages'   => 'Pricing Plans',
                        'partners'   => 'Partners', 
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v3',
                'type'     => 'sorter',
                'title'    => 'Homepage V3 Layout Manager(Coral)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V3',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'googlemap' => 'Google MAP',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(  
                        'layerslider' => 'LayerSlider',
                        'searchv3' => 'Search Bar',
                        'premiumslider'   => 'Premium Ads Slider',
                        'categories'   => 'Categories',
                        'advertisement'   => 'Advertisement',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'packages'   => 'Pricing Plans',
                        'partners'   => 'Partners', 
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v4',
                'type'     => 'sorter',
                'title'    => 'Homepage V4 Layout Manager (Canary)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V4',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'googlemap' => 'Google MAP',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'categoriesmenu'   => 'Categories Bar',
                        'layerslider' => 'LayerSlider',
                        'searchv4' => 'Search Bar',
                        'categories'   => 'Categories',
                        'advertisement'   => 'Advertisement',
                        'callout'   => 'Callout',
                        'packages'   => 'Pricing Plans',                        
                        'blogs'   => 'Blog Section',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v5',
                'type'     => 'sorter',
                'title'    => 'Homepage V5 Layout Manager (IVY)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V5',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
                        'customads' => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'googlemap' => 'Google MAP',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'searchv5' => 'Search Bar',
                        'banner' => 'Image Slider',
                        'premiumslider'   => 'Premium Ads Slider',
                        'categories'   => 'Categories',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'advertisement'   => 'Advertisement',
                        'packages'   => 'Pricing Plans',
                        'blogs'   => 'Blog Section',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v6',
                'type'     => 'sorter',
                'title'    => 'Homepage V6 Layout Manager (IRIS)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V6',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
                        'customads' => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'banner' => 'Big Slider',
                        'premiumslider'   => 'Premium Ads Slider',
                        'categories'   => 'Categories',
                        'advertisement'   => 'Advertisement',
                        'callout'   => 'Callout',
                        'location'   => 'Location',                     
                        'packages'   => 'Pricing Plans',
                        'blogs'   => 'Blog Section',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
            array(
                'id'       => 'opt-homepage-layout-v7',
                'type'     => 'sorter',
                'title'    => 'Homepage V7 Layout Manager (Allure)',
                'desc'     => 'Organize how you want the layout to appear on the homepage V7',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                        
                        'customads' => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'banner' => 'Big Slider',
                        'premiumslider'   => 'Premium Ads Slider',
                        'categories'   => 'Categories',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'advertisement'   => 'Advertisement',
                        'packages'   => 'Pricing Plans',
                        'blogs'   => 'Blog Section',
                        'partners'   => 'Partners',
                    ),
                ),
            ),
        )
    ) );
    // -> START Landing Page
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Landing Page Manager', 'classiera' ),
        'id'               => 'landingpagemanager',
        'subsection' => true,
        'desc'  => __( 'These Settings will work only Landing Page, Now you can use any section on Landing Page.', 'classiera' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-home-alt',
        'fields'     => array(
            array(
                'id'       => 'opt-homepage-layout-landing',
                'type'     => 'sorter',
                'title'    => 'Landing Page Layout Manager',
                'desc'     => 'Organize how you want the layout to appear on the Landing Page',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array( 
                        'navcategories' => 'Nav Categories Canary',
                        'imgslider1' => 'Image Slider IVY',
                        'imgslider2' => 'Image Slider IRIS',
                        'imgslider3' => 'Image Slider Allure',
                        'googlemap' => 'Google MAP',
                        'searchv2' => 'Search Strobe',
                        'searchv3' => 'Search Coral',
                        'searchv4' => 'Search Canary',
                        'searchv5' => 'Search IVY',
                        'searchv6' => 'Search IRIS',
                        'searchv7' => 'Search Allure',
                        'premiumslider2'   => 'Premium Ads Strobe',
                        'premiumslider3'   => 'Premium Ads Coral',
                        'premiumslider4'   => 'Premium Ads IVY',
                        'premiumslider5'   => 'Premium Ads IRIS',
                        'premiumslider6'   => 'Premium Ads Allure',
                        'categories2'   => 'Categories Strobe',
                        'categories3'   => 'Categories Coral',
                        'categories4'   => 'Categories Canary',
                        'categories5'   => 'Categories IVY',
                        'categories6'   => 'Categories IRIS',
                        'categories7'   => 'Categories Allure',
                        'advertisement2'   => 'Advertisement Strobe',       
                        'advertisement3'   => 'Advertisement Coral',        
                        'advertisement4'   => 'Advertisement Canary',       
                        'advertisement5'   => 'Advertisement IVY',      
                        'advertisement6'   => 'Advertisement IRIS',     
                        'advertisement7'   => 'Advertisement Allure',
                        'locationv2'   => 'Location Strobe',
                        'locationv3'   => 'Location Coral',
                        'locationv4'   => 'Location IVY',
                        'locationv5'   => 'Location IRIS - Allure',
                        'plans2'   => 'Pricing Plans Strobe',
                        'plans3'   => 'Pricing Plans Coral',
                        'plans4'   => 'Pricing Plans Canary',
                        'plans5'   => 'Pricing Plans IVY',
                        'plans6'   => 'Pricing Plans IRIS',
                        'plans7'   => 'Pricing Plans Allure',
                        'callout2'   => 'Callout Strobe',
                        'callout3'   => 'Callout Coral',
                        'callout4'   => 'Callout Canary',
                        'callout5'   => 'Callout IVY',
                        'callout6'   => 'Callout IRIS',
                        'callout7'   => 'Callout Allure',
                        'partners2'   => 'Partners Style 2',
                        'partners3'   => 'Partners Style 3',
                        'partners4'   => 'Partners Style 4',
                        'partners5'   => 'Partners Style 5',
                        'partners6'   => 'Partners Style 6',
                        'blogs2'   => 'Blog Style 2',
                        'blogs3'   => 'Blog Style 3',
                        'blogs4'   => 'Blog Style 4',
                        'customads' => 'Banner ads',
                        'customads2'   => 'Banner ads 2',
                        'customads3'   => 'Banner ads 3',
                        'contentsection'   => 'Content section (HTML)',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'searchv1' => 'Search Lime',
                        'premiumslider1'   => 'Premium Ads Lime',
                        'categories1'   => 'Categories Lime',
                        'advertisement1'   => 'Advertisement Lime',
                        'locationv1'   => 'Location Lime',
                        'plans1'   => 'Pricing Plans Lime',
                        'callout1'   => 'Callout Style Lime',
                        'partners1'   => 'Partners Lime',
                        'blogs1'   => 'Blog Style 1',
                    ),
                ),
            ),
        )
    ) );

    // -> START "Get Credits" page manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Get Credits Settings', 'classiera' ),
        'id'               => 'classiera_get_credits_settings',
        'subsection' => false,
        'desc'  => __( 'Update "Get Credits" page settings', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-brush',
        'fields'     => array(          
            array(
                'id'=>'get-credits-heading',
                'type' => 'text',
                'title' => __('"Get Credits" Heading', 'classiera'), 
                'subtitle' => __('Update "Get Credits" page heading', 'classiera'),
                'desc' => __('Heading Text', 'classiera'),
            ),
            array(
                'id'=>'get-credits-body-text',
                'type' => 'textarea',
                'title' => __('"Get Credits" Body Text', 'classiera'), 
                'subtitle' => __('Update "Get Credits" page body text', 'classiera'),
                'desc' => __('Body Text', 'classiera'),
            ),
        )
    ) );

    // -> START "New Ads" page manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'My Ads Settings', 'classiera' ),
        'id'               => 'classiera_my_ads_settings',
        'subsection' => false,
        'desc'  => __( 'Update "My Ads" page settings', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-brush',
        'fields'     => array(          
            array(
                'id'=>'my-ads-heading',
                'type' => 'text',
                'title' => __('"My Ads" Heading', 'classiera'), 
                'subtitle' => __('Update "My Ads" page heading', 'classiera'),
                'desc' => __('Heading Text', 'classiera'),
            ),
            array(
                'id'=>'my-ads-body-text',
                'type' => 'textarea',
                'title' => __('"My Ads" Body Text', 'classiera'), 
                'subtitle' => __('Update "My Ads" page body text', 'classiera'),
                'desc' => __('Body Text', 'classiera'),
            ),
            array(
            'id'=>'ads-length',
            'type' => 'multi_text',
            'title' => __('Ads Length only in number', 'classiera'),
            'subtitle' => __('update and add ads Length)', 'classiera'),
            'desc' => __('manage ads Length', 'classiera')
            ),
            array(
            'id'=>'ads-length-price',
            'type' => 'multi_text',
            'title' => __('Ads Length price only in number', 'classiera'),
            'subtitle' => __('update and add ads Length price)', 'classiera'),
            'desc' => __('manage ads Length price', 'classiera')
            ),
        )
    ) );

    // -> START "Adverts types" page manager
         Redux::setSection( $opt_name, array(
        'title'            => __( 'Advert Types', 'classiera' ),
        'id'               => 'adstyper',
        'desc'             => __( 'Manage Advert Types', 'classiera' ),
        'customizer_width' => '600px',
    ) );
    // -> START Standard Size Advert
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Standard Size', 'classiera' ),
        'id'               => 'standardads',
        'subsection'       => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-adjust-alt',
        'fields'     => array(
            array(
                'id'=>'standard-sec-title',
                'type' => 'text',
                'title' => __('Standard Adverts Title', 'classiera'),
                'subtitle' => __('Standard Adverts Title', 'classiera'),
                'desc' => __('Put here Standard Adverts Title.', 'classiera'),
                'default' => 'Standard Size'
            ),
            array(
                'id'=>'standard-sec-desc',
                'type' => 'textarea',
                'title' => __('Standard Advert Description', 'classiera'),
                'subtitle' => __('Standard Advert Description', 'classiera'),
                'desc' => __('Put here Standard Advert Description.', 'classiera'),
                'default' => 'Put your information here'
            ),
            array(
                'id'=>'standard-sec-price',
                'type' => 'multi_text',
                'title' => __('Advert Price (Numeral Only)', 'classiera'),
                'subtitle' => __('Update advert credit cost', 'classiera'),
                'desc' => __('1st Field = 1 Day, 2nd Field = 3 Days, 3rd Field = 7 Days and 4th Field = 30 Days', 'classiera'),
                'default' => '25'
            ),
            array(
                'id'       => 'standardads-media',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Media w/ URL', 'classiera'),
                'desc'     => __('Basic media uploader with disabled URL input field.', 'classiera'),
                'subtitle' => __('Upload any media using the WordPress native uploader', 'classiera'),
                'default'  => array(
                    'url'=>'http://s.wordpress.org/style/images/codeispoetry.png'
            ),

            )
        )
        ) 
    );

     // -> START Standard Size Top Advert
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Standard Size Top', 'classiera' ),
        'id'               => 'standardads-top',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-adjust-alt',
        'fields'     => array(
            array(
                'id'=>'standard-top-sec-title',
                'type' => 'text',
                'title' => __('Standard Top Adverts Title', 'classiera'),
                'subtitle' => __('Standard Top Adverts Title', 'classiera'),
                'desc' => __('Put here Standard Top Adverts Title.', 'classiera'),
                'default' => 'Standard Top Size'
            ),
            array(
                'id'=>'standard-top-sec-desc',
                'type' => 'textarea',
                'title' => __('Standard Top Advert Description', 'classiera'),
                'subtitle' => __('Standard Top Advert Description', 'classiera'),
                'desc' => __('Put here Standard Top Advert Description.', 'classiera'),
                'default' => 'Put your information here'
            ),
            array(
                'id'=>'standard-top-sec-price',
                'type' => 'multi_text',
                'title' => __('Advert Price (Numeral Only)', 'classiera'),
                'subtitle' => __('Update advert credit cost', 'classiera'),
                'desc' => __('1st Field = 1 Day, 2nd Field = 3 Days, 3rd Field = 7 Days and 4th Field = 30 Days', 'classiera'),
                'default' => '25'
            ),
            array(
                'id'       => 'standardads-top-media',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Media w/ URL', 'classiera'),
                'desc'     => __('Basic media uploader with disabled URL input field.', 'classiera'),
                'subtitle' => __('Upload any media using the WordPress native uploader', 'classiera'),
                'default'  => array(
                    'url'=>'http://s.wordpress.org/style/images/codeispoetry.png'
            ),

            )
        )
        ) 
    );
      // -> START Double Size Advert
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Double Size', 'classiera' ),
        'id'               => 'doubleads',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-adjust-alt',
        'fields'     => array(
            array(
                'id'=>'double-sec-title',
                'type' => 'text',
                'title' => __('Double Advert Title', 'classiera'),
                'subtitle' => __('Double Advert Title', 'classiera'),
                'desc' => __('Put here Double Advert Title.', 'classiera'),
                'default' => 'Double Advert'
            ),
            array(
                'id'=>'double-sec-desc',
                'type' => 'textarea',
                'title' => __('Double Advert Description', 'classiera'),
                'subtitle' => __('Double Advert Description', 'classiera'),
                'desc' => __('Put here Double Advert Description.', 'classiera'),
                'default' => 'Double Size Advert'
            ),
            array(
                'id'=>'double-sec-price',
                'type' => 'multi_text',
                'title' => __('Advert Price (Numeral Only)', 'classiera'),
                'subtitle' => __('Update advert credit cost', 'classiera'),
                'desc' => __('1st Field = 1 Day, 2nd Field = 3 Days, 3rd Field = 7 Days and 4th Field = 30 Days', 'classiera'),
                'default' => '25'
            ),
            array(
                'id'       => 'doubleads-media',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Media w/ URL', 'classiera'),
                'desc'     => __('Basic media uploader with disabled URL input field.', 'classiera'),
                'subtitle' => __('Upload any media using the WordPress native uploader', 'classiera'),
                'default'  => array(
                    'url'=>'http://s.wordpress.org/style/images/codeispoetry.png'
                ),
            )
        )
        ) 
    );
      // -> START Double Size Top
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Double Size Top', 'classiera' ),
        'id'               => 'doublesizeads',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-adjust-alt',
        'fields'     => array(
            array(
                'id'=>'doublesize-sec-title',
                'type' => 'text',
                'title' => __('Double Advert Top Title', 'classiera'),
                'subtitle' => __('Double Advert Top Title', 'classiera'),
                'desc' => __('Enter here Double Size Title', 'classiera'),
                'default' => 'Double Advert Top'
            ),
            array(
                'id'=>'doublesize-sec-desc',
                'type' => 'textarea',
                'title' => __('Double Top Advert Description', 'classiera'),
                'subtitle' => __('Double Top Advert Description', 'classiera'),
                'desc' => __('Put here Double Top Advert Description.', 'classiera'),
                'default' => 'Double Size Top Advert'
            ),
            array(
                'id'=>'double-top-sec-price',
                'type' => 'multi_text',
                'title' => __('Advert Price (Numeral Only)', 'classiera'),
                'subtitle' => __('Update advert credit cost', 'classiera'),
                'desc' => __('1st Field = 1 Day, 2nd Field = 3 Days, 3rd Field = 7 Days and 4th Field = 30 Days', 'classiera'),
                'default' => '25'
            ),
            array(
                'id'       => 'doublesize-media',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Media w/ URL', 'classiera'),
                'desc'     => __('Basic media uploader with disabled URL input field.', 'classiera'),
                'subtitle' => __('Upload any media using the WordPress native uploader', 'classiera'),
                'default'  => array(
                    'url'=>'http://s.wordpress.org/style/images/codeispoetry.png'
                ),
            )
        )
        ) 
    );

    // -> START Ads Manager
     Redux::setSection( $opt_name, array(
        'title'            => __( 'Ads Manager', 'classiera' ),
        'id'               => 'adsmanager',
        'desc'             => __( 'Manage Premium Ads and Regular Ads', 'classiera' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-signal'
    ) );
    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Premium Ads', 'classiera' ),
        'id'               => 'premiumads',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-usd',
        'fields'     => array(
            array(
                'id'=>'premium-sec-title',
                'type' => 'text',
                'title' => __('Premium Section Title', 'classiera'),
                'subtitle' => __('Premium Section Title', 'classiera'),
                'desc' => __('Put here Premium Section Title.', 'classiera'),
                'default' => 'PREMIUM ADVERTISEMENT'
            ),
            array(
                'id'=>'premium-sec-desc',
                'type' => 'textarea',
                'title' => __('Premium Section Description', 'classiera'),
                'subtitle' => __('Premium Section Description', 'classiera'),
                'desc' => __('Put here Premium Section Description.', 'classiera'),
                'default' => 'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor.'
            ),
            array(
                'id' => 'featured-options-on',
                'type' => 'switch',
                'title' => __('Premium Ads slider', 'classiera'),
                'subtitle' => __('Ads slider', 'classiera'),
                'desc' => __('If you want to turn off Premium Ads slider from all pages other then homepage then just turn off this option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'featured-caton',
                'type' => 'switch',
                'title' => __('Featured Category On/OFF', 'classiera'),
                'subtitle' => __('Ads Shown From Featured Category.', 'classiera'),
                'desc' => __('If You dont want to use Featured Category then Turn OFF This Options', 'classiera'),
                'default' => 2,
            ),
            array(
                'id' => 'featured-ads-cat',
                'type' => 'select',
                'data' => 'categories',
                'multi'    => true, 
                'args' => array(
                    'orderby' => 'name',
                    'hide_empty' => 0,
                    'parent' => 0,
                ),
                'default' => 1,
                'title' => __('Featured Category', 'classiera'),
                'subtitle' => __('Featured Category', 'classiera'), 
                'desc' => __('If You dont want to use Paid Ads then Just select a Category from here and All Ads from this category will be shown at Premium Slider Place.', 'classiera'),
            ),          
            array(
                'id'=>'premium-ads-counter',
                'type' => 'text',
                'title' => __('How many Premium Ads on homepage?', 'classiera'),
                'subtitle' => __('Premium Ads on homepage', 'classiera'),
                'desc' => __('How many Premium Ads you want to show in Premium Slider', 'classiera'),
                'default' => '9'
            ),
            array(
                'id'=>'premium-ads-limit',
                'type' => 'text',
                'title' => __('How May Image for Premium Ads?', 'classiera'),
                'subtitle' => __('Premium Ads Image Limit', 'classiera'),
                'desc' => __('Put a Value for Premium Ads , How May Images you want to allow to Paid users?. Example "3"', 'classiera'),
                'default' => '3'
            ),
            array(
                'id' => 'classiera_featured_expiry',
                'type' => 'switch',
                'title' => __('Featured Ads Expiry', 'classiera'),
                'subtitle' => __('ON/OFF Featured Ads Expiry', 'classiera'),
                'desc' => __('If you will turn ON this option then your featured ads will be remove after expire.', 'classiera'),
                'default' => false,
            ),
        )
    ) );
    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Regulars Ads', 'classiera' ),
        'id'               => 'regularadsposting',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-usd',
        'fields'     => array(
            array(
                'id' => 'regular-ads',
                'type' => 'switch',
                'title' => __('Regular ad posting On/OFF', 'classiera'),
                'subtitle' => __('Regular ad posting On/OFF', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'ad_expiry',
                'type' => 'select',
                'title' => __('Regular Ads Expiry', 'classiera'), 
                'subtitle' => __('Regular Ads Expiry', 'classiera'),
                'desc' => __('Regular Ads Expiry', 'classiera'),
                'options' => array(
                    '1' => 'One Day',
                    '2' => 'Two Days',
                    '3' => 'Three Days',
                    '4' => 'Four Days',
                    '5' => 'Five Days',
                    '6' => 'Six Days',
                    '7' => 'One week',
                    '30' => 'One Month',
                    '60' => 'Two Months',
                    '90' => 'Three Months',
                    '120' => 'Four Months',
                    '150' => 'Five Months',
                    '180' => 'Six Month',
                    '365' => 'One Year',
                    'lifetime' => 'Life Time'
                ),
                'default' => 'lifetime'
            ),
            array(
                'id'=>'regular-ads-limit',
                'type' => 'text',
                'title' => __('How May Image for Regular Ads?', 'classiera'),
                'subtitle' => __('Regular Ads Image Limit', 'classiera'),
                'desc' => __('Put a Value for Regulars Ads , How May Images you want to allow to regular users? Example "2"', 'classiera'),
                'default' => '2'
            ),
            array(
                'id' => 'regular-ads-posting-limit',
                'type' => 'switch',
                'title' => __('Regular Ads Post Limit', 'classiera'),
                'subtitle' => __('Turn ON/OFF Limit for Regular Ads.', 'classiera'),
                'desc' => __('If You want to Put Limit for free Ads Posting then You must need to Turn On This Option.', 'classiera'),
                'default' => false,
            ),
            array(
                'id'=>'regular-ads-user-limit',
                'type' => 'text',
                'title' => __('How May Free Ads User Can Post?', 'classiera'),
                'subtitle' => __('Regular Ads Limit', 'classiera'),
                'desc' => __('Put a Value for Regulars Ads , How May Free Ads you want to allow to regular users? Example "2"', 'classiera'),
                'default' => '2'
            ),
        )
    ) );
    // -> START Bump Ads
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Bump Ads', 'classiera' ),
        'id'               => 'bumpads',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-arrow-up',
        'desc' => __('Bump Ads, We need WooCommerece Product ID there, You need to create a product by name of Bump Ads and put that product ID here, Set Price for Bump Ads in WooCommerece Product.', 'classiera'),
        'fields'     => array(
            array(
                'id'=>'classiera_bump_ad_woo_id',
                'type' => 'text',
                'title' => __('Product ID', 'classiera'),
                'subtitle' => __('WooCommerece Product ID', 'classiera'),
                'desc' => __('Copy Product ID from WooCommerece Products and paste here.', 'classiera'),
                'default' => ''
            ),
        )
    ) );
    // -> START Single Ad
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Single Ad', 'classiera' ),
        'id'               => 'postads',
        'customizer_width' => '500px',
        'icon'             => 'el el-pencil',
        'desc'  => __( 'Some Settings Which Will work on Post New Ads Page', 'classiera' ),
        'fields'     => array(
            
            array(
                'id' => 'related-ads-on',
                'type' => 'switch',
                'title' => __('Related Ads On Single Post', 'classiera'),
                'subtitle' => __('Related Ads On Single Post', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_related_ads_count',
                'type' => 'text',
                'title' => __('Related Ads Count', 'classiera'),
                'subtitle' => __('Put Number', 'classiera'),
                'desc' => __('How many related ads you want to show on single post page', 'classiera'),
                'default' => '12'
            ),
            array(
                'id' => 'classiera_related_ads_autoplay',
                'type' => 'switch',
                'title' => __('Auto Play Related Ads', 'classiera'),
                'desc' => __('Manage Auto play for related ads on single ad page', 'classiera'),
                'default' => true,
            ),
            array(
                'id' => 'classiera_sing_post_comments',
                'type' => 'switch',
                'title' => __('Comments section On Single Post', 'classiera'),
                'subtitle' => __('Comments section ON/OFF', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_author_contact_info',
                'type' => 'switch',
                'title' => __('Author Contact info', 'classiera'),
                'subtitle' => __('Contact info ON/OFF', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_bid_system',
                'type' => 'switch',
                'title' => __('Bid system', 'classiera'),
                'subtitle' => __('Bid option ON/OFF', 'classiera'),
                'desc' => __('If you dont want to use Bidding then turn OFF this option.', 'classiera'),
                'default' => true,
            ),
            array(
                'id' => 'classiera_report_ad',
                'type' => 'switch',
                'title' => __('Report / Watch Later', 'classiera'),
                'subtitle' => __('Turn ON/OFF Report Ad and Watch Later', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'author-msg-box-off',
                'type' => 'switch',
                'title' => __('Author Message Box On/OFF', 'classiera'),
                'subtitle' => __('Author Message box on ad detail page', 'classiera'),
                'default' => 1,
            ),
            
            
        )
    ) );
    // -> START Bump Ads
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Submit Ads - Edit Ads', 'classiera' ),
        'id'               => 'classiera_submit_ad',
        'subsection' => true,
        'customizer_width' => '500px',
        'icon'             => 'el el-arrow-up',
        'desc' => __('From here you can manage your Submit Ad / Post Ad form.', 'classiera'),
        'fields'     => array(
            array(
                'id' => 'post-options-on',
                'type' => 'switch',
                'title' => __('Post moderation', 'classiera'),
                'subtitle' => __('Post moderation', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'post-options-edit-on',
                'type' => 'switch',
                'title' => __('Post moderation On every edit post', 'classiera'),
                'subtitle' => __('Post moderation On every edit post', 'classiera'),
                'default' => 1,
            ),
            
            array(
                'id' => 'phoneon',
                'type' => 'switch',
                'title' => __('Asking Phone Number on Post New Ads', 'classiera'),
                'subtitle' => __('If you dont want to ask phone number then just Turn OFF this.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_ads_type',
                'type' => 'switch',
                'title' => __('Ads Type', 'classiera'),
                'subtitle' => __('Turn On/OFF Ads Type', 'classiera'),
                'desc' => __('Ads type: Buy, Sell, Rent, Hire', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_ads_type_show',
                'type' => 'checkbox',
                'title' => __('Which Ads type you want to use?', 'classiera'),
                'desc' => __('From here you need to select which ads type you want to show.(Buy, Sell, Rent, Hire)', 'classiera'),
                'options' => array(
                    '1' => __('I want to sell?', 'classiera'),
                    '2' => __('I want to buy?', 'classiera'),
                    '3' => __('I want to rent?', 'classiera'),
                    '4' => __('I want to hire?', 'classiera'),
                    '5' => __('Lost and found?', 'classiera'),
                    '6' => __('I give for free.', 'classiera'),
                    '7' => __('I am an event', 'classiera'),
                    '8' => __('Professional service.', 'classiera'),
                ),
                'default' => array(
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                    '6' => '1',
                    '7' => '1',
                    '8' => '1',
                ),
            ),
            array(
                'id' => 'location_states_on',
                'type' => 'switch',
                'title' => __('Locations States On/OFF', 'classiera'),
                'subtitle' => __('Locations States On/OFF', 'classiera'),
                'desc' => __('This option will only work when you are not using City dropdown.', 'classiera'),
                'default' => 1,
            ),          
            array(
                'id' => 'location_city_on',
                'type' => 'switch',
                'title' => __('Locations City On/OFF', 'classiera'),
                'subtitle' => __('Locations City On/OFF', 'classiera'),
                'desc' => __('If you dont want to use city dropdown then turn off this .', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_address_field_on',
                'type' => 'switch',
                'title' => __('Address Field On/OFF', 'classiera'),
                'subtitle' => __('Address Field On/OFF', 'classiera'),
                'desc' => __('If you dont want to use Address Field then turn off this .', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'google-lat-long',
                'type' => 'switch',
                'title' => __('Latitude and Longitude', 'classiera'),
                'subtitle' => __('Turn On/OFF Latitude and Longitude from Ads Post', 'classiera'),
                'desc' => __('If You dont want user put Latitude and Longitude while posting ads then just turn OFF this option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'google-map-adpost',
                'type' => 'switch',
                'title' => __('Google MAP on Post Ads', 'classiera'),
                'subtitle' => __('Turn On/OFF Google MAP from Ads Post', 'classiera'),
                'desc' => __('If You want to hide Google MAP from Submit Ads Page And Single Ads Page Then Turn OFF this Option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_ad_location_remove',
                'type' => 'switch',
                'title' => __('Ad Location Section', 'classiera'),
                'subtitle' => __('Ad Location On/OFF', 'classiera'),
                'desc' => __('If you want remove Ad Locations section completely then Turn Off this option, It will remove Country, States,City, Address, Google Latitude, Google Longitude and Google MAP Option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_video_postads',
                'type' => 'switch',
                'title' => __('Video Box on Post Ads', 'classiera'),
                'subtitle' => __('Turn On/OFF Video Box on Post Ads', 'classiera'),
                'desc' => __('If you dont want to allow users to add video iframe or link in ads then just turn off this option', 'classiera'),
                'default' => 1,
            ),          
            array(
                'id' => 'regularpriceon',
                'type' => 'switch',
                'title' => __('Regular Price Tab on Post New Ads', 'classiera'),
                'subtitle' => __('Regular Price Tab on Post New Ads', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_sale_price_off',
                'type' => 'switch',
                'title' => __('Price section', 'classiera'),
                'subtitle' => __('Price Tab on Post New Ads', 'classiera'),
                'desc' => __('If you want to hide price section completely then please turn off this option.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_multi_currency',
                'type' => 'button_set',
                'title' => __('Select Currency', 'classiera'),
                'subtitle' => __('Ads Posts', 'classiera'),
                'options' => array('multi' => 'Multi Currency', 'single' => 'Single Currency'),
                'desc' => __('If you want to run your website only in one country then just select Single Currency. If you will select Multi Currency then On Submit Ad Page there will be a dropdown from where user can select currency tag.', 'classiera'),
                'default' =>'multi',
            ),
            array(
                'id'=>'classiera_multi_currency_default',
                'type' => 'select',
                'title' => __('Currency Tag', 'classiera'),
                'subtitle' => __('Currency Tag', 'classiera'),
                'desc' => __('Select default selected currency in dropdown', 'classiera'),
                'options' => array(
                    'USD' => 'US Dollar', 
                    'CAD' => 'Canadian Dollar',
                    'EUR' => 'Euro',
                    'AED' =>'United Arab Emirates Dirham',
                    'AFN' => 'Afghan Afghani',
                    'ALL' => 'Albanian Lek',
                    'AMD' => 'Armenian Dram',
                    'ARS' => 'Argentine Peso',
                    'AUD' => 'Australian Dollar',
                    'AZN' => 'Azerbaijani Manat',
                    'BDT' => 'Bangladeshi Taka',
                    'BGN' => 'Bulgarian Lev',
                    'BHD' => 'Bahraini Dinar',
                    'BND' => 'Brunei Dollar',
                    'BOB' => 'Bolivian Boliviano',
                    'BRL' => 'Brazilian Real',
                    'BWP' => 'Botswanan Pula',
                    'BYN' => 'Belarusian Ruble',
                    'BZD' => 'Belize Dollar',
                    'CHF' => 'Swiss Franc',
                    'CLP' => 'Chilean Peso',
                    'CNY' => 'Chinese Yuan',
                    'COP' => 'Colombian Peso',
                    'CRC' => 'Costa Rican Colón',
                    'CVE' => 'Cape Verdean Escudo',
                    'CZK' => 'Czech Republic Koruna',
                    'DJF' => 'Djiboutian Franc',
                    'DKK' => 'Danish Krone',
                    'DOP' => 'Dominican Peso',
                    'DZD' => 'Algerian Dinar',
                    'EGP' => 'Egyptian Pound',
                    'ERN' => 'Eritrean Nakfa',
                    'ETB' => 'Ethiopian Birr',
                    'GBP' => 'British Pound',
                    '‎GEL' => 'Georgian Lari',
                    'GHS' => 'Ghanaian Cedi',
                    'GTQ' => 'Guatemalan Quetzal',
                    'GMB' => 'Gambia Dalasi',
                    'HKD' => 'Hong Kong Dollar',
                    'HNL' => 'Honduran Lempira',
                    'HRK' => 'Croatian Kuna',
                    'HUF' => 'Hungarian Forint',
                    'IDR' => 'Indonesian Rupiah',
                    'ILS' => 'Israeli SheKel',
                    'INR' => 'Indian Rupee',
                    'IQD' => 'Iraqi Dinar',
                    'IRR' => 'Iranian Rial',
                    'ISK' => 'Icelandic Króna',
                    'JMD' => 'Jamaican Dollar',
                    'JOD' => 'Jordanian Dinar',
                    'JPY' => 'Japanese Yen',
                    'KES' => 'Kenyan Shilling',
                    'KHR' => 'Cambodian Riel',
                    'KMF' => 'Comorian Franc',
                    'KRW' => 'South Korean Won',
                    'KWD' => 'Kuwaiti Dinar',
                    'KZT' => 'Kazakhstani Tenge',
                    'KM' => 'Konvertibilna Marka',
                    'LBP' => 'Lebanese Pound',
                    'LKR' => 'Sri Lankan Rupee',
                    'LTL' => 'Lithuanian Litas',
                    'LVL' => 'Latvian Lats',
                    'LYD' => 'Libyan Dinar',
                    'MAD' => 'Moroccan Dirham',
                    'MDL' => 'Moldovan Leu',
                    'MGA' => 'Malagasy Ariary',
                    'MKD' => 'Macedonian Denar',
                    'MMK' => 'Myanma Kyat',
                    'HKD' => 'Macanese Pataca',
                    'MUR' => 'Mauritian Rupee',
                    'MXN' => 'Mexican Peso',
                    'MYR' => 'Malaysian Ringgit',
                    'MZN' => 'Mozambican Metical',
                    'NAD' => 'Namibian Dollar',
                    'NGN' => 'Nigerian Naira',
                    'NIO' => 'Nicaraguan Córdoba',
                    'NOK' => 'Norwegian Krone',
                    'NPR' => 'Nepalese Rupee',
                    'NZD' => 'New Zealand Dollar',
                    'OMR' => 'Omani Rial',
                    '‎PAB' => 'Panamanian Balboa',
                    'PEN' => 'Peruvian Nuevo Sol',
                    'PHP' => 'Philippine Peso',
                    'PKR' => 'Pakistani Rupee',
                    'PLN' => 'Polish Zloty',
                    'PYG' => 'Paraguayan Guarani',
                    'QAR' => 'Qatari Rial',
                    'RON' => 'Romanian Leu',
                    'RSD' => 'Serbian Dinar',
                    'RUB' => 'Russian Ruble',
                    'RWF' => 'Rwandan Franc',
                    'SAR' => 'Saudi Riyal',
                    'SDG' => 'Sudanese Pound',
                    'SEK' => 'Swedish Krona',
                    'SGD' => 'Singapore Dollar',
                    'SOS' => 'Somali Shilling',
                    'SYP' => 'Syrian Pound',
                    'THB' => 'Thai Baht',
                    'TND' => 'Tunisian Dinar',
                    'TOP' => 'Tongan Paʻanga',
                    'TRY' => 'Turkish Lira',
                    'TTD' => 'Trinidad and Tobago Dollar',
                    'TWD' => 'New Taiwan Dollar',
                    'UAH' => 'Ukrainian Hryvnia',
                    'UGX' => 'Ugandan Shilling',
                    'UYU' => 'Uruguayan Peso',
                    'UZS' => 'Uzbekistan Som',
                    'VEF' => 'Venezuelan Bolívar',
                    'VND' => 'Vietnamese Dong',
                    'YER' => 'Yemeni Rial',
                    'ZAR' => 'South African Rand',
                    'FCFA' => 'CFA Franc BEAC',
                    'TZS' => 'Tanzanian Shillings',
                    'SRD' => 'Surinamese dollar',
                    'ZMK' => 'Zambian Kwacha'),
                'default' => 'USD',
                'required' => array( 'classiera_multi_currency', '=', 'multi' )
            ),
            array(
                'id'=>'classierapostcurrency',
                'type' => 'text',
                'title' => __('Currency Tag', 'classiera'),
                'subtitle' => __('Currency Tag', 'classiera'),
                'desc' => __('Put Your Own Currency Symbol or HTML code to display', 'classiera'),
                'default' => '$',
                'required' => array( 'classiera_multi_currency', '=', 'single' )
            ),
            array(
                'id'=>'classiera_currency_left_right',
                'type' => 'radio',
                'title' => __('Currency Tag Display', 'classiera'), 
                'subtitle' => __('Select option', 'classiera'),
                'desc' => __('You want to show currency tag on left or right with post price??', 'classiera'),
                'options' => array('left' => 'Left', 'right' => 'Right'),//Must provide key => value pairs for radio options
                'default' => 'left'
            ),
            array(
                'id'=>'classiera_categories_noprice',
                'type' => 'select',
                'data' => 'categories',
                'args' => array(
                    'orderby' => 'name',
                    'hide_empty' => 0,
                ),
                'multi'    => true,             
                'title' => __('Select Categories to hide price', 'classiera'), 
                'subtitle' => __('Hide Price for categories', 'classiera'),
                'desc' => __('Please select categories in which you dont want to use price section, then price section will be hide for that categories', 'classiera'),
                'default' => 1,
            ),
        )
    ) );
    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Pages', 'classiera' ),
        'id'               => 'pages',
        'customizer_width' => '500px',
        'icon'             => 'el-icon-website',
        'fields'     => array(
            array(
                'id'=>'login',
                'type' => 'text',
                'title' => __('Login Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Login template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'get_credits',
                'type' => 'text',
                'title' => __('Get Credits Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting get credits template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'register',
                'type' => 'text',
                'title' => __('Register Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Register template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'profile',
                'type' => 'text',
                'title' => __('Profile Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Profile template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'edit',
                'type' => 'text',
                'title' => __('Profile Settings Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Profile template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'new_post',
                'type' => 'text',
                'title' => __('Submit Ad Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Submit template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'edit_post',
                'type' => 'text',
                'title' => __('Edit Ad Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Edit Ad template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'featured_plans',
                'type' => 'text',
                'title' => __('Pricing Plans Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Pricing Plan template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'all-cat-page-link',
                'type' => 'text',
                'title' => __('All Categories Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting All Categories template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'all-ads-page-link',
                'type' => 'text',
                'title' => __('All Ads Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting All Ads template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'all-ads',
                'type' => 'text',
                'title' => __('Single User All Ads', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Single User All Ads template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'classiera_single_user_plans',
                'type' => 'text',
                'title' => __('Single User Plans', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Single User All Plans template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'classiera_inbox_page_url',
                'type' => 'text',
                'title' => __('Inbox Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting inbox template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'all-favourite',
                'type' => 'text',
                'title' => __('Single User All Favorite', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Favorite Ads template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'classiera_user_follow',
                'type' => 'text',
                'title' => __('Single User All Follower', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Follow template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'reset',
                'type' => 'text',
                'title' => __('Reset Password Page URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Create page by selecting Reset Password Page template and insert url here.', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'termsandcondition',
                'type' => 'text',
                'title' => __('Terms And Conditions URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('This Link will be shown at registration page', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'classiera_cart_url',
                'type' => 'text',
                'title' => __('WooCommerece Cart URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Please Put Woo Commerce URL here', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
        )
    ) );
    // -> START Color Selection
    Redux::setSection( $opt_name, array(
        'title' => __( 'Color Selection', 'classiera' ),
        'id'    => 'color',
        'desc'  => __( 'Color Selection', 'classiera' ),
        'icon'  => 'el el-brush',
        'fields' => array(
            array(
                'id'       => 'color-primary',
                'type'     => 'color',
                'title'    => __('Primary Color', 'classiera'), 
                'subtitle' => __('Pick a Primary Color default: #e96969.', 'classiera'),
                'default'  => '#b6d91a',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'color-secondary',
                'type'     => 'color',
                'title'    => __('Secondary Color', 'classiera'), 
                'subtitle' => __('Pick a Secondary Color default: #232323.', 'classiera'),
                'default'  => '#232323',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_topbar_bg',
                'type'     => 'color',
                'title'    => __('Topbar Background Color', 'classiera'), 
                'subtitle' => __('Pick a color for topbar Background default: #444444.', 'classiera'),
                'default'  => '#444444',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_navbar_color',
                'type'     => 'color',
                'title'    => __('Navbar Background Color', 'classiera'), 
                'subtitle' => __('Pick a color for Navbar Background default: #fafafa.', 'classiera'),
                'default'  => '#fafafa',
                'validate' => 'color',
                'transparent' => true,
            ),
            array(
                'id'       => 'classiera_navbar_text_color',
                'type'     => 'color',
                'title'    => __('Navbar Text Color', 'classiera'), 
                'subtitle' => __('Pick a color for Navbar Text default: #444444.', 'classiera'),
                'default'  => '#444444',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_tags_bg',
                'type'     => 'color',
                'title'    => __('Footer Tags Background Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer tags Background default: #444444.', 'classiera'),
                'default'  => '#444444',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_tags_txt',
                'type'     => 'color',
                'title'    => __('Footer Tags Text Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer tags Text default: #ffffff.', 'classiera'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_tags_txt_hover',
                'type'     => 'color',
                'title'    => __('Footer Tags Hover Text Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer tags Hover Text default: #ffffff.', 'classiera'),
                'default'  => '#ffffff',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_txt',
                'type'     => 'color',
                'title'    => __('Footer text widget Text Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer text widget Text default: #aaaaaa.', 'classiera'),
                'default'  => '#aaaaaa',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_bottom_bg',
                'type'     => 'color',
                'title'    => __('Footer Bottom Background Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer Bottom Background default: #444444.', 'classiera'),
                'default'  => '#444444',
                'validate' => 'color',
                'transparent' => false,
            ),
            array(
                'id'       => 'classiera_footer_bottom_txt',
                'type'     => 'color',
                'title'    => __('Footer Bottom Text Color', 'classiera'), 
                'subtitle' => __('Pick a color for Footer Bottom text default: #8e8e8e.', 'classiera'),
                'default'  => '#8e8e8e',
                'validate' => 'color',
                'transparent' => false,
            ),
        )
    ) );

    // -> START Design Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Social Links', 'classiera' ),
        'id'    => 'social-links',
        'desc'  => __( 'Put Social Links', 'classiera' ),
        'icon'  => 'el el-glasses',
        'fields' => array(
            array(
            'id'=>'facebook-link',
            'type' => 'text',
            'title' => __('Facebook Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Facebook Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'twitter-link',
            'type' => 'text',
            'title' => __('Twitter Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Twitter Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'dribbble-link',
            'type' => 'text',
            'title' => __('Dribbble Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Dribbble Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'flickr-link',
            'type' => 'text',
            'title' => __('Flickr Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Flickr Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'github-link',
            'type' => 'text',
            'title' => __('Github Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Github Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'pinterest-link',
            'type' => 'text',
            'title' => __('Pinterest Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Pinterest Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'youtube-link',
            'type' => 'text',
            'title' => __('Youtube Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Youtube Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'google-plus-link',
            'type' => 'text',
            'title' => __('Google+ Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Google+ Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'linkedin-link',
            'type' => 'text',
            'title' => __('LinkedIn Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('LinkedIn Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'instagram-link',
            'type' => 'text',
            'title' => __('Instagram Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Instagram Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),

        array(
            'id'=>'vimeo-link',
            'type' => 'text',
            'title' => __('Vimeo Page URL', 'classiera'),
            'subtitle' => __('This must be an URL.', 'classiera'),
            'desc' => __('Vimeo Page URL', 'classiera'),
            'validate' => 'url',
            'default' => ''
            ),
        
        )
    ) );


    // -> START Media Uploads
    Redux::setSection( $opt_name, array(
        'title' => __( 'Advertisement', 'classiera' ),
        'id'    => 'advertisement',
        'desc'  => __( 'Advertisement Section, If you want to use image ads then please upload banner image and put website URL, but if you want to use google ads then images ads option must need to be empty.', 'classiera' ),
        'icon'  => 'el el-picture',
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Page Ads', 'classiera' ),
        'id'               => 'home-page-ads',
        'icon'             => 'el el-home-alt',
        'subsection' => true,
        'customizer_width' => '500px',        
        'desc'=> __('Put HomePage Ads Here.', 'classiera'),
        'fields'           => array( 
            array(
                'id'=>'home_ad1',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Home Page First banner Image Ads', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Ad Image.', 'classiera'),
                'subtitle' => __('Ad Image', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'home_ad1_url',
                'type' => 'text',
                'title' => __('Home Page First banner Image URL', 'classiera'),
                'subtitle' => __('link URL', 'classiera'),
                'desc' => __('You can add URL here so when user will click on that image then user will goes to that link.', 'classiera'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'=>'home_html_ad',
                'type' => 'textarea',
                'title' => __('HTML Ads Or Google Ads', 'classiera'),
                'subtitle' => __('HTML ads for HomePage', 'classiera'),
                'desc' => __('Put your HTML or Google Ads Code for First banner here.', 'classiera'),
                'default' => ''
            ),
            array(
                'id'=>'classiera_home_banner_2',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Home Page second banner Image Ads', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Ad Image.', 'classiera'),
                'subtitle' => __('Ad Image', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'classiera_home_banner_2_url',
                'type' => 'text',
                'title' => __('Home Page second banner Image URL', 'classiera'),
                'subtitle' => __('link URL', 'classiera'),
                'desc' => __('You can add URL here so when user will click on that image then user will goes to that link.', 'classiera'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'=>'classiera_home_banner_2_html',
                'type' => 'textarea',
                'title' => __('HTML Ads Or Google Ads', 'classiera'),
                'subtitle' => __('HTML ads for HomePage', 'classiera'),
                'desc' => __('Put your HTML or Google Ads Code for second banner on home here.', 'classiera'),
                'default' => ''
            ),
            array(
                'id'=>'classiera_home_banner_3',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Home Page third banner Image Ads', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Ad Image.', 'classiera'),
                'subtitle' => __('Ad Image', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'classiera_home_banner_3_url',
                'type' => 'text',
                'title' => __('Home Page third banner Image URL', 'classiera'),
                'subtitle' => __('link URL', 'classiera'),
                'desc' => __('You can add URL here so when user will click on that image then user will goes to that link.', 'classiera'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'=>'classiera_home_banner_3_html',
                'type' => 'textarea',
                'title' => __('HTML Ads Or Google Ads', 'classiera'),
                'subtitle' => __('HTML ads for HomePage', 'classiera'),
                'desc' => __('Put your HTML or Google Ads Code for third banner on home here.', 'classiera'),
                'default' => ''
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Other Ads', 'classiera' ),
        'id'         => 'advertisement-other',
        'desc'  => __( 'If you want to use image ads then please upload banner image and put website URL, but if you want to use google ads then images ads option must need to be empty.', 'classiera' ),
        'icon'  => 'el el-picture',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'=>'home_ad2',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Single Post Page Ad img', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Ad Image.', 'classiera'),
                'subtitle' => __('Single Post Page Ad img', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'home_ad2_url',
                'type' => 'text',
                'title' => __('Single Post Ad link URL', 'classiera'),
                'subtitle' => __('Single Post Ad link URL', 'classiera'),
                'desc' => __('You can add URL here so when user will click on that image then user will goes to that link.', 'classiera'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'=>'home_html_ad2',
                'type' => 'textarea',
                'title' => __('HTML Ads Or Google Ads for Single Post', 'classiera'),
                'subtitle' => __('Google ads', 'classiera'),
                'desc' => __('Put your HTML or Google Ads Code here.', 'classiera'),
                'default' => ''
            ),  
            array(
                'id'=>'post_ad',
                'type' => 'media', 
                'url'=> true,
                'title' => __(' Location & category page Ad', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your Ad Image.', 'classiera'),
                'subtitle' => __('Upload your Ad Image', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'post_ad_url',
                'type' => 'text',
                'title' => __('Location & category page Ad link URL', 'classiera'),
                'subtitle' => __('Ad link URL', 'classiera'),
                'desc' => __('You can add URL.', 'classiera'),
                'default' => '',
                'validate' => 'url',
            ),
            array(
                'id'=>'post_ad_code_html',
                'type' => 'textarea',
                'title' => __('HTML or Google ads (Location & category page)', 'classiera'),
                'subtitle' => __('Google ads', 'classiera'),
                'desc' => __('Put your HTML or Google Ads Code here.', 'classiera'),
                'default' => ''
            ),
        )
    ) );
    // -> START Switch & Button Set
    Redux::setSection( $opt_name, array(
        'title' => __( 'Partners', 'classiera' ),
        'id'    => 'partners',
        'desc'  => __( 'Upload Partners Logos', 'classiera' ),
        'icon'  => 'el el-group',
        'fields' => array(
            array(
                'id' => 'partners-on',
                'type' => 'switch',
                'title' => __('Partners Slider', 'classiera'),
                'subtitle' => __('Turn On/OFF', 'classiera'),
                'desc' => __('This setting will work only on inner pages, If you want to turn OFF from HomePage then Please visit LayOut Manager tab.', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'classiera_partners_style',
                'type' => 'radio',
                'title' => __('Partners Styles', 'classiera'), 
                'subtitle' => __('Select Styles', 'classiera'),
                'desc' => __('Selection Will work on all pages other then homepage, on homepage Design will be used from template', 'classiera'),
                'options' => array('1' => 'Version 1', '2' => 'Version 2', '3' => 'Version 3', '4' => 'Version 4', '5' => 'Version 5', '6' => 'Version 6'),//Must provide key => value pairs for radio options
                'default' => '1'
            ),
            array(
                'id'=>'classiera_partners_title',
                'type' => 'text',
                'title' => __('Partner Title', 'classiera'),
                'subtitle' => __('Partner Title', 'classiera'),
                'desc' => __('Partner Sections Title.', 'classiera'),
                'default' => 'See Our Featured Members'
            ),
            array(
                'id'=>'classiera_partners_desc',
                'type' => 'text',
                'title' => __('Partner Description', 'classiera'),
                'subtitle' => __('Partner Description', 'classiera'),
                'desc' => __('Replace Your Partner Section Description', 'classiera'),
                'default' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.'
            ),
            array(
                'id'=>'partner1',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner One', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner1-url',
                'type' => 'text',
                'title' => __('Partner One URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner One URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'partner2',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner two', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner2-url',
                'type' => 'text',
                'title' => __('Partner two URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner two URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),  
            array(
                'id'=>'partner3',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner three', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner3-url',
                'type' => 'text',
                'title' => __('Partner three URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner three URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'partner4',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner four', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner4-url',
                'type' => 'text',
                'title' => __('Partner four URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner four URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),  
            array(
                'id'=>'partner5',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner five', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner5-url',
                'type' => 'text',
                'title' => __('Partner five URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner five URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),  
            array(
                'id'=>'partner6',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner six', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner6-url',
                'type' => 'text',
                'title' => __('Partner six URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner six URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'partner7',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner seven', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner7-url',
                'type' => 'text',
                'title' => __('Partner seven URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner seven URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
            array(
                'id'=>'partner8',
                'type' => 'media', 
                'url'=> true,
                'title' => __('Partner eight', 'classiera'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc'=> __('Upload your logo.', 'classiera'),
                'subtitle' => __('Upload your logo', 'classiera'),
                'default'=>array('url'=>''),
            ),
            array(
                'id'=>'partner8-url',
                'type' => 'text',
                'title' => __('Partner eight URL', 'classiera'),
                'subtitle' => __('This must be an URL.', 'classiera'),
                'desc' => __('Partner eight URL', 'classiera'),
                'validate' => 'url',
                'default' => ''
            ),
        )
    ) );


    // -> START Select Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Translate', 'classiera' ),
        'id'    => 'translate',
        'icon'  => 'el el-refresh',
        'fields' => array(      
            array(
                'id'=>'trns_new_post_posted',
                'type' => 'text',
                'title' => __('New Post Posted', 'classiera'),
                'subtitle' => __('Translate Text', 'classiera'),
                'desc' => __('Replace New Post Has been Posted', 'classiera'),
                'default' => 'New Post Has been Posted'
            ),
            array(
                'id'=>'trns_welcome_user_title',
                'type' => 'text',
                'title' => __('Welcome Email Title', 'classiera'),
                'subtitle' => __('Translate Text', 'classiera'),
                'desc' => __('Replace Welcome Text', 'classiera'),
                'default' => 'Welcome To Classiera'
            ),
            array(
                'id'=>'trns_listing_published',
                'type' => 'text',
                'title' => __('Published Post Notification', 'classiera'),
                'subtitle' => __('Translate Text', 'classiera'),
                'desc' => __('Replace Your Listing has been published', 'classiera'),
                'default' => 'Your Listing has been published!'
            )   
        )
    ) );    
    // -> START Fonts
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Fonts', 'classiera' ),
        'id'     => 'Fonts',
        'desc' => __('Select Fonts for your Website', 'classiera'),
        'icon'   => 'el el-font',
        'fields' => array(           
            array(
            'id' => 'heading1-font',
            'type' => 'typography',
            'title' => __('H1 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h1, h1 a'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '36px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '36px',
                ),
            ),

        array(
            'id' => 'heading2-font',
            'type' => 'typography',
            'title' => __('H2 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h2, h2 a, h2 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '30px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '30px',
                ),
            ),

        array(
            'id' => 'heading3-font',
            'type' => 'typography',
            'title' => __('H3 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h3, h3 a, h3 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '24px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '24px',
                ),
            ),

        array(
            'id' => 'heading4-font',
            'type' => 'typography',
            'title' => __('H4 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h4, h4 a, h4 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '18px',
                'font-family' => 'ubuntu',
                'font-weight' => '700',
                'line-height' => '18px',
                ),
            ),

        array(
            'id' => 'heading5-font',
            'type' => 'typography',
            'title' => __('H5 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h5, h5 a, h5 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '14px',
                'font-family' => 'ubuntu',
                'font-weight' => '600',
                'line-height' => '24px',
                ),
            ),

        array(
            'id' => 'heading6-font',
            'type' => 'typography',
            'title' => __('H6 Font', 'classiera'),
            'subtitle' => __('Specify the headings font properties.', 'classiera'),
            'google' => true,
            'output' => array('h6, h6 a, h6 span'),
            'default' => array(
                'color' => '#232323',
                'font-size' => '12px',
                'font-family' => 'ubuntu',
                'font-weight' => '600',
                'line-height' => '24px',
                ),
            ),

        array(
            'id' => 'body-font',
            'type' => 'typography',
            'title' => __('Body Font', 'classiera'),
            'subtitle' => __('Specify the body font properties.', 'classiera'),
            'google' => true,
            'output' => array('html, body, div, applet, object, iframe p, blockquote, a, abbr, acronym, address, big, cite, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video'),
            'default' => array(
                'color' => '#6c6c6c',
                'font-size' => '14px',
                'font-family' => 'Lato',
                'font-weight' => 'Normal',
                'line-height' => '24px',
                'visibility' => 'inherit',
                ),
            ),
        )
    ) );    
    Redux::setSection( $opt_name, array(
        'title' => __( 'Google Settings', 'classiera' ),
        'icon'  => 'el el-map-marker',
        'id'    => 'google-map',
        'desc'  => __( 'Google Settings', 'classiera' ),        
        'fields' => array(
            array(
                'id'=>'classiera_map_post_type',
                'type' => 'radio',
                'title' => __('Select Ads type', 'classiera'),
                'subtitle' => __('Which ads you want to show??', 'classiera'),
                'desc' => __('Which type of ads you want to show on Google MAP on Home? On search result page all ads will be display.', 'classiera'),
                'options' => array('featured' => 'Featured / Premium', 'all' => 'All Ads (Regular & Premium)'),
                'default' => 'all'
            ),
            array(
                'id'=>'classiera_map_post_count',
                'type' => 'text',
                'title' => __('How Many ads', 'classiera'),
                'subtitle' => __('Put a number', 'classiera'),
                'desc' => __('How many ads you want to show on Google MAP (MAP on header), On Search result page count will shown from search query.', 'classiera'),
                'default' => '12'
            ),
            array(
                'id' => 'classiera_map_on_search',
                'type' => 'switch',
                'title' => __('Google MAP on Search Page', 'classiera'),
                'subtitle' => __('Turn Map On/OFF from Search result page', 'classiera'),
                'desc' => __('If you dont like Google MAP on search result page then just turn OFF this option.', 'classiera'),
                'default' => true,
            ),
            array(
                'id'=>'classiera_google_api',
                'type' => 'text',
                'title' => __('Google API Key', 'classiera'),
                'subtitle' => __('Google API Key', 'classiera'),
                'desc' => __('Put Google API Key here to run Google MAP. If you dont know how to get API key Please Visit  <a href="http://www.tthemes.com/get-google-api-key/" target="_blank">Google API Key</a>', 'classiera'),
                'default' => ''
            ),
            array(
                'id'=>'classiera_map_lang_code',
                'type' => 'text',
                'title' => __('Google MAP Language', 'classiera'),
                'subtitle' => __('Put your language code', 'classiera'),
                'desc' => __('Google allow only few language in MAP Please copy your language code and paste here. <a href="https://developers.google.com/maps/faq#languagesupport" target="_blank">Click here</a> for Language Code', 'classiera'),
                'default' => 'en'
            ),
            array(
                'id'=>'google_analytics',
                'type' => 'textarea',
                'title' => __('Google Analytics', 'classiera'),
                'subtitle' => __('Google Analytics Script Code', 'classiera'),
                'desc' => __('Get analytics on your site. Enter Google Analytics script code', 'classiera'),
                'default' => ''
            ),
            array(
                'id'=>'map-style',
                'type' => 'textarea',
                'title' => __('Map Styles', 'classiera'), 
                'subtitle' => __('Check <a href="http://snazzymaps.com/" target="_blank">snazzymaps.com</a> for a list of nice google map styles.', 'classiera'),
                'desc' => __('Ad here your Google map style.', 'classiera'),
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
        )
    ) );
    // -> Coming Soon Page
    Redux::setSection( $opt_name, array(
        'title' => __( 'Coming Soon Page', 'classiera' ),
        'id'    => 'coming-soon',
        'desc'  => __( 'Coming Soon Page Settings', 'classiera' ),
        'icon'  => 'el el-magic',
        'fields' => array(
            array(
            'id'=>'coming-soon-logo',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Coming Soon logo', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload Coming Soon template logo.', 'classiera'),
            'subtitle' => __('Upload Coming Soon template logo', 'classiera'),
            'default'=>array('url'=>''),
            ),
            array(
            'id'=>'coming-soon-bg',
            'type' => 'media', 
            'url'=> true,
            'title' => __('Coming Soon BG', 'classiera'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc'=> __('Upload Coming Soon template Background.', 'classiera'),
            'subtitle' => __('Coming Soon BG', 'classiera'),
            'default'=>array('url'=>''),
            ),
            array(
            'id'=>'coming-soon-txt',
            'type' => 'textarea',
            'title' => __('Coming Soon Text', 'classiera'),
            'subtitle' => __('Coming Soon Text', 'classiera'),
            'desc' => __('Coming Soon Text', 'classiera'),
            'default' => 'Well be here soon with our new awesome site'
            ),
            array(
            'id'=>'coming-trns-days',
            'type' => 'text',
            'title' => __('Replace Days text', 'classiera'),
            'subtitle' => __('Days text', 'classiera'),
            'desc' => __('Days text', 'classiera'),
            'default' => 'Days'
            ),
            array(
            'id'=>'coming-trns-hours',
            'type' => 'text',
            'title' => __('Replace Hours text', 'classiera'),
            'subtitle' => __('Hours text', 'classiera'),
            'desc' => __('Hours text', 'classiera'),
            'default' => 'Hours'
            ),
            array(
            'id'=>'coming-trns-minutes',
            'type' => 'text',
            'title' => __('Replace Minutes text', 'classiera'),
            'subtitle' => __('Minutes text', 'classiera'),
            'desc' => __('Minutes text', 'classiera'),
            'default' => 'Minutes'
            ),
            array(
            'id'=>'coming-trns-seconds',
            'type' => 'text',
            'title' => __('Replace Seconds text', 'classiera'),
            'subtitle' => __('Seconds text', 'classiera'),
            'desc' => __('Seconds text', 'classiera'),
            'default' => 'Seconds'
            ),          
            array(
            'id'=>'coming-month',
            'type' => 'select',
            'title' => __('Month', 'classiera'), 
            'subtitle' => __('Select Month.', 'classiera'),
            'options' => array('1'=>'January', '2'=>'February', '3'=>'March', '4'=>'April', '5'=>'May', '6'=>'June', '7'=>'July', '8'=>'August', '9'=>'September', '10'=>'October', '11'=>'November', '12'=>'December'),
            'default' => '6',
            ),
            array(
            'id'=>'coming-days',
            'type' => 'select',
            'title' => __('Days', 'classiera'), 
            'subtitle' => __('Select Days.', 'classiera'),
            'options' => array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10', '11'=>'11', '12'=>'12', '13'=>'13', '14'=>'14', '15'=>'15', '16'=>'16', '17'=>'17', '18'=>'18', '19'=>'19', '20'=>'20', '21'=>'21', '22'=>'22', '23'=>'23', '24'=>'24', '25'=>'25', '26'=>'26', '27'=>'27', '28'=>'28', '29'=>'29', '30'=>'30', '31'=>'31'),
            'default' => '10',
            ),
            array(
            'id'=>'coming-year',
            'type' => 'text',
            'title' => __('Years', 'classiera'),
            'subtitle' => __('Put Years Example: 2016.', 'classiera'),
            'desc' => __('Years', 'classiera'),         
            'default' => '2017'
            ),
            array(
            'id'=>'coming-copyright',
            'type' => 'text',
            'title' => __('Copyright Text', 'classiera'),
            'subtitle' => __('Copyright Text for Coming Soon Page.', 'classiera'),
            'desc' => __('Copyright Text', 'classiera'),            
            'default' => 'Copyright &copy; 2015 Classiera'
            ),
       )
    ) );
    // -> Contact Page
    Redux::setSection( $opt_name, array(
        'title' => __( 'Contact Page', 'classiera' ),
        'icon'  => 'el el-envelope',
        'id'    => 'contact-page',
        'desc'  => __( 'Contact Page Settings', 'classiera' ),        
        'fields' => array(
            array(
                'id' => 'contact-map',
                'type' => 'switch',
                'title' => __('Map On Contact Page', 'classiera'),
                'subtitle' => __('Turn Map On/OFF from Contact Page', 'classiera'),
                'default' => 1,
            ),
            array(
                'id' => 'classiera_display_email',
                'type' => 'switch',
                'title' => __('Email display on Contact Page', 'classiera'),
                'subtitle' => __('Turn OFF Email display', 'classiera'),
                'default' => 1,
            ),
            array(
                'id'=>'contact-email',
                'type' => 'text',
                'title' => __('Your email address', 'classiera'),
                'subtitle' => __('This must be an email address.', 'classiera'),
                'desc' => __('Your email address', 'classiera'),
                'validate' => 'email',
                'default' => ''
            ),
            array(
                'id'=>'contact-email-error',
                'type' => 'text',
                'title' => __('Email error message', 'classiera'),
                'subtitle' => __('Email error message', 'classiera'),
                'desc' => __('Email error message', 'classiera'),
                'default' => 'You entered an invalid email.'
            ),
            array(
                'id'=>'contact-name-error',
                'type' => 'text',
                'title' => __('Name error message', 'classiera'),
                'subtitle' => __('Name error message', 'classiera'),
                'desc' => __('Name error message', 'classiera'),
                'default' => 'You forgot to enter your name.'
            ),
            array(
                'id'=>'contact-message-error',
                'type' => 'text',
                'title' => __('Message error', 'classiera'),
                'subtitle' => __('Message error', 'classiera'),
                'desc' => __('Message error', 'classiera'),
                'default' => 'You forgot to enter your message.'
            ),
            array(
                'id'=>'contact-thankyou-message',
                'type' => 'text',
                'title' => __('Thank you message', 'classiera'),
                'subtitle' => __('Thank you message', 'classiera'),
                'desc' => __('Thank you message', 'classiera'),
                'default' => 'Thank you! We will get back to you as soon as possible.'
            ),
            array(
                'id'=>'contact-latitude',
                'type' => 'text',
                'title' => __('Google Latitude', 'classiera'),
                'subtitle' => __('Google Latitude', 'classiera'),
                'desc' => __('Put value for Google Latitude of your address', 'classiera'),
                'default' => '31.516370'
            ),
            array(
                'id'=>'contact-longitude',
                'type' => 'text',
                'title' => __('Google Longitude', 'classiera'),
                'subtitle' => __('Google Longitude', 'classiera'),
                'desc' => __('Put value for Google Longitude of your address', 'classiera'),
                'default' => '74.258727'
            ),
            array(
                'id'=>'contact-zoom',
                'type' => 'text',
                'title' => __('MAP Zoom level', 'classiera'),
                'subtitle' => __('MAP Zoom level', 'classiera'),
                'desc' => __('Put a value for Google MAP Zoom level', 'classiera'),
                'default' => '16'
            ),
            array(
                'id'=>'contact-radius',
                'type' => 'text',
                'title' => __('Radius on Google MAP', 'classiera'),
                'subtitle' => __('Radius value', 'classiera'),
                'desc' => __('Put a value for Radius on Google MAP', 'classiera'),
                'default' => '500'
            ),
            array(
                'id'=>'contact-address',
                'type' => 'text',
                'title' => __('Contact Page Address', 'classiera'),
                'subtitle' => __('Contact Page Address', 'classiera'),
                'desc' => __('Contact Page Address', 'classiera'),
                'default' => 'Our business address is 1063 Freelon Street San Francisco, CA 95108'
            ),  
            array(
                'id'=>'contact-phone',
                'type' => 'text',
                'title' => __('Contact Page Phone', 'classiera'),
                'subtitle' => __('Contact Page Phone', 'classiera'),
                'desc' => __('Contact Page Phone', 'classiera'),
                'default' => '021.343.7575'
            ),  
            array(
                'id'=>'contact-phone2',
                'type' => 'text',
                'title' => __('Contact Page Phone Second', 'classiera'),
                'subtitle' => __('Contact Page Phone Second', 'classiera'),
                'desc' => __('Contact Page Phone Second', 'classiera'),
                'default' => '021.343.7576'
            ),
        )
    ) );

    // -> Terms And Conditions
       Redux::setSection( $opt_name, array(
           'title' => __( 'Terms and Conditions', 'classiera' ),
           'icon'  => 'el el-check',
           'id'    => 'terms-and-conditions-page',
           'desc'  => __( 'Update your Terms And Conditions Information', 'classiera' ),        
           'fields' => array(
                   array(
                       'id'=>'tcs-body',
                           'type' => 'textarea',
                           'title' => __('Textarea Option - HTML Validated Custom', 'classiera'), 
                           'subtitle' => __('Custom HTML Allowed (wp_kses)', 'classiera'),
                           'validate' => 'html_custom',
                           'rows' => '35',
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
           )
       ) );
       // End Terms And Conditions

    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'classiera' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    if( function_exists( 'remove_demo' ) ) {
        add_action( 'redux/loaded', 'remove_demo' );
    }
    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/classiera', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'classiera' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'classiera' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }