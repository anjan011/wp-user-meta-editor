<?php

    /**
     * Class sume_actions
    *
    * Handles wordpress actions. All add_action() calls are being made inside
    * init() method, while the action callbacks are the class methods. By convention
    * class methods acting as callback, should starts with __action__ prefix
    */

    class sume_actions {

        /**
        * Init actions
        */

        public function init() {

            // Enqueue scripts and styles for admin

            add_action(
                'admin_enqueue_scripts',
                array($this,'__action__admin_enqueue_scripts')
            );

            // other actions

            add_action(
                'wp_ajax_me_anjan_sume_editor_page',
                array($this,'__action__editor_page')
            );

            add_action(
                'wp_ajax_me_anjan_sume_update_user_meta',
                array($this,'__action__update_user_meta')
            );

            add_action(
                'wp_ajax_me_anjan_sume_add_user_meta',
                array($this,'__action__add_user_meta')
            );

            add_action(
                'wp_ajax_me_anjan_sume_delete_user_meta',
                array($this,'__action__delete_user_meta')
            );

        }

        /**
        * Action Callback for: wp_enqueue_scripts
        *
        * Enqueue scripts and styles needed by plugin for back end
        *
        * @param string $hook
        */

        public function __action__admin_enqueue_scripts($hook = '') {

            if($hook != 'users.php') {
                return;
            }

            # Underscore

            wp_enqueue_script('underscore');

            # jQuery

            wp_enqueue_script('jquery');

            # Enqueue plugin main script now. We will be adding it in footer

            wp_enqueue_script(
                'ME_ANJAN_SUME_MAIN_SCRIPT_ADMIN',
                ME_ANJAN_SUME_URL.'/assets/js/main-admin.js',
                array('underscore','jquery'),
                '1.0.0',
                true
            );

            wp_enqueue_style(
                ME_ANJAN_SUME_PREFIX.'css_main',
                ME_ANJAN_SUME_URL.'/assets/css/main-admin.css',
                array(),
                '1.0.0'
            );

        }

        /**
         * Load meta editor page
         */

        function __action__editor_page() {

            if(!is_admin()) {
                echo 'Login as adin first!';
                exit();
            }

            if(!current_user_can('edit_users')) {
                echo 'You must have user edit capability!';
                exit();
            }


            $template_file = ME_ANJAN_SUME_DIR.'includes/templates/editor/index.php';

            if(!file_exists($template_file)) {
                echo 'Meta editor template file ['.$template_file.'] not found!';
                exit();
            }

            $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

            if($user_id <= 0) {

                echo 'Invalid user id!';
                exit();
            }

            $user = get_user_by('id',$user_id);

            if(!$user || !($user instanceof WP_User)) {
                echo 'User not found!';
                exit();
            }

            $returnUrl = isset($_GET['returnUrl']) ? trim($_GET['returnUrl']) : '';

            if(!$returnUrl) {
                $returnUrl = rawurldecode($returnUrl);
            } else {
                $returnUrl = admin_url('users.php');
            }

            require_once($template_file);

            exit();

        }

        /**
         * Update user meta via ajax
         */

        function __action__update_user_meta() {

            if(!is_admin()) {
                sume_utils::outputJsonAndExit(-1,'Login as adin first!');
            }

            if(!current_user_can('edit_users')) {
                sume_utils::outputJsonAndExit(-1,'You must have user edit capability!');
            }

            $umeta_id = (int)sume_input::post('umeta_id',0);
            $meta_key = trim(sume_input::post('meta_key',''));
            $meta_value = stripslashes(trim(sume_input::post('meta_value','')));

            if($umeta_id <= 0) {
                sume_utils::outputJsonAndExit(-1,'User meta id is required!');
            }

            if($meta_key == '') {
                sume_utils::outputJsonAndExit(-1,'Meta key is required!');
            }

            /** @var wpdb $wpdb */

            global $wpdb;

            $res = $wpdb->update(
                $wpdb->prefix.'usermeta',
                array(
                    'meta_value' => $meta_value
                ),
                array(
                    'umeta_id' => $umeta_id,
                    'meta_key' => $meta_key
                ),
                array('%s'),
                array('%d','%s')
            );

            if($res >= 0) {
                sume_utils::outputJsonAndExit(1,'Meta data updated!');
            }

            sume_utils::outputJsonAndExit(-1,'Error updating meta data!');


        }

        /**
         * Add user meta via ajax
         */

        function __action__add_user_meta() {

            if(!is_admin()) {
                sume_utils::outputJsonAndExit(-1,'Login as adin first!');
            }

            if(!current_user_can('edit_users')) {
                sume_utils::outputJsonAndExit(-1,'You must have user edit capability!');
            }

            $user_id = (int)sume_input::post('user_id',0);
            $meta_key = trim(sume_input::post('meta_key',''));
            $meta_value = stripslashes(trim(sume_input::post('meta_value','')));

            if($user_id <= 0) {
                sume_utils::outputJsonAndExit(-1,'User id is required!');
            }

            if($meta_key == '') {
                sume_utils::outputJsonAndExit(-1,'Meta key is required!');
            }

            $res = add_user_meta($user_id,$meta_key,$meta_value);

            if($res >= 0) {
                sume_utils::outputJsonAndExit(1,'Meta data added!');
            }

            sume_utils::outputJsonAndExit(-1,'Error adding meta data!');


        }

        /**
         * Delete user meta via ajax
         */

        function __action__delete_user_meta() {

            if(!is_admin()) {
                sume_utils::outputJsonAndExit(-1,'Login as adin first!');
            }

            if(!current_user_can('edit_users')) {
                sume_utils::outputJsonAndExit(-1,'You must have user edit capability!');
            }

            $umeta_id = (int)sume_input::post('umeta_id',0);
            $meta_key = trim(sume_input::post('meta_key',''));


            if($umeta_id <= 0) {
                sume_utils::outputJsonAndExit(-1,'User meta id is required!');
            }

            if($meta_key == '') {
                sume_utils::outputJsonAndExit(-1,'Meta key is required!');
            }

            /** @var wpdb $wpdb */

            global $wpdb;

            $res = $wpdb->delete(
                $wpdb->prefix.'usermeta',
                array(
                    'umeta_id' => $umeta_id,
                    'meta_key' => $meta_key
                ),
                array('%d','%s')
            );

            if($res >= 0) {
                sume_utils::outputJsonAndExit(1,'Meta data deleted!');
            }

            sume_utils::outputJsonAndExit(-1,'Error deleting meta data!');


        }

    }







