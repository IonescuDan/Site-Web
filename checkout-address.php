<?php
session_start();
require("config.php");
$statussql = "SELECT status FROM orders WHERE id = " .$_SESSION['SESS_ORDERNUM'];
$statusres = mysqli_query($db,$statussql);
$statusrow = mysqli_fetch_assoc($statusres);
$status = $statusrow['status'];
if($status == 1)
{
    header("Location: " . $config_basedir . "checkout-pay.php");
}

if($status >= 2)
{
    header("Location: " . $config_basedir);
}
if(isset($_POST['submit']))
{
    if(isset($_SESSION['SESS_LOGGEDIN']))
    {
        if($_POST['addselectBox'] == 2)
        {
            if(empty($_POST['firstnameBox']) ||
                empty($_POST['lastnameBox']) ||
                empty($_POST['addressBox']) ||
                empty($_POST['postcodeBox']) ||
                empty($_POST['phoneBox']) ||
                empty($_POST['emailBox']))

            {
                header("Location: " . $config_basedir . "checkout-address.php?error=1");
                exit;
            }
            $addsql = "INSERT INTO delivery_addresses(firstname, lastname, address, postcode, phone, email)VALUES('" . strip_tags(addslashes( $_POST['firstnameBox'])) . "', '" . strip_tags(addslashes( $_POST['lastnameBox'])) . "', '" . strip_tags(addslashes( $_POST['addressBox'])) . "', '" . strip_tags(addslashes( $_POST['postcodeBox'])) . "', '" . strip_tags(addslashes(
                    $_POST['phoneBox'])) . "', '" . strip_tags(addslashes($_POST['emailBox'])) . "')";
            mysqli_query($db,$addsql);
            $setaddsql = "UPDATE orders SET delivery_add_id = " . mysqli_insert_id() . ", status = 1 WHERE id = " . $_SESSION['SESS_ORDERNUM'];
            mysqli_query($db,$setaddsql);
            header("Location: " . $config_basedir . "checkout-pay.php");
        }
        else
        {
            $addsql = "INSERT INTO delivery_addresses(firstname, lastname, address, postcode, phone, email)
                      SELECT firstname, lastname, address, postcode, phone, email FROM customers";
            mysqli_query($db,$addsql);
            $custsql = "UPDATE orders SET delivery_add_id = 0, status = 1 WHERE id = " . $_SESSION['SESS_ORDERNUM'];
            mysqli_query($db,$custsql);
            header("Location: " . $config_basedir . "checkout-pay.php");
        }
    }
    else
    {
        if(empty($_POST['firstnameBox']) ||
            empty($_POST['lastnameBox']) ||
            empty($_POST['addressBox']) ||
            empty($_POST['postcodeBox']) ||
            empty($_POST['phoneBox']) ||
            empty($_POST['emailBox']))

        {
            header("Location: " . $config_basedir . "checkout-address.php?error=1");
            exit;
        }

        $addsql = "INSERT INTO delivery_addresses(firstname, lastname, address, postcode, phone, email) VALUES('" . $_POST['firstnameBox'] . "', '" . $_POST['lastnameBox'] . "', '" . $_POST['addressBox'] . "', '" . $_POST['postcodeBox'] . "', '" . $_POST['phoneBox'] . "', '" . $_POST['emailBox'] . "')";
        mysqli_query($db,$addsql);
        $setaddsql = "UPDATE orders SET delivery_add_id = " . mysqli_insert_id() . ", status = 1 WHERE session = '" . session_id() . "'";
        mysqli_query($db,$setaddsql);
        header("Location: " . $config_basedir . "checkout-pay.php");
    }
}

else
{
    require("header.php");

    echo "<h1>Add a delivery address</h1>";
    if(isset($_GET['error']) == TRUE)
    {
        echo "<strong>Please fill in the missing information from the form</strong>";
    }

    echo "<form action='".$_SERVER['SCRIPT_NAME'] . "' method='POST'>";
    if(isset($_SESSION['SESS_LOGGEDIN']))
    {
        ?>

        <input type="radio" name="addselectBox" value="1" checked>Use the address from my account</input><br>
        <input type="radio" name="addselectBox" value="2" >Use the address below:</input>

        <?php
    }
    ?>

    <table>

        <tr>
            <td>Firstname</td>
            <td><input type="text" name="firstnameBox" title=""></td>
        </tr>
        <tr>
            <td>Lastname</td>
            <td><input type="text" name="lastnameBox" title=""></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type="text" name="addressBox" title=""></td>
        </tr>
        <tr>
        <tr>
            <td>Postcode</td>
            <td><input type="text" name="postcodeBox" title=""></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><input type="text" name="phoneBox" title=""></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="emailBox" title=""></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Add Address (press only once)"></td>
        </tr>
    </table>

    <?php
}

require("footer.php");
?>