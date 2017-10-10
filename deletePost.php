<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>

<?php

if(isset($_POST["Submit"])){
  global $connection;
  $deleteId = $_GET["delete"];
  $query = "DELETE FROM admin_panel WHERE id='$deleteId'";
  $execute = mysqli_query($connection, $query);

  if($execute){
    $_SESSION["SuccessMessage"] = "Artikel wurde gelöscht.";
    redirect_to("dashboard.php");
  } else {
    $_SESSION["ErrorMessage"] = "Artikel konnte nicht gelöscht werden.";
    redirect_to("deletePost.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artikel löschen</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/dashboardStyle.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                  <li><a href="index.php">Home</a></li>
                  <li><a href="blog.php" target="_blank">Blog</a></li>
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
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-2">
            &nbsp;
            <ul id="sidemenu" class="nav nav-pills nav-stacked">
                <li><a href="dashboard.php">
                    <span class="glyphicon glyphicon-th"></span>
                    &nbsp;Dashboard</a>
                </li>
                <li  class="active"><a href="addPost.php">
                    <span class="glyphicon glyphicon-list-alt"></span>
                    &nbsp;Neuer Artikel</a>
                </li>
                <li><a href="categories.php">
                    <span class="glyphicon glyphicon-tags"></span>
                    &nbsp;Kategorien</a>
                </li>
                <li><a href="#">
                    <span class="glyphicon glyphicon-user"></span>
                    &nbsp;Manage Admins</a>
                </li>
                <li><a href="comments.php">
                    <span class="glyphicon glyphicon-comment"></span>
                    &nbsp;Kommentare</a>
                </li>
                <li><a href="#">
                    <span class="glyphicon glyphicon-equalizer"></span>
                    &nbsp;Live Blog</a>
                </li>
                <li><a href="#">
                    <span class="glyphicon glyphicon-log-out"></span>
                    &nbsp;Logout</a>
                </li>
            </ul>
        </div> <!-- Sidebar End  -->
        <div class="col-sm-10">
            <div>
                <?php
                echo message();
                echo okMessage();
                ?>
            </div>
            <h1>Artikel löschen</h1>
            <div>
            <?php
            $queryId = $_GET["delete"];
            $connection;
            $query = "SELECT * FROM admin_panel WHERE id='$queryId'";
            $execute = mysqli_query($connection, $query);
            while($dataRows = mysqli_fetch_array($execute)){
                $title = $dataRows["title"];
                $category = $dataRows["category"];
                $image = $dataRows["image"];
                $post = $dataRows["post"];
            }
            ?>
                <form action="deletePost.php?delete=<?php echo $queryId; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="title"><span class="fieldInfo">Titel:</span></label>
                            <input value="<?php echo $title; ?>" class="form-control" type="text" name="Title" id="title" disabled>
                        </div>
                        <div class="form-group">
                            <label for="categorySelect"><span class="fieldInfo">Kategorie:</span></label><br />
                            <input value="<?php echo $category; ?>" class="form-control" type="text" name="Category" id="categorySelect" disabled>
                        </div>
                        <div class="form-group">
                            <label for="imageSelect"><span class="fieldInfo">Bild:</span></label><br />
                                                    <img src="upload/<?php echo $image; ?>" width="170" height="70"/>
                        </div>
                        <div class="form-group">
                            <label for="postArea"><span class="fieldInfo">Artikel:</span></label>
                            <textarea class="form-control" name="Post" id="postArea" rows="6" cols="50" disabled><?php echo $post; ?></textarea>
                        </div>
                        <br>
                        <input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Artikel löschen">
                        <br>
                    </fieldset>
                </form>
            </div>
        </div> <!-- Main End  -->
    </div>
</div>
<div id="footer">
    <p>&copy;2017 Christian Scheider [chris@devcs.de] --- All rights reserved.</p>
</div>
<div id="myspacer"></div>
</body>
</html>
