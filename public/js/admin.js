$(document).ready(function() {
    var fetchUrl = $('#admin-data').data('fetch-url');

    function fetchMovies() {
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            success: function(response) {
                updateMoviesStatus(response);
            },
        });
    }

    function updateMoviesStatus(data) {
        var movies = Object.values(data.movies);
        movies.sort(function(a, b) {
            return new Date(a.showtime) - new Date(b.showtime);
        });
        movies.forEach(function(movie) {
            var isActive = new Date(movie.showtime) > new Date();
            var statusCell = $(`#movie-status-${movie.id}`);
            statusCell.html(isActive ? '<span class="text-green-700 font-semibold">✓</span>' : '<span class="text-red-800 font-semibold">✗</span>');    
        });
    }

    setInterval(fetchMovies, 5000);
});
