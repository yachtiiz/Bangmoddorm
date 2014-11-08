<div class="span12">	
        <div class="row">
            <?php

            function getMember() {
                require 'connection.php';
                $memberID = $_SESSION["memberID"];
                $query = "select * from Members where memberID = $memberID";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                if (mysqli_num_rows($result) !== 0) {
                    return $row;
                } else {
                    return NULL;
                }
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

            function changeProfile() {

                require 'connection.php';
                $memberID = $_SESSION["memberID"];
                $username = $_SESSION["username"];
                $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
                $lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
                $idcard = filter_var($_POST["idcard"], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
                $tel = filter_var($_POST["tel"], FILTER_SANITIZE_STRING);
                $address = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
                $city = filter_var($_POST["city"], FILTER_SANITIZE_STRING);
                $province = filter_var($_POST["province"], FILTER_SANITIZE_STRING);
                $zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_STRING);
                $country = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
                $about = filter_var($_POST["about"], FILTER_SANITIZE_STRING);
                $displayname = filter_var($_POST["displayname"], FILTER_SANITIZE_STRING);
                $memberurl = filter_var($_POST["memberurl"], FILTER_SANITIZE_STRING);
                $facebook = filter_var($_POST["facebook"], FILTER_SANITIZE_STRING);
                $pic_path = "";
                if (isset($_FILES["display_pic"]) && $_FILES["display_pic"]["name"] !== "") {
                    if (upPicture("display_pic", $_SESSION["username"])) {
                        $pic_path = ", pic_path = 'images/picture_profile/user_" . $username . "'";
                    }
                }

                $query = "update Members set firstName = '$firstname' , lastName = '$lastname' , idCard = '$idcard' , email = '$email' , tel = '$tel' , 
                          address= '$address' , city = '$city' , province = '$province' , zipcode = '$zipcode' , country = '$country' , about = '$about' ,
                        displayName = '$displayname' , memberUrl = '$memberurl' , facebook = '$facebook' $pic_path where memberID = $memberID";

                if (mysqli_query($con, $query)) {
                    return true;
                } else {
                    return false;
                }
            }
            ?>
            <?php
            $row = getMember();
            if ($row !== NULL) {
                if (isset($_POST["change_profile_submit"])) {
                    if (changeProfile()) {
                        $row = getMember();
                        echo '<script>alert("Change Profile Success"); window.location = "index.php?chose_page=myprofile" ';
                    } else {
                        echo '<script>alert("Change Profile Failed"); window.location = "index.php?chose_page=myprofile" ';
                    }
                }
                ?>
                <script>

                    $(document).ready(function() {

                        $("#form").validate({
                            rules: {
                                username: {
                                    checkSpecial: true,
                                    required: true,
                                    minlength: 4,
                                    maxlength: 256
                                },
                                password: {
                                    checkSpecial: true,
                                    required: true,
                                    minlength: 8,
                                    maxlength: 256
                                },
                                firstname: {
                                    checkSpecial: true,
                                    required: true,
                                    minlength: 4,
                                    maxlength: 256
                                },
                                lastname: {
                                    checkSpecial: true,
                                    required: true,
                                    minlength: 4,
                                    maxlength: 256
                                },
                                tel: {
                                    required: true,
                                    minlength: 14
                                },
                                address: {
                                    checkSpecial: true,
                                    required: true,
                                    minlength: 2,
                                    maxlength: 1024
                                },
                                email: {
                                    required: true,
                                    email: true
                                },
                                idcard: {
                                    required: true,
                                    checkSpecial: true,
                                },
                                zipcode: {
                                    required: true,
                                    checkSpecial: true
                                },
                                about: {
                                    required: true,
                                    checkSpecial: true
                                },
                                displayname: {
                                    required: true,
                                    checkSpecial: true
                                },
                                memberURL: {
                                    required: true,
                                    checkSpecial: true
                                },
                                fbname: {
                                    checkSpecial: true
                                }

                            }

                        });
                    });

                    jQuery(function($) {
                        $("#tel").mask("(+99)99-999-9999");
                        $("#cpn_tel").mask("(+99)99-999-9999 ext.? 99");
                        $("#cpn_fax").mask("(+99)99-999-9999");
                        $("#idcard").mask("9-9999-99999-99-9", {placeholder: "_"});
                        $("#cpn_elec_regis").mask("9999999999999", {placeholder: ""});
                        $("#cpn_tax_number").mask("9999999999999", {placeholder: ""});
                    });

                </script>
                <div class="span12">
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <br />
                            <div class="row">
                                <div class="span12">
                                    <legend><span>Your</span> Profile</legend>
                                </div>
                                <div class="span3" style="margin-left:10%">
                                    <label>Display Picture
                                        <img class="img-thumbnail" style="width:220px;height: 200px" src="<?php echo $row["pic_path"] ?>">
                                    </label>
                                </div>                                
                                <div class="span3">
                                    <label>Username
                                        <input type="text" name="username" class="form-control" value="<?php echo $row["username"] ?>"/>
                                    </label>
                                </div>
                                <div class="span3">
                                    <label>Type
                                        <select class="form-control">
                                            <option><?php echo $row["type"] ?></option>
                                        </select>
                                    </label>
                                </div>
                                <div class="span3">
                                    <label>Change Display Picture
                                        <input type="file" name="display_pic" class="form-control">
                                    </label>
                                </div>
                                <?php 
                                $color = "";
                                
                                switch ($_SESSION["status"]){
                                    case "Normal" : $color = "green";
                                        break;
                                    case "Blacklist" : $color = "red";
                                        break;
                                } ?>
                                <div class="span3">
                                    <label><br>
                                        <h4>Status =  <span style="color: <?php echo $color ?>"><?php echo $_SESSION["status"] ?></span></h4>
                                    </label>
                                </div>
                            </div>
                            <div class="row">

                                <div class="span12">
                                    <legend><span>Your</span> name</legend>
                                </div>


                                <div class="span3" style="margin-left:10%">
                                    <label>First name
                                        <input type="text" name="firstname" class="form-control" value="<?php echo $row["firstName"] ?>" />
                                    </label>
                                </div>	

                                <div class="span3">
                                    <label>Last name
                                        <input type="text" name="lastname" class="form-control" value="<?php echo $row["lastName"] ?>" />
                                    </label>
                                </div>

                            </div>		
                            <br />
                            <div class="row">
                                <div class="span12">
                                    <legend><span>Your</span> contact details</legend>
                                </div>
                                <div class="span3" style="margin-left:10%">
                                    <label>Identity Card Number
                                        <input id="idcard" name="idcard" type="text" class="form-control" value="<?php echo $row["idCard"] ?>"/>
                                    </label>
                                </div>

                                <div class="span3">
                                    <label>Email address 
                                        <input name="email" type="text" class="form-control" value ="<?php echo $row["email"] ?>" />
                                    </label>
                                </div>	

                                <div class="span3">
                                    <label>Telephone number
                                        <input id="tel" name="tel" type="text" class="form-control" value="<?php echo $row["tel"] ?>" />
                                    </label>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="span12">
                                    <legend><span>Your</span> address</legend>
                                </div>

                                <div class="span3" style="margin-left:10%">
                                    <label>Address
                                        <textarea name="address" class="form-control" rows="3"><?php echo $row["address"] ?></textarea>
                                    </label>
                                </div>				

                                <div class="span3">
                                    <label>City
                                        <input name="city" type="text" class="form-control" value="<?php echo $row["city"] ?>" />
                                    </label>
                                    <label>ZIP/Postal
                                        <input name="zipcode" type="text" class="form-control" value="<?php echo $row["zipcode"] ?>" />
                                    </label>
                                </div>

                                <div class="span3">
                                    <label>State/Province
                                        <input name="province" type="text" class="form-control" value="<?php echo $row["province"] ?>" />
                                    </label>
                                    <label>Country
                                        <input name="country" type="text" class="form-control" value="<?php echo $row["country"] ?>"
                                    </label>
                                </div>
                                <div class="span12">
                                    <legend><span>Your</span> Information</legend>
                                </div>

                                <div class="span3" style="margin-left:10%">
                                    <label>About
                                        <textarea name="about" class="form-control" rows="3"><?php echo $row["about"] ?></textarea>
                                    </label>
                                </div>				
                                <div class="span3">
                                    <label>Display Name
                                        <input name="displayname" type="text" class="form-control" value="<?php echo $row["displayName"] ?>" />
                                    </label>
                                    <label>Facebook
                                        <input name="facebook" type="text" class="form-control" value="<?php echo $row["facebook"] ?>" />
                                    </label>
                                </div>

                                <div class="span3">
                                    <label>Member URL
                                        <input name="memberurl" type="text" class="form-control" value="<?php echo $row["memberUrl"] ?>" />
                                    </label>
                                </div>	
                            </div><br><br>
                            <div class="row">
                                <div class="span10" style="margin-left:10%">
                                    <button type="submit" name="change_profile_submit" class="btn1 btn1-success" style="margin-left: 200px;width: 20%">Change Your Profile</button>
                                    <button data-toggle="modal" data-target="#changePasswordModal" type="button" class="btn1 btn1-primary" style="margin-left: 20px;width: 20%">Change Password</button>
                                    <div class="modal fade" id="changePasswordModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="height: 50px">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                </div>
                                                <div class="modal-body" style="padding-left: 20%;padding-right: 20%">
                                                    <h4 style="text-align: center"><span>Change Password</span></h4>
                                                    <div class="input-group" style="margin-top:20px">
                                                        <span class="input-group-addon">Old Password</span>
                                                        <input id="oldpass" type="password" class="form-control">
                                                    </div>

                                                    <div class="input-group" style="margin-top:10px">
                                                        <span class="input-group-addon">New Password</span>
                                                        <input id="newpass" type="password" class="form-control">
                                                    </div>

                                                    <div class="input-group" style="margin-top:10px">
                                                        <span class="input-group-addon">Confirm New Password</span>
                                                        <input id="confirm_newpass" type="password" class="form-control">
                                                    </div>
                                                </div><br>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button id="changePassword" type="button" class="btn btn-primary">Change Password</button>
                                                    <script>

                                                        $(function() {

                                                            $("#changePassword").on("click", function() {
                                                                
                                                                oldpass = $("#oldpass").val();
                                                                newpass = $("#newpass").val();
                                                                confirm_newpass = $("#confirm_newpass").val();

                                                                if (newpass === confirm_newpass) {
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "callback.php",
                                                                        data: { change_pass: 'change' , oldpass: oldpass , newpass : newpass , confirm_newpass: confirm_newpass },
                                                                        success: function(data){
                                                                            alert(data);
                                                                            window.location = "index.php?chose_page=myprofile";
                                                                        }
                                                                    });
                                                                }else{
                                                                    alert("Confirm Password Not Correct");
                                                                }
                                                            });
                                                        });




                                                    </script>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>
                            <br />

                        </fieldset>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

</div> <!-- /container -->
<br><br><br>
