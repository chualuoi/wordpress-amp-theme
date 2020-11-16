<?php
/**
 * Template part to display social share icons on the site.
 */

$social_shares = wp_amp_theme_social_share();
$enabled_social_shares = get_theme_mod( 'wp_amp_theme_social_share' );
?>

<amp-social-share
	type="<?php echo esc_attr( 'system' ) ?>"
	aria-label="<?php esc_html__( 'Share', 'wp_amp_theme' ); ?>">
</amp-social-share>
<?php if ( !empty( $enabled_social_shares ) ) : ?>
	<?php foreach ( $enabled_social_shares as $type ) : ?>
		<amp-social-share
			type="<?php echo esc_attr( $type ) ?>"
			aria-label="<?php echo esc_html( sprintf( __( 'Share on $1', 'wp_amp_theme' ), $social_shares[$type] ) ); ?>">
		</amp-social-share>
	<?php endforeach; ?>
<?php endif; ?>
