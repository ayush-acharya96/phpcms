<?php require_once("Include/session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>

<?php
if(isset($_GET['id'])) {
    $IdFromURL = $_GET['id'];
    $ConnectingDB;
    $Query = "DELETE FROM category WHERE id = '$IdFromURL'";
    $Execute = mysql_query($Query);
    if($Execute) {
        $_SESSION["SuccessMessage"] = "Category Deleted Successfully";
        Redirect_to("Categories.php");
    } else {
        $_SESSION['ErrorMessage'] = "Oops! something went wrong. Try Again !";
        Redirect_to("Categories.php");
    }
}


?>
