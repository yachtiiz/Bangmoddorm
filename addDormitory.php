
<script>

    $(document).ready(function() {

        $("#form").validate({
            rules: {
                dorm_name: {
                    checkSpecial: true,
                    required: true,
                    minlength: 2,
                    maxlength: 256
                },
                license_dorm: {
                    checkSpecial: true,
                    minlength: 4,
                    maxlength: 256
                }
            }
        });
    });


</script>

    <div class="span12">
        <?php

        function gen_req_id() {


            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);

            return $rand;
        }

        function up_evidance_picture($file, $username) {

            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);

            if ($_FILES["$file"]["type"] == "image/jpg" || $_FILES["$file"]["type"] == "image/png" || $_FILES["$file"]["type"] == "image/jpeg" || $_FILES["$file"]["type"] == "image/gif" || $_FILES["$file"]["type"] == "image/pjpeg" || $_FILES["$file"]["type"] == "image/x-png") {
                if (move_uploaded_file($_FILES["$file"]["tmp_name"], "images/picture_evidence/evidance_" . $username . "_" . $rand)) {
                    return "images/picture_evidence/evidance_" . $username . "_" . $rand;
                } else {
                    return "Cant Upload ..";
                }
            } else {
                return "Invalid Picture File ..";
            }
        }

        function send_request() {
            require 'connection.php';

            $memberID = $_SESSION["memberID"];
            $dorm_name = filter_var($_POST["dorm_name"], FILTER_SANITIZE_STRING);
            $license_dorm = filter_var($_POST["license_dorm"], FILTER_SANITIZE_STRING);
            $evidence_dorm = up_evidance_picture("evidence_dorm", $memberID);
            $special_request = filter_var($_POST["special_request"], FILTER_SANITIZE_STRING);

            $query = "INSERT INTO `ConfirmationDorm` (`memberID`, `dormName`, `evidence`, `license`, `approval` , `special_request` , `date` , `noti_status` )
VALUES ($memberID, '$dorm_name', '$evidence_dorm', '$license_dorm', 'Waiting' , '$special_request' , NOW() , 0);";

            if ($evidence_dorm === "Cant Upload .." || $evidence_dorm === "Invalid Picture File ..") {
                return "ERR";
            }

            if (mysqli_query($con, $query)) {
                return $evidence_dorm;
            } else {
                return "ERR";
            }
        }

        if (!isset($_POST["submit_form"])) {
            ?>
            <div class="row">
                <div class="span9">
                    <form id="form" action="" method="POST" enctype="multipart/form-data">
                        <h1><center>Add Dormitory				<br /><small>Owner send request to Admin for add your dormitory.
                                </small></center></h1><br />
                        <div class="row">
                            <div class="span9">
                                <legend><span>Your</span> Dormitory Information</legend>
                            </div>

                            <div class="span3">
                                <label>Dormitory Name
                                    <input id="dorm_name" name="dorm_name" class="form-control" type="text" placeholder="Dorm Name..." />
                                </label>
                            </div>	
                        </div>		
                        <br />
                        <div class="row">
                            <div class="span9">
                                <legend><span>Your</span> Evidence</legend>
                            </div>
                            <div class="span3">
                                <label>License ID
                                    <input id="license_dorm" name="license_dorm" class="form-control" type="text" placeholder="123DXXXX" />
                                </label>
                            </div>

                            <div class="span3">
                                <label>Evidence
                                    <input id="evidence_dorm" name="evidence_dorm" class="form-control" type="file"/>
                                </label>
                            </div>	
                        </div>
                        <br />

                        <div class="row">
                            <div class="span9">
                                <legend><span>Any</span> special requests?</legend>
                                <textarea id="special_request" name="special_request" class="span9 form-control" rows="4" placeholder="Send your spacials request or question to Admin"></textarea>
                            </div>			
                        </div>
                        <div class="row">
                            <div class="span9">
                                <br />
                                <input name="submit_form" type="submit" class="btn1 btn1-success pull-right" style="margin-left:15px;width: 30%" value="Submit">
                                <a href="index.php?chose_page=ownersystem" class="btn1 btn1-danger pull-right" style="width: 30%">Back</a>
                                <br />
                                <br />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <?php
        } else {
            $msg = send_request();
            if ($msg == "ERR") {
                echo '<script>alert("Send Request Failed");</script>';
                echo '<script>window.location = "index.php?chose_page=adddormitory"</script>';
            }
            ?>

            <div class="row">
                <div class="span9">
                    <br /><br />
                    <h1><center>Add Dormitory				<br /><small>Owner send request to Admin for add your dormitory.
                            </small></center></h1><br />
                    <div class="row">
                        <div class="span8">
                            <legend><span>Your</span> Dormitory Information</legend>
                        </div>

                        <div class="span3">
                            <label>Dormitory Name
                                <p><?php echo $_POST["dorm_name"]; ?></p>
                            </label>
                        </div>	
                    </div>		
                    <br />
                    <div class="row">
                        <div class="span8">
                            <legend><span>Your</span> Evidence</legend>
                        </div>
                        <div class="span3">
                            <label>License ID
                                <p> <?php echo $_POST["license_dorm"]; ?> </p>
                            </label>
                        </div>

                        <div class="span3">
                            <label>Evidence
                                <img class="img-thumbnail" src="<?php echo $msg; ?>"
                            </label>
                        </div>	
                    </div>
                    <br />

                    <?php if ($_POST["special_request"] !== "") { ?>
                        <div class="row">
                            <div class="span9">
                                <legend><span>Any</span> special requests?</legend>
                                <p> <?php echo $_POST["special_request"]; ?></p>
                            </div>			
                        </div>
                    <?php } ?>
                    <div class="row" style="margin-top: 40px;">
                        <div class="span9">
                            <legend><span>Send</span> Request Complete &nbsp;&nbsp; <span class="glyphicon glyphicon-ok"></span></legend>
                        </div>			
                    </div>
                    <div class="row" style="margin-bottom: 20%">
                        <div class="span9">
                            <br />
                            <a href="index.php" class="btn1 btn1-primary pull-right" style="width: 30%">Go To INDEX</a>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div> <!-- /container -->
