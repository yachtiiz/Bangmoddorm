
<?php

function upPicture($file, $i, $roomID) {

    if ($_FILES["$file"]["type"][$i] == "image/jpg" || $_FILES["$file"]["type"][$i] == "image/png" || $_FILES["$file"]["type"][$i] == "image/jpeg" || $_FILES["$file"]["type"][$i] == "image/gif" || $_FILES["$file"]["type"][$i] == "image/pjpeg" || $_FILES["$file"]["type"][$i] == "image/x-png") {


        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
        $path = "images/room_pictures/" . $rand . "_" . $roomID . "_" . $_FILES["$file"]["name"][$i];
        $pic_path = $rand . "_" . $roomID . "_" . $_FILES["$file"]["name"][$i];

        if (move_uploaded_file($_FILES["$file"]["tmp_name"][$i], $path)) {
            return $msg = $pic_path;
        } else {
            return $msg = "Cant Upload";
        }
    } else {
        return $msg = "Invalid Picture";
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

function add_fac_room($roomID) {

    require 'connection.php';

    $air = isset($_POST["air"]) ? ($_POST["air"] == "on" ? 1 : 0) : 0;
    $wardrobe = isset($_POST["wardrobe"]) ? ($_POST["wardrobe"] == "on" ? 1 : 0) : 0;
    $refrigerator = isset($_POST["refrigerator"]) ? ($_POST["refrigerator"] == "on" ? 1 : 0) : 0;
    $table = isset($_POST["table"]) ? ($_POST["table"] == "on" ? 1 : 0) : 0;
    $chair = isset($_POST["chair"]) ? ($_POST["chair"] == "on" ? 1 : 0) : 0;
    $fan = isset($_POST["fan"]) ? ($_POST["fan"] == "on" ? 1 : 0) : 0;
    $water_heater = isset($_POST["water_heater"]) ? ($_POST["water_heater"] == "on" ? 1 : 0) : 0;
    $bed = isset($_POST["bed"]) ? ($_POST["bed"] == "on" ? 1 : 0) : 0;
    $mattress = isset($_POST["mattress"]) ? ($_POST["mattress"] == "on" ? 1 : 0) : 0;
    $television = isset($_POST["television"]) ? ($_POST["television"] == "on" ? 1 : 0) : 0;

    $air_detail = filter_var($_POST["air_detail"], FILTER_SANITIZE_STRING);
    $wardrobe_detail = filter_var($_POST["wardrobe_detail"], FILTER_SANITIZE_STRING);
    $refrigerator_detail = filter_var($_POST["refrigerator_detail"], FILTER_SANITIZE_STRING);
    $table_detail = filter_var($_POST["table_detail"], FILTER_SANITIZE_STRING);
    $chair_detail = filter_var($_POST["chair_detail"], FILTER_SANITIZE_STRING);
    $fan_detail = filter_var($_POST["fan_detail"], FILTER_SANITIZE_STRING);
    $water_heater_detail = filter_var($_POST["water_heater_detail"], FILTER_SANITIZE_STRING);
    $bed_detail = filter_var($_POST["bed_detail"], FILTER_SANITIZE_STRING);
    $mattress_detail = filter_var($_POST["mattress_detail"], FILTER_SANITIZE_STRING);
    $television_detail = filter_var($_POST["television_detail"], FILTER_SANITIZE_STRING);



    $query = "update FacilitiesInRoom set air = $air , airDetails = '$air_detail' , wardrobe = $wardrobe , wardrobeDetails = '$wardrobe_detail' , refrigerator = $refrigerator , refrigeratorDetails = '$refrigerator_detail' , table_fac = $table , tableDetails = '$table_detail' , 
                chair = $chair , chairDetails = '$chair_detail' , fan = $fan , fanDetails = '$fan_detail' , waterHeater = $water_heater , waterHeaterDetails = '$water_heater_detail' , bed = $bed , bedDetails = '$bed_detail' , mattress = $mattress , mattressDetails = '$mattress_detail'
                    , television = $television ,  televisionDetails = '$television_detail' where roomID = $roomID;";

    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

function add_room($dormID) {

    require "connection.php";

    $room_type = filter_var($_POST["room_type"], FILTER_SANITIZE_STRING);
    $areas = filter_var($_POST["areas"], FILTER_SANITIZE_NUMBER_FLOAT);
    $price = filter_var($_POST["price"], FILTER_SANITIZE_STRING);
    $number_of_room = filter_var($_POST["number_of_room"], FILTER_SANITIZE_STRING);
    $room_available = filter_var($_POST["room_available"], FILTER_SANITIZE_NUMBER_INT);
    $room_deposit = filter_var($_POST["room_deposit"], FILTER_SANITIZE_NUMBER_INT);

    $main_pic_path = "default_picture.jpg";

    if ($_FILES["room_main_pic"]["name"] !== "") {
        if (move_uploaded_file($_FILES["room_main_pic"]["tmp_name"], "images/room_pictures/main_pic_" . $dormID . "_" . $_FILES["room_main_pic"]["name"])) {
            $main_pic_path = "main_pic_" . $dormID . "_" . $_FILES["room_main_pic"]["name"];
        }
    }



    $query = "INSERT INTO `Rooms` (`dormID`, `roomType`, `areas`, `price`, `numOfRoom`, `roomAvailable`, `roomDeposit` , `status` , `main_pic`)
VALUES ( $dormID, '$room_type', $areas , $price , $number_of_room , $room_available , $room_deposit , 'Active' , '$main_pic_path');";

    if (mysqli_query($con, $query)) {

        $query = "select max(roomID) from Rooms";
        $id_result = mysqli_query($con, $query);
        $id_row = mysqli_fetch_array($id_result);

        $fac_query = "INSERT INTO `FacilitiesInRoom` (`roomID`)VALUES ($id_row[0]);";

        for ($i = 0; $i <= count($_FILES["room_pic"]); $i++) {
            if ($_FILES["room_pic"]["name"][$i] !== "") {
                $pic_path = upPicture("room_pic", $i, $id_row[0]);
                $pic_query = "INSERT INTO `RoomPic` (`roomID`, `roomPicPath`) VALUES ($id_row[0], '$pic_path');";
                if (!mysqli_query($con, $pic_query)) {
                    return "Add Pic Fail";
                }
            }
        }
        if (mysqli_query($con, $fac_query)) {
            if (add_fac_room($id_row[0])) {
                return "Add Complete.";
            } else {
                return "Add Fac Fail.";
            }
        } else {
            return "Add FacInRoom Failed.";
        }
    } else {
        return "Add Room Failed.";
    }
}

function edit_room($roomID) {

    require 'connection.php';

    $room_type = filter_var($_POST["room_type"], FILTER_SANITIZE_STRING);
    $areas = filter_var($_POST["areas"], FILTER_SANITIZE_NUMBER_FLOAT);
    $price = filter_var($_POST["price"], FILTER_SANITIZE_STRING);
    $number_of_room = filter_var($_POST["number_of_room"], FILTER_SANITIZE_STRING);
    $room_available = filter_var($_POST["room_available"], FILTER_SANITIZE_NUMBER_INT);
    $room_deposit = filter_var($_POST["room_deposit"], FILTER_SANITIZE_NUMBER_INT);
    $main_room_path = NULL;

    if (isset($_FILES["change_main_room_pic"])) {
        if ($_FILES["change_main_room_pic"]["name"] !== "") {
            if (move_uploaded_file($_FILES["change_main_room_pic"]["tmp_name"], "images/room_pictures/main_pic_" . $roomID . "_" . $_FILES["change_main_room_pic"]["name"])) {
                $main_room_path = "main_pic_" . $roomID . "_" . $_FILES["change_main_room_pic"]["name"];
            }
        }
    }

    if (isset($_FILES["main_room_pic"])) {
        if ($_FILES["main_room_pic"]["name"] !== "") {
            if (move_uploaded_file($_FILES["main_room_pic"]["tmp_name"], "images/room_pictures/main_pic_" . $roomID . "_" . $_FILES["main_room_pic"]["name"])) {
                $main_room_path = "main_pic_" . $roomID . "_" . $_FILES["main_room_pic"]["name"];
            }
        }
    }

    if (isset($_FILES["room_pic"])) {
        for ($i = 0; $i <= count($_FILES["room_pic"]); $i++) {
            if (isset($_FILES["room_pic"]["tmp_name"][$i]) && $_FILES["room_pic"]["name"][$i] !== "") {
                $msg = upPicture("room_pic", $i, $roomID);
                $pic_query = "INSERT INTO `RoomPic` (`roomID`, `roomPicPath`) VALUES ($roomID, '$msg');";
                mysqli_query($con, $pic_query);
            }
        }
    }


    $pic_main_path_query = $main_room_path === NULL ? "" : ", main_pic = '$main_room_path'";
    $query = "update rooms set roomType = '$room_type' , areas = $areas , price = $price , numOfRoom = $number_of_room , roomAvailable = $room_available , roomDeposit = $room_deposit " . $pic_main_path_query . " where roomID = $roomID;";



    if (mysqli_query($con, $query)) {
        if (add_fac_room($roomID)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if (isset($_GET["dormName"]) && isset($_GET["dormID"])) {
    if (isset($_GET["roomID"]) && is_numeric($_GET["roomID"])) {

        require 'connection.php';
        $roomID = $_GET["roomID"];
        $query = "select * from Rooms where roomID = $roomID";
        $result = mysqli_query($con, $query);
        $room_row = mysqli_fetch_array($result);

        $fac_room_query = "select * from FacilitiesInRoom where roomID = $roomID";
        $fac_room_result = mysqli_query($con, $fac_room_query);
        $fac_room_row = mysqli_fetch_array($fac_room_result);
    }

    if (isset($_POST["edit_submit"])) {
        if (isset($_POST["roomID"]) && is_numeric($_POST["roomID"]) && $_POST["roomID"] !== "") {
            if (edit_room($_POST["roomID"])) {
                echo '<script>alert("Edit Room Success");</script>';
                echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
            } else {
                echo '<script>alert("Edit Room Failed");</script>';
                echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
            }
        } else {
            $msg = add_room($_POST["dormID"]);
            if ($msg == "Add Complete") {
                echo '<script>alert("Add Room Complete");</script>';
                echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
            } else {
                echo '<script>alert("' . $msg . '");</script>';
                echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
            }
        }
    }
    ?>

    <script>

        $(document).ready(function() {

            $("#form").validate({
                rules: {
                    areas: {
                        checkSpecial: true,
                        required: true,
                        number: true
                    },
                    price: {
                        required: true,
                        checkSpecial: true,
                        number: true
                    },
                    room_type: {
                        required: true,
                        checkSpecial: true,
                    },
                    room_available: {
                        required: true,
                        checkSpecial: true,
                        number: true
                    },
                    number_of_room: {
                        required: true,
                        checkSpecial: true,
                        number: true
                    }

                }
            });
        });


    </script>

    <div class="row booking_summary">
        <div class="span12">	
            <div class="row">
                <div class="span10">
                    <form id="form" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <fieldset>

                            <h1>Add Your Room Type<br /><small>You can add your room type and fill the information.
                                </small></h1><br />
                            <div class="row">

                                <div class="span10">
                                    <legend><span>Dormitory </span>Information</legend>
                                </div>

                                <div class="span3">
                                    <label>Dormitory Name
                                        <input disabled value="<?php echo $_GET["dormName"]; ?>" type="text" class="form-control" />
                                        <input type="hidden" name="dormID" value="<?php echo $_GET["dormID"]; ?>">
                                        <input type="hidden" name="roomID" value="<?php echo isset($_GET["roomID"]) ? $_GET["roomID"] : "" ?>">
                                    </label>
                                </div>		
                            </div>		
                            <br />
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Room</span> Information</legend>
                                </div>

                                <div class="span3">
                                    <label>Room Name
                                        <input class="form-control" type="text" name="room_type" value='<?php echo isset($room_row["roomType"]) ? $room_row["roomType"] : "" ?>'>
                                    </label>
                                    <label>Number Of Room
                                        <input type="text" class="form-control" name="number_of_room" value='<?php echo isset($room_row["numOfRoom"]) ? $room_row["numOfRoom"] : "" ?>'>
                                    </label>
                                </div>				

                                <div class="span3">
                                    <label>Areas
                                        <input type="text" class="form-control" name="areas" value='<?php echo isset($room_row["areas"]) ? $room_row["areas"] : "" ?>' />
                                    </label>
                                    <label>Room Avaliable
                                        <input type="text" class="form-control" name="room_available" value='<?php echo isset($room_row["roomAvailable"]) ? $room_row["roomAvailable"] : "" ?>'/>
                                    </label>
                                </div>

                                <div class="span3">
                                    <label>Price
                                        <input type="text" class="form-control" name="price" value='<?php echo isset($room_row["price"]) ? $room_row["price"] : "" ?>' />
                                    </label>
                                    <label>Room Deposit
                                        <select class="form-control" name="room_deposit">
                                            <option value="0">Chose Your Room Deposit</option>
                                            <option value="0" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 0 ? "selected" : ""  : "" ?>>No Room Deposit</option>
                                            <option value="1" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 1 ? "selected" : ""  : "" ?>>1 Month</option>
                                            <option value="2" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 2 ? "selected" : ""  : "" ?>>2 Month</option>
                                            <option value="3" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 3 ? "selected" : ""  : "" ?>>3 Month</option>
                                            <option value="4" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 4 ? "selected" : ""  : "" ?>>4 Month</option>
                                            <option value="5" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 5 ? "selected" : ""  : "" ?>>5 Month</option>
                                            <option value="6" <?php echo isset($room_row["roomDeposit"]) ? $room_row["roomDeposit"] == 6 ? "selected" : ""  : "" ?>>6 Month</option>
                                        </select>
                                    </label>
                                </div>

                            </div>  
                            <br />

                            <div class="row">

                                <div class="span10">
                                    <legend><span>Room </span>Facilities</legend>
                                </div>		

                                <div class="span5">

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Air Condition
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="air_detail" value="<?php echo isset($fac_room_row["airDetails"]) ? $fac_room_row["airDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='air' <?php echo isset($fac_room_row["air"]) ? ($fac_room_row["air"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Refrigrator
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="refrigerator_detail" value="<?php echo isset($fac_room_row["refrigeratorDetails"]) ? $fac_room_row["refrigeratorDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='refrigerator' <?php echo isset($fac_room_row["refrigerator"]) ? ($fac_room_row["refrigerator"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Chair
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="chair_detail" value="<?php echo isset($fac_room_row["chairDetails"]) ? $fac_room_row["chairDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='chair' <?php echo isset($fac_room_row["chair"]) ? ($fac_room_row["chair"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Water Heater
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="water_heater_detail" value="<?php echo isset($fac_room_row["waterHeaterDetails"]) ? $fac_room_row["waterHeaterDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='water_heater' <?php echo isset($fac_room_row["waterHeater"]) ? ($fac_room_row["waterHeater"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fan
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="fan_detail" value="<?php echo isset($fac_room_row["fanDetails"]) ? $fac_room_row["fanDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='fan' <?php echo isset($fac_room_row["fan"]) ? ($fac_room_row["fan"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>

                                <div class="span5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Wardrobe
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="wardrobe_detail" value="<?php echo isset($fac_room_row["wardrobeDetails"]) ? $fac_room_row["wardrobeDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='wardrobe' <?php echo isset($fac_room_row["wardrobe"]) ? ($fac_room_row["wardrobe"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Table
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="table_detail" value="<?php echo isset($fac_room_row["tableDetails"]) ? $fac_room_row["tableDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='table' <?php echo isset($fac_room_row["table_fac"]) ? ($fac_room_row["table_fac"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bed
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="bed_detail" value="<?php echo isset($fac_room_row["bedDetails"]) ? $fac_room_row["bedDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='bed' <?php echo isset($fac_room_row["bed"]) ? ($fac_room_row["bed"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Mattress
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="mattress_detail" value="<?php echo isset($fac_room_row["mattressDetails"]) ? $fac_room_row["mattressDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='mattress' <?php echo isset($fac_room_row["mattress"]) ? ($fac_room_row["mattress"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Television
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control" name="television_detail" value="<?php echo isset($fac_room_row["televisionDetails"]) ? $fac_room_row["televisionDetails"] : "" ?>">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='television' <?php echo isset($fac_room_row["television"]) ? ($fac_room_row["television"] == 1 ? "checked" : "") : "" ?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>
                            </div>                                
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Room</span> Picture</legend>
                                </div>

                                <div class="span10">
                                    <?php if (isset($room_row["main_pic"]) && $room_row["main_pic"] !== "") { ?>
                                        <div class="span3">
                                            <h4>Main Picture :</h4><br>
                                            <p>Change Main Picture</p>
                                            <input style='width:100%' class="form-control" name="change_main_room_pic" type="file" placeholder=""/>
                                        </div>
                                        <div class="span5 pull-right" >
                                            <img src="images/room_pictures/<?php echo $room_row["main_pic"]; ?>"
                                        </div>
                                    <?php } else { ?>
                                        <label>Main Picture : &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input class="form-control" style="width: 50%" name="room_main_pic" type="file" placeholder="" required />
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-10" style="margin-left:10px">
                                    <legend><span>Screen</span> Shot</legend>
                                </div>
                                <?php
                                if (isset($_GET["roomID"]) && is_numeric($_GET["roomID"])) {
                                    $roomID = $_GET["roomID"];
                                    $pic_query = "select * from RoomPic where roomID = $roomID";
                                    $pic_result = mysqli_query($con, $pic_query);
                                    for ($i = 0; $i < mysqli_num_rows($pic_result); $i++) {
                                        $pic_row = mysqli_fetch_array($pic_result);
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 250px;margin-left:10px">
                                            <label>Picture <?php echo $i + 1; ?>
                                                <?php if ($pic_row["roomPicPath"] !== "") { ?>
                                                    <img class="img-thumbnail" style="width:250px;height: 224px" style="" src="images/room_pictures/<?php echo $pic_row["roomPicPath"]; ?>">
                                                <?php } else { ?>
                                                    <input class="form-control" name="room_pic[]" type="file" placeholder=""/>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                    <?php for ($i = mysqli_num_rows($pic_result); $i < 6; $i++) {
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 250px;margin-left:10px">
                                            <label>Picture <?php echo $i + 1 ?>
                                                <input class="form-control" name="room_pic[]" type="file" />
                                            </label>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <?php for ($i = 1; $i <= 6; $i++) {
                                        ?>
                                        <div class="col-md-4" style="width:250px;height: 250px;margin-left:20px">
                                            <label>Picture <?php echo $i ?>
                                                <input class="form-control" name="room_pic[]" type="file" />
                                            </label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <br />
                            <div class="row">
                                <div class="span10">
                                    <br />
                                    <button type='submit' name='edit_submit' class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                    <a href="callback.php?disabled_room=<?php echo $_GET["roomID"]; ?>" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Delete Room</a>
                                    <a href="index.php?chose_page=ownersystem" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                    <br><br>
                                    <br />
                                    <br />
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>

        </div></div> <!-- /container -->
    </div>
<?php } else { ?>
    <h1>Something Error</h1>
<?php } ?>
