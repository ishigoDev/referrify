<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
?>
<div class="myaccount-banner">
	<div class="myaccount-banner-content">
		<h4 style="color:white;">My Account</h4>
		<div>
			<p style="text-transform:capitalize;margin-bottom:0;">Hello <?php echo esc_html(wp_get_current_user()->display_name); ?>!</p>
			<p >You can manage your orders and profile from here.</p>
		</div>
	</div>
	<div class="myaccount-banner-content">
	<div  class="myaccount-banner-nav">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<div class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html( $label ); ?>
				</a>
		</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>

<?php
do_action( 'woocommerce_account_navigation' ); ?>

<div class="woocommerce-MyAccount-content">
	<?php
		/**
		 * My Account content.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
	?>
</div>
