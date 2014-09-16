
<div class="row booking_summary">

    <div class="span12">	

        <div class="row">
            <div class="span10">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-10" style="margin-left: 70px">
                                <legend style="text-align: center"><span>Dormitory </span>Information</legend>
                            </div>
                            <?php
                            
                            if(isset($_GET["dormID"]) && is_numeric($_GET["dormID"])){
                                
                                $dormID = $_GET["dormID"];
                                require 'connection.php';
                                $query = "select dormName,d.type,firstName,lastName,m.memberID,m.email,m.tel,disFromUni,dormitory_rate,count(roomType) as AllroomType,sum(numOfRoom) as Allroom,sum(roomAvailable) as AvailableRoom,d.status from dormitories d join rooms r join members m where d.dormID = r.dormID and d.memberID = m.memberID and d.dormID = $dormID";
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_array($result);                            
                            ?>
                            <div class="col-md-4" style="margin-left:70px">
                                <h4>Name <span class="pull-right">: </span></h4>
                                <h4>Type <span class="pull-right">: </span> </h4>
                                <h4>Owner <span class="pull-right">: </span> </h4>
                                <h4>Contact <span class="pull-right">: </span> </h4>
                                <h4>Email <span class="pull-right">: </span> </h4>
                                <h4 style="margin-top: 20px">Distance From University <span class="pull-right">: </span> </h4>
                                <h4>Rate <span class="pull-right">: </span> </h4>
                                <h4>Number Of Rooms Type <span class="pull-right">: </span> </h4>
                                <h4>Number Of Rooms <span class="pull-right">: </span> </h4>
                                <h4>All Available Room <span class="pull-right">: </span> </h4>
                                <h4>Status on page <span class="pull-right">: </span> </h4>

                            </div>
                            
                            <?php
                            
                            $star = "";
                            
                            for($i=1;$i<=$row["dormitory_rate"];$i++){
                                $star = $star . "&#9733;";
                            }
                            for($i=1;$i<=5-$row["dormitory_rate"];$i++){
                                $star = $star . "&#9734;";
                            }
                            
                            ?>
                            <div class="col-md-6" style="margin-left:0px">
                                <h4><span class="pull-right"><?php echo $row["dormName"] ?></span></h4><br>
                                <h4><span class="pull-right"><?php echo $row["type"] ?></span></h4><br>
                                <h4><a class="pull-right" href="index.php?chose_page=memberInfo&memberID=<?php echo $row["memberID"]; ?>&backtodorm=<?php echo $dormID;  ?>" style="color: #0099ff"><?php echo $row["firstName"] . " " . $row["lastName"] ?></a></h4><br>
                                <h4><span class="pull-right"><?php echo $row["tel"] ?></span></h4><br>
                                <h4><span class="pull-right"><?php echo $row["email"] ?></span></h4><br><br>
                                <h4><span class="pull-right"><?php echo $row["disFromUni"] ?> Kilometers</span></h4><br>
                                <h4><span class="pull-right" style="color:gold"><?php echo $star ?></span></h4><br>
                                <h4><span class="pull-right"> <?php echo $row["AllroomType"] ?> Room Type</span></h4><br>
                                <h4><span class="pull-right"> <?php if($row["Allroom"] !== NULL) { echo $row["Allroom"]; } else { echo "Empty"; } ?> Rooms</span></h4><br>
                                <h4><span class="pull-right"> <?php if($row["AvailableRoom"] !== NULL) { echo $row["AvailableRoom"]; } else { echo "Empty"; } ?> Rooms</span></h4><br>
                                <h4><span class="pull-right"><?php echo $row["status"] ?></span></h4><br>
                            </div>
                            <div class="col-md-10" style="margin-left:70px">
                                <h3 style="text-align: center">Dormitory Facilities</h3>
                                <?php
                                $fac_dorm_query = "select * from FacilitiesInDorm where dormID = $dormID";
                                $fac_dorm_result = mysqli_query($con, $fac_dorm_query);
                                $fac_dorm_row = mysqli_fetch_array($fac_dorm_result);
                                ?>
                                <table class="table table-striped" style="border:solid 1px #cccccc">
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
                            <?php } ?>
                            </div>
                        </div>		
                        <br />
                        <a href="index.php?chose_page=checkDormitory" class="btn btn-primary btn-large book-now" style="margin-left:38%;margin-bottom: 50px">Back</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div></div>
</div><!-- /container -->
