<?php
$image = get_theme_mod( 'logo_upload' );
?>
<a href="<?php esc_url( home_url('/') ) ?>" class="my1 mx-auto ">
	<?php if ( ! empty ($image) ) : ?>
		<amp-img src="<?php echo esc_url($image) ?>" width="48" height="48" alt="<?php esc_attr( get_bloginfo( 'name' ) ) ?>"></amp-img>

		<?php echo esc_html( get_bloginfo( 'name' ) ) ?>
	<?php endif; ?>
</a>
