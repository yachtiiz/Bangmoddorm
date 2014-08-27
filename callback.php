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

function approve_dormitory($confirmID){
    
    require 'connection.php';
    $query = "update ConfirmationDorm set approval = 'Approve' where confirmID = $confirmID ";
    
    if(mysqli_query($con, $query)){
        
        $query = "select * from ConfirmationDorm where confirmID = $confirmID";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        
        $dorm_name = $row["dormName"];
        $memberID = $row["memberID"];
        
        $query = "INSERT INTO `Dormitories` (`memberID`, `dormName`) VALUES ($memberID, '$dorm_name');";
        if(mysqli_query($con, $query)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

if(isset($_GET["approval_submit"]) && is_numeric($_GET["approval_submit"])){
    if(approve_dormitory($_GET["approval_submit"])){
        echo "<script>alert('Approval Success')</script>";
        echo "<script>window.location = 'index.php?chose_page=checkRequestDorm';</script>";
    }else{
        echo "<script>alert('Approval Failed')</script>";
    }
}

?>

