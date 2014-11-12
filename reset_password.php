<?php

function checkCode($code, $memberID) {

    require 'connection.php';

    $query = "select username from Members where memberID = $memberID";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $check_code = md5($row[0]);
    if ($code === $check_code) {
        return true;
    } else {
        return false;
    }
}

function changePassword($memberID, $password) {

    require 'connection.php';
    $password = md5($password);
    $query = "update Members set password = '$password' where memberID = $memberID";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET["memberID"]) && is_numeric($_GET["memberID"]) && isset($_GET["code"])) {
    $memberID = $_GET["memberID"];
    $code = $_GET["code"];
    $checking = false;
    if (checkCode($code, $memberID)) {
        if(isset($_POST["confirm_reset_password"])){
            $password = $_POST["password"];
            $confirm_pass = $_POST["confirm_pass"];
            $memberID = $_POST["memberID"];
            if($password === $confirm_pass){
                changePassword($memberID, $password);
                echo '<script>alert("Change Password Success");window.location = "index.php";</script>';
            }else{
                echo '<script>alert("Wrong Confirm Password.")</script>';
            }
        }
        ?>
        <div class="span12" style="height: 80%">
            <form action="" method="post">
                <div class="row">
                    <div class="span12" style="text-align: center;margin-top:5%">
                        <legend><span>Reset</span> Your Password</legend>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="memberID" value="<?php echo $_GET["memberID"] ?>">
                    <div class="span12" style="text-align: center">
                        <label>New Password
                            <input id="password" name="password" type="password" class="form-control" style="width:40%;margin-left:30%" placeholder="At least 8 Charactors. "/>                                      
                        </label>
                        <label>Confirm New Password
                            <input id="confirm_password" name="confirm_pass" type="password" class="form-control" style="width:40%;margin-left:30%" placeholder="At least 8 Charactors. "/>                                      
                        </label>
                    </div>
                </div>
                <div class="row" style="margin-top:3%">
                    <button style="margin-left:42%" type="submit" name="confirm_reset_password" class="btn1 btn1-success"> Submit New Password</button>
                </div>
            </form>


        </div>
        </div>


        <?php
    }
} else {
    echo '<script>alert("dao");window.location = "index.php";</script>';
}
?>