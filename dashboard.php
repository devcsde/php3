<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php confirm_login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Bereich</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboardStyle.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
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
            <li class="active"><a href="dashboard.php">
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
            <li><a href="blog.php"  target=_blank>
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
      <h2>Admin Dashboard</h2>
      <div class="table-responsive">
        <table class="table table-stripped table-hover">
          <tr>
            <th>No.</th>
            <th>Titel</th>
            <th>Datum</th>
            <th>Author</th>
            <th>Kategorie</th>
            <th>Bild</th>
            <th>Kommentare</th>
            <th>Details</th>
            <th></th>
          </tr>
    <?php
        $connection;
        $viewquery = "SELECT * FROM admin_panel ORDER BY id desc";
        $execute = mysqli_query($connection, $viewquery);

        $SrNo = 0;

        while($dataRows = mysqli_fetch_array($execute)){
            $id = $dataRows["id"];
            $datetime = $dataRows["datetime"];
            $title = $dataRows["title"];
            $category = $dataRows["category"];
            $author = $dataRows["author"];
            $image = $dataRows["image"];
            $post = $dataRows["post"];
            $SrNo++;
        ?>
            <tr>
              <td> <?php echo $SrNo; ?> </td>
              <td class="dashColor">  <?php
                    if(strlen($title) > 20){$title = substr($title, 0, 20)."..";}
                    echo $title;
                    ?>
                </td>
                <td>
                    <?php
                    if(strlen($datetime) > 8){$datetime = substr($datetime, 0, 8);}
                    echo $datetime; ?>
                </td>
                <td> <?php
                    if(strlen($author) > 9){$author = substr($author, 0, 9);}
                    echo $author; ?>
                </td>
                <td> <?php
                    if(strlen($category) > 8){$category = substr($category, 0, 8);}
                    echo $category; ?>
                </td>
                <td><img src="upload/<?php echo $image; ?>" width="150" height="50" /></td>
                <td>
                <?php
                $connection;
                $queryAppr = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='ON'";
                $executeAppr = mysqli_query($connection, $queryAppr);
                $rowsAppr = mysqli_fetch_array($executeAppr);
                $totalAppr = array_shift($rowsAppr);
                if($totalAppr > 0){
                ?>
                    <div class="label label-success"><?php echo $totalAppr; ?></div>
                <?php    
                }
                ?>
                <?php
                $connection;
                $queryDeny = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='OFF'";
                $executeDeny = mysqli_query($connection, $queryDeny);
                $rowsDeny = mysqli_fetch_array($executeDeny);
                $totalDeny = array_shift($rowsDeny);
                if($totalDeny > 0){
                ?>
                    <div class="label label-danger"><?php echo $totalDeny; ?></div>
                <?php    
                }
                ?>
                </td>
                <td><a target="_blank" class="btn-sm btn-primary" href="fullPost.php?id=<?php echo $id; ?>">Vorschau</a></td>
                <td>
                    <a class="btn-sm btn-warning" href="editPost.php?edit=<?php echo $id; ?>">Edit</a>
                    <a class="btn-sm btn-danger" href="deletePost.php?delete=<?php echo $id; ?>">Delete</a>
                </td>
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
</body>
</html>
