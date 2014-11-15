
<?php

function checkBooking($memberID) {

    require 'connection.php';

    $query = "select * from Booking where memberID = $memberID and  (booking_status = 'Waiting' or booking_status = 'Checking')";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL) {
        return 'Already Booking (Booking ID = ' . $row["bookingID"] . ')';
    } else {
        return 'PASS';
    }
}

function get_room_per_floor($roomID, $dormID) {

    require 'connection.php';

    $query = "select * from Floor f join RoomPerFloor rpf join Rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID and rpf.roomID = $roomID";

    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $color = $row["roomPerFloor"] > 0 ? "green" : "red";
        $roomAvailable = $row["roomPerFloor"] > 0 ? "Available" : "Not Available";
        $disabled = $row["roomPerFloor"] > 0 ? "required" : "disabled";
        echo '<tr>';
        echo '<td><input type="radio" name="matchingID" value="' . $row["matchingID"] . '" ' . $disabled . '></td>';
        echo '<td>';
        echo 'Floor ' . $row["floorNo"];
        echo '</td>';
        echo '<td style="color:' . $color . '">';
        echo $roomAvailable;
        echo '</td>';
        echo '</tr>';
    }
}

function show_all_room($dormID) {
    require 'connection.php';

    $room_query = "select * from Floor f join RoomPerFloor rpf join Rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID and r.status = 'Complete' group by rpf.roomID";
    $result = mysqli_query($con, $room_query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<a href="#' . $row["roomID"] . '"><button class="btn1 btn1-default" style="margin-right:1%">' . $row["roomType"] . '</button></a> ';
    }
}

