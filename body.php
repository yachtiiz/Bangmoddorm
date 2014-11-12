<?php
$page = isset($_GET["chose_page"]) ? $_GET["chose_page"] : "";
$news_id = isset($_GET["news_id"]) ? $_GET["news_id"] : "";
//page=contentPage&newsid=16

switch ($page) {
    case "main": 
        require_once("main.php");
        break;
    case "dormitory":
        require_once("dormitory.php");
        break;
    case "adminsystem":
        require_once("adminSystem.php");
        break;
    case "ownersystem":
        require_once("ownersystem.php");
        break;
    case "dormdetail":
        require_once("dormdetail.php");
        break;
    case "register":
        require_once("register.php");
        break;
    case "membersystem":
        require_once("membersystem.php");
        break;
    case "advancesearch":
        require_once("advancesearch.php");
        break;
    case "adddormitory":
        require_once("addDormitory.php");
        break;
    case "adminsystem":
        require_once("adminsystem.php");
        break;
    case "checkRequestDetail":
        require_once("checkRequestDetail.php");
        break;
    case "checkRequestDorm":
        require_once("checkRequestDorm.php");
        break;
    case "editDormitory":
        require_once("editDormitory.php");
        break;
    case "editroom":
        require_once("editRoom.php");
        break;
    case "book":
        require_once("book.php");
        break;
    case "membersystem":
        require_once("membersystem.php");
        break;
    case "checkBookingHis":
        require_once("checkMemberBooking.php");
        break;
    case "membookdetail":
        require_once("memberBookingDetail.php");
        break;
    case "checkDormBooking":
        require_once("checkBooking.php");
        break;
    case "ownerbookDetail":
        require_once("ownerbook_detail.php");
        break;
    case "checkDormitory":
        require_once("checkDormInfo.php");
        break;
    case "checkDormDetail":
        require_once("checkDormDetail.php");
        break;
    case "checkMemberInfo":
        require_once("checkMemberInfo.php");
        break;
    case "memberInfo":
        require_once("memberInfo.php");
        break;
    case "ownernotification":
        require_once("checkowner_Notification.php");
        break;
    case "membernotification":
        require_once("checkmember_Notification.php");
        break;
    case "checkblacklist":
        require_once("checkBlacklist.php");
        break;
    case "myprofile":
        require_once("profile.php");
        break;
    case "setfloor":
        require_once("setFloor.php");
        break;
    case "resetPassword":
        require_once("reset_password.php");
        break;
    
    default:
        require_once("dormitory.php");
        break;
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
