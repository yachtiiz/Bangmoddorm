
<div class="row booking_summary">

    <div class="span12">	

        <div class="row">
            <div class="span10">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="row">
                            <div class="col-md-10" style="margin-left: 70px">
                                <legend style="text-align: center"><span>Dormitory </span>Information</legend>
                            </div>
                            <div class="col-md-4" style="margin-left:70px">
                                <h4>Name <span class="pull-right">: </span></h4>
                                <h4>Type <span class="pull-right">: </span> </h4>
                                <h4>Owner <span class="pull-right">: </span> </h4>
                                <h4>Contact <span class="pull-right">: </span> </h4>
                                <h4>Email <span class="pull-right">: </span> </h4>
                                <h4 style="margin-top: 20px">Distance From University <span class="pull-right">: </span> </h4>
                                <h4>Rate <span class="pull-right">: </span> </h4>
                                <h4>Number Of Rooms Type <span class="pull-right">: </span> </h4>
                                <h4>Number Of Rooms <span class="pull-right">: </span> </h4>
                                <h4>All Available Room <span class="pull-right">: </span> </h4>
                                <h4>All Reserve Room <span class="pull-right">: </span> </h4>

                            </div>
                            <div class="col-md-6" style="margin-left:0px">
                                <h4><span class="pull-right">My Place 2</span></h4><br>
                                <h4><span class="pull-right">Male & Female</span></h4><br>
                                <h4><a class="pull-right" href="index.php?chose_page=index" style="color: #0099ff">Ajchariya Arunramwong</a></h4><br>
                                <h4><span class="pull-right">(+66)90-971-1786</span></h4><br>
                                <h4><span class="pull-right">surachai@gmail.com</span></h4><br><br>
                                <h4><span class="pull-right">5 Kilometers</span></h4><br>
                                <h4><span class="pull-right" style="color:gold">&#9733;&#9733;&#9733;&#9733;&#9733;</span></h4><br>
                                <h4><span class="pull-right"> 3 Type</span></h4><br>
                                <h4><span class="pull-right"> 50 Rooms</span></h4><br>
                                <h4><span class="pull-right"> 30 Rooms</span></h4><br>
                                <h4><span class="pull-right"> 20 Rooms</span></h4><br>
                            </div>
                            <div class="col-md-10" style="margin-left:70px">
                                <h3 style="text-align: center">Dormitory Facilities</h3>
                                <?php
                                require 'connection.php';
                                $fac_dorm_query = "select * from FacilitiesInDorm where dormID = 9";
                                $fac_dorm_result = mysqli_query($con, $fac_dorm_query);
                                $fac_dorm_row = mysqli_fetch_array($fac_dorm_result);
                                ?>
                                <table class="table table-striped" style="border:solid 1px #cccccc">
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["wifi"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WIFI</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["lan"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAN</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["airCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; AIRCLEANSERVICE</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["roomCleanService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ROOMCLEANSERVICE</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["washingService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; WASHINGSERVICE</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["busService"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; BUSSERVICE</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["fitness"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; FITNESS</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["pool"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; POOL</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["restaurant"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; RESTAURANT</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["vendingMachine"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; VENDINGMACHINE</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["laundry"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; LAUNDRY</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["elevator"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; ELEVATOR</h3> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["cctv"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; CCTV</h3>
                                        </td>
                                        <td>
                                            <h3 style="text-align:left"> <?php echo $fac_dorm_row["parking"] === "0" ? '<span style="color:red" class="glyphicon glyphicon-remove-circle"></span>' : '<span style="color:green" class="glyphicon glyphicon-ok-circle"></span>' ?>&nbsp; PARKING</h3>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </div>		
                        <br />
                        <a href="checkDormInfo.jsp" class="btn btn-primary btn-large book-now" style="margin-left:38%;margin-bottom: 50px">Back</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div></div>
</div><!-- /container -->
