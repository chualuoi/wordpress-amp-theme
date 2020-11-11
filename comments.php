<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress_AMP_Theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$wordpress_amp_theme_comment_count = get_comments_number();
?>
<section class="recipe-comments">
	<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
		?>
		  <h2 class="mb3"><?php echo esc_html( wp_sprintf( __("%d Responses"), $wordpress_amp_theme_comment_count ) )  ?></h2>
		  <?php the_comments_navigation(); ?>
		  <ul class="list-reset">
		  	<?php
			wp_list_comments(
				array(
					'style'      => 'li',
					'short_ping' => true,
				)
			);
			?>
            <li class="mb4">
              <h3 class="ampstart-subtitle">Sriram</h3>
              <span class="h5 block mb3">02.24.17 at 6:01 pm</span>
              <p>This is perfect for a summer patio party. Thanks for another great one!</p>
            </li>
            <li class="mb4">
              <h3 class="ampstart-subtitle">Eric</h3>
              <span class="h5 block mb3">02.24.17 at 5:14 am</span>
              <p>These were so good I woke up dreaming about them. Regards, Eric.</p>
            </li>
		  </ul>
		  <?php
			the_comments_navigation();

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() ) :
				?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wordpress-amp-theme' ); ?></p>
				<?php
			endif;
		endif; // Check for have_comments().

		comment_form();
		?>
</section>
