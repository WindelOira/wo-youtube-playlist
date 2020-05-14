<?php

defined( 'ABSPATH' ) || exit; // If accessed directly, exit.

if( !class_exists( 'WOYP_Admin' ) ) :
    class WOYP_Admin {
        /**
         * Setup class.
         * 
         * @since   1.0.0
         */
        function __construct() {
            add_action( 'admin_init', __CLASS__ .'::init' );
            add_action( 'admin_menu', __CLASS__ .'::menu' );
        }

        /**
         * Init.
         * 
         * @since   1.0.0
         */
        public static function init() {
            // Register setting for "woyp" page
            register_setting( 'woyp', 'woyp_options' );

            $options = get_option( 'woyp_options' ); // Get options

            // Add settings fields.
            add_settings_field(
                'api_key',
                __( 'API Key', 'wo-youtube-playlist' ),
                __CLASS__ .'::fields',
                'woyp',
                'woyp_section',
                [
                    'label'     => __( 'API Key', 'wo-youtube-playlist' ),
                    'name'      => 'api_key',
                    'type'      => 'text'
                ]
            );

            add_settings_field(
                'channel_id',
                __( 'Channel ID', 'wo-youtube-playlist' ),
                __CLASS__ .'::fields',
                'woyp',
                'woyp_section',
                [
                    'label'     => __( 'Channel ID', 'wo-youtube-playlist' ),
                    'name'      => 'channel_id',
                    'type'      => 'text'
                ]
            );

            if( $options[ 'api_key' ] && 
                $options[ 'channel_id' ] ) :
                add_settings_section(
                    'woyp_sections',
                    __( 'Shortcode', 'wo-youtube-playlist' ),
                    __CLASS__ .'::sections',
                    'woyp'
                );
            endif;
        }

        /**
         * Admin menu.
         * 
         * @since   1.0.0
         */
        public static function menu() {
            // Add "WO Youtube Playlist" top level menu
            add_menu_page(
                'WO Youtube Playlist',
                'WO Youtube Playlist',
                'manage_options',
                'woyp',
                __CLASS__ .'::optionsPageHTML',
                WOYP_PLUGIN_DIR_URL .'assets/svg/youtube.svg'
            );
        }

        /**
         * Sections.
         * 
         * @since   1.0.0
         */
        public static function sections() {
            ?>
            <p>
                <label for="woyp_shortcode">
                    <?php _e( 'Use this shortcode to display your playlist.', 'wo-youtube-playlist' ); ?>
                </label>
                <br>
                <input id="woyp_shortcode" type="text" value="[woyp-playlist]" readonly>
            </p>
            <?php
        }

        /**
         * Fields.
         * 
         * @param   array       $args       Arguments.
         * @since   1.0.0
         */
        public static function fields( $args ) {
            $options = get_option( 'woyp_options' ); // Get options
            ?>
                <?php if( 'text' == $args[ 'type' ] ) : ?>
                <br>
                <input type="text" name="woyp_options[<?php echo esc_attr( $args[ 'name' ] ); ?>]" value="<?php echo isset( $options[ $args[ 'name' ] ] ) ? esc_attr( $options[ $args[ 'name' ] ] ) : ''; ?>">
                <br><br>
                <?php endif; ?>
            <?php
        }

        /**
         * Options page html.
         * 
         * @since   1.0.0
         */
        public static function optionsPageHTML() {
            if( !current_user_can( 'manage_options' ) ) 
                return;

            ?>
            <div class="wrap">
                <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
                <form action="options.php" method="POST">
                    <?php settings_fields( 'woyp' ); ?>
                    <?php do_settings_fields( 'woyp', 'woyp_section' ); ?>
                    <?php do_settings_sections( 'woyp' ); ?>
                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }
    }

    new WOYP_Admin;
endif;