<?php
echo "<p><i>Date: "
    . date("l m/d/Y") . "<br>"
    . "&copy; Ionescu Dan & Lupu Ionut" . "</i></p>";
if(@$_SESSION['SESS_ADMINLOGGEDIN'] == 1)
{
    echo "[<a href='" . $config_basedir . "adminorders.php'>Orders</a>]";
}
?>

