<?php
/**
 * WordPress AMP Theme Theme Customizer
 *
 * @package WordPress_AMP_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wordpress_amp_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'wordpress_amp_theme_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'wordpress_amp_theme_customize_partial_blogdescription',
			)
		);
	}

	/***** Avatar *****/

	// section
	$wp_customize->add_section( 'wp_amp_theme_avatar', array(
		'title'    => __( 'Avatar', 'wp_amp_theme' ),
		'priority' => 15
	) );
	// setting
	$wp_customize->add_setting( 'avatar_method', array(
		'default'           => 'none',
		'sanitize_callback' => 'wp_amp_theme_sanitize_avatar_method'
	) );
	// control
	$wp_customize->add_control( 'avatar_method', array(
		'label'       => __( 'Avatar image source', 'wp_amp_theme' ),
		'section'     => 'wp_amp_theme_avatar',
		'settings'    => 'avatar_method',
		'type'        => 'radio',
		'description' => __( 'Gravatar uses the admin email address.', 'wp_amp_theme' ),
		'choices'     => array(
			'gravatar' => __( 'Gravatar', 'wp_amp_theme' ),
			'upload'   => __( 'Upload an image', 'wp_amp_theme' ),
			'none'     => __( 'Do not display avatar', 'wp_amp_theme' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'avatar', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'avatar', array(
			'label'    => __( 'Upload your avatar', 'wp_amp_theme' ),
			'section'  => 'wp_amp_theme_avatar',
			'settings' => 'avatar'
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = wp_amp_theme_social_network_settings();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'wp_amp_theme_social_media_icons', array(
		'title'       => __( 'Social Media Account', 'wp_amp_theme' ),
		'priority'    => 35,
		'description' => __( 'Add the URL for each of your social profiles.', 'wp_amp_theme' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $label ) {
		$setting_id = 'wp_amp_theme_social_media_' . $social_site;
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $setting_id, array(
				'sanitize_callback' => 'wp_amp_theme_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $setting_id, array(
				'label'    => $label,
				'section'  => 'wp_amp_theme_social_media_icons',
				'priority' => $priority,
			) );
		} else {
			// setting
			$wp_customize->add_setting( $setting_id, array(
				'sanitize_callback' => 'esc_url_raw'
			) );
			// control
			$wp_customize->add_control( $setting_id, array(
				'type'     => 'url',
				'label'    => $label,
				'section'  => 'wp_amp_theme_social_media_icons',
				'priority' => $priority
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/** Social Share settings */
	$wp_customize->add_section( 'wp_amp_theme_social_share', array(
		'title'       => __( 'Social Share', 'wp_amp_theme' ),
		'priority'    => 45,
		'description' => __( 'Select social media to display social share buttons', 'wp_amp_theme' )
	) );

	$social_medias = wp_amp_theme_social_share();
	$wp_customize->add_setting( 'wp_amp_theme_social_share', array(
		'default'           => array( 'system', 'facebook', 'twitter', 'linkedin' ),
		'sanitize_callback' => 'wp_amp_theme_sanitize_social_share_setting',
	) );

	require_once __DIR__ . '/class-customize-multichekbox-control.php';
	// control
	$wp_customize->add_control( new Customize_MultiChecbox_Control (
		$wp_customize, 'wp_amp_theme_social_share', array(
			'label'    => __( 'Share on', 'wp_amp_theme' ),
			'section'  => 'wp_amp_theme_social_share',
			'settings' => 'wp_amp_theme_social_share',
			'type'     => 'multi-checkbox',
			'choices'  => $social_medias,
		)
	));

	wp_amp_theme_customize_reading( $wp_customize );
}
add_action( 'customize_register', 'wordpress_amp_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wordpress_amp_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wordpress_amp_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wordpress_amp_theme_customize_preview_js() {
	wp_enqueue_script( 'wordpress-amp-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'wordpress_amp_theme_customize_preview_js' );

if ( ! function_exists( 'wp_amp_theme_social_network_settings' ) ) {
	function wp_amp_theme_social_network_settings() {

		$social_sites = array(
			'twitter'       => __( 'Twitter', 'wp_amp_theme' ),
			'facebook'      => __( 'Facebook', 'wp_amp_theme' ),
			'linkedin'      => __( 'Linkedin', 'wp_amp_theme' ),
			'github'        => __( 'Github', 'wp_amp_theme' ),
			'instagram'     => __( 'Instagram', 'wp_amp_theme' ),
			'pinterest'     => __( 'Pinterest', 'wp_amp_theme' ),
			'youtube'       => __( 'YouTube', 'wp_amp_theme' ),
			'rss'           => __( 'RSS', 'wp_amp_theme' ),
			'email'         => __( 'Email', 'wp_amp_theme' ),
			'phone'    		=> __( 'Phone', 'wp_amp_theme' ),
			'behance'       => __( 'Behance', 'wp_amp_theme' ),
			'medium'        => __( 'Medium', 'wp_amp_theme' ),
		);

		return apply_filters( 'wp_amp_theme_social_network_settings', $social_sites );
	}
}

if ( ! function_exists( 'wp_amp_theme_social_share' ) ) {
	function wp_amp_theme_social_share() {

		$social_sites = array(
			'twitter'       => __( 'Twitter', 'wp_amp_theme' ),
			'facebook'      => __( 'Facebook', 'wp_amp_theme' ),
			'linkedin'      => __( 'Linkedin', 'wp_amp_theme' ),
			'instagram'     => __( 'Instagram', 'wp_amp_theme' ),
			'pinterest'     => __( 'Pinterest', 'wp_amp_theme' ),
			'email'         => __( 'Email', 'wp_amp_theme' ),
		);

		return apply_filters( 'wp_amp_theme_social_share', $social_sites );
	}
}


function wp_amp_theme_sanitize_social_share_setting( $input ) {

	$social_medias = wp_amp_theme_social_share();

	foreach ( $input as $selection ) {
		return array_key_exists( $selection, $social_medias ) ? $input : '';
	}
}

function wp_amp_theme_get_social_media_profiles() {
	$active_sites = [];
	$social_sites = wp_amp_theme_social_network_settings();
	foreach ( $social_sites as $social_site => $name ) {
		if ( strlen( get_theme_mod( 'wp_amp_theme_social_media_' . $social_site ) ) > 0 ) {
			$active_sites[ $social_site ] = get_theme_mod( 'wp_amp_theme_social_media_' . $social_site );
		}
	}
	return $active_sites;
}

function wp_amp_theme_sanitize_avatar_method( $input ) {

	$valid = array(
		'gravatar' => __( 'Gravatar', 'wp_amp_theme' ),
		'upload'   => __( 'Upload an image', 'wp_amp_theme' ),
		'none'     => __( 'Do not display avatar', 'wp_amp_theme' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function wp_amp_theme_customize_reading( $wp_customize ) {
	/***** Blog *****/

	// section
	$wp_customize->add_section( 'wp_amp_theme_reading', array(
		'title'    => _x( 'Reading', 'noun: the blog section',  'wp_amp_theme' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'wp_amp_theme_sanitize_radio'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'wp_amp_theme' ),
		'section'  => 'wp_amp_theme_reading',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'wp_amp_theme' ),
			'no'  => __( 'No', 'wp_amp_theme' )
		)
	) );

	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '100',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'wp_amp_theme' ),
		'section'  => 'wp_amp_theme_reading',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue reading', 'wp_amp_theme' ),
		'sanitize_callback' => 'sanitize_text_field'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More link text', 'wp_amp_theme' ),
		'section'  => 'wp_amp_theme_reading',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );
}


function wp_amp_theme_sanitize_radio( $input, $setting ){

	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key($input);

	//get the list of possible radio box options
	$choices = $setting->manager->get_control( $setting->id )->choices;

	//return input if valid or return default option
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}
