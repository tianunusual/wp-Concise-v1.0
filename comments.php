<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<?php
			// Get comments title.
			$comments_number = number_format_i18n( get_comments_number() );
			if ( '1' === $comments_number ) {
				$comments_title = esc_html__( '已有 1 个人评论' );
			} else {
				/* translators: %s: Comments number */
				$comments_title = sprintf( esc_html__( '已有 %s 个人评论' ), $comments_number );
			}
			$comments_title = apply_filters( 'lyboke_comments_title', $comments_title );
		?>		
		<h3 class="comments-title">
			<?php echo esc_html( $comments_title ); ?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( '评论分页' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( '上一页' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( '下一页' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
				    'callback'      =>'deel_comment_list',
					'style'      => 'ol',
					'short_ping' => true,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( '评论分页' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( '上一页' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( '下一页' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( '评论已关闭' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
