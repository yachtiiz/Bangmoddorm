<?php

if (isset($_GET["memberID"]) && is_numeric($_GET["memberID"])) {
    require 'connection.php';
    $memberID = $_GET["memberID"];
    $query = "select * from Members where memberID = $memberID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    
    $query1 = "select count(memberID) as All_booking from Booking where memberID = $memberID";
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_array($result1);
    
    $reject_query = "select count(memberID) as Reject_booking from Booking where memberID = $memberID and booking_status = 'Reject' ";
    $reject_result = mysqli_query($con, $reject_query);
    $reject_row = mysqli_fetch_array($reject_result);
    
    $comment_query = "select count(memberID) as All_comment from Comment where memberID = $memberID";
    $comment_result = mysqli_query($con, $comment_query);
    $comment_row = mysqli_fetch_array($comment_result);
    ?>
    
    <div class="col-md-12" style="">
        <legend><h3 style="text-align: center"><span>Member </span>Information</h3></legend>
        <img src="<?php echo $row["pic_path"] ?>" class="img-thumbnail" style="width: 40%;height: 40%;margin-left: 30%;margin-bottom: 20px"><br>
        <legend><h4 style="text-align: center;margin-bottom: 30px">Display Picture</h4></legend>

        <div class="col-lg-6 pull-left" >
            <table style=" width: 90%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Username : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["username"]; ?>
                        </td>
                    </tr>            
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>First name : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["firstName"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Last name : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["lastName"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px">
                        <td>
                            <h4><span>ID Card : </span></h4>  
                        </td>
                        <td>
                            <?php echo $row["idCard"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Email : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["email"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Telephone : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["tel"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Address No. : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["address"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>District : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["province"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>City : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["city"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Country : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["country"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Zip : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["zipcode"]; ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-6 pull-right" >   
            <table style="width: 100%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Type : </span></h4>
                        </td>
                        <?php
                        switch ($row["type"]) {
                            case "Owner":
                                $color = "#0480be";
                                break;
                            case "Member":
                                $color = "#00cc33";
                                break;
                        } ?>
                        <td style="color: <?php echo $color; ?>">
                            <?php echo $row["type"]; ?>
                        </td>
                    </tr>    
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Status : </span></h4>
                        </td>
                        <?php
                        switch ($row["status"]) {
                            case "Blacklist":
                                $color = "red";
                                break;
                            case "Normal":
                                $color = "#00cc33";
                                break;
                        } ?>
                        <td style="color: <?php echo $color; ?>">
                            <?php echo $row["status"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Register Date : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["regisDate"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Last Access : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["lastAccTime"]; ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Total Booking : </span></h4>
                        </td>
                        <td>
                            <?php echo $row1["All_booking"]; ?> Booking
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Total Reject Booking : </span></h4>
                        </td>
                        <td>
                            <?php echo $reject_row["Reject_booking"]; ?> Booking
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Total Comment : </span></h4>
                        </td>
                        <td>
                            <?php echo $comment_row["All_comment"]; ?> Comments
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="col-md-12">
            <?php if (isset($_GET["backtodorm"]) && is_numeric($_GET["backtodorm"])) { ?>
                <a href="index.php?chose_page=checkDormDetail&dormID=<?php echo $_GET["backtodorm"] ?>" class="btn1 btn1-danger" style="margin-left: 18%; margin-top: 10% ;margin-bottom: 10%; width: 30%" style="">Back</a> 
                <a href="" data-toggle="modal" data-target="#blacklist_modal" class="btn1 btn1-warning" style="margin-left: 5%;margin-top : 10% ;margin-bottom: 10%; width: 30%">Add to Blacklist</a>

                    <div class="modal fade" id="blacklist_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Add this member to Blacklist</h4>
                                </div>
                                <div class="modal-body">
                                    <h3 style="margin-top:0px">Reason</h3>
                                    <textarea id="blacklist_reason" rows="3" class="form-control" style="margin-bottom:30px"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="addBlacklist" type="button" class="btn btn-primary">Add to blacklist</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
        
                    
                



                <script>
                    $(function() {
                        $("#addBlacklist").on("click", function() {
                            if (confirm("Add this member to Blacklist ?")) {
                                reason = $("#blacklist_reason").val().replace(/ /g, "+");
                                url = "callback.php?addblacklist=<?php echo $row["memberID"] ?>&blacklist_reason=" + reason ;
                                alert(url);
                                $("#addBlacklist").load(url);
                            } else {
                                event.preventDefault();
                            }
                        });

                    });
                </script>
            <?php } else { ?>
                <a href="index.php?chose_page=checkMemberInfo" class="btn1 btn1-danger" style="margin-left: 18%; margin-top: 10% ;margin-bottom: 10%; width: 30%">Back</a>
                <?php if ($row["status"] === "Normal") { ?>
                    <a href="" data-toggle="modal" data-target="#blacklist_modal" class="btn1 btn1-warning" style="margin-left: 5%;margin-top : 10% ;margin-bottom: 10%; width: 30%">Add to Blacklist</a>

                    <div class="modal fade" id="blacklist_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Add this member to Blacklist</h4>
                                </div>
                                <div class="modal-body">
                                    <h3 style="margin-top:0px">Reason</h3>
                                    <textarea id="blacklist_reason" rows="3" class="form-control" style="margin-bottom:30px"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="addBlacklist" type="button" class="btn btn-primary">Add to blacklist</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
        
                    
                



                <script>
                    $(function() {
                        $("#addBlacklist").on("click", function() {
                            if (confirm("Add this member to Blacklist ?")) {
                                reason = $("#blacklist_reason").val().replace(/ /g, "+");
                                url = "callback.php?addblacklist=<?php echo $row["memberID"] ?>&blacklist_reason=" + reason ;
                                alert(url);
                                $("#addBlacklist").load(url);
                            } else {
                                event.preventDefault();
                            }
                        });

                    });
                </script>
            <?php } else { ?>
                <a href="" id="removeBlacklist" class="btn1 btn1-warning" style="margin-left: 5%;margin-top : 10% ;margin-bottom: 10%; width: 30%">Remove Blacklist</a>
        </div>
                <script>
                    $(function() {
                        $("#removeBlacklist").on("click", function() {
                            if (confirm("Remove blacklist ?")) {
                                $("#removeBlacklist").load("callback.php?removeblacklist=<?php echo $row["memberID"] ?>");
                            } else {
                                event.preventDefault();
                            }
                        });

                    });
                </script>
                <?php
            }
        }
        ?>

    <?php } ?>
</div>
</div>
    </div>
<!-- /container -->
