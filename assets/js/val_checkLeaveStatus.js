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
      url: "controllers/val_leaveStatusController.php", // json datasource
      type: "POST", // method  , by default get

      error: function () {
        // error handling
      },
    },
    createdRow: function (data) {},
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
  dataTable.on("draw.dt", function () {
    var info = dataTable.page.info();
    dataTable
      .column(1)
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
      });
  });
});
