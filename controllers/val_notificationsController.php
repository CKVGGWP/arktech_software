<?php

require("../models/ck_database.php");
require("../models/val_notifications.php");

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : '';
$notifications = new Notifications();
$notificationsData = $notifications->getTable($userID);

echo $notificationsData;
