<?php

require("models/ck_database.php");
require("models/val_notifications.php");

session_start();

$userID = isset($_SESSION['idNumber']) ? $_SESSION['idNumber'] : '';

$notification = new Notifications();

if ($notification->getPosition($userID) == "HR Staff") {
    $position = "HR";
    $notificationType = $notification->getNotificationType();
} else {
    $position = "";
    $notificationType = "";
}

$notifCount = $notification->countNotification($position);
