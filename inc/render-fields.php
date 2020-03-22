<?php
if(!function_exists('imoload_numbers_render')) {
    function imoload_numbers_render() {

        $defaults = array(
            'imoload_numbers_field'   => '1',
        );
        $options = wp_parse_args( get_option( 'imoload_meta', $defaults), $defaults );
        $numbers = $options['imoload_numbers_field'];
?>

<input type="radio" name='imoload_meta[imoload_numbers_field]' value="1"  <?php checked('1', $numbers); ?>>
<label for="1">1 - <?php esc_html_e('Use the same loading screen for the whole website', 'imoptimal_loading'); ?></label> </br>
<input type="radio" name='imoload_meta[imoload_numbers_field]' value="3" <?php checked('3', $numbers); ?>>
<label for="3">2 - <?php esc_html_e('Use different loading screens for: homepage, other pages', 'imoptimal_loading'); ?></label>

<?php }
}

if(!function_exists('imoload_minification_render')) {
    function imoload_minification_render() {

        $defaults = array(
            'imoload_minification_field'   => '0',
        );
        $options = wp_parse_args( get_option( 'imoload_meta', $defaults), $defaults );
        $minification = $options['imoload_minification_field'];
?>

<select name='imoload_meta[imoload_minification_field]' value="<?php echo $minification; ?>">
    <option value="0" <?php if($minification == 0): ?>selected<?php endif; ?>><?php esc_html_e('Use regural files (not minified)', 'imoptimal_loading'); ?></option>
    <option value="1" <?php if($minification == 1): ?>selected<?php endif; ?>><?php esc_html_e('Use minified files', 'imoptimal_loading'); ?></option>
</select>

<?php }
}

if(!function_exists('imoload_logo_render')) {
    function imoload_logo_render($args) {

        $logo_field = 'imoload_logo_' . $args['index'];
        $defaults = array(
            $logo_field   => '',
        );
        $options = wp_parse_args( get_option( 'imoload_settings', $defaults), $defaults );
        $value = $options[$logo_field];

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

        $background_color_field = 'imoload_background_color_' . $args['index'];
        $defaults = array(
            $background_color_field   => '',
        );
        $options = wp_parse_args( get_option( 'imoload_settings', $defaults), $defaults );
        $value = $options[$background_color_field];

        echo "<input class='jscolor' name='imoload_settings[{$background_color_field}]' value='{$value}'>";
    }
}

if(!function_exists('imoload_text_color_render')) {
    function imoload_text_color_render($args) {

        $text_color_field = 'imoload_text_color_' . $args['index'];
        $defaults = array(
            $text_color_field   => '',
        );
        $options = wp_parse_args( get_option( 'imoload_settings', $defaults), $defaults );
        $value = $options[$text_color_field];

        echo "<input class='jscolor' name='imoload_settings[{$text_color_field}]' value='{$value}'>";
    }
}

?>
