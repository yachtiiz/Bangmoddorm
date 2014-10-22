
<?php

function reduce_room($matchingID) {

    require 'connection.php';

    $query = "select roomPerFloor from RoomPerFloor where matchingID = $matchingID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL) {
        $available_room = $row[0] - 1;
    } else {
        return false;
    }
    $reduce_query = "update RoomPerFloor set roomPerFloor = $available_room where matchingID = $matchingID";
    if (mysqli_query($con, $reduce_query)) {
        return true;
    } else {
        return false;
    }
}

function checkBooking($memberID) {

    require 'connection.php';

    $query = "select * from booking where memberID = $memberID and  (booking_status = 'Waiting' or booking_status = 'Checking')";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL) {
        return 'Already Booking (Booking ID = ' . $row["bookingID"] . ')';
    } else {
        return 'PASS';
    }
}

function checkRoomAvailable($matchingID) {

    require 'connection.php';

    $query = "select roomPerFloor from RoomPerFloor where matchingID = $matchingID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row["roomPerFloor"] !== '0') {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST["dormID"]) && isset($_POST["roomID"]) && is_numeric($_POST["dormID"]) && is_numeric($_POST["roomID"])) {

    require 'connection.php';
    $dormID = $_POST["dormID"];
    $dorm_query = "select dormName from Dormitories where dormID = $dormID";
    $dorm_result = mysqli_query($con, $dorm_query);
    $dorm_row = mysqli_fetch_array($dorm_result);
    
    $roomID = $_POST["roomID"];
    $room_query = "select roomType,price,roomDeposit from rooms where roomID = $roomID";
    $room_result = mysqli_query($con, $room_query);
    $room_row = mysqli_fetch_array($room_result);

    $bank_query = "select * from BankAccount where dormID = $dormID and bank_status = 'Showing'";
    $bank_result = mysqli_query($con, $bank_query);
    
    $th_number = "th";
    
    switch ($_POST["floor"]){
        case "1": $th_number = "st";
            break;
        case "2": $th_number = "nd";
            break;
        case "3": $th_number = "rd";
            break;
    }
    
    if (isset($_POST["submit_book"])) {

        require 'connection.php';

        $memberID = $_SESSION["memberID"];
        $roomID = is_numeric(filter_var($_POST["roomID"], FILTER_SANITIZE_STRING)) ? $_POST["roomID"] : NULL;
        $total_price = is_numeric(filter_var($_POST["total_price"], FILTER_SANITIZE_STRING)) ? $_POST["total_price"] : NULL;
        $start_date = filter_var($_POST["start_date"], FILTER_SANITIZE_STRING);
        $expire_date = filter_var($_POST["expire_date"], FILTER_SANITIZE_STRING);
        $floor_no = filter_var($_POST["floor"],FILTER_SANITIZE_STRING);
        $matchingID = $_POST["matchingID"];
        
        $query = "INSERT INTO `Booking` (`memberID`, `roomID`, `date`, `expire_date`, `booking_status`, `totalPrice`, `floor_no`, `matchingID`) VALUES($memberID,$roomID, '$start_date', '$expire_date','Waiting',$total_price,$floor_no,$matchingID);";

        $msg = checkBooking($memberID);
        if ($msg == 'PASS') {
            if (checkRoomAvailable($matchingID)) {
                if (mysqli_query($con, $query)) {
                    if (reduce_room($matchingID)) {
                        echo '<script>alert("Booking Success (Deadline : ' . $expire_date . ')");</script>';
                        echo '<script>window.location = "index.php"</script>';
                    } else {
                        echo '<script>alert("Booking Failed");</script>';
                        echo '<script>window.location = "index.php"</script>';
                    }
                } else {
                    echo '<script>alert("Booking Failed");</script>';
                    echo '<script>window.location = "index.php"</script>';
                }
            } else {
                echo '<script>alert("This Room is Unavailable");</script>';
                echo '<script>window.location = "index.php"</script>';
            }
        } else {
            echo '<script>alert("' . $msg . '");</script>';
            echo '<script>window.location = "index.php"</script>';
        }
    }
    ?>


    <div class="row book-pay">
        <div class="span12">	
            <br /><br />
            <h1>Your <span>Booking</span> Summary</h1>
            <hr style="border-color:#cccccc; width: 80%"><br>
            <div class="row">
                <div class="span12">		
                    <div class="row">
                        <form action="" method="POST">
                            <div class="span8">
                                <h3><span>Detail</span></h3>				

                                <input type="hidden" name="roomID" value="<?php echo $_POST["roomID"]; ?>">
                                <input type="hidden" name="dormID" value="<?php echo $dormID; ?>">
                                <input type="hidden" name="total_price" value="<?php echo $room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]; ?>">
                                <input type="hidden" name="start_date" value="<?php echo strtr(substr(date("c"), 0, 19), "T", " "); ?>">
                                <input type="hidden" name="expire_date" value="<?php echo strtr(substr(date("c", strtotime("+1 day", strtotime(date("r")))), 0, 19), "T", " "); ?>">
                                <input type='hidden' name='floor' value="<?php echo $_POST["floor"] ?>">
                                <input type='hidden' name='matchingID' value="<?php echo $_POST["matchingID"] ?>">
                                <div class="pull-left strong">Your Name</div><div class="pull-right "><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></div><br />
                                <div class="pull-left strong">Dormitory</div><div class="pull-right "><?php echo $dorm_row["dormName"]; ?></div><br />
                                <div class="pull-left strong">Room type</div><div class="pull-right"><?php echo $room_row["roomType"]; ?></div><br />
                                <div class="pull-left strong">Floor</div><div class="pull-right"><?php echo $_POST["floor"]." ".$th_number; ?></div><br />
                                <div class="pull-left strong">Booking Time</div><div class="pull-right"><?php echo substr(date("r"), 0, 25) ?></div><br />
                                <div class="pull-left strong">Make Contract Before</div><div class="pull-right "><?php echo substr(date("r", strtotime("+1 day", strtotime(date("r")))), 0, 25); ?> </div><br />
                                <br>
                                <?php if (mysqli_num_rows($bank_result) !== 0) { ?>
                                    <h3><span>Money</span> Transfer Detail</h3>
                                <?php } ?>
                                <?php while ($bank_row = mysqli_fetch_array($bank_result)) { ?>

                                    <div class="pull-left strong">Bank Name </div><div class="pull-right "><?php echo $bank_row["bankName"] ?></div><br />
                                    <div class="pull-left strong">Bank Account Name </div><div class="pull-right "><?php echo $bank_row["bankAccountName"] ?></div><br />
                                    <div class="pull-left strong">Bank Account ID </div><div class="pull-right "><?php echo $bank_row["bankAccountID"] ?></div><br />
                                    <div class="pull-left strong">Branch </div><div class="pull-right "><?php echo $bank_row["branch"] ?></div><br />
                                    <br>
                                <?php } ?>
                                <div class="pull-left strong" style="color:#00cc33"><h3>Total Price :  </h3></div><div class="pull-right" style="color:#00cc33"><h3><?php echo $room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]; ?> Baht</h3></div><br />

                                <!--                            <div class="pull-left strong">Please Confirm Your Identity Card Number</div><div class="pull-right strong">Please Confirm Telephone Number</div><br>
                                                            <div class="pull-left strong"><input name="idcard" class="form-control" type="text" required></div>
                                                            <div class="pull-right strong" style="width: 40%"><input name="telephone" class="form-control" type="text" required></div><br>-->
                                <button type="submit" name="submit_book" style="margin-top: 30px;margin-left:435px; width: 30%" class="btn1 btn1-primary">Confirm</button>
