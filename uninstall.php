<?php

if ( ! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

$wpcf7Forms = get_posts(
    [
        'post_type'   => 'wpcf7_contact_form',
        'numberposts' => -1,
    ]
);

if ($wpcf7Forms) {
    foreach ($wpcf7Forms as $form) {
        $dck_cf7_sr_options = get_post_meta($form->ID, 'dck_cf7_sr_options', true);

        if ($dck_cf7_sr_options) {
            delete_post_meta($form->ID, 'dck_cf7_sr_options');
        }
    }
}