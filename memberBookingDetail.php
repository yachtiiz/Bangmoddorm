<?php
if (isset($_GET["bookingID"]) && is_numeric($_GET["bookingID"])) {

    $bookingID = $_GET["bookingID"];

    require 'connection.php';
    $query = "select * from booking where bookingID = $bookingID";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        $book_row = mysqli_fetch_array($result);
        $roomID = $book_row["roomID"];
        $memberID = $book_row["memberID"];

        $member_query = "select * from members where memberID = $memberID";
        $member_result = mysqli_query($con, $member_query);
        $member_row = mysqli_fetch_array($member_result);

        $room_query = "select * from rooms where roomID = $roomID";
        $room_result = mysqli_query($con, $room_query);
        $room_row = mysqli_fetch_array($room_result);

        $dormID = $room_row["dormID"];
        $dorm_query = "select * from dormitories where dormID = $dormID";
        $dorm_result = mysqli_query($con, $dorm_query);
        $dorm_row = mysqli_fetch_array($dorm_result);

        $bank_query = "select * from bankAccount where dormID = $dormID";
        $bank_result = mysqli_query($con, $bank_query);
        ?>
        <script>


            jQuery(function($) {
                $("#datetime").mask("9999-99-99 99:99:99", {placeholder: "0"});
                $("#cpn_tel").mask("(+99)99-999-9999 ext.? 99");
                $("#cpn_fax").mask("(+99)99-999-9999");
                $("#idcard").mask("9-9999-99999-99-9", {placeholder: "_"});
                $("#cpn_elec_regis").mask("9999999999999", {placeholder: ""});
                $("#cpn_tax_number").mask("9999999999999", {placeholder: ""});
            });

        </script>
        <div class="row book-pay">
            <div class="span12">	
                <h1>Your Booking Summary</h1><br>
                <div class="row">
                    <div class="span12">		
                        <div class="row">
                            <div class="span8">
                                <?php
                                if ($book_row["booking_status"] !== "Checking") {
                                    if (isset($_POST["confirm_evidence"])) {

                                        function upSlip($file, $bookingID) {
                                            if ($_FILES["$file"]["type"] == "image/jpg" || $_FILES["$file"]["type"] == "image/png" || $_FILES["$file"]["type"] == "image/jpeg" || $_FILES["$file"]["type"] == "image/gif" || $_FILES["$file"]["type"] == "image/pjpeg" || $_FILES["$file"]["type"] == "image/x-png") {
                                                if (move_uploaded_file($_FILES["$file"]["tmp_name"], "images/picture_slip/slip_" . $bookingID . "_" . $_FILES["$file"]["name"])) {
                                                    return $msg = "slip_" . $bookingID . "_" . $_FILES["$file"]["name"];
                                                } else {
                                                    return $msg = "Cant Upload";
                                                }
                                            } else {
                                                return $msg = "Invalid Picture";
                                            }
                                        }

                                        $slipImage = upSlip("slipImage", $bookingID);
                                        if ($slipImage !== "Cant Upload" && $slipImage !== "Invalid Picture") {

                                            $transfer_name = filter_var($_POST["transfer_name"], FILTER_SANITIZE_STRING);
                                            $transfer_time = filter_var($_POST["transfer_time"], FILTER_SANITIZE_STRING);
                                            $query = "update Booking set booking_status='Checking' , slip = '$slipImage' , transfer_name = '$transfer_name' , transfer_time = '$transfer_time' where bookingID =$bookingID";
                                            if (mysqli_query($con, $query)) {
                                                echo '<script>alert("Confirm Evidence Complete")</script>';
                                                echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID='. $bookingID . '"</script>';
                                            } else {
                                                echo '<script>alert("Confirm Evidence Failed")</script>';
                                                echo '<script>window.location = "index.php?chose_page=checkBookHis"</script>';
                                            }
                                        } else {
                                            echo '<script>alert("' . $slipImage . '")</script>';
                                        }
                                    } else {
                                        ?>
                                        <form action='' method='post' enctype="multipart/form-data">
                                            <div style='border:solid 2px black;padding: 30px;margin-bottom:50px'>
                                                <h3 style='margin-left:120px'><span>Money</span> Transfer Evidence</h3>
                                                <div class="input-group" style="width: 60%;margin-left:100px">
                                                    <span class="input-group-addon">Slip Image</span>
                                                    <input class="form-control" type="file" name="slipImage" value='' required >
                                                </div>
                                                <div class="input-group" style="width: 60%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">Transfer Name</span>
                                                    <input class="form-control" type="text" name="transfer_name" value='' required>
                                                </div>
                                                <div class="input-group" style="width: 60%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">Time</span>
                                                    <input id="timedate" class="form-control" type="datetime-local" name="transfer_time" placeholder="YYYY-MM-DD" required>
                                                </div>
                                                <button type='submit' name='confirm_evidence' class='btn btn-primary' style='color:green;margin-left:290px;margin-top:20px'>Confirm Evidence</button>
                                            </div>
                                        </form>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="col-md-12" style='padding: 30px;margin-bottom:50px'>
                                        <legend><h3 style='margin-left:120px'><span>Money</span> Transfer Evidence</h3></legend>
                                        <img style="margin-left: 130px ;width: 250px;height: 300px" class='img-thumbnail' src='/images/picture_slip/<?php echo $book_row["slip"]; ?>'><br>
                                        <div class="col-md-6" style="margin-top: 30px">
                                            <h4 style="margin-left:40px">Transfer Name :</h4>
                                            <h4 style="margin-left:40px">Transfer Time :</h4>
                                        </div>
                                        <div class="col-md-6" style="margin-top: 30px">
                                             <h4 style="margin-left: 20px"><?php echo $book_row["transfer_name"] ?></h4>
                                             <h4 style="margin-left: 20px"><?php echo $book_row["transfer_time"] ?></h4>
                                        </div>
                                    </div>
                                <?php } ?>
                                <h3><span>Detail</span></h3>				
                                <div class="pull-left strong">Your Name</div><div class="pull-right "><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></div><br />
                                <div class="pull-left strong">Dormitory</div><div class="pull-right "><?php echo $dorm_row["dormName"]; ?></div><br />
                                <div class="pull-left strong">Room type</div><div class="pull-right"><?php echo $room_row["roomType"]; ?></div><br />
                                <div class="pull-left strong">Booking ID</div><div class="pull-right"><?php echo $book_row["bookingID"] ?></div><br>
                                <div class="pull-left strong">Booking Status</div><div class="pull-right"><?php echo $book_row["booking_status"] ?></div><br>
                                <div class="pull-left strong">Booking Date</div><div class="pull-right"><?php echo $book_row["date"] ?></div><br />
                                <div class="pull-left strong">Booking Expire Date</div><div class="pull-right "><?php echo $book_row["expire_date"] ?> </div><br /><br>

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

                                <div class="pull-left strong" style="color:#00cc33"><h3>Total Price :  </h3></div><div class="pull-right" style="color:#00cc33"><h3><?php echo $room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]; ?> Bath</h3></div><br />
                                <br>


                                <!--                            <div class="pull-left strong">Please Confirm Your Identity Card Number</div><div class="pull-right strong">Please Confirm Telephone Number</div><br>
                                                            <div class="pull-left strong"><input name="idcard" class="form-control" type="text" required></div>
                                                            <div class="pull-right strong" style="width: 40%"><input name="telephone" class="form-control" type="text" required></div><br>-->

                                <button type="submit" name="submit_book" style="margin-top: 30px;margin-left:420px" class="btn btn-primary btn-large book-now">Cancle This Booking</button>
                                <br />
                                <br />
                                <br />
                                <br />
                                <div class ="span10" style="margin-top: 50px">
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
                        </div>

                    </div>
                </div><br /><hr />
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div></div>
    <?php } ?>
<?php } ?>