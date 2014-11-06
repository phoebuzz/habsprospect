<?php
/**
 * @package habsprospects
 */
?>

<?php if ( get_field('birthdate') ) : ?>
	<div class="player-info">
		<span><?php _e('Birthdate', 'habsprospect');?></span>
		<h4><?php the_field('birthdate'); ?></h4>
	</div>
<?php endif; ?>

<?php if ( get_field('birthplace') ) : ?>
	<div class="player-info">
		<span><?php _e('Birthplace', 'habsprospect');?></span>
		<h4><?php the_field('birthplace'); ?></h4>
	</div>
<?php endif; ?>

<?php if ( get_field('draft_year') ) : ?>
	<div class="player-info">
		<span><?php _e('Draft Year', 'habsprospect');?></span>
		<h4><?php the_field('draft_year'); ?></h4>
	</div>
<?php endif; ?>

<?php if ( get_field('drafted') ) : ?>
	<div class="player-info">
		<span><?php _e('Drafted', 'habsprospect');?></span>
		<h4><?php the_field('drafted'); ?></h4>
	</div>
<?php endif; ?>

<?php if ( get_field('player_height') ) : ?>
	<div class="player-info">
		<span><?php _e('Height', 'habsprospect');?></span>
		<h4><?php the_field('player_height'); ?></h4>
	</div>
<?php endif; ?>

<?php if ( get_field('weight') ) : ?>
	<div class="player-info">
		<span><?php _e('Weight', 'habsprospect');?></span>
		<h4><?php the_field('weight'); ?></h4>
	</div>
<?php endif; ?>