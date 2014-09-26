<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

function getUserType() {
    require 'connection.php';
    $memberid = $_SESSION["memberID"];
    $gettype = "select type from members where memberID = $memberid";
    $result = mysqli_query($con, $gettype);
    $row = mysqli_fetch_array($result);
    return $row;
}
?>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- JS -->
        <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.roundabout.js"></script>
        <script type="text/javascript" src="js/jquery.easing.js"></script>
        <script type="text/javascript" src="js/jquery.nivo.slider.js"></script>
        <script type="text/javascript" src="js/socialcount.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
        <script type="text/javascript" src="js/form_register_validate.js"></script>
        <script src="js/jquery.quicksand.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/global.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" />
        <link rel="stylesheet" href="css/hotel.css" type="text/css" />
        <link rel="stylesheet" href="css/hotel-responsive.css" type="text/css" />
        <link rel="stylesheet" href="js/slider/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/socialcount-with-icons.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/flat/flaticon.css" type="text/css" media="screen" />



    </head>
    <title>Bangmod Dormitory</title>
    <body style="padding-top:0px">

<!--        <div class="row" style="padding: 0px;height:90px"> 
            <div class="span12 logo" >

                <div class="row" style="margin-left:50%">
                    <a href="index.php">
                        <div class="span3 logo">
                            <h1>Bangmod<span>Dormitory</span></h1>
                            <p>&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>-->
        <hr style="margin-top:2px;margin-bottom: 0px;border:solid 1px #cccccc">
        <div class="row" style="margin-bottom: -20px">
            <div class="navbar">
                <div class="container">
                    <div class="nav-collapse">
                        <ul class="nav nav-pills" style="padding-left: 150px;padding-right:150px;width:100%;height: 10%">
                            <li><a href="index.php"><h5 >Home</h5></a></li>
                            <li><a href="index.php?chose_page=dormitory"><h5 >Dormitory</h5></a></li>
                            <!--<li class=""><a href="index.php?chose_page=ownersystem"><h5 >Owner</h5></a></li>-->
                            <?php //if(isset($_SESSION["auth"]) && $_SESSION["auth"] === false){     ?>
                            <?php if(!isset($_SESSION["auth"])) { ?><li class=""><a href="index.php?chose_page=register"><h5 >Register</h5></a></li> <?php } ?>
                            <?php //}     ?>
                            <li class=""><a href="index.php?chose_page=advancesearch"><h5 >Advance Search</h5></a></li>
                            <?php //if(isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Member"){     ?>
                            <!--<li class=""><a href="index.php?chose_page=membersystem"><h5 >Member System</h5></a></li>-->
                            <?php //}    ?>
                            <?php //if(isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Admin"){  ?>
                            <li class=""><a href="index.php?chose_page=adminsystem"><h5 >Admin System</h5></a></li>
                            <?php //}    ?>
                            <!--                                    <li class=""><button id="update_booking" class="btn btn-primary">UpdateBooking</button></li>-->
                            <li class="pull-right">
                                <?php
                                if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) {
                                    $row = getUserType();
                                    if ($row["type"] === "Member") {

                                        function getNotification() {
                                            require 'connection.php';
                                            $memberID = $_SESSION["memberID"];
                                            $query = "select * from booking where memberID = $memberID and member_noti = 1";
                                            $result = mysqli_query($con, $query);
                                            $noti = mysqli_num_rows($result);
                                            return $noti;
                                        }
                                        ?>

                                        <div class="dropdown dropdownuser">
                                            <h5 style="margin-top:14px;color:#b81007;cursor: pointer" id="dropdownMenu1" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style="margin-right: 0px"></span><?php if (getNotification() > 0) { ?><span class="glyphicon glyphicon-exclamation-sign" ></span><?php } ?> <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?> <span class="caret" style="color:#b81007;border-top: 4px solid #b81007"></span></h5>
                                            <ul style="width: 200px;" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li><h5>Member</h5></li>
                                                <li role="presentation" class="divider" style="border-bottom: solid 1px #cccccc"></li>
                                                <li><a href="index.php?chose_page=membernotification">Notification <span class="badge pull-right" style="background-color: #990000;padding-top:3px;padding-bottom: 3px"><?php echo getNotification() ?></span></a></li>
                                                <li role="presentation"><a href="index.php?chose_page=myprofile">My Profile</a></li>
                                                <li role="presentation"><a href="index.php?chose_page=checkBookingHis">Check Booking History</a></li>
                                                <li role="presentation" style="margin-bottom: 10px;cursor: pointer"><a id="logout_button">Sign out </a></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($row["type"] === "Owner") {

                                        function getOwnerNotification() {
                                            require 'connection.php';
                                            $memberID = $_SESSION["memberID"];
                                            $query = "select * from booking b join rooms r join members m join Dormitories d where r.dormID = d.dormID and b.memberID = m.memberID and b.roomID=r.roomID and d.memberID = $memberID and owner_noti = 1";
                                            $result = mysqli_query($con, $query);
                                            $noti = mysqli_num_rows($result);
                                            return $noti;
                                        }
                                        ?>

                                        <div class="dropdown dropdownuser">
                                            <h5 style="margin-top:14px;color:#b81007;cursor: pointer" id="dropdownMenu1" data-toggle="dropdown"><span class="glyphicon glyphicon-user" style="margin-right: 0px"></span><?php if (getOwnerNotification() > 0) { ?><span class="glyphicon glyphicon-exclamation-sign" ></span> <?php } ?> <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"] ?> <span class="caret" style="color:#b81007;border-top: 4px solid #b81007"></span></h5>
                                            <ul style="width: 200px;" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                                <li><h5>Owner</h5></li>
                                                <li role="presentation" class="divider" style="border-bottom: solid 1px #cccccc"></li>
                                                <li><a href="index.php?chose_page=ownernotification">Notification <span class="badge pull-right" style="background-color: #990000;padding-top:3px;padding-bottom: 3px"><?php echo getOwnerNotification() ?></span></a></li>
                                                <li role="presentation"><a href="index.php?chose_page=myprofile">My Profile</a></li>
                                                <li role="presentation"><a href="index.php?chose_page=checkDormBooking">Check All Booking</a></li>
                                                <li role="presentation" class="divider" style="border-bottom: solid 1px #cccccc"></li>
                                                <li role="presentation"><a href="index.php?chose_page=adddormitory">Add Dormitory</a></li>
                                                <li role="presentation"><a href="index.php?chose_page=ownersystem">Edit Your Dormitory</a></li>
                                                <li role="presentation" style="margin-bottom: 10px;cursor: pointer"><a id="logout_button">Sign out </a></li>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="" style="margin-left:50px" data-toggle="modal" data-target="#LoginModal"><h5 style="color:#b81007"> Sign In </h5></a>
                                    <div class="modal fade" id="LoginModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="height: 50px">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="signin_form" action="callback.php" method="post">
                                                        <h4 style="text-align:center"><span>Sign In</span></h4>
                                                        <div class="input-group" style="width: 70%;margin-left: auto;margin-right: auto;margin-bottom: 10px;margin-top:30px">
                                                            <span class="input-group-addon">Username</span>
                                                            <input id="username" name="username" type="text" class="form-control" required>
                                                        </div>
                                                        <div class="input-group" style="width: 70%;margin-left: auto;margin-right: auto;margin-bottom: 5px">
                                                            <span class="input-group-addon">Password</span>
                                                            <input id="password" name="password" type="password" class="form-control" required>
                                                        </div>
                                                        <div id="show_error" style="text-align:center;margin-bottom: 10px">

                                                        </div>
                                                        <button id="submit" type="submit" style='width:20%;margin-left:25px; margin-top: 40px'class="btn1 btn1-success">Sign In</button>
                                                        <a href="index.php?chose_page=register"><button type="button" style='width:20%;margin-left:20px; margin-top: 40px' class="btn1 btn1-warning">Register</button></a>
                                                        <br>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
<?php } ?>
                            </li>
                        </ul>
                    </div>                
                    <!-- /.nav-collapse -->                
                </div>            
            </div><!-- /navbar -->       
        </div>
        <hr style="margin: 0px;margin-bottom: 20px;border:solid 1px #cccccc">
        <div class="container-fluid">
            <script>
                $(function() {
                    $("#signin_form").submit(function() {
                        /* Input Data for Login with AJAX */
                        entered_login = $("#username").val();
                        entered_password = $("#password").val();
                        if (false) {

                        } else {
                            $("#show_error").append('<img style="height:20px" src="images/loading.gif" />');
                            fnn = "auth";
                            //*****************Asyncronize JQuery AJAX*****************
                            var timer = setTimeout(function() {
                                clearTimeout(timer);
                                $.post("callback.php", {fn: fnn, login: entered_login, password: entered_password},
                                function(data) {
                                    if (data.length === 2) {
                                        $("#show_error").html('<p style="color:red">Sign in Failed !</p>');
                                    } else {
                                        $("#show_error").html("<p style='color:green'>Sign in success !</p>");
                                        var timer = setTimeout(function() {
                                            clearTimeout(timer);
                                            window.location = "index.php";
                                        }, 1000);
                                    }
                                });
                            }, 1000);
                        }
                        return false;
                    });
                });

                $(document).on("click", "#logout_button", function() {
                    $("#logout_button").append('<img class="pull-right" style="height:20px" src="images/loading.gif" />');
                    var timer = setTimeout(function() {
                        clearTimeout(timer);
                        $("#logout_button").load("callback.php?logout");
                    }, 500);
                });

                $(document).on("click", "#update_booking", function() {
                    $("#update_booking").load("callback.php?updateBooking=1");
                });



            </script>
