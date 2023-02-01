$(document).ready(function() {
    const input = $('.input-comment');

    input.on('keyup', function(event) {
        if (event.key === 'Enter') {
            $('#form-comment').submit();
        }
    });
});
