<?php
/**
 * The Template for displaying all single staff posts
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
	$staff = new SP_Staff( $post );

	$show_nationality_flags = get_option( 'sportspress_staff_show_flags', 'yes' ) == 'yes' ? true : false;

	$role = get_post_meta( $post->ID, 'sp_role', true );
	$nationality = get_post_meta( $post->ID, 'sp_nationality', true );
	$current_teams = (array) get_post_meta( $post->ID, 'sp_current_team' );
	$past_teams = (array) get_post_meta( $post->ID, 'sp_past_team' );
	$leagues = (array) get_the_terms( $post->ID, 'sp_league' );
	$seasons = (array) get_the_terms( $post->ID, 'sp_season' );
	
	$country_name = tb_array_value( SP()->countries->countries, $nationality, null );

	$common = array();

	$common[ __( 'Role', 'sportspress' ) ] = $role;
	$common[ __( 'Nationality', 'sportspress' ) ] = $country_name ? ( $show_nationality_flags ? '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . '/assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '"> ' : '' ) . $country_name : '&mdash;';

	if ( count( $current_teams ) == 1 ):
		$current_team = array_shift( $current_teams );
		$common[ __( 'Current Team', 'sportspress' ) ] = get_the_title( $current_team );
	elseif ( count( $current_teams ) > 1 ):
		$current_team = array_shift( $current_teams );
		$teams = array( get_the_title( $current_team ) );
		foreach( $current_teams as $team ):
			$teams[] = get_the_title( $team );
		endforeach;
		$common[ __( 'Current Teams', 'sportspress' ) ] = implode( '<br>', $teams );;
	endif;

	if ( count( $past_teams ) >= 1 ):
		$teams = array();
		foreach( $past_teams as $team ):
			$teams[] = get_the_title( $team );
		endforeach;
		$common[ __( 'Past Teams', 'sportspress' ) ] = implode( '<br>', $teams );;
	endif;
?>

<div class="infinity team-name">
	<div class="row">
		<div class="small-9 columns">
			<h2><a href="<?php echo get_permalink( $current_team ); ?>"><?php the_title(); ?></a></h2>
		</div>
		<?php if ( isset( $current_team ) ): ?>
		<div class="small-3 columns">
			<a href="<?php echo get_post_permalink( $current_team ); ?>" class="team-logo"><?php echo get_the_post_thumbnail( $current_team, 'sportspress-fit-thumbnail' ); ?></a>
		</div>
		<?php endif; ?>
	</div>
</div><!-- .infinity -->

<div id="content" class="site-content" role="main">
	<div class="staff-main">
		<div class="row">
			<div class="large-4 medium-6 columns">
				<div class="staff-photo">
					<?php the_post_thumbnail( 'themeboy-square-thumbnail', array( 'class' => 'fill-image' ) ); ?>
				</div>
				<div class="infobox details">
					<?php foreach ( $common as $label => $value ): if ( $value == null ) continue; ?>
						<small><?php echo $label; ?></small>
						<h4><?php echo $value; ?></h4>
					<?php endforeach; ?>
				</div>
				<?php if ( has_excerpt() ): ?>
				<div class="sp-excerpt">
					<?php echo apply_filters( 'the_content', get_the_excerpt() ); ?>
				</div>
				<?php endif; ?>
			</div><!-- .columns -->
			<?php if ( get_the_content() ): ?>
			<div class="large-8 columns">
				<div class="infobox">
					<div class="entry-content">
						<h2><?php _e( 'Profile', 'themeboy' ); ?></h2>
						<?php the_content(); ?>
					</div>
				</div>
			</div><!-- .columns -->
			<?php endif; ?>
		</div><!-- .row -->
	</div><!-- .staff-main -->
</div><!-- #content -->
<?php endwhile; ?>

<?php get_footer();
