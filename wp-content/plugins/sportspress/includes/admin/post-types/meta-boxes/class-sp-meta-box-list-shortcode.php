<?php
/**
 * List Shortcode
 *
 * @author 		ThemeBoy
 * @category 	Admin
 * @package 	SportsPress/Admin/Meta_Boxes
 * @version     0.7.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * SP_Meta_Box_List_Shortcode
 */
class SP_Meta_Box_List_Shortcode {

	/**
	 * Output the metabox
	 */
	public static function output( $post ) {
		$the_format = get_post_meta( $post->ID, 'sp_format', true );
		if ( ! $the_format ) $the_format = 'list';
		?>
		<p class="howto">
			<?php _e( 'Copy this code and paste it into your post, page or text widget content.', 'sportspress' ); ?>
		</p>
		<p><input type="text" value="[player_<?php echo $the_format; ?> <?php echo $post->ID; ?>]" readonly="readonly" class="code"></p>
		<?php
	}
}