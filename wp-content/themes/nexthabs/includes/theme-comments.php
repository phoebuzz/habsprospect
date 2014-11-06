<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Comment Template.
 *
 * Overrides the default comment template
 *
 * @since  	3.0
 * @return 	void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_comment' ) ) {
	function tb_comment( $comment, $args, $depth ) {
	   $GLOBALS['comment'] = $comment; ?>

		<li <?php comment_class(); ?>>

	    	<a name="comment-<?php comment_ID() ?>"></a>

	      	<div id="li-comment-<?php comment_ID() ?>" class="comment-container">

		   		<div class="comment-entry"  id="comment-<?php comment_ID(); ?>">
					<?php comment_text(); ?>
					<?php if ( $comment->comment_approved == '0' ) { ?>
		                <p class='unapproved'><?php _e( 'Your comment is awaiting moderation.', 'themeboy' ); ?></p>
		            <?php } ?>

		            <div class="comment-head">

						<?php if( get_comment_type() == 'comment' ) { ?>
		                	<div class="avatar"><?php echo get_avatar( $comment, apply_filters( 'tb_comment_avatar_size', $size = 128 ) ); ?></div>
		            	<?php } ?>

		                <span class="name"><?php comment_author_link(); ?></span>
		                <span class="date"><a href="<?php echo get_comment_link(); ?>" title="<?php esc_attr_e( 'Direct link to this comment', 'themeboy' ); ?>"><?php echo get_comment_date( get_option( 'date_format' ) ); ?> <?php _e( 'at', 'themeboy' ); ?> <?php echo get_comment_time( get_option( 'time_format' ) ); ?></a></span>
		                <span class="edit"><?php edit_comment_link(__( 'Edit', 'themeboy' ), '', '' ); ?></span>

					</div><!-- /.comment-head -->

					<div class="reply">
		            	<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		        	</div><!-- /.reply -->

				</div><!-- /comment-entry -->

			</div><!-- /.comment-container -->

	<?php
	} // End tb_comment()
}

/**
 * Trackback / Ping template.
 *
 * Overrides the default trackback / ping template
 *
 * @since  	3.0
 * @return 	void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_list_pings' ) ) {
	function tb_list_pings( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment; ?>

		<li id="comment-<?php comment_ID(); ?>">
			<span class="author"><?php comment_author_link(); ?></span> -
			<span class="date"><?php echo get_comment_date( get_option( 'date_format' ) ); ?></span>
			<span class="pingcontent"><?php comment_text(); ?></span>

	<?php
	} // End tb_list_pings()
}