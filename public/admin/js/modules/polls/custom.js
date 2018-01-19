$(document).ready(function () {
    $('.polls-analytics').on('click', '.show-result', function () {
        var url = $(this).attr('data-target');

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'html',
            success: function (data) {
                $('#poll_result_modal .modal-body').html(data);

                $('#poll_result_modal').modal();
            }
        });
    });
});
