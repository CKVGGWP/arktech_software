<?php

require("../models/ck_database.php");
require("../models/ck_leaveForm.php");

$leave = new LeaveForm();
$users = $leave->getAllUser();
$userById = $leave->getUser(isset($_SESSION['userID']) ? $_SESSION['userID'] : '');

if (isset($_GET['calendar'])) {
    $holidays = $leave->holidays();

    $data = array();

    foreach ($holidays as $holiday) {
        $data[] = array(
            'start' => $holiday['holidayDate'],
        );
    }

    echo json_encode($data);
}

if (isset($_POST['leave'])) {
    $id = $_POST['employee_active'];
    $from = $_POST['leaveFrom'];
    $to = $_POST['leaveTo'];
    $purpose = $_POST['purpose'];

    $leave->insertLeave($id, $from, $to, $purpose);
}
