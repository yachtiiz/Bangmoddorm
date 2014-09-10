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
        <div class="row book-pay">
            <div class="span12">	
                <h1>Your Booking Summary</h1><br>
                <div class="row">
                    <div class="span12">		
                        <div class="row">
                            <form action="" method="post">
                                <div class="span8">
                                    <div style='border:solid 2px black;padding: 30px;margin-bottom:50px'>
                                    <h3 style='margin-left:150px'><span>Money</span> Transfer Evidence</h3>
                                    <div class="input-group" style="width: 50%;margin-left:150px">
                                        <span class="input-group-addon">Slip ID</span>
                                        <input class="form-control" type="text" name="distinct" value='' >
                                    </div>
                                    <div class="input-group" style="width: 50%;margin-top:10px;margin-left:150px">
                                        <span class="input-group-addon">Transfer Name</span>
                                        <input class="form-control" type="text" name="distinct" value='' >
                                    </div>
                                    <div class="input-group" style="width: 50%;margin-top:10px;margin-left:150px">
                                        <span class="input-group-addon">Bank Name</span>
                                        <input class="form-control" type="text" name="distinct" value='' >
                                    </div>
                                    <div class="input-group" style="width: 50%;margin-top:10px;margin-left:150px">
                                        <span class="input-group-addon">Time</span>
                                        <input class="form-control" type="text" name="distinct" value='' >
                                    </div>
                                    <button class='btn btn-primary' style='color:green;margin-left:200px;margin-top:20px'>Confirm</button>
                                    <button class='btn btn-primary' style='color:red;margin-left:20px;margin-top:20px'>Cancel Booking</button>
                                    </div>
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
                            </form>
                        </div>

                    </div>
                </div><br /><hr />
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div></div>
    <?php } ?>
<?php } ?>