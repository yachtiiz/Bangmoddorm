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
        echo $_SESSION["firstname"]." ".$_SESSION["lastname"];
    } else {
        echo "1";
    }
}

if(isset($_GET["logout"])){
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

function approve_dormitory($confirmID,$dorm_rate){
    
    require 'connection.php';
    $query = "update ConfirmationDorm set approval = 'Approve' where confirmID = $confirmID ";
    
    if(mysqli_query($con, $query)){
        
        $query = "select * from ConfirmationDorm where confirmID = $confirmID";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        
        $dorm_name = $row["dormName"];
        $memberID = $row["memberID"];
        
        $query = "INSERT INTO `Dormitories` (`memberID`, `dormName` , `dormitory_rate` , `status`) VALUES ($memberID, '$dorm_name' , $dorm_rate , 'Disable');";
        
        if(mysqli_query($con, $query)){
            $query = "select max(dormID) from Dormitories";
            $id_result = mysqli_query($con, $query);
            $id_row = mysqli_fetch_array($id_result);
            $dorm_fac_id = $id_row[0];
            $fac_query = "INSERT INTO `FacilitiesInDorm` (`dormID`) VALUES($dorm_fac_id);";
            mysqli_query($con, $fac_query);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

if(isset($_GET["approval_submit"]) && is_numeric($_GET["approval_submit"]) && isset($_GET["dorm_rate"]) && is_numeric($_GET["dorm_rate"])){
    if(approve_dormitory($_GET["approval_submit"],$_GET["dorm_rate"])){
        echo "<script>alert('Approval Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=checkRequestDorm';</script>";
    }else{
        echo "<script>alert('Approval Failed')</script>";
    }
}

// Deleted Room Function

function disabled_room($roomID){
    require 'connection.php';
    
    $query = "update Rooms set status = 'Disabled' where roomID = $roomID";
    
    if(mysqli_query($con, $query)){
        return true;
    }else{
        return false;
    }
}

if(isset($_GET["disabled_room"]) && is_numeric($_GET["disabled_room"])){
    if(disabled_room($_GET["disabled_room"])){
        echo "<script>alert('Delete Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    }else{
        echo "<script>alert('Delete Failed')</script>";
        echo "<script>window.location = 'index.php?chose_page=ownersystem';</script>";
    }
}

// Showing and Not Showing Dormitory

function showing_dorm($dormID,$status){
    
    require 'connection.php';
    
    $query = "update Dormitories set status = '$status' where dormID = $dormID ";
    if(mysqli_query($con, $query)){
        return true;
    }else{
        return false;
    }
}

if(isset($_GET["showing_dorm"]) && is_numeric($_GET["showing_dorm"])){
    if(showing_dorm($_GET["showing_dorm"], 'Active')){
        echo 'Hidden On Page';
    }
}
if(isset($_GET["disabled_dorm"]) && is_numeric($_GET["disabled_dorm"])){
    if(showing_dorm($_GET["disabled_dorm"], 'Disable')){
        echo 'Showing On Page';
    }
}

//check Booking Session
function checkBooking($memberID){
    
    require 'connection.php';
    
    $query = "select * from booking where memberID = $memberID and status = 'Waiting'";
    $result = mysqli_query($con, $query);
    
    $row = mysqli_fetch_array($result);
    if($row !== NULL){
        return 'Already Booking (Booking ID = '.$row["bookingID"].')';
    }else{
        return 'PASS';
    }
}

if(isset($_GET["memberID"]) && isset($_GET["dormID"]) && isset($_GET["roomID"])){
    if(is_numeric($_GET["memberID"]) && is_numeric($_GET["dormID"]) && is_numeric($_GET["roomID"])){
        $dormID = $_GET["dormID"];
        $roomID = $_GET["roomID"];
        $msg = checkBooking($_GET["memberID"]);
        if($msg !== 'PASS'){
            echo '<script>alert("'. $msg .'")</script>';
            echo '<script>window.location = "index.php"</script>';
        }else{
            echo '<script>window.location = "index.php?chose_page=book&dormID='.$dormID.'&roomID='.$roomID.'"</script>';
        }
    }
}
?>

