<?php

require("../models/ck_database.php");
require("../models/val_checkLeaveStatus.php");

$leaveStatus = new LeaveStatus();
$leaveData = $leaveStatus->getTable();

echo $leaveData;
