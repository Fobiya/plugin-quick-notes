<?php

/**
 * Plugin Name: Quick Notes
 * Description: A simple plugin to manage quick notes with AJAX functionality.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: quick-notes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Require the Quick_Notes_DB class file
require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-notes-db.php';

class Quick_Notes {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_shortcode( 'quick_notes', array( $this, 'render_notes' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        register_activation_hook( __FILE__, array( 'Quick_Notes_DB', 'create_table' ) );
        register_deactivation_hook( __FILE__, array( 'Quick_Notes_DB', 'drop_table' ) );
    }

    public function init() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-notes-db.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-notes-ajax.php';
        Quick_Notes_DB::init();
        new Quick_Notes_AJAX();
        $this->register_post_type();
    }

    public function enqueue_scripts() {
        // Enqueue TailwindCSS
        wp_enqueue_style( 'tailwindcss', '//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' );

        // Enqueue plugin styles and scripts
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'assets/css/style.css' ) ) {
            wp_enqueue_style( 'quick-notes-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
        }
        wp_enqueue_script( 'quick-notes-script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'jquery' ), null, true );
        wp_localize_script( 'quick-notes-script', 'quickNotes', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'quick_notes_nonce' ),
        ));
    }

    public function render_notes() {
        ob_start();
        include plugin_dir_path( __FILE__ ) . 'templates/form.php';
        return ob_get_clean();
    }

    private function register_post_type() {
        $labels = array(
            'name'               => _x( 'Quick Notes', 'post type general name', 'quick-notes' ),
            'singular_name'      => _x( 'Quick Note', 'post type singular name', 'quick-notes' ),
            'menu_name'          => _x( 'Quick Notes', 'admin menu', 'quick-notes' ),
            'name_admin_bar'     => _x( 'Quick Note', 'add new on admin bar', 'quick-notes' ),
            'add_new'            => _x( 'Add New', 'quick note', 'quick-notes' ),
            'add_new_item'       => __( 'Add New Quick Note', 'quick-notes' ),
            'new_item'           => __( 'New Quick Note', 'quick-notes' ),
            'edit_item'          => __( 'Edit Quick Note', 'quick-notes' ),
            'view_item'          => __( 'View Quick Note', 'quick-notes' ),
            'all_items'          => __( 'All Quick Notes', 'quick-notes' ),
            'search_items'       => __( 'Search Quick Notes', 'quick-notes' ),
            'parent_item_colon'  => __( 'Parent Quick Notes:', 'quick-notes' ),
            'not_found'          => __( 'No quick notes found.', 'quick-notes' ),
            'not_found_in_trash' => __( 'No quick notes found in Trash.', 'quick-notes' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'quick-note' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats' )
        );

        register_post_type( 'quick_note', $args );
    }
}

new Quick_Notes();