<?php

require("models/ck_database.php");
require("models/ck_leaveForms.php");

$leave = new LeaveForm();
$users = $leave->getAllUser();
$userById = $leave->getUser(isset($_SESSION['userID']) ? $_SESSION['userID'] : '');
