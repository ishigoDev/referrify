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

// Separate Page for register
add_action('template_redirect', 'redirect_logged_in_users_to_my_account');
function redirect_logged_in_users_to_my_account()
{
	if (is_page('register') && is_user_logged_in()) {
		wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
		exit;
	}
}
