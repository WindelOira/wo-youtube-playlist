<?php

defined( 'ABSPATH' ) || exit; // If accessed directly, exit.

if( !class_exists( 'WOYP' ) ) :
    class WOYP {
        /**
         * Setup class.
         * 
         * @since   1.0.0
         */
        function __construct() {
            register_activation_hook( __FILE__, __CLASS__ .'::activate' );
            register_deactivation_hook( __FILE__, __CLASS__ .'::deactivate' );
            register_uninstall_hook( __FILE__, __CLASS__ .'::uninstall' );

            add_action( 'plugins_loaded', __CLASS__ .'::includes' );
            add_action( 'wp_enqueue_scripts', __CLASS__ .'::enqueues' );
        }

        /**
         * Activate.
         * 
         * @since   1.0.0
         */
        public static function activate() {

        }

        /**
         * Deactivate.
         * 
         * @since   1.0.0
         */
        public static function deactivate() {

        }

        /**
         * Uninstall.
         * 
         * @since   1.0.0
         */
        public static function uninstall() {
            if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
                die();
        }

        /**
         * Includes.
         * 
         * @since   1.0.0
         */
        public static function includes() {
            require_once( WOYP_PLUGIN_DIR_PATH .'includes/wo-youtube-playlist-api.class.php' );
            require_once( WOYP_PLUGIN_DIR_PATH .'includes/wo-youtube-playlist-admin.class.php' );
            require_once( WOYP_PLUGIN_DIR_PATH .'includes/wo-youtube-playlist-shortcodes.class.php' );
            require_once( WOYP_PLUGIN_DIR_PATH .'includes/wo-youtube-playlist-ajax.class.php' );
        }

        /**
         * Enqueue scripts.
         * 
         * @since   1.0.0
         */
        public static function enqueues() {
            wp_enqueue_style( 'woyp-style', WOYP_PLUGIN_DIR_URL .'assets/css/woyp-style.css', [ 'woyp-lity' ] );

            wp_register_script('woyp-qs', '//cdnjs.cloudflare.com/ajax/libs/qs/6.9.0/qs.min.js', [], NULL, TRUE);
            wp_enqueue_script( 'woyp-vue', '//cdn.jsdelivr.net/npm/vue/dist/vue.js', [], NULL, TRUE );
            wp_enqueue_script( 'woyp-axios', '//cdn.jsdelivr.net/npm/axios/dist/axios.min.js', [], NULL, TRUE );
            wp_enqueue_script( 'woyp-vue-playlist', WOYP_PLUGIN_DIR_URL .'assets/js/woyp-playlist.vue.js', [ 'woyp-qs' ], NULL, TRUE );
            wp_localize_script(
                'woyp-vue-playlist',
                'woyp',
                [
                    'ajax'      => [
                        'url'   => admin_url( 'admin-ajax.php' )
                    ]
                ]
            );
        }
    }

    new WOYP;
endif;