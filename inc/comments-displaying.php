<?php
function aurel_comment( $comment, $args, $depth ) {
	global $ap_options;
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

<!-- begin #comment-<?php comment_ID(); ?>.comment-wrapper  -->
<div id="comment-<?php comment_ID(); ?>" class="comment-wrapper">

<!-- begin .comment-author.vcard -->
<div class="comment-author vcard">
<?php echo get_avatar( $comment, 64 ); ?>
</div>
<!-- end .comment-author.vcard -->

<!-- begin .comment-meta.commentmetadata -->
<div class="comment-meta commentmetadata">
	<?php
	echo( __('Author: ', 'thepalace') . get_comment_author_link() . '&nbsp;&nbsp//&nbsp&nbsp' );
	echo( __('Date: ', 'thepalace') . get_comment_date() . '&nbsp;&nbsp//&nbsp&nbsp' );
	echo( __('Time: ', 'thepalace') . get_comment_time() );
	comment_reply_link( array_merge( $args, array( 'after' => '</span>', 'before' => '<span class="reply">&nbsp;&nbsp//&nbsp&nbsp', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
	if ( $ap_options['ap_display_edit_link']['val'] == 'yes' ) {
		edit_comment_link( __( 'Edit comment', 'thepalace' ), '&nbsp;&nbsp//&nbsp&nbsp' );
	}
?>
</div>
<!-- end .comment-meta.commentmetadata -->

<?php if ( $comment->comment_approved == '0' ) : ?>
<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'thepalace' ); ?></em>
<br />
<?php endif; ?>

<div class="comment-body"><?php comment_text(); ?></div>

<div class="clear"></div>

</div>
<!-- end #comment-<?php comment_ID(); ?>.comment-wrapper  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	
<li class="pingback">

<!-- begin .comment-wrapper -->
<div class="comment-wrapper">
<?php 
_e( 'Pingback: ', 'thepalace' );  
comment_author_link(); 
if ( $ap_options['ap_display_edit_link']['val'] == 'yes' ) {
	edit_comment_link( __( 'Edit comment', 'thepalace' ), '&nbsp;&nbsp//&nbsp&nbsp' );
}
?>
</div>
<!-- end .comment-wrapper -->
	
	<?php
			break;
	endswitch;
}
?>