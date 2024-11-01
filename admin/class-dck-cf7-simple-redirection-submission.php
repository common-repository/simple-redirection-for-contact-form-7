<?php

class Dck_Cf7_Simple_Redirection_Submission
{
    public function save_post_meta($cf7)
    {
        $dck_cf7_sr_options = [
            'enabled'    => isset($_POST['dck_cf7_sr_enabled']) ? 1 : 0,
            'type'       => isset($_POST['dck_cf7_sr_type']) ? sanitize_text_field($_POST['dck_cf7_sr_type']) : '',
            'page_id'    => isset($_POST['dck_cf7_sr_page_id']) ? sanitize_text_field($_POST['dck_cf7_sr_page_id']) : '',
            'page_url'   => isset($_POST['dck_cf7_sr_page_id']) && $_POST['dck_cf7_sr_page_id'] != '' ? get_page_link(sanitize_text_field($_POST['dck_cf7_sr_page_id'])) : '',
            'custom_url' => isset($_POST['dck_cf7_sr_custom_url']) ? sanitize_text_field($_POST['dck_cf7_sr_custom_url']) : '',
            'new_tab'    => isset($_POST['dck_cf7_sr_new_tab']) ? 1 : 0,
            'delay'      => isset($_POST['dck_cf7_sr_delay']) ? sanitize_text_field($_POST['dck_cf7_sr_delay']) : '',
        ];

        update_post_meta($cf7->id(), 'dck_cf7_sr_options', wp_slash(json_encode($dck_cf7_sr_options)));
    }

    public function custom_feedback($response)
    {
        $cf7 = WPCF7_ContactForm::get_current();

        if ($cf7 != null && $response['status'] == 'mail_sent') {
            $response['dck_cf7_sr'] = json_decode(get_post_meta($cf7->id(), 'dck_cf7_sr_options', true));
        }

        return $response;
    }
}
