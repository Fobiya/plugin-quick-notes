document.addEventListener('DOMContentLoaded', function() {
    const noteForm = document.getElementById('quick-notes-form');
    const notesList = document.querySelector('.quick-notes-list');

    if (noteForm && notesList) {
        // Function to fetch and display notes
        function fetchNotes() {
            fetch(quickNotes.ajax_url + '?action=get_notes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'nonce=' + quickNotes.nonce
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && Array.isArray(data.data)) {
                    notesList.innerHTML = '';
                    data.data.forEach(note => {
                        const noteItem = document.createElement('li');
                        noteItem.classList.add('note-item', 'p-4', 'bg-white', 'border', 'border-gray-300', 'rounded', 'shadow-sm', 'flex', 'justify-between', 'items-center');
                        noteItem.innerHTML = `
                            <div class="note-content flex-grow">
                                <strong class="block text-lg">${note.title}</strong>
                                <p class="text-gray-700">${note.content}</p>
                                <p class="text-sm text-gray-500">Author: ${note.author}</p>
                            </div>
                            <button class="delete-note ml-2 p-2 bg-red-500 text-white rounded hover:bg-red-700" data-id="${note.id}">Delete</button>
                        `;
                        notesList.appendChild(noteItem);
                    });
                } else {
                    alert(data.data);
                }
            });
        }

        // Handle form submission
        noteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(noteForm);
            formData.append('nonce', quickNotes.nonce);
            fetch(quickNotes.ajax_url + '?action=add_note', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchNotes();
                    noteForm.reset();
                } else {
                    alert(data.data);
                }
            });
        });

        // Handle note deletion
        notesList.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-note')) {
                const noteId = e.target.getAttribute('data-id');
                fetch(quickNotes.ajax_url + '?action=delete_note', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'nonce=' + quickNotes.nonce + '&note_id=' + noteId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchNotes();
                    } else {
                        alert(data.data);
                    }
                });
            }
        });

        // Initial fetch of notes
        fetchNotes();
    }
});