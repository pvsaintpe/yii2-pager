$(function() {

  $('body').on('click',function (e) {
    var select = $('.pv_select');
    if (e.target.className == 'pv_input') {
      select.css({'display': 'block'});
    } else{
      select.css({'display':'none'})
    }
  });


  $('body').on('click', function (e) {
    var selectContainer = $('.pv_input');
    var maxPageSize =  selectContainer.attr('data-max-page');
    var minPageSize =  selectContainer.attr('data-min-page');
    var currentPage = selectContainer.val();
    var number = parseInt(currentPage,10);
    number = isNaN(number) ? 0 : number;

    if (e.target.classList.contains('addNumber')) {
      if (number < maxPageSize) {
        number += 1;
        selectContainer.val('');
        selectContainer.val(number);
      }
      selectContainer.focus();
    }

    if (e.target.classList.contains('deductionNumber')) {
      if (number > minPageSize) {
        number -= 1;
        selectContainer.val('');
        selectContainer.val(number);
      }
      selectContainer.focus();
    }
  });



  $('body').keydown(function(e){
    if (e.keyCode == 13 && e.target.className == 'pv_input') {
      var selectContainer = $('.pv_input');
      var maxPageSize = selectContainer.attr('data-max-page');
      var minPageSize = selectContainer.attr('data-min-page');
      var pageNumber = selectContainer.val();
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
