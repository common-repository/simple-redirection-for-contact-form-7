<?php

class Dck_Cf7_Simple_Redirection
{
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        $this->version     = DCK_CF7_SIMPLE_REDIRECTION_VERSION;
        $this->plugin_name = DCK_CF7_SIMPLE_REDIRECTION_NAME;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-dck-cf7-simple-redirection-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-dck-cf7-simple-redirection-i18n.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-dck-cf7-simple-redirection-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-dck-cf7-simple-redirection-panel.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-dck-cf7-simple-redirection-submission.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-dck-cf7-simple-redirection-public.php';

        $this->loader = new Dck_Cf7_Simple_Redirection_Loader();
    }

    private function set_locale()
    {
        $dck_cf7_sr_i18n = new Dck_Cf7_Simple_Redirection_i18n();

        $this->loader->add_action('plugins_loaded', $dck_cf7_sr_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks()
    {
        $dck_cf7_sr_admin = new Dck_Cf7_Simple_Redirection_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $dck_cf7_sr_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $dck_cf7_sr_admin, 'enqueue_scripts');

        $dck_cf7_sr_panel = new Dck_Cf7_Simple_Redirection_Panel($this->get_plugin_name(), $this->get_version());
        $this->loader->add_filter('wpcf7_editor_panels', $dck_cf7_sr_panel, 'init_panel');
        $this->loader->add_filter('wpcf7_after_update', $dck_cf7_sr_panel, 'validate');

        $dck_cf7_sr_submission = new Dck_Cf7_Simple_Redirection_Submission();
        $this->loader->add_action('wpcf7_after_save', $dck_cf7_sr_submission, 'save_post_meta');
        $this->loader->add_filter('wpcf7_feedback_response', $dck_cf7_sr_submission, 'custom_feedback');
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_version()
    {
        return $this->version;
    }

    private function define_public_hooks()
    {
        $dck_cf7_sr_public = new Dck_Cf7_Simple_Redirection_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $dck_cf7_sr_public, 'enqueue_scripts');
    }

    public function run()
    {
        $this->loader->run();
    }

    public function get_loader()
    {
        return $this->loader;
    }
}
