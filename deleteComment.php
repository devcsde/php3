<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php require_once("include/db.php"); ?>

<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $connection;
    $query = "DELETE FROM comments WHERE id='$id'";
    $execute = mysqli_query($connection, $query);
    if($execute){
        $_SESSION["SuccessMessage"] = "Kommentar gelöscht.";
        redirect_to("comments.php");
    } else {
        $_SESSION["ErrorMessage"] = "Kommentar konnte nicht gelöscht werden.";
        redirect_to("comments.php");
    }
}
?>