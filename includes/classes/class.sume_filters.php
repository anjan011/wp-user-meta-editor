<?php

    /**
     * Class sume_filters
    *
    * Handles wordpress filters. All add_filter() calls are being made inside
    * init() method, while the action callbacks are the class methods. By convention
    * class methods acting as callback, should starts with __filter__ prefix
    */

    class sume_filters {

        /**
        * Init filters
        */

        public function init() {

            // add filters here

            add_filter('user_row_actions',array($this,'user_row_actions'),10,2);


        }

        /**
         * Add a link to user actions hover menu
         *
         * @param array   $actions
         * @param WP_User $user
         *
         * @return array
         */

        public function user_row_actions($actions,$user) {

            if(!$user || !($user instanceof WP_User)) {
                return $actions;
            }

            $meta_edit_url = admin_url('admin-ajax.php?action='.ME_ANJAN_SUME_PREFIX.'editor_page&user_id='.$user->ID.'&returnUrl='.rawurlencode($_SERVER['REQUEST_URI']));

            $actions[ME_ANJAN_SUME_PREFIX.'popup_link'] = "<a class='sume-link-orange' href='{$meta_edit_url}'>Meta Editor</a>";

            return $actions;

        }

    }

