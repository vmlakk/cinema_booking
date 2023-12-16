$(document).ready(function () {
    var fetchUrl = $('#account-data').data('fetch-url');
    var deleteUrlBase = $('#account-data').data('delete-url');
    var posterBaseUrl = $('#account-data').data('poster-base-url');
    var csrfToken = $('#account-data').data('csrf-token');

    function fetchSeats() {
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            success: function (response) {
                var activeHtml = '';
                var passedHtml = '';

                var active_seats = Object.values(response.active_seats);
                var passed_seats = Object.values(response.passed_seats);
                active_seats.sort(function (a, b) {
                    return new Date(a.movie.showtime) - new Date(b.movie.showtime);
                });
                passed_seats.sort(function (a, b) {
                    return new Date(a.movie.showtime) - new Date(b.movie.showtime);
                });

                active_seats.forEach(function (seat) {
                    activeHtml += createSeatHtml(seat, true);
                });

                passed_seats.forEach(function (seat) {
                    passedHtml += createSeatHtml(seat, false);
                });

                $('.active-seats').html(activeHtml ? activeHtml : '<div class="mb-4"><h4>У вас пока нет бронирований</h4></div>');
                $('.passed-seats').html(passedHtml ? passedHtml : '<div class="mb-4"><h4>У вас пока нет бронирований</h4></div>');
            },
            error: function (error) {
                console.error('Ошибка:', error);
            }
        });
    }

    function createSeatHtml(seat, isActive) {
        var deleteForm = '';
        if (isActive) {
            deleteForm = `
                <form method="POST" class="flex justify-start p-0 m-0 delete-seat-form" data-seat-id="${seat.id}">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn mt-3">Удалить</button>
                </form>
            `;
        }

        return `
            <div class="card">
                <img src="${posterBaseUrl}/${seat.movie.poster}" alt="Постер фильма" class="object-fill h-80 w-50">
                <h4>${seat.movie.title}</h4>
                <div class="flex gap-3">
                    <p>${seat.movie.showtime}</p>
                </div>
                <div class="flex gap-1">
                    <p>Место: ${seat.seat} Ряд: ${seat.row}</p>
                </div>
                ${deleteForm}
            </div>
        `;
    }

    $(document).on('submit', '.delete-seat-form', function (e) {
        e.preventDefault();
        var seatId = $(this).data('seat-id');
        $.ajax({
            url: deleteUrlBase + '/' + seatId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    fetchSeats();
                }
            },
        });
    });

    setInterval(fetchSeats, 5000);
});
