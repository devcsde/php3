<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php confirm_login(); ?>
<?php

if(isset($_POST["Submit"])){
    $category = mysqli_real_escape_string($connection, $_POST["Category"]);
    date_default_timezone_set("Europe/Berlin");
    $currentTime = time();
    $datetime = strftime("%d.%m.%y, %H:%M:%S", $currentTime);
    $datetime;

    $admin = $_SESSION["user_name"];
    if(empty($category)){
        $_SESSION["ErrorMessage"] = "Bitte fuellen Sie alle Felder aus.";
        redirect_to("categories.php");
    } elseif (strlen($category) > 99) {
        $_SESSION["ErrorMessage"] = "Name ist zu lang.";
        redirect_to("categories.php");
    } else {
        global $connection;
        $query = "INSERT INTO category (datetime, name, creator)
            VALUES ('$datetime', '$category', '$admin')";
        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION["SuccessMessage"] = "Katergorie hinzugefügt.";
            redirect_to("categories.php");
        } else {
            $_SESSION["ErrorMessage"] = "Kategorie konnte nicht hinzugefügt werden.";
            redirect_to("categories.php");
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
    <title>Kategorien</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/dashboardStyle.css">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
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
            <li><a href="addPost.php">
                <span class="glyphicon glyphicon-list-alt"></span>
                &nbsp;Neuer Artikel</a>
            </li>
            <li  class="active"><a href="categories.php">
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
        <h2>Kategorien verwalten</h2>
        <div>
            <?php
                echo message();
                echo okMessage();
            ?>
        </div>
        <div>
            <form action="categories.php" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="Cat"><span class="fieldInfo">Name:</span></label>
                        <input class="form-control" type="text" name="Category" id="Cat" placeholder="Name">
                    </div>
                    <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Kategorie hinzufügen">
                    <br>
                </fieldset>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>No.</th>
                    <th>Datum/ Zeit</th>
                    <th>Kategorie Name</th>
                    <th>Author</th>
                    <th>ID</th>
                    <th></th>
                </tr>
                <?php
                    global $connection;
                    $viewquery = "SELECT * FROM category ORDER BY datetime desc";
                    $execute = mysqli_query($connection, $viewquery);

                    $idNo = 0;

                    while($dataRows = mysqli_fetch_array($execute)){
                        $id = $dataRows["id"];
                        $datetime = $dataRows["datetime"];
                        $name = $dataRows["name"];
                        $creator = $dataRows["creator"];
                        $idNo ++;
                ?>

                <tr>
                    <td> <?php echo $idNo; ?> </td>
                    <td> <?php echo $datetime; ?> </td>
                    <td> <?php echo $name; ?> </td>
                    <td> <?php echo $creator; ?> </td>
                    <td> <?php echo $id; ?></td>
                    <td><a class="btn-sm btn-danger" href="deleteCategory.php?id=<?php echo $id; ?>" onclick="return confirm('Really delete?');">Delete</a></td>

                </tr>

                <?php  }; ?>    <!-- end of while loop -->

            </table>
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
