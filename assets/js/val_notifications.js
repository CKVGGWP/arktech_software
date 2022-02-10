// Server-side processing with object sourced data
$(document).ready(function () {
  var dataTable = $("#userTable").DataTable({
    lengthChange: false,
    searching: false,
    processing: true,
    ordering: false,
    serverSide: true,
    bInfo: false,
    ajax: {
      url: "controllers/val_notificationsController.php", // json datasource
      type: "POST", // method  , by default get
      /*
	  success: function (row, data, index) {
        console.log(row);
      },
      */

      error: function () {
        // error handling
      },
    },
    createdRow: function (row, data, index) {},
    columnDefs: [],
    fixedColumns: true,
    deferRender: true,
    scrollY: 500,
    scrollX: false,
    scroller: {
      loadingIndicator: true,
    },
    stateSave: false,
  });
  console.log(index);
});