<!--                                <button type="submit" name="submit_book" style="margin-top: 30px;margin-left:420px" class="btn btn-primary btn-large book-now">Confirm</button>-->
                                
                                <div class ="span10" style="margin-top: 50px">
                                    <br />
                                <br />
                                <br />
                                <br />
                                <br>
                                <br>
                                    <h3><span>You Should transfer money to Dormitory before <?php echo date("r", strtotime("+1 day", strtotime(date("r")))); ?> 
                                            <br>If you don't go to make contract the System will recognize
                                            <br>And If it already 3 times you will be a blacklist  </span></h3>
                                </div>
                            </div>
                            <div class="span3" style="border: solid black 2px;text-align: center;margin-left:70px">
                                <br>
                                <h3 style="font-style: italic;text-align: center">Price Detail</h3><hr>
                                <p>Room Price</p>
                                <span class="price"><?php echo $room_row["price"]; ?> Bath</span>
                                <hr>
                                <p>Room Deposit For <?php echo $room_row["roomDeposit"]; ?> Month</p>
                                <span class="price"><?php echo $room_row["price"] * $room_row["roomDeposit"]; ?> Bath</span><hr style="color:red">
                                <h3 style="color: #00cc33;font-style:italic;text-align: center">Total Price</h3>
                                <span class="price" style="color:#00cc33"><?php echo $room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]; ?> Bath</span>
                                <br><br><br>
                            </div>		
                        </form>
                    </div>

                </div>
            </div><br /><hr />
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div></div> <!-- /container -->
<?php } ?>

