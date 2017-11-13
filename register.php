<?php
require("config.php");
require("header.php");

if(!empty($_POST["register-user"])) {
    /* Form Required Field Validation */
    foreach($_POST as $key=>$value) {
        if(empty($_POST[$key])) {
            $error_message = "All Fields are required";
            break;
        }
    }
    /* Password Matching Validation */
    if($_POST['password'] != $_POST['confirm_password']){
        $error_message = 'Passwords should be same<br>';
    }

    /* Email Validation */
    if(!isset($error_message)) {
        if (!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid Email Address";
        }
    }

    if(!isset($error_message)) {

        $query = "INSERT INTO customers (username, firstname, lastname, address,  password, email, postcode, phone, registered) VALUES
		('" . $_POST["userName"] . "', '" . $_POST["firstName"] . "', '" . $_POST["lastName"] . "', '" . $_POST['address'] . "', '" . sha1($_POST["password"]) . "', '" . $_POST["userEmail"] . "', '" . $_POST["postcode"]. "', '". $_POST["phone"] . "', '" . "1" ."')";
        $result = mysqli_query($db, $query);
        if(!empty($result)) {
            $error_message = "";
            $success_message = "You have registered successfully!";
            unset($_POST);
        } else {
            $error_message = "Problem in registration. Try Again!";
        }
    }
}
?>
<html>
<head>
    <title>PHP User Registration Form</title>

</head>
<body>
<link href="stylesheet.css" rel="stylesheet" type="text/css">
<form name="frmRegistration" method="post" action="">
    <table border="0" width="500" align="center" class="demo-table">
        <?php if(!empty($success_message)) { ?>
            <div class="success-message"><?php if(isset($success_message)) echo $success_message; ?></div>
        <?php } ?>
        <?php if(!empty($error_message)) { ?>
            <div class="error-message"><?php if(isset($error_message)) echo $error_message; ?></div>
        <?php } ?>
        <tr>
            <td>User Name</td>
            <td><input type="text" class="demoInputBox" name="userName" value="<?php if(isset($_POST['userName'])) echo $_POST['userName']; ?>"></td>
        </tr>
        <tr>
            <td>First Name</td>
            <td><input type="text" class="demoInputBox" name="firstName" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>"></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type="text" class="demoInputBox" name="lastName" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" class="demoInputBox" name="password" value=""></td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td><input type="password" class="demoInputBox" name="confirm_password" value=""></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" class="demoInputBox" name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo $_POST['userEmail']; ?>"></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type="text" class="demoInputBox" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>"></td>
        </tr>
        <tr>
            <td>Postal Code</td>
            <td><input type="text" class="demoInputBox" name="postcode" value="<?php if(isset($_POST['postcode'])) echo $_POST['postcode']; ?>"></td>
        </tr>
        <tr>
            <td>Phone Number</td>
            <td><input type="text" class="demoInputBox" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>"></td>
        </tr>
        <tr>
            <td colspan=2>
                <input type="submit" name="register-user" value="Register" class="btnRegister" ></td>
        </tr>
    </table>

</form>

</body>
</html>
<?php require("footer.php"); ?>