<div class="col-md-12" style="">    
<?php
if (isset($_GET["dormID"]) && is_numeric($_GET["dormID"])) {

    $dormID = $_GET["dormID"];
    require 'connection.php';
    $query = "select dormName,d.type,firstName,lastName,m.memberID,m.email,m.tel,disFromUni,dormitory_rate,count(roomType) as AllroomType,sum(numOfRoom) as Allroom,sum(roomAvailable) as AvailableRoom,d.status from dormitories d join rooms r join members m where d.dormID = r.dormID and d.memberID = m.memberID and d.dormID = $dormID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    ?>


    <?php
    $star = "";

    for ($i = 1; $i <= $row["dormitory_rate"]; $i++) {
        $star = $star . "&#9733;";
    }
    for ($i = 1; $i <= 5 - $row["dormitory_rate"]; $i++) {
        $star = $star . "&#9734;";
    }
    ?>


    
        <legend><h3 style="text-align: center"><span>Dormitory </span>Information</h3></legend>
        <div class="col-lg-6 pull-left" >
            <table style=" width: 90%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Name : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["dormName"] ?>
                        </td>
                    </tr>            
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Type : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["type"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Owner : </span></h4>
                        </td>
                        <td>
                            <a href="index.php?chose_page=memberInfo&memberID=<?php echo $row["memberID"]; ?>&backtodorm=<?php echo $dormID; ?>" style="color: #0099ff"><?php echo $row["firstName"] . " " . $row["lastName"] ?></a>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px">
                        <td>
                            <h4><span>Contact : </span></h4>  
                        </td>
                        <td>
                            <?php echo $row["tel"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Email : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["email"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Distance : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["disFromUni"] ?> KM.
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-5 pull-right" >   
            <table style="width: 100%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Rate : </span></h4>
                        </td>
                        <td>
                            <span class="" style="color:gold"><?php echo $star ?></span>
                        </td>
                    </tr>    
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Total Room Types : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["AllroomType"] ?> Types
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Total Rooms : </span></h4>
                        </td>
                        <td>
                            <?php
                            if ($row["Allroom"] !== NULL) {
                                echo $row["Allroom"];
                            } else {
                                echo "Empty";
                            }
                            ?> Rooms
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Available Rooms : </span></h4>
                        </td>
                        <td>
                            <?php
                            if ($row["AvailableRoom"] !== NULL) {
                                echo $row["AvailableRoom"];
                            } else {
                                echo "Empty";
                            }
                            ?> Rooms
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Status on page : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["status"] ?>
                        </td>
                    </tr>

                </tbody>
            </table>
            <br><br><br>
        </div>
    </div>
    <div class="col-md-12" style="">
        <legend><h3 style="text-align: center"><span>Dormitory </span>FACILITIES</h3></legend>
        <?php
        $fac_dorm_query = "select * from FacilitiesInDorm where dormID = $dormID";
        $fac_dorm_result = mysqli_query($con, $fac_dorm_query);
        $fac_dorm_row = mysqli_fetch_array($fac_dorm_result);
        ?>
        <table class="table table-striped" style="border:solid 1px #cccccc">
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["wifi"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WIFI</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["lan"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAN</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["airCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; AIRCLEANSERVICE</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["roomCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ROOMCLEANSERVICE</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["washingService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WASHINGSERVICE</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["busService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; BUSSERVICE</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["fitness"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; FITNESS</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["pool"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; POOL</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["restaurant"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; RESTAURANT</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["vendingMachine"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; VENDINGMACHINE</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["laundry"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAUNDRY</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["elevator"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ELEVATOR</h4> 
                </td>
            </tr>
            <tr>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["cctv"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; CCTV</h4>
                </td>
                <td>
                    <h4 style=" margin-left: 20%"> <?php echo $fac_dorm_row["parking"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; PARKING</h4>
                </td>

            </tr>
        </table>
    <?php } ?>
<br><br>

<a href="index.php?chose_page=checkDormitory" class="btn1 btn1-danger" style="margin-left:38%;margin-bottom: 50px; width: 30%">Back</a>
</div>
</div><!-- /container -->
