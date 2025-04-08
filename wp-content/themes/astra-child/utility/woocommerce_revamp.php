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


add_filter('woocommerce_account_menu_items', 'remove_orders_tab', 999);

function remove_orders_tab($items) {
    unset($items['orders']);
    // Add the custom menu item
    $new_items = array();

    // Get count of active jobs
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'author'         => get_current_user_id(),
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '='
            )
        ),
        'posts_per_page' => -1,
    );
    $active_jobs_query = new WP_Query($args);
    $active_jobs_count = $active_jobs_query->found_posts;

    // Get count of all posted jobs
    $all_jobs_args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'author'         => get_current_user_id(),
        'posts_per_page' => -1,
    );
    $all_jobs_query = new WP_Query($all_jobs_args);
    $all_jobs_count = $all_jobs_query->found_posts;

    foreach ($items as $key => $value) {
        if ($key === 'dashboard') {
            // Insert the custom menu item after the "Dashboard" menu item
            $new_items[$key] = $value;
            $new_items['active-jobs'] = sprintf(__('Active Jobs (%d)'), $active_jobs_count);
            $new_items['posted-jobs'] = sprintf(__('All Posted Jobs (%d)'), $all_jobs_count);
        } else {
            $new_items[$key] = $value;
        }
    }
    return $new_items;
}

add_action( 'init', 'active_jobs_endpoint' );
function active_jobs_endpoint() {
	add_rewrite_endpoint( 'active-jobs', EP_PAGES );
	add_rewrite_endpoint( 'posted-jobs', EP_PAGES );
}


add_action( 'woocommerce_account_active-jobs_endpoint', 'activejobs_my_account_endpoint_content' );
function activejobs_my_account_endpoint_content() {
    $template = locate_template('/templates/active-jobs.php');
    if ($template) {
        // Load the template file
        include $template;
    } else {
        // Fallback content if the template is not found
        echo '<p>' . __('No template found for Active Jobs.', 'text-domain') . '</p>';
    }
}

add_action( 'woocommerce_account_posted-jobs_endpoint', 'postedjobs_my_account_endpoint_content' );
function postedjobs_my_account_endpoint_content() {
    $template = locate_template('/templates/posted-jobs.php');
    if ($template) {
        // Load the template file
        include $template;
    } else {
        // Fallback content if the template is not found
        echo '<p>' . __('No template found for All Posted Jobs.', 'text-domain') . '</p>';
    }
}