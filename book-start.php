
<?php include 'header.php' ?>
<div class="row book-start">
    <div class="span12">	
        <br /><br />
        <h1>Book your room<br /><small>When would you like to stay with us?</small></h1>
        <div class="row">
            <div class="span9">
                <h3><span>Check-in</span> date</h3>
                <div type="text" class="datepicker_from" name="from"></div>
                <h3><span>Check-out</span> date</h3>
                <div type="text" class="datepicker_to" name="to"></div>
            </div>			
            <div class="span3">
                <div class="row">
                    <div class="span3">
                        <h3><span>select</span> your room</h3>
                        <div class="room_selector" data-price="34" data-adults="1" data-kids="1">
                            <h5><a href="#" class="pull-left"><i class="icon-chevron-left"></i></a>Single room<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/single_room.jpg" alt="" /></a>
                            <p>All single rooms have one single bed and sleeps one adult. A 25-inch TV is included.</p>
                        </div>
                        <div class="room_selector" data-price="48" data-adults="2" data-kids="1" style="display: none;">
                            <h5><a href="#" class="pull-left "><i class="icon-chevron-left"></i></a>Double Room<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/double_room.jpg" alt="" /></a>
                            <p>All double rooms have a single double bed and sleeps two adults.</p>
                        </div>		
                        <div class="room_selector" data-price="62" data-adults="3" data-kids="2" style="display: none;">
                            <h5><a href="#" class="pull-left "><i class="icon-chevron-left"></i></a>Triple Room<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/triple_room.jpg" alt="" /></a>
                            <p>All triple rooms have one double bed and a single bed and sleeps up to three people. </p>
                        </div>	
                        <div class="room_selector" data-price="72" data-adults="4" data-kids="3" style="display: none;">
                            <h5><a href="#" class="pull-left "><i class="icon-chevron-left"></i></a>Luxury Room<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/luxury_room.jpg" alt="" /></a>
                            <p>All rooms have two double beds and a balcony. Sleeps up to four adults.</p>
                        </div>		
                        <div class="room_selector" data-price="97" data-adults="4" data-kids="3" style="display: none;">
                            <h5><a href="#" class="pull-left "><i class="icon-chevron-left"></i></a>Private pool room<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/private_pool.jpg" alt="" /></a>
                            <p>A private pool, two double beds and a sea view. Sleeps up to four adults.</p>
                        </div>
                        <div class="room_selector" data-price="128" data-adults="5" data-kids="4" style="display: none;">
                            <h5><a href="#" class="pull-left "><i class="icon-chevron-left"></i></a>Private villa<a href="#" class="pull-right "><i class="icon-chevron-right"></i></a></h5>
                            <a href="listings.html"><img src="css/images/rooms/private_villa.jpg" alt="" /></a>
                            <p>All villas have an en-suite bathroom and sundeck. Sleeps up to five adults.</p>
                        </div>
                    </div>					
                </div>
            </div>	<br />






            <div class="row">

                <div class="span3">
                    <h3><span>Rooms</span> and people</h3>

                    <div class="form-horizontal">

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Rooms</label>
                            <div class="controls">
                                <select class="span1 select_rooms">
                                    <option />1
                                    <option />2
                                    <option />3
                                    <option />4
                                    <option />5
                                </select>
                            </div>
                        </div>			


                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Adults per room</label>
                            <div class="controls">
                                <select class="span1 select_adults">
                                    <option />1
                                    <option />2
                                    <option />3
                                    <option />4
                                    <option />5
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="inputEmail">Kids per room</label>
                            <div class="controls">
                                <select class="span1 select_kids">
                                    <option />1
                                    <option />2
                                    <option />3
                                    <option />4
                                    <option />5
                                </select>
                            </div>
                        </div>



                    </div>








                </div>


                <div class="row">

                    <div class="span3">
                        <h1 id="total_price">128.00 GBP</h1>
                        <a class="btn btn-primary btn-large book-now" href="book.jsp">Book now!</a>
                    </div>
                </div>		</div>
        </div>

        <br /><br />		
        <p>Please note: All single rooms have one single bed and sleeps one adult. A 25-inch TV is included. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui.</p>
        <br /><br />			




    </div>

</div></div> <!-- /container -->
    <?php include 'footer.php' ?>