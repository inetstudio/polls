let pollsAnalytics = {};

pollsAnalytics.init = function () {
    $(document).ready(function () {
        $('.polls-analytics').on('click', '.show-result', function () {
            let pollId = $(this).attr('data-id');
            let url = route('back.polls.analytics.result', {
                id: pollId
            });

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                success: function (data) {
                    $('#poll_result_modal .modal-body').html(data);

                    $('#poll_result_modal').modal();
                }
            });
        });
    });
};

module.exports = pollsAnalytics;
