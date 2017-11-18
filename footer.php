<?php

if( (@$_SESSION['SESS_ADMINLOGGEDIN'] == 1) && (basename($_SERVER['PHP_SELF']) != "adminorders.php"))
{
    echo "<p>[<a href='"  . $config_basedir . "adminorders.php'>Orders</a>]</p>";
}

echo "<p><i>Date: "
    . date("l m/d/Y") . "<br>"
    . "&copy; Ionescu Dan & Lupu Ionut" . "</i></p>";

?>

