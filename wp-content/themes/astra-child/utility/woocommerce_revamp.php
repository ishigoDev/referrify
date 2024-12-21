<?php
// Separate Page for register
add_action('template_redirect', 'redirect_logged_in_users_to_my_account');
function redirect_logged_in_users_to_my_account()
{
	if ((is_page('register') && is_user_logged_in()) || is_wc_endpoint_url('edit-address') || is_wc_endpoint_url('downloads') || is_cart() || is_checkout()) {
		wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
		exit;
	}
}

// hide download , addresses
function custom_my_account_menu_items($items)
{
	unset($items['downloads']);
	unset($items['edit-address']);
	return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_my_account_menu_items');

/**
 * * astra hooks
 */
add_action('astra_woo_shop_summary_wrap_bottom', function () {
	global $product;
	$categories = wp_get_post_terms($product->id, 'product_cat');
	if (!empty($categories)) {
		$category = $categories[0]; // Get the first category
		echo '<div class="job-information-container-1">';
		echo '<div class="company"><a href="#" class="company-link">Zuora</a></div>';
		echo '<div class="role"><a href="' . $category->slug . '" class="role-link">' . $category->name . '</a></div>';
		echo '</div>';
		echo '<div class="job-information-container-2">';
		echo '<div class="location"><img class="job-icons" src="' . site_url() . '/wp-content/uploads/2024/10/locations-pin.svg" /><a href="#" class="company-link">Zuora</a></div>';
		echo '<div class="type"><img class="job-icons" src="' . site_url() . '/wp-content/uploads/2024/10/job-time.svg" /><a href="' . $category->slug . '" class="role-link">' . $category->name . '</a></div>';
		echo '<div class="experience"><img class="job-icons" src="' . site_url() . '/wp-content/uploads/2024/10/position.svg" /><a href="' . $category->slug . '" class="role-link" style="margin-left:3px;">' . $category->name . '</a></div>';
		echo '</div>';
	}
}, 20);

add_action('astra_woo_shop_after_summary_wrap', function () {
	global $product, $woocommerce;
	echo '<div class="ast-shop-footer"><div class="salary">' . $product->get_price_html() . ' PA </div></div>';
}, 20);
