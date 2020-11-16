<?php
$image = get_theme_mod( 'logo_upload' );
?>
<a href="<?php esc_url( home_url('/') ) ?>" class="mx-auto">
	<?php if ( ! empty ($image) ) : ?>
		<amp-img src="<?php echo esc_url($image) ?>" width="3rem" height="3rem" alt="<?php esc_attr( get_bloginfo( 'name' ) ) ?>"></amp-img>
	<?php else : ?>
		<?php echo esc_html( get_bloginfo( 'name' ) ) ?>
	<?php endif; ?>
</a>
