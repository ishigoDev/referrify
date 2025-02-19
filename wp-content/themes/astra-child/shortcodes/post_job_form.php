<?php

function post_job_form_fn()
{
    ob_start();
    // Check if user is logged in
    if (!is_user_logged_in()) {
        // Get the login page URL
        $login_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        print_r($login_url);
        // Redirect to my-account page
        echo '<script>window.location.href = "' . esc_url($login_url) . '";</script>';
        exit;
    }
?>
    <div class="post-job-container">
        <div class="post-header">
            <h3 style="margin-bottom: 0;">
                Post Job
            </h3>
            <div class="heading-underline post-job-underline-width"></div>
        </div>
        <div class="post-form-body">
            <form method="post">
                <div class="referrify-form-field">
                    <label for="title" class="referrify-label">Job Title<span class="required" aria-hidden="true">*</span></label>
                    <input type="text" id="title" name="title" required>
                </div>
                <?php
                    $job_category_options = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                    ));
                ?>
                <div class="referrify-form-field">
                    <label for="category" class="referrify-label">Role<span class="required" aria-hidden="true">*</span>
                    </label>
                    <select id="category" name="category">
                        <option value="">Select Role</option>
                        <?php
                            if (!empty($job_category_options) && !is_wp_error($job_category_options)) {
                                foreach ($job_category_options as $job_category) {
                                    echo '<option value="'.$job_category->slug.'">' . esc_html($job_category->name).'</option>';
                                    }
                                }
                       ?>
                    </select>
                </div> 
                <?php
                    $locations_options = get_terms(array(
                        'taxonomy'   => 'location',
                        'hide_empty' => false,
                    ));
                ?>                              
                <div class="referrify-form-field">
                    <label for="location" class="referrify-label">Location <small class="file-format-hint">(India Only)</small><span class="required" aria-hidden="true">*</span></label>
                    <select id="location" name="location">
                        <option value="">Select City</option>
                        <?php
                            if (!empty($locations_options) && !is_wp_error($locations_options)) {
                                foreach ($locations_options as $location) {
                                    echo '<option value="'.$location->slug.'">' . esc_html($location->name).'</option>';
                                    }
                                }
                       ?>
                    </select>
                </div>
                <?php
                    $job_type_options = get_terms(array(
                        'taxonomy'   => 'job_type',
                        'hide_empty' => false,
                    ));
                ?>
                <div class="referrify-form-field">
                    <label for="type" class="referrify-label">Job Type<span class="required" aria-hidden="true">*</span></label>
                    <select id="job_type" name="job_type">
                        <option value="">Select Job Type</option>
                       <?php
                       if (!empty($job_type_options) && !is_wp_error($job_type_options)) {
                        foreach ($job_type_options as $job_type) {
                            echo '<option value="'.$job_type->slug.'">' . esc_html($job_type->name).'</option>';
                            }
                        }
                       ?>
                    </select>
                </div>
                <?php
                    $experience_options = get_terms(array(
                        'taxonomy'   => 'experience',
                        'hide_empty' => false,
                    ));
                ?>
                <div class="referrify-form-field">
                    <label for="experience" class="referrify-label">Experience<span class="required" aria-hidden="true">*</span></label>
                    <select id="experience" name="experience">
                        <option value="">Select Experience</option>
                        <?php
                            if (!empty($experience_options) && !is_wp_error($experience_options)) {
                                foreach ($experience_options as $experience) {
                                    echo '<option value="'.$experience->slug.'">' . esc_html($experience->name).'</option>';
                                    }
                                }
                       ?>
                    </select>
                </div>
                <div class="referrify-form-field">
                    <label for="salary" class="referrify-label">Salary <small class="file-format-hint">(INR)</small></label>
                    <input type="number" id="salary" name="salary">
                </div>                              
                <div class="referrify-form-field">
                    <label for="description" class="referrify-label">Description<span class="required" aria-hidden="true">*</span></label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="referrify-form-field">
                    <label for="image" class="referrify-label" >Image <small class="file-format-hint">(Supported formats: PNG, JPEG)</small></label>
                    <label for="image" class="company-file-upload">Choose File</label>
                    <input type="file" id="company-img" name="company_image">
                    <span id="selected-filename" class="selected-file"></span>
                </div>
                <button type="submit" class="referrify-btn">Post</button>
            </form>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('post_job_form', 'post_job_form_fn');


