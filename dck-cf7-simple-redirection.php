<?php
/**
 * Plugin Name:     Simple Redirection for Contact Form 7
 * Plugin URI:      https://darpan.co/wordpress-plugins/simple-redirection-for-contact-form-7
 * Description:     Simple redirection addon for Contact Form 7, allows you to redirect to an existing page or a custom URL after form submission.
 * Version:         1.0.2
 * Author:          Darpan Kulkarni
 * Author URI:      https://darpan.co
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     dck-cf7-simple-redirection
 * Domain Path:     /languages
 */

if ( ! defined('WPINC')) {
    die;
}

define('DCK_CF7_SIMPLE_REDIRECTION_VERSION', '1.0.2');
define('DCK_CF7_SIMPLE_REDIRECTION_NAME', 'dck-cf7-simple-redirection');

require plugin_dir_path(__FILE__) . 'includes/class-dck-cf7-simple-redirection.php';

$dck_cf7_sr = new Dck_Cf7_Simple_Redirection();
$dck_cf7_sr->run();
