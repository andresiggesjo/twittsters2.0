<?php
include_once('posts.php');
include_once('follows.php');
include_once('pagination.php');
include_once('functions.php');
startSession();
$userid = getUserID($login_session);

if(isset($_POST['submit'])) {
    switch ($_POST['type']) {
        case "follow":
            echo "follow";
            if (followstrue($userid, $_POST['userid']) == false) {
                follows($userid, $_POST['userid']);
            }
            break;
        case "unfollow":
            echo "unfollow";
                unfollows($userid, $_POST['userid']);
            break;
    }
}

$following = getFollowersByID($userid);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="assets/css/styles.css" rel="stylesheet" type="text/css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="jquery.charactercounter.js"></script>

        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
        <link href="erdem.css" rel="stylesheet" type="text/css">
    </head>

    <body>
         <section class="public-form">
        <div id="profiles">
            <h2>Other members!</h2>
            <div class ="knappar">
            <a href="logout.php" class="btn btn-info" role="button">Logout</a>
            <a href="profile.php" class="btn btn-info" role="button">Profile</a>

            <?php 
                $array = pages($userid);
                foreach($array as $value){
                    $id = $value['id'];
            ?>
                </div>
                    <div id="names">
                        <?php echo "<a href='otherprofile.php?poster={$value['username']}'>{$value['username']}</a><br/>"; ?>
                    </div>
                    <?php
                    $buttonText = in_array($value['id'], $following) ? "unfollow" : "follow";
                    ?>
                    <form method="post" class="forms">
                          <div id="unfollows">
                          <input value="<?php echo $buttonText; ?>" type="hidden" name="type" />
                          <input value="<?php echo $id; ?>" type="hidden" name="userid" />
                          <input class="followbutton" name="submit" type="submit" value="<?php echo $buttonText; ?>">
                          </div>
                    </form>
            <?php
                }
            ?>

        </div>
        </section>
    </body>
</html>