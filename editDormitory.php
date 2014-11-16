
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
                    checkSpecial: true
                },
                longitude: {
                    checkSpecial: true
                },
                displayname: {
                    required: true,
                    checkSpecial: true
                },
                email: {
                    required: true,
                    email: true
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
<div class="span12">	
            <div class="row">
                <div class="span10">
<?php

function checkPermission($dormID) {
    require 'connection.php';

    $query = 'select memberID from Dormitories where dormID = ' . $dormID;

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $memberID = $_SESSION["memberID"];
    if ($memberID === $row[0]) {
        return true;
    } else {
        return false;
    }
}

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

            $query = "INSERT INTO `BankAccount` (`dormID`, `bankAccountID`, `bankAccountName`, `bankName`, `branch` , bank_status)VALUES($dormID, '$new_acc_id', '$new_acc_name', '$new_bank_name', '$new_bank_branch' , 'Hiding');";
            if (mysqli_query($con, $query)) {
                $new_number += 1;
            } else {
                $new_number = 0;
            }
        }
    }
    if (isset($_POST["bank_acc_id"]) ? $number === count($_POST["bank_acc_id"]) : true) {
        if (isset($_POST["new_bank_acc_id"]) ? $new_number === count($_POST["new_bank_acc_id"]) : true) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function add_floor() {

    require 'connection.php';

    $total_floor = filter_var($_POST["total_floor"], FILTER_SANITIZE_STRING);
    $dormID = filter_var($_POST["dormID"], FILTER_SANITIZE_STRING);
    $query = "select total_floor from Dormitories where dormID = $dormID";
    $result = mysqli_query($con, $query);
    $total_floor_row = mysqli_fetch_array($result);
    $i = 1;
    if ($total_floor_row[0] !== NULL) {
        $i = $total_floor_row[0] + 1;
    }

    for ($i; $i <= $total_floor; $i++) {
        $query = "INSERT INTO `Floor` (`dormID`, `floorNo`) VALUES('$dormID','$i');";
        if (!mysqli_query($con, $query)) {
            return false;
        }
    }
    return true;
}

function add_room_per_floor() {

    require 'connection.php';
    $dormID = filter_var($_POST["dormID"], FILTER_SANITIZE_STRING);
    if (!isset($_POST["change_data"])) {
        $query = "select * from Floor where dormID = $dormID order by floorNo";
        $result = mysqli_query($con, $query);
        $total_roomID = array();
        while ($row = mysqli_fetch_array($result)) {
            if ($row["floorNo"] === "1") {
                for ($i = 0; $i < count($_POST["roomtype_name"]); $i++) {
                    $room_type = $_POST["roomtype_name"][$i];
                    $query = "INSERT INTO `Rooms` (`roomType`,`status`) VALUES ('$room_type','Incomplete');";
                    if (mysqli_query($con, $query)) {
                        $room_query = "select max(roomID) from Rooms";
                        $room_result = mysqli_query($con, $room_query);
                        $room_row = mysqli_fetch_array($room_result);
                        $roomID = $room_row[0];
                        $total_roomID[$i] = $roomID;
                        $floorNo = $row["floorNo"];
                        $floorID = $row["floorID"];
                        $room_per_floor = $_POST["floor" . $floorNo . "_roomtype"][$i];
                        $room_per_floor_query = "INSERT INTO `RoomPerFloor` (`floorID`, `roomID`, `roomPerFloor`) VALUES ($floorID, $roomID,$room_per_floor);";
                        if (!mysqli_query($con, $room_per_floor_query)) {
                            return false;
                        }
                        $fac_query = "INSERT INTO `FacilitiesInRoom` (`roomID`)VALUES ($roomID);";
                        if (!mysqli_query($con, $fac_query)) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                for ($j = 0; $j < count($total_roomID); $j++) {
                    $roomID = $total_roomID[$j];
                    $floorNo = $row["floorNo"];
                    $floorID = $row["floorID"];
                    $room_per_floor = $_POST["floor" . $floorNo . "_roomtype"][$j];
                    $room_per_floor_query = "INSERT INTO `RoomPerFloor` (`floorID`, `roomID`, `roomPerFloor`) VALUES ($floorID, $roomID,$room_per_floor);";
                    if (!mysqli_query($con, $room_per_floor_query)) {
                        return false;
                    }
                }
            }
        }
    } else {
        $query = "select * from Floor where dormID = $dormID";
        $result = mysqli_query($con, $query);
        $total_newroomID = array();
        while ($row = mysqli_fetch_array($result)) {
            for ($i = 1; $i <= count($_POST["room_name"]); $i++) {

                $floorID = $row["floorID"];
                $floorNo = $row["floorNo"];
                $room_per_floor = $_POST["floor" . $floorNo . "_roomtype"][$i - 1];
                if (isset($_POST["floor" . $floorNo . "_roomtype_matchingID"][$i - 1])) {
                    $matchingID = $_POST["floor" . $floorNo . "_roomtype_matchingID"][$i - 1];
                    $query = "update RoomPerFloor set roomPerFloor = $room_per_floor where matchingID = $matchingID";
                } else {
                    $roomID = $_POST["roomID"][$i - 1];
                    $query = "INSERT INTO `RoomPerFloor` (`floorID`, `roomID`, `roomPerFloor`) VALUES ($floorID, $roomID,$room_per_floor);";
                }
                if (!mysqli_query($con, $query)) {
                    return false;
                }
            }



            if (isset($_POST["newroomtype_name"])) {
                if ($row["floorNo"] === '1') {
                    for ($i = 0; $i < count($_POST["newroomtype_name"]); $i++) {
                        $roomtype_name = $_POST["newroomtype_name"][$i];
                        $query = "INSERT INTO `Rooms` (`roomType`,`status`) VALUES ('$roomtype_name','Incomplete');";

                        if (mysqli_query($con, $query)) {
                            //Insert Room Per floor
                            $room_query = "select max(roomID) from Rooms";
                            $room_result = mysqli_query($con, $room_query);
                            $room_row = mysqli_fetch_array($room_result);
                            $roomID = $room_row[0];
                            $total_newroomID[$i] = $roomID;
                            $floorNo = $row["floorNo"];
                            $floorID = $row["floorID"];
                            $room_per_floor = $_POST["floor" . $floorNo . "_newroomtype"][$i];
                            $room_per_floor_query = "INSERT INTO `RoomPerFloor` (`floorID`, `roomID`, `roomPerFloor`) VALUES ($floorID, $roomID,$room_per_floor);";
                            if (!mysqli_query($con, $room_per_floor_query)) {
                                return false;
                            }
                            //Insert Fac Room
                            $fac_query = "INSERT INTO `FacilitiesInRoom` (`roomID`)VALUES ($roomID);";
                            if (!mysqli_query($con, $fac_query)) {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                } else {
                    for ($j = 0; $j < count($total_newroomID); $j++) {
                        $roomID = $total_newroomID[$j];
                        $floorNo = $row["floorNo"];
                        $floorID = $row["floorID"];
                        $room_per_floor = $_POST["floor" . $floorNo . "_newroomtype"][$j];
                        $room_per_floor_query = "INSERT INTO `RoomPerFloor` (`floorID`, `roomID`, `roomPerFloor`) VALUES ($floorID, $roomID,$room_per_floor);";
                        if (!mysqli_query($con, $room_per_floor_query)) {
                            return false;
                        }
                    }
                }
            }
        }
        for ($i = 1; $i <= count($_POST["room_name"]); $i++) {
            $roomID = $_POST["roomID"][$i - 1];
            $roomName = $_POST["room_name"][$i - 1];
            $room_query = "update Rooms set roomType = '$roomName' where roomID = $roomID";
            if (!mysqli_query($con, $room_query)) {
                return false;
            }
        }
    }
    return true;
}

function getRoom_Per_floor($dormID) {

    require 'connection.php';

    $room_query = "select * from Floor f join RoomPerFloor rpf join Rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID group by rpf.roomID";
    $room_result = mysqli_query($con, $room_query);
    $colspan = mysqli_num_rows($room_result) + 1;
    echo '<input type="hidden" name="change_data">';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="background-color:#f9f9f9" colspan="' . $colspan . '"><h4 style="text-align:center">Room Per Floor</h4></th>';
    echo '</tr>';
    echo '<tr id="new_thead_input">';
    echo '<th>Floor</th>';
    while ($room_row = mysqli_fetch_array($room_result)) {
        echo '<th data-roomID="' . $room_row["roomID"] . '">' . $room_row["roomType"] . '</th>';
    }
    echo '</tr>';
    echo '</thead>';

    echo '<tbody id="new_tbody_input">';
    $query = "select * from Floor where dormID = $dormID";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $floorID = $row["floorID"];
        $floorNo = $row["floorNo"];
        $rpf_query = "select * from RoomPerFloor where floorID = $floorID";
        $rpf_result = mysqli_query($con, $rpf_query);

        echo '<tr id="floor' . $floorNo . '">';
        echo '<td style="text-align:center">' . $floorNo . '</td>';
        while ($rpf_row = mysqli_fetch_array($rpf_result)) {
            echo '<td><input type="number" class="form-control" name="floor' . $floorNo . '_roomtype[]" value="' . $rpf_row["roomPerFloor"] . '" data-matchingid="' . $rpf_row["matchingID"] . '"></td>';
            echo '<input type="hidden" name="floor' . $floorNo . '_roomtype_matchingID[]" value="' . $rpf_row["matchingID"] . '">';
        }
        echo '</tr>';
    }
    echo '</tbody>';
}

function getRoom_type($dormID) {

    require 'connection.php';

    $query = "select * from Floor f join RoomPerFloor rpf join Rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID group by rpf.roomID";
    $result = mysqli_query($con, $query);
    $number = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="input-group" style="width:95%;margin-bottom:3%"><span class="input-group-addon">Room Type ' . $number . '</span><input class="form-control" style="width:90%" type="text" value="' . $row["roomType"] . '" name="room_name[]"><input type="hidden" name="roomID[]" value="' . $row["roomID"] . '"></div>';
        $number = $number + 1;
    }
    echo '<input type="hidden" id="num_of_roomtype" value="' . $number . '">';
}

function edit_dorm() {

    require 'connection.php';

    $dormID = filter_var($_POST["dormID"], FILTER_SANITIZE_STRING);
    $type = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
    $distance = $_POST["distance"];
    $contract_length = $_POST["contract_length"];
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
    $total_floor = filter_var($_POST["total_floor"], FILTER_SANITIZE_STRING);
    $elec_price = filter_var($_POST["elec_price"], FILTER_SANITIZE_STRING);
    $water_price = filter_var($_POST["water_price"], FILTER_SANITIZE_STRING);

    $main_dorm_path = NULL;
    $plan_dorm_path = NULL;


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

    if (isset($_FILES["plan_dorm_pic"])) {
        if ($_FILES["plan_dorm_pic"]["name"] !== "") {
            if (move_uploaded_file($_FILES["plan_dorm_pic"]["tmp_name"], "images/dormitory_picture/plan_pic_" . $dormID . "_" . $_FILES["plan_dorm_pic"]["name"])) {
                $plan_dorm_path = "plan_pic_" . $dormID . "_" . $_FILES["plan_dorm_pic"]["name"];
            }
        }
    }

    if (isset($_FILES["change_plan_dorm_pic"])) {
        if ($_FILES["change_plan_dorm_pic"]["name"] !== "") {
            if (move_uploaded_file($_FILES["change_plan_dorm_pic"]["tmp_name"], "images/dormitory_picture/plan_pic_" . $dormID . "_" . $_FILES["change_plan_dorm_pic"]["name"])) {
                $plan_dorm_path = "plan_pic_" . $dormID . "_" . $_FILES["change_plan_dorm_pic"]["name"];
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

    if (isset($_FILES["change_dorm_pic"]) && isset($_POST["change_dorm_pic_id"])) {
        for ($i = 0; $i <= count($_FILES["change_dorm_pic"]); $i++) {
            if (isset($_FILES["change_dorm_pic"]["tmp_name"][$i]) && $_FILES["change_dorm_pic"]["name"][$i] !== "") {
                $pic_id = $_POST["change_dorm_pic_id"][$i];
                $msg = upPicture("change_dorm_pic", $i, $dormID);
                $pic_query = "update DormPic set dormPicPath = '$msg' where dormPicID = $pic_id ";
                mysqli_query($con, $pic_query);
            }
        }
    }

    $pic_main_path_query = $main_dorm_path === NULL ? "" : ", dorm_pictures = '$main_dorm_path'";
    $pic_plan_path_query = $plan_dorm_path === NULL ? "" : ", dorm_plan_pictures = '$plan_dorm_path'";

    $query = "update Dormitories set type= '$type', disFromUni = $distance , contractLength = $contract_length , addressNo = '$addressNO' , soi = '$soi' , road = '$road' , subDistinct = '$subdistinct' , dorm_distinct = '$distinct' , province = '$province' , zip = '$zip_code' , latitude = '$latitude' , longtitude = '$longtitude' , email = '$email' , total_floor = '$total_floor' , elec_price = $elec_price , water_price = $water_price , tel = '$tel'" . $pic_main_path_query . $pic_plan_path_query . " where dormID = $dormID ";

    if (add_floor() && mysqli_query($con, $query) && update_fac($dormID) && edit_bank($dormID)) {
        if (add_room_per_floor()) {
            echo '<script>alert("Edit Dormitory Success ");</script>';
            echo '<script>window.location = "index.php?chose_page=editDormitory&dormID=' . $dormID . '";</script>';
        } else {
            echo '<script>alert("Edit Dormitory Failed (Some Information Wrong)");</script>';
        }
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
            } else
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
    if (checkPermission($_GET["dormID"])) {



        require 'connection.php';
        if (isset($_POST["edit_dorm_submit"])) {
            if (filterPic($_FILES["dorm_pic"])) {
                edit_dorm();
            }
        }


        $query = "select * from Dormitories where dormID=" . $_GET["dormID"];
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
                            <br>
                            <h1>Edit Your Dormitory<br /><small>You can edit your dormitory information.
                                </small></h1><br>
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
                                <div class='col-lg-5'>
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
                                <div class='col-lg-5'>
                                    <?php if (!isset($row["total_floor"])) { ?>
                                        <div class="input-group">
                                            <span class="input-group-addon">Total Floor</span>
                                            <input class="form-control" id="total_floor" name="total_floor" type="number" value='<?php echo $row["total_floor"] ?>'>
                                        </div>
                                    <?php } else { ?>
                                        <div class="input-group">
                                            <span class="input-group-addon">Total Floor</span>
                                            <input class="form-control" id="total_floor" type="number" value='<?php echo $row["total_floor"] ?>' disabled>
                                            <input class="form-control" id="total_floor_hide" name="total_floor" type="hidden" value='<?php echo $row["total_floor"] ?>'>
                                        </div>
                                    <?php } ?>
                                </div>                                       
                            </div>
                            <br>
                            <div class="row">
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">Contract Length</span>
                                        <input class="form-control" min='0' name="contract_length" type="number" value='<?php echo $row["contractLength"] ?>'>
                                        <span class="input-group-addon">Month</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>

                                <?php if (!isset($row["total_floor"])) { ?>
                                    <div class="col-lg-3">
                                        <button class="btn1 btn1-default" type="button" id="add_roomtype">Add Room Type</button>
                                    </div>
                                    <div class="col-lg-9" id="roomtype_number">

                                    </div>
                                    <script>

                                        var room_number = 0;

                                        $(document).on("click", "#add_roomtype", function() {
                                            if ($("#total_floor").val() !== "") {
                                                if (room_number !== 0) {
                                                    $("#remove_room").remove();
                                                }
                                                room_number = room_number + 1;
                                                html = '<div class="input-group" style="width:95%;margin-bottom:3%" id="room' + room_number + '"><span class="input-group-addon">Room Type ' + room_number + '</span><input class="form-control" id="roomname_' + room_number + '" style="width:90%" name="roomtype_name[]" type="text" value="" placeholder="Room Type Name"><span id="remove_room" data-id="' + room_number + '" class="close">&times;</span></div>';
                                                $("#roomtype_number").append(html);
                                                document.getElementById("gen_table").setAttribute("style", "display:block");

                                            } else {
                                                alert("Please Input Total Floor");
                                            }
                                        });

                                        $(document).on("click", "#remove_room", function() {
                                            var id = "#room" + $(this).data("id");
                                            $(id).remove();
                                            room_number = room_number - 1;
                                            $("#room" + room_number).append('<span id="remove_room" data-id="' + room_number + '" class="close">&times;</span>');
                                            if (room_number === 0) {
                                                document.getElementById("gen_table").setAttribute("style", "display:none");
                                            }
                                        });

                                        $(document).on("click", "#gen_table", function() {
                                            $("#table_roomtype").html("");
                                            $("#table_thead").html("");
                                            $("#table_floor").html("");
                                            $("#table_thead").append("<tr><th colspan='" + (room_number + 1) + "'><h4 style='text-align:center'>Room Per Floor</h4></th></tr>");
                                            $("#table_thead").append("<tr id='table_roomtype'><th style='text-align:center'>Floor</th></tr>");

                                            total_floor = $("#total_floor").val();

                                            for (a = 1; a <= room_number; a++) {
                                                $("#table_roomtype").append("<th>" + $("#roomname_" + a).val() + "</th>");
                                            }
                                            for (b = 1; b <= total_floor; b++) {
                                                $("#table_floor").append("<tr id='floor" + b + "'><td style='text-align:center'> " + b + "</td>");
                                                for (c = 1; c <= room_number; c++) {
                                                    $("#floor" + b).append("<td><input type='number' name='floor" + b + "_roomtype[]' value='0' class='form-control'></td>");
                                                }
                                            }

                                            document.getElementById("input_table").setAttribute("style", "display:block");

                                        });



                                    </script>
                                <?php } else { ?>
                                    <div class="col-lg-3">
                                        <button class="btn1 btn1-default" type="button" id="addnew_roomtype">Add Room Type</button>
                                        <button class="btn1 btn1-default" type="button" id="add_floor" style="margin-top:5%;margin-bottom: 5%">Add Floor</button>
                                        <button class="btn1 btn1-default" type="button" id="remove_floor" style="display: none">Remove New Floor</button>
                                    </div>
                                    <div class="col-lg-9" id="roomtype_number">
                                        <?php getRoom_type($_GET["dormID"]) ?>
                                    </div>
                                    <script>

                                        var newroom_number = parseInt($("#num_of_roomtype").val());
                                        var oldroom_number = parseInt($("#num_of_roomtype").val());
                                        var total_floor = <?php echo $row["total_floor"] ?>;
                                        var original_floor = <?php echo $row["total_floor"] ?>;
                                        var new_total_floor = "";
                                        var new_floor = new Array();

                                        $(document).on("click", "#addnew_roomtype", function() {

                                            if (total_floor !== original_floor) {
                                                alert("Please Submit edit floor before add room type");
                                            } else {
                                                html = '<div class="input-group" style="width:95%;margin-bottom:3%" id="newroom' + newroom_number + '"><span class="input-group-addon">Room Type ' + newroom_number + '</span><input class="form-control" id="newroomname_' + newroom_number + '" style="width:90%" name="newroomtype_name[]" type="text" value="" placeholder="Room Type Name"><span id="remove_newroom" data-id="' + newroom_number + '" class="close">&times;</span></div>';
                                                $("#roomtype_number").append(html);
                                                $("#new_thead_input").append("<th id='roomtype" + newroom_number + "'>" + "Room Type " + newroom_number + "</th>");
                                                for (i = 1; i <= total_floor; i++) {
                                                    $("#floor" + i).append("<td id='floor" + i + "_newroom" + newroom_number + "'><input type='number' class='form-control' name='floor" + i + "_newroomtype[]'></td>");
                                                }
                                                newroom_number = newroom_number + 1;
                                                document.getElementById("submit_floor").setAttribute("style", "margin-left:40%;display:block");
                                            }
                                        });

                                        $(document).on("click", "#remove_newroom", function() {
                                            var id = "#newroom" + $(this).data("id");
                                            $(id).remove();
                                            newroom_number = newroom_number - 1;
                                            $("#newroom" + newroom_number).append('<span id="remove_room" data-id="' + newroom_number + '" class="close">&times;</span>');
                                            var roomtype_id = "#roomtype" + (newroom_number);
                                            $(roomtype_id).remove();
                                            for (i = 1; i <= total_floor; i++) {
                                                var floor_room_id = "#floor" + i + "_newroom" + (newroom_number);
                                                $(floor_room_id).remove();
                                            }
                                        });

                                        $(document).on("click", "#add_floor", function() {
                                            if (newroom_number === oldroom_number) {
                                                total_floor = total_floor + 1;
                                                $("#new_tbody_input").append("<tr id='floor" + total_floor + "'><td style='text-align:center'> " + total_floor + " <input type='hidden' name='new_floor[]'></td>");
                                                for (i = 1; i < newroom_number; i++) {
                                                    $("#floor" + total_floor).append("<td><input id='new_room_floor" + total_floor + "' type='number'name='floor" + total_floor + "_roomtype[]' class='form-control' value='0'></td>");
                                                }
                                                $("#new_tbody_input").append("</tr>");
                                                document.getElementById("remove_floor").setAttribute("style", "display:block");
                                                document.getElementById("total_floor").setAttribute("value", total_floor);
                                                document.getElementById("total_floor_hide").setAttribute("value", total_floor);
                                                $("#new_room_floor" + total_floor).focus();
                                                document.getElementById("submit_floor").setAttribute("style", "margin-left:40%;display:block");
                                            } else {
                                                alert("Please Submit edit room type before edit floor");
                                            }
                                        });

                                        $(document).on("click", "#remove_floor", function() {

                                            if (total_floor > original_floor) {
                                                $("#floor" + total_floor).remove();
                                                total_floor = total_floor - 1;
                                                document.getElementById("total_floor").setAttribute("value", total_floor);
                                                document.getElementById("total_floor_hide").setAttribute("value", total_floor);
                                                if (total_floor === original_floor) {
                                                    document.getElementById("remove_floor").setAttribute("style", "display:none");
                                                    document.getElementById("submit_floor").setAttribute("style", "display:none");
                                                }
                                            }


                                        });


                                    </script>
                                <?php } ?>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-lg-11">
                                    <button id="gen_table" class="btn1 btn-success pull-right" style="display:none" type="button">Generate Table</button>
                                </div>
                            </div>
                            <div class="row" style="margin-top:3%">
                                <div class="col-lg-12" style="margin-left:auto;margin-right: auto">
                                    <?php if (!isset($row["total_floor"])) { ?>
                                        <table id="input_table" class="table table-bordered" style="display:none">
                                            <thead id="table_thead">
                                                <tr id="table_roomtype"> 
                                                </tr>
                                            </thead>
                                            <tbody id="table_floor">
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <table class="table table-bordered" id="new_input_table">
                                            <?php getRoom_Per_floor($_GET["dormID"]); ?>
                                        </table>                                        
                                    <?php } ?> 
                                </div>
                            </div>
                            <button id="submit_floor" name="edit_dorm_submit" type="submit" class="btn1 btn1-success" style="margin-left:43%;display:none">Submit New Floor or New Room</button>
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
                                        <span class="input-group-addon">Sub District</span>
                                        <input id="subdistinct" class="form-control" type="text" name="sub_distinct" value='<?php echo $row["subDistinct"] ?>' >
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <div class="input-group">
                                        <span class="input-group-addon">District</span>
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
                                <div class='col-lg-3'>
                                    <div class="input-group">
                                        <button type="button" class="btn1 btn1-default" style="width:100%"><a target="blank_" href="https://www.google.com/maps/@13.6513616,100.4959106,17z?hl=en">Search Latitude,Longitude</a></button>
                                    </div>
                                </div>
                                <div class='col-lg-3'>
                                    <div class="input-group">
                                        <button type="button" data-target="#searchModal" data-toggle="modal" class="btn1 btn1-default" style="width:100%">How to search</button>
                                    </div>
                                    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-body">
                                                    <legend><h4>How to search</h4></legend>
                                                    <h5 style="text-align:left">1. Click <a href="https://www.google.com/maps/@13.6513616,100.4959106,17z?hl=en" target="blank_">Search Latitude , Longitude </a> Link.
                                                        <br>2. Searching your dormitory place.
                                                        <br>3. Right click to your dormitory place and chose Direction to here.
                                                        <br>4. Right click red point and chose What's here.
                                                        <br>5. Look at left top of page you will see Latitude and Longitude number.
                                                        <br>Example 13.651327,100.499111 <br> Latitude = 13.651327 <br> Longitude = 100.499111 </h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
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

                                    <div class='col-lg-12' style='margin-bottom:2%;'><p style='color:red'> * Default Status When Add Bank Account is Hiding. You can change status after bank account have been added</p></div>

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
                                        <div class="col-lg-12" style="margin-bottom:2%;">
                                            <?php if ($bank_row["bank_status"] === "Showing") { ?>
                                                <button type="button" class="btn1 btn1-success" id="hiding_click<?php echo $bank_row["bankID"] ?>">Now Showing on Page ( Click for Hiding )</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn1 btn1-danger" id="showing_click<?php echo $bank_row["bankID"] ?>">Now Hiding from Page ( Click for Showing )</button>
                                            <?php } ?>
                                        </div>
                                        <script>

                                            $(document).on("click", "#hiding_click<?php echo $bank_row["bankID"] ?>", function() {

                                                url = "callback.php?bank_show_status=Hiding&bank_id=<?php echo $bank_row["bankID"] ?>";
                                                $("#hiding_click<?php echo $bank_row["bankID"] ?>").load(url);
                                                document.getElementById("hiding_click<?php echo $bank_row["bankID"] ?>").setAttribute("class", "btn1 btn1-danger");
                                                document.getElementById("hiding_click<?php echo $bank_row["bankID"] ?>").setAttribute("id", "showing_click<?php echo $bank_row["bankID"] ?>");
                                                $("#showing_click<?php echo $bank_row["bankID"] ?>").html("Now Hiding on page ( Click for Showing )");
                                            });

                                            $(document).on("click", "#showing_click<?php echo $bank_row["bankID"] ?>", function() {

                                                url = "callback.php?bank_show_status=Showing&bank_id=<?php echo $bank_row["bankID"] ?>";
                                                $("#showing_click<?php echo $bank_row["bankID"] ?>").load(url);
                                                document.getElementById("showing_click<?php echo $bank_row["bankID"] ?>").setAttribute("class", "btn1 btn1-success");
                                                document.getElementById("showing_click<?php echo $bank_row["bankID"] ?>").setAttribute("id", "hiding_click<?php echo $bank_row["bankID"] ?>");
                                                $("#hiding_click<?php echo $bank_row["bankID"] ?>").html("Now Showing on page ( Click for Hiding )");
                                            });


                                        </script>
                                        <div class='col-lg-6'>
                                            <div class="input-group">
                                                <span class="input-group-addon">Bank Name</span>
                                                <input type="hidden" name="bank_id[]" value="<?php echo $bank_row["bankID"] ?>" >
                                                <select class="form-control" name="bank_name[]">
                                                    <option value="Bangkok Bank" <?php echo $bank_row["bankName"] === "Bangkok Bank" ? "selected" : ""; ?>>Bangkok Bank</option>
                                                    <option value="Krung Sri Bank" <?php echo $bank_row["bankName"] === "Krung Sri Bank" ? "selected" : ""; ?>>Krung Sri Bank</option>
                                                    <option value="Krung Thai Bank (KTB)" <?php echo $bank_row["bankName"] === "Krung Thai Bank (KTB)" ? "selected" : ""; ?>>Krung Thai Bank (KTB)</option>
                                                    <option value="Kasikorn Thai Bank (KBANK)" <?php echo $bank_row["bankName"] === "Kasikorn Thai Bank (KBANK)" ? "selected" : ""; ?>>Kasikorn Thai Bank (KBANK)</option>
                                                    <option value="Kaitnakin Bank" <?php echo $bank_row["bankName"] === "Kaitnakin Bank" ? "selected" : ""; ?>>Kaitnakin Bank</option>
                                                    <option value="CIMB Thai Bank" <?php echo $bank_row["bankName"] === "CIMB Thai Bank" ? "selected" : ""; ?>>CIMB Thai Bank</option>
                                                    <option value="Thai Military Bank (TMB)" <?php echo $bank_row["bankName"] === "Thai Military Bank (TMB)" ? "selected" : ""; ?>>Thai Military Bank (TMB)</option>
                                                    <option value="Tisco Bank" <?php echo $bank_row["bankName"] === "Tisco Bank" ? "selected" : ""; ?>>Tisco Bank</option>
                                                    <option value="Thai Credit Bank (TCR)" <?php echo $bank_row["bankName"] === "Thai Credit Bank (TCR)" ? "selected" : ""; ?>>Thai Credit Bank (TCR)</option>
                                                    <option value="Thanachart Bank" <?php echo $bank_row["bankName"] === "Thanachart Bank" ? "selected" : ""; ?>>Thanachart Bank</option>
                                                    <option value="Unitied Overseas Bank (UOB)" <?php echo $bank_row["bankName"] === "Unitied Overseas Bank (UOB)" ? "selected" : ""; ?>>Unitied Overseas Bank (UOB)</option>
                                                    <option value="Land and House Retail Bank (LHBANK)" <?php echo $bank_row["bankName"] === "Land and House Retail Bank (LHBANK)" ? "selected" : ""; ?>>Land and House Retail Bank (LHBANK)</option>
                                                    <option value="Standard Chartered" <?php echo $bank_row["bankName"] === "Standard Chartered" ? "selected" : ""; ?>>Standard Chartered</option>
                                                    <option value="SME Bank (SME)" <?php echo $bank_row["bankName"] === "SME Bank (SME)" ? "selected" : ""; ?>>SME Bank</option>
                                                    <option value="EXIM Thailand (EXIM)" <?php echo $bank_row["bankName"] === "EXIM Thailand (EXIM)" ? "selected" : ""; ?>>EXIM Thailand Bank</option>
                                                    <option value="Goverment Saving Bank (GSB)" <?php echo $bank_row["bankName"] === "Goverment Saving Bank (GSB)" ? "selected" : ""; ?>>Government Saving Bank (GSB)</option>
                                                    <option value="Islamic Bank of Thailand" <?php echo $bank_row["bankName"] === "Islamic Bank of Thailand" ? "selected" : ""; ?>>Islamic Bank of Thailand</option>
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
                                    $("#inputMore").append("<div class='row'><div class='col-lg-12' style='margin-bottom:2%;'><p style='color:red'> * Default Status When Add Bank Account is Hiding. You can change status after bank account have been added</p></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Name</span><select class='form-control' name='new_bank_name[]'><option value='Bangkok Bank'>Bangkok Bank</option><option value='Krung Sri Bank'>Krung Sri Bank</option><option value='Krung Thai Bank (KTB)'>Krung Thai Bank (KTB)</option><option value='Kasikorn Thai Bank (KBANK)'>Kasikorn Thai Bank (KBANK)</option><option value='Kaitnakin Bank'>Kaitnakin Bank</option><option value='CIMB Thai Bank'>CIMB Thai Bank</option><option value='Thai Military Bank (TMB)'>Thai Military Bank (TMB)</option><option value='Tisco Bank'>Tisco Bank</option><option value='Thai Credit Bank (TCR)'>Thai Credit Bank (TCR)</option><option value='Thanachart Bank'>Thanachart Bank</option><option value='Unitied Overseas Bank (UOB)'>Unitied Overseas Bank (UOB)</option><option value='Land and House Retail Bank (LHBANK)'>Land and House Retail Bank (LHBANK)</option><option value='Standard Chartered'>Standard Chartered</option><option value='SME Bank (SME)'>SME Bank</option><option value='EXIM Thailand (EXIM)'>EXIM Thailand Bank</option><option value='Goverment Saving Bank (GSB)'>Government Saving Bank (GSB)</option><option value='Islamic Bank of Thailand'>Islamic Bank of Thailand</option></select></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Branch</span><input class='form-control' type='text' name='new_bank_branch[]' value='' /></div></div></div><br><div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account Name</span><input class='form-control' type='text' name='new_bank_acc_name[]' value=''/></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account ID</span><input class='form-control' type='text' name='new_bank_acc_id[]' value='' /></div></div></div><br>");
                                    morebank = morebank + 1;
                                });

                                $(document).on("click", "#Remove_moreBank", function() {

                                    $("#inputMore").html("");
                                    for (i = 1; i < morebank; i++) {
                                        $("#inputMore").append("<div class='row'><div class='col-lg-12' style='margin-bottom:2%;'><p style='color:red'> * Default Status When Add Bank Account is Hiding. You can change status after bank account have been added</p></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Name</span><select class='form-control' name='new_bank_name[]'><option value='Bangkok Bank'>Bangkok Bank</option><option value='Krung Sri Bank'>Krung Sri Bank</option><option value='Krung Thai Bank (KTB)'>Krung Thai Bank (KTB)</option><option value='Kasikorn Thai Bank (KBANK)'>Kasikorn Thai Bank (KBANK)</option><option value='Kaitnakin Bank'>Kaitnakin Bank</option><option value='CIMB Thai Bank'>CIMB Thai Bank</option><option value='Thai Military Bank (TMB)'>Thai Military Bank (TMB)</option><option value='Tisco Bank'>Tisco Bank</option><option value='Thai Credit Bank (TCR)'>Thai Credit Bank (TCR)</option><option value='Thanachart Bank'>Thanachart Bank</option><option value='Unitied Overseas Bank (UOB)'>Unitied Overseas Bank (UOB)</option><option value='Land and House Retail Bank (LHBANK)'>Land and House Retail Bank (LHBANK)</option><option value='Standard Chartered'>Standard Chartered</option><option value='SME Bank (SME)'>SME Bank</option><option value='EXIM Thailand (EXIM)'>EXIM Thailand Bank</option><option value='Goverment Saving Bank (GSB)'>Government Saving Bank (GSB)</option><option value='Islamic Bank of Thailand'>Islamic Bank of Thailand</option></select></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Branch</span><input class='form-control' type='text' name='new_bank_branch[]' value='' /></div></div></div><br><div class='row'><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account Name</span><input class='form-control' type='text' name='new_bank_acc_name[]' value=''/></div></div><div class='col-lg-6'><div class='input-group'><span class='input-group-addon'>Bank Account ID</span><input class='form-control' type='text' name='new_bank_acc_id[]' value='' /></div></div></div><br>");
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
                                            Water Price
                                        </span>
                                        <input type="number" min="0" name='water_price' class="form-control" value="<?php echo $row["water_price"] ?>">
                                        <span class="input-group-addon" >
                                            Baht / Unit
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            WiFi
                                        </span>
                                        <input type="text" name='wifi_detail' placeholder='Eg. 599 Baht per month (10 Mbps)' class="form-control" value="<?php echo $fac_row["wifiDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='wifi' <?php echo $fac_row["wifi"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Room Clean Service
                                        </span>
                                        <input type="text" name='room_clean_detail' placeholder='Eg. 200 Baht per time' class="form-control" value="<?php echo $fac_row["roomCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='room_clean_service' <?php echo $fac_row["roomCleanService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Washing Machine
                                        </span>
                                        <input type="text" name="washing_service_detail" placeholder='Eg. 40 Bath per time' class="form-control" value="<?php echo $fac_row["washingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='washing_service' <?php echo $fac_row["washingService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Vending Machine
                                        </span>
                                        <input type="text" name="vending_detail" placeholder='Eg. 3 Vending Machine on first floor' class="form-control" value="<?php echo $fac_row["vendingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="vending_machine" <?php echo $fac_row["vendingMachine"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Restaurant
                                        </span>
                                        <input type="text" name="restaurant_detail" placeholder='Eg. Cheap, Delicious' class="form-control" value="<?php echo $fac_row["restaurantDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="restaurant" <?php echo $fac_row["restaurant"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Swimming Pool
                                        </span>
                                        <input type="text" name="pool_detail" placeholder='Eg. Medium pool on first floor' class="form-control" value="<?php echo $fac_row["poolDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="swimming_pool" <?php echo $fac_row["pool"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Car Parking
                                        </span>
                                        <input type="text" name="parking_detail" placeholder='Eg. 200 Bath / month / car or FREE' class="form-control" value="<?php echo $fac_row["parkingDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="parking" <?php echo $fac_row["parking"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>

                                <div class="span5">
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Electrical Charge
                                        </span>
                                        <input type="number" min="0" name='elec_price' class="form-control" value="<?php echo $row["elec_price"] ?>">
                                        <span class="input-group-addon" >
                                            Baht / Unit
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Lan
                                        </span>
                                        <input type="text" name="lan_detail" placeholder='Eg. Two port per room' class="form-control" value="<?php echo $fac_row["lanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="lan" <?php echo $fac_row["lan"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Air Clean Service
                                        </span>
                                        <input type="text" name="air_clean_detail" placeholder='Eg. Free of charge per year' class="form-control" value="<?php echo $fac_row["airCleanDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="air_clean_service" <?php echo $fac_row["airCleanService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Laundry
                                        </span>
                                        <input type="text" name="laundry_detail" placeholder='Eg. 7 Bath per piece' class="form-control" value="<?php echo $fac_row["laundryDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="laundry" <?php echo $fac_row["laundry"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bus Service
                                        </span>
                                        <input type="text" name="bus_detail" placeholder='Eg. Free of charge' class="form-control" value="<?php echo $fac_row["busDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="bus_service" <?php echo $fac_row["busService"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fitness
                                        </span>
                                        <input type="text" name="fitness_detail" placeholder='Eg. 1000 Baht per month' class="form-control" value="<?php echo $fac_row["fitnessDetails"] ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name="fitness" <?php echo $fac_row["fitness"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            CCTV
                                        </span>
                                        <input type="text" name="cctv_detail" placeholder='Eg. 3 cctv per floor' class="form-control" value="<?php echo $fac_row["cctvDetails"] ?>">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="cctv" <?php echo $fac_row["cctv"] == 1 ? "checked" : ""; ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Elevator
                                        </span>
                                        <input type="text" name="elevator_detail" placeholder='Eg. 2 Elevator' class="form-control" value="<?php echo $fac_row["elevatorDetails"] ?>">
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
                                <div class="span12" style="margin-top:5%">
                                    <?php if (isset($row["dorm_plan_pictures"]) && $row["dorm_plan_pictures"] !== "") { ?>
                                        <div class="span3">
                                            <h4>Dormitory Plan Picture :</h4><br>
                                            <p>Change Dormitory Plan Picture</p>
                                            <input style='width:100%' class="form-control" name="change_plan_dorm_pic" type="file" placeholder="" multipart/>
                                        </div>

                                        <div class="span8 center">
                                            <img style="width:405px;height: 250px" class="img-thumbnail" src="images/dormitory_picture/<?php echo $row["dorm_plan_pictures"]; ?>">
                                        </div>
                                    <?php } else { ?>
                                        <label>Dormitory Plan Picture : &nbsp;&nbsp;&nbsp;
                                            <input style='width:50%' class="form-control" name="plan_dorm_pic" type="file" placeholder="" required/>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div><br><br>
                            <div class='row'>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <legend><span>Dormitory View</span> Pictures</legend>
                                    </div>
                                    <?php
                                    for ($i = 0; $i < mysqli_num_rows($pic_result); $i++) {
                                        $pic_row = mysqli_fetch_array($pic_result);
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 280px">
                                            <label>Picture <?php echo $i + 1; ?> ( change picture )
                                                <input type="file" class="form-control" name="change_dorm_pic[]">
                                                <input type="hidden" name="change_dorm_pic_id[]" value="<?php echo $pic_row["dormPicID"]; ?>">
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
                                        <div class="col-md-4" style="width:250px;height: 280px">
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
                                    <button name="edit_dorm_submit" type="submit" class="btn1 btn1-success pull-right" style="margin-left:15px;margin-top: 50px;margin-bottom: 50px;width: 25%">Submit</button>
                                    <a href="index.php?chose_page=ownersystem" class="btn1 btn1-danger pull-right" style="margin-top: 50px;margin-bottom: 50px;width: 25%">Back</a>
                                    <br><br>
                                </div>

                            </div>
                        </fieldset>
                    </form>
                    <?php
                } else {
                    echo '<script> alert("Permission Denied");</script>';
                    echo '<script> window.location = "index.php?chose_page=ownersystem"</script>';
                }
            } else {
                ?>
            </div>
            <h1>Something Error</h1>
        <?php } ?>
    </div>

</div>
</div></div></div><!-- /container -->