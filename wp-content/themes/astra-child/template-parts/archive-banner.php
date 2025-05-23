<?php

/**
 * Template part for displaying archive post's entry banner.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 4.0.0
 */

$astra_post_type      = ! empty($args) && ! empty($args['post_type']) ? $args['post_type'] : strval(get_post_type());
$astra_banner_control = 'ast-dynamic-archive-' . esc_attr($astra_post_type);

// If description is the only meta available in structure & its blank then no need to render banner markup.
$astra_archive_structure       = astra_get_option($astra_banner_control . '-structure', array($astra_banner_control . '-title', $astra_banner_control . '-description'));
$astra_get_archive_description = astra_get_archive_description($astra_post_type);
if (1 === count($astra_archive_structure) && in_array($astra_banner_control . '-description', $astra_archive_structure) && empty($astra_get_archive_description)) {
	return;
}

// Conditionally updating data section & class.
$astra_attr = 'class="ast-archive-entry-banner"';
if (is_customize_preview()) {
	$astra_attr = 'class="ast-archive-entry-banner ast-post-banner-highlight site-header-focus-item" data-section="' . esc_attr($astra_banner_control) . '"';
}

$astra_layout_type = astra_get_option($astra_banner_control . '-layout');
$astra_data_attrs  = 'data-post-type="' . $astra_post_type . '" data-banner-layout="' . $astra_layout_type . '"';

if ('layout-2' === $astra_layout_type && 'custom' === astra_get_option($astra_banner_control . '-banner-width-type', 'fullwidth')) {
	$astra_data_attrs .= 'data-banner-width-type="custom"';
}

$astra_background_type = astra_get_option($astra_banner_control . '-banner-image-type', 'none');
if ('layout-2' === $astra_layout_type && 'none' !== $astra_background_type) {
	$astra_data_attrs .= 'data-banner-background-type="' . $astra_background_type . '"';
}

?>

<section <?php echo wp_kses_post($astra_attr . ' ' . $astra_data_attrs); ?>>
	<div class="ast-container">
		<?php
		if (is_customize_preview()) {
			Astra_Builder_UI_Controller::render_banner_customizer_edit_button();
		}
		if (!is_archive())
			astra_banner_elements_order();
		else {
			$page_id = get_page_by_path('/jobs')->ID;
			$page_title = get_the_title($page_id);
			$total_products = wp_count_posts('product')->publish;
		?>
			<div class="job-banner-container" style="background-image: url('<?php echo get_the_post_thumbnail_url($page_id, 'full'); ?>');">
				<div class="job-banner-titles">
					<h2 style="margin-bottom:0.2rem;"><?php echo esc_html($page_title); ?></h2>
					<span class='quick-category-banner'><?php echo $total_products.' Jobs Founded'; ?></span>
				</div>
				<div class="job-search-container"><?php echo do_shortcode('[search_job]'); ?></div>
			</div>
		<?php
		}
		?>
	</div>
</section>