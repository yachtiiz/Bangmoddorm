
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span10">
                <?php
                if (isset($_GET["dormID"]) && is_numeric($_GET["dormID"])) {
                    require 'connection.php';

                    if (isset($_POST["edit_dorm_submit"])) {
                        
                        function update_fac($dormID){
                            
                            require 'connection.php';
                            
                            $wifi = $_POST["wifi"] === 'on' ? 1:0;
                            $lan = $_POST["lan"] === 'on' ? 1:0;
                            $room_clean = $_POST["room_clean_service"] === 'on' ? 1:0;
                            $air_clean = $_POST["air_clean_service"] === 'on' ? 1:0;
                            $washing_service = $_POST["washing_service"] === 'on' ? 1:0;
                            $laundry = $_POST["laundry"] === 'on' ? 1:0;
                            $vending = $_POST["vending_machine"] === 'on' ? 1:0;
                            $bus_service = $_POST["bus_service"] === 'on' ? 1:0;
                            $restaurant = $_POST["restaurant"] === 'on' ? 1:0;
                            $fitness = $_POST["fitness"] === 'on' ? 1:0;
                            $swimming_pool = $_POST["swimming_pool"] === 'on' ? 1:0;
                            $cctv = $_POST["cctv"] === 'on' ? 1:0;
                            $car_parking = $_POST["parking"] === 'on' ? 1:0;
                            $elevator = $_POST["elevator"] === 'on' ? 1:0;
                            
                        }
                        
                        
                        $dormID = filter_var($_POST["dormID"], FILTER_SANITIZE_STRING);
                        $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
                        $distance = filter_var($_POST["distance"], FILTER_SANITIZE_NUMBER_FLOAT);
                        $addressNO = filter_var($_POST["addressNo"], FILTER_SANITIZE_STRING);
                        $soi = filter_var($_POST["soi"], FILTER_SANITIZE_STRING);
                        $road = filter_var($_POST["road"], FILTER_SANITIZE_STRING);
                        $subdistinct = filter_var($_POST["sub_distinct"], FILTER_SANITIZE_STRING);
                        $distinct = filter_var($_POST["distinct"], FILTER_SANITIZE_STRING);
                        $province = filter_var($_POST["province"], FILTER_SANITIZE_STRING);
                        $zip_code = filter_var($_POST["zip_code"], FILTER_SANITIZE_STRING);
                        $latitude = filter_var($_POST["latitude"], FILTER_SANITIZE_STRING);
                        $longtitude = filter_var($_POST["longtitude"], FILTER_SANITIZE_STRING);
                        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
                        $tel = filter_var($_POST["tel"], FILTER_SANITIZE_STRING);

                        $query = "update Dormitories set type= '$type', disFromUni = $distance , addressNo = '$addressNO' , soi = '$soi' , road = '$road' , subDistinct = '$subdistinct' , dorm_distinct = '$distinct' , province = '$province' , zip = '$zip_code' , latitude = '$latitude' , longtitude = '$longtitude' , email = '$email' , tel = '$tel' where dormID = $dormID ";

                        if (mysqli_query($con, $query)) {
                            echo '<script>alert("Edit Dormitory Success");</script>';
                            echo '<script>window.location = "index.php?chose_page=ownersystem";</script>';
                        } else {
                            echo '<script>alert("Edit Dormitory Failed (Some Information Wrong)");</script>';
                        }
                    }


                    $query = "select * from dormitories where dormID=" . $_GET["dormID"];
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);
                    
                    $fac_query = "select * from FacilitiesInDorm where dormID=" . $_GET["dormID"];
                    $fac_result = mysqli_query($con, $fac_query);
                    $fac_row = mysqli_fetch_array($fac_result);
                    
                    ?>
                    <form action="" method="get" class="form-horizontal" enctype="multipart/form-data">
                        <fieldset>
                            <br />
                            <h1>Edit Your Dormitory<br /><small>You can edit your dormitory information.
                                </small></h1><br />
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Dormitory </span>Information</legend>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Dormitory Name</span>
                                        <input disabled type="text" class="form-control" value='<?php echo $row["dormName"] ?>'>                                        
                                    </div>
                                    <input name="dormID" type="hidden" value="<?php echo $row["dormID"] ?>" />
                                </div>
                                <div class='col-lg-4 pull-right'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Type</span>
                                        <select class="form-control" name="type"><option value="Female" <?php echo $row["type"] === 'Female' ? "selected" : "" ?> />Female Only<option <?php echo $row["type"] === 'Male' ? "selected" : "" ?> value="Male" />Male Only<option <?php echo $row["type"] === 'Female&Male' ? "selected" : "" ?> value="Female&Male" />Female & Male</select>
                                    </div>
                                </div>                               
                            </div>		
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Distance From University</span>
                                        <input class="form-control" name="distance" type="text" placeholder="Insert only Number unit is KM." value='<?php echo $row["disFromUni"] ?>' >
                                        <span class="input-group-addon">Km.</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Dormitory</span> address</legend>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Address No.</span>
                                        <input class="form-control" type="text" name="addressNo" value='<?php echo $row["addressNo"] ?>'>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Soi</span>
                                        <input class="form-control" type="text" name="soi" value='<?php echo $row["soi"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Road</span>
                                        <input class="form-control" type="text" name="road" value='<?php echo $row["road"] ?>' />
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Sub Distinct</span>
                                        <input class="form-control" type="text" name="sub_distinct" value='<?php echo $row["subDistinct"] ?>' >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Distinct</span>
                                        <input class="form-control" type="text" name="distinct" value='<?php echo $row["dorm_distinct"] ?>' >
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Province</span>
                                        <input class="form-control" type="text" name="province" value='<?php echo $row["province"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Zip Code</span>
                                        <input class="form-control" type="text" name="zip_code" value='<?php echo $row["zip"] ?>'>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Latitude</span>
                                        <input class="form-control" type="text" name="latitude" value='<?php echo $row["latitude"] ?>'/>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Longitude</span>
                                        <input class="form-control" type="text" name="longtitude" value='<?php echo $row["longtitude"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br>                              
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Dormitory</span> Contact</legend>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Email</span>
                                        <input class="form-control" type="text" name="email" value='<?php echo $row["email"] ?>'/>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Telephone</span>
                                        <input class="form-control" type="text" name="tel" value='<?php echo $row["tel"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br />

                            <div class="row">

                                <div class="span10">
                                    <legend><span>Dormitories </span>Facilities</legend>
                                </div>		

                                <div class="span5">

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            WiFi
                                        </span>
                                        <input type="text" name='wifi_detail' placeholder='Detail' class="form-control" value="<?php echo $fac_row["wifiDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='wifi' <?php echo $fac_row["wifi"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                           Room Clean Service
                                        </span>
                                        <input type="text" name='clean_service_detail' placeholder='Detail' class="form-control" value="<?php echo $fac_row["roomCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='clean_service' <?php echo $fac_row["roomCleanService"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Wahsing Service
                                        </span>
                                        <input type="text" name="washing_service_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["washingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='washing_service' <?php echo $fac_row["washingService"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Vending Machine
                                        </span>
                                        <input type="text" name="vending_machine_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["vendingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="vending_machine" <?php echo $fac_row["vendingMachine"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Restaurant
                                        </span>
                                        <input type="text" name="restaurant_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["restaurantDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="restaurant" <?php echo $fac_row["restaurant"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Swimming Pool
                                        </span>
                                        <input type="text" name="pool_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["poolDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="swimming_pool" <?php echo $fac_row["pool"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Car Parking
                                        </span>
                                        <input type="number" name="parking_detail" placeholder='Number of car parking' class="form-control" value="<?php echo $fac_row["parkingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="car_parking" <?php echo $fac_row["parking"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>

                                <div class="span5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Lan
                                        </span>
                                        <input type="text" name="lan_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["lanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="lan" <?php echo $fac_row["lan"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Air Clean Service
                                        </span>
                                        <input type="text" name="air_clean_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["airCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="air_clean_service" <?php echo $fac_row["airCleanService"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Laundry
                                        </span>
                                        <input type="text" name="laundry_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["laundryDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="luandry" <?php echo $fac_row["laundry"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bus Service
                                        </span>
                                        <input type="text" name="bus_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["busDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="bus_service" <?php echo $fac_row["busService"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fitness
                                        </span>
                                        <input type="text" name="fitness_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["fitnessDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="fitness" <?php echo $fac_row["fitness"] === 1 ? "checked":"";?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            CCTV
                                        </span>
                                        <input type="text" name="cctv_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["cctvDetails"] ?>">
                                        <span class="input-group-addon" name="cctv" <?php echo $fac_row["cctv"] === 1 ? "checked":"";?> >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Elevator
                                        </span>
                                        <input type="text" name="elevator_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["elevatorDetails"] ?>">
                                        <span class="input-group-addon" name="elevetor" <?php echo $fac_row["elevetor"] === 1 ? "checked":"";?> >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <br/>


                            <br/>
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Dormitory</span> Picture</legend>
                                </div>
                                <div class="span4">
                                    <label>Picture1 
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture2
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder=""/>
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture3 
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture4 
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture5 
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture6 
                                        <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span10">
                                    <br>
                                    <button name="edit_dorm_submit" type="submit" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                    <a href="ownersystem.jsp" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                    <br><br>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                <?php } else { ?>
                </div>
                <h1>Something Error</h1>
            <?php } ?>
        </div>

    </div></div> <!-- /container -->
</div>
