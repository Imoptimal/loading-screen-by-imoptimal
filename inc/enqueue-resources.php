<?php
// Public resources
add_action('wp_enqueue_scripts', 'imoload_public_resources');

if(!function_exists('imoload_public_resources')) {
    function imoload_public_resources() {
        
        wp_register_script('imoload-public-script', plugin_dir_url( __FILE__ ) . '../js/imoload-public.js', array('jquery'), true);
        wp_register_script('imoload-public-script-min', plugin_dir_url( __FILE__ ) . '../js/imoload-public-min.js', array('jquery'), true);

        // Passing php option variables into the javascript
        // default array is at the position [0]
        $defaultEmptyArray = array(
            'imoload_logo' => '',
            'imoload_background_color' => '',
            'imoload_text_color' => ''
        );
        $options_array =  wp_parse_args( get_option( 'imoload_settings', $defaultEmptyArray), $defaultEmptyArray );

        // Dividing single array into groups of 3 (based on number of fields)
        $divided_array = array_chunk($options_array, 3, true);

        // Reset array keys to numbers
        $numeric_array = array_map('array_values', $divided_array);

        // Set up function to change key names in a multidimensional array (all levels)
        if(!function_exists('imoload_change_keys')) {
            function imoload_change_keys($arr, $set) {
                //$arr => original array
                //$set => array containing old keys as keys and new keys as values
                if (is_array($arr) && is_array($set)) {
                    $newArr = array();
                    foreach ($arr as $k => $v) {
                        $key = array_key_exists( $k, $set) ? $set[$k] : $k;
                        $newArr[$key] = is_array($v) ? imoload_change_keys($v, $set) : $v;
                    }
                    return $newArr;
                }
                return $arr;
            }
        }

        $renamed_array = imoload_change_keys($numeric_array, array(
            '0' => 'imoload_logo',
            '1' => 'imoload_background_color',
            '2' => 'imoload_text_color'
        ));

        // Reset first level keys to index numbers
        $reset_array = array_values($renamed_array);

        // Ajax for front-end
        wp_localize_script('imoload-public-script', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_localize_script('imoload-public-script-min', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));

        $defaults = array(
            'imoload_minification_field'   => '0',
            'imoload_numbers_field' => '1'
        );
        $options = wp_parse_args( get_option( 'imoload_meta', $defaults), $defaults );
        $optionsMetaMinification = $options['imoload_minification_field'];
        $optionsMetaNumbers = $options['imoload_numbers_field'];

        if ($optionsMetaMinification == 1) { // if minified selected

            if ($optionsMetaNumbers == 1) {
                wp_localize_script('imoload-public-script-min', 'imoloadPhp', $reset_array[1]);
            }

            elseif ($optionsMetaNumbers == 3) {
                if (is_front_page()) {
                    wp_localize_script('imoload-public-script-min', 'imoloadPhp', $reset_array[2]);
                } else {
                    wp_localize_script('imoload-public-script-min', 'imoloadPhp', $reset_array[3]);
                }
            }
            
            wp_enqueue_script('imoload-public-script-min');
            wp_enqueue_style('imoload-public-style-min', plugin_dir_url( __FILE__ ) . '../css/imoload-public-min.css', array());

        } else { // not minified

            if ($optionsMetaNumbers == 1) {
                wp_localize_script('imoload-public-script', 'imoloadPhp', $reset_array[1]);
                wp_enqueue_script('imoload-whole-website-script');
            }

            elseif ($optionsMetaNumbers == 3) {
                if (is_front_page()) {
                    wp_localize_script('imoload-public-script', 'imoloadPhp', $reset_array[2]);
                } else {
                    wp_localize_script('imoload-public-script', 'imoloadPhp', $reset_array[3]);
                }
            }
            
            wp_enqueue_script('imoload-public-script');
            wp_enqueue_style('imoload-public-style', plugin_dir_url( __FILE__ ) . '../css/imoload-public.css', array());

        }

    }
}

// Admin resources
add_action('admin_enqueue_scripts', 'imoload_admin_resources');
add_action( 'wp_ajax_imoload_get_image', 'imoload_get_image' );
add_action( 'wp_ajax_nopriv_imoload_get_image', 'imoload_get_image' );
// solving the error that the function is being redeclared under the same name
function imoload_get_image() {

    if(isset($_GET['id']) ){
        $image = wp_get_attachment_image(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array('class' => 'imoload-preview-image'));
        $data = array(
            'image' => $image
        );
        wp_send_json_success( $data );
        wp_die();
    } else {
        wp_send_json_error();
    }

};

if(!function_exists('imoload_admin_resources')) {
    function imoload_admin_resources($hook) {
        // used print_r(get_current_screen();) under ID = $hook
        if ( 'settings_page_imoload_loading' != $hook ) {
            return;
        }

        wp_enqueue_media(); // default wordpress media scripts
        wp_register_script('imoload-admin-script', plugin_dir_url( __FILE__ ) . '../js/imoload-admin.js', array('jquery'), true);
        wp_register_script('imoload-color-picker-script', plugin_dir_url( __FILE__ ) . '../js/jscolor.js', array('jquery'), true);
        // Minified scripts
        wp_register_script('imoload-admin-script-min', plugin_dir_url( __FILE__ ) . '../js/imoload-admin-min.js', array('jquery'), true);
        wp_register_script('imoload-color-picker-script-min', plugin_dir_url( __FILE__ ) . '../js/jscolor-min.js', array('jquery'), true);

        $translateEmpty = esc_html__('Set the custom logo', 'imoptimal_loading');
        $translateSelected = esc_html__('Custom logo selected', 'imoptimal_loading');

        wp_localize_script('imoload-admin-script', 'imoloadLogo', array(
            'empty' => $translateEmpty,
            'selected' => $translateSelected,
        ));

        wp_localize_script('imoload-admin-script-min', 'imoloadLogo', array(
            'empty' => $translateEmpty,
            'selected' => $translateSelected
        ));
        
        $defaults = array(
            'imoload_minification_field'   => '0',
            'imoload_numbers_field' => '1'
        );
        $options = wp_parse_args( get_option( 'imoload_meta', $defaults), $defaults );
        $optionsMetaMinification = $options['imoload_minification_field'];
        
        wp_localize_script('imoload-admin-script', 'imoloadPhp', $options);
        wp_localize_script('imoload-admin-script-min', 'imoloadPhp', $options);

        if ($optionsMetaMinification == 1) { // if minified selected

            wp_enqueue_script('imoload-admin-script-min');
            wp_enqueue_script('imoload-color-picker-script-min');
            wp_enqueue_style('imoload-admin-style-min', plugin_dir_url( __FILE__ ) . '../css/imoload-admin-min.css', array());

        } else { // not minified

            wp_enqueue_script('imoload-admin-script');
            wp_enqueue_script('imoload-color-picker-script');
            wp_enqueue_style('imoload-admin-style', plugin_dir_url( __FILE__ ) . '../css/imoload-admin.css', array());

        }
    }
}
?>
