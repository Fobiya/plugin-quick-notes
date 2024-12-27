# Quick Notes Plugin

Quick Notes is a simple WordPress plugin that allows logged-in users to manage their personal notes through a user-friendly front-end interface. The plugin utilizes AJAX for seamless interactions, enabling users to add and delete notes without page reloads.

## Features

- Add personal notes with titles and content.
- Delete notes easily.
- Responsive design that supports both LTR and RTL layouts.
- AJAX functionality for a smooth user experience.

## Installation

1. Download the plugin files.
2. Upload the `quick-notes` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Use the shortcode `[quick_notes]` to display the notes form and list on any page or post.

## Usage

Once activated, the plugin will allow logged-in users to add and manage their notes. The notes will be displayed in a list format, and users can delete any note they no longer need.

## Functions

### Quick_Notes

- **__construct()**: Initializes the plugin by setting up actions, shortcodes, and hooks.
- **init()**: Loads required files and initializes the database and AJAX handlers.
- **enqueue_scripts()**: Enqueues the necessary styles and scripts for the plugin.
- **render_notes()**: Renders the notes form and list using a template file.
- **register_post_type()**: Registers the custom post type 'quick_note'.

### Quick_Notes_DB

- **init()**: Initializes the database table name.
- **create_table()**: Creates the custom database table for storing notes.
- **drop_table()**: Drops the custom database table.
- **get_notes($user_id)**: Retrieves notes for a specific user.
- **add_note($user_id, $title, $content)**: Adds a new note to the database.
- **delete_note($id)**: Deletes a note from the database.

### Quick_Notes_AJAX

- **__construct()**: Sets up AJAX actions for adding, deleting, and retrieving notes.
- **add_note()**: Handles the AJAX request to add a new note.
- **delete_note()**: Handles the AJAX request to delete a note.
- **get_notes()**: Handles the AJAX request to retrieve notes for the current user.

### Quick_Notes_Shortcode

- **__construct()**: Registers the `[quick_notes]` shortcode.
- **render_notes()**: Renders the notes form and list when the shortcode is used.

## Development

- **SCSS**: The styles for the plugin are written in SCSS and are located in `assets/css/style.scss`. Make sure to compile it to CSS for proper styling.
- **JavaScript**: The AJAX functionality is handled in `assets/js/script.js`, which listens for user interactions and communicates with the server.
- **Database**: The database interactions are managed by the `Quick_Notes_DB` class in `includes/class-quick-notes-db.php`.
- **AJAX Handling**: The `Quick_Notes_AJAX` class in `includes/class-quick-notes-ajax.php` processes AJAX requests for adding and deleting notes.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any enhancements or bug fixes.

## License

This plugin is licensed under the GPLv2 or later.