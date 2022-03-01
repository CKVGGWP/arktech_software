<?php

require("../models/ck_database.php");
require("../models/ck_leaveForms.php");

session_start();

$userID = isset($_SESSION['idNumber']) ? $_SESSION['idNumber'] : "";

$leave = new LeaveForm();

if (isset($_GET['calendar'])) {
    $holidays = $leave->holidays();
    $Sundays = $leave->getSunday();
    // $leaves = $leave->getAllLeaveById($userID);

    foreach ($holidays as $holiday) {
        $data[] = array(
            'from' => $holiday['holidayDate'],
            'to' => $holiday['holidayDate'],
        );
    }

    foreach ($Sundays as $Sunday) {
        $data[] = array(
            'from' => $Sunday['SundayDate'],
            'to' => $Sunday['SundayDate'],
        );
    }

    // foreach ($leaves as $leave) {
    //     $data[] = array(
    //         'from' => $leave['leaveFrom'],
    //         'to' => $leave['leaveTo'],
    //     );
    // }

    echo json_encode($data);
}

if (isset($_POST['leave'])) {
    $id = $_POST['employee_active'];
    $from = $_POST['leaveFrom'];
    $to = $_POST['leaveTo'];
    $purpose = $_POST['purpose'];

    $leave->insertLeave($id, $from, $to, $purpose);
}
