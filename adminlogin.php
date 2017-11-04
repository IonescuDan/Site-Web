<?php
session_start();
require("config.php");
if(isset($_SESSION['SESS_ADMINLOGGEDIN'])) {
    header("Location: " . $config_basedir. "adminorders.php");
}
if(isset($_POST['submit']))
{
    $loginsql = "SELECT * FROM admin WHERE username = '" . $_POST['userBox'] . "' AND password = '" . sha1($_POST['passBox']). "'";
    $loginres = mysqli_query($db, $loginsql) or die(mysqli_error($db));
    $numrows = mysqli_num_rows($loginres);
    if($numrows == 1)
    {
        $loginrow = mysqli_fetch_assoc($loginres);
        $_SESSION['SESS_ADMINLOGGEDIN'] = 1;
        $_SESSION['SESS_ADMINUSERNAME'] = $loginrow['username'];
        header("Location: " . $config_basedir . "adminorders.php");
    }
    else
    {
        header("Location: http://" .$_SERVER['HTTP_HOST']. $_SERVER['SCRIPT_NAME'] . "?error=1");
    }
}
