<?php
/**
 * Team Link
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();

$url = get_post_meta( $id, 'sp_url', true );

if ( empty( $url ) )
	return false;
?>
<a href="<?php echo $url; ?>" class="button sp-button sp-team-button expand"><?php _e( 'Visit Site', 'sportspress' ); ?></a>