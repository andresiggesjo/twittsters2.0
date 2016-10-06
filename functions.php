<?php

// Starts the sessions
function startSession(){
    if(!isset($_SESSION)){
        session_start();
    }
}
function setSession($id, $username){
    startSession();
    $_SESSION['id'] = $id;
    $_SESSION['username'] = $username;
}

function getUserName(){
    startSession();
    return $_SESSION['username'];
}

function getUserId(){
    startSession();
    return $_SESSION['id'];
}

function logOut(){
    startSession();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    $url = "index.php";
    if(isset($_GET["session_expired"])) {
        $url .= "?session_expired=" . $_GET["session_expired"];
    }
    header("Location:$url");
    //header("Location: index.php");
}



?>