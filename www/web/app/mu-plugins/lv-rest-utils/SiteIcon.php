<?php

namespace Plugin\LV\RestUtils;


class SiteIcon
{

    public static function run()
    {
        add_action('rest_api_init', array(__CLASS__, 'api_register_lv_site_icon'));
    }

    public static function api_register_lv_site_icon() {
        register_rest_route('site/v1', '/icon', array(
            'methods'   => 'GET',
            'callback'  => function() {
                $response = array(
                    'icon_url' => get_site_icon_url()
                );
                return $response;
            }
        ));
    }

}