<?php

require("../models/ck_database.php");
require("../models/val_checkLeaveStatus.php");

session_start();

$leaveStatus = new LeaveStatus();
$leaveData = $leaveStatus->getTable(isset($_SESSION['userID']) ? $_SESSION['userID'] : '');

echo $leaveData;
