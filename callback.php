<?php

session_start();
date_default_timezone_set('Asia/Bangkok');

//ETC FUNCTION
function getTHNUMBER($floor) {

    $th_number = "th";

    switch ($floor) {
        case "1": $th_number = "st";
            break;
        case "2": $th_number = "nd";
            break;
        case "3": $th_number = "rd";
            break;
    }
    return $th_number;
}

function login($login, $password) {
    /* Query login matching password in DB */
    include 'connection.php';

    $query = "select * from Members where username='$login'";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row != NULL && $password === $row["password"]) {
        $canLogin = true;
        $firstname = $row["firstName"];
        $memberID = $row["memberID"];
        $lastname = $row["lastName"];
        $type = $row["type"];
        $status = $row["status"];
        $picpath = $row["pic_path"];
    } else {
        $canLogin = false;
    }
    /* Query login matching password in DB */

    if ($canLogin === true) {
        $_SESSION["auth"] = true;
        $_SESSION["memberID"] = $memberID;
        $_SESSION["username"] = $login;
        $_SESSION["firstname"] = $firstname;
        $_SESSION["lastname"] = $lastname;
        $_SESSION["type"] = $type;
        $_SESSION["status"] = $status;
        $_SESSION["pic_path"] = $picpath;
        return true;
    } else {
        return false;
    }
}

#----------------- AJAX FN CASE SWITCHER
if (isset($_POST["fn"]) && $_POST["fn"] === "auth") {
    $_SESSION["auth"] = false;

    if (!isset($_POST["login"]) || !isset($_POST["password"])) {
        echo "ERR";
        exit;
    }
    $entered_login = trim($_POST["login"]);
    $entered_password = md5(trim($_POST["password"]));

    $login_result = login($entered_login, $entered_password);

    if ($login_result) {
        echo $_SESSION["firstname"] . " " . $_SESSION["lastname"];
    } else {
        echo "1";
    }
}

if (isset($_GET["logout"])) {
    session_destroy();
    echo '<script>window.location = "index.php"</script>';
}

function upPicture($file, $username) {
    if ($_FILES["$file"]["type"] == "image/jpg" || $_FILES["$file"]["type"] == "image/png" || $_FILES["$file"]["type"] == "image/jpeg" || $_FILES["$file"]["type"] == "image/gif" || $_FILES["$file"]["type"] == "image/pjpeg" || $_FILES["$file"]["type"] == "image/x-png") {
        if (move_uploaded_file($_FILES["$file"]["tmp_name"], "images/picture_profile/user_" . $username)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function approve_dormitory($confirmID, $dorm_rate) {

    require 'connection.php';
    $query = "update ConfirmationDorm set approval = 'Approve' , noti_status = 1 where confirmID = $confirmID ";

    if (mysqli_query($con, $query)) {

        $query = "select * from ConfirmationDorm where confirmID = $confirmID";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        $dorm_name = $row["dormName"];
        $memberID = $row["memberID"];

        $query = "INSERT INTO `Dormitories` (`memberID`, `dormName` , `dormitory_rate` , `status`) VALUES ($memberID, '$dorm_name' , $dorm_rate , 'Disable');";

        if (mysqli_query($con, $query)) {
            $query = "select max(dormID) from Dormitories";
            $id_result = mysqli_query($con, $query);
            $id_row = mysqli_fetch_array($id_result);
            $dorm_fac_id = $id_row[0];
            $fac_query = "INSERT INTO `FacilitiesInDorm` (`dormID`) VALUES($dorm_fac_id);";
            mysqli_query($con, $fac_query);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function reject_dormitory($confirmID) {
    require 'connection.php';
    $query = "update ConfirmationDorm set approval = 'Reject' , noti_status = 1 where confirmID = $confirmID ";

    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["approval_submit"]) && is_numeric($_GET["approval_submit"]) && isset($_GET["dorm_rate"]) && is_numeric($_GET["dorm_rate"])) {
    if (approve_dormitory($_GET["approval_submit"], $_GET["dorm_rate"])) {
        echo "Approve<script>alert('Approval Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=checkRequestDorm';</script>";
    } else {
        echo "Approve<script>alert('Approval Failed')</script>";
    }
}

if (isset($_GET["reject_submit"]) && is_numeric($_GET["reject_submit"])) {
    if (reject_dormitory($_GET["reject_submit"])) {
        echo "Reject<script>alert('Reject Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=checkRequestDorm';</script>";
    } else {
        echo "Reject<script>alert('Reject Failed')</script>";
    }
}

// Deleted Room Function

function disabled_room($roomID) {
    require 'connection.php';
    $status = $_GET["room_status"];
    $query = "update Rooms set status = '$status' where roomID = $roomID";

    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["disabled_room"]) && is_numeric($_GET["disabled_room"])) {
    if (disabled_room($_GET["disabled_room"])) {
        echo "<script>alert('Room now " . $_GET["room_status"] . "')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    } else {
        echo "<script>alert('Delete Failed')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    }
}

// Showing and Not Showing Dormitory

function checkingRoom($dormID) {

    require 'connection.php';
    $query = "select * from Rooms where dormID = $dormID";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        return true;
    } else {
        return false;
    }
}

function showing_dorm($dormID, $status) {

    require 'connection.php';

    $query = "update Dormitories set status = '$status' where dormID = $dormID ";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["showing_dorm"]) && is_numeric($_GET["showing_dorm"])) {
    if (showing_dorm($_GET["showing_dorm"], 'Showing')) {
        echo 'Show On Page<script>alert("Your Dormitory is now showing on page.");</script>';
    } else {
        echo 'Hide On Page<script>alert("Empty room type. Please add room before showing on page.");</script>';
    }
}
if (isset($_GET["disabled_dorm"]) && is_numeric($_GET["disabled_dorm"])) {
    if (showing_dorm($_GET["disabled_dorm"], 'Hidden')) {
        echo 'Hide On Page';
    }
}

//check Booking Session
function checkBooking($memberID) {

    require 'connection.php';

    $query = "select * from Booking where memberID = $memberID and  (booking_status = 'Waiting' or booking_status = 'Checking')";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL) {
        return 'Already Booking (Booking ID = ' . $row["bookingID"] . ')';
    } else {
        return 'PASS';
    }
}

function checkRoomAvailable($roomID) {

    require 'connection.php';

    $query = "select roomAvailable from Rooms where roomID = $roomID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row["roomAvailable"] !== '0') {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["memberID"]) && isset($_GET["dormID"]) && isset($_GET["roomID"])) {
    if (is_numeric($_GET["memberID"]) && is_numeric($_GET["dormID"]) && is_numeric($_GET["roomID"])) {
        $dormID = $_GET["dormID"];
        $roomID = $_GET["roomID"];
        $msg = checkBooking($_GET["memberID"]);
        if ($msg !== 'PASS') {
            echo 'Booking<script>alert("' . $msg . '")</script>';
        } else {
            if (checkRoomAvailable($roomID)) {
                echo 'Booking<script>window.location = "index.php?chose_page=book&dormID=' . $dormID . '&roomID=' . $roomID . '"</script>';
            } else {
                echo 'Booking<script>alert("This Room is Unavailable")</script>';
            }
        }
    }
}

//Checking Dormitory

function checkDormitory($memberID) {

    require 'connection.php';

    $query = "select * from Dormitories where memberID = $memberID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["checkdorm_memberID"]) && is_numeric($_GET["checkdorm_memberID"])) {

    $memberID = $_GET["checkdorm_memberID"];
    if (checkDormitory($memberID)) {
        echo 'Check Booking History<script>window.location = "index.php?chose_page=checkDormBooking&memberID=' . $memberID . '" </script>';
    } else {
        echo 'Check Booking History<script>alert("You dont have any dormitoris for booking")</script>';
    }
}

// Show Dormitories Booking

function showDormBook($dormID) {

    require 'connection.php';
    $query = "select * from Booking b join Rooms r where b.roomID=r.roomID and r.dormID=$dormID";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {

        $color = "black";

        switch ($row["booking_status"]) {
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
                $color = "#ffcc33";
                break;
            case "Already Refunded":
                $color = "#00cc33";
                break;
        }

        echo '<tr>';
        echo '<td>' . $row["bookingID"] . '</td>';
        echo '<td>' . $row["roomType"] . '</td>';
        echo '<td>' . $_SESSION["firstname"] . '</td>';
        echo '<td>' . $_SESSION["lastname"] . '</td>';
        echo '<td>' . $row["expire_date"] . '</td>';
        echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
        echo '<td><button type="button" class="btn ">Change Status</button></td>';
        echo '</tr> ';
    }

    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) <= 8) {
        for ($i = 1; $i <= 8 - mysqli_num_rows($result); $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
            echo '</tr>';
        }
    }

    if (mysqli_num_rows($result) == 0) {
        echo '<tr style="height: 51px">';
        echo '<td colspan="8" style="text-align: center"> No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
            echo '</tr>';
        }
    }
}

