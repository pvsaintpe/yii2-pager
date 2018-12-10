$(function () {

    $('body').on('click', function (e) {
        var selectContainer = $('.pv_input');
        if (e.target.classList.contains('bootstrap-touchspin-up') ||
            e.target.classList.contains('bootstrap-touchspin-down')) {
            selectContainer.focus();
        }
    });

    $('body').keydown(function (e) {
        if (e.keyCode == 13 && e.target.classList.contains('pv_input')) {
            var selectContainer = $('.pv_input');
            var maxPageSize = parseInt(selectContainer.attr('data-max-page'), 10);
            var minPageSize = parseInt(selectContainer.attr('data-min-page'), 10);
            var pageNumber = parseInt(selectContainer.val(), 10);
            if (pageNumber > maxPageSize) {
                pageNumber = maxPageSize
            } else if (pageNumber < minPageSize) {
                pageNumber = minPageSize
            }
            var url = selectContainer.attr('data-url');
            url += pageNumber;

            var container = selectContainer.closest('div[data-pjax-container]');
            if (container.length) {
                $.pjax({url: url, container: '#' + container.attr('id')});
            } else {
                location.href = url;
            }
        }
    });

});