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
    } elseif(strpos($comment, "<script>") !== false){
        $_SESSION["ErrorMessage"] = "<script> tags sind nicht erlaubt.";
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
<body class="bg">
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
                <li><a href="contact.php">Kontakt</a></li>
                <li><a href="features.php">Projekte</a></li>
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
<div class="container">
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
            // when search, do this
            if(isset($_GET["SearchButton"])){
                $search = $_GET["Search"];
                $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR
                           title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
            } else {
                $urlPostId = $_GET["id"];
                $query = "SELECT * FROM admin_panel WHERE id = '$urlPostId' ORDER BY id desc";
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
                if(empty($image)){$image = "noimg.png";} 
            ?>
            <div class="blogpost thumbnail">
                <img class="img-responsive img-rounded" src="upload/<?php echo $image; ?>">
                <div class="caption">
                    <h3 id="header"><?php echo htmlentities($title); ?></h3>
                    <p class="description">Kategorie: <?php echo htmlentities($category); ?>, veröffentlicht: <?php echo htmlentities($datetime); ?></p>
                    <p class="post"><?php echo nl2br($post); ?> </p>
                </div>
            </div>
            <?php 
            } 
            ?>
            <br><br>
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
                    <p><?php echo nl2br($comment); ?></p>
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
                        <label for="area1"><span class="mySpan2">Kommentar:</span></label>
                        <textarea class="form-control" name="Comment" id="area1"></textarea>
                    </div>
                    <input class="btn btn-default" type="Submit" name="Submit" value="Kommentar hinzufügen">
                </fieldset>
            </form>
            </div>
            &nbsp;
        </div>
        <div class="col-sm-offset-1 col-sm-3">
            <div class="panel panel-default sidebar">
                <h4 class=""><strong>Letzte Artikel</strong></h4>
                <div class="panel-body">
                    <?php 
                    global $connection;
                    $sql = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 3";
                    $execute = mysqli_query($connection, $sql);
                    while($dataRows = mysqli_fetch_array($execute)){
                        $id = $dataRows["id"];
                        $title = $dataRows["title"];
                        $datetime = $dataRows["datetime"];
                        $image = $dataRows["image"];
                        if(strlen($datetime) > 8){$datetime = substr($datetime, 0,8);}
                        if(empty($image)){$image = "noimg.png";}
                    ?>
                    <hr>
                    <div class="margin1">
                        <img class="pull-left" style="margin: 0 0 0 5px;" src="upload/<?php echo htmlentities($image); ?>" width=75 height=60>
                        <a href="fullPost.php?id=<?php echo $id; ?>"><p style="margin-left: 90px"><strong class="mysidebar2"><?php echo htmlentities($title); ?></strong></p></a>
                        <p class="description" style="margin-left: 90px"><?php echo htmlentities($datetime) ?></p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default sidebar">
                <h4><strong>Kategorien</strong></h4>
                <div class="panel-body">
                    <hr>
                    <?php 
                    global $connection;
                    $sql = "SELECT * FROM category ORDER BY name asc";
                    $execute = mysqli_query($connection, $sql);
                    while($dataRows = mysqli_fetch_array($execute)){
                        $id = $dataRows["id"];
                        $category = $dataRows["name"];
                    ?>
                    <a href="blog.php?cat=<?php echo $category; ?>"><span  class="myheader"><?php echo $category."<br>"; ?></span></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="thumbnail sidebar">
                <h3><span class="mySpan">dev</span>elopment<br>
                <span class="mySpan2">c</span>oncept<br> 
                <span class="mySpan2">s</span>tyle</h3>
                <hr>
                    <strong>
                    “If debugging is the process of removing software bugs, then programming must be the process of putting them in.”
                    </strong>
            </div>
        </div>
    </div>
</div>
</body>
</html>