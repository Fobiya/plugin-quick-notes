<?php
class Quick_Notes_I18N {
    public static function load_plugin_textdomain() {
        load_plugin_textdomain('quick-notes', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
}