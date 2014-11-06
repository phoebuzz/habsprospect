<?php
/*
Plugin Name: Habs - Custom Post Types
Description: Custom post types for Players.
Version: 1.0
Author: Gabriel Gaudreau
*/

/* //////////////////////////// Taxonomies and Custom Post Types */

/* ------------------- Custom Post Type: Players */

add_action('init', 'create_cpt_players', 0);
function create_cpt_players() {
    $labels = array(
        'name'                => _x('Players', 'Post Type General Name', 'habsplayers_plugin'),
        'singular_name'       => _x('Player', 'Post Type Singular Name', 'habsplayers_plugin'),
        'menu_name'           => __('Players', 'habsplayers_plugin'),
        'parent_item_colon'   => __('Players parent:', 'habsplayers_plugin'),
        'all_items'           => __('All Players', 'habsplayers_plugin'),
        'view_item'           => __('See Players', 'habsplayers_plugin'),
        'add_new_item'        => __('Add new players', 'habsplayers_plugin'),
        'add_new'             => __('Add new players', 'habsplayers_plugin'),
        'edit_item'           => __('Edit player', 'habsplayers_plugin'),
        'update_item'         => __('Update player', 'habsplayers_plugin'),
        'search_items'        => __('Search player', 'habsplayers_plugin'),
        'not_found'           => __('No player found', 'habsplayers_plugin'),
        'not_found_in_trash'  => __('Aucun player trouvé dans la corbeille', 'habsplayers_plugin'),
   );
    $args = array(
        'label'               => __('Players', 'habsplayers_plugin'),
        'description'         => __('Players', 'habsplayers_plugin'),
        'labels'              => $labels,
        'hierarchical'        => true,
        'can_export'          => true,
        'has_archive'         => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 6,
        'publicly_queryable'  => true,
        'public'              => true,
        'show_in_admin_bar'   => true,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'query_var'           => true,
        'exclude_from_search' => false,
        'rewrite'             =>  array('slug' => 'player-profile')
   );
    
    register_post_type('players', $args);
}

/* ------------------- Taxonomy: Player - Team */

    add_action('init', 'create_players_team_taxonomy', 0);
    function create_players_team_taxonomy() {
        $labels = array(
            'name'                  => _x('Teams', 'taxonomy general name'),
            'singular_name'         => _x('Team', 'taxonomy singular name'),
            'search_items'          => __('Find a team'),
            'all_items'             => __('All teams'),
            'parent_item'           => __('Team parent'),
            'parent_item_colon'     => __('Team parent:'),
            'edit_item'             => __('Edit team'),
            'update_item'           => __('Update Team'),
            'update_item'           => __('Add team'),
            'add_new_item'          => __('New team'),
            'menu_name'             => __('Teams')
       );

        $args = array(
            'hierarchical'        => false,
            'labels'              => $labels,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'public'              => true,
            'rewrite'             =>  array('slug' => 'teams')
       );

        register_taxonomy('teams', array('players'), $args);
    }

/* ------------------- Taxonomy: Player - Team */

    add_action('init', 'create_players_league_taxonomy', 0);
    function create_players_league_taxonomy() {
        $labels = array(
            'name'                  => _x('Leagues', 'taxonomy general name'),
            'singular_name'         => _x('League', 'taxonomy singular name'),
            'search_items'          => __('Find a league'),
            'all_items'             => __('All leagues'),
            'parent_item'           => __('Leagues parent'),
            'parent_item_colon'     => __('League parent:'),
            'edit_item'             => __('Edit league'),
            'update_item'           => __('Update league'),
            'update_item'           => __('Add league'),
            'add_new_item'          => __('New league'),
            'menu_name'             => __('Leagues')
       );

        $args = array(
            'hierarchical'        => true,
            'labels'              => $labels,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'rewrite'             =>  array('slug' => 'leagues')
       );

        register_taxonomy('leagues', array('players'), $args);
    }

/* ------------------- Taxonomy: Player - Team */

    add_action('init', 'create_players_positions_taxonomy', 0);
    function create_players_positions_taxonomy() {
        $labels = array(
            'name'                  => _x('Positions', 'taxonomy general name'),
            'singular_name'         => _x('Position', 'taxonomy singular name'),
            'search_items'          => __('Find a position'),
            'all_items'             => __('All position'),
            'parent_item'           => __('Position parent'),
            'parent_item_colon'     => __('Position parent:'),
            'edit_item'             => __('Edit position'),
            'update_item'           => __('Update position'),
            'update_item'           => __('Add position'),
            'add_new_item'          => __('New position'),
            'menu_name'             => __('Positions')
       );

        $args = array(
            'hierarchical'        => false,
            'labels'              => $labels,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'rewrite'             =>  array('slug' => 'positions')
       );

        register_taxonomy('positions', array('players'), $args);
    }

/* ------------------- Taxonomy: Player - Team */

    add_action('init', 'create_players_nationality_taxonomy', 0);
    function create_players_nationality_taxonomy() {
        $labels = array(
            'name'                  => _x('Nationalities', 'taxonomy general name'),
            'singular_name'         => _x('Nationality', 'taxonomy singular name'),
            'search_items'          => __('Find a nationality'),
            'all_items'             => __('All nationalities'),
            'parent_item'           => __('Nationality parent'),
            'parent_item_colon'     => __('Nationality parent:'),
            'edit_item'             => __('Edit nationality'),
            'update_item'           => __('Update nationality'),
            'update_item'           => __('Add nationality'),
            'add_new_item'          => __('New nationality'),
            'menu_name'             => __('Nationalities')
       );

        $args = array(
            'hierarchical'        => false,
            'labels'              => $labels,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'rewrite'             =>  array('slug' => 'nationalities')
       );

        register_taxonomy('nationalities', array('players'), $args);
    }


/* ------------------- Register Login widget */

// add_action('init', 'create_widget_login', 0);
// function create_widget_login() {
//     if ( function_exists('register_sidebar') ){
//         register_sidebar(array(
//             'name' => 'Section Membres Login',
//             'id'            => 'members-login',
//             'before_widget' => '',
//             'after_widget' => '',
//             'before_title' => '<h2>',
//             'after_title' => '</h2>',
//         ));
//     }
// }

/* ------------------- Reset permalinks */

function my_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );

