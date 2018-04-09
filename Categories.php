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
    $Category = mysql_real_escape_string($_POST["Category"]);
    date_default_timezone_set('Asia/Kathmandu');
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $Admin = "Ayush Acharya";
    if(empty($Category)){
        $_SESSION["ErrorMessage"] = "All fields must be filed out.";
        Redirect_to("Categories.php");
    } elseif(strlen($Category) > 99){
        $_SESSION["ErrorMessage"] = "Too long Name.";
        Redirect_to("Categories.php");
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO category(datetime,name,creatorname)
                  VALUES('$DateTime','$Category','$Admin')";
        $Execute = mysql_query($Query);
        if($Execute) {
            $_SESSION["SuccessMessage"] = "Category added successfully.";
            Redirect_to("Categories.php");
        } else {
            $_SESSION["ErrorMessage"] = "Category failed to add.";
            Redirect_to("Categories.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
                <li><a href="AddNewPost.php">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        &nbsp;Add New Post</a> </li>
                <li class="active"><a href="Categories.php">
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
            <h1>Manage Categories</h1>
            <?php
                echo Message();
                echo SuccessMessage();
            ?>
            <div>
            <form action="Categories.php" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="categoryname"><span class="FieldInfo">Name:</span></label>
                        <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
                    </div>
                    <br>
                    <input class="btn btn-primary btn-block" type="Submit" name="Submit" value="Add New Category">
                    <br>
                </fieldset>

            </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr. No</th>
                        <th>Date & Time</th>
                        <th>Category Name</th>
                        <th>Creator Name</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        global $ConnectingDB;
                        $ViewQuery = "SELECT * FROM category ORDER BY datetime DESC ";
                        $Execute = mysql_query($ViewQuery);
                        $SrNo = 0;
                        while($DataRows = mysql_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $CategoryName = $DataRows["name"];
                            $CreatorName = $DataRows["creatorname"];
                            $SrNo++;

                    ?>
                    <tr>
                        <td><?php echo $SrNo; ?></td>
                        <td><?php echo $DateTime; ?></td>
                        <td><?php echo $CategoryName; ?></td>
                        <td><?php echo $CreatorName; ?></td>
                        <td><a href="DeleteCategory.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
                    </tr>
                    <?php } ?>
                </table>
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