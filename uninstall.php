<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

if ( current_user_can( 'delete_plugins' ) ) { // restrict to admins

        $option_meta = 'imoload_meta';
        $option_settings = 'imoload_settings';

        delete_option($option_meta);
        delete_option($option_settings);

        // for site options in Multisite
        delete_site_option($option_meta);
        delete_site_option($option_settings);   

} ?>