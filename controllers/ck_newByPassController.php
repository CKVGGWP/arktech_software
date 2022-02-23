<?php

require("../models/ck_database.php");
require("../models/ck_leaveForms.php");

$byPass = new LeaveForm();

if (isset($_POST['multi'])) {
    $employees = $_POST['employee'];
    $dates = $_POST['leaveDatesArray'];
    $status = $_POST['status'];
    $leaveType = $_POST['leaveType'];
    $type = $_POST['type'];
    $transpo = $_POST['transpo'];
    $quarantine = $_POST['quarantine'];
    $purpose = $_POST['purpose'];

    $data = array(
        'employees' => $employees,
        'dates' => $dates,
        'status' => $status,
        'leaveType' => $leaveType,
        'type' => $type,
        'transpo' => $transpo,
        'quarantine' => $quarantine,
        'purpose' => $purpose
    );

    $byPass->byPassInsert($data);
}
