
<?php

if(isset($_GET["dormID"])){
    
    require 'connection.php';
    $dormID = $_GET["dormID"];
    $dorm_query = "select dormName from Dormitories where dormID = $dormID";
    $dorm_result = mysqli_query($con, $dorm_query);
    $dorm_row = mysqli_fetch_array($dorm_result);
    
    $roomID = $_GET["roomID"];
    $room_query = "select roomType,price from rooms where roomID = $roomID";
    $room_result = mysqli_query($con, $room_query);
    $room_row = mysqli_fetch_array($room_result);


?>


<div class="row book-pay">
    <div class="span12">	
        <br /><br />
        <h1>Your Booking Summary</h1><br>
        <div class="row">
            <div class="span12">		
                <div class="row">
                    <form action="confirm_book.php" method="post">
                        <div class="span8">
                            <h3><span>Detail</span></h3>				
                            <br>
                            <input type="hidden" name="memberID" value="<?php echo $_SESSION["memberID"]; ?>">
                            <input type="hidden" name="roomID" value="<?php echo $_GET["roomID"]; ?>">
                            <input type="hidden" name="start_date" value="<?php echo date("r"); ?>">
                            <input type="hidden" name="expire_date" value="<?php echo date("r", strtotime("+1 day", strtotime(date("r")))) ?>">
                            <div class="pull-left strong">Your Name</div><div class="pull-right "><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></div><br />
                            <div class="pull-left strong">Dormitory</div><div class="pull-right "><?php echo $dorm_row["dormName"]; ?></div><br />
                            <div class="pull-left strong">Room type</div><div class="pull-right"><?php echo $room_row["roomType"]; ?></div><br />
                            <div class="pull-left strong">Booking Time</div><div class="pull-right"><?php echo date("r"); ?></div><br />
                            <div class="pull-left strong">Make Contract Before</div><div class="pull-right "><?php echo date("r", strtotime("+1 day", strtotime(date("r")))) ?> </div><br />
                            <br>
                            <div class="pull-left strong">Please Confirm Your Identity Card Number</div><div class="pull-right strong">Please Confirm Telephone Number</div><br>
                            <div class="pull-left strong"><input name="idcard" class="form-control" type="text" required></div>
                            <div class="pull-right strong" style="width: 40%"><input name="telephone" class="form-control" type="text" required></div><br>
                            <button type="submit" name="submit_book" style="margin-top: 30px" class="btn btn-primary btn-large book-now pull-right">Confirm</button>
                            <br />
                            <br />
                            <br />
                            <br />
                            <div class ="span10" style="margin-top: 50px">
                                <h3><span>You Should go to make Contract Before <?php echo date("r", strtotime("+1 day", strtotime(date("r")))); ?> 
                                        <br>If you don't go to make contract the System will recognize
                                        <br>And If it already 3 times you will be a blacklist  </span></h3>
                            </div>
                        </div>
                        <div class="span3 pull-right">
                            <p>Contract Fee Price</p>
                            <span class="price"><?php echo $room_row["price"]; ?> Bath/Month</span>
                        </div>		
                    </form>
                </div>

            </div>
        </div><br /><hr />
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</div></div> <!-- /container -->
<?php } ?>

