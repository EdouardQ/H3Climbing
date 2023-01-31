$(document).ready(function() {
    let map = $('#form-map');
    const url = map.attr('src');

    $('#get-form-data-btn').on('click', function () {
        event.preventDefault();
        map.attr('src', url);

        const input_title = $('#discovery_day_title').val();
        const input_date = $('#discovery_day_date').val();
        const input_max_participant = $('#discovery_day_maxParticipant').val();
        const input_location = $('#discovery_day_location').val();

        if (
            input_title.length > 0 &&
            input_date.length > 0 &&
            input_max_participant.length > 0 &&
            input_location.length > 0
        ) {
            map.attr('src', url + '&q=' + input_location);
            $('#form-modal').modal("show");
        }
    });
});
