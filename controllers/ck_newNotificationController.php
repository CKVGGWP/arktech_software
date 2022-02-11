<?php

require("../models/ck_database.php");
require("../models/val_notifications.php");

$notifications = new Notifications();

if (isset($_POST['approve'])) {
    $listId = $_POST['listId'];
    $approval = $_POST['reasonForApproval'];
    $leaveFrom = $_POST['leaveFrom'];
    $leaveTo = $_POST['leaveTo'];
    $status = "approve";

    $newLeaveFrom = date("Y-m-d", strtotime($leaveFrom));
    $newLeaveTo = date("Y-m-d", strtotime($leaveTo));

    $notifications->leaveFormApproval($listId, $status, $approval, $newLeaveFrom, $newLeaveTo);
}

if (isset($_POST['disapprove'])) {
    $listId = $_POST['listId'];
    $status = "disapprove";
    $disapproval = $_POST['reasonForDisapproval'];

    $notifications->leaveFormApproval($listId, $status, $disapproval);
}
