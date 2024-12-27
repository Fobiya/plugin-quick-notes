<?php

class Quick_Notes_AJAX {
    public function __construct() {
        add_action( 'wp_ajax_add_note', array( $this, 'add_note' ) );
        add_action( 'wp_ajax_delete_note', array( $this, 'delete_note' ) );
        add_action( 'wp_ajax_get_notes', array( $this, 'get_notes' ) );
    }

    public function add_note() {
        check_ajax_referer( 'quick_notes_nonce', 'nonce' );

        if ( ! is_user_logged_in() ) {
            wp_send_json_error( __( 'You must be logged in to add a note.', 'quick-notes' ) );
        }

        $user_id = get_current_user_id();
        $title = sanitize_text_field( $_POST['title'] );
        $content = sanitize_textarea_field( $_POST['content'] );

        $post_id = wp_insert_post( array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'quick_note',
            'post_author'  => $user_id,
        ) );

        if ( $post_id ) {
            wp_send_json_success( __( 'Note added successfully.', 'quick-notes' ) );
        } else {
            wp_send_json_error( __( 'Failed to add note.', 'quick-notes' ) );
        }
    }

    public function delete_note() {
        check_ajax_referer( 'quick_notes_nonce', 'nonce' );

        if ( ! is_user_logged_in() ) {
            wp_send_json_error( __( 'You must be logged in to delete a note.', 'quick-notes' ) );
        }

        $note_id = intval( $_POST['note_id'] );
        $result = wp_delete_post( $note_id, true );

        if ( $result ) {
            wp_send_json_success( __( 'Note deleted successfully.', 'quick-notes' ) );
        } else {
            wp_send_json_error( __( 'Failed to delete note.', 'quick-notes' ) );
        }
    }

    public function get_notes() {
        if ( ! is_user_logged_in() ) {
            wp_send_json_error( __( 'You must be logged in to view notes.', 'quick-notes' ) );
        }

        $user_id = get_current_user_id();
        $args = array(
            'post_type'      => 'quick_note',
            'post_status'    => 'publish',
            'author'         => $user_id,
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $notes_query = new WP_Query( $args );

        $notes = array();
        if ( $notes_query->have_posts() ) {
            while ( $notes_query->have_posts() ) {
                $notes_query->the_post();
                $notes[] = array(
                    'id'      => get_the_ID(),
                    'title'   => get_the_title(),
                    'content' => get_the_content(),
                    'author'  => get_the_author(),
                );
            }
            wp_reset_postdata();
        }

        wp_send_json_success( $notes );
    }
}