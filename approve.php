<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php require_once("include/db.php"); ?>
<?php confirm_login(); ?>
<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $admin=$_SESSION["user_name"];
    $connection;
    $query = "UPDATE comments SET status = 'ON', approved_by='$admin' WHERE id='$id'";
    $execute = mysqli_query($connection, $query);
    if($execute){
        $_SESSION["SuccessMessage"] = "Kommentar freigeschaltet.";
        redirect_to("comments.php");
    } else {
        $_SESSION["ErrorMessage"] = "Kommentar konnte nicht hinzugefügt werden.";
        redirect_to("comments.php");
    }
}
?>