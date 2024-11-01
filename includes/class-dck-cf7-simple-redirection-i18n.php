<?php

class Dck_Cf7_Simple_Redirection_i18n
{
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'dck-cf7-simple-redirection',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
