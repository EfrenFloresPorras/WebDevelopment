document.addEventListener('DOMContentLoaded', function() {
    const clearAllButton = document.getElementById('clearAll');
    const searchForm = document.getElementById('searchForm');

    clearAllButton.addEventListener('click', function() {
        const selects = searchForm.querySelectorAll('select');
        selects.forEach(select => {
            select.value = '';
        });
    });

    // Check for saved query on page load
    if (performance.navigation.type === 1) { // Page was refreshed
        if (confirm('Do you want to load the previous search?')) {
            // The form will be submitted with the saved data from the session
        } else {
            // Clear the session data
            fetch('clear_session.php')
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        window.location.reload();
                    }
                });
        }
    }
});