<?php

class Walker_AMP_Category extends Walker_Category {
	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.1.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
	 * @param array  $args   Optional. An array of arguments. Will only append content if style argument
	 *                       value is 'list'. See wp_list_categories(). Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' !== $args['style'] ) {
			return;
		}

		// $output .= "<amp-accordion layout='container'>\n";
		if ( $this->has_children ) {
			$output .= '<ul class="ampstart-dropdown-items list-reset m0 p0">';
		} else {
			$output .= '<ul>';
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 2.1.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
	 * @param array  $args   Optional. An array of arguments. Will only append content if style argument
	 *                       value is 'list'. See wp_list_categories(). Default empty array.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' !== $args['style'] ) {
			return;
		}

		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 2.1.0
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Used to append additional content (passed by reference).
	 * @param object $category Category data object.
	 * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
	 * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
	 * @param int    $id       Optional. ID of the current category. Default 0.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

		// Don't generate an element if the category name is empty.
		if ( '' === $cat_name ) {
			return;
		}

		$atts         = array();
		$atts['href'] = get_term_link( $category );

		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filters the category description for display.
			 *
			 * @since 1.2.0
			 *
			 * @param string $description Category description.
			 * @param object $category    Category object.
			 */
			$atts['title'] = strip_tags( apply_filters( 'category_description', $category->description, $category ) );
		}

		/**
		 * Filters the HTML attributes applied to a category list item's anchor element.
		 *
		 * @since 5.2.0
		 *
		 * @param array   $atts {
		 *     The HTML attributes applied to the list item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $href  The href attribute.
		 *     @type string $title The title attribute.
		 * }
		 * @param WP_Term $category Term data object.
		 * @param int     $depth    Depth of category, used for padding.
		 * @param array   $args     An array of arguments.
		 * @param int     $id       ID of the current category.
		 */
		$atts = apply_filters( 'category_list_link_attributes', $atts, $category, $depth, $args, $id );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$link = sprintf(
			'<a%s>%s</a>',
			$attributes,
			$cat_name
		);


		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' === $args['style'] ) {
			if ( $this->has_children ) {
				$output .= '<li class="ampstart-nav-item ampstart-nav-dropdown relative "><amp-accordion layout="container" disable-session-states="" class="ampstart-dropdown"><section>
				<header>' . $cat_name . '</header>';
			} else {
				$output     .= "<li";
			}

			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( $depth == 0 ){
				$css_classes[] = 'ampstart-nav-item';
			} else {
				$css_classes[] = 'ampstart-dropdown-item';
			}

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms(
					array(
						'taxonomy'   => $category->taxonomy,
						'include'    => $args['current_category'],
						'hide_empty' => false,
					)
				);

				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat';
						$link          = str_replace( '<a', '<a aria-current="page"', $link );
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}

			/**
			 * Filters the list of CSS classes to include with each category in the list.
			 *
			 * @since 4.2.0
			 *
			 * @see wp_list_categories()
			 *
			 * @param array  $css_classes An array of CSS classes to be applied to each list item.
			 * @param object $category    Category data object.
			 * @param int    $depth       Depth of page, used for padding.
			 * @param array  $args        An array of wp_list_categories() arguments.
			 */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
			$css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';


			if ( ! $this->has_children ) {
				$output .= $css_classes;
				$output .= ">$link\n";
			}
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.1.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param object $page   Not used.
	 * @param int    $depth  Optional. Depth of category. Not used.
	 * @param array  $args   Optional. An array of arguments. Only uses 'list' for whether should append
	 *                       to output. See wp_list_categories(). Default empty array.
	 */
	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
		if ( 'list' !== $args['style'] ) {
			return;
		}
		if ( $this->has_children || $args['has_children'] ) {
			$output . '</section></amp-accordion>';
		}
		$output .= "</li>\n";
	}
}
