<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'themeboy' ), max( $paged, $page ) );

	?></title>
<meta http-equiv="Content-Type" content="<?php echo esc_attr( get_bloginfo( 'html_type' ) ); ?>; charset=<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php do_action('themeboy_after_body'); ?>
  
  <div class="off-canvas-wrap">
  <div class="inner-wrap">
  
  <?php do_action('themeboy_layout_start'); ?>

  <aside class="left-off-canvas-menu">
    <?php tb_mobile_nav(); ?>
  </aside>

  <nav class="tab-bar show-for-small-only">
    <section class="left-small">
      <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
    </section>
    <section class="middle tab-bar-section">
      
      <h1 class="title"><?php bloginfo( 'name' ); ?></h1>

    </section>
  </nav>

  <div id="page" class="hfeed site">
    <header id="masthead" class="site-header" role="banner">
      <div class="header-main"<?php if ( is_singular( array( 'page', 'sp_table', 'sp_list' ) ) && has_post_thumbnail() ): $src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'themeboy-wide-header' ); ?> style="background-image: url(<?php echo array_shift( $src ); ?>);"<?php endif; ?>>
        <div class="row">
          <?php $options = get_option( 'premier_theme_options', array() ); if ( tb_array_value( $options, 'show_logo', 1 ) ): ?>
          <div class="medium-3 columns">
            <div class="logo"><?php tb_logo(); ?></div>
          </div><!-- .columns -->
          <div class="medium-9 columns">
            <div class="site-navigation">
              <?php tb_top_nav(); ?>
            </div>
          </div><!-- .columns -->
          <?php else: ?>
          <div class="medium-12 columns">
            <div class="site-navigation">
              <?php tb_top_nav(); ?>
            </div>
          </div><!-- .columns -->
          <?php endif; ?>
        </div><!-- .row -->

        <div class="row">
          <div class="large-12 columns">
            <hgroup class="clearfix">
              <?php if ( is_tax( 'sp_venue' ) ) : ?>
              <h2 class="page-title"><?php _e( 'Venue', 'sportspress' ); ?></h2>
              <?php elseif ( is_category() ) : ?>
              <h2 class="page-title"><?php single_cat_title( '', true ); ?></h2>
              <?php elseif ( is_single() && $post_type && ! in_array( $post_type, array( 'page', 'sp_event', 'sp_calendar', 'sp_list' ) ) ) : $post_type = get_post_type_object( $post_type ); ?>
              <?php elseif ( is_single() && ! $post_type ): ?>
              <h2 class="page-title"><?php the_category( ' / ' ); ?></h2>
              <?php elseif ( ( is_page() && ! is_front_page() ) || ( is_single() && ! is_singular( 'post' ) ) ) : ?>
              <h2 class="page-title"><?php the_title(); ?></h2>
              <?php elseif ( is_archive() ) : ?>
              <h2 class="page-title">
                <?php
                  if ( is_day() ) :
                    printf( __( 'Daily Archives: %s', 'twentyfourteen' ), get_the_date() );

                  elseif ( is_month() ) :
                    printf( __( 'Monthly Archives: %s', 'twentyfourteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyfourteen' ) ) );

                  elseif ( is_year() ) :
                    printf( __( 'Yearly Archives: %s', 'twentyfourteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentyfourteen' ) ) );

                  else :
                    _e( 'Archives', 'twentyfourteen' );

                  endif;
                ?>
              </h2>
              <?php else : ?>
              <?php if ( get_bloginfo( 'description' ) ): ?><h2 class="description hide-for-small-only"><?php bloginfo( 'description' ); ?></h2><?php endif; ?>
              <?php endif; ?>
            </hgroup>
          </div><!-- .columns -->
        </div><!-- .row -->
      </div><!-- #header-main -->
    </header><!-- #masthead -->

    <div id="main" class="site-main">
      <?php do_action('themeboy_after_header'); ?>
      <?php if ( is_front_page() ): ?>
      <div class="infinity headline">
        <div class="row">
          <?php if ( is_active_sidebar( 'headline' ) ) : ?>
          <div id="headline-widgets" class="headline-widgets widget-area">
            <?php dynamic_sidebar( 'headline' ); ?>
          </div><!-- #headline-widgets -->
          <?php endif; ?>
        </div>
      </div><!-- .infinity -->
      <?php endif; ?>