if (isset($_GET["dormID"]) && is_numeric($_GET["dormID"])) {

    require 'connection.php';

    $dormID = $_GET["dormID"];

    $dorm_query = "select * from Dormitories where dormID = $dormID";
    $dorm_result = mysqli_query($con, $dorm_query);
    $dorm_row = mysqli_fetch_array($dorm_result);

    $fac_dorm_query = "select * from FacilitiesInDorm where dormID = $dormID";
    $fac_dorm_result = mysqli_query($con, $fac_dorm_query);
    $fac_dorm_row = mysqli_fetch_array($fac_dorm_result);

    $pic_dorm_query = "select * from DormPic where dormID = $dormID";
    $pic_dorm_result = mysqli_query($con, $pic_dorm_query);

    $dorm_room_query = "select * from Floor f join RoomPerFloor rpf join Rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID and r.status = 'Complete' group by rpf.roomID";
    $dorm_room_result = mysqli_query($con, $dorm_room_query);
    ?>


    <div class="row">
        <div class="span12">	
            <br /><br />
            <legend><h1><?php echo $dorm_row["dormName"] ?> </h1></legend>
            <br>
            <div class="row">
                <div class="span12">
                    <img  class="img-thumbnail" style="width:100%;max-height:100%" src="images/dormitory_picture/<?php echo $dorm_row["dorm_pictures"]; ?>" alt=""/><br><br>
                    <legend><h1><span>Dormitory </span> Picture </h1></legend>
                </div>
                <?php while ($dorm_pic_row = mysqli_fetch_array($pic_dorm_result)) { ?>
                    <div class="span3">
                        <img style="width: 100%;max-height: 150px;margin-top: 10%"class="img-thumbnail" src="images/dormitory_picture/<?php echo $dorm_pic_row["dormPicPath"] ?>" alt=""  onmouseover="showtrail('images/dormitory_picture/<?php echo $dorm_pic_row["dormPicPath"] ?>', '',670,500)" onmouseout="hidetrail()"/>
                    </div>		
                <?php } ?>
                <div class="span12">
                    <br>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <br><br>

    <div class="span12" style="margin-left:0%">
        <legend><h1><span>Dormitory </span>Information</h1></legend>
        <div class="span6 pull-left" >
            <table style=" width: 90%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Type : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["type"] ?>
                        </td>
                    </tr>            
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Distance From University : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["disFromUni"] ?> KM.
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Contract length : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["contractLength"] ?> Months
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px">
                        <td>
                            <h4><span>Address No : </span></h4>  
                        </td>
                        <td>
                            <?php echo $dorm_row["addressNo"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Soi : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["soi"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px">
                        <td>
                            <h4><span>Road : </span></h4> 
                        </td>
                        <td>
                            <?php echo $dorm_row["road"] ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="span5 pull-right" >   
            <table style="width: 100%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Sub District : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["subDistinct"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>District : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["dorm_distinct"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>City : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["province"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Zipcode : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["zip"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Email : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["email"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Telephone : </span></h4>
                        </td>
                        <td>
                            <?php echo $dorm_row["tel"] ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br><br><br>
        </div>
    </div>

    <div class="span12" style="margin-left:0%">
        <legend><h1><span>Dormitory</span> Facilities &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Rate &nbsp;<span style="color: gold">
                    <?php
                    for ($i = 1; $i <= $dorm_row["dormitory_rate"]; $i++) {
                        echo '&#9733;';
                    } for ($i = $dorm_row["dormitory_rate"]; $i < 5; $i++) {
                        echo '&#9734;';
                    }
                    ?></span></h1></legend>
        <br>
        <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
            <tr style="">
                <td>
                    <h4 style="margin-left:10%"><span style="color:green" class="glyphicon glyphicon-ok-circle"></span>&nbsp; Water Price <small>&nbsp;&nbsp; <?php echo $dorm_row["water_price"] ?> Baht per unit</small></h4>

                </td>
                <td>
                    <h4 style="margin-left:10%"><span style="color:green" class="glyphicon glyphicon-ok-circle"></span>&nbsp; Electrical Charge <small>&nbsp;&nbsp; <?php echo $dorm_row["elec_price"] ?> Baht per unit</small></h4> 
                </td>
            </tr>
            <tr style="">
                <td>
                    <h4 style="margin-left:10%"><?php echo $fac_dorm_row["wifi"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WIFI &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["wifiDetails"] ?></small> </h4>

                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["lan"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAN &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["lanDetails"] ?></small></h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["airCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; AIR CLEAN SERVICE &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["airCleanDetails"] ?></small> </h4>
                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["roomCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ROOM CLEAN SERVICE &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["roomCleanDetails"] ?></small> </h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["washingService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WASHING SERVICE &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["washingDetails"] ?></small></h4>
                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["busService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; BUS SERVICE &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["busDetails"] ?></small></h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["fitness"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; FITNESS &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["fitnessDetails"] ?></small></h4>

                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["pool"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; POOL &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["poolDetails"] ?></small></h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["restaurant"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; RESTAURANT &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["restaurantDetails"] ?></small></h4>
                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["vendingMachine"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; VENDING MACHINE &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["vendingDetails"] ?></small></h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["laundry"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAUNDRY &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["laundryDetails"] ?></small></h4>
                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["elevator"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ELEVATOR &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["elevatorDetails"] ?></small></h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style="margin-left:10%;"> <?php echo $fac_dorm_row["cctv"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; CCTV &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["cctvDetails"] ?></small></h4>
                </td>
                <td>
                    <h4 style="margin-left:10%"> <?php echo $fac_dorm_row["parking"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; PARKING &nbsp;&nbsp;<small> <?php echo $fac_dorm_row["parkingDetails"] ?></small></h4>
                </td>

            </tr>
        </table>
        <br>
    </div>
    
    
    <div style="display: none; position: absolute; z-index: 110; left: 400px; top: 100px; width: 15px; height: 15px" id="preview_div"></div>


    <?php if ($dorm_row["dorm_plan_pictures"] !== NULL) { ?>
        <div class="span12" style="margin-left:0%">
            <legend><h1><span>Dormitory</span> Plan Picture</h1></legend>
            <img class="img-thumbnail" style="width:100%;max-height: 80%" src="images/dormitory_picture/<?php echo $dorm_row["dorm_plan_pictures"]; ?>" alt=""/><br><br>
        </div>
    <?php } ?>

    <div class="span12" style="margin-left:0%;">
        <legend><h1><span>Type </span>Of Rooms</h1></legend>
        <?php show_all_room($dormID) ?>

        <br><br>
        <?php while ($dorm_room_row = mysqli_fetch_array($dorm_room_result)) { ?>
            <div class="col-md-12" id="<?php echo $dorm_room_row["roomID"] ?>" style="border:solid 1px #cccccc;margin-bottom: 5%">
                <legend><h3 style="text-align: center"><span><?php echo $dorm_room_row["roomType"] ?> Room</span></h3></legend>
                <div class="span5">
                    <img style="width: 100%;max-height: 45%" src="images/room_pictures/<?php echo $dorm_room_row["main_pic"]; ?>" class="img-thumbnail" onmouseover="showtrail('images/room_pictures/<?php echo $dorm_room_row["main_pic"]; ?>', '',670,500)" onmouseout="hidetrail()"/>
                </div>


                <div class="span6">

                    <?php
                    $room_id = $dorm_room_row["roomID"];
                    $room_pic_query = "select * from RoomPic where roomID = $room_id";
                    $room_pic_result = mysqli_query($con, $room_pic_query);
                    while ($room_pic_row = mysqli_fetch_array($room_pic_result)) {
                        ?>
                        <div class="col-md-4">
                            <img class="img-thumbnail" style="width:100%;max-height: 100%;margin-bottom:10%"src="images/room_pictures/<?php echo $room_pic_row["roomPicPath"] ?>" onmouseover="showtrail('images/room_pictures/<?php echo $room_pic_row["roomPicPath"] ?>', '',670,500)" onmouseout="hidetrail()"/>
                        </div>
                    <?php } ?>
                </div>


                <div class="col-md-12">
                    <?php
                    $fac_room = "select * from FacilitiesInRoom where roomID = $room_id";
                    $fac_room_result = mysqli_query($con, $fac_room);
                    $fac_room_row = mysqli_fetch_array($fac_room_result);
                    ?>
                    <h3 ><span>Facilities</span> in room</h3>
                    <div class="col-md-12" style="padding-left:0%">
                        <table class="table table-striped table-hover" style="border:solid 1px #cccccc" >
                            <tr>
                                <td>
                                    <h4 style="text-align:left"> <?php echo $fac_room_row["air"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Air Condition</h4>
                                </td>
                                <td>
                                    <h4 style="text-align:left"> <?php echo $fac_room_row["wardrobe"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; Wardrobe</h4> 
                                </td>
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
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:3%">
                    <h3 style="margin-top:0%"><span>Room </span>Information</h3>
                    <div class="col-md-10" style="border:solid 1px #cccccc;width:100%;height: 20%;padding:2%">
                        <p style="font-size: larger"><?php echo nl2br($dorm_room_row["roomDetail"]) ?></p>
                    </div>

                </div>
                <div class="col-md-6">

                    <h3 style="margin-top:0%"><span>Room </span>Detail</h3>
                    <table class="table table-striped table-hover" style="border:solid 1px #cccccc">

                        <tbody>
                            <tr>
                                <td>
                                    Room Type : 
                                </td>
                                <td>
                                    <?php echo $dorm_room_row["roomType"] ?>   
                                </td>
                            </tr>
                            <tr>
                                <td  >
                                    Areas : 
                                </td>
                                <td>
                                    <?php echo $dorm_room_row["areas"]; ?> SQ.M.    
                                </td>
                            </tr>
                            <tr>
                                <td  >
                                    Number Person Per Room : 
                                </td>
                                <td>
                                    <?php echo $dorm_room_row["num_of_person"]; ?> Person    
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
                                    Room Deposit : 
                                </td>
                                <td>
                                    <?php echo $dorm_room_row["roomDeposit"]; ?> Month
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="color: green">Total Booking Price : </span>
                                </td>
                                <td>
                                    <span style="color: green"><?php echo number_format($dorm_room_row["price"] * $dorm_room_row["roomDeposit"] + $dorm_room_row["price"]); ?> Baht</span>
                                </td>
                            </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3 style="margin-top:0%"><span>Booking </span>This Room</h3>
                    <form action="index.php?chose_page=book" method="POST">
                        <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
                            <tbody>
                            <input type="hidden" name="roomID" value="<?php echo $dorm_room_row["roomID"] ?>">
                            <input type="hidden" name="dormID" value="<?php echo $dorm_row["dormID"] ?>">
                            <?php get_room_per_floor($dorm_room_row["roomID"], $dorm_row["dormID"]) ?>
                            <tr>
                                <td colspan="3" style="text-align: center">
                                    <?php if (isset($_SESSION["auth"]) && $_SESSION["auth"] === true && $_SESSION["type"] === "Member" && $_SESSION["status"] !== "Blacklist") { ?>
                                        <?php
                                        $return_value = checkBooking($_SESSION["memberID"]);
                                        if ($return_value === "PASS") {
                                            ?>
                                            <button style="width:40%" class="btn1 btn1-success" type="submit">Booking</button>
                                        <?php } else { ?>
                                            <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" style="width:40%" class="btn1 btn1-success" type="button">Booking</button>
                                            <script>

                                                $(function() {

                                                    $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                        alert("<?php echo $return_value ?>");
                                                        window.location = "index.php?chose_page=membernotification";
                                                    });
                                                });

                                            </script>
                                        <?php } ?>
                                    <?php } else if ($_SESSION["auth"] && $_SESSION["auth"] === true && $_SESSION["type"] === "Owner") { ?>
                                        <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 40% ">Booking</button>
                                        <script>

                                            $(function() {

                                                $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                    alert("Only Member can book the room.");
                                                });



                                            });

                                        </script>
                                    <?php } else if ($_SESSION["auth"] && $_SESSION["auth"] === true && $_SESSION["type"] === "Admin") { ?>
                                        <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 40% ">Booking</button>
                                        <script>

                                            $(function() {

                                                $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                    alert("Only Member can book the room.");
                                                });



                                            });

                                        </script>    
                                    <?php } else if ($_SESSION["auth"] && $_SESSION["auth"] === true && $_SESSION["status"] === "Blacklist") { ?>
                                        <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 40% ">Booking</button>
                                        <script>

                                            $(function() {

                                                $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                    alert("Cannot booking. You are Blacklist.");
                                                });



                                            });

                                        </script>
                                    <?php } else { ?>
                                        <button id="booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>" type="button" class="btn1 btn1-success"style="width: 40% ">Booking</button>
                                        <script>

                                            $(function() {

                                                $("#booking_not_sign_in<?php echo $dorm_room_row["roomID"] ?>").on("click", function() {
                                                    alert("Please sign in before booking or register.");
                                                    window.location = "index.php?chose_page=register";
                                                });



                                            });

                                        </script>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="span12" style="margin-left:0%">
        <legend><h1><span>Map</span>Direction</h1></legend>
        <iframe width="950" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?f=d&amp;source=s_d&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%40<?php echo $dorm_row["latitude"] ?>,<?php echo $dorm_row["longtitude"] ?>&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.com/maps?f=d&amp;source=embed&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%4013.648036,100.498716&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
        <br><br>
    </div>
    <div class="span12" style="margin-left:0%">
        <?php

        function getRating($dormID) {

            require 'connection.php';
            $query = "select rating from Comment where dormID = $dormID";
            $result = mysqli_query($con, $query);
            $allcomment = mysqli_num_rows($result);
            $allrate = 0;
            $rating = 0;
            while ($row = mysqli_fetch_array($result)) {
                $allrate = $allrate + $row[0];
            }
            if ($allcomment !== 0) {
                $rating = $allrate / $allcomment;
            }
            return $rate = array($rating, $allcomment);
        }

        function calStar($number) {
            $star = "";
            $number = ceil($number);
            for ($i = 1; $i <= $number; $i++) {
                $star = $star . "&#9733;";
            }
            for ($i = 1; $i <= 5 - $number; $i++) {
                $star = $star . "&#9734;";
            }
            return $star;
        }

        $rate = getRating($dormID);
        ?>
        <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
            <legend><h1><span>Review </span> And Comment <span id="show_rating" class="pull-right"><h4 style="font-style:italic">Review Rate : <span style="color:gold"><?php echo calStar($rate[0]) ?> </span><br><small class="pull-right">from <?php echo $rate[1] ?> Reviews</small></h4></span></h1></legend>
            <br>
            <tbody id="comment_table">
                <?php

                function getComment($dormID, $page) {
                    require 'connection.php';

                    $limit_start = ((4 * $page ) - 4);
                    $query = "select * from Comment c join Members m where c.memberID = m.memberID and c.dormID = $dormID order by date desc limit $limit_start , 4";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $star = "";
                        $date = substr(date("r", strtotime($row["date"])), 0, 25);

                        for ($i = 1; $i <= $row["rating"]; $i++) {
                            $star = $star . "&#9733;";
                        }
                        for ($i = 1; $i <= 5 - $row["rating"]; $i++) {
                            $star = $star . "&#9734;";
                        }

                        echo '<tr>';
                        echo '<td style="width:20%;height:15%">';
                        echo '<img src="'.$row["pic_path"].'" class="img-rounded"';
                        echo '</td>';
                        echo '<td style="width:250px;height:15%">';
                        echo '<h3 style="margin-top:0%">' . $row["firstName"] . " " . substr($row["lastName"], 0, 1) . '.' . '</h3>';
                        echo '<p class="pull-left">' . $date . '<br>Give Rate :<span class="pull-right" style="color:gold">' . $star . '</span></p>';
                        echo '';
                        echo '</td>';
                        echo '<td style="padding-top:1%"><h4><span>' . $row["detail"] . '</span></h4></td>';
                        echo '</tr>';
                    }

                    if (mysqli_num_rows($result) === 0) {
                        echo '<tr>';
                        echo '<td colspan="3" style="height:12%"><h3 style="text-align:center"> No Comment Yet</h3></td>';
                        echo '</tr>';
                    }
                }

                getComment($dormID, 1);
                ?>
            </tbody>
            <tbody>
                <tr style="height: 2%">
                    <td colspan="3">
                        <ul id="page_comment" class="comment_page pagination pull-right">
                            <?php

                            function displayPage($cur_page, $query, $href) {

                                require 'connection.php';

                                $result = mysqli_query($con, $query);

                                if (mysqli_num_rows($result) !== 0) {
                                    $total_page = ceil(mysqli_num_rows($result) / 4);
                                } else {
                                    $total_page = 1;
                                }
                                if ($cur_page == 1) {
                                    $prev_page = 1;
                                } else {
                                    $prev_page = $cur_page - 1;
                                }
                                if ($cur_page == $total_page) {
                                    $next_page = $cur_page;
                                } else {
                                    $next_page = $cur_page + 1;
                                }

                                echo '<li><a value=' . $prev_page . ' href="' . $href . $prev_page . '">&laquo;</a></li>';
                                for ($i = 1; $i <= $total_page; $i++) {
                                    $class = ($cur_page == $i ? "class = 'active'" : "");
                                    echo '<li ' . $class . '><a value=' . $i . ' href="' . $href . $i . '">' . $i . '</a></li>';
                                }
                                echo '<li><a value=' . $next_page . ' href="' . $href . $next_page . '">&raquo;</a></li>';
                            }

                            $page_query = "select * from Comment where dormID = $dormID";
                            $cur_page = 1;
                            $page_href = "callback.php?comment_page=";
                            displayPage($cur_page, $page_query, $page_href);
                            ?>
                        </ul>
                    </td>
                </tr>
            </tbody>
            <?php if (isset($_SESSION["auth"]) && $_SESSION["type"] === "Member" && $_SESSION["status"] !== "Blacklist") { ?>
                <tr>
                    <td style="width:20%;height:15%"><img src="<?php echo $_SESSION["pic_path"]; ?>" class="img-rounded" ><h3><?php echo $_SESSION["firstname"] . " " . substr($_SESSION["lastname"], 0, 1) . '.'; ?> </h3></td>
                    <td colspan="2"> 
                        <textarea style="margin-bottom:2%" id="comment_value" rows="5" class="span8 from-control" required style="margin-bottom: 20px"></textarea>
                        <select id="comment_rate" class="form-control" style="width:30%;margin-top:0px;display:inline">
                            <option id="rate_default" value="default">Give Dormitory Rate</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Star</option>i
                            <option value="3">3 Star</option>
                            <option value="4">4 Star</option>
                            <option value="5">5 Star</option>
                        </select>
                        <span id="star" style="margin-top:0px;margin-left:20%;display: inline;color:gold">&#9734;&#9734;&#9734;&#9734;&#9734;</span><br>   
                        <span id="show" style="width:5%"></span>
                        <br>
                        <button id="comment_submit" class="btn1 btn1-success" style="margin-top:20px;width: 30%;"> Comment</button>
                        <button class="btn1 btn1-danger" id='clear_comment' style="margin-top:20px;width: 30%;margin-left: 5%"> Clear</button>

                        <!--                <button id="comment_submit" class="btn btn-default book-now" style="margin-top:20px;width: 30%;margin-left: 12%"> Comment</button>
                                            <button class="btn btn-default book-now" style="margin-top:20px;width: 30%;margin-left: 5%"> Clear</button>-->

                    </td>
                </tr>
            <?php } ?>
            <script>

                $(function() {

                    $("#comment_submit").on("click", function() {
                        if ($("#comment_value").val() !== "") {
                            if ($("#comment_rate").val() !== "default") {
                                url = "callback.php?comment_value=" + $("#comment_value").val().replace(/ /g, "+") + "&comment_dormID=<?php echo $_GET["dormID"]; ?>&comment_memberID=<?php echo isset($_SESSION["auth"]) ? $_SESSION["auth"] === true ? $_SESSION["memberID"] : ""  : "" ?>&comment_rate=" + $("#comment_rate").val();
                                $("#show").append('<img style="height:20px" src="images/loading.gif" />');
                                var timer = setTimeout(function() {
                                    clearTimeout(timer);
                                    $("#show").html("");
                                    $("#comment_value").removeAttr("value");
                                    document.getElementById("rate_default").setAttribute("selected", " ");
                                    cur_page = "callback.php?request_comment_page=1&request_comment_dormID=<?php echo $dormID; ?>";
                                    $("#comment_table").animate({
                                        opacity: 0
                                    }, 100, function() {
                                        $("#comment_table").load(url, function() {
                                            $("#comment_table").animate({
                                                opacity: 1
                                            }, 1000);
                                        });
                                    });
                                    $("#page_comment").animate({
                                        opacity: 0
                                    }, 100, function() {
                                        $("#page_comment").load(cur_page, function() {
                                            $("#page_comment").animate({
                                                opacity: 1
                                            }, 1000);
                                        });
                                    });
                                    $("#show_rating").animate({
                                        opacity: 0
                                    }, 100, function() {
                                        url = "callback.php?comment_rating=<?php echo $dormID ?>";
                                        $("#show_rating").load(url, function() {
                                            $("#show_rating").animate({
                                                opacity: 1
                                            }, 1000);
                                        });
                                    });
                                }, 1000);
                            } else {
                                alert("Please Give Dormitory Rate");
                            }
                        } else {
                            alert("Please Input Value");
                        }
                    });

                    $("#clear_comment").on("click", function() {

                        $("#comment_value").removeAttr("value");
                        document.getElementById("rate_default").setAttribute("selected", " ");

                    });

                    $("#comment_rate").on("change", function() {

                        if ($("#comment_rate").val() !== "default") {
                            if ($("#comment_rate").val() === "1") {
                                $("#star").html("&#9733;&#9734;&#9734;&#9734;&#9734;");
                            }
                            if ($("#comment_rate").val() === "2") {
                                $("#star").html("&#9733;&#9733;&#9734;&#9734;&#9734;");
                            }
                            if ($("#comment_rate").val() === "3") {
                                $("#star").html("&#9733;&#9733;&#9733;&#9734;&#9734;");
                            }
                            if ($("#comment_rate").val() === "4") {
                                $("#star").html("&#9733;&#9733;&#9733;&#9733;&#9734;");
                            }
                            if ($("#comment_rate").val() === "5") {
                                $("#star").html("&#9733;&#9733;&#9733;&#9733;&#9733;");
                            }
                        } else {
                            $("#star").html("&#9734;&#9734;&#9734;&#9734;&#9734;");
                        }
                    });


                    $(function() {
                        $(".comment_page li a").live("click", function() {
                            event.preventDefault();
                            url = $(this).attr("href") + "&comment_dormID=<?php echo $dormID; ?>";
                            cur_page = "callback.php?request_comment_page=" + $(this).attr("value") + "&request_comment_dormID=<?php echo $dormID; ?>";
                            $("#page_comment").load(cur_page);
                            $("#comment_table").animate({
                                opacity: 0
                            }, 100, function() {
                                $("#comment_table").load(url, function() {
                                    $("#comment_table").animate({
                                        opacity: 1
                                    }, 200);
                                });
                            });
                        });
                    });


                });





            </script>

        </table>


        <div class="row">
            <div class="span12 what_people_say">
                <div id="quotes">
                    <blockquote class="textItem" style="display: none;">
                        <p>Easy to find</p>
                    </blockquote>			

                    <blockquote class="textItem" style="display: none;">
                        <p>Safe Dormitory</p>
                    </blockquote>			

                    <blockquote class="textItem" style="display: none;">
                        <p>Beyond All Comfortable</p>
                    </blockquote>
                    <blockquote class="textItem" style="display: none;">
                        <p>All in Bangmod Dorm</p>
                    </blockquote>
                </div>
            </div>	
        </div>
    </div>
<?php } ?>
</div> <!-- /container -->

