<?php
	if ( ! function_exists( 'wordpress_amp_theme_footer_menu_css' ) ) {
		function wordpress_amp_theme_footer_menu_css ( $classes, $item, $args ) {
			if ( $args->theme_location !== 'footer-menu' ) {
				return $classes;
			}
			$classes[] = 'px1';
			return $classes;
		}
		add_filter( 'nav_menu_css_class', 'wordpress_amp_theme_footer_menu_css', 10, 3 );
	}
	if ( ! function_exists( 'wordpress_amp_theme_footer_menu_link_attributes' ) ) {
		function wordpress_amp_theme_footer_menu_link_attributes ( $attrs, $item, $args ) {
			if ( $args->theme_location !== 'footer-menu' ) {
				return $attrs;
			}
			$attrs['class'] = 'text-decoration-none ampstart-label';
			return $attrs;
		}
		add_filter( 'nav_menu_link_attributes', 'wordpress_amp_theme_footer_menu_link_attributes', 10, 3 );
	}

	wp_nav_menu( [
		'theme_location' => 'footer-menu',
		'depth'          => 1,
		'menu_class'     => 'list-reset flex flex-wrap mb3'
	] );
?>

