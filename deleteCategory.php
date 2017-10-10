<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php require_once("include/db.php"); ?>
<?php confirm_login(); ?>
<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $connection;
    $query = "DELETE FROM category WHERE id='$id'";
    $execute = mysqli_query($connection, $query);
    if($execute){
        $_SESSION["SuccessMessage"] = "Kategorie gelöscht.";
        redirect_to("categories.php");
    } else {
        $_SESSION["ErrorMessage"] = "Kategorie konnte nicht gelöscht werden.";
        redirect_to("categories.php");
    }
}
?>