<?php

require("../models/ck_database.php");
require("../models/ck_leaveForms.php");

$leave = new LeaveForm();

if (isset($_GET['calendar'])) {
    $holidays = $leave->holidays();

    $data = array();

    foreach ($holidays as $holiday) {
        $data[] = array(
            'from' => $holiday['holidayDate'],
            'to' => $holiday['holidayDate'],
        );
    }

    echo json_encode($data);
}

if (isset($_POST['leave'])) {
    $id = $_POST['employee_active'];
    $from = $_POST['leaveFrom'];
    $to = $_POST['leaveTo'];
    $purpose = $_POST['purpose'];
    // $signature = $_POST['signature'];

    // Convert the signature JSON to image
    // $signature = json_decode($signature);
    // $signature = base64_decode($signature->data);

    $leave->insertLeave($id, $from, $to, $purpose);
}
