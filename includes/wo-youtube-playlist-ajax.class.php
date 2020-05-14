<?php

defined( 'ABSPATH' ) || exit; // If accessed directly, exit.

if( !class_exists( 'WOYP_Ajax' ) ) :
    class WOYP_Ajax {
        /**
         * Setup class.
         * 
         * @since   1.0.0
         */
        function __construct() {
            add_action( 'wp_ajax_nopriv_getPlaylist', __CLASS__ .'::getPlaylist' );
            add_action( 'wp_ajax_getPlaylist', __CLASS__ .'::getPlaylist' );
        }

        /**
         * Get next playlist.
         * 
         * @since   1.0.0
         */
        public static function getPlaylist() {
            if( !defined( 'DOING_AJAX' ) && !DOING_AJAX )
                die();

            extract( $_POST );

            if( $nextPageToken ) :
                $url = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&type=video&pageToken='. $nextPageToken;
            else :
                $url = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&type=video';
            endif;

            $playlist = WOYP_API::call( $url );

            wp_send_json( $playlist );
        }

    }

    new WOYP_Ajax;
endif;