$(document).ready(function() {
    var movieUrl = $('#movie-data').data('movie-url');

    $('.seatBookingForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $button = $form.find('button');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    $button.removeClass('available').addClass('taken').text('▲');
                    alert(response.success);
                }
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.error) {
                    alert(response.responseJSON.error);
                }
            }
        });
    });

    function fetchMovieData() {
        $.ajax({
            url: movieUrl,
            type: 'GET',
            success: function(response) {
                updateSeats(response);
            }
        });
    }
    
    function updateSeats(movie) {
        var takenSeats = movie.seats;
    
        for (let i = 1; i <= movie.max_rows; i++) {
            for (let j = 1; j <= movie.max_seats; j++) {
                let seatId = `seat-${i}-${j}`;
                let $seatButton = $(`#${seatId}`);
    
                let isTaken = takenSeats.some(seat => seat.row === i && seat.seat === j);
    
                if (isTaken) {
                    $seatButton.removeClass('available').addClass('taken').text('▲');
                } else {
                    $seatButton.removeClass('taken').addClass('available').text('△');
                }
            }
        }
    }
    
    setInterval(fetchMovieData, 5000);
    
});