//Display Dorm Book Page 

function displayBookingPage($cur_page, $dormID) {
    include 'connection.php';
    mysqli_query($con, "SET NAMES UTF8");

    $query = "select bookingID from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID=$dormID";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        $total_page = ceil(mysqli_num_rows($result) / 8);
    } else {
        $total_page = 1;
    }
    if ($cur_page == 1) {
        $prev_page = 1;
    } else {
        $prev_page = $cur_page - 1;
    }
    if ($cur_page == $total_page) {
        $next_page = $cur_page;
    } else {
        $next_page = $cur_page + 1;
    }

    echo '<li><a value=' . $prev_page . ' href="callback.php?dormbook_showpage=' . $prev_page . '">&laquo;</a></li>';
    for ($i = 1; $i <= $total_page; $i++) {
        $class = ($cur_page == $i ? "class = 'active'" : "");
        echo '<li ' . $class . '><a value=' . $i . ' href="callback.php?dormbook_showpage=' . $i . '">' . $i . '</a></li>';
    }
    echo '<li><a value=' . $next_page . ' href="callback.php?dormbook_showpage=' . $next_page . '">&raquo;</a></li>';
}

function getBookingDorm($page, $order_by, $dormID) {
    include 'connection.php';
    mysqli_query($con, "SET NAMES UTF8");

    $limit_start = ((8 * $page) - 8);
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dormID order by $order_by limit $limit_start , 8";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {

        $color = "black";

        switch ($row["booking_status"]) {
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
                $color = "#ffcc33";
                break;
            case "Already Refunded":
                $color = "#00cc33";
                break;
        }

        echo '<tr>';
        echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
        echo '<td>' . $row["firstName"] . '</td>';
        echo '<td>' . $row["lastName"] . '</td>';
        echo '<td>' . $row["date"] . '</td>';
        echo '<td>' . $row["expire_date"] . '</td>';
        echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
        echo '<td><button type="button" style="width:130px" class="viewdetail btn1 btn1-primary" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . number_format($row["totalPrice"]) . '" data-transfername="' . $row["transfer_name"] . '" data-transferbank="' . $row["transfer_bank"] . '" data-floor="' . $row["floor_no"] . " " . getTHNUMBER($row["floor_no"]) . '" data-bankacc="' . $row["bank_acc_id"] . '" data-transferamount="' . number_format($row["transfer_amount"]) . '" data-bankname="' . $row["bank_name"] . '" data-transferrefID="' . $row["transfer_referenceID"] . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
        echo '</tr> ';
    }
    if (mysqli_num_rows($result) != 8 && mysqli_num_rows($result) != 0) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="7"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) === 0) {
        echo '<tr style="height: 51px">';
        echo '<td colspan="7" style="text-align: center"> No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="7"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["showbook_dormID"]) && isset($_GET["dormbook_showpage"]) && isset($_GET["dormbook_order"])) {
    if (is_numeric($_GET["showbook_dormID"]) && is_numeric($_GET["dormbook_showpage"])) {
        getBookingDorm($_GET['dormbook_showpage'], $_GET["dormbook_order"], $_GET["showbook_dormID"]);
    } else {
        echo '<tr style="height: 51px">';
        echo '<td colspan="7" style="text-align: center"> Something Error</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="7"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["dormbook_page"]) && isset($_GET["showpage_dormID"])) {
    if (is_numeric($_GET["dormbook_page"]) && is_numeric($_GET["showpage_dormID"])) {
        displayBookingPage($_GET["dormbook_page"], $_GET["showpage_dormID"]);
    } else {
        echo '<script>alert("something error");</script>';
    }
}

//SPLIT PAGE METHOD ..

function displayCommentPage($cur_page, $query, $href) {

    require 'connection.php';

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) !== 0) {
        $total_page = ceil(mysqli_num_rows($result) / 4);
    } else {
        $total_page = 1;
    }
    if ($cur_page == 1) {
        $prev_page = 1;
    } else {
        $prev_page = $cur_page - 1;
    }
    if ($cur_page == $total_page) {
        $next_page = $cur_page;
    } else {
        $next_page = $cur_page + 1;
    }

    echo '<li><a value=' . $prev_page . ' href="' . $href . $prev_page . '">&laquo;</a></li>';
    for ($i = 1; $i <= $total_page; $i++) {
        $class = ($cur_page == $i ? "class = 'active'" : "");
        echo '<li ' . $class . '><a value=' . $i . ' href="' . $href . $i . '">' . $i . '</a></li>';
    }
    echo '<li><a value=' . $next_page . ' href="' . $href . $next_page . '">&raquo;</a></li>';
}

