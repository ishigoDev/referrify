<?php
add_filter('woocommerce_account_menu_items', 'remove_orders_tab', 999);

function remove_orders_tab($items) {
    unset($items['orders']);
    return $items;
}
