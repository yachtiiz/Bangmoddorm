
            <div class="row booking_summary">
                <div class="span12">	
                    <div class="row">
                        <div class="span10">
                            <?php
                            
                            if(isset($_GET["dormID"]) && is_numeric($_GET["dormID"])){
                                require 'connection.php';
                                
                                $query = "select * from dormitories where dormID=".$_GET["dormID"];
                                $result = mysqli_query($con, $query);
                                $row = mysqli_fetch_array($result);
                            
                            
                            ?>
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <fieldset>
                                <br />
                                <h1>Edit Your Dormitory<br /><small>You can edit your dormitory information.
                                    </small></h1><br />
                                <div class="row">
                                    <div class="span8">
                                        <legend><span>Dormitory </span>Information</legend>
                                    </div>

                                    <div class="span3">
                                        <label>Dormitory Name
                                            <input class="form-control" disabled name="dorm_name" type="text" value="<?php echo $row["dormName"] ?>" />
                                        </label>
                                    </div>	
                                    <div class="span3">
                                        <label>Dormitory Type
                                            <select class="form-control" name="type"><option value="female" />Female Only<option value="male" />Male Only<option value="both" />Female & Male</select>
                                        </label>
                                    </div>
                                    <div class="span3">
                                        <label>Distance From University
                                            <input class="form-control" name="distance" type="text" placeholder="Insert only Number unit is KM." />
                                        </label>
                                    </div>	
                                </div>		
                                <br />
                                <div class="row">
                                    <div class="span8">
                                        <legend><span>Dormitory</span> address</legend>
                                    </div>

                                    <div class="span3">
                                        <label>Address No.
                                            <input class="form-control" type="text" name="address">
                                        </label>
                                        <label>Sub Distinct
                                            <input class="form-control" type="text" name="sub_distinct">
                                        </label>
                                        <label>Zipcode
                                            <input class="form-control" type="text" name="zip_code">
                                        </label>
                                    </div>				

                                    <div class="span3">
                                        <label>Soi
                                            <input class="form-control" type="text" name="soi" />
                                        </label>
                                        <label>Distinct
                                            <input class="form-control" type="text" name="distinct"/>
                                        </label>
                                        <label>Latitude
                                            <input class="form-control" type="text" name="latitude"/>
                                        </label>
                                    </div>

                                    <div class="span3">
                                        <label>Road
                                            <input class="form-control" type="text" name="road" />
                                        </label>
                                        <label>Province
                                            <input class="form-control" type="text" name="province" />
                                        </label>
                                        <label>Longitude
                                            <input class="form-control" type="text" name="longtitude" />
                                        </label>
                                    </div>

                                </div>  
                                <br />
                                <div class="row">
                                    <div class="span8">
                                        <legend><span>Dormitory</span> Contact</legend>
                                    </div>
                                    <div class="span3">
                                        <label>Email
                                            <input class="form-control" type="text" placeholder="" name="email" />
                                        </label>
                                    </div>

                                    <div class="span3">
                                        <label>Telephone
                                            <input class="form-control" type="text" placeholder="" name="tel"/>
                                        </label>
                                    </div>	
                                </div>
                                <br />

                                <div class="row">

                                    <div class="span8">
                                        <legend><span>Dormitories </span>Facilities</legend>
                                    </div>		

                                    <div class="span3">
                                        <div class="custom_container">
                                            <div class="pull-left">WiFi</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Clean Service</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Washing Service</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Vending Machine</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Restaurant</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Swimming Pool</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                    </div>
                                    <div class="span3 offset1">
                                        <div class="custom_container">
                                            <div class="pull-left ">Lan</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Air Clean Service</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Laundry</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Bus Service</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Fitness</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">CCTV</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="span5">
                                        <label>    
                                            <input class="form-control" name="number_of_parking" type="number" placeholder="Input Number of All Parking" />
                                        </label>
                                    </div>
                                </div>

                                <br/>
                                <div class="row">
                                    <div class="span8">
                                        <legend><span>Dormitory</span> Picture</legend>
                                    </div>
                                    <div class="span4">
                                        <label>Picture1 
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture2
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder=""/>
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture3 
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture4 
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture5 
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture6 
                                            <input class="form-control" name="dorm_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span9">
                                        <br>
                                        <button name="edit_dorm_submit" type="submit" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                        <a href="ownersystem.jsp" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                        <br><br>
                                    </div>
                                </div>
                            </fieldset>
                            </form>
                            <?php } ?>
                        </div>

                    </div>

                </div></div> <!-- /container -->
                </div>
