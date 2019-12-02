<?php
/**
Plugin Name: lv-rest-utils
Description: Add project type article to create portfolios.
Version: 1.0
Author: Loïck Virot
 */

namespace Plugin\LV\RestUtils;


class Index
{

    public static function run() {

        Menus::run();
    }
}

Index::run();
