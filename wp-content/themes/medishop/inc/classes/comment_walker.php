<?php
/**
 * Custom comment walker for this theme.
 *
 * @package WordPress
 * @subpackage medishop
 * @since medishop
 */

if ( ! class_exists( 'Medishop_Walker_Comment' ) ) {
	/**
	 * CUSTOM COMMENT WALKER
	 * A custom walker for comments, based on the walker in Twenty Nineteen.
	 */
	class Medishop_Walker_Comment extends Walker_Comment {

		/**
		 * Outputs a comment in the HTML5 format.
		 *
		 * @see wp_list_comments()
		 * @see https://developer.wordpress.org/reference/functions/get_comment_author_url/
		 * @see https://developer.wordpress.org/reference/functions/get_comment_author/
		 * @see https://developer.wordpress.org/reference/functions/get_avatar/
		 * @see https://developer.wordpress.org/reference/functions/get_comment_reply_link/
		 * @see https://developer.wordpress.org/reference/functions/get_edit_comment_link/
		 *
		 * @param WP_Comment $comment Comment to display.
		 * @param int        $depth   Depth of the current comment.
		 * @param array      $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {

			$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

			?>
			<<?php echo medishop_return($tag); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
					<div class="comment-meta comments_item">
						<div class="comment-author vcard comments_author_img">
							<?php
							$comment_author_url = get_comment_author_url( $comment );
							$comment_author     = get_comment_author( $comment );
							$avatar             = get_avatar( $comment, $args['avatar_size'] );

							$comment_reply_link = get_comment_reply_link(
								array_merge(
									$args,
									array(
										'add_below' => 'div-comment',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
									)
								)
							);

							if ( 0 !== $args['avatar_size'] ) {
								if ( empty( $comment_author_url ) ) {
									echo wp_kses_post( $avatar );
								} else {
									printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Escaped in https://developer.wordpress.org/reference/functions/get_comment_author_url/
									echo wp_kses_post( $avatar );
								}
							}

							if ( ! empty( $comment_author_url ) ) {
								echo '</a>';
							}
							?>
						</div><!-- .comment-author -->

						<div class="content">
							<?php
							
							printf(
								'<h4 class="fn">%1$s</h4><h4 class="screen-reader-text says">%2$s</h4>',
								esc_html( $comment_author ),
								__( 'says:', 'medishop' )
							);
							
							?>
							<div class="comment-date">
							<?php
							/* translators: 1: Comment date, 2: Comment time. */
							$comment_timestamp = sprintf( __( '%1$s at %2$s', 'medishop' ), get_comment_date( '', $comment ), get_comment_time() );

							printf(
								'<a href="%s"><time datetime="%s" title="%s">%s</time></a>',
								esc_url( get_comment_link( $comment, $args ) ),
								get_comment_time( 'c' ),
								esc_attr( $comment_timestamp ),
								esc_html( $comment_timestamp )
							);

							if ( get_edit_comment_link() ) {
								printf(
									' <span aria-hidden="true">&bull;</span> <a class="comment-edit-link" href="%s">%s</a>',
									esc_url( get_edit_comment_link() ),
									__( 'Edit', 'medishop' )
								);
							}
							?>

							</div>
							<?php

								comment_text();

								if ( '0' === $comment->comment_approved ) {
									?>
									<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'medishop' ); ?></p>
									<?php
								}

								if ( $comment_reply_link ) {
									echo medishop_return($comment_reply_link); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Link is escaped in https://developer.wordpress.org/reference/functions/get_comment_reply_link/
								}

						     ?>
							
                        </div>


					</div><!-- .comment-meta -->

					
				</article><!-- .comment-body -->

			<?php
		}
	}
}
