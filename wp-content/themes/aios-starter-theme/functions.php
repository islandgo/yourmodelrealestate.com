<?php
/**
 * Check wordpress and parent theme version
 *
 */
if( is_admin() ) {
	add_action('after_switch_theme', 'check_depencies', 10 ,  2);
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	function check_depencies( $oldtheme_name, $oldtheme ) {
		$required_version_wp 		= '4.9.3';
		$required_version_ais 		= '3.9.9';

		$aios_initial_setup 		= 'aios-initial-setup/asis_main.php';
		$aios_initial_setup_data 	= get_plugin_data( WP_PLUGIN_DIR . '/' . $aios_initial_setup );
		$aios_initial_setup_version = $aios_initial_setup_data['Version'];

		if (
			version_compare( get_bloginfo('version'), $required_version_wp, '<' ) ||
			!is_plugin_active( $aios_initial_setup ) ||
			version_compare( $aios_initial_setup_version, $required_version_ais, '<' )
		)  {
			switch_theme( $oldtheme->stylesheet );
			$wp_error 		= ( version_compare( get_bloginfo('version'), $required_version_wp, '<' ) ? '<li>WordPress ' . $required_version_wp . ' or higher!</li>' : '' );
			$ais_active 	= ( !is_plugin_active( $aios_initial_setup ) ? '<li>AIOS Initial Setup is not Active</li>' : '' );
			$ais_version 	= ( version_compare( $aios_initial_setup_version, $required_version_ais, '<' ) ? '<li>AIOS Initial Setup ' . $required_version_ais . ' or higher!</li>' : '' );

			wp_die(
				'AIOS Under Construction requires the ff:'
				. '<ul>'
					. $wp_error
					. $ais_active
					. $ais_version
				. '</ul>'
			);
		}
	}
}

/*
 * Include Custom Functions
 */
require('lib/aios-starter-theme-functions.php');

/*
 * Register sidebars
 */
function ai_starter_theme_register_sidebars() {

	register_sidebar(array(
	   'name' => 'Primary Sidebar',
	   'id'=>'primary-sidebar',
	   'before_widget' => '<div id="%1$s" class="widget-set %2$s">',
	   'after_widget' => '</div>',
	   'before_title' => '<h2 class="widget-title">',
	   'after_title' => '</h2>'
    ));

	register_sidebar(array(
	   'name' => 'Mobile Header',
	   'id'=>'mobile-header',
	   'before_widget' => '',
	   'after_widget' => '',
	   'before_title' => '',
	   'after_title' => ''
    ));


}

add_action( 'widgets_init', 'ai_starter_theme_register_sidebars' );

/*
 * Register menus
 */
function ai_starter_theme_register_menus() {
	register_nav_menu( 'primary-menu', 'Primary Menu' );
	register_nav_menu( 'secondary-menu', 'Secondary Menu (optional)' );
	register_nav_menu( 'footer-menu', 'Footer Menu (optional)' );
}

add_action( 'init', 'ai_starter_theme_register_menus' );

/*
 * Enable post and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/*
 * Enable post thumbnails
 */
add_theme_support('post-thumbnails');
set_post_thumbnail_size(150, 150);

/*
 * Add custom classes to HP and IP
 */
add_filter('body_class','ai_starter_theme_extra_classes');
function ai_starter_theme_extra_classes($c) {
	if ( is_home() ) {
		$c[] = "home-container";
	}
	else {
		$c[] = "ip-container";
	}
	return $c;
}

/*
 * Add classes to AIOS Listings pages
 */
add_filter('body_class','ai_starter_theme_aios_listings_extra_classes');
function ai_starter_theme_aios_listings_extra_classes($c) {
	if ( get_post_type() == 'listing' ) {
		$c[] = "aios-listings-page";
	}
	return $c;
}

/*
 * Truncate string
 *
 * @param string $string - string to be truncated
 * @param int $length - length in characters
 * @param $end - (optional) Trailing phrase
 *
 * @return string
 */
function ai_starter_theme_truncate_string($string,$length,$end="...") {
	if ( strlen($string) > $length ) {
		return substr($string,0,$length) . $end;
	}
	return $string;
}

/*
 * Detect Mobile
 *
 * @return bool
 */
function ai_starter_theme_is_mobile() {
	if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|playbook|sagem|sharp|sie-|silk|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])){
		return true;
	}
	else {
		return false;
	}
}

/*
 * Enqueue theme styles and scripts
 */
