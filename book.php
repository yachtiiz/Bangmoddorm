
            <?php include 'header.php' ?>
            <div class="row book-pay">
                <div class="span12">	
                    <br /><br />
                    <h1>Your Booking Summary</h1><br />

                    <div class="row">
                        <div class="span12">		
                            <div class="row">

                                <div class="span8">
                                    <h3><span>Detail</span></h3>				
                                    <br>
                                    <div class="pull-left strong">Your Name</div><div class="pull-right "><?php echo $_SESSION["firstname"]. " " . $_SESSION["lastname"]; ?></div><br />
                                    <div class="pull-left strong">Dormitory</div><div class="pull-right ">MyPlace 2</div><br />
                                    <div class="pull-left strong">Room type</div><div class="pull-right">Superior</div><br />
                                    <div class="pull-left strong">Booking Time</div><div class="pull-right"><?php echo date("r"); ?></div><br />
                                    <div class="pull-left strong">Make Contract Before</div><div class="pull-right "><?php echo date("r", strtotime("+1 day", strtotime(date("r")))) ?> </div><br />
                                    <br>
                                    <div class="pull-left strong">Please Confirm Your Identity Card Number</div><div class="pull-right strong">Please Confirm Telephone Number</div><br>
                                    <div class="pull-left strong"><input name="idcard" class="form-control" type="text" required></div>
                                    <div class="pull-right strong" style="width: 40%"><input name="telephone" class="form-control" type="text" required></div><br>
                                    <a href="book-pay.php" style="margin-top: 30px" class="btn btn-primary btn-large book-now pull-right">Confirm</a>
                                    <br />
                                    <br />
                                    <br />
                                    <br />
                                    <div class ="span10" style="margin-top: 50px">
                                        <h3><span>You Should go to make Contract Before Wed 16, May 2014 15:24:33 
                                                <br>If you don't go to make contract the System will recognize
                                                <br>And If it already 3 times you will be a blacklist  </span></h3>


                                    </div>
                                </div>




                                <div class="span3 pull-right">
                                    <p>Contract Fee Price</p>
                                    <span class="price">4000.00 THB</span>
                                </div>		

                            </div>

                        </div>
                    </div><br /><hr />





                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div></div> <!-- /container -->
            <?php include 'footer.php' ?>

     