
<?php

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

    $query = "update FacilitiesInRoom set air = $air , wardrobe = $wardrobe , refrigerator = $refrigerator , table_fac = $table , 
                chair = $chair , fan = $fan , waterHeater = $water_heater , bed = $bed , mattress = $mattress , television = $television where roomID = $roomID;";

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
    $room_reserve = filter_var($_POST["room_reserve"], FILTER_SANITIZE_NUMBER_INT);

    $query = "INSERT INTO `Rooms` (`dormID`, `roomType`, `areas`, `price`, `numOfRoom`, `roomAvailable`, `roomReserve`)
VALUES ( $dormID, '$room_type', $areas , $price , $number_of_room , $room_available , $room_reserve);";

    if (mysqli_query($con, $query)) {
        $query = "select max(roomID) from Rooms";
        $id_result = mysqli_query($con, $query);
        $id_row = mysqli_fetch_array($id_result);

        $fac_query = "INSERT INTO `FacilitiesInRoom` (`roomID`)VALUES ($id_row[0]);";
        if (mysqli_query($con, $fac_query)) {
            if (add_fac_room($id_row[0])) {
                return "Add Complete";
            } else {
                return "Add Fac Fail";
            }
        } else {
            return "Add FacInRoom Failed";
        }
    } else {
        return "Add Room Failed";
    }
}

function edit_room($roomID) {

    require 'connection.php';

    $room_type = filter_var($_POST["room_type"], FILTER_SANITIZE_STRING);
    $areas = filter_var($_POST["areas"], FILTER_SANITIZE_NUMBER_FLOAT);
    $price = filter_var($_POST["price"], FILTER_SANITIZE_STRING);
    $number_of_room = filter_var($_POST["number_of_room"], FILTER_SANITIZE_STRING);
    $room_available = filter_var($_POST["room_available"], FILTER_SANITIZE_NUMBER_INT);
    $room_reserve = filter_var($_POST["room_reserve"], FILTER_SANITIZE_NUMBER_INT);

    $query = "update rooms set roomType = '$room_type' , area = $areas , price = $price , numOfRoom = $number_of_room , roomAvailable = $room_available , roomReserve = $room_reserve where roomID = $roomID;";

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
        }
        $msg = add_room($_POST["dormID"]);
        if ($msg == "Add Complete" ) {
            echo '<script>alert("Add Room Complete");</script>';
            echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
        } else {
            echo '<script>alert("'.$msg.'");</script>';
            echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
        }
    }
    ?>

    <div class="row booking_summary">
        <div class="span12">	
            <div class="row">
                <div class="span10">
                    <form action="" method="post" class="form-horizontal">
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
                                    <label>Room Reserve
                                        <input type="text" class="form-control" name="room_reserve" value='<?php echo isset($room_row["roomReserve"]) ? $room_row["roomReserve"] : "" ?>' />
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
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='air' <?php echo isset($fac_room_row["air"]) ? ($fac_room_row["air"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Refrigrator
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='refrigerator' <?php echo isset($fac_room_row["refrigerator"]) ? ($fac_room_row["refrigerator"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Chair
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='chair' <?php echo isset($fac_room_row["chair"]) ? ($fac_room_row["chair"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Water Heater
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='water_heater' <?php echo isset($fac_room_row["waterHeater"]) ? ($fac_room_row["waterHeater"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fan
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='fan' <?php echo isset($fac_room_row["fan"]) ? ($fac_room_row["fan"] == 1 ? "checked":""):""?>>
                                        </span>
                                    </div>
                                    <br>


                                </div>

                                <div class="span5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Wardrobe
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='wardrobe' <?php echo isset($fac_room_row["wardrobe"]) ? ($fac_room_row["wardrobe"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Table
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='table' <?php echo isset($fac_room_row["table_fac"]) ? ($fac_room_row["table_fac"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bed
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='bed' <?php echo isset($fac_room_row["bed"]) ? ($fac_room_row["bed"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Mattress
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='mattress' <?php echo isset($fac_room_row["mattress"]) ? ($fac_room_row["mattress"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Television
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox" name='television' <?php echo isset($fac_room_row["television"]) ? ($fac_room_row["television"] == 1 ? "checked":""):"" ?>>
                                        </span>
                                    </div>
                                    <br>
                                </div>
                            </div>                                
                            <div class="row">
                                <div class="span10">
                                    <legend><span>Room</span> Picture</legend>
                                </div>
                                <div class="span4">
                                    <label>Picture1 
                                        <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture2
                                        <input class="form-control" name="room_pic[]" type="file" placeholder=""/>
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture3 
                                        <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture4 
                                        <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture5 
                                        <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                                <div class="span4">
                                    <label>Picture6 
                                        <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                    </label>
                                </div>
                            </div>
                            <br />


                            <div class="row">
                                <div class="span10">
                                    <br />
                                    <button type='submit' name='edit_submit' class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                    <a href="index.php?chose_page=ownersystem" class="btn btn-primary btn-large book-now pull-right">Back</a>

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
