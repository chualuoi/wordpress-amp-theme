<?php
	$avatar_method = get_theme_mod( 'avatar_method' );
	if ( ! in_array( $avatar_method, ['gravatar', 'upload'] ) ) {
		return;
	}
	if ( $avatar_method == 'gravatar' ) {
		$avatar = get_avatar( get_option( 'admin_email' ) );
		// use regex to grab source from <img /> markup
		if ( class_exists( 'WP_User_Avatar' ) ) {
			preg_match( '/src="([^"]*)"/i', $avatar, $matches );
		} else {
			preg_match( "/src='([^']*)'/i", $avatar, $matches );
		}
		$avatar = $matches[1];
	} elseif ( $avatar_method == 'upload' ) {
		$avatar = get_theme_mod( 'avatar' );
	}

	if ( empty( $avatar ) ) {
		return;
	}
?>
<amp-img class="site-avatar"
		src="<?php echo esc_url( $avatar ); ?>" width="144" height="144">
</amp-img>
