<?php

require("../models/ck_database.php");
require("../models/ck_byPassStatus.php");

session_start();

$byPass = new ByPassStatus();
$byPassData = $byPass->getTable(isset($_SESSION['idNumber']) ? $_SESSION['idNumber'] : '');

echo $byPassData;
