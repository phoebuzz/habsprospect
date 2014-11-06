<?php
/**
 * Player Gallery Thumbnail
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */
?>
<div class="<?php if ( isset( $class ) ) echo $class; ?>">
	<div class="player-post">
		<div class="ImageWrapper">
			<a href="<?php echo get_post_permalink( $id ); ?>">


				<?php
				if( has_post_thumbnail( $id ) )
					echo get_the_post_thumbnail( $id, 'themeboy-square-thumbnail', array( 'class' => 'profile-photo fill-image' ) );
				else
					echo '<img width="150" height="150" src="http://www.gravatar.com/avatar/?s=150&d=mm&f=y" class="attachment-thumbnail wp-post-image profile-photo fill-image">';
				?>
				<div class="PStyleH"></div>
				<h5 class="image-caption-alt">
					<?php
					$number = get_post_meta( $id, 'sp_number', true );
					if ( $number != null ): ?>
					<span class="player-number"><?php echo $number; ?></span>
					<?php endif; ?>
					<?php echo get_the_title( $id ); ?>
				</h5>
			</a>    
		</div>
	</div>
</div><!-- .columns -->