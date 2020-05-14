<?php

defined( 'ABSPATH' ) || exit; // If accessed directly, exit.

if( !class_exists( 'WOYP_API' ) ) :
    class WOYP_API {
        /**
         * Errors.
         * 
         * @since   1.0.0
         */
        private static $errors;

        /**
         * Setup class.
         * 
         * @since   1.0.0
         */
        function __construct() {

        }

        /**
         * Call.
         * 
         * @param   string      $url        Endpoint url.
         * @param   string      $method     Method.
         * @param   array       $args       Args.
         * @return  array|WP_Error
         * @since   1.0.0
         */
        public static function call( $url, $method = 'GET', $args = [] ) {
            $options = get_option( 'woyp_options' ); // Get options.

            if( !$options || ( !isset( $options[ 'api_key' ] ) && !isset( $options[ 'channel_id' ] ) ) ) // Check options.
                return FALSE;

            $url = $url .'&channelId='. $options[ 'channel_id' ] .'&key='. $options[ 'api_key' ];

            if( 'POST' == $method ) :
                $response = wp_remote_post( $url, $args );
            else :
                $response = wp_remote_get( $url, $args );
            endif;

            $responseBody = json_decode( wp_remote_retrieve_body( $response ) );

            if( $responseBody->error ) :
                return [
                    'errors'     => self::$errors = $responseBody->error->errors
                ];
            endif;

            return $responseBody;
        }
    }

    new WOYP_API;
endif;