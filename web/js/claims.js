$(document).on('click', '#btn-configure-columns', function () {

    let gridKey = $(this).data('grid-key');

    $('#config-container').html('');
    $('#config-loader').show();
    $('#columnConfigModal').modal('show');

    $.get('/claims/config-get', {
        gridKey: gridKey
    }, function (res) {

        $('#config-loader').hide();

        if (!res.success) {
            $('#config-container').html(
                '<div class="alert alert-danger">Failed to load configuration.</div>'
            );
            return;
        }

        let html = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Column</th>
                        <th>Visible</th>
                    </tr>
                </thead>
                <tbody>
        `;

        res.data.forEach(function (col) {
            html += `
                <tr>
                    <td>${col.display_name || col.column_name}</td>
                    <td>
                        <input
                            type="checkbox"
                            class="col-toggle"
                            data-column="${col.column_name}"
                            ${parseInt(col.is_visible) === 1 ? 'checked' : ''}
                        >
                    </td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;

        $('#config-container').html(html);
    })
        .fail(function () {

            $('#config-loader').addClass('d-none');

            $('#config-container').html(
                '<div class="alert alert-danger">Unable to load configuration.</div>'
            );
        });

});

$(document).on('click', '#btn-save-config', function () {

    console.log('Save clicked');

    let gridKey = $(this).data('grid-key');

    let columns = [];

    $('.col-toggle').each(function () {
        columns.push({
            column_name: $(this).data('column'),
            is_visible: $(this).is(':checked') ? 1 : 0
        });
    });

    $.ajax({
        url: '/claims/config-save',
        type: 'POST',
        data: {
            gridKey: gridKey,
            columns: columns
        },
        success: function (res) {

            $.pjax.reload({
                container: '#claims-grid-pjax',
                url: '/claims/index',
                timeout: false
            });

            $('#columnConfigModal').modal('hide');

        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});

/**
 * Export currently filtered records
 */
$(document).on('click', '#btn-export-excel', function () {

    let params = '';

    if ($('.filters').length) {
        params = $('.filters')
            .find('input, select')
            .serialize();
    }

    console.log('Export Params:', params);

    let exportUrl = '/claims/export';

    if (params.length > 0) {
        exportUrl += '?' + params;
    }

    window.open(exportUrl, '_blank');
});


/**
 * Reset all filters
 */
$(document).on('click', '#btn-reset-filters', function () {

    $('.filters')
        .find('input[type="text"], input[type="date"], select')
        .val('');

    $.pjax.reload({
        container: '#claims-grid-pjax',
        url: '/claims/index',
        timeout: false
    });

});

$(document).on('change', '.toggle-column', function () {

    let gridKey = $(this).data('grid');
    let column = $(this).data('column');
    let isVisible = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/claims/toggle-column',
        type: 'POST',
        data: {
            grid_key: gridKey,
            column_name: column,
            is_visible: isVisible,
            _csrf: yii.getCsrfToken()
        },
        success: function (res) {
            if (res.success) {
                toggleGridColumn(column, isVisible);
            }
        }
    });
});

/**
 * Close Configuration Modal
 */
$(document).on('click', '#btn-close-config-modal', function () {
    $('#columnConfigModal').modal('hide');

});