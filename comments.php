<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kommentare</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboardStyle.css">
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
            <li><a href="addPost.php">
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
            <li class="active"><a href="comments.php">
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
      <h1>Nicht freigeschaltete Kommentare</h1>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Datum</th>
                <th>Kommentare</th>
                <th>Freischalten</th>
                <th>Löschen</th>
                <th>Vorschau</th>
            </tr>
<?php
global $connection;
$query = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc";
$execute = mysqli_query($connection, $query);
$srNo = 0;
while($dataRows = mysqli_fetch_array($execute)){
    $id = $dataRows["id"];
    $datetime = $dataRows["datetime"];
    $name = $dataRows["name"];
    $comment = $dataRows["comment"];
    $postId = $dataRows["admin_panel_id"];
    $srNo++;
    if(strlen($comment) > 40){$comment = substr($comment, 0, 40)."...";}
    if(strlen($name) > 10){$name = substr($name, 0, 10)."...";}
?>
            <tr>
                <td><?php echo htmlentities($srNo); ?></td>
                <td class="dashColor"><?php echo htmlentities($name); ?></td>
                <td><?php echo htmlentities($datetime); ?></td>
                <td><?php echo htmlentities($comment); ?></td>
                <td><a class="btn-sm btn-success" href="approve.php?id=<?php echo $id; ?>">Freischalten</a></td>
                <td><a class="btn-sm btn-danger" href="deleteComment.php?id=<?php echo $id; ?>">Löschen</a></td>
                <td><a class="btn-sm btn-primary" href="fullPost.php?id=<?php echo $postId; ?>" target=_blank>Vorschau</a></td>
            </tr>
<?php
}
?>
        </table>
      </div>

      <h1>Freigeschaltete Kommentare</h1>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Datum</th>
                <th>Kommentare</th>
                <th>Admin</th>
                <th>Sperren</th>
                <th>Löschen</th>
                <th>Vorschau</th>
            </tr>
<?php
global $connection;
$admin = "Chris";
$query = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc";
$execute = mysqli_query($connection, $query);
$srNo = 0;
while($dataRows = mysqli_fetch_array($execute)){
    $id = $dataRows["id"];
    $datetime = $dataRows["datetime"];
    $name = $dataRows["name"];
    $comment = $dataRows["comment"];
    $postId = $dataRows["admin_panel_id"];
    $srNo++;
    if(strlen($comment) > 40){$comment = substr($comment, 0, 40)."...";}
    if(strlen($name) > 10){$name = substr($name, 0, 10)."...";}
?>
            <tr>
                <td><?php echo htmlentities($srNo); ?></td>
                <td class="dashColor"><?php echo htmlentities($name); ?></td>
                <td><?php echo htmlentities($datetime); ?></td>
                <td><?php echo htmlentities($comment); ?></td>
                <td><?php echo $admin; ?></td>
                <td><a class="btn-sm btn-warning" href="deny.php?id=<?php echo $id; ?>">Sperren</a></td>
                <td><a class="btn-sm btn-danger" href="deleteComment.php?id=<?php echo $id; ?>">Löschen</a></td>
                <td><a class="btn-sm btn-primary" href="fullPost.php?id=<?php echo $postId; ?>" target=_blank>Vorschau</a></td>
            </tr>
<?php
}
?>
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
