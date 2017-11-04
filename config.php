<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbdatabase = "programareweb";
$config_basedir = "https://localhost/Programare%20Web/";
$config_sitename = "Online Shop";
$db = mysqli_connect($dbhost, $dbuser, $dbpassword) or die(mysqli_error($db));
mysqli_select_db($db, $dbdatabase) or die(mysqli_error($db));
?>