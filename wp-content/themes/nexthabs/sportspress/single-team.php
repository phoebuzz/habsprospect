<?php
/**
 * The template for displaying single teams
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */

get_header();

while ( have_posts() ) : the_post();

$team = new SP_Team( get_the_ID() );
?>

<div class="infinity team-name">
	<div class="row">
		<div class="small-9 columns">
			<h2><?php the_title(); ?></h2>
		</div>
		<div class="small-3 columns">
			<a href="<?php the_permalink(); ?>" class="team-logo"><?php the_post_thumbnail( 'sportspress-fit-thumbnail' ); ?></a>
		</div>
	</div>
</div><!-- .infinity -->

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-8 columns">
			<?php if ( get_the_content() ): ?>
			<div class="infobox">
				<div class="entry-content">
					<h2><?php _e( 'Profile', 'themeboy' ); ?></h2>
					<?php the_content(); ?>
				</div>
			</div>
			<?php endif; ?>
			<?php sp_get_template( 'team-lists.php' ); ?>
			<?php sp_get_template( 'team-tables.php' ); ?>
			<?php if ( has_excerpt() ): ?>
			<div class="sp-excerpt">
				<?php echo apply_filters( 'the_content', get_the_excerpt() ); ?>
			</div>
			<?php endif; ?>
		</div><!-- .columns -->
		<div class="large-4 columns">
			<?php 
			$next_event = $team->next_event();
			if ( $next_event ):
			?>
			<div class="widget widget_sp_countdown">
				<h2 class="widget-title"><?php _e( 'Next Event', 'themeboy' ); ?></h2>
				<?php sp_get_template( 'countdown.php', array( 'id' => $next_event->ID ) ); ?>
			</div>
			<?php
			endif;

			$leagues = get_the_terms( get_the_ID(), 'sp_league' );
			$seasons = get_the_terms( get_the_ID(), 'sp_season' );
			if ( ! empty( $leagues ) || ! empty( $seasons ) ):
			?>
			<div class="infobox-alt">
				<?php
					if ( ! empty( $leagues ) ):
						$names = array();
						foreach( $leagues as $term ):
							$names[] = $term->name;
						endforeach;
				?>
				<h2 class="widget-title"><?php _e( 'Leagues', 'themeboy' ); ?></h2>
					<p><?php echo implode( ', ', $names ); ?></p>
				<?php endif; ?>

				<?php
					if ( ! empty( $seasons ) ):
						$names = array();
						foreach( $seasons as $term ):
							$names[] = $term->name;
						endforeach;
				?>
				<h2 class="widget-title"><?php _e( 'Seasons', 'themeboy' ); ?></h2>
					<p><?php echo implode( ', ', $names ); ?></p>
				<?php endif;
			endif; ?>
			</div>
			<?php sp_get_template( 'team-link.php' ); ?>
		</div><!-- .columns -->
	</div><!-- .row -->
</div><!-- #content -->
<?php endwhile; ?>

<?php get_footer();
