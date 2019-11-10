<?php
/**
 * Created by PhpStorm.
 * User: Loick
 * Date: 09/11/2019
 * Time: 18:36
 */

namespace Plugin\LV\Portfolio\Dao;


class ProjectDAO
{
    public static function getProjects()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type LIKE 'lv_project'");
    }

    public static function getProject($id) {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type LIKE 'lv_project' AND ID = $id");
    }
}