function register_additional_taxonomy() {
    // JobType
    $job_type_labels = array(
        'name'              => __('Job Type', 'referrify'),
        'singular_name'     => __('Job Type', 'referrify'),
        'search_items'      => __('Search Job Type', 'referrify'),
        'all_items'         => __('All Job Type', 'referrify'),
        'parent_item'       => __('Parent Job Type', 'referrify'),
        'parent_item_colon' => __('Parent Job Type:', 'referrify'),
        'edit_item'         => __('Edit Job Type', 'referrify'),
        'update_item'       => __('Update Job Type', 'referrify'),
        'add_new_item'      => __('Add Job Type', 'referrify'),
        'new_item_name'     => __('New Job Type', 'referrify'),
        'menu_name'         => __('Job Type', 'referrify'),
    );

    $job_type_args = array(
        'labels'            => $job_type_labels,
        'hierarchical'      => true, 
        'public'            => true,
        'show_ui'           => true,
        // 'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'job-type'),
    );
    register_taxonomy('job_type', 'product', $job_type_args);

    // Experience 
    $experience_labels = array(
        'name'              => __('Experience', 'referrify'),
        'singular_name'     => __('Experience', 'referrify'),
        'search_items'      => __('Search Experience', 'referrify'),
        'all_items'         => __('All Experience', 'referrify'),
        'parent_item'       => __('Parent Experience', 'referrify'),
        'parent_item_colon' => __('Parent Experience:', 'referrify'),
        'edit_item'         => __('Edit Experience', 'referrify'),
        'update_item'       => __('Update Experience', 'referrify'),
        'add_new_item'      => __('Add Experience', 'referrify'),
        'new_item_name'     => __('New Experience', 'referrify'),
        'menu_name'         => __('Experience', 'referrify'),
    );
    $experience_type_args = array(
        'labels'            => $experience_labels,
        'hierarchical'      => true, 
        'public'            => true,
        'show_ui'           => true,
        // 'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'experience'),
    );

    register_taxonomy('experience', 'product', $experience_type_args);

    //Location
    $location_labels = array(
        'name'              => __('Location', 'referrify'),
        'singular_name'     => __('Location', 'referrify'),
        'search_items'      => __('Search Location', 'referrify'),
        'all_items'         => __('All Location', 'referrify'),
        'parent_item'       => __('Parent Location', 'referrify'),
        'parent_item_colon' => __('Parent Location:', 'referrify'),
        'edit_item'         => __('Edit Location', 'referrify'),
        'update_item'       => __('Update Location', 'referrify'),
        'add_new_item'      => __('Add Location', 'referrify'),
        'new_item_name'     => __('New Location', 'referrify'),
        'menu_name'         => __('Location', 'referrify'),
    );  
    $location_args = array( 
        'labels'            => $location_labels,
        'hierarchical'      => true, 
        'public'            => true,
        'show_ui'           => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'location'),
    );
    register_taxonomy('location', 'product', $location_args);

    // Only proceed with cities update if cache is expired
    if (false === get_transient('indian_cities_terms_updated')) {
        print_r('indiand - pranay');
        update_indian_cities_taxonomy();
    }
}

add_action('init', 'register_additional_taxonomy');

function update_indian_cities_taxonomy() {
    $indian_cities = fetch_indian_cities();
    
    if (!empty($indian_cities)) {
        // Get existing cities that are being used in products
        $existing_terms = get_terms(array(
            'taxonomy' => 'location',
            'hide_empty' => true,
            'fields' => 'names' // Only get names, more efficient
        ));

        if (!is_wp_error($existing_terms)) {
            // Merge and filter cities
            $cities_to_add = array_diff(
                array_unique($indian_cities),
                is_array($existing_terms) ? $existing_terms : array()
            );

            // Batch insert new terms
            foreach ($cities_to_add as $city) {
                if (!term_exists($city, 'location')) {
                    wp_insert_term($city, 'location');
                }
            }
        }

        // Cache for 365 days
        set_transient('indian_cities_terms_updated', true, 365 * DAY_IN_SECONDS);
    }
}

