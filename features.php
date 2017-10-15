<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projekte</title>
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
            <h2  class="logo"><a href="index.php"><span class="mySpan">dev</span>cs</a></h2>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Start</a></li>
                <li><a href="contact.php">Kontakt</a></li>
                <li class="active"><a href="features.php">Projekte</a></li>
                <li><a href="blog.php">Blog</a></li>
            </ul>
            <form action="blog.php" class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Suche" name="Search"> 
                    <button class="btn btn-default" name="SearchButton">Los</button>
                </div>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <?php
            global $connection;

            if(isset($_GET["SearchButton"])){
                $search = $_GET["Search"];
                $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR
                           title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                // this query for if category is set
            } elseif(isset($_GET["page"])){
                $page = $_GET["page"];
                if($page <= 0){
                    $showPostFrom = 0;
                } else {
                    $showPostFrom = ($page*5) - 5;
                }
                $query = "SELECT * FROM admin_panel WHERE category='Projekte' ORDER BY id desc LIMIT $showPostFrom, 5";
            // this query will run when no pagination is active
            } else {
                $query = "SELECT * FROM admin_panel WHERE category='Projekte' ORDER BY id desc LIMIT 0,5";
                $page = 1;
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
                <div class="caption">
                    <h3 id="header"><?php echo htmlentities($title); ?></h3>
                    <p class="post"><?php 
                        if(strlen($post) > 200){$post=substr($post, 0, 200)."...";}
                        echo nl2br($post); ?>
                    </p>
                </div>
                <a class="btn btn-default pull-right" href="fullPost.php?id=<?php echo $postId; ?>">weiter lesen &rsaquo;&rsaquo;</a>
            </div>
    <?php   } ?>

            <nav>
                <ul class="pagination pagination-secondary pagination-lg">
                <?php
                if($page > 1){
                ?>
                    <li><a href="features.php?page=<?php echo $page-1 ?>">&laquo;</a></li>
                <?php    
                }
                ?>
            <?php
            global $connection;
            $sql = "SELECT COUNT(*) FROM admin_panel";
            $execute = mysqli_query($connection, $sql);
            $rawPagination = mysqli_fetch_array($execute);
            $totalPosts = array_shift($rawPagination);
            $pages = ceil($totalPosts/5);
            
            for($i=1; $i <= $pages; $i++){
                if(isset($page)){               
                    if($i==$page){
                ?>        
                        <li class="active"><a href="features.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                <?php        
                    } else {
                ?>
                        <li><a href="features.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php
                    }
                }
            }
            if(isset($page) && $page+1 <= $pages){
            ?>
                    <li><a href="features.php?page=<?php echo $page+1 ?>">&raquo;</a></li>
            <?php    
            }
            ?>
                </ul>
            </nav>
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
                    “As you’re about to add a comment, ask yourself, ‘How can I improve the code so that this comment isn’t needed?'”
                    </strong>
            </div>
        </div>
    </div>
</div>
</body>
</html>
