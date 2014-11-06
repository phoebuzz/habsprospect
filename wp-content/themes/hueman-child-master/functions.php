<?php

/* //////////////////////////// Language */

define('LANG', (ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') ? (ICL_LANGUAGE_CODE == "fr") ? 'fr' : 'en'  : 'fr');


// ----------------------------- WPML Language switcher
    
    function icl_post_languages(){
        $languages = icl_get_languages('skip_missing=0');
        foreach($languages as $l){
            if(!$l['active']) $langs[] = '<a class="lang-switcher"href="'.$l['url'].'">'.$l['language_code'].'</a>';
        }
        echo join(', ', $langs);
    }


/* ------------------------------------------------------------------------- *
 *  Custom functions
/* ------------------------------------------------------------------------- */
	
	// Add your custom functions here, or overwrite existing ones. Read more how to use:
	// http://codex.wordpress.org/Child_Themes

function orderby_tax_clauses( $clauses, $wp_query ) {
    global $wpdb;
    $taxonomies = get_taxonomies();
    foreach ($taxonomies as $taxonomy) {
        if ( isset( $wp_query->query['orderby'] ) && $taxonomy == $wp_query->query['orderby'] ) {
            $clauses['join'] .=<<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= " AND (taxonomy = '{$taxonomy}' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
            $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
        }
    }
    return $clauses;
}

    add_filter('posts_clauses', 'orderby_tax_clauses', 10, 2 );