<div class="row booking_summary">
    <div class="span12">	
        <br />
        <div class="row">
            <?php
            if (isset($_GET["memberID"]) && is_numeric($_GET["memberID"])) {
                require 'connection.php';
                $memberID = $_GET["memberID"];
                $query = "select * from members where memberID = $memberID";

                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="col-md-12" style="margin-left: 0px">
                    <legend><h3 style="text-align: center"><span>Member </span>Information</h3></legend>
                    <img src="<?php echo $row["pic_path"] ?>" class="img-thumbnail" style="width: 40%;height: 40%;margin-left: 30%;margin-bottom: 20px"><br>
                    <legend><h4 style="margin-left:36%;margin-bottom: 30px">Display Picture</h4></legend>
    <!--                                    <h4>Username :<span> <?php echo $row["username"]; ?> </span></h4>
                    <h4>Name :<span> <?php echo $row["firstName"] . " " . $row["lastName"] ?> </span></h4>
                    <h4>Identity Card : <span> <?php echo $row["idCard"]; ?> </span></h4>
                    <h4>Email :<span> <?php echo $row["email"]; ?> </span></h4>
                    <h4>Telephone :<span> <?php echo $row["tel"]; ?> </span></h4>
                    <h4>Type :<span> <?php echo $row["type"]; ?> </span></h4>
                    <h4>Address :<span> <?php echo $row["address"]; ?> </span></h4>
                    <h4>City :<span> <?php echo $row["city"]; ?> </span></h4>
                    <h4>Province :<span> <?php echo $row["province"]; ?> </span></h4>
                    <h4>Zip Code :<span> <?php echo $row["zipcode"]; ?> </span></h4>
                    <h4>Country :<span> <?php echo $row["country"]; ?> </span></h4>
                    <h4>Register Date :<span> <?php echo $row["regisDate"]; ?> </span></h4>
                    <h4>Last Access Time :<span> <?php echo $row["lastAccTime"]; ?> </span></h4>
                    <h4>Status :<span> <?php echo $row["status"]; ?> </span></h4>
                    <h4>Member URL :<span> <?php echo $row["memberUrl"]; ?> </span></h4>
                    <h4>Display Name :<span> <?php echo $row["displayName"]; ?> </span></h4>
                    <h4>Facebook :<span> <?php echo $row["facebook"]; ?> </span></h4>
                    <h4>About :<span> <?php echo $row["about"]; ?> </span></h4>-->
                </div>

                <div class="col-md-3" style="margin-left:0px">
                    <h4>Username <span class="pull-right">:</span></h4>
                    <h4>First name <span class="pull-right">: </span> </h4>
                    <h4>Last name <span class="pull-right">: </span> </h4>
                    <h4 style="margin-top: 10px">Identify Card Number <span class="pull-right">: </span> </h4>
                    <h4 style="margin-top: 15px">Email <span class="pull-right">: </span> </h4>
                    <h4 style="margin-top: 15px">Telephone <span class="pull-right">: </span> </h4>
                    <h4>Type <span class="pull-right">: </span> </h4>
                    <h4>Address <span class="pull-right">: </span> </h4>
                    <h4>City <span class="pull-right">: </span> </h4>
                    <h4>Province <span class="pull-right">: </span> </h4>
                    <h4>Zip Code <span class="pull-right">: </span> </h4>
                    <h4>Country <span class="pull-right">: </span> </h4>
                    <h4 style="margin-top: 10px">Register Date <span class="pull-right">: </span> </h4>
                    <h4>Last Access Time <span class="pull-right">: </span> </h4>
                    <h4>Status <span class="pull-right">: </span> </h4>
                    <h4>Member URL <span class="pull-right">: </span> </h4>
                    <h4>Display Name <span class="pull-right">: </span> </h4>
                    <h4 style="margin-top: 15px">Facebook <span class="pull-right">: </span> </h4>
                    <h4>About <span class="pull-right">: </span> </h4>
                </div>
                <div class="col-md-3" style="margin-left:0px">
                    <h4><span class="pull-right"><?php echo $row["username"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["firstName"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["lastName"]; ?></span></h4><br><br>
                    <h4><span class="pull-right"><?php echo $row["idCard"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["email"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["tel"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["type"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["address"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["city"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["province"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["zipcode"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["country"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["lastAccTime"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["regisDate"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["status"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["memberUrl"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["displayName"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["facebook"]; ?></span></h4><br>
                    <h4><span class="pull-right"><?php echo $row["about"]; ?></span></h4><br>
                </div>


                <div class="col-md-5" style="margin-left: 0px">
                    <h4>Total Booking : <span>30 Recipes</span></h4>
                    <h4>Total Reject Booking :<span> 20 Recipes</span></h4>
                    <h4>Total Comment : <span> 12 Comments</span></h4>

                </div>
            </div>
            <?php if (isset($_GET["backtodorm"]) && is_numeric($_GET["backtodorm"])) { ?>
                <a href="index.php?chose_page=checkDormDetail&dormID=<?php echo $_GET["backtodorm"] ?>" class="btn btn-primary btn-large book-now" style="margin-left: 38%">Back</a>                                
            <?php } else { ?>
                <a href="index.php?chose_page=checkMemberInfo" class="btn btn-primary btn-large book-now" style="margin-left: 30%;margin-bottom: 100px">Back</a>
                <?php if ($row["status"] === "Normal") { ?>
                    <a href="" data-toggle="modal" data-target="#blacklist_modal" class="btn btn-primary btn-large book-now" style="margin-left: 5%;margin-bottom: 100px">Add to Blacklist</a>

                    <div class="modal fade" id="blacklist_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title">Add this member to Blacklist</h4>
                                </div>
                                <div class="modal-body">
                                    <h3 style="margin-top:0px">Reason</h3>
                                    <textarea id="blacklist_reason" rows="3" class="form-control" style="margin-bottom:30px"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="addBlacklist" type="button" class="btn btn-primary">Add to blacklist</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>



                    <script>
                        $(function() {
                            $("#addBlacklist").on("click", function() {
                                if (confirm("Add this member to Blacklist ?")) {
                                    reason = $("#blacklist_reason").val().replace(/ /g, "+");
                                    $("#addBlacklist").load("callback.php?addblacklist=<?php echo $row["memberID"] ?>&blacklist_reason="+reason);
                                } else {
                                    event.preventDefault();
                                }
                            });

                        });
                    </script>
                <?php } else { ?>
                    <a href="" id="removeBlacklist" class="btn btn-primary btn-large book-now" style="margin-left: 5%;margin-bottom: 100px">Remove Blacklist</a>
                    <script>
                        $(function() {
                            $("#removeBlacklist").on("click", function() {
                                if (confirm("Remove blacklist ?")) {
                                    $("#removeBlacklist").load("callback.php?removeblacklist=<?php echo $row["memberID"] ?>");
                                } else {
                                    event.preventDefault();
                                }
                            });

                        });
                    </script>
                <?php
                }
            }
            ?>

            </fieldset>
            </form>


        </div>
<?php } ?>
</div>
</div>
</div></div> <!-- /container -->
