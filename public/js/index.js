$(document).ready(function() {
    var $moviesList = $('.list');
    var posterBaseUrl = $moviesList.data('poster-url');
    var movieBaseUrl = $moviesList.data('movie-url');
    var apiBaseUrl = $moviesList.data('api-url');

    function fetchMovies() {
        $.ajax({
            url: apiBaseUrl,
            type: 'GET',
            success: function(data) {
                var movies = Object.values(data.movies);
                movies.sort(function(a, b) {
                    return new Date(a.showtime) - new Date(b.showtime);
                });
                var moviesList = '';
                movies.forEach(function(movie) {
                    moviesList += `
                        <div class="card">
                            <img src="${posterBaseUrl}/${movie.poster}" alt="Постер фильма" class="object-fill h-80 w-46">
                            <a href="${movieBaseUrl}/${movie.id}">${movie.title}</a>
                            <div class="flex gap-3">
                                <p>${movie.showtime}</p>
                                ${generateRating(movie.rating)}
                            </div>
                        </div>
                    `;
                });

                if (data.movies.length === 0) {
                    moviesList = 'Фильмов нет';
                }

                $moviesList.html(moviesList);
            }
        });
    }

    setInterval(fetchMovies, 5000);
});

function generateRating(rating) {
    let ratingStars = '';
    if (rating) {
        for (let i = 1; i <= 5; i++) {
            ratingStars += i <= Math.round(rating) ? '★ ' : '☆ ';
        }
    } else {
        ratingStars = 'Рейтинг отсутствует';
    }
    return ' ' + ratingStars;
}

