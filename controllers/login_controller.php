<?php

require("../models/database.php");
require("../models/login.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login($username, $password);
    $login->login();
}
