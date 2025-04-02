<?php
function get_page_number() {
    $current_url = $_SERVER['REQUEST_URI'];
    if (preg_match('/page\/(\d+)/', $current_url, $matches)) {
        return (int)$matches[1];
    }
    return 1;
}

function get_draft_post_link($post_id) {
    return add_query_arg(
        array(
            'action' => 'draft_job',
            'post' => $post_id,
            'nonce' => wp_create_nonce('draft_job_' . $post_id)
        ),
        admin_url('admin-post.php')
    );
}

// Handle the draft action
add_action('admin_post_draft_job', 'handle_draft_job');
function handle_draft_job() {
    if (isset($_GET['post']) && isset($_GET['nonce'])) {
        $post_id = intval($_GET['post']);
        
        // Verify nonce
        if (wp_verify_nonce($_GET['nonce'], 'draft_job_' . $post_id)) {
            // Update post status to draft
            wp_update_post(array(
                'ID' => $post_id,
                'post_status' => 'draft'
            ));
        }
    }
    // Redirect back to the jobs page
    wp_redirect(wc_get_account_endpoint_url('posted-jobs'));
    exit;
}

function handle_hired_status() {
    if (isset($_GET['action']) && $_GET['action'] === 'mark_hired' && isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']);
        $product = wc_get_product($product_id);
        
        if ($product && current_user_can('edit_post', $product_id)) {
            // Update stock status to out of stock
            $product->set_stock_status('outofstock');
            $product->save();
            
            // Redirect back to the jobs page
            wp_redirect(wc_get_account_endpoint_url('posted-jobs'));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_hired_status');