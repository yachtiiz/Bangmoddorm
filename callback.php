<?php

session_start();

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
    $query = "update ConfirmationDorm set approval = 'Approve' where confirmID = $confirmID ";

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

function reject_dormitory($confirmID){
    require 'connection.php';
    $query = "update ConfirmationDorm set approval = 'Reject' where confirmID = $confirmID ";
    
    if(mysqli_query($con, $query)){
        return true;
    }else{
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

    $query = "update Rooms set status = 'Disabled' where roomID = $roomID";

    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["disabled_room"]) && is_numeric($_GET["disabled_room"])) {
    if (disabled_room($_GET["disabled_room"])) {
        echo "<script>alert('Delete Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    } else {
        echo "<script>alert('Delete Failed')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    }
}

// Showing and Not Showing Dormitory

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
    if (showing_dorm($_GET["showing_dorm"], 'Active')) {
        echo 'Hidden On Page';
    }
}
if (isset($_GET["disabled_dorm"]) && is_numeric($_GET["disabled_dorm"])) {
    if (showing_dorm($_GET["disabled_dorm"], 'Disable')) {
        echo 'Showing On Page';
    }
}

//check Booking Session
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

function checkRoomAvailable($roomID) {

    require 'connection.php';

    $query = "select roomAvailable from rooms where roomID = $roomID";
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

    $query = "select * from dormitories where memberID = $memberID";
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
    $query = "select * from booking b join rooms r where b.roomID=r.roomID and r.dormID=$dormID";
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

    $query = "select bookingID from booking b join rooms r where b.roomID=r.roomID and r.dormID=$dormID";
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
    $query = "select * from booking b join rooms r join members m join Dormitories d where r.dormID = d.dormID and b.memberID = m.memberID and b.roomID=r.roomID and r.dormID=$dormID order by $order_by limit $limit_start , 8";
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
        }

        echo '<tr>';
        echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
        echo '<td>' . $row["firstName"] . '</td>';
        echo '<td>' . $row["lastName"] . '</td>';
        echo '<td>' . $row["date"] . '</td>';
        echo '<td>' . $row["expire_date"] . '</td>';
        echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
        echo '<td><button type="button" class="btn viewdetail" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . $row["totalPrice"] . '" data-transfername="' . $row["transfer_name"] . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
        echo '</tr> ';
    }
    if (mysqli_num_rows($result) != 8 && mysqli_num_rows($result) != 0) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) === 0) {
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

if (isset($_GET["showbook_dormID"]) && isset($_GET["dormbook_showpage"]) && isset($_GET["dormbook_order"])) {
    if (is_numeric($_GET["showbook_dormID"]) && is_numeric($_GET["dormbook_showpage"])) {
        getBookingDorm($_GET['dormbook_showpage'], $_GET["dormbook_order"], $_GET["showbook_dormID"]);
    } else {
        echo '<tr style="height: 51px">';
        echo '<td colspan="8" style="text-align: center"> Something Error</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
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
        echo '<td><a href="index.php?chose_page=checkRequestDetail&confirmID=' . $row["confirmID"] . '">View</a></td>';
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
            echo '<td><a href="index.php?chose_page=checkRequestDetail&confirmID=' . $row["confirmID"] . '">View</a></td>';
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
            }

            echo '<tr>';
            echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
            echo '<td>' . $row["firstName"] . '</td>';
            echo '<td>' . $row["lastName"] . '</td>';
            echo '<td>' . $row["date"] . '</td>';
            echo '<td>' . $row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
            echo '<td><button type="button" class="btn viewdetail" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . $row["totalPrice"] . '" data-transfername="' . $row["transfer_name"] . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
            echo '</tr> ';
        }
    } else {
        echo '<tr style="height: 51px">';
        echo '<td colspan="8" style="text-align: center"> No Result</td>';
        echo '</tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) <= 8) {
        for ($i = 1; $i <= 8 - mysqli_num_rows($result); $i++) {
            echo '<tr style="height: 51px">';
            echo '<td colspan="8"></td>';
            echo '</tr>';
        }
    }
}

