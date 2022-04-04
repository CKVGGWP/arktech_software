<?php

require("../models/ck_database.php");
require("../models/val_notifications.php");

$notifications = new Notifications();

if (isset($_POST['approve'])) {
    $listId = $_POST['listId'];
    $approval = $_POST['headRemark'];
    $status = $_POST['decisionOfHead'];

    $notifications->leaveFormApproval($listId, $status, $approval);
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
