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
    case "reseller":
        require_once("thr_finder.php");
        break;
    case "addresellerlist":
        require_once("addresellerlist.php");
        break;
    case "contact":
        require_once("contact.php");
        break;
    case "editreseller":
        require_once("editreseller.php");
        break;
    
    default:
        require_once("main.php");
        break;
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>