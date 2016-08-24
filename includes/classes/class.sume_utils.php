<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 8/18/16
     * Time: 8:58 PM
     */
    class sume_utils {

        /**
         * Generates a JSON encoded response and immediately exits
         *
         * @param mixed  $code    A code to indicate status of action
         * @param string $message Message to describe the response
         * @param null   $data    Extra data that needs to be sent back
         */

        public static function outputJsonAndExit( $code = -1, $message = 'Error!', $data = NULL ) {

            $temp = array(
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            );

            echo json_encode( $temp );

            exit();
        }

    }