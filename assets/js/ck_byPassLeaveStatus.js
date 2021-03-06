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
      url: "controllers/ck_byPassStatusController.php", // json datasource
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
    // dataTable
    //   .column(0)
    //   .nodes()
    //   .each(function (cell, i) {
    //     cell.innerHTML = i + 1 + info.start;
    //   });
  });
});

function filter() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("filter");
  filter = input.value.toUpperCase();
  table = document.getElementById("userTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
