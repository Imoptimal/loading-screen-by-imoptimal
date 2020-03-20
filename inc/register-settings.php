<?php
add_action( 'admin_menu', 'imoload_add_admin_menu' );
add_action( 'admin_init', 'imoload_meta_init' );
add_action( 'admin_init', 'imoload_settings_init' );

if(!function_exists('imoload_add_admin_menu')) {
    function imoload_add_admin_menu() {

        add_submenu_page( 'options-general.php', // parent menu item - general settings in this case
                         'Loading Screen by Imoptimal', // plugin's menu item title
                         'Loading Screen by Imoptimal', // plugin's settings page title
                         'activate_plugins', // (user role) capability - restricted to admins
                         'imoload_loading', // menu slug
                         'imoload_options_page' ); //output function
    }
}

if(!function_exists('imoload_meta_init')) {
    function imoload_meta_init() {

        register_setting( 'imoload_meta_group', // option group
                         'imoload_meta', // option name
                         'imoload_validate_loading_meta' // validate function
                        );
        // Number of groups selection section
        add_settings_section(
            'imoload_numbers_section', // id
            '', // title
            'imoload_settings_section_callback', // callback function 
            'imoload_meta_group' // option group
        );

        add_settings_field( 
            'imoload_numbers_field', // id
            'a) ' . esc_html__( 'Choose how many different loading screens you need', 'imoptimal_loading' ), // title
            'imoload_numbers_render', // callback function
            'imoload_meta_group', // option group
            'imoload_numbers_section' // field output section
        );
        // Minification section
        add_settings_section(
            'imoload_minification_section',
            '',
            'imoload_settings_section_callback',
            'imoload_meta_group'
        );

        add_settings_field( 
            'imoload_minification_field',
            'b) ' . esc_html__( 'Choose if the plugin files (styles and scripts) will be loaded in regular or minified version', 'imoptimal_loading' ),
            'imoload_minification_render',
            'imoload_meta_group',
            'imoload_minification_section'
        );

    }
}

if(!function_exists('imoload_settings_init')) {
    function imoload_settings_init() { 

        register_setting( 'imoload_loading_group', // option group
                         'imoload_settings', // option name
                         'imoload_validate_loading_settings' // validate function
                        );

        $options = get_option( 'imoload_meta' );
        $numberChoosen = $options['imoload_numbers_field'];
        if ( empty($numberChoosen) ) $numberChoosen = 1;
        $nameArray = array('Whole Website', 'Homepage', 'Other Pages');
        // Main section loop
        for ($i = 0; $i < $numberChoosen; $i++) {
            $noSpaceArrayItem = str_replace(" ",'', $nameArray[$i]);
            add_settings_section(
                'imoload_loading_group_section_' . $noSpaceArrayItem, // id
                '<div class="imoload-collapsible ' . $noSpaceArrayItem . '">
            <div class="group-title">' . esc_html__( 'Loading Screen Options', 'imoptimal_loading' ) . ' - ' . esc_html__($nameArray[$i], 'imoptimal_loading') . '</div> 
            <div class="imoload-info"></div> 
            <div class="collapsible-icon"></div>
            </div>',  // title
                'imoload_settings_section_callback', // callback function 
                'imoload_loading_group' // option group
            );

            add_settings_field( 
                'imoload_logo_' . $noSpaceArrayItem, // id
                '1. ' . esc_html__( 'Upload an image to display on the loading screen (or browse from the existing uploads)', 'imoptimal_loading' ),  // title
                'imoload_logo_render',  // callback function
                'imoload_loading_group', // option group
                'imoload_loading_group_section_' . $noSpaceArrayItem, // field output section
                array( // Args
                    'index' => $noSpaceArrayItem,
                )
            );

            add_settings_field( 
                'imoload_background_color_' . $noSpaceArrayItem, // id
                '2. ' . esc_html__( 'Pick the background color', 'imoptimal_loading' ),  // title
                'imoload_background_color_render',  // callback function
                'imoload_loading_group', // option group
                'imoload_loading_group_section_' . $noSpaceArrayItem, // field output section
                array( // Args
                    'index' => $noSpaceArrayItem,
                )
            );

            add_settings_field( 
                'imoload_text_color_' . $noSpaceArrayItem, // id
                '3. ' . esc_html__( 'Pick the bar and percentage text color', 'imoptimal_loading' ),  // title
                'imoload_text_color_render',  // callback function
                'imoload_loading_group', // option group
                'imoload_loading_group_section_' . $noSpaceArrayItem, // field output section
                array( // Args
                    'index' => $noSpaceArrayItem,
                )
            );
        }
    }
}

if(!function_exists('imoload_validate_loading_meta')) {
    function imoload_validate_loading_meta( $input ) {
        // Create our array for storing the validated options
        $output = array();

        foreach( $input as $key => $value ) {

            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$key] ) ) {

                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = sanitize_text_field( $input[ $key ] );

            } // end if
        } // end foreach
        // Return the array processing any additional functions filtered by this action
        return apply_filters( 'imoload_meta', $output, $input );
    }
}

if(!function_exists('imoload_validate_loading_settings')) {
    function imoload_validate_loading_settings( $input ) {
        // Create our array for storing the validated options
        $output = array();

        foreach( $input as $key => $value ) {

            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$key] ) ) {

                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = sanitize_text_field( $input[ $key ] );

            } // end if
        } // end foreach
        // Return the array processing any additional functions filtered by this action
        return apply_filters( 'imoload_settings', $output, $input );
    }
}

if(!function_exists('imoload_settings_section_callback')) {
    function imoload_settings_section_callback() {
    }
}
?>
