$(document).ready(function () {
  $(".category").select2();

  checkHolidays();

  function checkHolidays() {
    $.ajax({
      url: "controllers/ck_holidayController.php",
      type: "GET",
      data: { calendar: 1 },
      success: function (data) {
        let parsed = JSON.parse(data);

        $(".calendar").flatpickr({
          mode: "multiple",
          altInput: true,
          altFormat: "F j, Y",
          dateFormat: "Y-m-d",
          minDate: new Date().fp_incr(1),
          disable: parsed,
          locale: {
            firstDayOfWeek: 1, // start week on Monday
          },
        });
      },
    });
  }

  $("#submitLeave").on("submit", function (e) {
    e.preventDefault();

    // let employees = [];
    let employee = $("#employees").val();
    let leaveDate = $("#leaveDates").val();
    let status = $("#status").val();
    let type = $("#type").val();
    let transpo = $("#transpo").val();
    let quarantine = $("#quarantine").val();
    let purpose = $("#purpose").val();
    let leaveType = $("#leaveType").val();
    let leaveDatesArray = leaveDate.split(",");

    // $("#employees").each(function () {
    //   employees.push($(this).val());
    // });

    if (employee == "") {
      Swal.fire({
        icon: "error",
        title: "Employee Field is Empty!",
        text: "Please select at least one employee!",
      });
    } else if (leaveDates == "") {
      Swal.fire({
        icon: "error",
        title: "Leave Date Field is Empty!",
        text: "Please select at least one leave date!",
      });
    } else if (purpose == "") {
      Swal.fire({
        icon: "error",
        title: "Purpose Field is Empty!",
        text: "Please enter a purpose of leave!",
      });
    } else {
      $.ajax({
        url: "controllers/ck_newByPassController.php",
        type: "POST",
        data: {
          multi: 1,
          employee: employee,
          leaveDatesArray: leaveDatesArray,
          status: status,
          leaveType: leaveType,
          type: type,
          transpo: transpo,
          quarantine: quarantine,
          purpose: purpose,
        },
        beforeSend: function () {
          $("#blur").addClass("blur-active");
          $(".preloader").show();
        },
        complete: function () {
          $("#blur").removeClass("blur-active");
          $(".preloader").hide();
        },
        success: function (response) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Leave has been submitted!",
          }).then((result) => {
            window.location.href = "ck_leaveForm.php?title=Dashboard";
          });
        },
      });
    }
  });
});

// $("body").on("click", ".store-data", function (e) {
//   e.preventDefault();

//   //Get Text
//   var selected = $(".category").select2("data");
//   for (var i = 0; i <= selected.length - 1; i++) {
//     console.log(selected[i].text);
//   }
// });
