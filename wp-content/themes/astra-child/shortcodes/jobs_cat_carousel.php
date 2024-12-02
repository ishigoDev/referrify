<?php
function jobs_cat_carousel_structure(){
    ob_start();
    $args = array(
        'taxonomy'     => 'product_cat',
        'hide_empty'   => false,        
        'number'     => 24,
    );
    $categories = get_terms( $args );
    $i = 0;
    echo '<div class="discover-role-container">';
    foreach ( $categories as $category ) {
        if ($i % 6 == 0) { 
            echo '<div class="discover-role-group">'; 
        }
        ?>
        <div class="role"><a class="discover-role-link" href="#"> <?php echo esc_html( $category->name ) ?></a><p class="role-jobs"><?php echo esc_html( $category->count)." Jobs";; ?> </p></div>
        <?php 
        if ($i % 6 == 5) { 
            echo '</div>'; 
        }
        $i++;
    }
    if ($i % 6 != 0) {
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}

add_shortcode('jobs_cat_carousel','jobs_cat_carousel_structure');


add_action('wp_enqueue_scripts', 'jobs_cat_enqueue_scripts');

function jobs_cat_enqueue_scripts(){
    wp_enqueue_script( 'job_role_script', get_stylesheet_directory_uri(). '/assets/js/job_role.js' );   
}