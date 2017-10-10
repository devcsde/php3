<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php confirm_login(); ?>

<?php
if(isset($_POST["Submit"])){
    $name = mysqli_real_escape_string($connection, $_POST["Username"]);
    $password = mysqli_real_escape_string($connection, $_POST["Password"]);
    $confirm = mysqli_real_escape_string($connection, $_POST["ConfirmPassword"]);
    date_default_timezone_set("Europe/Berlin");
    $currentTime = time();
    $datetime = strftime("%d.%m.%y, %H:%M:%S", $currentTime);
    $datetime;

    $admin = $_SESSION["user_name"];
    if(empty($name)){
        $_SESSION["ErrorMessage"] = "Bitte geben Sie einen Namen an.";
        redirect_to("admins.php");
    } elseif (strlen($password) < 6) {
        $_SESSION["ErrorMessage"] = "Passwort muss mindestens 6 Zeichen enthalten.";
        redirect_to("admins.php");
    } elseif ($password !== $confirm) {
        $_SESSION["ErrorMessage"] = "Passwörter stimmen nicht überein.";
        redirect_to("admins.php");
    } else {
        global $connection;
        $query = "INSERT INTO registration (datetime, name, added_by, password)
            VALUES ('$datetime', '$name', '$admin', '$password')";
        $execute = mysqli_query($connection, $query);
        if($execute){
            $_SESSION["SuccessMessage"] = "Admin hinzugefügt.";
            redirect_to("admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Admin konnte nicht hinzugefügt werden.";
            redirect_to("admins.php");
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
    <title>Admins verwalten</title>
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
            <li><a href="categories.php">
                <span class="glyphicon glyphicon-tags"></span>
                &nbsp;Kategorien</a>
            </li>
            <li  class="active"><a href="admins.php">
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
        <h2>Admins verwalten</h2>
        <div>
            <?php
                echo message();
                echo okMessage();
            ?>
        </div>
        <div>
            <form action="admins.php" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="Username"><span class="fieldInfo">Name:</span></label>
                        <input class="form-control" type="text" name="Username" id="Username">
                    </div>
                    <div class="form-group">
                        <label for="Password"><span class="fieldInfo">Password:</span></label>
                        <input class="form-control" type="password" name="Password" id="Password">
                    </div>
                    <div class="form-group">
                        <label for="ConfirmPassword"><span class="fieldInfo">Password Bestätigen:</span></label>
                        <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword">
                    </div>
                    <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Admins hinzufügen">
                    <br>
                </fieldset>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>No.</th>
                    <th>Datum/ Zeit</th>
                    <th>Admin Name</th>
                    <th>Hinzugefügt von</th>
                    <th>ID</th>
                    <th></th>
                </tr>
                <?php
                    global $connection;
                    $viewquery = "SELECT * FROM registration ORDER BY datetime desc";
                    $execute = mysqli_query($connection, $viewquery);

                    $idNo = 0;

                    while($dataRows = mysqli_fetch_array($execute)){
                        $id = $dataRows["id"];
                        $datetime = $dataRows["datetime"];
                        $name = $dataRows["name"];
                        $creator = $dataRows["added_by"];
                        $idNo ++;
                ?>

                <tr>
                    <td> <?php echo $idNo; ?> </td>
                    <td> <?php echo $datetime; ?> </td>
                    <td> <?php echo $name; ?> </td>
                    <td> <?php echo $creator; ?> </td>
                    <td> <?php echo $id; ?></td>
                    <td><a class="btn-sm btn-danger" href="deleteAdmin.php?id=<?php echo $id; ?>" onclick="return confirm('Really delete?');">Delete</a></td>

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
