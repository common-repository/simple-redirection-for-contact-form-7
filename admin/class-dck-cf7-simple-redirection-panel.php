<?php

class Dck_Cf7_Simple_Redirection_Panel
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    public function init_panel($panels)
    {
        $dck_cf7_sr_panel = [
            'dck-cf7-sr-panel' => [
                'title'    => __('Simple Redirection', 'dck-cf7-simple-redirection'),
                'callback' => [$this, 'init_panel_content'],
            ],
        ];

        return array_merge($panels, $dck_cf7_sr_panel);
    }

    public function init_panel_content(WPCF7_ContactForm $cf7)
    {
        $options = json_decode(get_post_meta($cf7->id(), 'dck_cf7_sr_options', true));

        $enabled    = $options != null ? $options->enabled : 0;
        $type       = $options != null ? $options->type : '';
        $pageId     = $options != null ? $options->page_id : '';
        $custom_url = $options != null ? $options->custom_url : '';
        $new_tab    = $options != null ? $options->new_tab : 0;
        $delay      = $options != null ? $options->delay : 0;

        if ($enabled) {
            $validation_error = null;

            if ($type == 'page' && $pageId == '') {
                $validation_error = __('Please select a page.', 'dck-cf7-simple-redirection');
            } else if ($type == 'url' && ! filter_var($custom_url, FILTER_VALIDATE_URL)) {
                $validation_error = __('Please enter a valid custom URL.', 'dck-cf7-simple-redirection');
            }

            if ($validation_error) {
                echo '<div class="notice notice-error"><p><strong>' . __('Simple Redirection:', 'dck-cf7-simple-redirection') . '</strong> ' . $validation_error . '</p></div>';
            }
        }
        ?>

        <h2><?php _e('Simple Redirection', 'dck-cf7-simple-redirection') ?></h2>
        <p>
            <a href="https://darpan.co/wordpress-plugins/simple-redirection-for-contact-form-7" target="_blank"><?php _e('Documentation', 'dck-cf7-simple-redirection') ?></a> |
            <a href="https://wordpress.org/plugins/simple-redirection-for-contact-form-7" target="_blank"><?php _e('Rate this plugin', 'dck-cf7-simple-redirection') ?></a> |
            <a href="https://darpan.co/wordpress-plugins" target="_blank"><?php _e('More plugins', 'dck-cf7-simple-redirection') ?></a>
        </p>
        <hr>

        <?php

        if ($cf7->id()) {
            ?>
            <table>
                <tr>
                    <th><label for="dck_cf7_sr_enabled"><?php _e('Enable redirect:', 'dck-cf7-simple-redirection') ?></label></th>
                    <td><input type="checkbox" name="dck_cf7_sr_enabled" id="dck_cf7_sr_enabled" value="1" <?php echo $enabled ? 'checked' : '' ?>></td>
                </tr>

                <tr>
                    <th><label for="dck_cf7_sr_type"><?php _e('Redirect type:', 'dck-cf7-simple-redirection') ?></label></th>
                    <td>
                        <select name="dck_cf7_sr_type" id="dck_cf7_sr_type">
                            <option value="page" <?php echo $type == 'page' || $type == '' ? 'selected' : '' ?>><?php _e('Page', 'dck-cf7-simple-redirection') ?></option>
                            <option value="custom_url" <?php echo $type == 'custom_url' ? 'selected' : '' ?>><?php _e('Custom URL', 'dck-cf7-simple-redirection') ?></option>
                        </select>
                    </td>
                </tr>

                <tr id="dck_cf7_sr_page_row">
                    <th><label for="dck_cf7_sr_page_id"><strong><?php _e('Select a page:', 'dck-cf7-simple-redirection') ?></strong></label></th>
                    <td>
                        <?php
                        wp_dropdown_pages(
                            [
                                'selected'         => $pageId,
                                'name'             => 'dck_cf7_sr_page_id',
                                'show_option_none' => __('Please select a page', 'dck-cf7-simple-redirection'),
                            ]
                        )
                        ?>
                    </td>
                </tr>

                <tr id="dck_cf7_sr_custom_url_row">
                    <th><label for="dck_cf7_sr_custom_url"><strong><?php _e('Enter a custom URL:', 'dck-cf7-simple-redirection') ?></strong></label></th>
                    <td><input type="text" name="dck_cf7_sr_custom_url" id="dck_cf7_sr_custom_url" value="<?php echo $custom_url ?>" placeholder="https://example.com/"></td>
                </tr>

                <tr>
                    <th><label for="dck_cf7_sr_new_tab"><?php _e('Open in new tab:', 'dck-cf7-simple-redirection') ?></label></th>
                    <td>
                        <input type="checkbox" name="dck_cf7_sr_new_tab" id="dck_cf7_sr_new_tab" <?php echo $new_tab ? 'checked' : '' ?>>
                        <div class="warning"><?php _e('This option depends on the browser settings, browsers often block popup windows.', 'dck-cf7-simple-redirection') ?></div>
                    </td>
                </tr>

                <tr>
                    <th><label for="dck_cf7_sr_delay"><?php _e('Delay in redirection (in seconds):', 'dck-cf7-simple-redirection') ?></label></th>
                    <td><input type="number" name="dck_cf7_sr_delay" id="dck_cf7_sr_delay" min="0" value="<?php echo $delay ?>" placeholder="0"></td>
                </tr>
            </table>
            <?php
        } else {
            _e('Please save the form.', 'dck-cf7-simple-redirection');
        }
    }
}
