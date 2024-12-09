<?php
//login button
function login_cb(){
	ob_start();
	?>
	<button class="login-button-header" style="padding:15px">
	<?php  
	if(is_user_logged_in()){
		echo '<a href="/referrify/my-account/" style="color:white;">Account</a>';
	}else{
		echo '<a href="/referrify/my-account/" style="color:white;">Sign In</a>';
	}
	?>
	</button>
	<?php
    return ob_get_clean();
}

add_shortcode('login_button','login_cb');

//banner category button / tags

function banner_category_buttons_cb(){
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
     if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        foreach ( $categories as $category ) {
            
        ?>
          <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="quick-category-banner"><?php echo esc_html( $category->name ); ?></a>
        <?php
        }
     }?>
     </div>
     <?php
    return ob_get_clean();
}

add_shortcode('banner_category_buttons','banner_category_buttons_cb');

function search_job(){
    ob_start();
    ?>
    <div class='search-job-container'>
    <form role="search" method="get" class="search-job" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <!-- Jon Search Field -->
     <div class="search-job-dv">
    <input type="search" class="search-job-field" 
           placeholder="<?php echo esc_attr__( 'Enter skills', 'woocommerce' ); ?>" 
           value="<?php echo get_search_query(); ?>" name="s" />
    </div>
    <!-- Location Field -->
    <div>
    <input type="text" class="location-field" 
           placeholder="<?php echo esc_attr__( 'Location', 'woocommerce' ); ?>" 
           value="<?php echo isset( $_GET['location'] ) ? esc_attr( $_GET['location'] ) : ''; ?>" name="location" />
    </div>
    <!-- Submit Button -->
    <button type="submit" class="search-submit"><span><?php echo esc_html__( 'Search', 'woocommerce' ); ?></span></button>
    
    <!-- Hidden job Type -->
    <input type="hidden" name="post_type" value="product" />
</form>
</div>
    <?php
    return ob_get_clean();
}

add_shortcode('search_job','search_job');