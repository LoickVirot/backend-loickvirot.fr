<?php
/**
 * Plugin Name: lv-portfolio
 * Description: Add project type article to create portfolios.
 * Version: 1.0
 * Author: Loïck Virot
 */

namespace Plugin\LV\Portfolio;

class Index
{

    public const PROJECT_TYPE = "project";

    /**
     * Index constructor.
     */
    public static function run()
    {
        add_action('init', array(__CLASS__, 'register_lv_project'));
        add_action('init', array(__CLASS__, 'genres_taxonomy'));

        add_action('rest_api_init', array(__CLASS__, 'api_register_lv_project'));

        add_filter('the_excerpt', array(__CLASS__, 'filter_excerpt'));
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
            'taxonomies' => array('project_type'),
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

        add_filter('use_block_editor_for_post_type', '__return_false', 10);

        register_post_type(self::PROJECT_TYPE, $args);

    }

    public static function api_register_lv_project()
    {
        register_rest_field(self::PROJECT_TYPE, 'thumbnail', array(
            'get_callback' => function ($data) {
                return get_the_post_thumbnail_url($data['id']);
            }
        ));

        register_rest_field(self::PROJECT_TYPE, 'project-type', array(
            'get_callback' => function ($data) {
                return get_the_terms($data['id'], 'project_type');
            }
        ));
    }

    public static function genres_taxonomy()
    {
        register_taxonomy(
            'project_type',
            self::PROJECT_TYPE,
            array(
                'hierarchical' => false,
                'label' => 'Projects type',
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'project-type',
                    'with_front' => false
                )
            )
        );
    }

    public static function filter_excerpt($data) {
        $data = strip_tags($data);
        return $data;
    }

}

Index::run();