function ai_starter_theme_enqueue_assets() {
	$font = 'https://fonts.googleapis.com';
	$cdn = 'https://resources.agentimage.com';

	/* Enqueue parent style.css */
	wp_register_style( 'aios-starter-theme-style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'aios-starter-theme-style' );

	/* Enqueue globals */
	wp_register_script('aios-starter-theme-global', $cdn . '/libraries/js/global.min.js');
	wp_enqueue_script('aios-starter-theme-global');

	/* Enqueue child theme assets */
	if ( is_child_theme() ) {

		wp_register_style('aios-starter-theme-child-style', get_stylesheet_directory_uri() . '/style.css');
		wp_enqueue_style('aios-starter-theme-child-style');

		if ( file_exists( get_stylesheet_directory() . DIRECTORY_SEPARATOR . '/style-media-queries.css' ) ) {
			wp_register_style('aios-starter-theme-child-style-media-queries', get_stylesheet_directory_uri() . '/style-media-queries.css');
			wp_enqueue_style('aios-starter-theme-child-style-media-queries');
		}

	}

}

add_action( 'wp_enqueue_scripts', 'ai_starter_theme_enqueue_assets' );

/*
 * Remove media queries from style.css of child theme
 */
function ai_starter_theme_remove_media_queries_from_child_stylesheet() {

	/* Only run when a AIOS Starter Child Theme is used */
	if ( !is_child_theme() )  { return; }

	/* Only run if process-style.php is detected */
	if ( !file_exists ( get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'process-style.php' ) ) { return; }

	/* Dequeue child style */
	wp_deregister_style("aios-starter-theme-child-style");
	wp_enqueue_style("aios-starter-theme-child-style", get_stylesheet_directory_uri() . '/process-style.php');

}

/*
 * Enqueue google fonts as a single URL
 */
function ai_starter_theme_concatenate_google_fonts() {

	/* Define variables */
    global $wp_styles;
	$search_for = "fonts.googleapis.com/css?family";
	$google_fonts = array();

	/* Find enqueued Google fonts */
	foreach ( $wp_styles->registered as $name=>$style ) {

		$src = $style->src;

		if ( strpos( $src, $search_for ) !== FALSE ) {
			wp_dequeue_style($name);

			$url_components = parse_url($src);
			parse_str( $url_components["query"], $vars );

			$google_fonts[] = $vars["family"];
		}

	}

	/* Concatenate Google fonts */
	$concatenated = urlencode( implode("|", $google_fonts) );

	wp_enqueue_style("aios-starter-theme-concatenated-google-fonts","https://fonts.googleapis.com/css?family=".$concatenated);

}

add_action( 'wp_enqueue_scripts', 'ai_starter_theme_concatenate_google_fonts', 12 );

/*
 * Allow shortodes on text widgets
 */
add_filter('widget_text', 'do_shortcode');

/*
 * Set HTML as default page/post editor.
 */
function html_default_editor_view() {
	return "html";
}
add_filter( 'wp_default_editor', 'html_default_editor_view' );

/*
 * Format wp_title
 */
function ai_starter_theme_title_filter( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'agentimage-theme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ai_starter_theme_title_filter', 10, 2 );

/*
 * Hide admin bar on mobile devices
 */
if ( ai_starter_theme_is_mobile() ) {
	show_admin_bar( false );
}

/* Test image resolution before image crunch
 * Credits: 	http://wordpress.stackexchange.com/users/28660/marc-dingena
 *       		http://wordpress.stackexchange.com/questions/130203/limit-image-resolution-on-upload
 */
//add_filter('wp_handle_upload_prefilter','ai_starter_theme_validate_image_size');

function ai_starter_theme_validate_image_size( $file ) {
    $image = getimagesize($file['tmp_name']);

    $maximum = array(
        'width' => '2000',
        'height' => '2000'
    );
    $image_width = $image[0];
    $image_height = $image[1];

    $too_large = "Image dimensions are too large. Maximum size is {$maximum['width']} by {$maximum['height']} pixels. Uploaded image is $image_width by $image_height pixels.";

    if ( $image_width > $maximum['width'] || $image_height > $maximum['height'] )
        return array( 'error' => $too_large );
    else
        return $file;
}

/*
 * Make attachments link nowhere by default
 */

function ai_starter_theme_link_attachments_nowhere() {
	update_option('image_default_link_type', 'none' );

}
add_action('after_setup_theme', 'ai_starter_theme_link_attachments_nowhere');

/*
 * Define content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

/*
 * Get content area class. Automatically uses 'content-full' if sidebar is empty.
 * Assumes that sidebar id is 'primary-sidebar'.
 *
 * @param string $default_class - class to use if overriding is unnecessary
 *
 * @return string
 */

function ai_starter_theme_get_content_id( $default_class ) {

	if ( is_active_sidebar( 'primary-sidebar' ) || get_option("ai_starter_theme_force_sidebar_visibility") ) {
			return $default_class;
	}
	else {
			return 'content-full';
	}

}

add_option( "ai_starter_theme_force_sidebar_visibility", false );

/*
 * Remove Really Simple Discovery link
 */

remove_action( 'wp_head', 'rsd_link' );
