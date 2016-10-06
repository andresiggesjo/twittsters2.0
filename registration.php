<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('functions.php');
include_once('functions.php');
$userID = getUserId();
$error   = ''; // Variable To Store Error Message
$errors  = ''; // Variable To Store Error Message
$errorss = '';



if (isset($_POST['signup'])) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } else {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $confirmpassword = md5($_POST['password1']);

        if (strlen($username) > 10) {
            $errorss = 'Username is longer than 10 chars';
        } else if($password != $confirmpassword){
            echo "The passwords doesnt match";
        } else{
            $connection = mysqli_connect("localhost", "root", "root", "company");
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $result2 = mysqli_query($connection, "SELECT * FROM login WHERE  '$username' = username");
            $num_rows = mysqli_num_rows($result2);
            if ($num_rows == 0) {
                //Create new user
                $sql = "INSERT INTO login (username, password) VALUES 
                ('$username' , '$password')";

                if (mysqli_query($connection, $sql)) {

                    echo "New record created successfully!";
                    header("Location:index.php");

                } else {

                    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                }

            } else {
                $errors = "Username is already taken!";
            }
            }
        }
    }

?>