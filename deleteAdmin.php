<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php require_once("include/db.php"); ?>
<?php confirm_login(); ?>
<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $connection;
    $query = "DELETE FROM registration WHERE id='$id'";
    $execute = mysqli_query($connection, $query);
    if($execute){
        $_SESSION["SuccessMessage"] = "Admin gelöscht.";
        redirect_to("admins.php");
    } else {
        $_SESSION["ErrorMessage"] = "Admin konnte nicht gelöscht werden.";
        redirect_to("admins.php");
    }
}
?>