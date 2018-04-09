<?php
    require_once("Include/Session.php");
?>
<?php
    require_once("Include/Functions.php");
?>
<?php
    require_once("Include/DB.php");
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
</head>
<body>
<div style="height: 10px; background: #00695C"></div>
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Blog.php">
                Spr!ng
                <!--                    <img src="images/ayushacharya.png" width:200; height:100;>-->
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse" >
            <ul class="nav navbar-nav">
                <li><a href="#">Home</a></li>
                <li class="active"><a href="Blog.php" target="_blank">Blog</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <form action="Blog.php" class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="Search">
                </div>
                <button class="btn btn-default" name="SearchButton">Go</button>
            </form>
        </div>
    </div>
</nav>
<div class="Line" style="height: 10px; background: #00695C"></div>
<div class="container-fluid">
    <div class="row">

        <div class="col-sm-2">
<!--            <h1>Ayush</h1>-->
            <ul id="side_menu" class="nav nav-pills nav-stacked">
                <br><br>
                <li class="active"><a href="Dashboard.php">
                        <span class="glyphicon glyphicon-th"></span>
                        &nbsp;DashBoard</a></li>
                <li><a href="AddNewPost.php">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        &nbsp;Add New Post</a> </li>
                <li><a href="Categories.php">
                        <span class="glyphicon glyphicon-tags"></span>
                        &nbsp;Categories</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-user"></span>
                        &nbsp;Manage Admin</a> </li>
                <li><a href="Comments.php">
                        <span class="glyphicon glyphicon-comment"></span>
                        &nbsp;Comments

                        <?php
                        $ConnectingDB;
                        $QueryTotal = "SELECT COUNT(*) FROM comments WHERE status = 'OFF' ";
                        $ExecuteTotal = mysql_query($QueryTotal);
                        $RowsTotal = mysql_fetch_array($ExecuteTotal);
                        $TotalTotal = array_shift($RowsTotal);
                        if($TotalTotal > 0) {
                            ?>
                            <span class="label pull-right label-warning">
                                <?php
                                echo $TotalTotal;
                                ?>
                                </span>
                        <?php } ?>


                    </a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-equalizer"></span>
                        &nbsp;Live Blog</a> </li>
                <li><a href="#">
                        <span class="glyphicon glyphicon-log-out"></span>
                        &nbsp;Logout</a> </li>
            </ul>


        </div> <!-- Ending of side srea -->
        <div class="col-sm-10">  <!--Main Area -->
            <div><?php
                echo Message();
                echo SuccessMessage();
                ?></div>
            <h1>Admin Dashboard</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Post Title</th>
                        <th>Date & Time</th>
                        <th>Auther</th>
                        <th>Category</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    <?php
                    $ConnectingDB;
                    $ViewQuery = "SELECT *FROM admin_panel ORDER BY datetime desc;";
                    $Execute = mysql_query($ViewQuery);
                    $SrNo = 0;
                    while($DataRows = mysql_fetch_array($Execute)) {
                        $Id = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $Post = $DataRows["post"];
                        $SrNo++;
                        ?>
                        <tr>
                            <td><?php echo $SrNo; ?></td>
                            <td style="color:#00695C;"><?php
                                if(strlen($Title)>20){$Title = substr($Title,0,20).'..';}
                                echo $Title;
                                ?></td>
                            <td><?php
                                if(strlen($DateTime)>15){$DateTime = substr($DateTime,0,15).'..';}
                                echo $DateTime;?></td>
                            <td><?php echo $Admin; ?></td>
                            <td><?php echo $Category; ?></td>
                            <td><img src="Upload/<?php echo $Image; ?>" width="170px" height="100px"></td>
                            <td>
                                <?php
                                $ConnectingDB;
                                $QueryApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'ON' ";
                                $ExecuteApproved = mysql_query($QueryApproved);
                                $RowsApproved = mysql_fetch_array($ExecuteApproved);
                                $TotalApproved = array_shift($RowsApproved);
                                if($TotalApproved > 0) {
                                ?>
                                <span class="label pull-right label-success">
                                <?php
                                echo $TotalApproved;
                                ?>
                                </span>
                                <?php } ?>

                                <?php
                                $ConnectingDB;
                                $QueryUnApproved = "SELECT COUNT(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'OFF' ";
                                $ExecuteUnApproved = mysql_query($QueryUnApproved);
                                $RowsUnApproved = mysql_fetch_array($ExecuteUnApproved);
                                $TotalUnApproved = array_shift($RowsUnApproved);
                                if($TotalUnApproved > 0) {
                                    ?>
                                    <span class="label pull-left label-danger">
                                <?php
                                echo $TotalUnApproved;
                                ?>
                                </span>
                                <?php } ?>



                            </td>
                            <td>
                                <a href="EditPost.php?Edit=<?php echo $Id; ?>">
                                    <span class="btn btn-warning">Edit</span>
                                </a>
                                <a href="DeletePost.php?Delete=<?php echo $Id; ?>">
                                    <span class="btn btn-danger">Delete</span>
                                </a>
                            </td>
                            <td>
                                <a href="FullPost.php?id=<?php echo $Id;?>" target="_blank">
                                    <span class="btn btn-primary"> Live Preview</span>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
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