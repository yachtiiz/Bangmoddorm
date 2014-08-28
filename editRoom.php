
<?php if(isset($_GET["dormName"]) && isset($_GET["dormID"])){ ?>

            <div class="row booking_summary">
                <div class="span12">	
                    <div class="row">
                        <div class="span10">
                            <form action="" method="post" class="form-horizontal">
                            <fieldset>
                                
                                <h1>Add Your Room Type<br /><small>You can add your room type and fill the information.
                                    </small></h1><br />
                                <div class="row">

                                    <div class="span10">
                                        <legend><span>Dormitory </span>Information</legend>
                                    </div>

                                    <div class="span3">
                                        <label>Dormitory Name
                                            <input disabled value="<?php echo $_GET["dormName"]; ?>" type="text" class="form-control" />
                                            <input type="hidden" name="dormID" value="<?php echo $_GET["dormID"]; ?>">
                                        </label>
                                    </div>		
                                </div>		
                                <br />
                                <div class="row">
                                    <div class="span10">
                                        <legend><span>Room</span> Information</legend>
                                    </div>

                                    <div class="span3">
                                        <label>Room Name
                                            <input class="form-control" type="text" name="room_name">
                                        </label>
                                        <label>Number Of Room
                                            <input type="text" class="form-control" name="number_of_room">
                                        </label>
                                    </div>				

                                    <div class="span3">
                                        <label>Areas
                                            <input type="text" class="form-control" name="room_area" />
                                        </label>
                                        <label>Room Avaliable
                                            <input type="text" class="form-control" name="room_available"/>
                                        </label>
                                    </div>

                                    <div class="span3">
                                        <label>Price
                                            <input type="text" class="form-control" name="price_per_month" />
                                        </label>
                                        <label>Room Reserve
                                            <input type="text" class="form-control" name="room_reserve" />
                                        </label>
                                    </div>

                                </div>  
                                <br />
                                
                                <div class="row">

                                <div class="span10">
                                    <legend><span>Room </span>Facilities</legend>
                                </div>		

                                <div class="span5">

                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Air Condition
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Refrigrator
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Chair
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Water Heater
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Fan
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>

                                    
                                </div>

                                <div class="span5">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            Wardrobe
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Table
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Bed
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Mattress
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            Television
                                        </span>
                                        <input type="text" placeholder='Detail' class="form-control">
                                        <span class="input-group-addon" >
                                            <input type="checkbox">
                                        </span>
                                    </div>
                                    <br>
                                </div>
                            </div>

                                <div class="row">

                                    <div class="span8">
                                        <legend><span>Room </span>Facilities</legend>
                                    </div>		

                                    <div class="span3">
                                        <div class="custom_container">
                                            <div class="pull-left">Air Conditioning</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Refrigerator</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Chair</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Water Heater</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Fan</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                    </div>
                                    <div class="span3 offset1">
                                        <div class="custom_container">
                                            <div class="pull-left ">Wardrobe</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Table</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Bed</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Mattress</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>
                                        <div class="custom_container">
                                            <div class="pull-left ">Television</div><div class="pull-right"><input type="checkbox" /></div>
                                        </div>

                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="span8">
                                        <legend><span>Room</span> Picture</legend>
                                    </div>
                                    <div class="span4">
                                        <label>Picture1 
                                            <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture2
                                            <input class="form-control" name="room_pic[]" type="file" placeholder=""/>
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture3 
                                            <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture4 
                                            <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture5 
                                            <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                    <div class="span4">
                                        <label>Picture6 
                                            <input class="form-control" name="room_pic[]" type="file" placeholder="" />
                                        </label>
                                    </div>
                                </div>
                                <br />


                                <div class="row">
                                    <div class="span9">
                                        <br />
                                         <button type='submit' class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Submit</button>
                                        <a href="index.php?chose_page=ownersystem" class="btn btn-primary btn-large book-now pull-right">Back</a>
                                        
                                        <br />
                                        <br />
                                    </div>
                                </div>

                            </fieldset>
                            </form>

                        </div>

                    </div>

                </div></div> <!-- /container -->
                </div>
<?php } else { ?>
                <h1>Something Error</h1>
<?php } ?>