function displayPage($cur_page, $query, $href) {

    require 'connection.php';

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) !== 0) {
        $total_page = ceil(mysqli_num_rows($result) / 8);
    } else {
        $total_page = 1;
    }
    if ($cur_page == 1) {
        $prev_page = 1;
    } else {
        $prev_page = $cur_page - 1;
    }
    if ($cur_page == $total_page) {
        $next_page = $cur_page;
    } else {
        $next_page = $cur_page + 1;
    }

    echo '<li><a value=' . $prev_page . ' href="' . $href . $prev_page . '">&laquo;</a></li>';
    for ($i = 1; $i <= $total_page; $i++) {
        $class = ($cur_page == $i ? "class = 'active'" : "");
        echo '<li ' . $class . '><a value=' . $i . ' href="' . $href . $i . '">' . $i . '</a></li>';
    }
    echo '<li><a value=' . $next_page . ' href="' . $href . $next_page . '">&raquo;</a></li>';
}

// GET REQUEST DORMITORY 

function getRequestDorm($page, $order_by) {

    require 'connection.php';

    $limit_start = ((8 * $page) - 8);
    $query = "select * from ConfirmationDorm order by $order_by limit $limit_start , 8";

    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td style="text-align:center">' . $row["confirmID"] . '</td>';
        echo '<td style="text-align:center">' . $row["memberID"] . '</td>';
        echo '<td>' . $row["dormName"] . '</td>';
        echo '<td>' . $row["license"] . '</td>';
        echo '<td>' . $row["date"] . '</td>';
        if ($row["approval"] == "Reject") {
            echo '<td style="color: red" >' . $row["approval"] . '</td>';
        } else if ($row["approval"] == "Waiting") {
            echo '<td style="color: black">' . $row["approval"] . '</td>';
        } else {
            echo '<td style="color: green">' . $row["approval"] . '</td>';
        }
        echo '<td><a href="index.php?chose_page=checkRequestDetail&confirmID=' . $row["confirmID"] . '"><button type="button" class="btn1 btn1-primary" style="width:100%">View Detail</button></a></td>';
        echo '</tr>';
    }
    if (mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
    if (mysqli_num_rows($result) === 0) {
        echo '<tr><td colspan="7"> No Result </td></tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
}

if (isset($_GET["request_dormpage"]) && isset($_GET["request_orderby"])) {
    if (is_numeric($_GET["request_dormpage"])) {
        getRequestDorm($_GET["request_dormpage"], $_GET["request_orderby"]);
    } else {
        echo '<tr><td colspan="8">Error</td></tr>';
    }
}

if (isset($_GET["request_curpage"]) && is_numeric($_GET["request_curpage"])) {
    $query = "select confirmID from ConfirmationDorm";
    $href = "callback.php?request_dormpage=";
    displayPage($_GET["request_curpage"], $query, $href);
}

// REQUEST SEARCHING

function searchingRequest($query) {

    require 'connection.php';

    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<td style="text-align:center">' . $row["confirmID"] . '</td>';
            echo '<td style="text-align:center">' . $row["memberID"] . '</td>';
            echo '<td>' . $row["dormName"] . '</td>';
            echo '<td>' . $row["license"] . '</td>';
            echo '<td>' . $row["date"] . '</td>';
            if ($row["approval"] == "Rejected") {
                echo '<td style="color: red" >' . $row["approval"] . '</td>';
            } else if ($row["approval"] == "Waiting") {
                echo '<td style="color: black">' . $row["approval"] . '</td>';
            } else {
                echo '<td style="color: green">' . $row["approval"] . '</td>';
            }
            echo '<td><a href="index.php?chose_page=checkRequestDetail&confirmID=' . $row["confirmID"] . '"><button type="button" class="btn1 btn1-primary" style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7" style="text-align:center"> No Result </td></tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
    if (mysqli_num_rows($result) !== 8 && mysqli_num_rows($result) !== 0) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
}

if (isset($_GET["request_searching"])) {
    if ($_GET["request_searching"] !== "") {
        if (isset($_GET["search_only"])) {
            $search_value = filter_var($_GET["request_searching"], FILTER_SANITIZE_STRING);
            $search_only = filter_var($_GET["search_only"], FILTER_SANITIZE_STRING);
            $query = "select * from ConfirmationDorm where $search_only like '%$search_value%' limit 0 , 8";
            searchingRequest($query);
        } else {
            $search_value = filter_var($_GET["request_searching"], FILTER_SANITIZE_STRING);
            $query = "select * from ConfirmationDorm where confirmID = '$search_value' or memberID = '$search_value' or dormName like '%$search_value%' or license like '%$search_value%' or date like '%$search_value%' limit 0 , 8";
            searchingRequest($query);
        }
    } else {
        getRequestDorm(1, "date desc");
    }
}

//Booking Searching for Owner

function searchingBook($query) {

    require 'connection.php';
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "black";

            switch ($row["booking_status"]) {
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
                    $color = "#ffcc33";
                    break;
                case "Already Refunded":
                    $color = "#00cc33";
                    break;
            }

            echo '<tr>';
            echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
            echo '<td>' . $row["firstName"] . '</td>';
            echo '<td>' . $row["lastName"] . '</td>';
            echo '<td>' . $row["date"] . '</td>';
            echo '<td>' . $row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
            echo '<td><button type="button" style="width:130px" class="viewdetail btn1 btn1-primary" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . number_format($row["totalPrice"]) . '" data-transfername="' . $row["transfer_name"] . '" data-transferbank="' . $row["transfer_bank"] . '" data-floor="' . $row["floor_no"] . '" data-bankacc="' . $row["bank_acc_id"] . '" data-bankname="' . $row["bank_name"] . '" data-transferrefID="' . $row["transfer_referenceID"] . '" data-transferamount="' . number_format($row["transfer_amount"]) . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
            echo '</tr> ';
        }
    } else {
        echo '<tr style="height: 51px">';
        echo '<td colspan="7" style="text-align: center"> No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="7"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) <= 8) {
        for ($i = 1; $i <= 8 - mysqli_num_rows($result); $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="7"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["booking_searching"]) && isset($_GET["dormbook_id"]) && is_numeric($_GET["dormbook_id"]) && $_GET["booking_searching"] !== "\\") {
    $search_value = filter_var($_GET["booking_searching"], FILTER_SANITIZE_SPECIAL_CHARS);
    $dorm_id = $_GET["dormbook_id"];
    if ($_GET["booking_searching"] !== "") {
        if (isset($_GET["search_only"])) {
            $page = 1;
            if (isset($_GET["search_date_page"])) {
                $page = $_GET["search_date_page"];
            }
            $limit_start = ((8 * $page) - 8);
            $type = "like";
            if ($_GET["search_only"] === "bookingID") {
                $type = "=";
            }
            if ($_GET["search_only"] == "expire_date" || $_GET["search_only"] == "booking_status" || $_GET["search_only"] == "date") {
                $search_value = "%" . $search_value . "%";
            }
            $booksearch_only = $_GET["search_only"];
            $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dorm_id and $booksearch_only $type '$search_value' order by date limit $limit_start , 8";
            searchingBook($query);
        } else {
            $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dorm_id and (bookingID like '$search_value' or date like '%$search_value%' or expire_date like '%$search_value%' or booking_status like '%$search_value%' or roomType like '%$search_value%' or firstName like '%$search_value%' or lastName like '%$search_value%') order by date desc limit 0 , 8 ";
            searchingBook($query);
        }
    } else {
        getBookingDorm(1, "date desc", $dorm_id);
    }
}

