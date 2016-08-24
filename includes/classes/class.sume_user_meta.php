<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 8/17/16
     * Time: 11:32 AM
     */
    class sume_user_meta {

        public static function get_user_meta_data($params = array()) {

            $params = is_array($params) ? $params : array();

            $user_id = isset($params['user_id']) ? (int)$params['user_id'] : 0;

            if($user_id <= 0) {
                return array();
            }

            /** @var wpdb $wpdb */

            global $wpdb;

            $sql = "select * from {$wpdb->prefix}usermeta where user_id = {$user_id} order by meta_key";

            return $wpdb->get_results($sql,'ARRAY_A');

        }

    }