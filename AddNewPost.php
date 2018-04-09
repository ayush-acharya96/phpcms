<?php
    require_once("Include/DB.php");
?>
<?php
    require_once("Include/Session.php");
?>
<?php
    require_once("Include/Functions.php");
?>
<?php
if(isset($_POST["Submit"])){
    $Title = mysql_real_escape_string($_POST["Title"]);
    $Category = mysql_real_escape_string($_POST["Category"]);
    $Post = mysql_real_escape_string($_POST["Post"]);
    date_default_timezone_set('Asia/Kathmandu');
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $Admin = "Ayush Acharya";
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);
    if(empty($Title)){
        $_SESSION["ErrorMessage"] = "Title can't be empty.";
        Redirect_to("AddNewPost.php");
    } elseif(strlen($Title) < 2){
        $_SESSION["ErrorMessage"] = "Title should be at least 2 characters.";
        Redirect_to("AddNewPost.php");
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO admin_panel(datetime,title,category,author,image,post)
                  VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
        $Execute = mysql_query($Query);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute) {
            $_SESSION["SuccessMessage"] = "Post added successfuly.";
            Redirect_to("AddNewPost.php");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong.";
            Redirect_to("AddNewPost.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/adminstyle.css">
    <style>
        .FieldInfo {
            color: #00695C;
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <div class="col-sm-2">
            <ul id="side_menu" class="nav nav-pills nav-stacked">
                <li><a href="Dashboard.php">
                        <span class="glyphicon glyphicon-th"></span>
                        &nbsp;DashBoard</a></li>
                <li class="active"><a href="AddNewPost.php">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        &nbsp;Add New Post</a> </li>
                <li><a href="Categories.php">
                        <span class="glyphicon glyphicon-tags"></span>
                        &nbsp;Categories</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-user"></span>
                        &nbsp;Manage Admin</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-comment"></span>
                        &nbsp;Comments</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-equalizer"></span>
                        &nbsp;Live Blog</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-log-out"></span>
                        &nbsp;Logout</a> </li>
            </ul>


        </div> <!-- Ending of side srea -->
        <div class="col-sm-10">
            <h1>Add New Post</h1>
            <?php
                echo Message();
                echo SuccessMessage();
            ?>
            <div>
            <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <div class="form-group">
                        <label for="title"><span class="FieldInfo">Title:</span></label>
                        <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label for="categoryselect"><span class="FieldInfo">Category:</span></label>
                        <select class="form-control" id="categoryselect" name="Category">
                            <?php
                            global $ConnectingDB;
                            $ViewQuery = "SELECT * FROM category ORDER BY datetime DESC ";
                            $Execute = mysql_query($ViewQuery);
                            while($DataRows = mysql_fetch_array($Execute)) {
                                $Id = $DataRows["id"];
                                $CategoryName = $DataRows["name"];
                            ?>
                            <option><?php echo $CategoryName; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imageselect"><span class="FieldInfo">Select Image:</span></label>
                        <input type="File" class="form-control" name="Image" id="imageselect">
                    </div>
                    <div class="form-group">
                        <label for="postarea"><span class="FieldInfo">Post:</span></label>
                        <textarea class="form-control" name="Post" id="postarea"></textarea>
                        <br>
                    <input class="btn btn-primary btn-block" type="Submit" name="Submit" value="Add New Post">
                    <br>
                </fieldset>

            </form>
            </div>

        </div><!-- ending of main area -->
    </div><!-- ending of row -->
</div><!-- ending of container fluid  -->
<div id="Footer">
    <hr><p>Theme By | Ayush Acharya |&copy;2016-2020 --- All right reserved.</p>
    <a style="color:white; text-decoration: none; cursor: pointer; font-weight: bold;" href="http://ayushacharya.com" target="_blank">
        <p>
            Contact me if you want beautiful templates.
        </p>
    </a><hr>

</div>
</body>
</html>