<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$error1 = '';
include_once('functions.php');
if (isset($_POST['go'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error1 = "Username or Password is invalid";
    } else {
        $connection = mysqli_connect("localhost", "root", "root", "company");
        $usernamee = mysqli_real_escape_string($connection,$_POST['username']);
        $passwordd = mysqli_real_escape_string($connection,md5($_POST['password']));


        
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result2  = mysqli_query($connection, "SELECT * FROM login WHERE '$usernamee' = username");
        $num_rows = mysqli_num_rows($result2);
        $row = mysqli_fetch_array($result2);

        if ($num_rows == 1) {
            $hashAndSalt = $row[2];
            if(password_verify($passwordd, $hashAndSalt)){
                setSession($row['id'],$usernamee);
                header("location: profile.php"); // Redirecting To Other Page
            }
            else{
                $error1 = "Wrong password!";
            }
        } else {
            $error1 = "There is no user by that name!";
        }
        mysqli_close($connection); // Closing Connection
    }
}
?>