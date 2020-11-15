<?php
	$profiles = wp_amp_theme_get_social_media_profiles();
	if ( empty( $profiles ) ) {
		return;
	}
?>
<ul class="ampstart-social-follow list-reset flex justify items-center flex-wrap m0 mb4">
	<?php foreach ( $profiles as $social_site => $profile ) : ?>
		<li>
			<a href="<?php echo esc_url( $profile ) ?>" target="_blank" class="ampstart-icon inline-block p1" aria-label="">
				<?php echo file_get_contents( __DIR__ . "/../icons/social-$social_site.svg" ) ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
