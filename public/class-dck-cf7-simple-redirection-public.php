<?php

class Dck_Cf7_Simple_Redirection_Public
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/dck-cf7-simple-redirection-public.min.js', ['jquery'], $this->version, true);
    }

}
