<?php

namespace Plugin\LV\RestUtils;

use WP_HTTP_Requests_Response;
use WP_REST_Response;

class Menus
{

    public static function run()
    {
        add_action('rest_api_init', array(__CLASS__, 'api_register_lv_menus'));
    }

    public static function api_register_lv_menus() {
        register_rest_route('site/v1', '/menus', array(
            'methods'   => 'GET',
            'callback'  => function() {
                return wp_get_nav_menu_items('main-menu');
            }
        ));
    }

}

Menus::run();