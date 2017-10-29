<?php
session_start();
require('config.php');
require("header.php");
require("functions.php");
echo "<h1>Your shopping cart</h1>";
showcart();
require("footer.php");
?>
