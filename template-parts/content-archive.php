<?php
/**
 * Template part for displaying post archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress_AMP_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-article mb3 pb3' ); ?>>
	<header class="entry-header">
		<?php
			the_title( '<h2 class="mb1"><a class="text-decoration-none" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		if ( 'post' === get_post_type() ) :
			?>
			<address class="ampstart-byline clearfix mb3 h5">
				<?php
				wordpress_amp_theme_posted_on();
				wordpress_amp_theme_posted_by();
				?>
			</address>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php wordpress_amp_theme_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		wordpress_amp_theme_the_excerpt();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wordpress-amp-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
