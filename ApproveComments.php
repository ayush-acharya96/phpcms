<?php require_once("Include/session.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/DB.php"); ?>

<?php
if(isset($_GET['id'])) {
    $IdFromURL = $_GET['id'];
    $ConnectingDB;
    $Query = "UPDATE comments set status = 'ON' WHERE id = '$IdFromURL'";
    $Execute = mysql_query($Query);
    if($Execute) {
        $_SESSION["SuccessMessage"] = "Comment Approved Successfully";
        Redirect_to("Comments.php");
    } else {
        $_SESSION['ErrorMessage'] = "Oops! something went wrong. Try Again !";
        Redirect_to("FullPost.php?id={$PostId}");
    }
}


?>