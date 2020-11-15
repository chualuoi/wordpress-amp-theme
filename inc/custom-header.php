<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package WordPress_AMP_Theme
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses wordpress_amp_theme_header_style()
 */
function wordpress_amp_theme_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'wordpress_amp_theme_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'wordpress_amp_theme_header_style',
			)
		)
	);
}
// add_action( 'after_setup_theme', 'wordpress_amp_theme_custom_header_setup' );

/**
 * Custom CSS to be added.
 */
function wordpress_amp_theme_custom_css() {

}

