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
echo "<button onclick=\"history.go(-1);\"><-- Go back to products </button><br><br>";

if(@$_SESSION['SESS_LOGGEDIN'] == 1) {
    echo " <form method='POST' action='" . setComments($db) . "'>
        <input type='hidden' name='uid' value='" . $_SESSION['SESS_USERNAME']. "'>
        <input type ='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea name = 'message'></textarea><br>
        <button type='submit' name='commentSubmit'>Comment</button>
    </form>";
} elseif (@$_SESSION['SESS_ADMINLOGGEDIN'] == 1){
    echo "<form method='POST' action='" . setComments($db) . "'>
        <input type='hidden' name='uid' value='" . $_SESSION['SESS_ADMINUSERNAME']. "'>
        <input type ='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea name = 'message'></textarea><br>
        <button type='submit' name='commentSubmit'>Comment</button>
    </form>";
}else {
    echo "You need to be logged in to be able to write a review! <br><br>";
}
    getComments($db);
    require ("footer.php");
?>
</body>
</html>