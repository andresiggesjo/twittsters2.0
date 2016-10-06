<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$error  = ''; // Variable To Store Error Message
$errors = ''; // Variable To Store Error Message
$text   = '';
//echo $login_user;
include_once('functions.php');
$login_session = getUserName();

$comment = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function getTweets($user)
{
    $conn = mysqli_connect("localhost", "root", "root", "company");
    
    $sqlii  = "SELECT text,poster,created_at FROM posts WHERE ('$user' = poster)";
    $result = mysqli_query($conn, $sqlii);
    $tweets = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            // echo "author: " . $row["poster"] . " -text: " . $row["text"] . "<br>";
            array_push($tweets, $row);
            
        }
        
    }
    return $tweets;
}



function getTweetsByID($userid){
    $conn = mysqli_connect("localhost", "root", "root", "company");
    $sqlii  = "SELECT text,poster,created_at FROM posts WHERE ('$userid' = poster_id)";
    $result = mysqli_query($conn, $sqlii);
    $tweets = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            // echo "author: " . $row["poster"] . " -text: " . $row["text"] . "<br>";
            array_push($tweets, $row);
            
        }
        
    }
    return $tweets;
    
}



function getFollowersTweets($user)
{
    $conn  = mysqli_connect("localhost", "root", "root", "company");
    $sqlii = "SELECT text, poster, created_at FROM posts JOIN (SELECT login FROM  
 login LEFT JOIN (SELECT followee_id FROM Follows WHERE user_id = $user[id] )AS
 Follows ON followee_id = id WHERE followee_id = id OR id = $user[id] ) AS login
 ON user_id = login.id ORDER BY posts.created_at";
    
    $result = mysqli_query($conn, $sqlii);
    $tweets = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($tweets, $row);
        }
    }
    return $tweets;
}








if (isset($_POST['tweettext'])) {
    echo $comment;
    
    $text       = $_POST['comment'];
    $poster     = $login_session;
    $created_at = date('Y-m-d H:i:s');
    
    // $poster_id = "SELECT id FROM login WHERE username = ('$poster')";   
    
    
    
    $connection = mysqli_connect("localhost", "root", "root", "company");
    /*   
    $result = mysqli_query($connection, "SELECT id FROM login WHERE  '$poster' = username"); 
    */
    
    $sql1 = "SELECT id FROM login WHERE ('$poster' = username)";
    if (mysqli_query($connection, $sql1)) {
        
        $cursor = mysqli_query($connection, $sql1);
        $row    = mysqli_fetch_row($cursor);
        $id     = $row[0];
        
        
        
    }
    
    
    
    
    
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $sql = "INSERT INTO posts (poster, poster_id, text, created_at) VALUES 
                ('$poster' , '$id' , '$text' , '$created_at')";
        
        if (mysqli_query($connection, $sql)) {
            
            echo "New record created successfully!";
            echo $text;
            echo $created_at;
            
        } else {
            
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}
?>