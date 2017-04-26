<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
            
            <?php echo esc_html__( 'Comments', 'simple-elegant' ); ?>
            <span class="sep">&middot;</span>
            <?php echo get_comments_number(); ?>
            
		</h2>

		<?php withemes_comment_nav(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 72,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php withemes_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'simple-elegant' ); ?></p>
	<?php endif; ?>

	<?php 

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$fields = array();

$fields[ 'author' ] =  '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'simple-elegant' ) . '</label> ' .
( $req ? '<span class="required screen-reader-text">*</span>' : '' ) .
'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
'" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Name', 'simple-elegant' ) . ( $req ? ' *' : '' ) .  '" /></p>';

$fields[ 'email' ] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'simple-elegant' ) . '</label> ' .
( $req ? '<span class="required screen-reader-text">*</span>' : '' ) .
'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
'" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Email', 'simple-elegant' ) . ( $req ? ' *' : '' ) . '" /></p>';

$fields[ 'url' ] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'simple-elegant' ) . '</label>' .
'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
'" size="30" placeholder="' . esc_html__( 'Website', 'simple-elegant' ) . '" /></p>';

comment_form( array(
        
    'comment_field' =>  '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . _x( 'Comment', 'noun','simple-elegant' ) .
        '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__( 'Comment', 'simple-elegant' ) . ' *' . '"></textarea></p>',

    'fields' => $fields,

    'logged_in_as' => '',
    'comment_notes_before' => '',

) ); ?>

</div><!-- .comments-area -->
