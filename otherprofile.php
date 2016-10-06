<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
include_once('posts.php');
include_once('functions.php');
include_once('follows.php');
//$login_session = getUserName();
//$userID = getUserId();

$poster = $_GET["poster"];
$poster_id = getOtherUserID($poster);
if($poster_id == getUserId()){
    header('location:profile.php');
}

$following = getFollowersByID($poster_id);
$tweetzers = array();

$minutes=3;
$times = ($minutes*60);
$time = time();

if (!isset($_SESSION['time'])) {
        $_SESSION['time'] = time();
    } else if (($time - $_SESSION['time']) > $times) {
        session_destroy();
        header('location:index.php');
    }
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Your Home Page</title>
        <link href="assets/bootstrap/css/be.css" rel="stylesheet" type="text/css">
        <link href="assets/css/styles.css" rel="stylesheet" type="text/css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="jquery.charactercounter.js"></script>

        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
  
    </head>

    <body>
        <section class="container">
                <section class="profile-form">
                        <section class="form-outer">
                    <div id="profiles">
            <h2>  <?php echo $poster; ?></h2>

            <a href="logout.php" class="btn btn-info" role="button">Logout</a>
            <a href="public.php" class="btn btn-info" role="button">Public</a>
            <a href="profile.php" class="btn btn-info" role="button">Profile</a>

            <div class="feed">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                    <div class="twt-wrapper">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <hr />
                    <?php
                    foreach($following as $value){
                       $fidarr = getTweetsByID($value);
                        foreach($fidarr as $value){
                            $tweetzers[] = $value;
                        }
                    }
                     function sortFunction( $a, $b ) {
                    return strtotime($a["created_at"]) - strtotime($b["created_at"]);
                    }
                    usort($tweetzers, "sortFunction");
                    $reversed = array_reverse($tweetzers);
                    foreach($reversed as $value){
                        ?>
                        <ul class="media-list">
                        <li class="media">
                        <a href="#" class="pull-left">
                        <img src="assets/images/profile.jpg" alt="" class="img-circle">
                        </a>
                        <div class="media-body">
                        <span class="text-muted pull-right">
                        <small class="text-muted">
                        <?php
                           $timesince = time() - strtotime($value['created_at']);

                           if($timesince < 60){
                               echo $timesince . "s";
                           }
                           else if($timesince < 3600){
                               echo floor($timesince / 60) . "m";
                           }
                            else if($timesince < 86400){
                               echo floor($timesince / 3600) . "h";
                           }
                            else {
                               echo floor($timesince / 86400) . "d";
                           }
                    ?></small>
                            </span>
                                <strong class="text-success">@ 
                                <?php echo "<a href='otherprofile.php?poster={$value['poster']}'>{$value['poster']}</a>";?>
                                </strong>
                                <p>
                                 <?php echo  $value['text']; ?>

                                 </p>
                            </div>
                            </li>

                                            </ul>
                                            <?php    }?>
                                    </div>
                                </div>
                            </div>
                            <div id="followersforotheruser">
                                <div class="knappar">
                                <h2><?php $poster ?>följer:<h2>
                                <?php foreach ($following as $value): ?>
                                    <?php $name = getNamesById($value);
                                    if($name != $poster){
                                    echo "<a href='otherprofile.php?poster=$name' class='btn btn-info' role='button'>$name</a>";
                                    }?>
                                <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="photo-inner"><img class="profilepic" src="assets/images/profile.jpg"></div>
                       <div class= underfoto>
                               <br> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br>


                          </div>
                    </section>

            </section>

        </section>










    </body>

    </html>