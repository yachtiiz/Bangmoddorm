<?php
if (isset($_GET["bookingID"]) && is_numeric($_GET["bookingID"])) {

    $bookingID = $_GET["bookingID"];

    require 'connection.php';
    $query = "select * from Booking where bookingID = $bookingID";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        $book_row = mysqli_fetch_array($result);
        $roomID = $book_row["roomID"];
        $memberID = $book_row["memberID"];
        $floorNo = $book_row["floor_no"];

        $member_query = "select * from Members where memberID = $memberID";
        $member_result = mysqli_query($con, $member_query);
        $member_row = mysqli_fetch_array($member_result);

        $room_query = "select * from Rooms r join RoomPerFloor rpf join Floor f where r.roomID = rpf.roomID and rpf.floorID = f.floorID and r.roomID = $roomID and f.floorNo = $floorNo";
        $room_result = mysqli_query($con, $room_query);
        $room_row = mysqli_fetch_array($room_result);

        $dormID = $room_row["dormID"];
        $dorm_query = "select * from Dormitories where dormID = $dormID";
        $dorm_result = mysqli_query($con, $dorm_query);
        $dorm_row = mysqli_fetch_array($dorm_result);

        $bank_query = "select * from BankAccount where dormID = $dormID";
        $bank_result = mysqli_query($con, $bank_query);
        $bank_result_selected = mysqli_query($con, $bank_query);
        ?>
        <script>

            $(function() {

                $("#cancel_booking").on("click", function() {
                    if (confirm("Are you sure to cancel this booking ?")) {
                        $("#cancel_booking").load("callback.php?cancel_booking=<?php echo $bookingID ?>");
                    }
                });
            });



        </script>
        <div class="row book-pay">
            <div class="span12">	
                <div class="row">
                    <div class="span12">		
                        <div class="row">
                            <br>
                            <div class="span8">
                                <?php
                                if ($book_row["booking_status"] === "Refund Needed") {
                                    if (isset($_POST["submit_bank_acc"])) {
                                        $bank_acc_id = filter_var($_POST["customer_bank_acc_id"], FILTER_SANITIZE_STRING);
                                        $bank_name = filter_var($_POST["customer_bank_name"], FILTER_SANITIZE_STRING);
                                        $query = "update Booking  set owner_noti = 1 , bank_acc_id = '$bank_acc_id' , bank_name = '$bank_name' where bookingID = $bookingID";
                                        if (mysqli_query($con, $query)) {
                                            echo '<script>alert("Confirm Bank Account Complete")</script>';
                                            echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID=' . $bookingID . '"</script>';
                                        }
                                    }
                                }



                                if ($book_row["booking_status"] === "Waiting" | $book_row["booking_status"] === "Checking") {
                                    if ($book_row["booking_status"] === "Refund Needed") {
                                        if (isset($_POST["submit_bank_acc"])) {
                                            $bank_acc_id = filter_var($_POST["customer_bank_acc_id"], FILTER_SANITIZE_STRING);
                                            $bank_name = filter_var($_POST["customer_bank_name"], FILTER_SANITIZE_STRING);
                                            $query = "update Booking  set owner_noti = 1 , bank_acc_id = '$bank_acc_id' , bank_name = '$bank_name' where bookingID = $bookingID";
                                            if (mysqli_query($con, $query)) {
                                                echo '<script>alert("Confirm Bank Account Complete")</script>';
                                                echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID=' . $bookingID . '"</script>';
                                            }
                                        }
                                    }
                                    if (isset($_POST["confirm_evidence"])) {
                                        if (!($_FILES["slipImage"]["name"] === "" && $_POST["reference_id"] === "")) {
                                            if ($_FILES["slipImage"]["name"] !== "") {

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
                                            } else {
                                                if ($book_row["slip"] !== "") {
                                                    $slipImage = $book_row["slip"];
                                                } else {
                                                    $slipImage = "default_slip_picture.jpg";
                                                }
                                            }
                                            if ($slipImage !== "Cant Upload" && $slipImage !== "Invalid Picture") {

                                                $transfer_name = filter_var($_POST["transfer_name"], FILTER_SANITIZE_STRING);
                                                $transfer_time = filter_var($_POST["transfer_time"], FILTER_SANITIZE_STRING);
                                                $transfer_reference_id = filter_var($_POST["reference_id"], FILTER_SANITIZE_STRING);
                                                $transfer_bank = filter_var($_POST["transfer_bank"], FILTER_SANITIZE_STRING);
                                                $transfer_amount = filter_var($_POST["transfer_amount"], FILTER_SANITIZE_STRING);
                                                $query = "update Booking  set owner_noti = 1 , booking_status='Checking' , slip = '$slipImage' , transfer_name = '$transfer_name' , transfer_time = '$transfer_time' , transfer_time = '$transfer_time' , transfer_referenceID = '$transfer_reference_id' , transfer_bank = '$transfer_bank' , transfer_amount = $transfer_amount where bookingID =$bookingID";
                                                if (mysqli_query($con, $query)) {
                                                    echo '<script>alert("Confirm Evidence Complete")</script>';
                                                    echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID=' . $bookingID . '"</script>';
                                                } else {
                                                    echo '<script>alert("Confirm Evidence Failed")</script>';
                                                    echo '<script>window.location = "index.php?chose_page=checkBookHis"</script>';
                                                }
                                            } else {
                                                echo '<script>alert("' . $slipImage . '")</script>';
                                                echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID=' . $bookingID . '"</script>';
                                            }
                                        } else {
                                            echo '<script>alert("Either Slip image or Reference ID")</script>';
                                            echo '<script>window.location = "index.php?chose_page=membookdetail&bookingID=' . $bookingID . '"</script>';
                                        }
                                    } else if ($book_row["booking_status"] === "Waiting") {
                                        ?>
                                        <form id="confirm_form" action='' method='post' enctype="multipart/form-data">
                                            <div style='border:solid 2px black;padding: 30px;margin-bottom:50px'>
                                                <h3 style='margin-left:120px'><span>Money</span> Transfer Evidence</h3>
                                                <br>
                                                <div class="input-group" style="width: 70%;margin-left:100px">
                                                    <span class="input-group-addon">Slip Image</span>
                                                    <input id="slip_image" class="form-control" type="file" name="slipImage" value='' >
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">Reference ID </span>
                                                    <input id="transfer_name" class="form-control" type="text" name="reference_id" value=''>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">From Bank Account ID <span style="color:red">*</span></span>
                                                    <input id="transfer_name" class="form-control" type="text" name="transfer_name" value='' placeholder="Or Your Transfer name" required>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">To Dormitory Bank Account <span style="color:red">*</span></span>
                                                    <select name="transfer_bank" class="form-control">
                                                        <?php while ($bank_select_row = mysqli_fetch_array($bank_result_selected)) { ?>
                                                            <option value="<?php echo $bank_select_row["bankName"] ?>"><?php echo $bank_select_row["bankName"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">Transfer Time <span style="color:red">*</span></span>
                                                    <input id="transfer_time" class="form-control" type="datetime-local" name="transfer_time" placeholder="YYYY-MM-DD" required>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                    <span class="input-group-addon">Amount <span style="color:red">*</span></span>
                                                    <input id="transfer_amount" class="form-control" type="number" name="transfer_amount" required>
                                                    <span class="input-group-addon">Baht</span>
                                                </div>

                                                <!--                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                                                                    <span class="input-group-addon">Your Bank Account ID <span style="color:red">*</span></span>
                                                                                                    <input id="transfer_name" class="form-control" type="text" name="customer_bank_acc_id" value='' required>
                                                                                                </div>
                                                                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                                                                    <span style="color:red"><span style="color:red">*</span>Your Bank Account ID for transfer back case this room have a problem to booking</span>
                                                                                                </div>-->
                                                <button type='submit' name='confirm_evidence' class='btn1 btn1-success' style='margin-left:350px;margin-top:20px'>Confirm Evidence</button>
                                            </div>
                                        </form>
                                    <?php } else { ?>

                                        <form id="confirm_form" action='' method='post' enctype="multipart/form-data">
                                            <div style='border:solid 2px black;padding: 30px;margin-bottom:50px'>
                                                <h3 style='margin-left:120px'><span>Money</span> Transfer Evidence</h3>
                                                <br>
                                                <?php if ($book_row["slip"] !== "None") { ?>
                                                    <img style="margin-left: 130px ;width: 250px;height: 300px" class='img-thumbnail' src='/images/picture_slip/<?php echo $book_row["slip"]; ?>'><br>
                                                    <br>
                                                <?php } ?>
                                                <div class="input-group" style="width: 70%;margin-left:10%">
                                                    <span class="input-group-addon">Edit Slip Image</span>
                                                    <input id="slip_image" class="form-control" type="file" name="slipImage" value='' >
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:10%">
                                                    <span class="input-group-addon">Reference ID </span>
                                                    <input id="transfer_name" class="form-control" type="text" name="reference_id" value='<?php echo $book_row["transfer_referenceID"] !== "" ? $book_row["transfer_referenceID"] : " Empty Data" ?>'>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:10%">
                                                    <span class="input-group-addon">From Bank Account ID <span style="color:red">*</span></span>
                                                    <input id="transfer_name" class="form-control" type="text" name="transfer_name" value='<?php echo $book_row["transfer_name"] ?>' placeholder="Or Your Transfer name" required>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:10%">
                                                    <span class="input-group-addon">To Dormitory Bank Account <span style="color:red">*</span></span>
                                                    <select name="transfer_bank" class="form-control">
                                                        <?php while ($bank_select_row = mysqli_fetch_array($bank_result_selected)) { ?>
                                                            <option <?php echo $book_row["transfer_bank"] === $bank_select_row["bankName"] ? "selected" : "" ?> value="<?php echo $bank_select_row["bankName"] ?>"><?php echo $bank_select_row["bankName"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:10%">
                                                    <span class="input-group-addon">Transfer Time <span style="color:red">*</span></span>
                                                    <input id="transfer_time" class="form-control" type="text" name="transfer_time" value="<?php echo $book_row["transfer_time"] ?>" required>
                                                </div>
                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:10%">
                                                    <span class="input-group-addon">Amount <span style="color:red">*</span></span>
                                                    <input id="transfer_amount" class="form-control" type="number" name="transfer_amount" value="<?php echo $book_row["transfer_amount"] ?>" required>
                                                    <span class="input-group-addon">Baht</span>
                                                </div>

                                                <!--                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                                                                    <span class="input-group-addon">Your Bank Account ID <span style="color:red">*</span></span>
                                                                                                    <input id="transfer_name" class="form-control" type="text" name="customer_bank_acc_id" value='' required>
                                                                                                </div>
                                                                                                <div class="input-group" style="width: 70%;margin-top:10px;margin-left:100px">
                                                                                                    <span style="color:red"><span style="color:red">*</span>Your Bank Account ID for transfer back case this room have a problem to booking</span>
                                                                                                </div>-->
                                                <button type='submit' name='confirm_evidence' class='btn1 btn1-success' style='margin-left:60%;margin-top:2%'>Edit Evidence</button>

                                            </div>
                                        </form>
                                    <?php } ?>
                                <?php } else if ($book_row["booking_status"] !== "Canceled" && $book_row["booking_status"] !== "Reject") { ?>
                                    <div class="col-md-12" style='padding: 30px;'>
                                        <legend><h3 style='margin-left:120px'><span>Money</span> Transfer Evidence</h3></legend>
                                        <?php if ($book_row["slip"] !== "None") { ?>
                                            <img style="margin-left: 130px ;width: 250px;height: 300px" class='img-thumbnail' src='/images/picture_slip/<?php echo $book_row["slip"]; ?>'><br>
                                        <?php } ?>
                                        <div class="col-md-5" style="margin-top: 30px">
                                            <h4 style="margin-left:20px">Reference ID :</h4>
                                            <h4 style="margin-left:20px">Transfer Name :</h4>
                                            <h4 style="margin-left:20px">Transfer Time :</h4>
                                            <h4 style="margin-left:20px">Transfer Bank :</h4>
                                            <h4 style="margin-left:20px">Amount :</h4>
                                        </div>
                                        <div class="col-md-7" style="margin-top: 30px">
                                            <h4 style="margin-left: 20px"><?php echo $book_row["transfer_referenceID"] !== "" ? $book_row["transfer_referenceID"] : " Empty Data" ?></h4>
                                            <h4 style="margin-left: 20px"><?php echo $book_row["transfer_name"] ?></h4>
                                            <h4 style="margin-left: 20px"><?php echo $book_row["transfer_time"] ?></h4>
                                            <h4 style="margin-left: 20px"><?php echo $book_row["transfer_bank"] ?></h4>
                                            <h4 style="margin-left: 20px;color:#33cc00"><?php echo number_format($book_row["transfer_amount"]) ?> Baht</h4>
                                        </div>
                                        <?php if ($book_row["booking_status"] === "Refund Needed" || $book_row["booking_status"] === "Already Refunded") { ?>
                                            <div class="col-md-12" style='margin-top:4%'>
                                                <form action='' method='post'>
                                                    <?php if ($book_row["booking_status"] === "Refund Needed") { ?>
                                                        <p style='color:red'><span style='color:red'>***</span>In case a problem with your room booking eg. not available room or money transfer problem,We will transfer your money back. <br> <?php if (!isset($book_row["bank_acc_id"])) { ?>Please Add Bank Account and Bank Name. <?php } else {
                                        echo '<span style="color:green">Add Complete.</span>';
                                    } ?> </p>
                                                        <div class="input-group" style="width: 100%;margin-top:2%">
                                                            <span class="input-group-addon">Bank Account ID <span style="color:red">*</span></span>
                                                            <input id="bankacc" class="form-control" type="text" name="customer_bank_acc_id" value='<?php echo $book_row["bank_acc_id"] ?>' required>
                                                        </div>
                                                        <div class="input-group" style="width: 100%;margin-top:2%">
                                                            <span class="input-group-addon">Bank Name <span style="color:red">*</span></span>
                                                            <select class="form-control" name="customer_bank_name">
                                                                <option <?php echo $book_row["bank_name"] === "Bangkok Bank" ? "selected" : "" ?> value="Bangkok Bank">Bangkok Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Krung Sri Bank" ? "selected" : "" ?> value="Krung Sri Bank">Krung Sri Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Krung Thai Bank (KTB)" ? "selected" : "" ?> value="Krung Thai Bank (KTB)">Krung Thai Bank (KTB)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Kasikorn Thai Bank (KBANK)" ? "selected" : "" ?> value="Kasikorn Thai Bank (KBANK)">Kasikorn Thai Bank (KBANK)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Kaitnakin Bank" ? "selected" : "" ?> value="Kaitnakin Bank">Kaitnakin Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "CIMB Thai Bank" ? "selected" : "" ?> value="CIMB Thai Bank">CIMB Thai Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Thai Military Bank (TMB)" ? "selected" : "" ?> value="Thai Military Bank (TMB)">Thai Military Bank (TMB)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Tisco Bank" ? "selected" : "" ?> value="Tisco Bank">Tisco Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Thai Credit Bank (TCR)" ? "selected" : "" ?> value="Thai Credit Bank (TCR)">Thai Credit Bank (TCR)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Thanachart Bank" ? "selected" : "" ?> value="Thanachart Bank">Thanachart Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Unitied Overseas Bank (UOB)" ? "selected" : "" ?> value="Unitied Overseas Bank (UOB)">Unitied Overseas Bank (UOB)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Land and House Retail Bank (LHBANK)" ? "selected" : "" ?> value="Land and House Retail Bank (LHBANK)">Land and House Retail Bank (LHBANK)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Standard Chartered" ? "selected" : "" ?> value="Standard Chartered">Standard Chartered</option>
                                                                <option <?php echo $book_row["bank_name"] === "SME Bank (SME)" ? "selected" : "" ?> value="SME Bank (SME)">SME Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "EXIM Thailand (EXIM)" ? "selected" : "" ?> value="EXIM Thailand (EXIM)">EXIM Thailand Bank</option>
                                                                <option <?php echo $book_row["bank_name"] === "Goverment Saving Bank (GSB)" ? "selected" : "" ?> value="Goverment Saving Bank (GSB)">Government Saving Bank (GSB)</option>
                                                                <option <?php echo $book_row["bank_name"] === "Islamic Bank of Thailand" ? "selected" : "" ?> value="Islamic Bank of Thailand">Islamic Bank of Thailand</option>
                                                            </select>
                                                        </div>
                                                        <br>
                                                        <button style='margin-left:36%' class='btn1 btn1-success' type='submit' name='submit_bank_acc' ><?php if (!isset($book_row["bank_acc_id"])) { ?>Confirm Bank Account <?php } else { ?> Edit Bank Account <?php } ?></button>
                <?php } else { ?>
                                                        <p style='color:red'><span style='color:red'>***</span>In case a problem with your room booking eg. not available room or money transfer problem,We will transfer your money back. <br><span style="color:green">Add Complete.</span> </p>
                                                        <div class="input-group" style="width: 100%;margin-top:2%">
                                                            <span class="input-group-addon">Bank Account ID <span style="color:red">*</span></span>
                                                            <input id="bankacc" class="form-control" type="text" name="customer_bank_acc_id" value='<?php echo $book_row["bank_acc_id"] ?>' disabled>
                                                        </div>
                                                        <div class="input-group" style="width: 100%;margin-top:2%">
                                                            <span class="input-group-addon">Bank Name <span style="color:red">*</span></span>
                                                            <select class="form-control" name="customer_bank_name" disabled>
                                                                <option><?php echo $book_row["bank_name"] ?></option>
                                                            </select>
                                                        </div>
                                            <?php } ?>
                                                </form>
                                            </div>
                                            <?php } ?>
                                        <div class="col-md-12" style="margin-left: 20px">
                                            <br>
            <?php if ($book_row["booking_status"] === "Checking") { ?><h4 style="font-style: italic;color: #0480be; text-align: center">Waiting for Owner to check your evidence</h4> <?php } ?>
            <?php if ($book_row["booking_status"] === "Approve") { ?><h4 style="font-style: italic;color: #33cc00; text-align: center">Your Evidence is Correct. When you contract with Dormitory receptionist you can tell booking id for your room.</h4> <?php } ?>

                                        </div>
                                    </div>
        <?php } ?>
                                <div style='border:solid 2px black;padding: 30px;margin-bottom:50px'>
                                    <h3 style='margin-left:35%'><span>Booking</span> Summary</h3>
                                    <br>
        <?php if ($book_row["booking_status"] === "Waiting") { ?>
                                        <div class="strong" style="text-align: center">You Should transfer money to Dormitory before <?php echo date("r", strtotime("+1 day", strtotime(date("r")))); ?> 
                                            .If you don't go to make contract the System will recognize
                                            .And If it already 3 times you will be a blacklist  </div>
                                        <br>
                                    <?php } ?>
                                    <h3><span>Detail</span></h3>			

                                    <?php
                                    $th_number = "th";

                                    switch ($book_row["floor_no"]) {
                                        case "1": $th_number = "st";
                                            break;
                                        case "2": $th_number = "nd";
                                            break;
                                        case "3": $th_number = "rd";
                                            break;
                                    }

                                    $color = "black";

                                    switch ($book_row["booking_status"]) {
                                        case "Canceled":
                                            $color = "red";
                                            break;
                                        case "Reject":
                                            $color = "red";
                                            break;
                                        case "Checking":
                                            $color = "#0480be";
                                            break;
                                        case "Approve":
                                            $color = "#00cc33";
                                            break;
                                        case "Refund Needed":
                                            $color = "red";
                                            break;
                                        case "Already Refunded":
                                            $color = "#00cc33";
                                            break;
                                    }
                                    ?>

                                    <div class="pull-left strong">Your Name</div><div class="pull-right "><?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?></div><br />
                                    <div class="pull-left strong">Dormitory</div><div class="pull-right "><?php echo $dorm_row["dormName"]; ?></div><br />
                                    <div class="pull-left strong">Room type</div><div class="pull-right"><?php echo $room_row["roomType"]; ?></div><br />
                                    <div class="pull-left strong">Floor</div><div class="pull-right"><?php echo $room_row["floorNo"] . " " . $th_number ?> </div><br />
                                    <div class="pull-left strong">Booking ID</div><div class="pull-right"><?php echo $book_row["bookingID"] ?></div><br>
                                    <div class="pull-left strong">Booking Status</div><div class="pull-right" style="color:<?php echo $color; ?>"><?php echo $book_row["booking_status"] ?></div><br>
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

                                    <div class="pull-left strong" style="color:#00cc33"><h3>Total Price :  </h3></div><div class="pull-right" style="color:#00cc33"><h3><?php echo number_format($room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]); ?> Baht</h3></div><br />
                                    <br>


                                    <!--                            <div class="pull-left strong">Please Confirm Your Identity Card Number</div><div class="pull-right strong">Please Confirm Telephone Number</div><br>
                                                                <div class="pull-left strong"><input name="idcard" class="form-control" type="text" required></div>
                                                                <div class="pull-right strong" style="width: 40%"><input name="telephone" class="form-control" type="text" required></div><br>-->

                                    <?php if ($book_row["booking_status"] === "Waiting") { ?>
                                        <button id="cancel_booking" type="button" name="submit_book" style="margin-left:35%;width: 30%" class="btn1 btn1-danger">Cancel This Booking</button>
                                        <!--                                <button id="cancel_booking" type="button" name="submit_book" style="margin-top: 30px;margin-left:420px" class="btn btn-primary btn-large book-now">Cancel This Booking</button> -->
        <?php } ?>
                                    <br />
                                </div>
                            </div>
                            <div class="span3" style="border: solid black 2px;text-align: center;margin-left:70px">
                                <br>
                                <h3 style="font-style: italic;text-align: center">Price Detail</h3><hr>
                                <p>Room Price</p>
                                <span class="price"><?php echo number_format($room_row["price"]); ?> Baht</span>
                                <hr>
                                <p>Room Deposit For <?php echo $room_row["roomDeposit"]; ?> Month</p>
                                <span class="price"><?php echo number_format($room_row["price"] * $room_row["roomDeposit"]); ?> Baht</span><hr style="color:red">
                                <h3 style="color: #00cc33;font-style:italic;text-align: center">Total Price</h3>
                                <span class="price" style="color:#00cc33"><?php echo number_format($room_row["price"] * $room_row["roomDeposit"] + $room_row["price"]); ?> Baht</span>
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