<?php
if(!function_exists('imoload_options_page')) {
    function imoload_options_page() {
?>

<div id="imoload-options" class="imoload-wrap">
    <h1>
        <span class="imoload-title"><?php esc_html_e('Loading Screen by Imoptimal', 'imoptimal_loading'); ?></span>
        <a class="imoload-logo" href="https://www.imoptimal.com/" target="_blank"></a>
    </h1>

    <h2 class="imoload-instructions"><?php esc_html_e('Instructions', 'imoptimal_loading'); ?><span class="pointer"></span></h2>

    <ol class="imoload-list">
        <li>a) <?php esc_html_e('First of all, set the number of loading screen options your website needs (either one for the entire website, or two different ones - first for the homepage, second for all of the other pages).', 'imoptimal_loading'); ?></li>
        <li>b) <?php esc_html_e('Choose if the plugin files (styles and scripts) will be loaded in regular or minified version. Default: not minified.', 'imoptimal_loading'); ?></li>
        <li><?php esc_html_e('Open each loading screen option by clicking on its title bar.', 'imoptimal_loading'); ?></li>
        <li>1. <?php esc_html_e('Set the logo image that will be used on the loading screen (choose from the existing uploads, or upload a new item).', 'imoptimal_loading');?></li>
        <li>2. <?php esc_html_e('Select the background color for the loading screen (by clicking on the input field and choosing from the dropdown color pallete).', 'imoptimal_loading'); ?></li>
        <li>3. <?php esc_html_e('Select the color of progress bar and percentage text (same as the above input field).', 'imoptimal_loading'); ?></li>
    </ol>

    <p class="note"><?php esc_html_e('Note: "Save Meta Options" button is used to save the number of loading screen options, as well as the minification of plugin files, while "Save Loading Options" button is used for all of the options inside of every loading screen options item.', 'imoptimal_loading'); ?></p>

    <noscript><?php esc_html_e('IMPORTANT: Javascript must be turned ON in your browser settings in order for this plugin to work!', 'imoptimal_loading'); ?></noscript>

    <div class="imoload-content">

        <form action='options.php' method='post' id='imoload-meta'>
            <div class="meta-border-top"><span><?php esc_html_e('Meta Options', 'imoptimal_loading') ?></span></div>
            <?php 
        settings_fields( 'imoload_meta_group' );
                                     do_settings_sections('imoload_meta_group');
                                     submit_button(esc_html('Save meta options', 'imoptimal_loading'), 'submit-class', 'submit', true, array('id' => 'submit-meta'));
            ?>
            <div class="meta-notice notice"></div>
            <div class="meta-border-bottom"><span><?php esc_html_e('Loading Options', 'imoptimal_loading') ?></span></div>
        </form>

        <form action='options.php' method='post' id='imoload-loading'>
            <?php 
                settings_fields( 'imoload_loading_group' );
                                     do_settings_sections('imoload_loading_group');
                                     submit_button(esc_html('Save loading options', 'imoptimal_loading'), 'submit-class', 'submit', true, array('id' => 'submit-loading'));
            ?>
            <div class="loading-notice notice"></div>
            <div class="loading-border-bottom"></div>
        </form>

        <div class="imoload-sidebar">

            <div class="rating">
                <h3><?php esc_html_e('Ratings & Reviews', 'imoptimal_loading'); ?></h3>
                <p>
                    <strong><?php esc_html_e('If you like this plugin, please consider leaving a', 'imoptimal_loading') ?></strong> 
                    ★★★★★ 
                    <strong><?php esc_html_e('rating', 'imoptimal_loading'); ?></strong><br>
                    <strong><?php esc_html_e('A huge thanks in advance!', 'imoptimal_loading'); ?></strong>
                </p>
                <a href="https://wordpress.org/support/plugin/loading-screen-by-imoptimal/reviews/" target="_blank" class="button button-primary"><?php esc_html_e('Leave us a rating', 'imoptimal_loading'); ?></a>
            </div>

            <div class="meta-info">
                <h3><?php esc_html_e('About the plugin', 'imoptimal_loading'); ?></h3>
                <strong><?php esc_html_e('Developed by: ', 'imoptimal_loading'); ?></strong> <a href="https://www.imoptimal.com/" target="_blank">Imoptimal</a>

                <div class="contact-info">
                    <strong><?php esc_html_e('Need some support?', 'imoptimal_loading'); ?></strong> <br>
                    <strong><?php esc_html_e('Contact the developers via the Support Forum', 'imoptimal_loading'); ?></strong>
                    <div>
                        <a href="https://wordpress.org/support/plugin/loading-screen-by-imoptimal/" target="_blank" class="button button-primary"><?php esc_html_e('Contact us', 'imoptimal_loading'); ?></a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?php }
} ?>