function fetch_indian_cities() {
    // API endpoint for Indian cities
    $api_url = 'https://api.countrystatecity.in/v1/countries/IN/cities';
    
    $response = wp_remote_get($api_url, array(
        'headers' => array(
            'X-CSCAPI-KEY' => 'OVNhRTdWek5QUG5xNmV5clRSWDk3dG90bHhDU2k2a2psVzA3ZHgwRQ=='
        ),
        'timeout' => 15
    ));
    
    if (!is_wp_error($response) && 200 === wp_remote_retrieve_response_code($response)) {
        $cities_data = json_decode(wp_remote_retrieve_body($response), true);
        
        if (is_array($cities_data)) {
            return array_map(function($city) {
                return $city['name'];
            }, $cities_data);
        }
    }

    // Fallback cities if API fails
    return array(
        'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai',
        'Kolkata', 'Pune', 'Ahmedabad', 'Surat', 'Jaipur',
        'Bhopal', 'Indore', 'Lucknow', 'Kanpur', 'Nagpur',
        'Nashik', 'Faridabad', 'Meerut', 'Rajkot', 'Kalyan-Dombivali'
    );
}

function enqueue_post_job_scripts() {
    if (is_user_logged_in() && is_page('post-job')) {
    wp_enqueue_script('astra-child-theme-job-form', get_stylesheet_directory_uri() . '/assets/js/post_job_form.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
    wp_localize_script('astra-child-theme-job-form', 'jobformajax', array(
        'nonce' => wp_create_nonce('post_job_nonce'),
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_style('astra-child-theme-post-job-form', get_stylesheet_directory_uri() . '/assets/css/post_job_form.css', array(), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
}
}
add_action('wp_enqueue_scripts', 'enqueue_post_job_scripts');

function handle_post_job_submission() {;
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'post_job_nonce')) {
        wp_send_json_error('Invalid nonce');
        return;
    }
   
    // Handle file upload if present
    $company_image_url = '';
    $company_image_id = '';
    if (!empty($_FILES['company_image']['name'])) {
        // Debug file upload data
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        // Validate file type and size
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($_FILES['company_image']['type'], $allowed_types)) {
            wp_send_json_error('Invalid file type. Please upload a JPG, PNG or GIF image.');
            return;
        }

        if ($_FILES['company_image']['size'] > $max_size) {
            wp_send_json_error('File is too large. Maximum size is 5MB.');
            return;
        }
        $attachment_id = media_handle_upload('company_image', 0);
      
        if (!is_wp_error($attachment_id)) {
            $company_image_id = $attachment_id; 
            $company_image_url = wp_get_attachment_url($attachment_id);
        }
    }

    // Create post object
    $post_data = array(
        'post_title'    => sanitize_text_field($_POST['title']),
        'post_content'  => wp_kses_post($_POST['description']),
        'post_status'   => 'publish',
        'post_type'     => 'product'
    );

    // Insert the post into the database
    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
        // Set product type to simple
        wp_set_object_terms($post_id, 'simple', 'product_type');

        // Add product meta data
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, '_regular_price', sanitize_text_field($_POST['salary']));
        update_post_meta($post_id, '_price', sanitize_text_field($_POST['salary']));
        
        // Set product categories
        if (!empty($_POST['category'])) {
            wp_set_object_terms($post_id, intval($_POST['category']), 'product_cat');
        }
        if (!empty($_POST['location'])) {
            wp_set_object_terms($post_id, sanitize_text_field($_POST['location']), 'location');
        }
        if (!empty($_POST['job_type'])) {
            wp_set_object_terms($post_id, sanitize_text_field($_POST['job_type']), 'job_type');
        }
        if (!empty($_POST['experience'])) {
            wp_set_object_terms($post_id, sanitize_text_field($_POST['experience']), 'experience');
        }
        if (!empty($company_image_url)) {
            set_post_thumbnail($post_id, $company_image_id );
        }
        wp_send_json_success(array('post_id' => $post_id));
    } else {
        wp_send_json_error('Failed to create product');
    }
 
    wp_die();
}
add_action('wp_ajax_post_job_submission', 'handle_post_job_submission');
add_action('wp_ajax_nopriv_post_job_submission', 'handle_post_job_submission');

