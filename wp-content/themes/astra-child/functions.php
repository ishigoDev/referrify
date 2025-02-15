<?php

/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.1');

//required files
require_once get_stylesheet_directory() . '/shortcodes/util_shortcodes.php';
require_once get_stylesheet_directory() . '/shortcodes/jobs_cat_carousel.php';
require_once get_stylesheet_directory() . '/shortcodes/register_form.php';
require_once get_stylesheet_directory() . '/utility/woocommerce_revamp.php';
require_once get_stylesheet_directory() . '/shortcodes/post_job_form.php';



/**
 * Enqueue styles
 */
function child_enqueue_styles()
{
	wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
	wp_enqueue_style('astra-child-theme-shortcode-css', get_stylesheet_directory_uri() . '/shortcodes/shortcode_styles.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/46ce832a93.js', array(), null, false);
	wp_enqueue_style('slick-css',  get_stylesheet_directory_uri() . "/assets/slick/slick.css");
	wp_enqueue_style('slick-theme-css',  get_stylesheet_directory_uri() . "/assets/slick/slick-theme.css");
	if (!is_user_logged_in() && is_page('my-account')) {
		wp_enqueue_style('astra-child-theme-login-page-css', get_stylesheet_directory_uri() . '/assets/css/login.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
	}
	if (is_user_logged_in() && is_page('post-job')) {
		wp_enqueue_style( 'select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
		wp_enqueue_script( 'select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js',array('jquery'),CHILD_THEME_ASTRA_CHILD_VERSION,'defer' );
	}
	wp_enqueue_style('astra-child-theme-job-page-css', get_stylesheet_directory_uri() . '/assets/css/job.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);


if (! function_exists('header_scripts')) {
	function header_scripts()
	{
?>
		<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src=<?php echo get_stylesheet_directory_uri() . "/assets/slick/slick.min.js" ?>></script>
<?php
	}
}
add_action('wp_head', 'header_scripts');

//svg support 
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

	global $wp_version;
	if ($wp_version !== '4.7.1') {
		return $data;
	}

	$filetype = wp_check_filetype($filename, $mimes);

	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
}, 10, 4);

function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
