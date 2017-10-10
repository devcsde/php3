<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>

<?php
if(isset($_POST["Submit"])){
    $name = mysqli_real_escape_string($connection, $_POST["Username"]);
    $password = mysqli_real_escape_string($connection, $_POST["Password"]);

    if(empty($name) || empty($password)){
        $_SESSION["ErrorMessage"] = "Bitte füllen Sie alle Felder aus.";
        redirect_to("login.php");
    } else {
        $foundAccount = login_attempt($name, $password);
        if($foundAccount){
            $_SESSION["user_id"] = $foundAccount["id"];
            $_SESSION["user_name"] = $foundAccount["name"];
            $_SESSION["SuccessMessage"] = "Hello again, {$_SESSION["user_name"]}!";
            redirect_to("dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Email/ Passwort nicht gefunden.";
            redirect_to("login.php");
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
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/public.css">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>

<div class="cont1"></div>
<nav class="navbar navbar-inverse" role="navigation" style="border-radius:0px;">
    <div class="container">
        <div class="navbar-header myNav">
            <h2 class="logo"><a href="index.php"><span class="mySpan">dev</span>cs</a></h2>
        </div>
    </div>
</nav>
<div class="cont2"></div>
<div class="container-fluid">
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
        <div>
                <?php
                    echo message();
                    echo okMessage();
                ?>
        </div>
            <h2>Hallo! Login.</h2>
            <div>
                <form action="login.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <label for="Username"><span class="mySpan2">Name:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope text-primary"></span>
                                </span>
                                <input class="form-control" type="text" name="Username" id="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Password"><span class="mySpan2">Password:</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock text-primary"></span>
                                </span>
                                <input class="form-control" type="password" name="Password" id="Password">
                            </div>
                        </div>
                        <input class="btn-lg btn-info btn-block" type="Submit" name="Submit" value="Login">
                        <br>
                    </fieldset>
                </form>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div> <!-- Main End  -->
    </div>
</div>
</body>
</html>