if (isset($_GET["dormbookID"]) && is_numeric($_GET["dormbookID"]) && isset($_GET["search_by_status"])) {

    $dormID = $_GET["dormbookID"];
    $status = $_GET["search_by_status"];
    $page = 1;
    if (isset($_GET["search_status_page"])) {
        $page = $_GET["search_status_page"];
    }
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dormID and booking_status='$status' order by date desc limit $limit_start , 8";
    searchingBook($query);
}

if (isset($_GET["search_status_page"]) && is_numeric($_GET["search_status_page"]) && isset($_GET["search_by_status"]) && isset($_GET["dormID"])) {
    $dormID = $_GET["dormID"];
    $status = $_GET["search_by_status"];
    $cur_page = $_GET["search_status_page"];
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dormID and booking_status = '$status'";
    $href = 'callback.php?search_status_page=';
    displayPage($cur_page, $query, $href);
}

if (isset($_GET["dormbook_id"]) && isset($_GET["search_date"]) && isset($_GET["search_date_page"])) {

    $dormID = $_GET["dormbook_id"];
    $search_date = $_GET["search_date"];
    $cur_page = $_GET["search_date_page"];
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and f.dormID= $dormID and date like '%$search_date%'";
    $href = "callback.php?search_date_page=";
    displayPage($cur_page, $query, $href);
}

//Incoming Display Member Booking Page

function getMembook($member_id, $page) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Booking b join Dormitories d join Rooms r where b.roomID = r.roomID and b.memberID = $member_id group by bookingID order by date desc limit $limit_start , 8 ";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($book_row = mysqli_fetch_array($result)) {

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
                    $color = "#ffcc33";
                    break;
                case "Already Refunded":
                    $color = "#00cc33";
                    break;
            }
            echo '<tr>';
            echo '<td><p style = "margin-left:20px">' . $book_row["bookingID"] . '</p></td>';
            echo '<td><p style="margin-left:20px">' . $book_row["dormName"] . '</p></td>';
            echo '<td>' . $book_row["roomType"] . '</td>';
            echo '<td>' . $book_row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $book_row["booking_status"] . '</td>';
            echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $book_row["bookingID"] . '" type="button" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr style="height:49px">';
        echo '<td style="text-align:center" colspan="6">No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height:49px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height:49px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["membook_showpage"]) && is_numeric($_GET["membook_showpage"])) {
    getMembook($_SESSION["memberID"], $_GET["membook_showpage"]);
}

if (isset($_GET["membook_curpage"]) && is_numeric($_GET["membook_curpage"])) {
    $cur_page = $_GET["membook_curpage"];
    $memberID = $_SESSION["memberID"];
    $href = "callback.php?membook_showpage=";
    $query = "select bookingID from Booking where memberID = $memberID ";
    displayPage($cur_page, $query, $href);
}

//Member Cancel Booking

function cancelBooking($bookingID) {

    require 'connection.php';
    $query = "update Booking set booking_status = 'Canceled' where bookingID = $bookingID";

    if (mysqli_query($con, $query)) {
        $query = "select matchingID from Booking where bookingID = $bookingID";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $matchingID = $row[0];
        $query = "update RoomPerFloor set roomPerFloor = roomPerFloor + 1 where matchingID = $matchingID";
        if (mysqli_query($con, $query)) {
            return true;
        }
    } else {
        return false;
    }
}

if (isset($_GET["cancel_booking"]) && is_numeric($_GET["cancel_booking"])) {

    $bookingID = $_GET["cancel_booking"];
    if (cancelBooking($bookingID)) {
        echo 'Cancel This Booking <script>alert("Cancel Booking Success")</script>';
        echo '<script>window.location = "index.php?chose_page=checkBookingHis"</script>';
    } else {
        echo 'Cancel This Booking <script> alert("Cant Cancel This Booking")</script>';
    }
}

//Change Booking Status Function

