jQuery(function ($) {

    $('body').on('click', '.select-rows tr', function () {
        if (!$(this).hasClass('header')) {
            if ($(this).hasClass('selected')) {
                $('table tr').removeClass('selected');
            } else {
                $('table tr').removeClass('selected');
                $(this).addClass('selected');
            }
        }
    });

    $('#del').on('click', function () {
        let row = getSelectedRow();
        let id = $(row).children('.id').val();

        $.ajax({
            type: "GET",
            url: "main_script.php",
            data: {del_id: id},
            success: function () {
                $(row).remove();
            }
        });
    });

    $('#save_emp').on('click', function () {

        $.ajax({
            type: "GET",
            url: "main_script.php",
            data: $('#form_emp').serializeArray(),
            success: function () {
                $('#addEmp').modal('hide');
                location.reload();
            }
        });

    });

    $('#add_relax').on('click', function () {
        let row = getSelectedRow();
        let id = $(row).children('.id').val();

        let data = $('#form_relax').serializeArray();
        data[data.length] = {name: 'employee_id', value: id};

        $.ajax({
            type: "GET",
            url: "main_script.php",
            data: data,
            success: function () {
                $('#goto').modal('hide')
            }
        });
    });

    $('#getReport').on('click', function () {
        let data = $('#form_get_report_card').serialize();
        location.href = 'reportCard.php?' + data;
    });

    function getSelectedRow() {
        return $('.selected')[0];
    }
});