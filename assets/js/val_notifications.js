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
    fixedColumns: false,
    deferRender: true,
    scrollY: 500,
    scrollX: false,
    scroller: {
      loadingIndicator: true,
    },
    stateSave: false,
  });
});

$(document).on("click", ".employees", function () {
  let employeeNumber = $(this).data("employee").employeeNumber;
  let employeeName = $(this).data("employee").employeeName;
  let designation = $(this).data("employee").designation;
  let department = $(this).data("employee").department;
  let purposeOfLeave = $(this).data("employee").purposeOfLeave;
  let leaveFrom = $(this).data("employee").leaveFrom;
  let leaveTo = $(this).data("employee").leaveTo;
  let listId = $(this).data("employee").listId;

  $("#employeeNumber").val(employeeNumber);
  $("#employeeName").val(employeeName);
  $("#designation").val(designation);
  $("#department").val(department);
  $("#purposeofLeave").val(purposeOfLeave);
  $("#leaveFrom").val(leaveFrom);
  $("#leaveTo").val(leaveTo);
  $("#listId").val(listId);
});

$("#decisionOfHead").on("change", function () {
  let des = $(this).val();

  if (des == "approve") {
    $("#approvalHead").removeClass("d-none");
    $("#disapprovalHead").addClass("d-none");
  } else if (des == "disapprove") {
    $("#approvalHead").addClass("d-none");
    $("#disapprovalHead").removeClass("d-none");
  } else {
    $("#approvalHead").addClass("d-none");
    $("#disapprovalHead").addClass("d-none");
  }
});

$(document).on("click", "#submitApproval", function () {
  let listId = $("#listId").val();
  let leaveFrom = $("#leaveFrom").val();
  let leaveTo = $("#leaveTo").val();
  let decisionOfHead = $("#decisionOfHead").val();
  let headRemark = "";

  if (decisionOfHead == "approve") {
    let approvalHeadRemarks = $("#approvalHeadRemarks").val();
    headRemark = approvalHeadRemarks;
  } else {
    let disapprovalHeadRemarks = $("#disapprovalHeadRemarks").val();
    headRemark = disapprovalHeadRemarks;
  }

  if (headRemark == "") {
    $("#remarkHeadClass").addClass("is-invalid");
    $("#remarkHeadClass").focus();
    return false;
  } else {
    $.ajax({
      url: "controllers/ck_newNotificationController.php",
      type: "POST",
      data: {
        approve: 1,
        listId: listId,
        decisionOfHead: decisionOfHead,
        headRemark: headRemark,
        leaveFrom: leaveFrom,
        leaveTo: leaveTo,
      },
      success: function (response) {
        Swal.fire({
          title: "Success",
          text: "Leave Has Been Set!",
          icon: "success",
        }).then((result) => {
          location.reload();
        });
      },
    });
  }
});

$(document).on("click", ".hr", function () {
  let empNum = $(this).data("employee").employeeNumber;
  let empName = $(this).data("employee").employeeName;
  let des = $(this).data("employee").designation;
  let dept = $(this).data("employee").department;
  let purpose = $(this).data("employee").purposeOfLeave;
  let from = $(this).data("employee").leaveFrom;
  let to = $(this).data("employee").leaveTo;
  let list = $(this).data("employee").listId;
  let reason = $(this).data("employee").reasonOfSuperior;
  let date = $(this).data("employee").date;

  $("#empNum").val(empNum);
  $("#empName").val(empName);
  $("#des").val(des);
  $("#dept").val(dept);
  $("#purpose").val(purpose);
  $("#from").val(from);
  $("#to").val(to);
  $("#list").val(list);
  $("#reason").val(reason);
  $("#dateOfApproval").val(date);

  $(".titleName").text(empName + " Leave Details");
});

$(document).on("change", "#decision", function () {
  let decision = $(this).val();

  if (decision == 3) {
    $("#approvalHR").removeClass("d-none");
    $("#disapprovalHR").addClass("d-none");
  } else if (decision == 4) {
    $("#approvalHR").addClass("d-none");
    $("#disapprovalHR").removeClass("d-none");
  } else {
    $("#approvalHR").addClass("d-none");
    $("#disapprovalHR").addClass("d-none");
  }
});

$(document).on("click", "#setStatusBTN", function () {
  let leaveType = $("#leaveType").val() ? $("#leaveType").val() : "";
  let status = $("#status").val() ? $("#status").val() : "";
  let type = $("#type").val() ? $("#type").val() : "";
  let transpoAllowance = $("#transpoAllowance").val()
    ? $("#transpoAllowance").val()
    : "";
  let quarantine = $("#quarantine").val() ? $("#quarantine").val() : "";
  let newEmpNum = $("#empNum").val();
  let decision = $("#decision").val();

  let remarks = "";

  if (decision == 3) {
    let leaveRemarks = $("#leaveRemarks").val();
    remarks = leaveRemarks;
  } else {
    let disapprovalRemarks = $("#disapprovalRemarks").val();
    remarks = disapprovalRemarks;
  }

  if (remarks == "") {
    $(".remarkClass").addClass("is-invalid");
    $(".remarkClass").focus();
    return false;
  } else {
    $.ajax({
      url: "controllers/ck_newNotificationController.php",
      type: "POST",
      data: {
        setStatus: 1,
        decision: decision,
        leaveType: leaveType,
        remarks: remarks,
        status: status,
        type: type,
        transpoAllowance: transpoAllowance,
        quarantine: quarantine,
        newEmpNum: newEmpNum,
      },
      success: function (response) {
        Swal.fire({
          title: "Success",
          text: "Leave Status has been set!",
          icon: "success",
        }).then((result) => {
          location.reload();
        });
      },
    });
  }
});
