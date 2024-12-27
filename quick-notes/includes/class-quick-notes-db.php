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

        $sql = "CREATE TABLE " . self::$table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            note_title text NOT NULL,
            note_content longtext NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function drop_table() {
        global $wpdb;
        $sql = "DROP TABLE IF EXISTS " . self::$table_name . ";";
        $wpdb->query($sql);
    }

    public static function get_notes($user_id) {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare("SELECT * FROM " . self::$table_name . " WHERE user_id = %d ORDER BY created_at DESC", $user_id));
    }

    public static function add_note($user_id, $title, $content) {
        global $wpdb;
        return $wpdb->insert(
            self::$table_name,
            array('user_id' => $user_id, 'note_title' => $title, 'note_content' => $content),
            array('%d', '%s', '%s')
        );
    }

    public static function delete_note($id) {
        global $wpdb;
        return $wpdb->delete(self::$table_name, array('id' => $id), array('%d'));
    }
}