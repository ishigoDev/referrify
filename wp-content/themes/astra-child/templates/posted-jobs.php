<?php
// Ensure WooCommerce is active
if (!defined('ABSPATH')) {
    exit;
}


$current_page =get_page_number();

// Get the current user ID
$user_id = get_current_user_id();
// Query products created by the logged-in user
$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 15,
    'paged'          => $current_page,
    'author'         => $user_id,
);

$query = new WP_Query($args);


    ?>
     <div class="wrap">
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th class="job-title"><?php _e('Job Title', 'woocommerce'); ?></th>
                    <th><?php _e('Role', 'woocommerce'); ?></th>
                    <th><?php _e('Location', 'woocommerce'); ?></th>
                    <th><?php _e('Experience', 'woocommerce'); ?></th>
                    <th class="price-column"><?php _e('Salary', 'woocommerce'); ?></th>
                    <th><?php _e('Actions', 'woocommerce'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php          
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $job = wc_get_product(get_the_ID());  
                        ?>
                        <tr>
                            <td class="job-title">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </td>
                            <td>
                                <?php
                                    $terms = get_the_terms(get_the_ID(), 'product_cat');
                                    if ($terms && !is_wp_error($terms)) {
                                        $categories = wp_list_pluck($terms, 'name');
                                        echo implode(', ', $categories);
                                    }
                                ?>
                            </td>
                            <td>    
                            <?php
                                $locations = get_the_terms(get_the_ID(), 'location');
                                if ($locations && !is_wp_error($locations)) {
                                    echo implode(', ', wp_list_pluck($locations, 'name'));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $experience = get_the_terms(get_the_ID(), 'experience');
                                    if ($experience && !is_wp_error($experience)) {
                                        echo implode(', ', wp_list_pluck($experience, 'name'));
                                    }
                                ?>
                            </td>
                            <td  class="price-column">   
                                <?php 
                                    $price = $job->get_price();
                                    echo (!empty($price)) ? wc_price($price) : '--';
                                ?>
                            </td>    
                            <td>
                                <a href="<?php echo get_edit_post_link(get_the_ID()); ?>"  class="btn-icon"><i class="fas fa-edit"></i></a> |
                                <a href="<?php echo get_delete_post_link(get_the_ID()); ?>" class="btn-icon btn-delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<tr><td colspan="6">' . __('No products found', 'woocommerce') . '</td></tr>';
                endif;
                ?>
            </tbody>
        </table>
        <div class="tablenav">
            <div class="tablenav-pages">
                <?php
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links(array(
                        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format'    => '?page=%#%',
                        'current'   => $current_page,
                        'total'     => $query->max_num_pages,
                        'type'      => 'plain',
                        'prev_next' => true,
                        'prev_text' => __('&laquo; Previous'),
                        'next_text' => __('Next &raquo;'),
                        'mid_size'  => 2,
                        'end_size'  => 1,
                    ));
                ?>
            </div>
        </div>
    </div>
    <?php
