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
    $Username = mysql_real_escape_string($_POST["Username"]);
    $Password = mysql_real_escape_string($_POST["Password"]);
    $ConfirmPassword = mysql_real_escape_string($_POST["ConfirmPassword"]);
    date_default_timezone_set('Asia/Kathmandu');
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $DateTime;
    $Admin = "Ayush Acharya";
    if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
        $_SESSION["ErrorMessage"] = "All fields must be filed out.";
        Redirect_to("Admins.php");
    } elseif(strlen($Password) < 4) {
        $_SESSION["ErrorMessage"] = "Password must be at least 4 characters.";
        Redirect_to("Admins.php");
    } elseif($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMessage"] = "Passwords donot match";
    } else {
        global $ConnectingDB;
        $Query = "INSERT INTO registration(datetime,username,password,addedby)
                  VALUES('$DateTime','$Username','$Password','$Admin')";
        $Execute = mysql_query($Query);
        if($Execute) {
            $_SESSION["SuccessMessage"] = "Admin added successfully.";
            Redirect_to("Admins.php");
        } else {
            $_SESSION["ErrorMessage"] = "Failed to add admin.";
            Redirect_to("Admins.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
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
                <li><a href="Categories.php">
                        <span class="glyphicon glyphicon-tags"></span>
                        &nbsp;Categories</a> </li>
                <li class="active"><a href="Admins.php">
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
            <h1>Manage Admin Access</h1>
            <?php
                echo Message();
                echo SuccessMessage();
            ?>
            <div>
            <form action="Admins.php" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="Username"><span class="FieldInfo">Username:</span></label>
                        <input class="form-control" type="text" name="Username" id="Username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="Password"><span class="FieldInfo">Password:</span></label>
                        <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span></label>
                        <input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirm Password">
                    </div>
                    <br>
                    <input class="btn btn-primary btn-block" type="Submit" name="Submit" value="Add New Admin">
                    <br>
                </fieldset>

            </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Sr. No</th>
                        <th>Date & Time</th>
                        <th>Admins</th>
                        <th>Added BY</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        global $ConnectingDB;
                        $ViewQuery = "SELECT * FROM registration ORDER BY datetime DESC ";
                        $Execute = mysql_query($ViewQuery);
                        $SrNo = 0;
                        while($DataRows = mysql_fetch_array($Execute)) {
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $UserName = $DataRows["username"];
                            $AddedBy = $DataRows["addedby"];
                            $SrNo++;

                    ?>
                    <tr>
                        <td><?php echo $SrNo; ?></td>
                        <td><?php echo $DateTime; ?></td>
                        <td><?php echo $UserName; ?></td>
                        <td><?php echo $AddedBy; ?></td>
                        <td><a href="DeleteAdmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
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