$(function () {

  $(".js-create-product").click(function () {
    $.ajax({
      url: 'product/add',
      type: 'get',
      dataType: 'json',
      beforeSend: function () {
        $("#modal-book").modal("show");
      },
      success: function (data) {
        $("#modal-book .modal-content").html(data.html_form);
      }
    });
  });

});