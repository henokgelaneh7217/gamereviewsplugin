<?php

/**
 *
 * @link              gelanehhenok.wordpress.com
 * @since             1.0.0
 * @package           Gamereviews
 *
 * @wordpress-plugin
 * Plugin Name:       Game Reviews v2
 * Plugin URI:        https://github.com/henokgelaneh7217/gamereviewsplugin
 * Description:       Beginner friendly WordPress Game Review plugin.
 * Version:           1.0.0
 * Author:            Henok Gelaneh
 * Author URI:        gelanehhenok.wordpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gamereviews
 * Domain Path:       /languages
 *
 * Game Reviews is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WPForms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'GAMEREVIEWS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gamereviews-activator.php
 */
function activate_gamereviews() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gamereviews-activator.php';
	Gamereviews_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gamereviews-deactivator.php
 */
function deactivate_gamereviews() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gamereviews-deactivator.php';
	Gamereviews_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gamereviews' );
register_deactivation_hook( __FILE__, 'deactivate_gamereviews' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gamereviews.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gamereviews() {

	$plugin = new Gamereviews();
	$plugin->run();

}
run_gamereviews();

function register_cpt_game_review() {
 
    $labels = array(
        'name' => _x( 'Game Reviews', 'game_review' ),
        'singular_name' => _x( 'Game Review', 'game_review' ),
        'add_new' => _x( 'Add New', 'Game_review' ),
        'add_new_item' => _x( 'Add New Game Review', 'game_review' ),
        'edit_item' => _x( 'Edit Game Review', 'game_review' ),
        'new_item' => _x( 'New Game Review', 'game_review' ),
        'view_item' => _x( 'View Game Review', 'game_review' ),
        'search_items' => _x( 'Search Game Reviews', 'game_review' ),
        'not_found' => _x( 'No Game reviews found', 'game_review' ),
        'not_found_in_trash' => _x( 'No Game reviews found in Trash', 'game_review' ),
        'parent_item_colon' => _x( 'Parent Game Review:', 'game_review' ),
        'menu_name' => _x( 'Game Reviews', 'game_review' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Game Reviews',
        'supports' => array( 'title', 'editor', 'publisher', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'platform'),
        'taxonomies' => array( 'genre'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-feedback',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'game_review', $args );
}
 
add_action( 'init', 'register_cpt_game_review' );
 
function platform() {
    register_taxonomy(
        'platform',
        'game_review',
        array(
            'hierarchical' => true,
            'label' => 'Platform',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'platform',
                'with_front' => false
            )
        )
    );
}

function genre() {
    register_taxonomy(
        'genre',
        'game_review',
        array(
            'hierarchical' => true,
            'label' => 'Genre',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'genre',
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'platform');
add_action( 'init', 'genre');

function create_game_review_pages()
  {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'game_review',
          'post_status' => 'publish' ,
          'post_title' => 'Game Reviews',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'grpage', $newvalue );
  }

register_activation_hook( __FILE__, 'create_game_review_pages');


