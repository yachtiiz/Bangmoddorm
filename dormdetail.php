
<?php
if (isset($_GET["dormID"]) && is_numeric($_GET["dormID"])) {

    require 'connection.php';

    $dormID = $_GET["dormID"];

    $dorm_query = "select * from Dormitories where dormID = $dormID";
    $dorm_result = mysqli_query($con, $dorm_query);
    $dorm_row = mysqli_fetch_array($dorm_result);

    $fac_dorm_query = "select * from FacilitiesInDorm where dormID = $dormID";
    $fac_dorm_result = mysqli_query($con, $fac_dorm_query);
    $fac_dorm_row = mysqli_fetch_array($fac_dorm_result);

    $pic_dorm_query = "select * from dormPic where dormID = $dormID";
    $pic_dorm_result = mysqli_query($con, $pic_dorm_query);

    $dorm_room_query = "select * from Rooms where dormID = $dormID and status = 'Active' ";
    $dorm_room_result = mysqli_query($con, $dorm_room_query);
    ?>


    <div class="row">
        <div class="span12">	
            <br /><br />
            <h1><?php echo $dorm_row["dormName"] ?></h1>
            <br>
            <div class="row">
                <div class="span12">
                    <img  class="img-thumbnail" style="width:900px;height: 500px" src="images/dormitory_picture/<?php echo $dorm_row["dorm_pictures"]; ?>" alt=""/><br><br>
                    <h3><span>Screen </span> Shot </h3>
                </div>
                <?php while ($dorm_pic_row = mysqli_fetch_array($pic_dorm_result)) { ?>
                    <div class="span3">
                        <img style="width: 220px;height: 150px;margin-top: 20px"class="img-thumbnail" src="images/dormitory_picture/<?php echo $dorm_pic_row["dormPicPath"] ?>" alt="" />
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

    <table class="table table-striped">
        <thead>
        <h1><span> Dormitory</span> Facilities</h1>
    </thead>
    <tr>
        <td><h3 style="margin-left: 45%">Internet</h3></td>
    </tr>
    <?php echo $fac_dorm_row["wifi"] === "0" ? "" : "<tr><td><h4><img src='css/images/icons/Wireless.png'/>WiFi</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["lan"] === "0" ? "" : "<tr><td><h4>Lan</h4></td></tr>" ?>
    <tr>
        <td><h3 style="margin-left: 45%">Facilities</h4></td>
    </tr>
    <?php echo $fac_dorm_row["airCleanService"] === "0" ? "" : "<tr><td><h4>Air Clean Service</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["roomCleanService"] === "0" ? "" : "<tr><td><h4>Room Clean Service</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["washingService"] === "0" ? "" : "<tr><td><h4>Washing Service</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["fitness"] === "0" ? "" : "<tr><td><h4>Fitness</h4></td></tr>" ?>


    <?php echo $fac_dorm_row["pool"] === "0" ? "" : "<tr><td><h4>Swimming Pool</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["busService"] === "0" ? "" : "<tr><td><h4>Bus Service</h4></td></tr>" ?>


    <?php echo $fac_dorm_row["restaurant"] === "0" ? "" : "<tr><td><h4>Restaurant</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["vendingMachine"] === "0" ? "" : "<tr><td><h4>Vending Machine</h4></td></tr>" ?>

    <?php echo $fac_dorm_row["laundry"] === "0" ? "" : "<tr><td><h4>Laundry</h4></td></tr>" ?>
    <?php echo $fac_dorm_row["elevator"] === "0" ? "" : "<tr><td><h4>Elevator</h4></td></tr>" ?>


    <?php echo $fac_dorm_row["cctv"] === "0" ? "" : "<tr><td><h4>CCTV</h4></td></tr>" ?>

    <tr>
        <td><h4>Rate</h4>
            <h3 style="color:gold"><?php
                for ($i = 1; $i < $dorm_row["rate"]; $i++) {
                    echo '&#9734;';
                } for ($i = $dorm_row["rate"]; $i < 5; $i++) {
                    echo '&#9733;';
                }
                ?></h3></td>
    </tr>
    </table>

    <hr>
    <br><br>
    <table class="table table-condensed">
        <thead>
        <h1><span>Type </span>Of Rooms</h1>
    </thead>
    <?php while ($dorm_room_row = mysqli_fetch_array($dorm_room_result)) { ?>
        <tr>
            <td><img style="width: 410px;height: 300px" src="images/room_pictures/<?php echo $dorm_room_row["main_pic"]; ?>" class="img-thumbnail"/></td>
            <td class="span5"><h3><?php echo $dorm_room_row["roomType"] ?> </h3>Areas : <?php echo $dorm_room_row["areas"]; ?> <br> Price : <?php echo $dorm_room_row["price"]; ?> <br> <p style="color: green"> Room Available : <?php echo $dorm_room_row["roomAvailable"]; ?> </p><p style="color: red">Room Reserve : <?php echo $dorm_room_row["roomReserve"] ?> </p><br>
                <a href="book.jsp"><button type="button" class="btn btn-success book-now">Booking</button></a><br><br>
                <!-- Button trigger modal -->
                <button class="btn btn-primary btn-lg book-now" data-toggle="modal" data-target="#room<?php echo $dorm_room_row["roomID"]; ?>">
                    Detail
                </button>

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
                                        <div class="pull-right"><h3>Price <?php echo $dorm_room_row["price"] ?> Bath/Month</h3></div>





                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default book-now" data-dismiss="modal">Close</button>
                                    <a href="index.php?chose_page=book&dormID=<?php echo $dorm_row["dormID"]; ?>&roomID=<?php echo $dorm_room_row["roomID"]; ?>"><button type="button" class="btn btn-success book-now">Booking</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td><img src="css/images/rooms/KiatSuda_Room1_1.jpg"/></td>
        <td>
            <h3>Medium Room</h3>Air Conditioner <br> Table <br> Wardrobe <br> Price : 20$/Month<br><br>
            <a href="book.jsp"><button type="button" class="btn btn-success book-now">Booking</button></a><br><br>
            <!-- Button trigger modal -->
            <button class="btn btn-primary btn-lg book-now" data-toggle="modal" data-target="#myModal2">
                Detail
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Medium Room</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="span7">
                                    <img src="css/images/rooms/KiatSuda_Room1_1.jpg"/>
                                </div>
                                <div class="span3">
                                    <br><br>
                                    <img src="css/images/rooms/KiatSuda_Room1_2.jpg"/>
                                </div>
                                <div class="span3">
                                    <br><br>
                                    <img src="css/images/rooms/KiatSuda_Room1_3.jpg"/>
                                </div>

                                <div class="span7">
                                    <h3><span>Facilities</span> in room</h3>		
                                    <div class="row">
                                        <div class="span2">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Breakfast Buffet</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Wi-Fi</div><div class="pull-right"><input type="checkbox" checked="checked" disabled="" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Non-smoking</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Newspaper</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Luggage storage</div><div class="pull-right"><input type="checkbox" disabled="" /></div>
                                            </div>                   
                                        </div>
                                        <div class="span3 offset1">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Parking</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Limo service</div><div class="pull-right"><input type="checkbox" checked="checked" disabled="" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Air conditioning</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Hair dryer</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Sea view</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="custom_container">
                                        <div class="pull-left strong">Areas of room : 5m x 4m</div>
                                    </div>

                                    <div class="custom_container">
                                        <div class="pull-left strong" style="color:green">Number Room Available : 24</div>
                                    </div>
                                    <div class="pull-right"><h3>Price 15$/Month</h3></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default book-now" data-dismiss="modal">Close</button>
                            <a href="book.jsp"><button type="button" class="btn btn-success book-now">Booking</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td><img src="css/images/rooms/44garden_Room_1.jpg"/></td>
        <td><h3>Deluxe Room</h3>Air Conditioner <br> Table <br> Wardrobe <br> Price : 20$/Month<br><br>
            <a href="book.jsp"><button type="button" class="btn btn-success book-now">Booking</button></a><br><br>
            <!-- Button trigger modal -->
            <button class="btn btn-primary btn-lg book-now" data-toggle="modal" data-target="#myModal3">
                Detail
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Deluxe Room</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="span7">
                                    <img src="css/images/rooms/44garden_Room_1.jpg"/>
                                </div>
                                <div class="span3">
                                    <br><br>
                                    <img src="css/images/rooms/44garden_Room_2.jpg"/>
                                </div>
                                <div class="span3">
                                    <br><br>
                                    <img src="css/images/rooms/44garden_Room_3.jpg"/>
                                </div>

                                <div class="span7">
                                    <h3><span>Facilities</span> in room</h3>		
                                    <div class="row">
                                        <div class="span2">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Breakfast Buffet</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Wi-Fi</div><div class="pull-right"><input type="checkbox" checked="checked" disabled="" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Non-smoking</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Newspaper</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Luggage storage</div><div class="pull-right"><input type="checkbox" disabled="" /></div>
                                            </div>                   
                                        </div>
                                        <div class="span3 offset1">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Parking</div><div class="pull-right"><input type="checkbox" checked="checked" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Limo service</div><div class="pull-right"><input type="checkbox" checked="checked" disabled="" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Air conditioning</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Hair dryer</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Sea view</div><div class="pull-right"><input type="checkbox" disabled=""/></div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="custom_container">
                                        <div class="pull-left strong">Areas of room : 4m x 4m</div>
                                    </div>

                                    <div class="custom_container">
                                        <div class="pull-left strong" style="color:green">Number Room Available : 30</div>
                                    </div>
                                    <div class="pull-right"><h3>Price 5$/Month</h3></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default book-now" data-dismiss="modal">Close</button>
                            <a href="book.jsp"><button type="button" class="btn btn-success book-now">Booking</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </table>
    <br>
    <legend><h1><span>Map</span>Direction</h1></legend>
    <iframe width="950" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?f=d&amp;source=s_d&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%4013.648036,100.498716&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.com/maps?f=d&amp;source=embed&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%4013.648036,100.498716&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
    <br><br>
    <table class="table table-striped">
        <h1><span>Review </span> And Comment</h1>
        <br>
        <tr>
            <td colspan="3"><h3>Richard M. </h3><br>Solo travelers</td>
            <td colspan="10">Beautiful Balcony and Facilities.</td>

        </tr>
        <tr>
            <td colspan="2"><h3>Vic L. </h3><br>Solo travelers</td>
            <td colspan="10">Not far from University. So comfortable.</td>

        </tr>
        <tr>
            <td colspan="2"><h3>Tommy F. </h3><br>Solo travelers</td>
            <td colspan="10">I Like it.</td>

        </tr>
        <tr>
            <td colspan="2"><h3>Ajchariya K. </h3><br>Solo travelers</td>
            <td colspan="10"><textarea rows="5" class="span8" ></textarea><br>
                <button type="button" class="btn btn-success book-now">Comment</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="reset" class="btn btn-danger book-now" value="Clear"></td>


        </tr>

    </table>


    <div class="row">
        <div class="span12 what_people_say">
            <div id="quotes">
                <blockquote class="textItem" style="display: none;">
                    <p>Easy to find</p>
                    <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                </blockquote>			

                <blockquote class="textItem" style="display: none;">
                    <p>Safe Dormitory</p>
                    <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                </blockquote>			

                <blockquote class="textItem" style="display: none;">
                    <p>Beyond All Comfortable</p>
                    <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                </blockquote>
                <blockquote class="textItem" style="display: none;">
                    <p>All in Bangmod Dorm</p>
                    <small>Someone famous <cite title="Source Title">Source Title</cite></small>
                </blockquote>
            </div>
        </div>	
    </div>
<?php } ?>
</div> <!-- /container -->

