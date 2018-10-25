$(function() {
    $('body').on('change', 'select.page-selector', function () {
        var url = $(this).data('url') + '&page=' + $(this).val();
        var id = $(this).closest('div[data-pjax-container]').attr('id');
        $.pjax({url: url, container: '#' + id});
    }).on('change', 'select.page-size', function () {
        var currentPage = $(this).attr('data-page');
        var currentPerPage = $(this).attr('data-per-page');
        var calcPage = ((currentPage - 1) * currentPerPage) / $(this).val();
        var page = Math.ceil(calcPage) + 1;
        var url = $(this).data('url') + '&page=' + page + '&per-page=' + $(this).val();
        var id = $(this).closest('div[data-pjax-container]').attr('id');
        $.pjax({url: url, container: '#' + id});
    });
});
