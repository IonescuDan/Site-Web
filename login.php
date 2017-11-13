<?php
session_start();
require("config.php");

if(isset($_SESSION['SESS_LOGGEDIN'])) {
    header("Location: " . $config_basedir);
}

if(isset($_POST['submit']))
{
    $loginsql = "SELECT * FROM customers WHERE username = '" . $_POST['userBox']. "' AND password = '" . sha1($_POST['passBox']) . "'";
    $loginres = mysqli_query($db, $loginsql);
    $numrows = mysqli_num_rows($loginres);
    if($numrows == 1)
    {
        $loginrow = mysqli_fetch_assoc($loginres);

        $_SESSION['SESS_LOGGEDIN'] = 1;
        $_SESSION['SESS_USERNAME'] = $loginrow['username'];
        $_SESSION['SESS_USERID'] = $loginrow['id'];
        $ordersql = "SELECT id FROM orders WHERE customer_id = " . $_SESSION['SESS_USERID'] . " AND status < 2";
        $orderres = mysqli_query($db, $ordersql);
        $orderrow = mysqli_fetch_assoc($orderres);
        $_SESSION['SESS_ORDERNUM'] = $orderrow['id'];
        header("Location: " . $config_basedir);
    }
    else
    {
        //header("Location: http://" .$_SERVER['HTTP_HOST']. $_SERVER['SCRIPT_NAME'] . "?error=1");
        require("adminlogin.php");
    }
}

else
{
    require("header.php");
    ?>
    <h1>Customer Login</h1>
    Please enter your username and password to log into the websites. If you do not have an account, you can get one for free by <a href="register.php"><b>registering</b></a>.
    <p>
        <?php
        if(isset($_GET['error'])) {
            echo "<strong>Incorrect username/password</strong>";
        }
        ?>

    <form action="<?php $_SERVER['SCRIPT_NAME']; ?>" method="POST">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="userBox" title="Username">
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="passBox" title="Password">
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Log in">
            </tr>
        </table>
    </form>
    <?php
}
require("footer.php");
?>
