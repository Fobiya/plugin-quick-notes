// This file contains the JavaScript code for handling AJAX requests to add and delete notes without reloading the page.

jQuery(document).ready(function($) {
    // Function to load notes
    function loadNotes() {
        $.ajax({
            url: quick_notes_ajax.ajax_url,
            method: 'GET',
            data: {
                action: 'load_notes'
            },
            success: function(response) {
                $('#notes-container').html(response);
            }
        });
    }

    // Load notes on page load
    loadNotes();

    // Function to add a note
    $('#add-note-form').on('submit', function(e) {
        e.preventDefault();
        var noteContent = $('#note-content').val();

        $.ajax({
            url: quick_notes_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'add_note',
                content: noteContent
            },
            success: function(response) {
                $('#note-content').val(''); // Clear input
                loadNotes(); // Reload notes
            }
        });
    });

    // Function to delete a note
    $(document).on('click', '.delete-note', function() {
        var noteId = $(this).data('id');

        $.ajax({
            url: quick_notes_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'delete_note',
                id: noteId
            },
            success: function(response) {
                loadNotes(); // Reload notes
            }
        });
    });
});