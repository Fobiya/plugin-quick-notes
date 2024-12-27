<?php
class Quick_Notes_Shortcode {
    public function __construct() {
        add_shortcode('quick_notes', [$this, 'render_notes']);
    }

    public function render_notes() {
        ob_start();
        ?>
        <div id="quick-notes-container" class="container">
            <h2><?php esc_html_e('Quick Notes', 'quick-notes'); ?></h2>
            <div id="notes-list"></div>
            <input type="text" id="new-note" placeholder="<?php esc_attr_e('Add a new note...', 'quick-notes'); ?>" />
            <button id="add-note" class="btn btn-primary"><?php esc_html_e('Add Note', 'quick-notes'); ?></button>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>