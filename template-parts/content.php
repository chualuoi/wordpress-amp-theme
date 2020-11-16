<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress_AMP_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-article' ); ?>>
	<?php if ( is_singular() ) : ?>
		<span class="ampstart-subtitle block px3 pt2 mb2 caps"><?php wordpress_amp_theme_entry_footer(); ?></span>
	<?php endif; ?>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="mb1 px3">', '</h1>' );
		else :
			the_title( '<h2 class="mb2 px3"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<address class="ampstart-byline clearfix mb4 px3 h5">
				<?php
				wordpress_amp_theme_posted_on();
				wordpress_amp_theme_posted_by();
				?>
			</address>
			<div class="right">
				<?php get_template_part( 'template-parts/social-share' ); ?>
			</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php wordpress_amp_theme_post_thumbnail(); ?>

	<div class="entry-content px3">
		<?php
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

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wordpress-amp-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
