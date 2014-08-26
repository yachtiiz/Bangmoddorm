
            <?php include 'header.php' ?>
            <div class="row book-pay">

                <div class="span12">	
                    <br /><br />
                    <h1>Review your selection</h1><br />

                    <div class="row">
                        <div class="span12">		
                            <div class="row">

                                <div class="span6">
                                    <h3><span>Your</span> chosen rooms</h3>				

                                    <div class="pull-left strong">Room type</div><div class="pull-right ">Classic Room</div><br />
                                    <div class="pull-left strong">Arrival date</div><div class="pull-right">Thu 10, January 2013</div><br />
                                    <div class="pull-left strong">Departure date</div><div class="pull-right">Fri 11, January 2013</div><br />
                                    <div class="pull-left strong">Duration</div><div class="pull-right">1 night,1 room</div><br /><br />

                                    <div class="pull-left strong">Guests</div><div class="pull-right">2 adults and 1 child</div><br />
                                </div>

                                <div class="span3 pull-right">
                                    <p>Base price</p>
                                    <span class="price">1280.00 GBP</span>
                                </div>		

                            </div>

                        </div>
                    </div><br /><hr />

                    <div class="row">
                        <div class="span12">

                            <div class="row">

                                <div class="span7">
                                    <h3><span>Customize</span> your stay</h3>		
                                    <div class="row">
                                        <div class="span3">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Breakfast Buffet</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Wi-Fi</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Non-smoking</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Newspaper</div><div class="pull-right"><input type="checkbox" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Luggage storage</div><div class="pull-right"><input type="checkbox" /></div>
                                            </div>
                                        </div>
                                        <div class="span3 offset1">
                                            <div class="custom_container">
                                                <div class="pull-left strong">Parking</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Limo service</div><div class="pull-right"><input type="checkbox" checked="checked" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Air conditioning</div><div class="pull-right"><input type="checkbox" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Hair dryer</div><div class="pull-right"><input type="checkbox" /></div>
                                            </div>
                                            <div class="custom_container">
                                                <div class="pull-left strong">Sea view</div><div class="pull-right"><input type="checkbox" /></div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="span3 pull-right">
                                    <p>Extras</p>
                                    <span class="price" id="extras_price">0.00 GBP</span>
                                </div>	
                            </div>	

                        </div>
                    </div><br /><hr />

                    <div class="row">
                        <div class="span12">

                            <div class="row">
                                <div class="span8">
                                    <h3><span>Payment</span> information</h3>				

                                    <form class="form-horizontal" />
                                    <div class="control-group">
                                        <label for="inputWarning" class="control-label pay strong">Card Type</label>
                                        <div class="controls">
                                            <select class="span4"><option value="0" />Select<option value="VISA" />Visa<option value="Master" />MasterCard<option value="Diners" />DinersClub<option value="AMEX" />AmEx </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="inputError" class="control-label pay strong">Card Number</label>
                                        <div class="controls">
                                            <input type="text" class="span3" />
                                            <strong>CVV</strong>
                                            <input type="text" class="span1 cvv2" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="inputInfo" class="control-label pay strong">Expiration Date</label>
                                        <div class="controls">
                                            <select class="span2 month_picker"><option value="0" />Month<option value="1" />January<option value="2" />February<option value="3" />March<option value="4" />April<option value="5" />May<option value="6" />June<option value="7" />July<option value="8" />August<option value="9" />September<option value="10" />October<option value="11" />November<option value="12" />December</select>
                                            <select class="span2 year_picker"><option value="0" />Year<option value="2013" />2013<option value="2014" />2014<option value="2015" />2015<option value="2016" />2016<option value="2017" />2017<option value="2018" />2018<option value="2019" />2019<option value="2020" />2020<option value="2021" />2021<option value="2022" />2022<option value="2023" />2023</select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="inputSuccess" class="control-label pay strong">Cardholder full name</label>
                                        <div class="controls">
                                            <input type="text" class="span4 card_holder" />
                                        </div>
                                    </div>
                                    </form>
                                </div>


                                <div class="span3 pull-right">
                                    <p><strong>Total price</strong></p>
                                    <span class="price strong" id="total_price">1280.00 GBP</span>
                                </div>	

                                <div class="span12">
                                    <button class="btn btn-primary btn-large book-now pull-right">Submit payment</button>
                                    <br />
                                    <br />
                                </div>	

                            </div><br />

                        </div>
                    </div>




                </div>

            </div></div> <!-- /container -->
            <?php include 'footer.php' ?>
       