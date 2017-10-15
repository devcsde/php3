<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kontakt</title>
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
                <li class="active"><a href="contact.php">Kontakt</a></li>
                <li><a href="features.php">Projekte</a></li>
                <li><a href="blog.php">Blog</a></li>
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
&nbsp;
&nbsp;
<div class="container">
    <div class="row row-fluid">
        <div class="col-sm-8">
            <div class="blogpost thumbnail">
                <div class="caption">

                <h4>Schreiben Sie mir eine email an chris@devcs.de</h4>
                   
                </div>
            </div>
    
        </div>
        <div class="col-sm-offset-1 col-sm-3 pull-down">
            <div class="sidebar thumbnail">
                  <h3><span class="mySpan">dev</span>elopment<br>
            <span class="mySpan2">c</span>oncept<br> 
            <span class="mySpan2">s</span>tyle</h3>
            <hr>
            <strong>
            “Most good programmers do programming not because they expect to get paid or get adulation by the public, but because it is fun to program.”
            </strong>
            </div>
          
        </div>
    </div>
</div>
<!-- <div class="footer">
    <p>&copy;2017 Christian Scheider [chris@devcs.de] --- All rights reserved.</p>
</div> -->
</body>
</html>