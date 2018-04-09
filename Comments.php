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
                <li><a href="Dashboard.php">
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
                <li class="active"><a href="Comments.php">
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
        <div class="col-sm-10">  <!--Main Area -->
            <div><?php
                echo Message();
                echo SuccessMessage();
                ?></div>
            <h1>Un-Approved Comments</h1>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Approve</th>
                    <th>Delete</th>
                    <th>Details</th>
                </tr>
                <?php
                $connectingDB;
                $Query = "SELECT *FROM comments WHERE status='OFF' ORDER BY datetime DESC ";
                $Execute = mysql_query($Query);
                $SrNo = 0;
                while($DataRows=mysql_fetch_array($Execute)) {
                    $CommentId = $DataRows['id'];
                    $CommentDate = $DataRows['datetime'];
                    $CommentatorName = $DataRows['name'];
                    $Comment = $DataRows['comment'];
                    $CommentPostId = $DataRows['admin_panel_id'];
                    $SrNo++;
                    if(strlen($Comment) > 20) { $Comment = substr($Comment,0,20).'...';}
                    if(strlen($CommentatorName) > 10) { $CommentatorName = substr($CommentatorName,0,10).'...';}

                ?>
                <tr>
                    <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($CommentatorName); ?></td>
                    <td><?php echo htmlentities($CommentDate); ?></td>
                    <td><?php echo htmlentities($Comment); ?></td>
                    <td><a href="ApproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approve</span></a></td>
                    <td><a href="DeleteComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                    <td><a href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
            <h1>Approved Comments</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Comment</th>
                        <th>Approved By</th>
                        <th>Approve</th>
                        <th>Delete</th>
                        <th>Details</th>
                    </tr>
                    <?php
                    $connectingDB;
                    $Admin = "Ayush Acharya";
                    $Query = "SELECT *FROM comments WHERE status='ON' ORDER BY datetime DESC ";
                    $Execute = mysql_query($Query);
                    $SrNo = 0;
                    while($DataRows=mysql_fetch_array($Execute)) {
                        $CommentId = $DataRows['id'];
                        $CommentDate = $DataRows['datetime'];
                        $CommentatorName = $DataRows['name'];
                        $Comment = $DataRows['comment'];
                        $CommentPostId = $DataRows['admin_panel_id'];
                        $SrNo++;
                        if(strlen($Comment) > 20) { $Comment = substr($Comment,0,20).'...';}
                        if(strlen($CommentatorName) > 10) { $CommentatorName = substr($CommentatorName,0,10).'...';}

                        ?>
                        <tr>
                            <td><?php echo htmlentities($SrNo); ?></td>
                            <td><?php echo htmlentities($CommentatorName); ?></td>
                            <td><?php echo htmlentities($CommentDate); ?></td>
                            <td><?php echo htmlentities($Comment); ?></td>
                            <td><?php echo htmlentities($Admin); ?></td>
                            <td><a href="DisapproveComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Disapprove</span></a></td>
                            <td><a href="DeleteComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                            <td><a href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
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