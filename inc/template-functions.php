<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress_AMP_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wordpress_amp_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'wordpress_amp_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wordpress_amp_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wordpress_amp_theme_pingback_header' );

/**
 * Customize excerpt length.
 *
 * @param int $length Excerpt length.
 * @return int Customized excerpt length.
 */
function wordpress_amp_theme_excerpt_length( $length ) {

	$new_excerpt_length = get_theme_mod( 'excerpt_length' );

	if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 100 ) {
		return $new_excerpt_length;
	}
	if ( $new_excerpt_length === 0 ) {
		return 0;
	}
	return 100;
}
add_filter( 'excerpt_length', 'wordpress_amp_theme_excerpt_length', 99 );


function wordpress_amp_theme_the_excerpt() {
	global $post;
	$show_full_post = get_theme_mod( 'full_post' );
	$ismore         = strpos( $post->post_content, '<!--more-->' );

	if ( $show_full_post === 'yes' ) {
		global $more;
		$more = 0;
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wordpress-amp-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		return;
	}
	the_excerpt();

}