function change_booking($bookID, $status) {

    require 'connection.php';
    $noti = "";
    if ($status === "Approve" || $status === "Reject" || $status === "Refund Needed" || $status === "Already Refunded") {
        $noti = ", member_noti = 1";
    }
    $query = "update Booking set booking_status = '$status' $noti where bookingID = $bookID";
    if (mysqli_query($con, $query)) {
        if ($status === "Reject" || $status === "Canceled" || $status === "Refund Needed") {
            $query = "select matchingID from Booking where bookingID = $bookID";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_array($result);
            $plus_room_query = "update RoomPerFloor set roomPerFloor = roomPerFloor + 1 where matchingID = $row[0]";
            if (mysqli_query($con, $plus_room_query)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["change_booking_status"]) && isset($_GET["change_booking_id"]) && is_numeric($_GET["change_booking_id"])) {

    $status = filter_var($_GET["change_booking_status"]);
    $bookID = $_GET["change_booking_id"];
    change_booking($bookID, $status);
}

//Member Searching Book

function searchingMemberBook($query) {

    require 'connection.php';
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) !== 0) {
        while ($book_row = mysqli_fetch_array($result)) {

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
                    $color = "#ffcc33";
                    break;
                case "Already Refunded":
                    $color = "#00cc33";
                    break;
            }
            echo '<tr>';
            echo '<td><p style = "margin-left:20px">' . $book_row["bookingID"] . '</p></td>';
            echo '<td><p style="margin-left:20px">' . $book_row["dormName"] . '</p></td>';
            echo '<td>' . $book_row["roomType"] . '</td>';
            echo '<td>' . $book_row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $book_row["booking_status"] . '</td>';
            echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $book_row["bookingID"] . '" type="button" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr style="height:49px">';
        echo '<td style="text-align:center" colspan="6">No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height:49px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height:49px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["search_member_value"])) {
    $value = filter_var($_GET["search_member_value"], FILTER_SANITIZE_STRING);
    $memberID = $_SESSION["memberID"];
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and b.memberID = $memberID and bookingID like '%$value%' group by bookingID order by date desc limit 0 , 8";
    searchingMemberBook($query);
}

if (isset($_GET["sortby_memberbooking"]) && isset($_GET["sortby_memberbooking_page"]) && is_numeric($_GET["sortby_memberbooking_page"])) {

    $sort_by = filter_var($_GET["sortby_memberbooking"], FILTER_SANITIZE_STRING);
    if ($sort_by == "date") {
        $sort_by = "date desc";
    }
    $memberID = $_SESSION["memberID"];
    $limit_start = ((8 * $_GET["sortby_memberbooking_page"]) - 8);
    $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and b.memberID = $memberID group by bookingID order by $sort_by limit $limit_start , 8";
    searchingMemberBook($query);
}

if (isset($_GET["sortby_memberbooking_curpage"]) && is_numeric($_GET["sortby_memberbooking_curpage"]) && isset($_GET["sortby_membook"])) {

    $memberID = $_SESSION["memberID"];
    $sort_by = $_GET["sortby_membook"];
    $query = "select bookingID from Booking where memberID = $memberID ";
    $href = "callback.php?sortby_memberbooking=" . $sort_by . "&sortby_memberbooking_page=";
    $cur_page = $_GET["sortby_memberbooking_curpage"];
    displayPage($cur_page, $query, $href);
}

// Checking Dorm Info

function getAllDorm($page, $order_by) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select dormID,dormName,firstName,lastName,d.type,d.status from Dormitories d join Members m where d.memberID = m.memberID order by $order_by limit $limit_start,8";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "red";
            if ($row["status"] == "Showing") {
                $color = "#00cc33";
            }

            echo "<tr>";
            echo '<td style="text-align: center">' . $row["dormID"] . '</td>';
            echo '<td>' . $row["dormName"] . '</td>';
            echo '<td>' . $row["firstName"] . $row["lastName"] . '</td>';
            echo '<td>' . $row["type"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["status"] . '</td>';
            echo '<td><a href="index.php?chose_page=checkDormDetail&getdorm=' . $row["dormID"] . '"><button type="button" class="btn1 btn1-primary pull-right " style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr style="height:47px">';
        echo '<td style="text-align:center" colspan="6">No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height:47px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height:47px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
}

function searchDormitories($query) {
    require 'connection.php';
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "red";
            if ($row["status"] == "Showing") {
                $color = "#00cc33";
            }

            echo "<tr>";
            echo '<td style="text-align: center">' . $row["dormID"] . '</td>';
            echo '<td>' . $row["dormName"] . '</td>';
            echo '<td>' . $row["firstName"] . $row["lastName"] . '</td>';
            echo '<td>' . $row["type"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["status"] . '</td>';
            echo '<td><a href="index.php?chose_page=checkDormDetail&getdorm=' . $row["dormID"] . '"><button type="button" class="btn1 btn1-primary pull-right " style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr style="height:47px">';
        echo '<td style="text-align:center" colspan="6">No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height:47px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height:47px">';
            echo '<td style="text-align:center" colspan="6"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["checkdorm_currentpage"]) && is_numeric($_GET["checkdorm_currentpage"])) {
    $page = $_GET["checkdorm_currentpage"];
    getAllDorm($page, "dormID");
}

if (isset($_GET["checkdorm_showpage"]) && is_numeric($_GET["checkdorm_showpage"])) {
    $href = "callback.php?checkdorm_currentpage=";
    $query = "select * from Dormitories";
    if (isset($_GET["sortby_dorm"])) {
        $sort_by = $_GET["sortby_dorm"];
        $href = "callback.php?sortby_dormitories=" . $sort_by . "&sortby_dormitories_page=";
    }
    displayPage($_GET["checkdorm_showpage"], $query, $href);
}

if (isset($_GET["search_dormitories"])) {
    $value = $_GET["search_dormitories"];
    $query = "select dormID,dormName,firstName,lastName,d.type,d.status from Dormitories d join Members m where d.memberID = m.memberID and  (dormID like '%$value%' or dormName like '%$value%' or firstName like '%$value%' or lastName like '%$value%' or d.type like '%$value%' or d.status like '%$value%') limit 0,8";
    searchDormitories($query);
}

if (isset($_GET["sortby_dormitories"]) && isset($_GET["sortby_dormitories_page"]) && is_numeric($_GET["sortby_dormitories_page"])) {
    $order_by = $_GET["sortby_dormitories"];
    if ($order_by == "type") {
        $order_by = "type desc";
    }
    getAllDorm($_GET["sortby_dormitories_page"], $order_by);
}

//Get All Members
function getAllMember($page, $order_by) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Members order by $order_by limit $limit_start , 8";

    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "black";
            switch ($row["type"]) {
                case "Member":
                    $color = "#00cc33";
                    break;
                case "Owner":
                    $color = "#0480be";
                    break;
                case "Admin":
                    $color = "red";
                    break;
            }

            $bl_color = "black";
            if ($row["status"] === "Blacklist") {
                $bl_color = "red";
            }

            echo '<tr>';
            echo '<td style="text-align: center;">' . $row["memberID"] . '</td>';
            echo '<td>' . $row["username"] . '</td>';
            echo '<td>' . $row["firstName"] . '</td>';
            echo '<td>' . $row["lastName"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["type"] . '</td>';
            echo '<td style="color:' . $bl_color . '">' . $row["status"] . '</td>';
            echo '<td>' . $row["tel"] . '</td>';
            echo '<td><a href="index.php?chose_page=memberInfo&memberID=' . $row["memberID"] . '"><button type="button" class="btn1 btn1-primary" style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}

function searchingMembers($query) {

    require 'connection.php';
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "black";
            switch ($row["type"]) {
                case "Member":
                    $color = "#00cc33";
                    break;
                case "Owner":
                    $color = "#0480be";
                    break;
                case "Admin":
                    $color = "red";
                    break;
            }

            $bl_color = "black";
            if ($row["status"] === "Blacklist") {
                $bl_color = "red";
            }

            echo '<tr>';
            echo '<td style="text-align: center">' . $row["memberID"] . '</td>';
            echo '<td>' . $row["username"] . '</td>';
            echo '<td>' . $row["firstName"] . '</td>';
            echo '<td>' . $row["lastName"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["type"] . '</td>';
            echo '<td style="color:' . $bl_color . '">' . $row["status"] . '</td>';
            echo '<td>' . $row["tel"] . '</td>';
            echo '<td><a href="index.php?chose_page=memberInfo&memberID=' . $row["memberID"] . '"><button type="button" class="btn1 btn1-primary" style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["show_member_page"]) && is_numeric($_GET["show_member_page"])) {

    $page = $_GET["show_member_page"];
    $sort_by = "memberID";
    if (isset($_GET["sortby_member"])) {
        $sort_by = $_GET["sortby_member"];
    }
    getAllMember($page, $sort_by);
}

if (isset($_GET["show_member_curpage"]) && is_numeric($_GET["show_member_curpage"])) {
    $query = "select * from Members";
    $href = "callback.php?show_member_page=";
    if (isset($_GET["sortby_member"])) {
        $sort_by = $_GET["sortby_member"];
        $href = "callback.php?sortby_member=$sort_by&show_member_page=";
    }
    displayPage($_GET["show_member_curpage"], $query, $href);
}

if (isset($_GET["search_members"])) {

    $value = filter_var($_GET["search_members"], FILTER_SANITIZE_STRING);
    $query = "select * from Members where ( memberID like '%$value%' or firstName like '%$value%'  or lastName like '%$value%' or username like '%$value%' or idCard like '%$value%' or email like '%$value%' ) limit 0 , 8";
    searchingMembers($query);
}

if (isset($_GET["sortby_member"]) && isset($_GET["sortby_member_page"])) {
    $sort_by = $_GET["sortby_member"];
    $page = $_GET["sortby_member_page"];
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Members order by $sort_by limit $limit_start , 8";
    searchingMembers($query);
}

// Comment Dormitory
function commentDorm($dormID, $memberID, $detail, $rate) {

    require 'connection.php';
    $query = "INSERT INTO `Comment` (`memberID`, `dormID`, `detail`, `date`, `rating`) VALUES ( $memberID, $dormID, '$detail', NOW(), $rate);";

    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["comment_value"]) && isset($_GET["comment_dormID"]) && isset($_GET["comment_memberID"]) && isset($_GET["comment_rate"])) {
    if (is_numeric($_GET["comment_dormID"]) && is_numeric($_GET["comment_memberID"]) && is_numeric($_GET["comment_rate"])) {
        $detail = filter_var($_GET["comment_value"], FILTER_SANITIZE_STRING);
        $memberID = $_GET["comment_memberID"];
        $dormID = $_GET["comment_dormID"];
        $rate = $_GET["comment_rate"];
        if (commentDorm($dormID, $memberID, $detail, $rate)) {
            getComment($dormID, 1);
        } else {
            echo '<script>alert("Cannot Comment This");</script>';
        }
    }
}

function updateBooking() {
    require 'connection.php';

    $query = "select * from Booking where booking_status = 'Waiting'";
    $result = mysqli_query($con, $query);
    $update_row = 0;
    $time_now = substr(strtr(substr(date("c"), 0, 19), "T", " "), 11, 19);
    $date_now = strtr(substr(date("c"), 0, 19), "T", " ");
    while ($row = mysqli_fetch_array($result)) {

        $bookingID = $row["bookingID"];
        $expire_time = $row["expire_date"];
        if ($expire_time <= $date_now) { // Check Date Time
            if (substr($expire_time, 11, 19) < $time_now) { // Check Time
                $update_query = "update Booking set booking_status = 'Reject' where bookingID = $bookingID";
                if (mysqli_query($con, $update_query)) {
                    $roomID = $row["roomID"];
                    $plus_room_query = "update Rooms set roomAvailable = roomAvailable + 1 where roomID = $roomID";
                    if (mysqli_query($con, $plus_room_query)) {
                        $update_row = $update_row + 1;
                    }
                }
            }
        }
    }
    return $update_row;
}

if (isset($_GET["updateBooking"])) {
    $update_row = updateBooking();
    echo 'UpdateBooking<script>alert("update ' . $update_row . ' rows")</script>';
}

//Add Blacklist 
function addBlacklist($memberID, $reason) {
    require 'connection.php';
    $query = "update Members set status = 'Blacklist' , status_reason = '$reason' where memberID = $memberID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

function removeBlacklist($memberID) {
    require 'connection.php';
    $query = "update Members set status = 'Normal' where memberID = $memberID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["addblacklist"]) && is_numeric($_GET["addblacklist"]) && isset($_GET["blacklist_reason"])) {
    $memberID = $_GET["addblacklist"];
    $reason = filter_var($_GET["blacklist_reason"], FILTER_SANITIZE_STRING);
    if (addBlacklist($memberID, $reason)) {
        echo 'Add to Blacklist<script>alert("Add member to blacklist Success"); window.location = "index.php?chose_page=memberInfo&memberID=' . $memberID . '"</script>';
    } else {
        echo 'Add to Blacklist<script>alert("Add member to blacklist failed"); window.location = "index.php?chose_page=memberInfo&memberID=' . $memberID . '"</script>';
    }
}

if (isset($_GET["removeblacklist"]) && is_numeric($_GET["removeblacklist"])) {
    $memberID = $_GET["removeblacklist"];
    if (removeBlacklist($memberID)) {
        echo 'Remove Blacklist<script>alert("Remove blacklist success"); window.location = "index.php?chose_page=memberInfo&memberID=' . $memberID . '"</script>';
    } else {
        echo 'Remove Blacklist<script>alert("Remove blacklist failed"); window.location = "index.php?chose_page=memberInfo&memberID=' . $memberID . '"</script>';
    }
}

//Get Owner Notification
function readAble($bookingID) {

    require 'connection.php';
    $query = "update Booking set owner_noti = 2 where bookingID = $bookingID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

function getAllNotification($cur_page, $order_by, $status_value) {
    require 'connection.php';
    if ($order_by === "date") {
        $order_by = "date desc";
    }
    if ($order_by === "booking_status") {
        $order_by = "booking_status";
    }
    $limit_start = ((8 * $cur_page) - 8);
    $memberID = $_SESSION["memberID"];
    if ($status_value === "") {
        $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and (owner_noti = 1 or owner_noti = 2) order by $order_by limit $limit_start,8";
    } else {
        $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and (owner_noti = 1 or owner_noti = 2) and booking_status = '$status_value' limit $limit_start,8";
    }
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $unread = "";
            if ($row["owner_noti"] == "1") {
                $unread = 'style="background-color:#f9f9f9"';
            }
            $color = "black";

            switch ($row["booking_status"]) {
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
                    $color = "#ffcc33";
                    break;
                case "Already Refunded":
                    $color = "#00cc33";
                    break;
            }
            echo '<tr ' . $unread . '>';
            echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
            echo '<td>' . $row["firstName"] . " " . $row["lastName"] . '</td>';
            echo '<td>' . $row["date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
            echo '<td>' . $row["dormTel"] . '</td>';
            echo '<td><button type="button" style="width:130px" class="viewdetail btn1 btn1-primary" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . number_format($row["totalPrice"]) . '" data-transfername="' . $row["transfer_name"] . '" data-transferbank="' . $row["transfer_bank"] . '" data-transferamount="' . number_format($row["transfer_amount"]) . '" data-floor="' . $row["floor_no"] . '" data-bankacc="' . $row["bank_acc_id"] . '" data-bankname="' . $row["bank_name"] . '" data-transferrefID="' . $row["transfer_referenceID"] . '" data-transferamount="' . $row["transfer_amount"] . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
            echo '</tr>';
            if ($row["owner_noti"] == "1") {
                if (!readAble($row["bookingID"])) {
                    echo '<script>alert("something error")<script>';
                    break;
                }
            }
        }
    } else {
        echo '<tr>';
        echo '<td colspan="6" style="text-align:center">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="6" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="6" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["ownernoti_orderby"]) && isset($_GET["ownernoti_curpage"])) {
    $status_value = "";
    if (isset($_GET["search_ownernoti"])) {
        $status_value = $_GET["search_ownernoti"];
    }
    $order_by = filter_var($_GET["ownernoti_orderby"], FILTER_SANITIZE_STRING);
    getAllNotification($_GET["ownernoti_curpage"], $order_by, $status_value);
}

if (isset($_GET["owner_noti_curpage"]) && is_numeric($_GET["owner_noti_curpage"])) {
    $cur_page = $_GET["owner_noti_curpage"];
    $memberID = $_SESSION["memberID"];
    $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and (owner_noti = 1 or owner_noti = 2) ";
    $href = "callback.php?owner_noti_curpage=";
    if (isset($_GET["search_ownernoti"])) {
        $status = $_GET["search_ownernoti"];
        $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and b.booking_status = '$status' and (owner_noti = 1 or owner_noti = 2)";
    }
    
    displayPage($cur_page, $query, $href);
}

// Change Password AJAX
function change_password($oldpass, $newpass) {

    require 'connection.php';
    $change_pass = false;
    $memberID = $_SESSION["memberID"];
    $query = "select password from Members where memberID = $memberID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($row !== NULL && $row[0] === md5($oldpass)) {
        $newpass = md5($newpass);
        $update_query = "update Members set password = '$newpass' where memberID = $memberID";
        if (mysqli_query($con, $update_query)) {
            $change_pass = true;
        }
    }
    return $change_pass;
}

if (isset($_POST["change_pass"]) && isset($_POST["oldpass"]) && isset($_POST["newpass"]) && isset($_POST["confirm_newpass"])) {

    $oldpass = filter_var($_POST["oldpass"], FILTER_SANITIZE_STRING);
    $newpass = filter_var($_POST["newpass"], FILTER_SANITIZE_STRING);
    $confirm_newpass = filter_var($_POST["confirm_newpass"], FILTER_SANITIZE_STRING);

    if ($confirm_newpass === $newpass) {
        if (change_password($oldpass, $newpass)) {
            echo 'Change Password Success';
        } else {
            echo 'Change Password Failed';
        }
    }
}

//Get Comment Page

function getComment($dormID, $page) {
    require 'connection.php';

    $limit_start = ((4 * $page ) - 4);
    $query = "select * from Comment c join Members m where c.memberID = m.memberID and c.dormID = $dormID order by date desc limit $limit_start , 4";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $star = "";
        $date = substr(date("r", strtotime($row["date"])), 0, 25);

        for ($i = 1; $i <= $row["rating"]; $i++) {
            $star = $star . "&#9733;";
        }
        for ($i = 1; $i <= 5 - $row["rating"]; $i++) {
            $star = $star . "&#9734;";
        }

        echo '<tr>';
        echo '<td style="width:20%;height:15%">';
        echo '<img src="' . $row["pic_path"] . '" class="img-rounded"';
        echo '</td>';
        echo '<td style="width:250px;height:15%">';
        echo '<h3 style="margin-top:0%">' . $row["firstName"] . " " . substr($row["lastName"], 0, 1) . '.' . '</h3>';
        echo '<p class="pull-left">' . $date . '<br>Give Rate :<span class="pull-right" style="color:gold">' . $star . '</span></p>';
        echo '';
        echo '</td>';
        echo '<td style="padding-top:1%"><h4><span>' . $row["detail"] . '</span></h4></td>';
        echo '</tr>';
    }

    if (mysqli_num_rows($result) === 0) {
        echo '<tr>';
        echo '<td colspan="2" style="height:121px"> No Comment</td>';
        echo '</tr>';
    }
}

function getRating($dormID) {

    require 'connection.php';
    $query = "select rating from Comment where dormID = $dormID";
    $result = mysqli_query($con, $query);
    $allcomment = mysqli_num_rows($result);
    $allrate = 0;
    $rating = 0;
    while ($row = mysqli_fetch_array($result)) {
        $allrate = $allrate + $row[0];
    }
    if ($allcomment !== 0) {
        $rating = $allrate / $allcomment;
    }
    return $rate = array($rating, $allcomment);
}

function calStar($number) {
    $star = "";
    $number = ceil($number);
    for ($i = 1; $i <= $number; $i++) {
        $star = $star . "&#9733;";
    }
    for ($i = 1; $i <= 5 - $number; $i++) {
        $star = $star . "&#9734;";
    }
    return $star;
}

if (isset($_GET["comment_page"]) && isset($_GET["comment_dormID"])) {
    if (is_numeric($_GET["comment_page"]) && is_numeric($_GET["comment_dormID"])) {
        $dormID = $_GET["comment_dormID"];
        $page = $_GET["comment_page"];
        getComment($dormID, $page);
    }
}

if (isset($_GET["request_comment_page"]) && is_numeric($_GET["request_comment_page"]) && isset($_GET["request_comment_dormID"]) && is_numeric($_GET["request_comment_dormID"])) {
    $dormID = $_GET["request_comment_dormID"];
    $page_query = "select * from Comment where dormID = $dormID";
    $cur_page = $_GET["request_comment_page"];
    $page_href = "callback.php?comment_page=";
    displayCommentPage($cur_page, $page_query, $page_href);
}

if (isset($_GET["comment_rating"]) && is_numeric($_GET["comment_rating"])) {
    $dormID = $_GET["comment_rating"];
    $rate = getRating($dormID);
    $star = calStar($rate[0]);
    echo '<h4 style="font-style:italic">Review Rate : <span style="color:gold">' . $star . ' </span><br><small class="pull-right">from ' . $rate[1] . ' Reviews</small></h4>';
}

//Function Advance Search Dormitories

function filter_dorm($type, $disFromUni, $start_price, $end_price, $rate, $road) {

    require 'connection.php';

    if ($type === "all") {
        $type = "";
    } else {
        $type = "d.type = '" . $type . "' and";
    }
    if ($disFromUni === 'all') {
        $disFromUni = "";
    } else {
        $disFromUni = "d.DisFromUni " . $disFromUni . " and";
    }
    if ($start_price === "") {
        $start_price = "0";
    }
    if ($end_price === "") {
        $end_price = "1000000";
    }
    if ($rate === "all") {
        $rate = "";
    } else {
        $rate = "and d.dormitory_rate = " . $rate;
    }
    if ($road === "all") {
        $road = "";
    } else {
        $road = "and d.road like '%" . $road . "%'";
    }




    $query = "select * from Dormitories d join Rooms r join Floor f join RoomPerFloor rpf where d.dormID = f.dormID and f.floorID = rpf.floorID and rpf.roomID = r.roomID and d.status = 'Showing' and $type $disFromUni ( r.price >=$start_price and r.price <= $end_price ) $rate $road group by d.dormID";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $dormID = $row["dormID"];
            $room_query = "select min(price) as minprice , max(price) as maxprice from Dormitories d join Rooms r join Floor f join RoomPerFloor rpf where d.dormID = f.dormID and f.floorID = rpf.floorID and rpf.roomID = r.roomID and d.status = 'Showing' and r.status = 'Complete' and d.dormID = $dormID group by d.dormID";
            $room_result = mysqli_query($con, $room_query);
            $room_row = mysqli_fetch_array($room_result);
            $star = '';
            for ($i = 1; $i <= $row["dormitory_rate"]; $i++) {
                $star = $star . '&#9733;';
            } for ($i = $row["dormitory_rate"]; $i < 5; $i++) {
                $star = $star . '&#9734;';
            }
            echo '<div class = "thumbnail" style = "border:solid 1px black;max-height: 100%;padding:2%;background-color: #eee">';
            echo '<div class = "col-md-6">';
            echo '<img class = "img-rounded" src = "images/dormitory_picture/' . $row["dorm_pictures"] . '" style="width:90%;height: 30%;" alt = "...">';
            echo '</div>';
            echo '<div class = "col-md-6">';
            echo '<legend><h3 style = "margin-top:0px"><span>' . $row["dormName"] . '<span class = "pull-right" style = "color: gold">' . $star . '</span></span></h2></legend>';
            echo '<p style = "text-align:center">';
            echo 'DORMITORY TYPE : ' . $row["type"] . '<br>';
            echo 'DISTANCE FROM UNIVERSITY : ' . $row["disFromUni"] . ' Kilometers<br>';
            if ($room_row["minprice"] === $room_row["maxprice"]) {
                echo 'PRICE RATE : ' . $room_row["maxprice"] . ' BAHT/MONTH<br>';
            } else {
                echo 'PRICE RATE : ' . $room_row["minprice"] . ' - ' . $room_row["maxprice"] . ' BAHT/MONTH<br>';
            }
            echo '<a style = "margin-top:20px;" class = "btn1 btn1-primary" href = "index.php?chose_page=dormdetail&dormID=' . $row["dormID"] . '">View Details</a>';
            echo '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<h2 style="text-align:center"> No Result </h2>';
    }
}

if (isset($_GET["search_dorm"]) && $_GET["search_dorm"] === "true") {

    $disFromUni = $_GET["disFromUni"];
    $type = $_GET["search_dorm_type"];
    if ($type === "FemaleMale") {
        $type = "Female&Male";
    }
    $rate = $_GET["search_dorm_rate"];
    $road = $_GET["search_dorm_road"];
    $start_price = $_GET["search_dorm_stprice"];
    $end_price = $_GET["search_dorm_enprice"];

    filter_dorm($type, $disFromUni, $start_price, $end_price, $rate, $road);
}

// Change Bank Account Status
function change_bank_status($bankID, $status) {
    require 'connection.php';
    $query = "update BankAccount set bank_status = '$status' where bankID = $bankID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["bank_show_status"]) && isset($_GET["bank_id"])) {

    $bankID = $_GET["bank_id"];
    $status = $_GET["bank_show_status"];
    $revert_status = "";
    if ($status === "Showing") {
        $revert_status = "Hiding";
    } else if ($status === "Hiding") {
        $revert_status = "Showing";
    }
    if (change_bank_status($bankID, $status) && ($status === "Showing" | $status === "Hiding")) {
        echo 'Now ' . $status . ' on page ( Click for ' . $revert_status . ' )<script>alert("Now ' . $status . ' on page")</script>';
    } else {
        echo '<script>alert("change status failed")</script>';
    }
}

//Member Notification
function member_readAble($bookingID) {

    require 'connection.php';
    $query = "update Booking set member_noti = 2 where bookingID = $bookingID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}


function getMemberNotification($page, $order_by) {
    require 'connection.php';
    $memberID = $_SESSION["memberID"];
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Booking where memberID = $memberID and (member_noti = 1 or member_noti = 2 or booking_status = 'Waiting') order by $order_by limit $limit_start , 8";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            if ($row["booking_status"] === "Waiting") {
                echo '<tr style="background-color:#f9f9f9">';
                echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                echo '<td>' . $row["date"] . '</td>';
                echo '<td>' . $row["expire_date"] . '</td>';
                echo '<td>This Booking is wating to confirm evidance</td>';
                echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $row["bookingID"] . '" style="width:100%" class="btn1 btn1-success">Click to confirm</a></td>';
                echo '</tr>';
            } else {
                $unread = "";
                if ($row["member_noti"] == "1") {
                    $unread = 'style="background-color:#f9f9f9"';
                }
                $color = "black";

                switch ($row["booking_status"]) {
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
                        $color = "#ffcc33";
                        break;
                    case "Already Refunded":
                        $color = "#00cc33";
                        break;
                }
                echo '<tr ' . $unread . '>';
                echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                echo '<td>' . $row["date"] . '</td>';
                echo '<td>' . $row["expire_date"] . '</td>';
                echo '<td>This Booking change status to <span style="color:' . $color . '">' . $row["booking_status"] . '</span></td>';
                echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $row["bookingID"] . '" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>';
                echo '</tr>';
                if ($row["member_noti"] == "1") {
                    if (!member_readAble($row["bookingID"])) {
                        echo '<script>alert("something error")<script>';
                        break;
                    }
                }
            }
        }
    } else {
        echo '<tr>';
        echo '<td colspan="5" style="text-align:center">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="5" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="5" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["membernoti_orderby"]) && isset($_GET["membernoti_curpage"])) {

    $order_by = filter_var($_GET["membernoti_orderby"], FILTER_SANITIZE_STRING);
    getMemberNotification($_GET["membernoti_curpage"], $order_by);
}

if (isset($_GET["member_noti_curpage"]) && is_numeric($_GET["member_noti_curpage"])) {
    $cur_page = $_GET["member_noti_curpage"];
    $memberID = $_SESSION["memberID"];
    $query = "select * from Booking where memberID = $memberID and (member_noti = 1 or member_noti = 2 or booking_status = 'Waiting')";
    $href = "callback.php?member_noti_curpage=";
    displayPage($cur_page, $query, $href);
}

//Forgot Password

function sendEmail($email) {

    require 'connection.php';

    $query = "select username,memberID,email,password from Members";
    $result = mysqli_query($con, $query);
    $value = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($email === $row['email']) {
            $value = 1;
            $code = md5($row["username"]);
            $link = "http://bangmoddorm.backeyefinder.in.th/index.php?chose_page=resetPassword&memberID=" . $row["memberID"] . "&code=" . $code;
            $msg = "Click here to reset your password : " . $link;
            if (mail($email, "Forgot Password from Bangmoddorm", $msg)) {
                echo 'Forgot Password<script>alert("Send Email Success")</script>';
                break;
            }
        }
    }
    if ($value === 0) {
        echo 'Forgot Password<script>alert("Send Email Failed or Your email has not been in the system.")</script>';
    }
}

if (isset($_GET["forgot_email"])) {
    $email = filter_var($_GET["forgot_email"], FILTER_SANITIZE_EMAIL);
    sendEmail($email);
}
?>

