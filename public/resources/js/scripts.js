(function ($) {
    "use strict"; // Start of use strict

    $('.login-form').each(function () {
        $(this).on('blur', function () {
            if ($(this).val().trim() !== "") {
                $(this).addClass('login-focused');
            } else {
                $(this).removeClass('login-focused');
            }
        })
    })

    const doUpdate = function () {
        $('.dv-countdown').each(function () {
            $('.dv-progress-bar').width('0%');
            const count = parseInt($(this).html());
            if (count !== 0) {
                $(this).html(count - 1);
            }
            if (count === 0) {
                $('.dv-message').remove()
            }
        });
    };

    // Schedule the update to happen once every second
    setInterval(doUpdate, 1000);

})(jQuery);

$(document).ready( function () {
    $('#dreamTable').DataTable({
        "pageLength": 25
    });

    $('#dvTicketsTable').DataTable({
        "pageLength": 25,
        "order": [[ 4, "desc" ]]
    });

    $('#dvComplaintsTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "desc" ]]
    });

    $('#dvUnbansTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "desc" ]]
    });

    $('#dvHelperAppsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]]
    });

    $('#dvLeaderAppsTable').DataTable({
        "pageLength": 25,
        "order": [[ 2, "asc" ]]
    });

    $('#dvFactionsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]]
    });

    $('#dvFMembersTable').DataTable({
        "pageLength": 25,
        "order": [[ 1, "asc" ]]
    });

    $('#dvApplicationsTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "asc" ]]
    });

    $('#dvQuestionsTable').dataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]]
    });

    $('#dvResignationsTable').dataTable({
        "pageLength": 25,
        "order": [[ 2, "desc" ]]
    });

    $('#dvFamiliesTable').dataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]]
    });

    $('#dvFamilyMembersTable').dataTable({
        "pageLength": 25,
        "order": [[ 0, "asc" ]]
    });

    $('#dvTopPlayersTable').dataTable({
        "pageLength": 25,
        "order": [[ 2, "desc" ]]
    });

    $('#dvBannedPlayersTable').dataTable({
        "pageLength": 25,
        "order": [[ 4, "desc" ]]
    });

    $('#dvPropertiesTable').dataTable({
        "pageLength": 50,
        "order": [[ 0, "asc" ]]
    });

    $('#dvAllLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvAdminLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvAnticheatLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvChatLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvBusinessLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvHouseLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvCarLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $('#dvMoneyLogsTable').dataTable({
        "pageLength": 100,
        "order": [[ 2, "desc" ]]
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    tinymce.init({
        selector: "textarea",
        menubar: false,
        statusbar: false,
        plugins: "link",
        content_style: "body.mce-content-body { color: #fff; font-size: 12px; } a { color: #fff; } .mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before { color: #7174a8 !important; }",
        toolbar: 'undo redo | bold italic underline | link blockquote removeformat'
    });
});


