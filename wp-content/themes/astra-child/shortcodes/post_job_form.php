<?php

function post_job_form_fn()
{
    ob_start();
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
                    <label for="title" class="referrify-label">Title<span class="required" aria-hidden="true">*</span></label>
                    <input type="text" id="title" name="title" required>
                </div>
                <?php
                    $job_category_options = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                    ));
                ?>
                <div class="referrify-form-field">
                    <label for="category" class="referrify-label">Category<span class="required" aria-hidden="true">*</span>
                    </label>
                    <select id="category" name="category">
                        <option value="">Select Category</option>
                        <?php
                            if (!empty($job_category_options) && !is_wp_error($job_category_options)) {
                                foreach ($job_category_options as $job_category) {
                                    echo '<option value="'.$job_category->slug.'">' . esc_html($job_category->name).'</option>';
                                    }
                                }
                       ?>
                    </select>
                </div>                               
                <div class="referrify-form-field">
                    <label for="location" class="referrify-label">Location<span class="required" aria-hidden="true">*</span></label>
                    <select id="location" name="location">
                        <option value="">Select City</option>
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
                    <label for="salary" class="referrify-label">Salary</label>
                    <input type="number" id="salary" name="salary">
                </div>                              
                <div class="referrify-form-field">
                    <label for="description" class="referrify-label">Description<span class="required" aria-hidden="true">*</span></label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="referrify-form-field">
                    <label for="image" class="referrify-label" >Image</label>
                    <label for="image" class="company-file-upload">Choose File</label>
                    <input type="file" id="company-img" name="company_image">
                </div>
                <button type="submit" class="referrify-btn">Post</button>
            </form>
        </div>
    </div>
<?php

    wp_enqueue_script('astra-child-theme-job-form', get_stylesheet_directory_uri() . '/assets/js/post_job_form.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true );
    wp_enqueue_style('astra-child-theme-post-job-form', get_stylesheet_directory_uri() . '/assets/css/post_job_form.css', array(), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
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
}
add_action('init', 'register_additional_taxonomy');
