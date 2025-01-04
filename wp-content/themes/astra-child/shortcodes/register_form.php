<?php
//Register User Shortcode
function referrify_woocommerce_registration_form()
{
    wp_enqueue_script('wc-password-strength-meter');
    wp_enqueue_style('woocommerce-general');
    wp_enqueue_style('woocommerce-layout');
    wp_enqueue_style('woocommerce-smallscreen');

    ob_start();

?>

    <div class="register-form-container">
        <h3><?php esc_html_e('Register', 'woocommerce'); ?></h3>
        <div class="heading-underline"></div>
        <div class="u-column2 col-2">
            <div class="woocommerce">
                <form method="post" class="woocommerce-form woocommerce-form-register register shortcode-register-snippet" <?php do_action('woocommerce_register_form_tag'); ?>>

                    <?php do_action('woocommerce_register_form_start'); ?>

                    <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                                            ?>
                        </p>

                    <?php endif; ?>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="linkedin_url"><?php esc_html_e('LinkedIn Profile Url', 'woocommerce'); ?>&nbsp;<span><?php echo do_shortcode('[tooltip tooltip_description="LinkedIn Profile is required to connect the job seekers with you"]'); ?></span><span class="required" aria-hidden="true" style="margin-left:2px;">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="linkedin_url" id="linkedin_url" value="<?php echo (! empty($_POST['linkedin_url'])) ? esc_attr(wp_unslash($_POST['linkedin_url'])) : ''; ?>" required aria-required="true" />
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                                                            ?>
                    </p>

                    <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
                        </p>

                    <?php else : ?>

                        <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

                    <?php endif; ?>
                    <?php do_action('woocommerce_register_form'); ?>

                    <p class="woocommerce-form-row form-row">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                    </p>

                    <?php do_action('woocommerce_register_form_end'); ?>

                </form>
            </div>
        </div>
        <?php
        do_action('woocommerce_after_customer_login_form');
        ?>
    </div>

<?php
    return ob_get_clean();
}
add_shortcode('referrify_register', 'referrify_woocommerce_registration_form');

//validation of register form
add_action('woocommerce_register_post', 'register_additional_customer_information_validation', 10, 3);

function register_additional_customer_information_validation($username, $email, $errors)
{

    if (empty($_POST['linkedin_url'])) {
        $errors->add('linkedin_url', 'Linked In Profile is required!');
    }
}

/* 
* Submit additional information of customer 
*/

function register_additional_customer_informations_submission($customer_id)
{
    //Linked IN URL fields for user
    print_r($_POST['linkedin_url']);
    if (wp_verify_nonce(sanitize_text_field($_REQUEST['woocommerce-register-nonce']), 'woocommerce-register')) {

        if (isset($_POST['linkedin_url'])) {
            update_user_meta($customer_id, 'linkedin_url', sanitize_text_field($_POST['linkedin_url']));
        }
    }
}

add_action('woocommerce_created_customer', 'register_additional_customer_informations_submission');

/*
* Adding the additional information on User profile page in admin dashboard
*/

function show_additional_user_information_profile_field($user)
{
?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="linkedin_url">LinkedIn URL</label></th>
            <td>
                <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo esc_attr(get_the_author_meta('linkedin_url', $user->ID)); ?>" class="regular-text" /><br />
                <span class="description">Please enter your LinkedIn URL.</span>
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'show_additional_user_information_profile_field');
add_action('edit_user_profile', 'show_additional_user_information_profile_field');

/**
 * *Save and edit on User profile in admin dashboard
 */
function save_additional_user_information_profile_field($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'linkedin_url', sanitize_text_field($_POST['linkedin_url']));
}
add_action('personal_options_update', 'save_additional_user_information_profile_field');
add_action('edit_user_profile_update', 'save_additional_user_information_profile_field');

/**
 * *Adding the Additional User Information on My account page
 */
add_action('woocommerce_edit_account_form_fields', 'user_additional_information_account_detail', 20);
function user_additional_information_account_detail()
{
    $user = wp_get_current_user();
?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide linked_in_url">
        <label for="linkedin_profile_url"><?php esc_html_e('Linkedin Profile Url', 'woocommerce'); ?><span><?php echo do_shortcode('[tooltip tooltip_description="LinkedIn Profile is required to connect the job seekers with you"]'); ?></span><span class="required" aria-hidden="true" style="margin-left:2px;">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="linkedin_profile_url" id="linkedin_profile_url" value="<?php echo (! empty($_POST['linkedin_url'])) ? esc_attr(wp_unslash($_POST['linkedin_url'])) : esc_attr(get_user_meta($user->ID, 'linkedin_url', true)); ?>" required aria-required="true" />
    </p>
<?php
}

add_action('woocommerce_save_account_details', 'save_user_addition_information_account_detail');
function save_user_addition_information_account_detail($user_id)
{
    if (isset($_POST['linkedin_profile_url'])) {
        update_user_meta($user_id, 'linkedin_url', sanitize_text_field($_POST['linkedin_profile_url']));
    }
}

function user_addition_information_account_detail_required_fields($required_fields)
{
    $required_fields['linkedin_profile_url'] = 'Linkedin Profile Url is a required field.';
    return $required_fields;
}
add_filter('woocommerce_save_account_details_required_fields', 'user_addition_information_account_detail_required_fields');
