<?php
/*
   Plugin Name: Loading Screen by Imoptimal
   Plugin URI: https://github.com/Imoptimal/loading-screen-by-imoptimal
   Description: Enable loading screen progress bar (with percentage text), that features the logo/image of your choosing.
   Version: 1.2.1
   Author: imoptimal
   Author URI: https://www.imoptimal.com/
   Requires at least: 4.9.8
   Requires PHP: 5.6
   License: GNU General Public License v3 or later
   License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
   Text Domain: imoptimal_loading
   Domain Path: /lang
   */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die();
}

if(!function_exists('imoptimal_loading')) {

    function imoptimal_loading() {

        class Imoptimal_Loading {    

            public static function include_files() {
                include_once(plugin_dir_path( __FILE__ ) . 'inc/register-settings.php');
                include_once(plugin_dir_path( __FILE__ ) . 'inc/render-fields.php');
                include_once(plugin_dir_path( __FILE__ ) . 'inc/options-page.php');
                include_once(plugin_dir_path( __FILE__ ) . 'inc/enqueue-resources.php');
            }
        }
        Imoptimal_Loading::include_files();
    
    }
    add_action( 'init', 'imoptimal_loading' );
}
?>
