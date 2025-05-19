<?php
//login button
function login_cb()
{
    ob_start();
?>
    <button class="login-button-header" style="padding:15px">
        <?php
        if (is_user_logged_in()) {
            echo '<a href="/referrify/my-account/" style="color:white;">Account</a>';
        } else {
            echo '<a href="/referrify/my-account/" style="color:white;">Sign In</a>';
        }
        ?>
    </button>
<?php
    return ob_get_clean();
}

add_shortcode('login_button', 'login_cb');

//banner category button / tags

function banner_category_buttons_cb()
{
    ob_start();
    $categories = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'orderby'    => 'name',
            'hide_empty' => false,
            'number'     => 5,
        )
    );
?><div class="job-category-nav-container"><?php
                                            if (! empty($categories) && ! is_wp_error($categories)) {
                                                foreach ($categories as $category) {

                                            ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="quick-category-banner"><?php echo esc_html($category->name); ?></a>
        <?php
                                                }
                                            } ?>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('banner_category_buttons', 'banner_category_buttons_cb');

function search_job()
{
    ob_start();
?>
    <div class='search-job-container'>
        <form role="search" method="get" class="search-job" action="<?php echo esc_url(home_url('/')); ?>">
            <!-- Jon Search Field -->
            <div class="search-job-dv">
                <input type="search" class="search-job-field"
                    placeholder="<?php echo esc_attr__('Enter skills', 'woocommerce'); ?>"
                    value="<?php echo get_search_query(); ?>" name="s" />
            </div>
            <!-- Location Field -->
            <div>
                <input type="text" class="location-field"
                    placeholder="<?php echo esc_attr__('Location', 'woocommerce'); ?>"
                    value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>" name="location" />
            </div>
            <!-- Submit Button -->
            <button type="submit" class="search-submit"><span><?php echo esc_html__('Search', 'woocommerce'); ?></span></button>

            <!-- Hidden job Type -->
            <input type="hidden" name="post_type" value="product" />
        </form>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('search_job', 'search_job');

/**
 * *Tooltip ShortCode
 * @param tooltip_description is required to show approriate tooltip description
 */

function tooltip_cb($attrs)
{
    ob_start();
?>
    <span class="tooltip_container">
        <span><i class="fa-regular fa-circle-question"></i></span>
        <span class="tooltiptext">
            <?php if (!isset($attrs['tooltip_description'])) {
                echo "No Tooltip desc provided.";
            } else {
                echo $attrs['tooltip_description'];
            } ?>
        </span>
    </span>
    <style>
        .tooltip_container {
            position: relative;
        }

        .tooltip_container .tooltiptext {
            visibility: hidden;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            /* Center the tooltip */
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
            height: 40px;
            width: 200px;
            min-width: 30px;
            font-weight: 300;
            line-height: 13px;
        }

        .tooltip_container:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
<?php
    return ob_get_clean();
}
add_shortcode('tooltip', 'tooltip_cb');

function card($atts) {    
     $defaults = array(
        'image' => '',
        'title' => '',
        'content' => '',
        'class' => '',
        'link' => '',
        'btn-text' => '',
    );
    // Merge user provided parameters with defaults
    $args = shortcode_atts($defaults, $atts);
        wp_enqueue_style(
        'referrify-card-style',
        get_stylesheet_directory_uri() . '/assets/css/card.css',
        array(),
        '1.0.0'
    );
    ob_start();
    ?>
    <div class="referrify-card">
        <div class="card-header">
        <?php if (!empty($args['image'])) : ?>
            <img src="<?php echo esc_url($args['image']); ?>" alt="<?php echo esc_attr($args['title']); ?>" class="card-image" />
        <?php endif; ?>
        <h5><?php echo esc_html($args['title']); ?></h5>
        </div>
        <div class="card-content">
            <p class="card-text"><?php echo esc_html($args['content']); ?></p>  
            <a href="<?php echo esc_url($args['link']);?>" class="card-btn"><?php echo $args['btn-text']; ?></a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('referrify_card', 'card');