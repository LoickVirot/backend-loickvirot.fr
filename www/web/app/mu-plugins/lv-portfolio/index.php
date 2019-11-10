<?php
/**
 * Plugin Name: lv-portfolio
 * Description: Add project type article to create portfolios.
 * Version: 1.0
 * Author: Loïck Virot
 */

namespace Plugin\LV\Portfolio;

use Plugin\LV\Portfolio\Dao\ProjectDAO;

class Index
{

    /**
     * Index constructor.
     */
    public static function run()
    {
        add_action('init', array(__CLASS__, 'register_lv_project'));
        add_action('init', array(__CLASS__, 'genres_taxonomy'));

        add_action('rest_api_init', array(__CLASS__, 'api_register_lv_project'));
    }


    public static function register_lv_project()
    {

        $labels = array(
            'name' => _x('Projects', 'projects'),
            'singular_name' => _x('Project', 'project'),
            'add_new' => _x('Add new', 'projects'),
            'add_new_item' => _x('Add new', 'projects'),
            'edit_item' => _x('Edit project', 'projects'),
            'new_item' => _x('New project', 'projects'),
            'view_item' => _x('View project', 'projects'),
            'search_items' => _x('Search project', 'projects'),
            'not_found' => _x('No projects found', 'projects'),
            'not_found_in_trash' => _x('No projects found in Trash', 'projects'),
            'parent_item_colon' => _x('Parent project:', 'projects'),
            'menu_name' => _x('Projects', 'projects'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => 'Projects filterable by genre',
            'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
            'taxonomies' => array('genres'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-post',
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'show_in_rest'       => true,
            'rest_base'          => 'project',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        );

        register_post_type('lv_project', $args);

    }


    public static function api_register_lv_project()
    {
        register_rest_field('lv_project', 'thumbnail', array(
            'get_callback' => function ($data) {
                return get_the_post_thumbnail_url($data['id']);
            }
        ));
    }

    public static function genres_taxonomy()
    {
        register_taxonomy(
            'genres',
            'lv_project',
            array(
                'hierarchical' => true,
                'label' => 'Genres',
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'genre',
                    'with_front' => false
                )
            )
        );
    }

}

Index::run();