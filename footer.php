<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress_AMP_Theme
 */
?>

<footer class="ampstart-footer flex flex-column items-center px3 ">
	<nav class="ampstart-footer-nav">
		<?php get_template_part( 'template-parts/footer-menu' ); ?>
	</nav>
	<small>
	© <a href="https://www.chualuoi.com">https://www.chualuoi.com</a>, 2020
	</small>
</footer>

<?php wp_footer(); ?>

</body>
</html>
