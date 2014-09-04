<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <?php

            function getMember() {
                require 'connection.php';
                $memberID = $_SESSION["memberID"];
                $query = "select * from members where memberID = $memberID";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                if (mysqli_num_rows($result) !== 0) {
                    return $row;
                } else {
                    return NULL;
                }
            }
            ?>
            <?php $row = getMember(); 
            if($row !== NULL){
            ?>
            <div class="span9">
                <form class="form-horizontal">
                <fieldset>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Member</span> System</legend>
                        </div>
                        <div class="span4">
                            <a href="index.php?chose_page=checkBookingHis"><button type="button" class="btn btn-primary btn-lg btn-block book-now2">Check Your Booking History</button></a><br><br>
                            <a href="checkNotification.jsp"><button type="button" class="btn btn-primary btn-lg btn-block book-now2">Check Your Notification</button></a>
                        </div>
                    </div><br><br><br>
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> Profile</legend>
                        </div>
                        <div class="span3">
                            <label>Display Picture
                                <img class="img-thumbnail" style="width:220px;height: 200px" src="<?php echo $row["pic_path"] ?>">
                            </label>
                        </div>
                        <div class="span3">
                            <label>Username
                                <input type="text" class="form-control" value="<?php echo $row["username"] ?>"/>
                            </label>
                        </div>
                        <div class="span3">
                            <label>Type
                                <select class="form-control">
                                    <option><?php echo $row["type"] ?></option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="span9">
                            <legend><span>Your</span> name</legend>
                        </div>

                        <div class="span3">
                            <label>
                                <select class="form-control">
                                    <option>Mr.</option>
                                </select>
                            </label>
                        </div>

                        <div class="span3">
                            <label>
                                <input type="text" class="form-control" value="<?php echo $row["firstName"] ?>" />
                            </label>
                        </div>	

                        <div class="span3">
                            <label>
                                <input type="text" class="form-control" value="<?php echo $row["lastName"] ?>" />
                            </label>
                        </div>

                    </div>		
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> contact details</legend>
                        </div>
                        <div class="span3">
                            <label>Identity Card Number
                                <input type="text" class="form-control" value="<?php echo $row["idCard"] ?>"/>
                            </label>
                        </div>

                        <div class="span3">
                            <label>Email address 
                                <input type="text" class="form-control" value ="<?php echo $row["email"] ?>" />
                            </label>
                        </div>	

                        <div class="span3">
                            <label>Telephone number
                                <input type="text" class="form-control" value="<?php echo $row["tel"] ?>" />
                            </label>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Your</span> address</legend>
                        </div>

                        <div class="span3">
                            <label>Address
                                <textarea class="form-control" rows="3"><?php echo $row["address"] ?></textarea>
                            </label>
                        </div>				

                        <div class="span3">
                            <label>City
                                <input type="text" class="form-control" value="<?php echo $row["city"] ?>" />
                            </label>
                            <label>ZIP/Postal
                                <input type="text" class="form-control" value="<?php echo $row["zipcode"] ?>" />
                            </label>
                        </div>

                        <div class="span3">
                            <label>State/Province
                                <input type="text" class="form-control" value="<?php echo $row["province"] ?>" />
                            </label>
                            <label>Country
                                <input type="text" class="form-control" value="<?php echo $row["country"] ?>"
                            </label>
                        </div>
                        <div class="span9">
                            <legend><span>Your</span> Information</legend>
                        </div>

                        <div class="span3">
                            <label>About
                                <textarea class="form-control" rows="3"><?php echo $row["about"] ?></textarea>
                            </label>
                        </div>				
                        <div class="span3">
                            <label>Display Name
                                <input type="text" class="form-control" value="<?php echo $row["displayName"] ?>" />
                            </label>
                            <label>Facebook
                                <input type="text" class="form-control" value="<?php echo $row["facebook"] ?>" />
                            </label>
                        </div>

                        <div class="span3">
                            <label>Member URL
                                <input type="text" class="form-control" value="<?php echo $row["memberUrl"] ?>" />
                            </label>
                        </div>	
                    </div><br><br>
                    <div class="row">
                        <div class="span5">
                            <button type="submit" class="btn btn-primary book-now" style="margin-left: 260px">Change Your Profile</button>
                        </div>
                    </div>
                    <br />
                    		
                </fieldset>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>

</div></div> <!-- /container -->
<br><br><br>
