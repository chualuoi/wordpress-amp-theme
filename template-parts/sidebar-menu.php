<?php
	if ( ! function_exists( 'wordpress_amp_theme_sidebar_menu_css' ) ) {
		function wordpress_amp_theme_sidebar_menu_css ( $classes, $item, $args ) {
			if ( $args->theme_location !== 'sidebar-menu' ) {
				return $classes;
			}
			$classes[] = 'ampstart-faq-item';
			return $classes;
		}
		add_filter( 'nav_menu_css_class', 'wordpress_amp_theme_sidebar_menu_css', 10, 3 );
	}
	if ( ! function_exists( 'wordpress_amp_theme_sidebar_menu_link_attributes' ) ) {
		function wordpress_amp_theme_sidebar_menu_link_attributes ( $attrs, $item, $args ) {
			if ( $args->theme_location !== 'sidebar-menu' ) {
				return $attrs;
			}
			$attrs['class'] = 'text-decoration-none';
			return $attrs;
		}
		add_filter( 'nav_menu_link_attributes', 'wordpress_amp_theme_sidebar_menu_link_attributes', 10, 3 );
	}

	wp_nav_menu( [
		'theme_location' => 'sidebar-menu',
		'depth'          => 1,
		'menu_class'	 => 'ampstart-sidebar-faq list-reset m0'
	] );
?>

