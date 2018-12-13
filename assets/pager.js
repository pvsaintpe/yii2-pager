$(document).ready(function () {
    checkInput();

    $('body').on('click', function (e) {
        if (e.target.classList.contains('bootstrap-touchspin-up') ||
            e.target.classList.contains('bootstrap-touchspin-down')){
            checkInput();
        }
    });

    $('body').on('change', function (e) {
        var selectContainer = $('.pv_input');
        var maxPageSize = parseInt(selectContainer.attr('data-max-page'), 10);
        var minPageSize = parseInt(selectContainer.attr('data-min-page'), 10);
        var pageNumber = parseInt(selectContainer.val(), 10);

        if (e.target.classList.contains('pv_input')) {
            if (pageNumber >= maxPageSize) {
                btnDisabled('.bootstrap-touchspin-up');
            } else if (pageNumber <= minPageSize) {
                btnDisabled('.bootstrap-touchspin-down');
            }
            if (pageNumber > minPageSize) {
                btnEnabled('.bootstrap-touchspin-down');
            }
            if (pageNumber < maxPageSize) {
                btnEnabled('.bootstrap-touchspin-up');
            }
            selectContainer.focus();
        }
    });

    $('body').keydown(function (e) {
        var selectContainer = $('.pv_input');
        var maxPageSize = parseInt(selectContainer.attr('data-max-page'), 10);
        var minPageSize = parseInt(selectContainer.attr('data-min-page'), 10);
        var pageNumber = parseInt(selectContainer.val(), 10);

        if (e.target.classList.contains('pv_input')) {
            checkInput();
            if (e.keyCode == 13 && e.target.classList.contains('pv_input')) {
                if (pageNumber >= maxPageSize) {
                    pageNumber = maxPageSize;
                    btnDisabled('.bootstrap-touchspin-up');
                } else if (pageNumber < minPageSize) {
                    pageNumber = minPageSize;
                    btnDisabled('.bootstrap-touchspin-down');
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
        }
    });

    function checkInput() {
        var selectContainer = $('.pv_input');
        var pageNumber = parseInt(selectContainer.val(), 10);
        var maxPageSize = parseInt(selectContainer.attr('data-max-page'), 10);
        var minPageSize = parseInt(selectContainer.attr('data-min-page'), 10);

        if (pageNumber >= maxPageSize) {
            btnDisabled('.bootstrap-touchspin-up');
        }
        if (pageNumber <= minPageSize) {
            btnDisabled('.bootstrap-touchspin-down');
        }
    }

    function btnDisabled(className) {
        $(className).attr('disabled','true');
        $(className).css({"background-color":"grey"});
    }

    function btnEnabled(className) {
        $(className).removeAttr('disabled');
        $(className).css('background', '');
    }

});