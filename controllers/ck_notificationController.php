<?php

require("models/ck_database.php");
require("models/val_notifications.php");

$notification = new Notifications();

$notifCount = $notification->countNotification();
