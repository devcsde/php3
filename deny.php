<?php require_once("include/sessions.php"); ?>
<?php require_once("include/helpers.php"); ?>
<?php require_once("include/db.php"); ?>

<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $connection;
    $query = "UPDATE comments SET status = 'OFF' WHERE id='$id'";
    $execute = mysqli_query($connection, $query);
    if($execute){
        $_SESSION["SuccessMessage"] = "Kommentar gesperrt.";
        redirect_to("comments.php");
    } else {
        $_SESSION["ErrorMessage"] = "Kommentar konnte nicht gesperrt werden.";
        redirect_to("comments.php");
    }
}
?>