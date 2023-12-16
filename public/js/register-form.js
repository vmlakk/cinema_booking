$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            },
            error: function(response) {
                if (response.responseJSON && response.responseJSON.errors) {
                    const errors = response.responseJSON.errors;
                    $('#error_login').text(errors.login ? errors.login[0] : '');
                    $('#error_password').text(errors.password ? errors.password[0] : '');
                    $('#error_confirm_password').text(errors.confirm_password ? errors.confirm_password[0] : '');
                }
            }
        });
    });
});
