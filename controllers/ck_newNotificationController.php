<?php

require("../models/ck_database.php");
require("../models/val_notifications.php");

$notifications = new Notifications();

if (isset($_POST['approve'])) {
    $listId = $_POST['listId'];
    $approval = $_POST['headRemark'];
    $leaveFrom = isset($_POST['leaveFrom']) ? $_POST['leaveFrom'] : '';
    $leaveTo = isset($_POST['leaveTo']) ? $_POST['leaveTo'] : '';
    $status = $_POST['decisionOfHead'];

    if ($leaveFrom != '' && $leaveTo != '') {
        $newLeaveFrom = date("Y-m-d", strtotime($leaveFrom));
        $newLeaveTo = date("Y-m-d", strtotime($leaveTo));
    } else {
        $newLeaveFrom = '';
        $newLeaveTo = '';
    }

    $notifications->leaveFormApproval($listId, $status, $approval, $newLeaveFrom, $newLeaveTo);
}

if (isset($_POST['setStatus'])) {
    $leaveType = $_POST['leaveType'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $transpoAllowance = $_POST['transpoAllowance'];
    $quarantine = $_POST['quarantine'];
    $newEmpNum = $_POST['newEmpNum'];
    $decision = $_POST['decision'];

    $notifications->updateHR($decision, $leaveType, $remarks, $status, $type, $transpoAllowance, $quarantine, $newEmpNum);
}
