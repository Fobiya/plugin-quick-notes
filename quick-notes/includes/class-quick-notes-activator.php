<?php

class Quick_Notes_DB {
    private static $table_name;

    public static function init() {
        global $wpdb;
        self::$table_name = $wpdb->prefix . 'quick_notes';
    }

    public static function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            content text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function get_notes() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM " . self::$table_name . " ORDER BY created_at DESC");
    }

    public static function add_note($title, $content) {
        global $wpdb;
        return $wpdb->insert(
            self::$table_name,
            array('title' => $title, 'content' => $content),
            array('%s', '%s')
        );
    }

    public static function delete_note($id) {
        global $wpdb;
        return $wpdb->delete(
            self::$table_name,
            array('id' => $id),
            array('%d')
        );
    }
}