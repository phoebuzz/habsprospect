<?php
/*
Template Name: Prospects
*/
?>

<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'positions', array(
    'orderby'    => 'name',
    'hide_empty' => 0
) );
?>
<?php get_header(); ?>

<section class="content">

	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group position-listing">

	<?php
	// now run a query for each animal family
	foreach( $terms as $term ) {
	 
	    // Define the query
	    $args = array(
	        'post_type' => 'players',
	        'positions' => $term->slug, 
	        'leagues'   => $league_terms
	    );
	    $query = new WP_Query( $args );
	             
	    // output the term name in a heading tag                
	    echo'<h2>' . $term->name . '</h2>';
	     
	    // output the post titles in a list
	    echo '<ul>';
	     
	        // Start the Loop
	        while ( $query->have_posts() ) : $query->the_post(); ?>
	 
	        <li class="listing-player"><?php get_template_part('listing-player'); ?></li>
	         
	        <?php endwhile;
	     
	    echo '</ul>';
	     
	    // use reset postdata to restore orginal query
	    wp_reset_postdata();
	 
	} ?>	
		
		
	</div><!--/.pad-->
	
</section><!--/.content-->


<?php get_sidebar(); ?>

<?php get_footer(); ?>