if (isset($_GET["booking_searching"]) && isset($_GET["dormbook_id"]) && is_numeric($_GET["dormbook_id"])) {
    $search_value = filter_var($_GET["booking_searching"], FILTER_SANITIZE_STRING);
    $dorm_id = $_GET["dormbook_id"];
    if ($_GET["booking_searching"] !== "") {
        if (isset($_GET["search_only"])) {
            $type = "like";
            if ($_GET["search_only"] === "bookingID") {
                $type = "=";
            }
            if ($_GET["search_only"] == "expire_date" || $_GET["search_only"] == "booking_status" || $_GET["search_only"] == "date") {
                $search_value = "%" . $search_value . "%";
            }
            $booksearch_only = $_GET["search_only"];
            $query = "select * from booking b join rooms r join members m where b.memberID = m.memberID and b.roomID=r.roomID and r.dormID=$dorm_id and $booksearch_only $type '$search_value' order by date desc limit 0 , 8";
            searchingBook($query);
        } else {
            $query = "select * from booking b join rooms r join members m where b.memberID = m.memberID and b.roomID=r.roomID and r.dormID=$dorm_id and (bookingID like '$search_value' or date like '%$search_value%' or expire_date like '%$search_value%' or booking_status like '%$search_value%' or roomType like '%$search_value%' or firstName like '%$search_value%' or lastName like '%$search_value%') order by date desc limit 0 , 8 ";
            searchingBook($query);
        }
    } else {
        getBookingDorm(1, "date desc", $dorm_id);
    }
}

//Incoming Display Member Booking Page

function getMembook($member_id, $page) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Booking b join Dormitories d join Rooms r where b.roomID = r.roomID and r.dormID = d.dormID and b.memberID = $member_id order by date desc limit $limit_start , 8";
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
            }
            echo '<tr>';
            echo '<td><p style = "margin-left:20px">' . $book_row["bookingID"] . '</p></td>';
            echo '<td><p style="margin-left:20px">' . $book_row["dormName"] . '</p></td>';
            echo '<td>' . $book_row["roomType"] . '</td>';
            echo '<td>' . $book_row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $book_row["booking_status"] . '</td>';
            echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $book_row["bookingID"] . '" type="button" style="width:100%" class="btn btn-success book-now">View Detail</a></td>';
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
    $query = "update booking set booking_status = 'Canceled' where bookingID = $bookingID";

    if (mysqli_query($con, $query)) {
        $query = "select roomID from booking where bookingID = $bookingID";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $roomID = $row[0];
        $query = "update Rooms set roomAvailable = roomAvailable + 1 where roomID = $roomID";
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
    $query = "update booking set booking_status = '$status' where bookingID = $bookID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["change_booking_status"]) && isset($_GET["change_booking_id"]) && is_numeric($_GET["change_booking_id"])) {

    $status = filter_var($_GET["change_booking_status"]);
    $bookID = $_GET["change_booking_id"];

    if (change_booking($bookID, $status)) {
        echo 'Change Status <script>alert("Change Status Complete");</script>';
    } else {
        echo 'Change Status <script>alert("Change Status Failed");</script>';
    }
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
            }
            echo '<tr>';
            echo '<td><p style = "margin-left:20px">' . $book_row["bookingID"] . '</p></td>';
            echo '<td><p style="margin-left:20px">' . $book_row["dormName"] . '</p></td>';
            echo '<td>' . $book_row["roomType"] . '</td>';
            echo '<td>' . $book_row["expire_date"] . '</td>';
            echo '<td style="color:' . $color . '">' . $book_row["booking_status"] . '</td>';
            echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $book_row["bookingID"] . '" type="button" style="width:100%" class="btn btn-success book-now">View Detail</a></td>';
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
    $query = "select * from Booking b join Dormitories d join Rooms r where b.roomID = r.roomID and r.dormID = d.dormID and b.memberID = $memberID and bookingID like '%$value%' order by date desc limit 0 , 8";
    searchingMemberBook($query);
}

