$(document).ready(function () {
  checkHolidays();

  function checkHolidays() {
    $.ajax({
      url: "controllers/ck_holidayController.php",
      type: "GET",
      data: { calendar: 1 },
      success: function (data) {
        let parsed = JSON.parse(data);

        $(".calendar").flatpickr({
          altInput: true,
          altFormat: "F j, Y",
          dateFormat: "Y-m-d",
          //minDate: new Date().fp_incr(1),
          disable: parsed,
          locale: {
            firstDayOfWeek: 1, // start week on Monday
          },
        });
      },
    });
  }

  $("#leaveForm").on("submit", function (e) {
    e.preventDefault();

    var employee_active = $("#employee_active").val();
    var leaveFrom = $("#leaveFrom").val();
    var leaveTo = $("#leaveTo").val();
    var purpose = $("#purpose").val();
    var halfDay = $("input[id=halfDay]");

    if (halfDay.prop("checked")) {
      halfDay = 1;
    } else {
      halfDay = 0;
    }

    if (leaveFrom == "") {
      Swal.fire({
        icon: "error",
        title: "Leave From is Empty!",
        text: "Please select a starting date!",
      });
    } else if (leaveTo == "") {
      Swal.fire({
        icon: "error",
        title: "Leave To is Empty!",
        text: "Please select an ending date!",
      });
    } else if (leaveFrom > leaveTo) {
      Swal.fire({
        icon: "info",
        title: "Invalid Date!",
        text: "Leave To cannot be before Leave From!",
      });
    } else if (purpose == "") {
      Swal.fire({
        icon: "error",
        title: "Purpose of Leave is Empty!",
        text: "Please enter a purpose of leave!",
      });
    } else {
      var formData = new FormData();

      var uploadFile = $("#uploadFile")[0].files[0];
      formData.append("uploadFile", uploadFile);
      formData.append("leave", "1");
      formData.append("employee_active", employee_active);
      formData.append("leaveFrom", leaveFrom);
      formData.append("leaveTo", leaveTo);
      formData.append("purpose", purpose);
      formData.append("halfDay", halfDay);
      console.log(halfDay);
      $.ajax({
        url: "controllers/ck_holidayController.php",
        type: "POST",
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function () {
          $("#blur").addClass("blur-active");
          $(".preloader").show();
        },
        complete: function () {
          $("#blur").removeClass("blur-active");
          $(".preloader").hide();
        },
        success: function (response) {
          console.log(response);
          // Swal.fire({
          // icon: "success",
          // title: response,
          // text: "Please wait for the status of your leave request.",
          // });
          if (response == "1") {
            Swal.fire({
              icon: "success",
              title: "Leave Form Submitted!",
              text: "Please wait for the status of your leave request.",
            });
            $("#leaveForm")[0].reset();
          } else if (response == "2") {
            Swal.fire({
              icon: "error",
              title: "Something went wrong!",
              text: "There is a problem with the server! Please try again later!",
            });
          } else if (response == "3") {
            Swal.fire({
              icon: "info",
              title: "Starting Date or End Date is Conflict!",
              text: "Your starting or end date is in conflict! Please check the status of your ongoing/on approval leave and choose another date.",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: response,
            });
          }
        },
      });
    }
  });
});
