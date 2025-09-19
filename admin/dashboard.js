// dashboard.js

$(document).ready(function() {
    // Autocomplete for search
    $('#search').autocomplete('autocomplete.php', {
        minChars: 2
    });

    // Handle search button click
    $('#search-button').on('click', function() {
        alert($('#search').val());
        // In a real app, this would perform an AJAX search or redirect
    });
});