if (isset($_GET["sortby_memberbooking"]) && isset($_GET["sortby_memberbooking_page"]) && is_numeric($_GET["sortby_memberbooking_page"])) {

    $sort_by = filter_var($_GET["sortby_memberbooking"], FILTER_SANITIZE_STRING);
    if ($sort_by == "date") {
        $sort_by = "date desc";
    }
    $memberID = $_SESSION["memberID"];
    $limit_start = ((8 * $_GET["sortby_memberbooking_page"]) - 8);
    $query = "select * from Booking b join Dormitories d join Rooms r where b.roomID = r.roomID and r.dormID = d.dormID and b.memberID = $memberID order by $sort_by limit $limit_start , 8";
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

function getAllDorm($page,$order_by) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select dormID,dormName,firstName,lastName,d.type,d.status from dormitories d join members m where d.memberID = m.memberID order by $order_by limit $limit_start,8";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "red";
            if ($row["status"] == "Active") {
                $color = "#00cc33";
            }

            echo "<tr>";
            echo '<td style="text-align: center">' . $row["dormID"] . '</td>';
            echo '<td>' . $row["dormName"] . '</td>';
            echo '<td>' . $row["firstName"] . $row["lastName"] . '</td>';
            echo '<td>' . $row["type"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["status"] . '</td>';
            echo '<td><a href="index.php?chose_page=checkDormDetail&getdorm=' . $row["dormID"] . '"><button type="button" class="btn btn-success book-now">Detail</button></a></td>';
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

function searchDormitories($query){
    require 'connection.php';
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {

            $color = "red";
            if ($row["status"] == "Active") {
                $color = "#00cc33";
            }

            echo "<tr>";
            echo '<td style="text-align: center">' . $row["dormID"] . '</td>';
            echo '<td>' . $row["dormName"] . '</td>';
            echo '<td>' . $row["firstName"] . " " . $row["lastName"] . '</td>';
            echo '<td>' . $row["type"] . '</td>';
            echo '<td style="color:' . $color . '">' . $row["status"] . '</td>';
            echo '<td><a href="index.php?chose_page=checkDormDetail&getdorm=' . $row["dormID"] . '"><button type="button" class="btn btn-success book-now">Detail</button></a></td>';
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
    getAllDorm($page,"dormID");
}

if (isset($_GET["checkdorm_showpage"]) && is_numeric($_GET["checkdorm_showpage"])) {
    $href = "callback.php?checkdorm_currentpage=";
    $query = "select * from dormitories";
    if(isset($_GET["sortby_dorm"])){
        $sort_by = $_GET["sortby_dorm"];
        $href = "callback.php?sortby_dormitories=". $sort_by ."&sortby_dormitories_page=";
    }
    displayPage($_GET["checkdorm_showpage"], $query , $href);
}

if(isset($_GET["search_dormitories"])){
    $value = $_GET["search_dormitories"];
    $query = "select dormID,dormName,firstName,lastName,d.type,d.status from dormitories d join members m where d.memberID = m.memberID and  (dormID like '%$value%' or dormName like '%$value%' or firstName like '%$value%' or lastName like '%$value%' or d.type like '%$value%' or d.status like '%$value%') limit 0,8";
    searchDormitories($query);
}

if(isset($_GET["sortby_dormitories"]) && isset($_GET["sortby_dormitories_page"]) && is_numeric($_GET["sortby_dormitories_page"])){
    $order_by = $_GET["sortby_dormitories"];
    if($order_by == "type"){
        $order_by = "type desc";
    }
    getAllDorm($_GET["sortby_dormitories_page"], $order_by);
}

?>

