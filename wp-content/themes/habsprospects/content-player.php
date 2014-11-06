<?php
/**
 * @package sparkling
 */
?>

<article id="post-<?php the_ID(); ?>"class="single-player" <?php post_class(); ?>>
	<div class="row">
		<div class="col-md-5">

			<?php the_post_thumbnail( 'sparkling-featured', array( 'class' => 'single-featured' )); ?>
			
		</div>

		<div class="col-md-7">

			<div class="post-inner-content">
				<div class="entry-content">
				<header class="entry-header page-header">
					<h1 class="entry-title "><?php the_title(); ?>
					</h1>
				</header><!-- .entry-header -->
				<?php if ( function_exists( 'sportspress_output_player_intro' ) ) {
						sp_get_template( 'player-intro.php' );
					} ?>
				<?php if (  function_exists( 'sportspress_output_player_details' ) ) {
					sp_get_template( 'player-details.php' );
				} ?>
				</div>
			</div>
		</div><!-- .entry-content -->
	</div>
	<div class="row">
		
						<div class="post-inner-content">
				<div class="entry-content">
					<?php if ( get_field('ep_parser') ) :
							 $parser = get_field('ep_parser');
						?>

									<h2><?php _e( 'Statistics', 'themeboy' ); ?></h2>
									<?
										$rss = new SimpleXMLElement('http://eliteprospects.com/rss_player_stats.php?player='. $parser .'', null, true);
										foreach($rss->xpath('channel/item') as $item)
										{
										  echo  utf8_decode($item->description);
										}
									?>

						<?php endif; ?>
				</div>
	</div>
			</div>
</article><!-- #post-## -->
