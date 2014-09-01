
<div class="row booking_summary">
    <div class="span12">
        <?php

        function gen_req_id() {

            
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0,3);

            return $rand;
        }

        function up_evidance_picture($file, $username) {
            
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0,5);
            
            if ($_FILES["$file"]["type"] == "image/jpg" || $_FILES["$file"]["type"] == "image/png" || $_FILES["$file"]["type"] == "image/jpeg" || $_FILES["$file"]["type"] == "image/gif" || $_FILES["$file"]["type"] == "image/pjpeg" || $_FILES["$file"]["type"] == "image/x-png") {
                if (move_uploaded_file($_FILES["$file"]["tmp_name"], "images/picture_evidence/evidance_" . $username  . "_" . $rand)) {
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

            $query = "INSERT INTO `ConfirmationDorm` (`memberID`, `dormName`, `evidence`, `license`, `approval` , `special_request` , `date` )
VALUES ($memberID, '$dorm_name', '$evidence_dorm', '$license_dorm', 'Waiting' , '$special_request' , NOW() );";

            if ($evidence_dorm === "Cant Upload .." || $evidence_dorm === "Invalid Picture File ..") {
                return false;
            }

            if (mysqli_query($con, $query)) {
                return true;
            } else {
                return false;
            }
        }

        if (!isset($_POST["submit_form"])) {
            ?>
            <div class="row">
                <div class="span9">
                    <form action="" method="post" enctype="multipart/form-data">
                        <br /><br />
                        <h1><center>Add Dormitory				<br /><small>Owner send request to Admin for add your dormitory.
                                </small></center></h1><br />
                        <div class="row">
                            <div class="span8">
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
                            <div class="span8">
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
                                <textarea name="special_request" class="span9 form-control" rows="4" placeholder="Send your spacials request or question to Admin"></textarea>
                            </div>			
                        </div>
                        <div class="row">
                            <div class="span9">
                                <br />
                                <input name="submit_form" type="submit" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px" value="Submit">
                                <a href="ownersystem.jsp" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                <br />
                                <br />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <?php
        } else {

            if (!send_request()) {
                echo '<script>alert("Send Request Failed");</script>';
                echo '<script>window.location = "index.php?chose_page=adddormitory</script>';
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
                                <img src="<?php echo $_POST["evidence_dorm"]; ?>"
                            </label>
                        </div>	
                    </div>
                    <br />
                    
                    <?php if($_POST["special_request"] !== ""){ ?>
                    <div class="row">
                        <div class="span9">
                            <legend><span>Any</span> special requests?</legend>
                            <p> <?php echo $_POST["special_request"]; ?></p>
                        </div>			
                    </div>
                    <?php } ?>
                    <div class="row" style="margin-top: 40px">
                        <div class="span9">
                            <legend><span>Send</span> Request Complete &nbsp;&nbsp; <span class="glyphicon glyphicon-ok"></span></legend>
                        </div>			
                    </div>
                    <div class="row">
                        <div class="span9">
                            <br />
                            <a href="index.php" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Go to INDEX</a>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
    </div>
</div></div> <!-- /container -->
