<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$error1 = ''; // Variable To Store Error Message
include_once('functions.php');
if (isset($_POST['go'])) {
    // Alltid när en bracet öppnas allt under måste tabas
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error1 = "Username or Password is invalid";
    } else {
        // Define $username and $password
        $usernamee = $_POST['username'];
        $passwordd = md5($_POST['password']);
        // Establishing Connection with Server by passing server_name, user_id and password as a parameter

        $connection = mysqli_connect("localhost", "root", "root", "company");
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // SQL query to fetch information of registerd users and finds user match.
        $result2  = mysqli_query($connection, "SELECT * FROM login WHERE '$passwordd' = password AND '$usernamee' = username");
        $num_rows = mysqli_num_rows($result2);
        $row = mysqli_fetch_array($result2);

        if ($num_rows == 1) {
            //$_SESSION['login_user'] = $usernamee; // Initializing Session
            setSession($row['id'],$usernamee);
            header("location: profile.php"); // Redirecting To Other Page
        } else {
            $error1 = "Username or Password is invalid";
        }
        mysqli_close($connection); // Closing Connection
    }
}
?>