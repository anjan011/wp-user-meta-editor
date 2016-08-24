<?php

    /**
    * Class sume_main
    *
    * Main class for this plugin
    */

    class sume_main {

        /**
        * Initializer function
        *
        * This function sets up actions, filters, etc. for the plugin
        */

        public function init() {

            /**

            * Add actions

            */

            $actions = new sume_actions();

            $actions->init();

            /**

            * Add filters

            */

            $filters = new sume_filters();

            $filters->init();

            /**

            * Add Shortcodes

            */

            $shortcodes = new sume_shortcodes();

            $shortcodes->init();

        }

    }

