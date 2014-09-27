
<script>

    $(document).ready(function() {

        $("#form").validate({
            rules: {
                distance: {
                    checkSpecial: true,
                    required: true
                },
                address: {
                    checkSpecial: true,
                    required: true
                },
                soi: {
                    checkSpecial: true,
                    required: true
                },
                road: {
                    checkSpecial: true,
                    required: true
                },
                subdistinct: {
                    required: true,
                    checkSpecial: true
                },
                distinct: {
                    checkSpecial: true,
                    required: true
                },
                province: {
                    checkSpecial: true,
                    required: true
                },
                zipcode: {
                    required: true,
                    checkSpecial: true,
                    number: true
                },
                latitude: {
                    required: true,
                    checkSpecial: true,
                },
                longitude: {
                    required: true,
                    checkSpecial: true,
                },
                displayname: {
                    required: true,
                    checkSpecial: true
                },
                email: {
                    required: true,
                    email:true
                },
                tel: {
                    checkSpecial: true,
                    required: true
                },
                branch: {
                    checkSpecial: true,
                    required: true
                },
                bankkaccname: {
                    checkSpecial: true,
                    required: true
                },
                bankkaccid: {
                    checkSpecial: true,
                    required: true
                }
            }

        });
    });


</script>

<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span10">
                <?php

                function upPicture($file, $i, $dormID) {

                    if ($_FILES["$file"]["type"][$i] == "image/jpg" || $_FILES["$file"]["type"][$i] == "image/png" || $_FILES["$file"]["type"][$i] == "image/jpeg" || $_FILES["$file"]["type"][$i] == "image/gif" || $_FILES["$file"]["type"][$i] == "image/pjpeg" || $_FILES["$file"]["type"][$i] == "image/x-png") {


                        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
                        $path = "images/dormitory_picture/" . $rand . "_" . $dormID . "_" . $_FILES["$file"]["name"][$i];
                        $pic_path = $rand . "_" . $dormID . "_" . $_FILES["$file"]["name"][$i];

                        if (move_uploaded_file($_FILES["$file"]["tmp_name"][$i], $path)) {
                            return $msg = $pic_path;
                        } else {
                            return $msg = "Cant Upload";
                        }
                    } else {
                        return $msg = "Invalid Picture";
                    }
                }

                function update_fac($dormID) {

                    require 'connection.php';

                    $wifi = isset($_POST["wifi"]) ? ($_POST["wifi"] == 'on' ? 1 : 0) : 0;
                    $lan = isset($_POST["lan"]) ? ($_POST["lan"] == 'on' ? 1 : 0) : 0;
                    $room_clean = isset($_POST["room_clean_service"]) ? ($_POST["room_clean_service"] == 'on' ? 1 : 0) : 0;
                    $air_clean = isset($_POST["air_clean_service"]) ? ($_POST["air_clean_service"] == 'on' ? 1 : 0) : 0;
                    $washing_service = isset($_POST["washing_service"]) ? ($_POST["washing_service"] == 'on' ? 1 : 0) : 0;
                    $laundry = isset($_POST["laundry"]) ? ($_POST["laundry"] == 'on' ? 1 : 0) : 0;
                    $vending = isset($_POST["vending_machine"]) ? ($_POST["vending_machine"] == 'on' ? 1 : 0) : 0;
                    $bus_service = isset($_POST["bus_service"]) ? ($_POST["bus_service"] == 'on' ? 1 : 0) : 0;
                    $restaurant = isset($_POST["restaurant"]) ? ($_POST["restaurant"] == 'on' ? 1 : 0) : 0;
                    $fitness = isset($_POST["fitness"]) ? ($_POST["fitness"] == 'on' ? 1 : 0) : 0;
                    $swimming_pool = isset($_POST["swimming_pool"]) ? ($_POST["swimming_pool"] == 'on' ? 1 : 0) : 0;
                    $cctv = isset($_POST["cctv"]) ? ($_POST["cctv"] == 'on' ? 1 : 0) : 0;
                    $car_parking = isset($_POST["parking"]) ? ($_POST["parking"] == 'on' ? 1 : 0) : 0;
                    $elevator = isset($_POST["elevator"]) ? ($_POST["elevator"] == 'on' ? 1 : 0) : 0;

                    $wifi_detail = filter_var($_POST["wifi_detail"], FILTER_SANITIZE_STRING);
                    $lan_detail = filter_var($_POST["lan_detail"], FILTER_SANITIZE_STRING);
                    $room_detail = filter_var($_POST["room_clean_detail"], FILTER_SANITIZE_STRING);
                    $air_detail = filter_var($_POST["air_clean_detail"], FILTER_SANITIZE_STRING);
                    $washing_detail = filter_var($_POST["washing_service_detail"], FILTER_SANITIZE_STRING);
                    $fitness_detail = filter_var($_POST["fitness_detail"], FILTER_SANITIZE_STRING);
                    $pool_detail = filter_var($_POST["pool_detail"], FILTER_SANITIZE_STRING);
                    $bus_detail = filter_var($_POST["bus_detail"], FILTER_SANITIZE_STRING);
                    $restaurant_detail = filter_var($_POST["restaurant_detail"], FILTER_SANITIZE_STRING);
                    $vending_detail = filter_var($_POST["vending_detail"], FILTER_SANITIZE_STRING);
                    $luandry_detail = filter_var($_POST["laundry_detail"], FILTER_SANITIZE_STRING);
                    $cctv_detail = filter_var($_POST["cctv_detail"], FILTER_SANITIZE_STRING);
                    $parking_detail = filter_var($_POST["parking_detail"], FILTER_SANITIZE_STRING);
                    $elevator_detail = filter_var($_POST["elevator_detail"], FILTER_SANITIZE_STRING);

                    $query = "update FacilitiesInDorm set parkingDetails = '$parking_detail' , wifiDetails = '$wifi_detail' , lanDetails = '$lan_detail' , airCleanDetails = '$air_detail' , roomCleanDetails = '$room_detail' , washingDetails = '$washing_detail' , fitnessDetails = '$fitness_detail' , poolDetails = '$pool_detail' , 
                                busDetails = '$bus_detail' , restaurantDetails = '$restaurant_detail' , vendingDetails = '$vending_detail' , laundryDetails = '$luandry_detail' , elevatorDetails = '$elevator_detail' , cctvDetails = '$cctv_detail' , parking = $car_parking , wifi = $wifi , lan = $lan , airCleanService = $air_clean , 
                                    roomCleanService = $room_clean , washingService = $washing_service , fitness = $fitness , pool = $swimming_pool , busService = $bus_service , restaurant = $restaurant , vendingMachine = $vending , laundry = $laundry , elevator = $elevator , cctv = $cctv where dormID = $dormID";

                    if (mysqli_query($con, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function edit_bank($dormID) {

                    require 'connection.php';
                    $number = 0;
                    $new_number = 0;
                    if (isset($_POST["bank_acc_id"])) {
                        for ($j = 0; $j < count($_POST["bank_acc_id"]); $j++) {
                            $bank_id = $_POST["bank_id"][$j];
                            $bank_name = filter_var($_POST["bank_name"][$j], FILTER_SANITIZE_STRING);
                            $bank_acc_id = filter_var($_POST["bank_acc_id"][$j], FILTER_SANITIZE_STRING);
                            $bank_acc_name = filter_var($_POST["bank_acc_name"][$j], FILTER_SANITIZE_STRING);
                            $bank_branch = filter_var($_POST["bank_branch"][$j], FILTER_SANITIZE_STRING);

                            $query = "update BankAccount set bankName = '$bank_name' , bankAccountID = '$bank_acc_id' , bankAccountName = '$bank_acc_name' , branch = '$bank_branch' where bankID = $bank_id";
                            if (mysqli_query($con, $query)) {
                                $number += 1;
                            } else {
                                $number = 0;
                            }
                        }
                    }
                    if (isset($_POST["new_bank_acc_id"])) {
                        for ($i = 0; $i < count($_POST["new_bank_acc_id"]); $i++) {

                            $new_bank_name = filter_var($_POST["new_bank_name"][$i], FILTER_SANITIZE_STRING);
                            $new_acc_id = filter_var($_POST["new_bank_acc_id"][$i], FILTER_SANITIZE_STRING);
                            $new_acc_name = filter_var($_POST["new_bank_acc_name"][$i], FILTER_SANITIZE_STRING);
                            $new_bank_branch = filter_var($_POST["new_bank_branch"][$i], FILTER_SANITIZE_STRING);

                            $query = "INSERT INTO `BankAccount` (`dormID`, `bankAccountID`, `bankAccountName`, `bankName`, `branch`)VALUES($dormID, '$new_acc_id', '$new_acc_name', '$new_bank_name', '$new_bank_branch');";
                            if (mysqli_query($con, $query)) {
                                $new_number += 1;
                            } else {
                                $new_number = 0;
                            }
                        }
                    }
                    if (isset($_POST["bank_acc_id"]) ? $number === count($_POST["bank_acc_id"]) : true && isset($_POST["new_bank_acc_id"]) ? $new_number === count($_POST["new_bank_acc_id"]) : true) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function edit_dorm() {

                    require 'connection.php';

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

                    $main_dorm_path = NULL;


                    if (isset($_FILES["main_dorm_pic"])) {
                        if ($_FILES["main_dorm_pic"]["name"] !== "") {
                            if (move_uploaded_file($_FILES["main_dorm_pic"]["tmp_name"], "images/dormitory_picture/main_pic_" . $dormID . "_" . $_FILES["main_dorm_pic"]["name"])) {
                                $main_dorm_path = "main_pic_" . $dormID . "_" . $_FILES["main_dorm_pic"]["name"];
                            }
                        }
                    }

                    if (isset($_FILES["change_main_dorm_pic"])) {
                        if ($_FILES["change_main_dorm_pic"]["name"] !== "") {
                            if (move_uploaded_file($_FILES["change_main_dorm_pic"]["tmp_name"], "images/dormitory_picture/main_pic_" . $dormID . "_" . $_FILES["change_main_dorm_pic"]["name"])) {
                                $main_dorm_path = "main_pic_" . $dormID . "_" . $_FILES["change_main_dorm_pic"]["name"];
                            }
                        }
                    }



                    if (isset($_FILES["dorm_pic"])) {
                        for ($i = 0; $i <= count($_FILES["dorm_pic"]); $i++) {
                            if (isset($_FILES["dorm_pic"]["tmp_name"][$i]) && $_FILES["dorm_pic"]["name"][$i] !== "") {
                                $msg = upPicture("dorm_pic", $i, $dormID);
                                $pic_query = "INSERT INTO `DormPic` (`dormID`, `dormPicPath`) VALUES ($dormID, '$msg');";
                                mysqli_query($con, $pic_query);
                            }
                        }
                    }

                    $pic_main_path_query = $main_dorm_path === NULL ? "" : ", dorm_pictures = '$main_dorm_path'";

                    $query = "update Dormitories set type= '$type', disFromUni = $distance , addressNo = '$addressNO' , soi = '$soi' , road = '$road' , subDistinct = '$subdistinct' , dorm_distinct = '$distinct' , province = '$province' , zip = '$zip_code' , latitude = '$latitude' , longtitude = '$longtitude' , email = '$email' , tel = '$tel'" . $pic_main_path_query . " where dormID = $dormID ";

                    if (mysqli_query($con, $query) && update_fac($dormID) && edit_bank($dormID)) {
                        echo '<script>alert("Edit Dormitory Success ");</script>';
                        echo '<script>window.location = "index.php?chose_page=ownersystem";</script>';
                    } else {
                        echo '<script>alert("Edit Dormitory Failed (Some Information Wrong)");</script>';
                    }
                }

                function filterPic(&$arr_pic) {
                    $value = 0;
                    for ($i = 0; $i < count($arr_pic["name"]); $i++) {
                        if ($arr_pic["name"][$i] != "") {
                            if ($arr_pic["type"][$i] == "image/jpg" || $arr_pic["type"][$i] == "image/png" || $arr_pic["type"][$i] == "image/x-png" || $arr_pic["type"][$i] == "image/jpeg" || $arr_pic["type"][$i] == "image/gif" || $arr_pic["type"][$i] == "image/pjpeg") {
                                $value += 0;
                            }
                            else
                                $value += 1;
                        }
                    }
                    if ($value == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if (isset($_GET["dormID"]) && is_numeric($_GET["dormID"])) {
                    require 'connection.php';
                    if (isset($_POST["edit_dorm_submit"])) {
                        if (filterPic($_FILES["dorm_pic"])) {
                            edit_dorm();
                        }
                    }


                    $query = "select * from dormitories where dormID=" . $_GET["dormID"];
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result);

                    $fac_query = "select * from FacilitiesInDorm where dormID=" . $_GET["dormID"];
                    $fac_result = mysqli_query($con, $fac_query);
                    $fac_row = mysqli_fetch_array($fac_result);

                    $pic_query = "select * from DormPic where dormID=" . $_GET["dormID"];
                    $pic_result = mysqli_query($con, $pic_query);
                    ?>
                    <form id="form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                                        <input id="distance" class="form-control" name="distance" type="text" placeholder="Insert only Number unit is KM." value='<?php echo $row["disFromUni"] ?>' >
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
                                        <input id="address" class="form-control" type="text" name="addressNo" value='<?php echo $row["addressNo"] ?>'>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Soi</span>
                                        <input id="soi" class="form-control" type="text" name="soi" value='<?php echo $row["soi"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Road</span>
                                        <input id="road" class="form-control" type="text" name="road" value='<?php echo $row["road"] ?>' />
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Sub Distinct</span>
                                        <input id="subdistinct" class="form-control" type="text" name="sub_distinct" value='<?php echo $row["subDistinct"] ?>' >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Distinct</span>
                                        <input id="distinct" class="form-control" type="text" name="distinct" value='<?php echo $row["dorm_distinct"] ?>' >
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Province</span>
                                        <input id="province" class="form-control" type="text" name="province" value='<?php echo $row["province"] ?>' />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Zip Code</span>
                                        <input id="zipcode" class="form-control" type="text" name="zip_code" value='<?php echo $row["zip"] ?>'>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Latitude</span>
                                        <input id="latitude" class="form-control" type="text" name="latitude" value='<?php echo $row["latitude"] ?>'/>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Longitude</span>
                                        <input id="longitude" class="form-control" type="text" name="longtitude" value='<?php echo $row["longtitude"] ?>' />
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
                                        <input id="email" class="form-control" type="text" name="email" value='<?php echo $row["email"] ?>'/>
                                    </div>
                                </div>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Telephone</span>
                                        <input id="tel" class="form-control" type="text" name="tel" value='<?php echo $row["tel"] ?>' />
                                    </div>
                                </div>
                            </div><br>


                            <div class="row">
                                <div class="span10">
                                    <legend><span>Dormitory</span> Bank Account </legend>
                                </div>
                            </div>

                            <?php
                            $dorm_id = $_GET["dormID"];
                            $bank_query = "select * from BankAccount where dormID = $dorm_id";
                            $bank_result = mysqli_query($con, $bank_query);

                            if (mysqli_num_rows($bank_result) === 0) {
                                ?>
                                <div class='row'> 
                                    <div class='col-lg-6'>
                                        <div class="input-group">
                                            <span class="input-group-addon">Bank Name</span>
                                            <select class="form-control" name="new_bank_name[]">
                                                <option value="Bangkok Bank">Bangkok Bank</option>
                                                <option value="Krung Sri Bank">Krung Sri Bank</option>
                                                <option value="Krung Thai Bank (KTB)">Krung Thai Bank (KTB)</option>
                                                <option value="Kasikorn Thai Bank (KBANK)">Kasikorn Thai Bank (KBANK)</option>
                                                <option value="Kaitnakin Bank">Kaitnakin Bank</option>
                                                <option value="CIMB Thai Bank">CIMB Thai Bank</option>
                                                <option value="Thai Military Bank (TMB)">Thai Military Bank (TMB)</option>
                                                <option value="Tisco Bank">Tisco Bank</option>
                                                <option value="Thai Credit Bank (TCR)">Thai Credit Bank (TCR)</option>
                                                <option value="Thanachart Bank">Thanachart Bank</option>
                                                <option value="Unitied Overseas Bank (UOB)">Unitied Overseas Bank (UOB)</option>
                                                <option value="Land and House Retail Bank (LHBANK)">Land and House Retail Bank (LHBANK)</option>
                                                <option value="Standard Chartered">Standard Chartered</option>
                                                <option value="SME Bank (SME)">SME Bank</option>
                                                <option value="EXIM Thailand (EXIM)">EXIM Thailand Bank</option>
                                                <option value="Goverment Saving Bank (GSB)">Government Saving Bank (GSB)</option>
                                                <option value="Islamic Bank of Thailand">Islamic Bank of Thailand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-lg-6'>
                                        <div class="input-group">
                                            <span class="input-group-addon">Branch</span>
                                            <input id="branch" class="form-control" type="text" name="new_bank_branch[]" value='' />
                                        </div>
                                    </div>
                                </div><br>
                                <div class='row'>
                                    <div class='col-lg-6'>
                                        <div class="input-group">
                                            <span class="input-group-addon">Bank Account Name</span>
                                            <input id="bankaccname" class="form-control" type="text" name="new_bank_acc_name[]" value=''/>
                                        </div>
                                    </div>
                                    <div class='col-lg-6'>
                                        <div class="input-group">
                                            <span class="input-group-addon">Bank Account ID</span>
                                            <input id="bankaccid" class="form-control" type="text" name="new_bank_acc_id[]" value='' />
                                        </div>
                                    </div>
                                </div><br>
                            <?php } else { ?>
                                <?php while ($bank_row = mysqli_fetch_array($bank_result)) { ?>
                                    <div class='row'> 
                                        <div class='col-lg-6'>
                                            <div class="input-group">
                                                <span class="input-group-addon">Bank Name</span>
                                                <input type="hidden" name="bank_id[]" value="<?php echo $bank_row["bankID"] ?>" >
                                                <select class="form-control" name="bank_name[]">
                                                    <option value="Bangkok Bank">Bangkok Bank</option>
                                                    <option value="Krung Sri Bank">Krung Sri Bank</option>
                                                    <option value="Krung Thai Bank (KTB)">Krung Thai Bank (KTB)</option>
                                                    <option value="Kasikorn Thai Bank (KBANK)">Kasikorn Thai Bank (KBANK)</option>
                                                    <option value="Kaitnakin Bank">Kaitnakin Bank</option>
                                                    <option value="CIMB Thai Bank">CIMB Thai Bank</option>
                                                    <option value="Thai Military Bank (TMB)">Thai Military Bank (TMB)</option>
                                                    <option value="Tisco Bank">Tisco Bank</option>
                                                    <option value="Thai Credit Bank (TCR)">Thai Credit Bank (TCR)</option>
                                                    <option value="Thanachart Bank">Thanachart Bank</option>
                                                    <option value="Unitied Overseas Bank (UOB)">Unitied Overseas Bank (UOB)</option>
                                                    <option value="Land and House Retail Bank (LHBANK)">Land and House Retail Bank (LHBANK)</option>
                                                    <option value="Standard Chartered">Standard Chartered</option>
                                                    <option value="SME Bank (SME)">SME Bank</option>
                                                    <option value="EXIM Thailand (EXIM)">EXIM Thailand Bank</option>
                                                    <option value="Goverment Saving Bank (GSB)">Government Saving Bank (GSB)</option>
                                                    <option value="Islamic Bank of Thailand">Islamic Bank of Thailand</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='col-lg-6'>
                                            <div class="input-group">
                                                <span class="input-group-addon">Branch</span>
                                                <input id="branch" class="form-control" type="text" name="bank_branch[]" value='<?php echo $bank_row["branch"] ?>' />
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class='row'>
                                        <div class='col-lg-6'>
                                            <div class="input-group">
                                                <span class="input-group-addon">Bank Account Name</span>
                                                <input id="bankaccname" class="form-control" type="text" name="bank_acc_name[]" value='<?php echo $bank_row["bankAccountName"] ?>'/>
                                            </div>
                                        </div>
                                        <div class='col-lg-6'>
                                            <div class="input-group">
                                                <span class="input-group-addon">Bank Account ID</span>
                                                <input id="bankaccid" class="form-control" type="text" name="bank_acc_id[]" value='<?php echo $bank_row["bankAccountID"] ?>' />
                                            </div>
                                        </div>
                                    </div><br>
                                    <?php
                                }
                            }
                            ?>
                            <span id="inputMore">

                            </span>
                            <button type="button" id="moreBank" class="btn btn-default pull-right">More Bank Account</button>
                            <button type="button" id="Remove_moreBank" class="btn btn-default pull-right" style="margin-right:20px">Remove More Bank Account</button>
                            <br />

                            <script>

                                var morebank = 0;

                                $(document).on("click", "#moreBank", function() {
                                    $("#inputMore").append("<div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Name</span><select class='form-control' name='new_bank_name[]'><option value='Bangkok Bank'>Bangkok Bank</option><option value='Krung Sri Bank'>Krung Sri Bank</option><option value='Krung Thai Bank (KTB)'>Krung Thai Bank (KTB)</option><option value='Kasikorn Thai Bank (KBANK)'>Kasikorn Thai Bank (KBANK)</option><option value='Kaitnakin Bank'>Kaitnakin Bank</option><option value='CIMB Thai Bank'>CIMB Thai Bank</option><option value='Thai Military Bank (TMB)'>Thai Military Bank (TMB)</option><option value='Tisco Bank'>Tisco Bank</option><option value='Thai Credit Bank (TCR)'>Thai Credit Bank (TCR)</option><option value='Thanachart Bank'>Thanachart Bank</option><option value='Unitied Overseas Bank (UOB)'>Unitied Overseas Bank (UOB)</option><option value='Land and House Retail Bank (LHBANK)'>Land and House Retail Bank (LHBANK)</option><option value='Standard Chartered'>Standard Chartered</option><option value='SME Bank (SME)'>SME Bank</option><option value='EXIM Thailand (EXIM)'>EXIM Thailand Bank</option><option value='Goverment Saving Bank (GSB)'>Government Saving Bank (GSB)</option><option value='Islamic Bank of Thailand'>Islamic Bank of Thailand</option></select></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Branch</span><input class='form-control' type='text' name='new_bank_branch[]' value='' /></div></div></div><br><div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account Name</span><input class='form-control' type='text' name='new_bank_acc_name[]' value=''/></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account ID</span><input class='form-control' type='text' name='new_bank_acc_id[]' value='' /></div></div></div><br>");
                                    morebank = morebank + 1;
                                });

                                $(document).on("click", "#Remove_moreBank", function() {
                                    
                                    $("#inputMore").html("");
                                    for (i = 1; i < morebank; i++) {
                                        $("#inputMore").append("<div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Name</span><select class='form-control' name='new_bank_name[]'><option value='Bangkok Bank'>Bangkok Bank</option><option value='Krung Sri Bank'>Krung Sri Bank</option><option value='Krung Thai Bank (KTB)'>Krung Thai Bank (KTB)</option><option value='Kasikorn Thai Bank (KBANK)'>Kasikorn Thai Bank (KBANK)</option><option value='Kaitnakin Bank'>Kaitnakin Bank</option><option value='CIMB Thai Bank'>CIMB Thai Bank</option><option value='Thai Military Bank (TMB)'>Thai Military Bank (TMB)</option><option value='Tisco Bank'>Tisco Bank</option><option value='Thai Credit Bank (TCR)'>Thai Credit Bank (TCR)</option><option value='Thanachart Bank'>Thanachart Bank</option><option value='Unitied Overseas Bank (UOB)'>Unitied Overseas Bank (UOB)</option><option value='Land and House Retail Bank (LHBANK)'>Land and House Retail Bank (LHBANK)</option><option value='Standard Chartered'>Standard Chartered</option><option value='SME Bank (SME)'>SME Bank</option><option value='EXIM Thailand (EXIM)'>EXIM Thailand Bank</option><option value='Goverment Saving Bank (GSB)'>Government Saving Bank (GSB)</option><option value='Islamic Bank of Thailand'>Islamic Bank of Thailand</option></select></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Branch</span><input class='form-control' type='text' name='new_bank_branch[]' value='' /></div></div></div><br><div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account Name</span><input class='form-control' type='text' name='new_bank_acc_name[]' value=''/></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account ID</span><input class='form-control' type='text' name='new_bank_acc_id[]' value='' /></div></div></div><br>");
                                    }
                                    morebank = morebank - 1;

                                });


                            </script>

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
                                            <input type="checkbox" name='wifi' <?php echo $fac_row["wifi"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Room Clean Service
                                        </span>
                                        <input type="text" name='room_clean_detail' placeholder='Detail' class="form-control" value="<?php echo $fac_row["roomCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='room_clean_service' <?php echo $fac_row["roomCleanService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Wahsing Service
                                        </span>
                                        <input type="text" name="washing_service_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["washingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='washing_service' <?php echo $fac_row["washingService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Vending Machine
                                        </span>
                                        <input type="text" name="vending_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["vendingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="vending_machine" <?php echo $fac_row["vendingMachine"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Restaurant
                                        </span>
                                        <input type="text" name="restaurant_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["restaurantDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="restaurant" <?php echo $fac_row["restaurant"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Swimming Pool
                                        </span>
                                        <input type="text" name="pool_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["poolDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="swimming_pool" <?php echo $fac_row["pool"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Car Parking
                                        </span>
                                        <input type="number" name="parking_detail" placeholder='Number of car parking' class="form-control" value="<?php echo $fac_row["parkingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="parking" <?php echo $fac_row["parking"] == 1 ? "checked" : ""; ?>>
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
                                            <input type="checkbox" name="lan" <?php echo $fac_row["lan"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Air Clean Service
                                        </span>
                                        <input type="text" name="air_clean_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["airCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="air_clean_service" <?php echo $fac_row["airCleanService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Laundry
                                        </span>
                                        <input type="text" name="laundry_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["laundryDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="laundry" <?php echo $fac_row["laundry"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bus Service
                                        </span>
                                        <input type="text" name="bus_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["busDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="bus_service" <?php echo $fac_row["busService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fitness
                                        </span>
                                        <input type="text" name="fitness_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["fitnessDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="fitness" <?php echo $fac_row["fitness"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            CCTV
                                        </span>
                                        <input type="text" name="cctv_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["cctvDetails"] ?>">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="cctv" <?php echo $fac_row["cctv"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Elevator
                                        </span>
                                        <input type="text" name="elevator_detail" placeholder='Detail' class="form-control" value="<?php echo $fac_row["elevatorDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="elevator" <?php echo $fac_row["elevator"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <br/>


                            <br/>
                            <div class="row">
                                <div class="span12">
                                    <legend><span>Dormitory</span> Picture</legend>
                                </div>
                                <div class="span12">
                                    <?php if (isset($row["dorm_pictures"]) && $row["dorm_pictures"] !== "") { ?>
                                        <div class="span3">
                                            <h4>Main Picture :</h4><br>
                                            <p>Change Main Picture</p>
                                            <input style='width:100%' class="form-control" name="change_main_dorm_pic" type="file" placeholder="" multipart/>
                                        </div>

                                        <div class="span8 center">
                                            <img style="width:405px;height: 250px" class="img-thumbnail" src="images/dormitory_picture/<?php echo $row["dorm_pictures"]; ?>">
                                        </div>
                                    <?php } else { ?>
                                        <label>Main Picture : &nbsp;&nbsp;&nbsp;
                                            <input style='width:50%' class="form-control" name="main_dorm_pic" type="file" placeholder="" required/>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div><br><br>
                            <div class='row'>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <legend><span> Screen</span> Shot</legend>
                                    </div>
                                    <?php
                                    for ($i = 0; $i < mysqli_num_rows($pic_result); $i++) {
                                        $pic_row = mysqli_fetch_array($pic_result);
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 250px">
                                            <label>Picture <?php echo $i + 1; ?>
                                                <?php if ($pic_row["dormPicPath"] !== "") { ?>
                                                    <img class="img-thumbnail" style="width:250px;height: 224px" style="" src="images/dormitory_picture/<?php echo $pic_row["dormPicPath"]; ?>">
                                                <?php } else { ?>
                                                    <input class="form-control" name="dorm_pic[]" type="file" placeholder=""/>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                    <?php for ($i = mysqli_num_rows($pic_result); $i < 6; $i++) {
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 250px">
                                            <label>Picture <?php echo $i + 1 ?>
                                                <input class="form-control" name="dorm_pic[]" type="file" />
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span10">
                                    <br>
                                    <button name="edit_dorm_submit" type="submit" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                    <button type="button" id="<?php echo $row["status"] === "Active" ? "disabled_button" : "active_button"; ?>" style='margin-left: 15px' class="btn btn-primary btn-large book-now pull-right"><?php echo $row["status"] === "Active" ? "Hidden On Page" : "Showing On Page"; ?></button>
                                    <a href="index.php?chose_page=ownersystem" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                    <br><br>
                                </div>
                                <script>

                                    $(document).on("click", "#disabled_button", function() {
                                        $("#disabled_button").load("callback.php?disabled_dorm=" + "<?php echo $row["dormID"]; ?>");
                                        document.getElementById("disabled_button").setAttribute("id", "active_button");
                                        alert("Your Dormitory Information be Hidden on Dormitory Page");
                                    });
                                    $(document).on("click", "#active_button", function() {
                                        $("#active_button").load("callback.php?showing_dorm=" + "<?php echo $row["dormID"]; ?>");
                                    });


                                </script>
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
</div>
