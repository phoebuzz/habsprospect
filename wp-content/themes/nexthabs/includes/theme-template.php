<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Template
 *
 * Functions used by the theme to display template components
 *
 * @since   1.0.0
 * @author 	ThemeBoy
 */

/**
 * Display breadcrumbs.
 *
 * Display breadcrumbs on all pages except the homepage unless specified otherwise via tb_breadcrumbs filter.
 *
 * @since  	1.0.0
 * @return 	void
 * @uses  	tb_breadcrumbs()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_display_breadcrumbs' ) ) {
	function tb_display_breadcrumbs() {
		if ( apply_filters( 'tb_breadcrumbs', true ) && ! is_home() ) {
		echo '<section id="breadcrumbs">';
			tb_breadcrumbs();
		echo '</section><!--/#breadcrumbs -->';
		}
	} // End tb_display_breadcrumbs()
} // End IF Statement
add_action( 'tb_main_before', 'tb_display_breadcrumbs', 10 );

/**
 * Post author.
 *
 * Display the post author and the date the post was published.
 *
 * @since 	1.0.0
 * @uses 	the_time(), get_option(), the_author_posts_link()
 * @return  void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_post_author' ) ) {
	function tb_post_author() {
		global $post;

		?>
		<aside class="post-meta-author">
			<p>
				<?php echo get_avatar( $post->post_author, 96 ); ?>
				<span><?php the_time( get_option( 'date_format' ) ); ?></span><br />
				<span class="by"><?php _e( 'by', 'themeboy' ) ?></span>
				<span><?php the_author_posts_link(); ?></span>
			</p>
		</aside>
		<?php
	}
}

/**
 * Post meta.
 *
 * Display post date, author, category and comments.
 *
 * @since 	1.0.0
 * @uses 	the_category(), comments_popup_link()
 * @return  void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_post_meta' ) ) {
	function tb_post_meta() {
		?>
		<aside class="post-meta">
			<ul>
				<li class="post-category">
					<?php the_category( ' ' ) ?>
				</li>
				<li class="comments">
					<?php comments_popup_link( __( 'no comments', 'themeboy' ), __( '1 comment', 'themeboy' ), __( '% comments', 'themeboy' ) ); ?>
				</li>
				<?php the_tags( '<li class="tags">', ' ', '</li>' ); ?>
			</ul>
		</aside>
		<?php
	}
}

/**
 * Comment form.
 *
 * Display post comment form.
 *
 * @since 	1.0.0
 * @param   $args array
 * @param   $post_id int
 * @uses 	get_the_ID(), wp_get_current_commenter(), wp_get_current_user()
 * @return  void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_comment_form' ) ) {
	function tb_comment_form( $args = array(), $post_id = null ) {
		if ( null === $post_id )
			$post_id = get_the_ID();
		else
			$id = $post_id;

		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );
		if ( ! isset( $args['format'] ) )
			$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html5    = 'html5' === $args['format'];
		$fields   =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'themeboy' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'themeboy' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			            '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'themeboy' ) . '</label> ' .
			            '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
		);

		$fields = apply_filters( 'comment_form_default_fields', $fields );
		$defaults = array(
			'fields'               => $fields,
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'themeboy' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'themeboy' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'themeboy' ) . '</p>',
			'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'themeboy' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => __( 'Leave a Reply', 'themeboy' ),
			'title_reply_to'       => __( 'Leave a Reply to %s', 'themeboy' ),
			'cancel_reply_link'    => __( 'Cancel reply', 'themeboy' ),
			'label_submit'         => __( 'Post Comment', 'themeboy' ),
			'format'               => 'xhtml',
		);

		$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

		?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php
			do_action( 'comment_form_before' );
			?>
			<div id="respond" class="comment-respond">
				<h3 id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php
					do_action( 'comment_form_must_log_in_after' );
					?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?>>
						<div class="row">
							<?php
							do_action( 'comment_form_top' );
							?>
							<?php
							echo '<div class="large-12 columns">' . apply_filters( 'comment_form_field_comment', $args['comment_field'] ) . '</div>' . "\n";
							?>
							<?php if ( is_user_logged_in() ) : ?>
								<?php
								echo '<div class="large-12 columns">' . apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ) . '</div>' . "\n";
								?>
								<?php
								do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
								?>
							<?php else : ?>
								<?php echo '<div class="large-12 columns">' . $args['comment_notes_before'] . '</div>' . "\n"; ?>
								<?php
								do_action( 'comment_form_before_fields' );
								foreach ( (array) $args['fields'] as $name => $field ) {
									echo '<div class="large-6 columns">' . apply_filters( "comment_form_field_{$name}", $field ) . '</div>' . "\n";
								}
								do_action( 'comment_form_after_fields' );
								?>
							<?php endif; ?>
							<?php echo '<div class="large-12 columns">' . $args['comment_notes_after'] . '</div>' . "\n"; ?>
							<p class="form-submit">
								<div class="large-6 large-offset-6 columns"><input name="submit" class="button expand" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" /></div>
								<?php comment_id_fields( $post_id ); ?>
							</p>
							<?php
							do_action( 'comment_form', $post_id );
							?>
						</div><!-- .row -->
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php
			do_action( 'comment_form_after' );
		else :
			do_action( 'comment_form_comments_closed' );
		endif;
	}
}

function tb_excerpt_more( $more ) {
	return '...';
}

/**
 * Archive Description.
 *
 * Display a description, if available, for the archive being viewed (category, tag, other taxonomy).
 *
 * @since 	1.0.0
 * @uses 	do_atomic(), get_queried_object(), term_description()
 * @return  string
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_archive_description' ) ) {
	function tb_archive_description ( $echo = true ) {
		do_action( 'tb_archive_description' );

		// Archive Description, if one is available.
		$description = '';

		if ( ! is_post_type_archive() ) {

			if ( get_queried_object() != null ) {
				$term_obj 		= get_queried_object();
				$description 	= term_description( $term_obj->term_id, $term_obj->taxonomy );
			} else {
				$description 	= '';
			}

		}

		if ( $description != '' ) {
			// Allow child themes/plugins to filter here ( 1: text in DIV and paragraph, 2: term object )
			$description = apply_filters( 'tb_archive_description', '<div class="archive-description">' . $description . '</div><!--/.archive-description-->', $term_obj );
		}

		if ( $echo != true ) { return $description; }

		echo $description;
	} // End tb_archive_description()
}

/**
 * Query venue events.
 *
 * Get all events from a venue to use table pagination
 *
 * @since 	1.0.0
 * @author 	ThemeBoy
 */
