$(document).ready(function() {
    $(".btn-register-confirm").on('click', function () {
        const btn = $(this);

        document.location.href = btn.data('url');
    });
});