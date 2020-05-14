<?php
/**
 * Plugin Name:       WO Youtube Playlist
 * Plugin URI:        https://github.com/WindelOira/wo-youtube-playlist
 * Description:       A simple WP plugin that uses Youtube API to pull videos from the channel.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Windel Oira
 * Author URI:        https://github.com/WindelOira
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wo-youtube-playlist
 * Domain Path:       /languages
 */

defined( 'WOYP_PLUGIN_DIR_PATH' ) || define( 'WOYP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WOYP_PLUGIN_DIR_URL' ) || define( 'WOYP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once( WOYP_PLUGIN_DIR_PATH .'includes/wo-youtube-playlist.class.php' );