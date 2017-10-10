<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>

<?php

function redirect_to($new_location){
    header("Location:".$new_location);
    exit;
}

function login_attempt($name, $password){
    global $connection;
    $query = "SELECT * FROM registration WHERE name='$name' AND password='$password'";
    $execute = mysqli_query($connection, $query);
    if($admin = mysqli_fetch_assoc($execute)){
        return $admin;
    } else {
        return null;
    }
}

function login(){
    if(isset($_SESSION["user_id"])){
        return true;
    } 
}

function confirm_login(){
    if(!login()){
        $_SESSION["ErrorMessage"] = "Bitte einloggen.";
        redirect_to("login.php");
    }
}

?>
