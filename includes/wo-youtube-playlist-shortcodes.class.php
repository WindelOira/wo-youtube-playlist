<?php

defined( 'ABSPATH' ) || exit; // If accessed directly, exit.

if( !class_exists( 'WOYP_Shortcodes' ) ) :
    class WOYP_Shortcodes {
        /**
         * Setup class.
         * 
         * @since   1.0.0
         */
        function __construct() {
            add_shortcode( 'woyp-playlist', __CLASS__ .'::playlist' );
        }

        /**
         * Playlist.
         * 
         * @return  string
         * @since   1.0.0
         */
        public static function playlist() {
            ob_start();
            ?>
            <div id="woyp-playlist" class="woyp-container">
                <div v-if="0 < playlist.length" 
                    :class="{ 'has-active': active }"
                    class="woyp-playlist">
                    <div class="woyp-playlist--video">
                        <iframe v-if="active" 
                                :src="'https://www.youtube.com/embed/'+ active.id.videoId" 
                                width="560" 
                                height="315" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                    <div class="woyp-playlist--videos">
                        <div class="woyp-playlist--items">
                            <div v-for="( item, index ) in playlist" 
                                :key="index" 
                                @click="active = item" 
                                :class="{ 'is-active': active && active.id.videoId == item.id.videoId }"
                                class="woyp-playlist--item">
                                <div class="woyp-playlist--item__image">
                                    <img :src="item.snippet.thumbnails.default.url" 
                                        :alt="item.snippet.title">
                                </div>
                                <h3 v-html="item.snippet.title" 
                                    class="woyp-playlist--item__title"></h3>
                                <div v-html="item.snippet.description" 
                                    class="woyp-playlist--item__description"></div>
                            </div>
                        </div>
                        <button v-if="nextToken" 
                                @click="getPlaylist" 
                                class="woyp-playlist--loader" 
                                type="button">
                            <?php _e( 'Load More', 'wo-youtube-playlist' ); ?>
                        </button>
                    </div>
                </div>

                <div v-else 
                    class="woyp-container--loading">
                    <p v-if="0 == errors.length">Loading...</p>
                    <ul v-else>
                        <li v-for="( error, index ) in errors" 
                            :key="index">{{ error.message }}</li>
                    </ul>
                </div>
            </div>
            <?php

            return ob_get_clean();
        }
    }

    new WOYP_Shortcodes;
endif;