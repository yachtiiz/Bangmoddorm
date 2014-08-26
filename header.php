<?php session_start(); ?>
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
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" />
        <link rel="stylesheet" href="css/hotel.css" type="text/css" />
        <link rel="stylesheet" href="css/hotel-responsive.css" type="text/css" />
        <link rel="stylesheet" href="js/slider/default.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/socialcount-with-icons.css" type="text/css" media="screen" />



    </head>
    <title>Bangmod Dormitory</title>
    <body>

        <div class="container-fluid">
            <div class="row"><!-- start header -->
                <div class="span4 logo">
                    <a href="index.php">
                        <div class="row">
                            <div class="span3 logo">
                                <h1>Bangmod<span>Dormitory</span></h1>
                                <p>&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                            </div>
                        </div>
                    </a>
                </div>		
                <div class="span7">
                    <div class="navbar">
                        <div class="container">
                            <div class="nav-collapse">
                                <ul class="nav nav-pills">
                                    <li class=""><a href="index.php">Home</a></li>
                                    <li class=""><a href="dormitory.php">Dormitory</a></li>
                                    <li class=""><a href="ownersystem.php">Owner</a></li>
                                    <li class=""><a href="register.php">Register</a></li>
                                    <li class=""><a href="advanceSearch.php">Advance Search</a></li>
                                    <li class=""><a href="membersystem.php">Member System</a></li>
                                    <li class=""><a href="adminsystem.php">Admin System</a></li>
                            </div>                
                            <!-- /.nav-collapse -->                
                        </div>            
                    </div><!-- /navbar -->       
                </div>
            </div>

            <div id="showValue" class="row" style="margin-bottom:-10px">

                <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true) { ?>
                    <div class="span7">
                        <h3><span>Welcome <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> &nbsp;&nbsp; <button id="logout_button" type="button" class="btn btn-default">Logout</button></span></h3>
                    </div>                
                <?php } else { ?>
                    <form id="signin_form" action="callback.php" method="post">
                        <div class="span2">
                            <input id="username" type="text" class="form-control" placeholder="username" required>
                        </div>
                        <div class="span2">
                            <input id="password" type="password" class="form-control" placeholder="password" required>
                        </div>
                        <div id="showSubmit" style="color: red" class="span5">
                            <button id="submit" type="submit" class="btn btn-default">Login</button>
                        </div>

                    </form>                
                <?php } ?>



            </div>
            <script>
                $(function() {
                    $("#signin_form").submit(function() {
                        /* Input Data for Login with AJAX */
                        entered_login = $("#username").val();
                        entered_password = $("#password").val();
                        if (false) {

                        } else {
                            $("#submit").append('<img style="height:20px" src="images/loading.gif" />');
                            fnn = "auth";
                            //*****************Asyncronize JQuery AJAX*****************
                            var timer = setTimeout(function() {
                                clearTimeout(timer);
                                $.post("callback.php", {fn: fnn, login: entered_login, password: entered_password},
                                function(data) {
                                    if (data.length === 2) {
                                        $("#showSubmit").html('<button id="submit" type="submit" class="btn btn-default">Login</button> &nbsp;&nbsp; Login Failed Please Login Again');
                                    } else {
                                        $("#showValue").html("<div class='span7'><h3><span>Welcome " + data + " &nbsp;&nbsp; <button id='logout_button' type='button' class='btn btn-default'>Logout</button></span></h3>");
                                    }
                                });
                            }, 1000);
                        }
                        return false;
                    });
                });

                $(document).on("click", "#logout_button", function() {
                    $("#logout_button").append('<img style="height:20px" src="images/loading.gif" />');
                    var timer = setTimeout(function() {
                        clearTimeout(timer);
                        $("#logout_button").load("callback.php?logout");
                    }, 500);


                });


            </script>
            <hr style="color:red">