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
    $Name = mysql_real_escape_string($_POST["Name"]);
    $Email = mysql_real_escape_string($_POST["Email"]);
    $Comment = mysql_real_escape_string($_POST["Comment"]);
    date_default_timezone_set('Asia/Kathmandu');
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
    $PostId = $_GET['id'];
    $DateTime;
    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"] = "All fields are required.";
    } elseif(strlen($Comment) > 500){
        $_SESSION["ErrorMessage"] = "Only 500 characters are allowed for comment.";
    } else {
        global $ConnectingDB;
        $Query="INSERT INTO comments (datetime,name,email,comment,status,admin_panel_id)
                VALUES ('$DateTime','$Name','$Email','$Comment','OFF','$PostId')";
        $Execute = mysql_query($Query);
        if($Execute) {
            $_SESSION["SuccessMessage"] = "Comment submitted successfuly.";
            Redirect_to("FullPost.php?id={$PostId}");
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong.";
            Redirect_to("FullPost.php?id={$PostId}");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Blog Post</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/publicstyles.css">
    <style>
        .FieldInfo {
            color: #00695C;
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-size: 1.2em;
        }
        .CommentBlog {
            background-color: #f6f7f9;
        }
        .Comment-Info {
            color: #365899;
            font-family: sans-seriff;
            font-size: 1.1em;
            font-weight: bold;
            padding-top: 10px;
        }
        .comment {
            margin-top: -2px;
            padding-bottom: 10px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div style="height: 10px; background: #4cae4c"></div>
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
                <li class="active"><a href="Blog.php">Blog</a></li>
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
    <div class="Line" style="height: 10px; background: #4cae4c"></div>
    <div class="container"><!--  COntainer   -->
        <div class="blog-header">
            <h1>The Complete Ressponsive CMS Blog </h1>
            <p>The Complete Blog by Ayush Acharya</p>
        </div>
        <div class="row"><!--Row-->
            <div class="col-sm-8 col-md-8 col-lg-8">
                <?php
                echo Message();
                echo SuccessMessage();
                ?>
                <?php
                global $connectionDB;
                if(isset($_GET['SearchButton'])) {
                    $Search = $_GET["Search"];
                    $ViewQuery = "SELECT * FROM admin_panel 
                                  WHERE datetime LIKE'%$Search%' OR 
                                  title LIKE '%$Search%' OR 
                                  category LIKE '%$Search%' OR 
                                  post LIKE '%$Search%'";
                } else {
                    $PostIdFromURL = $_GET["id"];
                    $ViewQuery = "SELECT * FROM admin_panel WHERE id = '$PostIdFromURL'
                                  ORDER BY datetime DESC";
                }
                $Execute = mysql_query($ViewQuery);
                while($DateRows = mysql_fetch_array($Execute)){
                    $PostId = $DateRows["id"];
                    $DateTime = $DateRows["datetime"];
                    $Title = $DateRows["title"];
                    $Category = $DateRows["category"];
                    $Admin = $DateRows["author"];
                    $Image = $DateRows["image"];
                    $Post = $DateRows["post"];
                ?>
                <div class="blogpost thumbnail">
                    <img class="img-responsive img-rounded" src="Upload/<?php echo $Image; ?>">
                    <div class="caption">
                        <h1 id="heading"><?php echo htmlentities($Title);?></h1>
                        <p class="description">Category:<?php echo htmlentities($Category);?>
                        Published on:<?php echo htmlentities($DateTime);?></p>
                        <p class="post">
                            <?php echo $Post; ?>
                        </p>
                    </div>
<!--                    <a href="Fu;;Post.php?id=--><?php //echo $PostId; ?><!--">-->
<!--                        <span class="btn btn-info">Read More &rsaquo;&rsaquo;</span>-->
<!--                    </a>-->
                </div>
                <?php } ?>
                <br><br><br><br>
                <span class="FieldInfo">Share your thoughts about this post.</span><br>
                <span class="FieldInfo">Comments</span>
                <?php
                $connectionDB;
                $PostIdForComment = $_GET['id'];
                $ExtractingCommentQuery = "SELECT * FROM comments WHERE admin_panel_id ='$PostIdForComment' AND status='ON'";
                $Execute = mysql_query($ExtractingCommentQuery);
                while($DataRows = mysql_fetch_array($Execute)) {
                    $CommentDate = $DataRows["datetime"];
                    $CommentName = $DataRows["name"];
                    $Comments = $DataRows["comment"];

                ?>
                <div class="CommentBlog">
                    <img style="margin-top: 10px; margin-left: 10px;" class="pull-left" src="Upload/computers.jpeg" width="70" height="70">
                    <p style="margin-left: 90px;" class="Comment-Info"><?php echo $CommentName; ?></p>
                    <p style="margin-left: 90px;" class="description"><?php echo $CommentDate; ?></p>
                    <p style="margin-left: 90px;" class="comment"><?php echo $Comments; ?></p>
                </div>
                    <hr>
                <?php } ?>
                <div>
                    <form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label for="Name"><span class="FieldInfo">Name:</span></label>
                                <input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="Email"><span class="FieldInfo">Email:</span></label>
                                <input class="form-control" type="email" name="Email" id="Email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="Commentarea"><span class="FieldInfo">Comment:</span></label>
                                <textarea class="form-control" name="Comment" id="Commentarea"></textarea>
                                <br>
                                <input class="btn btn-primary" type="Submit" name="Submit" value="Submit">
                                <br>
                        </fieldset>

                    </form>
                </div>
            </div>
            <div class="col-sm-offset-1 col-sm-3 col-md-offset-1 col-md-3 col-lg-offset-1 col-lg-3"><!--Sidebar-->
                <h2>Test</h2>
                <p>Random text here. So dont underestimate the power of the common man. life is full
                    of ups and downs and we have to face it with courage to make
                    something meaningfull out of it.</p>
            </div><!-- Sidebar Ending -->
        </div><!-- Row Ending  -->
    </div><!--  Container Ending    -->
    <div id="footer">
        <hr><p>Theme By | Ayush Acharya | &copy;2016-2020 --- All right reserved.</p>
        <a style="color:white; text-decoration: none; cursor: pointer; font-weight: bold;" href="http://ayushacharya.com" target="_blank">
            <p>
                Contact me if you want beautiful templates.
            </p>
        </a><hr>
    </div>
</body>
</html>