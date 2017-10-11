<?php
session_start();
$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";
    $conn = mysqli_connect('localhost', 'root', '', 'login' );

    if(isset($_POST['register'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
        $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

        if(empty($username)){
            array_push($errors, "Username is empty.");
        }
        if(empty($email)){
            array_push($errors, "Email is empty.");
        }
        if(empty($password1)){
            array_push($errors, "Password is empty.");
        }
        if($password1 != $password2){
            array_push($errors, "The passwords must match.");
        }

        if(count($errors) == 0) {
            //encriptare parola
            $password = md5($password1);
            $sql = "INSERT INTO User_Data (usename, email, password)
                      VALUES ('$username', '$email', '$password')";
            mysqli_query($conn, $sql);

            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
    }

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is empty");
    }
    if (empty($password)) {
        array_push($errors, "Password is empty");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>

?>