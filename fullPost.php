<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>devcs // Artikel</title>
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
            <h2><a href="blog.php"><span class="mySpan">dev</span>cs</a></h2>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <li class="active"><a href="blog.php">Blog</a></li>
                <li><a href="#">Über mich</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Kontakt</a></li>
                <li><a href="#">Feature</a></li>
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
        <h3><span class="mySpan">dev</span>elopment <span class="mySpan">c</span>oncept <span class="mySpan">s</span>tyle</h3>
        <p class="lead"><span
                        class="txt-rotate"
                        data-period="2000"
                        data-rotate='[ "javascript ++ PHP ++ web development", "nodejs ++ html 5 ++ jquery ++ scss" ]'></span>
        </p>
    </div>
    <div class="row">
        <div class="col-sm-8">
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
    <?php   } ?>
        </div>
        <div class="col-sm-offset-1 col-sm-3">
            <h2>Test</h2>
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