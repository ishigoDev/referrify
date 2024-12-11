<?php
// Separate Page for register
add_action('template_redirect', 'redirect_logged_in_users_to_my_account');
function redirect_logged_in_users_to_my_account()
{
	if ((is_page('register') && is_user_logged_in()) || is_wc_endpoint_url('edit-address') || is_wc_endpoint_url('downloads')) {
		wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
		exit;
	}
}

// hide download , addresses
function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    unset($items['edit-address']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );