<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php confirm_login(); ?>
<?php

if(isset($_POST["Submit"])){
    $title = mysqli_real_escape_string($connection, $_POST["Title"]);
    $category = mysqli_real_escape_string($connection, $_POST["Category"]);
    $post = mysqli_real_escape_string($connection, $_POST["Post"]);
    date_default_timezone_set("Europe/Berlin");
    $currentTime = time();
    $datetime = strftime("%d.%m.%y, %H:%M:%S", $currentTime);
    $datetime;
    $admin = $_SESSION["user_name"];
    $image = $_FILES["Image"]["name"];
    $uploadPath = "upload/".basename($_FILES["Image"]["name"]);

    if(empty($title)){
        $_SESSION["ErrorMessage"] = "Bitte geben Sie einen Titel an.";
        redirect_to("editPost.php");
    } elseif (strlen($title) < 3) {
        $_SESSION["ErrorMessage"] = "Der Titel benötigt mindestens 3 Zeichen.";
        redirect_to("editPost.php");
    } else {
        global $connection;
        $editId = $_GET["edit"];
        if(empty($image)){
            $query = "UPDATE admin_panel SET datetime='$datetime', title='$title',
            category='$category', author='$admin', post='$post'
            WHERE id='$editId'";
        } else {
            $query = "UPDATE admin_panel SET datetime='$datetime', title='$title',
            category='$category', author='$admin', image='$image', post='$post'
            WHERE id='$editId'";
        }
        $execute = mysqli_query($connection, $query);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $uploadPath);
        if($execute){
            $_SESSION["SuccessMessage"] = "Artikel wurde editiert.";
            redirect_to("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Artikel konnte nicht editiert werden.";
            redirect_to("editPost.php");
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
    <title>Artikel editieren</title>
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
              <h2 class="logo"><a href="index.php"><span class="mySpan">dev</span>cs</a></h2>
          </div>
          <div class="collapse navbar-collapse" id="collapse">
              <ul class="nav navbar-nav">
                  <li><a href="index.php">Start</a></li>
                  <li><a href="services.php">Services</a></li>
                  <li><a href="features.php">Features</a></li>
                  <li><a href="contact.php">Kontakt</a></li>
                  <li><a href="blog.php" target="_blank">Blog</a></li>
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
                <li><a href="admins.php">
                    <span class="glyphicon glyphicon-user"></span>
                    &nbsp;Manage Admins</a>
                </li>
                <li><a href="comments.php">
                    <span class="glyphicon glyphicon-comment"></span>
                    &nbsp;Kommentare
                    <?php
                $connection;
                $queryDeny = "SELECT COUNT(*) FROM comments WHERE status='OFF'";
                $executeDeny = mysqli_query($connection, $queryDeny);
                $rowsDeny = mysqli_fetch_array($executeDeny);
                $totalDeny = array_shift($rowsDeny);
                if($totalDeny > 0){
                ?>
                    <div class="label label-danger"><?php echo $totalDeny; ?></div>
                <?php    
                }
                ?>
                    </a>
                </li>
                <li><a href="blog.php" target=_blank>
                    <span class="glyphicon glyphicon-equalizer"></span>
                    &nbsp;Live Blog</a>
                </li>
                <li><a href="logout.php">
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
            <h2>Artikel editieren</h2>
            <div>
            <?php
            $queryId = $_GET["edit"];
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
                <form action="editPost.php?edit=<?php echo $queryId; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="title"><span class="fieldInfo">Titel:</span></label>
                            <input value="<?php echo $title; ?>" class="form-control" type="text" name="Title" id="title" placeholder="Titel">
                        </div>
                        <div class="form-group">
                            <label for="categorySelect"><span class="fieldInfo">Kategorie:</span></label>
                            <select class="form-control" id="categorySelect" name="Category">
                            <?php
                            global $connection;
                            $viewquery = "SELECT * FROM category ORDER BY datetime desc";
                            $execute = mysqli_query($connection, $viewquery);

                            while($dataRows = mysqli_fetch_array($execute)){
                                $id = $dataRows["id"];
                                $name = $dataRows["name"];
                                if($name == $category){
                            ?>
                            <option selected="selected"><?php echo $name; ?></option>
                            <?php } else { ?>
                            <option><?php echo $name ?></option>
                            <?php
                            }}
                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imageSelect"><span class="fieldInfo">Bild:</span></label><br />
                                                    <img src="upload/<?php echo $image; ?>" width="170" height="70"/>
                            <input type="File" class="form-control" name="Image" id="imageSelect" value="<?php echo $image; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="area1"><span class="fieldInfo">Artikel:</span></label>
                            <textarea class="form-control" name="Post" id="area1" rows="6" cols="50"><?php echo $post; ?></textarea>
                        </div>
                        <br>
                        <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Artikel editieren">
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
