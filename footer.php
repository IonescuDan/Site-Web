<?php

if(@$_SESSION['SESS_ADMINLOGGEDIN'] == 1)
{
    if(basename($_SERVER['PHP_SELF']) != "adminorders.php") {
        echo "<p>[<a href='" . $config_basedir . "adminorders.php'>Orders</a>]";
    }

    if(basename($_SERVER['PHP_SELF']) == "products.php") {
        $id = $_GET['id'];
        echo "[<a href='" . $config_basedir . "addproducts.php?id=$id'>Add Product</a>]";
    }
}

echo "<p><i>Date: "
    . date("l m/d/Y") . "<br>"
    . "&copy; Ionescu Dan & Lupu Ionut" . "</i></p>";

?>

