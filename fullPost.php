<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php
if(isset($_POST["Submit"])){
    $name = mysqli_real_escape_string($connection, $_POST["Name"]);
    $email = mysqli_real_escape_string($connection, $_POST["Email"]);
    $comment = mysqli_real_escape_string($connection, $_POST["Comment"]);
    date_default_timezone_set("Europe/Berlin");
    $currentTime = time();
    $datetime = strftime("%d.%m.%y, %H:%M:%S", $currentTime);
    $datetime;
    $postId = $_GET["id"];
    
    if(empty($name) || empty($email) || empty($comment)){
        $_SESSION["ErrorMessage"] = "Bitte füllen Sie alle Felder aus.";
    } elseif (strlen($comment) > 500) {
        $_SESSION["ErrorMessage"] = "Nur 500 Zeichen per Kommentar.";
    } else {
        global $connection;
        $query = "INSERT into comments (datetime, name, email, comment, status, admin_panel_id, approved_by)
            VALUES ('$datetime', '$name', '$email', '$comment', 'OFF', '$postId', 'pending..')";
        $execute = mysqli_query($connection, $query);
       
        if($execute){
            $_SESSION["SuccessMessage"] = "Kommentar hinzugefügt und wird in Kürze freigeschaltet.";
            redirect_to("fullPost.php?id={$postId}");
        } else {
            $_SESSION["ErrorMessage"] = "Kommentar konnte nicht hinzugefügt werden.";
            redirect_to("fullPost.php?id={$postId}");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artikel</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/public.css">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/main.js"></script>
</head>
<body>
<div class="cont1"></div>
<nav class="navbar navbar-inverse" role="navigation" style="border-radius:0px;">
    <div class="container">
        <div class="navbar-header myNav">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                <span class="sr-only">Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h2 class="logo"><a href="index.php"><span class="mySpan">dev</span>cs</a></h2>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Start</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="features.php">Features</a></li>
                <li><a href="contact.php">Kontakt</a></li>
                <li class="active"><a href="blog.php">Blog</a></li>
            </ul>
            <form action="blog.php" class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Suche" name="Search"> 
                </div>
                <button class="btn btn-default" name="SearchButton">Los</button>
            </form>
        </div>
    </div>
</nav>
<div class="cont2"></div>

<div class="container">
    <div class="blog-header">
        &nbsp;
        <p class="lead"><span
                        class="txt-rotate"
                        data-period="2000"
                        data-rotate='[ "web development ++ php ++ javascript ++ nodejs ++ jquery ++ html5 ++ css" ]'></span>
        </p>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div>
            <?php
            echo message();
            echo okMessage();
            ?>
            </div>
            <?php
            global $connection;

            if(isset($_GET["SearchButton"])){
                $search = $_GET["Search"];
                $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR
                           title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
            } else {
                $urlPostId = $_GET["id"];
                $query = "SELECT * FROM admin_panel WHERE id = '$urlPostId' ORDER BY datetime desc";
            }
            $execute = mysqli_query($connection, $query);

            while($dataRows = mysqli_fetch_array($execute)){
                $postId = $dataRows["id"];
                $datetime = $dataRows["datetime"];
                $title = $dataRows["title"];
                $category = $dataRows["category"];
                $author = $dataRows["author"]; 
                $image = $dataRows["image"]; 
                $post = $dataRows["post"]; 
            ?>
            <div class="blogpost thumbnail">
                <img class="img-responsive img-rounded" src="upload/<?php echo $image; ?>">
                <div class="caption">
                    <h3 id="header"><?php echo htmlentities($title); ?></h3>
                    <p class="description">Kategorie: <?php echo htmlentities($category); ?>, veröffentlicht: <?php echo htmlentities($datetime); ?></p>
                    <p class="post"><?php echo htmlentities($post); ?> </p>
                </div>
            </div>
            <?php 
            } 
            ?>
            <h4 class="mySpan2"><strong>Kommentare:</strong></h4>
            <div class="container col-sm-12">
            <?php  
            $connection;
            $commentQuery = "SELECT * FROM comments WHERE admin_panel_id='$postId' AND status='ON' ORDER BY datetime desc";
            $execute = mysqli_query($connection, $commentQuery);
            while($dataRows = mysqli_fetch_array($execute)){
                $commentDate = $dataRows["datetime"];
                $commentName = $dataRows["name"];
                $comment = $dataRows["comment"];
            ?>
            <div class="row commentBlock thumbnail">
                <div class="col-sm-9">
                    <p><?php echo $comment; ?></p>
                </div>
                <div class="col-sm-3">
                    <p class="comments"><?php echo $commentName; ?></p>
                    <p class="description"><?php echo $commentDate; ?></p>
                </div>
            </div>
            <hr>
            <?php
            }
            ?>
            <form class="commentForm" action="fullPost.php?id=<?php echo $postId; ?>" method="post" enctype="multipart/form-data">
                <fieldset>
                <div class="form-group">
                        <label for="name"><span class="mySpan2">Name:</span></label>
                        <input class="form-control" type="text" name="Name" id="name">
                    </div>
                <div class="form-group">
                        <label for="email"><span class="mySpan2">Email:</span></label>
                        <input class="form-control" type="email" name="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="commentArea"><span class="mySpan2">Kommentar:</span></label>
                        <textarea class="form-control" name="Comment" id="commentArea"></textarea>
                    </div>
                    <input class="btn btn-primary" type="Submit" name="Submit" value="Kommentar hinzufügen">
                </fieldset>
            </form>
            </div>
        </div>
        <div class="col-sm-offset-1 col-sm-3">
            <h3><span class="mySpan">dev</span>elopment<br>
            <span class="mySpan2">c</span>oncept<br> 
            <span class="mySpan2">s</span>tyle</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate excepturi earum aspernatur corporis eaque soluta dolores minus ut, veritatis magnam velit nam nihil nisi placeat quaerat eos quas debitis vitae eum corrupti ad. Nobis nisi optio possimus fugiat autem esse animi magni similique, dolore illo voluptate error at culpa non!</p>
        </div>
    </div>
</div>
<div id="footer">
    <p>&copy;2017 Christian Scheider [chris@devcs.de] --- All rights reserved.</p>
</div>
<div class="cont1"></div>
</body>
</html>