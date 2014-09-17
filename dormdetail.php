
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

    <h1><span>Dormitory</span> Facilities &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        Rate &nbsp;<span style="color: gold">
            <?php
            for ($i = 1; $i <= $dorm_row["dormitory_rate"]; $i++) {
                echo '&#9733;';
            } for ($i = $dorm_row["dormitory_rate"]; $i < 5; $i++) {
                echo '&#9734;';
            }
            ?></span></h1>
    <div class="col-md-12" style="padding-left:0px">
        <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["wifi"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WIFI</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["lan"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAN</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["airCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; AIRCLEANSERVICE</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["roomCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ROOMCLEANSERVICE</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["washingService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WASHINGSERVICE</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["busService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; BUSSERVICE</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["fitness"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; FITNESS</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["pool"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; POOL</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["restaurant"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; RESTAURANT</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["vendingMachine"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; VENDINGMACHINE</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["laundry"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAUNDRY</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["elevator"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ELEVATOR</h3> 
                </td>
            </tr>
            <tr>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["cctv"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; CCTV</h3>
                </td>
                <td>
                    <h3 style="text-align:left"> <?php echo $fac_dorm_row["parking"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; PARKING</h3>
                </td>

            </tr>
        </table>
        <br><br><br>

    </div>


    <hr>

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
                                <?php echo $dorm_room_row["price"]; ?> BATH/MONTH 
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
                <button id="booking<?php echo $dorm_room_row["roomType"] ?>" type="button" class="btn book-now"style="margin-left: 50px; ">Booking</button><br><br>
                <script>

                    $(document).on("click", "#booking<?php echo $dorm_room_row["roomType"] ?>", function() {
                        event.preventDefault;
                        $("#booking<?php echo $dorm_room_row["roomType"] ?>").load("callback.php?memberID=<?php echo $_SESSION["memberID"]; ?>&dormID=<?php echo $dorm_row["dormID"]; ?>&roomID=<?php echo $dorm_room_row["roomID"]; ?>");
                    });

                </script>
                <!-- Button trigger modal -->
                <button class="btn btn-primary btn-lg book-now" data-toggle="modal" data-target="#room<?php echo $dorm_room_row["roomID"]; ?>" style="margin-left: 50px; ">
                    Detail
                </button>
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
                                        <div class="pull-right"><h3>Price <?php echo $dorm_room_row["price"] ?> Bath/Month</h3></div>





                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default book-now" data-dismiss="modal">Close</button>
                                    <button id="modal_booking<?php echo $dorm_room_row["roomType"] ?>" type="button" class="btn book-now">Booking</button>
                                    <script>
                                        $(document).on("click", "#modal_booking<?php echo $dorm_room_row["roomType"] ?>", function() {
                                            event.preventDefault;
                                            $("#booking<?php echo $dorm_room_row["roomType"] ?>").load("callback.php?memberID=<?php echo $_SESSION["memberID"]; ?>&dormID=<?php echo $dorm_row["dormID"]; ?>&roomID=<?php echo $dorm_room_row["roomID"]; ?>");
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
            </td>
        </tr>
    <?php } ?>

    </table>
    <br><br>
    <legend><h1><span>Map</span>Direction</h1></legend>
    <iframe width="950" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?f=d&amp;source=s_d&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%4013.648036,100.498716&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.com/maps?f=d&amp;source=embed&amp;saddr=%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%97%E0%B8%A2%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%A2%E0%B9%80%E0%B8%97%E0%B8%84%E0%B9%82%E0%B8%99%E0%B9%82%E0%B8%A5%E0%B8%A2%E0%B8%B5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%88%E0%B8%AD%E0%B8%A1%E0%B9%80%E0%B8%81%E0%B8%A5%E0%B9%89%E0%B8%B2%E0%B8%98%E0%B8%99%E0%B8%9A%E0%B8%B8%E0%B8%A3%E0%B8%B5+Pracha+Uthit+Rd,+Bang+Mot,+Thung+Khru,+Bangkok,+Thailand&amp;daddr=%E0%B8%AB%E0%B8%AD%E0%B8%9E%E0%B8%B1%E0%B8%81%E0%B8%8A%E0%B8%B2%E0%B8%A2+%E0%B8%A1%E0%B8%B2%E0%B8%A2%E0%B9%80%E0%B8%9E%E0%B8%A5%E0%B8%AA+2+%4013.648036,100.498716&amp;geocode=FZ9R0AAdMGr9BSHQMQs9swABDylx4AKOUaLiMDHQMQs9swABDw%3BFaRA0AAdHH39BQ&amp;aq=0&amp;oq=%E0%B8%A1%E0%B8%AB%E0%B8%B2&amp;sll=13.649438,100.497823&amp;sspn=0.006683,0.009645&amp;hl=en&amp;mra=ls&amp;ie=UTF8&amp;ll=13.649438,100.497823&amp;spn=0.00348,0.003072&amp;t=m" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
    <br><br>
    <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
        <h1><span>Review </span> And Comment <span class="pull-right"><h4 style="font-style:italic">Rate : 5.6 from 15 Reviews</h4></span></h1>
        <br>
        <tbody id="comment_table">
            <?php

            function getComment($dormID) {
                require 'connection.php';
                $query = "select * from comment c join members m where c.memberID = m.memberID and c.dormID = $dormID order by date";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $star = "";

                    for ($i = 1; $i <= $row["rating"]; $i++) {
                        $star = $star . "&#9733;";
                    }
                    for ($i = 1; $i <= 5 - $row["rating"]; $i++) {
                        $star = $star . "&#9734;";
                    }

                    echo '<tr>';
                    echo '<td colspan="2">';
                    echo '<h3 style="margin-top:0px">' . $row["firstName"] . " " . substr($row["lastName"], 0, 1) . '.' . '</h3>';
                    echo '<p class="pull-left">' . $row["date"] . '</p>';
                    echo '<p class="pull-left" style="color:gold">' . $star . '</p>';
                    echo '</td>';
                    echo '<td colspan="10" style="padding-top:5px"><h4><span>' . $row["detail"] . '</span></h4></td>';
                    echo '</tr>';
                }
            }
            getComment($dormID);
            ?>
        </tbody>
        <tr>
            <td colspan="2"><h3><?php echo $_SESSION["firstname"] . " " . substr($_SESSION["lastname"], 0, 1) . '.'; ?> </h3><br>Solo travelers</td>
            <td colspan="10">
                <textarea style="margin-bottom:20px" id="comment_value" rows="5" class="span8 from-control" required style="margin-bottom: 20px"></textarea>
                <select id="comment_rate" class="form-control" style="width:25%;margin-top:0px;display:inline">
                    <option value="default">Give Dormitory Rate</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Star</option>
                    <option value="3">3 Star</option>
                    <option value="4">4 Star</option>
                    <option value="5">5 Star</option>
                </select>
                <span id="star" style="margin-top:0px;margin-left:20%;display: inline;color:gold">&#9734;&#9734;&#9734;&#9734;&#9734;</span><br>   
                <span id="show" style="width:5%"></span>
                <button id="comment_submit" class="btn btn-default book-now" style="margin-top:20px;width: 30%;margin-left: 12%"> Comment</button>
                <button class="btn btn-default book-now" style="margin-top:20px;width: 30%;margin-left: 5%"> Clear</button>

            </td>
        </tr>
        <script>

            $(function() {

                $("#comment_submit").on("click", function() {
                    if ($("#comment_value").val() !== "") {
                        if ($("#comment_rate").val() !== "default") {
                            url = "callback.php?comment_value=" + $("#comment_value").val().replace(/ /g, "+") + "&comment_dormID=<?php echo $_GET["dormID"]; ?>&comment_memberID=<?php echo $_SESSION["memberID"]; ?>&comment_rate=" + $("#comment_rate").val();
                            $("#show").append('<img style="height:20px" src="images/loading.gif" />');
                            var timer = setTimeout(function() {
                                clearTimeout(timer);
                                $("#show").html("");
                                $("#comment_value").removeAttr("value");
                                $("#comment_table").animate({
                                    opacity: 0
                                }, 100, function() {
                                    $("#comment_table").load(url, function() {
                                        $("#comment_table").animate({
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
            });





        </script>

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