function tb_query_venue_events( $query ) {
    if ( $query->is_archive() && array_key_exists( 'sp_venue', $query->query ) ) {
    	$query->set( 'posts_per_page', -1 );
    }
}

/**
 * Top Navigation.
 *
 * Display the top navigation if a menu is set.
 *
 * @since  	1.0.0
 * @return 	void
 * @uses  	wp_nav_menu()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_top_nav' ) ) {
function tb_top_nav() {
	wp_nav_menu(array(
		'depth' => 6,                                   // limit the depth of the nav
//		'sort_column' => 'menu_order',                  // sort column
//		'container' => 'ul',                            // nav container
//		'menu_id' => 'main-nav',                        // adding custom nav class
		'menu_class' => 'nav-menu hide-for-small',      // adding custom nav class
		'theme_location' => 'primary',                  // where it's located in the theme
	));
} // End tb_top_nav()
}

/**
 * Mobile off-canvas Navigation.
 *
 * Display the top navigation if a menu is set.
 *
 * @since  	1.0.0
 * @return 	void
 * @uses  	wp_nav_menu()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_mobile_nav' ) ) {
function tb_mobile_nav() {
	wp_nav_menu(array(
		'depth' => 6,                                   // limit the depth of the nav
//		'sort_column' => 'menu_order',                  // sort column
//		'container' => 'ul',                            // nav container
		'menu_class' => 'off-canvas-list',              // adding custom nav class
		'theme_location' => 'primary',                  // where it's located in the theme
	));
} // End tb_mobile_nav()
}

/**
 * Display logo.
 *
 * Display a custom logo if specified in the Theme Options.
 *
 * @since  	1.0.0
 * @return 	void
 * @uses  	global $tb_options array of Theme Options
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_get_logo' ) ) {
	function tb_get_logo() {
		$tb_options = get_option( 'premier_theme_options' );
		if ( isset( $tb_options['logo'] ) && ! is_null( $tb_options['logo'] ) ):
			$src = $tb_options['logo'];
		else:
			$src = get_template_directory_uri() . '/images/logo.png';
		endif;

		return '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . $src . '" class="logo-image" title="' . get_bloginfo( 'name' ) . '"></a>';
	} // End tb_get_logo()
}

if ( ! function_exists( 'tb_logo' ) ) {
	function tb_logo() {
		echo tb_get_logo();
	} // End tb_logo()
}

/**
 * Single Post Navigation.
 *
 * Provides links to next / previous posts.
 *
 * @since  	1.0.0
 * @return 	void
 * @uses  	previous_post_link(), next_post_link()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_single_post_nav' ) ) {
	function tb_single_post_nav() {
		if ( is_single() ) {
		?>
		<nav id="post-entries" class="fix">
	        <div class="nav-prev fl"><?php previous_post_link( '%link', __( 'Previous', 'themeboy' ) ); ?></div>
	        <div class="nav-next fr"><?php next_post_link( '%link', __( 'Next', 'themeboy' ) ); ?></div>
	    </nav><!-- #post-entries -->
		<?php
		}
	}
}

/**
 * Darken color.
 *
 * Returns darkened color.
 *
 * @since  	1.0.0
 * @author 	ThemeBoy
 */
if (!function_exists('tb_darken')) {
	function tb_darken( $color, $dif = 10 ){
		$color = str_replace( '#', '', $color );
		if ( strlen( $color ) != 6 ){ return '#000'; }
		$rgb = '';	 
		for ( $x = 0; $x < 3; $x ++ ){
			$c = hexdec( substr( $color,( 2 * $x ), 2 ) ) - $dif;
			$c = ( $c < 0 ) ? 0 : dechex( $c );
			$rgb .= ( strlen( $c ) < 2 ) ? '0' . $c : $c;
		}	 
		return '#' . $rgb;
	}
}

/**
 * Lighten color.
 *
 * Returns lightened color.
 *
 * @since  	1.0.0
 * @author 	ThemeBoy
 */
if (!function_exists('tb_lighten')) {
	function tb_lighten( $color, $dif = 10 ){
		$color = str_replace( '#', '', $color );
		if ( strlen( $color ) != 6 ){ return '#fff'; }
		$rgb = '';	 
		for ( $x = 0; $x < 3; $x ++ ){
			$c = hexdec( substr( $color,( 2 * $x ), 2 ) ) + $dif;
			$c = ( $c > 255 ) ? 'ff' : dechex( $c );
			$rgb .= ( strlen( $c ) < 2 ) ? '0' . $c : $c;
		}	 
		return '#' . $rgb;
	}
}

/**
 * Convert hex color to rgba.
 *
 * Returns rgba.
 *
 * @since  	1.0.0
 * @author 	ThemeBoy
 */
if (!function_exists('tb_hex2rgba')) {
	function tb_hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if(empty($color))
	          return $default; 

		//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }
}
