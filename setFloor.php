<table class="table table-condensed">
            <thead>
            <h1><span>Type </span>Of Rooms</h1>
            </thead>
            <?php while ($dorm_room_row = mysqli_fetch_array($dorm_room_result)) { ?>
                <tr>
                    <td><img style="width: 410px;height: 300px" src="images/room_pictures/<?php echo $dorm_room_row["main_pic"]; ?>" class="img-thumbnail"/></td>
                    <td class="span5">
                        <table>
                            <thead>
                            <th style="text-align:center">
                            <h3> <?php echo $dorm_room_row["roomType"] ?></h3>
                            </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Areas : 
                                    </td>
                                    <td>
                                        <?php echo $dorm_room_row["areas"]; ?> SQ.M.    
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Price :  
                                    </td>
                                    <td>
                                        <?php echo $dorm_room_row["price"]; ?> BAHT/MONTH 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Number of Rooms : 
                                    </td>
                                    <td>
                                        <?php echo $dorm_room_row["numOfRoom"]; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="color: green">Room Available : </span>
                                    </td>
                                    <td>
                                        <span style="color: green"><?php echo $dorm_room_row["roomAvailable"] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>

                        </table>

                        <br>
                        <!-- Button trigger modal -->
                        <button class="btn1 btn1-primary" data-toggle="modal" data-target="#room<?php echo $dorm_room_row["roomID"]; ?>" style="margin-left: -10px; margin-top: 40px; width: 40% ">
                            Detail
                        </button>
                        <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Member" && $_SESSION["status"] !== "Blacklist") { ?>
                            <button id="booking<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="margin-left: 30px; margin-top: 40px; width: 40% ">Booking</button>
                            <script>
                                $(document).on("click", "#booking<?php echo $dorm_room_row["roomID"] ?>", function() {
                                    event.preventDefault;
                                    $("#booking<?php echo $dorm_room_row["roomID"] ?>").load("callback.php?memberID=<?php echo $_SESSION["memberID"]; ?>&dormID=<?php echo $dorm_row["dormID"]; ?>&roomID=<?php echo $dorm_room_row["roomID"]; ?>");
                                });
                            </script>
                        <?php } else if($_SESSION["auth"] && $_SESSION["auth"] === true && $_SESSION["type"] === "Owner") { ?>
                            <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="margin-left: 30px; margin-top: 40px; width: 40% ">Booking</button>
                            <script>

                                $(function() {

                                    $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                        alert("Only Member can be booking.");
                                    });



                                });

                            </script>
                        <?php } else if($_SESSION["auth"] && $_SESSION["auth"] === true && $_SESSION["status"] === "Blacklist") { ?>
                            <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="margin-left: 30px; margin-top: 40px; width: 40% ">Booking</button>
                            <script>

                                $(function() {

                                    $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                        alert("Cannot booking. You are Blacklist.");
                                    });



                                });

                            </script>
                        <?php } else { ?>
                            <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="margin-left: 30px; margin-top: 40px; width: 40% ">Booking</button>
                            <script>

                                $(function() {

                                    $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                        alert("Please sign in before booking.");
                                    });



                                });

                            </script>
                        <?php } ?>
                        <br><br>
                        <br><br>



                        <!-- Modal -->
                        <div class="modal fade" id="room<?php echo $dorm_room_row["roomID"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $dorm_room_row["roomType"] ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="span12">
                                                <img class="img-thumbnail" style="margin-left: 50px;width: 80%" src="images/room_pictures/<?php echo $dorm_room_row["main_pic"]; ?>"/>
                                            </div>
                                            <?php
                                            $room_id = $dorm_room_row["roomID"];
                                            $room_pic_query = "select * from RoomPic where roomID = $room_id";
                                            $room_pic_result = mysqli_query($con, $room_pic_query);
                                            while ($room_pic_row = mysqli_fetch_array($room_pic_result)) {
                                                ?>
                                                <div class="span5">
                                                    <br><br>
                                                    <img class="img-thumbnail" style="width:350px;height: 250px;margin-left: 50px"src="images/room_pictures/<?php echo $room_pic_row["roomPicPath"] ?>"/>
                                                </div>
                                            <?php } ?>

                                            <div style="margin-left: 70px;margin-top:30px" class="span10">

                                                <?php
                                                $fac_room = "select * from FacilitiesInRoom where roomID = $room_id";
                                                $fac_room_result = mysqli_query($con, $fac_room);
                                                $fac_room_row = mysqli_fetch_array($fac_room_result);
                                                ?>
                                                <h3><span>Facilities</span> in room</h3>
                                                <div class="col-md-12" style="padding-left:0px">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["air"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Air Condition</h4>
                                                            </td>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["wardrobe"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Wardrobe</h4> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["refrigerator"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Refrigerator</h4>
                                                            </td>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["table_fac"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Table</h4> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["chair"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Chair</h4>
                                                            </td>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["fan"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Fan</h4> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["waterHeater"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Water Heater</h4>
                                                            </td>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["bed"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Bed</h4> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["mattress"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Mattress</h4>
                                                            </td>
                                                            <td>
                                                                <h4 style="text-align:left"> <?php echo $fac_room_row["television"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Television</h4> 
                                                            </td>
                                                        </tr>


                                                    </table>
                                                </div>
                                                <div class="col-md-6" style="padding-left:0px;margin-top:30px">
                                                    <div class="pull-left strong">Areas of room : <?php echo $dorm_room_row["areas"] ?> SQM.</div>
                                                </div>
                                                <div class="col-md-6" style="padding-left:0px;margin-top:30px">
                                                    <div class="pull-left strong" style="color:green">Number Room Available : <?php echo $dorm_room_row["roomAvailable"]; ?></div>
                                                </div>
                                                <div class="pull-right"><h3>Price <?php echo $dorm_room_row["price"] ?> Baht/Month</h3></div>





                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn1 btn1-danger" data-dismiss="modal" style="width:30%">Close</button>
                                            <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Member" && $_SESSION["status"] !== "Blacklist" ) { ?>
                                                <button id="modal_booking<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width:30%">Booking</button>                                            
                                                <script>
                                                    $(document).on("click", "#modal_booking<?php echo $dorm_room_row["roomID"] ?>", function() {
                                                        $("#modal_booking<?php echo $dorm_room_row["roomID"] ?>").load("callback.php?memberID=<?php echo $_SESSION["memberID"]; ?>&dormID=<?php echo $dorm_row["dormID"]; ?>&roomID=<?php echo $dorm_room_row["roomID"]; ?>");
                                                    });
                                                </script>
                                            <?php } else if(isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Owner") { ?>
                                                <button id="modal_booking<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 30% ">Booking</button>
                                                <script>

                                                    $(function() {

                                                        $("#modal_booking<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                            alert("Only Member can be booking.");
                                                        });
                                                    });

                                                </script>
                                            <?php } else if(isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["status"] == "Blacklist") { ?>
                                                <button id="modal_booking<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 30% ">Booking</button>
                                                <script>

                                                    $(function() {

                                                        $("#modal_booking<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                            alert("Cannot Booking. You are Blacklist");
                                                        });
                                                    });

                                                </script>
                                                
                                            <?php } else { ?>
                                                <button id="modal_booking<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 30% ">Booking</button>
                                                <script>

                                                    $(function() {

                                                        $("#modal_booking<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                            alert("Please Sign in before booking.");
                                                        });
                                                    });

                                                </script>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </td>
                </tr>
            <?php } ?>

        </table>