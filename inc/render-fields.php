<?php
if(!function_exists('imoload_numbers_render')) {
    function imoload_numbers_render() {
        $options = get_option( 'imoload_meta' );
        if(isset($options['imoload_numbers_field'])) {
            $numbers = $options['imoload_numbers_field'];
        }
        if ( empty($numbers) ) $numbers = 1;
?>

<input type="radio" name='imoload_meta[imoload_numbers_field]' value="1"  <?php checked('1', $options['imoload_numbers_field']); ?>>
<label for="1">1 - <?php esc_html_e('Use the same loading screen for the whole website', 'imoptimal_loading'); ?></label> </br>
<input type="radio" name='imoload_meta[imoload_numbers_field]' value="3" <?php checked('3', $options['imoload_numbers_field']); ?>>
<label for="3">2 - <?php esc_html_e('Use different loading screens for: homepage, other pages', 'imoptimal_loading'); ?></label>

<?php }
}

if(!function_exists('imoload_minification_render')) {
    function imoload_minification_render() {
        $options = get_option( 'imoload_meta' );
        if(isset($options['imoload_minification_field'])) {
            $minification = $options['imoload_minification_field'];
        }
        if ( empty($minification) ) $minification = 0;
?>

<select name='imoload_meta[imoload_minification_field]' value="<?php echo $minification; ?>">
    <option value="0" <?php if($minification == 0): ?>selected<?php endif; ?>><?php esc_html_e('Use regural files (not minified)', 'imoptimal_loading'); ?></option>
    <option value="1" <?php if($minification == 1): ?>selected<?php endif; ?>><?php esc_html_e('Use minified files', 'imoptimal_loading'); ?></option>
</select>

<?php }
}

if(!function_exists('imoload_logo_render')) {
    function imoload_logo_render($args) {
        $options = get_option( 'imoload_settings' );
        $logo_field = 'imoload_logo_' . $args['index'];
        if(isset($options[$logo_field])) {
            $value = $options[$logo_field];
        }
        if ( empty($value) ) $value = '';

        if( $value !== '' ) {
            // Change with the image size you want to use
            $image = wp_get_attachment_image( $value, 'medium', false, array( 'class' => 'imoload-preview-image' ) );
        } else {
            // Default image
            $image = '<img class="imoload-preview-image default" src="'. plugin_dir_url( __FILE__ ) . '../img/imoptimal-logo-white.png" />';
        }
        $select_button = esc_html('Select an image', 'imoptimal_loading');
        echo $image;
        echo "<input type='hidden' name='imoload_settings[{$logo_field}]' class='imoload-logo' value='{$value}'/>
<input type='button' class='imoload-logo-button' value='" . $select_button . "' />";
    }
}

if(!function_exists('imoload_background_color_render')) {
    function imoload_background_color_render($args) {
        $options = get_option( 'imoload_settings' );
        $background_color_field = 'imoload_background_color_' . $args['index'];
        if(isset($options[$background_color_field])) {
            $value = $options[$background_color_field];
        }
        if ( empty($value) ) $value = '';
        
        echo "<input class='jscolor' name='imoload_settings[{$background_color_field}]' value='{$value}'>";
    }
}

if(!function_exists('imoload_text_color_render')) {
    function imoload_text_color_render($args) {
        $options = get_option( 'imoload_settings' );
        $text_color_field = 'imoload_text_color_' . $args['index'];
        if(isset($options[$text_color_field])) {
            $value = $options[$text_color_field];
        }
        if ( empty($value) ) $value = '';
        
        echo "<input class='jscolor' name='imoload_settings[{$text_color_field}]' value='{$value}'>";
    }
}

?>
