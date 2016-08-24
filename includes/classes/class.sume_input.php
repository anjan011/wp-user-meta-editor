<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 8/18/16
     * Time: 8:55 PM
     */
    class sume_input {

        /**
         * Get array value.
         *
         * It takes the array and a key name or a key path to access element in multidimensional array
         *
         * @param array  $array   The array to conduct the search on
         * @param string $key     The Key name or key path (a/b/c/d)
         * @param mixed  $default The default value
         *
         * @return mixed
         */

        public static function array_value( $array, $key, $default = NULL ) {

            if ( !is_array( $array ) ) {
                return $default;
            }

            $key = trim( trim( $key ), '/' );

            $parts = explode( '/', $key );

            foreach ( $parts as $p ) {

                $array = isset($array[ $p ]) ? $array[ $p ] : NULL;

                if ( $array === NULL ) {
                    return $default;
                }
            }

            return $array;
        }

        /**
         * Directly prints/returns a value from $_POST
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function post( $key, $default = NULL, $return = TRUE ) {

            $data = self::array_value( $_POST, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_GET
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function get( $key, $default = NULL, $return = TRUE ) {

            $data = self::array_value( $_GET, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_SESSION
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function session( $key, $default = NULL, $return = TRUE ) {

            $data = self::array_value( $_SESSION, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_SERVER
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function server( $key, $default = NULL, $return = TRUE ) {

            $data = self::array_value( $_SERVER, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

        /**
         * Directly prints/returns a value from $_COOKIE
         *
         * @param string $key     The key, can be a key path, like "data/name"
         * @param string $default The default value, if the value is null
         * @param mixed  $return  Should return?
         *
         * @return mixed
         */

        public static function cookie( $key, $default = NULL, $return = TRUE ) {

            $data = self::array_value( $_COOKIE, $key, $default );

            if ( $return ) {
                return $data;
            }
            else {
                echo $data;
            }
        }

    }