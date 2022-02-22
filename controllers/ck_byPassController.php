<?php

require("models/ck_database.php");
require("models/ck_leaveForms.php");

$leave = new LeaveForm();
$users = $leave->getAllUser();
$userById = $leave->getUser(isset($_SESSION['idNumber']) ? $_SESSION['idNumber'] : '');

foreach ($userById as $key => $user) {
    $userPosition = $user['position'];
}

$position = $leave->getPosition($userPosition);


foreach ($position as $key => $value) {
    $positionName = $value['positionName'];
}

if ($positionName != "HR Staff") :

    header("Location: ck_leaveForm.php?title=Leave Input Form");
    exit();

endif;
