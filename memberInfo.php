<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal">
                    <fieldset>
                        <br />
                        <div class="row">
                            <?php
                            if (isset($_GET["memberID"]) && is_numeric($_GET["memberID"])) {
                                require 'connection.php';
                                $memberID = $_GET["memberID"];
                                $query = "select * from members where memberID = $memberID";

                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_array($result);
                                ?>
                                <div class="col-md-10" style="margin-left: 70px">
                                    <legend style="text-align: center"><span>Member </span>Information</legend>
                                    <img src="<?php echo $row["pic_path"] ?>" class="img-thumbnail" style="width: 40%;height: 40%;margin-left: 30%;margin-bottom: 20px"><br>
                                    <legend><h4 style="margin-left:36%;margin-bottom: 30px">Display Picture</h4></legend>
                                </div>
                                <div class="col-md-4" style="margin-left:70px">
                                    <h4>Username <span class="pull-right">:</span></h4>
                                    <h4>First name <span class="pull-right">: </span> </h4>
                                    <h4>Last name <span class="pull-right">: </span> </h4>
                                    <h4 style="margin-top: 10px">Identify Card Number <span class="pull-right">: </span> </h4>
                                    <h4 style="margin-top: 15px">Email <span class="pull-right">: </span> </h4>
                                    <h4 style="margin-top: 15px">Telephone <span class="pull-right">: </span> </h4>
                                    <h4>Type <span class="pull-right">: </span> </h4>
                                    <h4>Address <span class="pull-right">: </span> </h4>
                                    <h4>City <span class="pull-right">: </span> </h4>
                                    <h4>Province <span class="pull-right">: </span> </h4>
                                    <h4>Zip Code <span class="pull-right">: </span> </h4>
                                    <h4>Country <span class="pull-right">: </span> </h4>
                                    <h4 style="margin-top: 10px">Register Date <span class="pull-right">: </span> </h4>
                                    <h4>Last Access Time <span class="pull-right">: </span> </h4>
                                    <h4>Status <span class="pull-right">: </span> </h4>
                                    <h4>Member URL <span class="pull-right">: </span> </h4>
                                    <h4>Display Name <span class="pull-right">: </span> </h4>
                                    <h4 style="margin-top: 15px">Facebook <span class="pull-right">: </span> </h4>
                                    <h4>About <span class="pull-right">: </span> </h4>
                                </div>
                                <div class="col-md-6" style="margin-left:0px">

                                    <h4><span class="pull-right"><?php echo $row["username"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["firstName"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["lastName"]; ?></span></h4><br><br>
                                    <h4><span class="pull-right"><?php echo $row["idCard"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["email"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["tel"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["type"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["address"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["city"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["province"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["zipcode"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["country"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["lastAccTime"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["regisDate"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["status"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["memberUrl"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["displayName"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["facebook"]; ?></span></h4><br>
                                    <h4><span class="pull-right"><?php echo $row["about"]; ?></span></h4><br>
                                <?php } ?>
                            </div>
                        </div>
                        <br><br><br>
                        <?php if (isset($_GET["backtodorm"]) && is_numeric($_GET["backtodorm"])) { ?>
                            <a href="index.php?chose_page=checkDormDetail&dormID=<?php echo $_GET["backtodorm"] ?>" class="btn btn-primary btn-large book-now" style="margin-left: 38%">Back</a>                                
                        <?php } else { ?>
                            <a href="index.php?chose_page=checkMemberInfo" class="btn btn-primary btn-large book-now" style="margin-left: 38%">Back</a>                                
                        <?php } ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</div></div> <!-- /container -->
<br><br><br><br><br><br><br>
