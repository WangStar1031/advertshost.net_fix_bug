<?php
/**
 * A custom WordPress comment walker class to implement the Bootstrap 3 Media object in wordpress comment list.
 *
 * @package     WP Bootstrap Comment Walker
 * @version     1.0.0
 * @author      Edi Amin <to.ediamin@gmail.com>
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link        https://github.com/ediamin/wp-bootstrap-comment-walker
 */

class Bootstrap_Comment_Walker extends Walker_Comment {
	/**
	 * Output a comment in the HTML5 format.
	 *
	 * @access protected
	 * @since 1.0.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>		
		<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent media' : 'media' ); ?>>

			<?php if ( 0 != $args['avatar_size'] ): ?>
			<div class="media-left">
			<?php
			$user_ID = $comment->user_id;			
			$author_avatar_url = get_user_meta($user_ID, "classify_author_avatar_url", true);
			$author_avatar_url = classiera_get_profile_img($author_avatar_url);
			if(empty($author_avatar_url)){
				$author_id = get_the_author_meta('user_email', $user_ID);
				$author_avatar_url = classiera_get_avatar_url ($author_id, $size = '150' );
			}
			if($user_ID == 0){				
				$useremail = $comment->comment_author_email;				
				$author_avatar_url = classiera_get_avatar_url ($useremail, $size = '150' );				
			}
			global $redux_demo;
			$classieraProfileURL = $redux_demo['profile'];
			if (function_exists('icl_object_id')){ 
				$templateProfile = 'template-profile.php';
				$classieraProfileURL = classiera_get_template_url($templateProfile);
			}
			?>
				<a href="<?php echo get_comment_link(); ?>" class="media-object">
					<img class="media-object img-thumbnail" src="<?php echo esc_url($author_avatar_url); ?>">
				</a>
			</div>
			<?php endif; ?>

			<div class="media-body" id="div-comment-<?php comment_ID(); ?>">
				<h5 class="media-heading"><?php echo get_comment_author_link(); ?> &nbsp; 
					<span class="normal"><?php esc_html_e( 'Said', 'classiera') ?> :</span>
					<span class="time pull-right flip"><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'classiera'), get_comment_date(), get_comment_time() ); ?></span>
				</h5>
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation label label-info">
					<?php _e( 'Your comment is awaiting moderation.', 'classiera'); ?>
				</p>
				<?php endif; ?>
				<?php comment_text(); ?>
				<!-- .comment-content -->
				<?php					
					comment_reply_link( array_merge( $args, array(
							'add_below' => 'media-body',
							'reply_text' => esc_html__( 'Reply to comment', 'classiera' ),
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<h5 class="text-right flip"><i class="fa fa-mail-forward"></i>&nbsp;',
							'after'     => '</h5>'
					) ) );	
				?>
				<div class="reply-comment-div">
					<button type="button" class="reply-tg-button btn btn-primary btn-md btn-style-one sharp"><?php esc_html_e( 'close reply', 'classiera' );?></button>
					<div class="comment-form">
						<div class="classiera--loader">
							<img src="<?php echo get_template_directory_uri().'/images/loader180.gif' ?>">
						</div>
						<div class="alert alert-success comment-success">
							<?php esc_html_e('Success! Thanks for your comment. We appreciate your response.', 'classiera') ?>
						</div>
						<div class="alert alert-danger comment-error">
							<?php esc_html_e('You might have left one of the fields blank, or be posting too quickly', 'classiera') ?>
						</div>
						<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentformSUB" class="addComment">
							<div class="form-inline row">
								<?php if ( is_user_logged_in()){ ?>
								<?php $classieraCurUser = wp_get_current_user();?>
								<p>
								<?php esc_html_e( 'Logged in as', 'classiera' );?>					
								<a href="<?php echo esc_url($classieraProfileURL); ?>">
									<?php echo esc_attr($classieraCurUser->user_login);?>
								</a>&nbsp;
								<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php wp_kses(__( 'Log out of this account', 'classiera' ), $allowed); ?>"><?php esc_html_e( 'Log out &raquo;', 'classiera' ); ?></a>
								</p>
							<?php }else{ ?>
								<div class="form-group col-sm-7">
									<label class="text-capitalize"> <?php esc_html_e( 'Name','classiera' ); ?>: <span class="text-danger">*</span> </label>
									<div class="inner-addon left-addon">
										<input type="text" name="author" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter name','classiera' ); ?>" data-error="<?php esc_html_e( 'name required','classiera' ); ?>" required value="<?php echo esc_attr( $comment_author ); ?>">
										<div class="help-block with-errors"></div>
									</div>
								</div><!--Name-->
								<div class="form-group col-sm-7">
									<label class="text-capitalize"><?php esc_html_e( 'Email','classiera' ); ?> : <span class="text-danger">*</span></label>
									<div class="inner-addon left-addon">
										<input type="text" name="email" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'Enter email','classiera' ); ?>" data-error="<?php esc_html_e( 'email required','classiera' ); ?>" required value="<?php echo esc_attr( $comment_author_email ); ?>">
										<div class="help-block with-errors"></div>
									</div>
								</div><!--eMAIL-->
								<div class="form-group col-sm-7">
									<label class="text-capitalize"><?php esc_html_e( 'Website','classiera' ); ?> : <span class="text-danger">*</span> </label>
									<div class="inner-addon left-addon">
										<input type="url" name="url" class="form-control form-control-sm" placeholder="<?php esc_html_e( 'enter website url','classiera' ); ?>" value="<?php echo esc_attr( $comment_author_url ); ?>">
									</div>
								</div><!--Phone-->
							<?php } ?>
								<div class="form-group col-sm-12">
									<label class="text-capitalize"><?php esc_html_e( 'Message','classiera' ); ?> : <span class="text-danger">*</span></label>
									<div class="inner-addon">
										<textarea data-error="<?php esc_html_e( 'Type your comment here', 'classiera') ?>" name="comment" placeholder="<?php esc_html_e( 'Type your comment here...', 'classiera') ?>" required></textarea>
										<div class="help-block with-errors"></div>
									</div>
								</div><!--Message-->
								<?php global $post; ?>
								<input type="hidden" id="comment_parent" name="comment_parent" value="<?php comment_ID(); ?>">
								<input type="hidden" id="comment_post_ID" name="comment_post_ID" value="<?php echo ($post->ID); ?>">
							</div>
							 <div class="form-group">
								<button type="submit" name="submit" class="btn btn-primary sharp btn-md btn-style-one" value="<?php esc_attr_e( 'Send', 'classiera' ); ?>"><?php esc_html_e( 'Post Comment','classiera' ); ?></button>
							</div>			
							<?php do_action( 'comment_form', $post->ID ); ?>
							
						</form>
					</div>
				</div>
			</div><!--mediabody-->		
<?php
	}	
}
