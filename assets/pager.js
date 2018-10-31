$(function() {
    $('body').on('change', 'input.page-selector', function () {
        var url = $(this).data('url') + '&page=' + $(this).val();
        var id = $(this).closest('div[data-pjax-container]').attr('id');
        $.pjax({url: url, container: '#' + id});
    }).on('change', 'select.page-size', function () {
        var currentPage = $(this).attr('data-page');
        console.log('current-page: ', currentPage);
        var currentPerPage = $(this).attr('data-per-page');
        console.log('current-per-page: ', currentPerPage);
        console.log('current-page(-1): ', (currentPage - 1));
        console.log('current-page(-1)*current-per-page: ', (currentPage - 1) * currentPerPage);
        console.log('new-page: ', $(this).val());
        var calcPage = ((currentPage - 1) * currentPerPage) / $(this).val();
        console.log('calc-page: ', calcPage);
        var page = Math.ceil(calcPage) + 1;
        console.log('round-page(+1): ', page);
        var url = $(this).data('url') + '&page=' + page + '&per-page=' + $(this).val();
        console.log('url: ', url);
        var id = $(this).closest('div[data-pjax-container]').attr('id');
        $.pjax({url: url, container: '#' + id});
    });
});
