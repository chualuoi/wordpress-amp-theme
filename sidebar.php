<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress_AMP_Theme
 */
?>

<!-- Start Sidebar -->
<amp-sidebar id="header-sidebar" class="ampstart-sidebar px3  " layout="nodisplay">
  <div class="flex justify-start items-center ampstart-sidebar-header">
    <div role="button" aria-label="close sidebar" on="tap:header-sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger items-start">✕</div>
  </div>
  	<nav class="ampstart-sidebar-nav ampstart-nav">
		  <?php get_template_part( 'template-parts/categories' ); ?>
	</nav>
  	<?php get_template_part( 'template-parts/avatar' ); ?>
	<?php get_template_part( 'template-parts/social-media-profiles' ); ?>
    <?php get_template_part( 'template-parts/sidebar-menu' ) ?>
</amp-sidebar>
<!-- End Sidebar -->
