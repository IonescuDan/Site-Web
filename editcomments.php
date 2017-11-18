<?php

require("config.php");
require("header.php");
require("functions.php");
date_default_timezone_set('Europe/Bucharest');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
</head>

<body>
<?php
    $uid = $_POST['uid'];
    $cid = $_POST['cid'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    $pid = $_POST['pid'];
echo "
    <form method='POST' action='". editComments($db) ."'>
    <input type='hidden' name='cid' value='". $cid ."'>
    <input type='hidden' name='uid' value='". $uid ."'>
    <input type ='hidden' name='date' value='". $date ."'>
    <input type ='hidden' name='pid' value='". $pid ."'>
    <textarea name = 'message'>".$message."</textarea><br>
    <button type='submit' name='commentSubmit'>Edit</button>
</form>";

require ("footer.php");
?>
</body>
</html>