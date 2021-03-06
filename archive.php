<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress_AMP_Theme
 */

get_header();
?>

	<main id="content" role="main" class="archive">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="mb1 page-title">', '</h1>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				?>
				<div class="mb2">
					<?php get_template_part( 'template-parts/content-archive', get_post_type() ); ?>
				</div>
				<?php
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content-archive', 'none' );

		endif;
		get_template_part( 'template-parts/social-share' );
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
