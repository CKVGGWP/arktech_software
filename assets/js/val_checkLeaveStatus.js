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
    createdRow: function (row, data, index) {},
    columnDefs: [],
    fixedColumns: false,
    deferRender: true,
    scrollY: 400,
    scrollX: true,
    scroller: {
      loadingIndicator: true,
    },
    stateSave: false,
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

$(document).on("click", ".uploadFile", function () {
  let listID = $(this).data("id");

  $("#uploadFileHR").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    console.log(listID);

    let files = $("#exampleFormControlFile1")[0].files[0];

    if (files == undefined) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Please select a file to upload!",
      });
    } else if (files.type != "application/pdf") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "File must be a PDF file",
      });
    } else {
      formData.append("listID", listID);
      formData.append("file", files);
      formData.append("upload", "upload");

      $.ajax({
        url: "controllers/ck_holidayController.php",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          Swal.fire({
            title: "Uploading...",
            html:
              '<div class="spinner-border text-primary" role="status">' +
              '<span class="sr-only">Loading...</span>' +
              "</div>",
            showConfirmButton: false,
            allowOutsideClick: false,
          });
        },
        complete: function () {
          Swal.close();
        },
        success: function (data) {
          if (data) {
            Swal.fire({
              icon: "success",
              title: "Success!",
              text: "File has been uploaded!",
            }).then((result) => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          }
        },
      });
    }
  });
});
