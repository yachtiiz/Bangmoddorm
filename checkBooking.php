

<script type="text/javascript" src="js/checkBooking.js"></script>


<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span12">
                <form class="form-horizontal">
                    <fieldset>
                        <br />
                        <div class="row">
                            <div class="span12">
                                <legend>
                                    <span>Booking</span> System
                                </legend>
                            </div>
                            <div class="span12" style="margin-bottom: 30px">
                                <select id="select_dorm" class="form-control pull-left" style="width:20%">
                                    <option value="default">Select Dormitories</option>
                                    <?php
                                    require 'connection.php';
                                    $memberID = $_SESSION["memberID"];

                                    $query = "select * from dormitories where memberID = $memberID";
                                    $result = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value="<?php echo $row["dormID"]; ?>"><?php echo $row["dormName"]; ?> </option>
                                    <?php } ?>
                                </select>


                                <div class="input-group pull-right" style="width:30%">
                                    <span class="input-group-addon">Search By Booking Date</span>
                                    <input id="sort_chosendate" type="date" class="form-control" placeholder="Username">
                                </div>
                                
                            </div>
                            <div class="span12">
                                <div class="col-md-5" style="padding: 0px">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon">Search Booking</span>
                                        <input id="searching" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3" style="">
                                <select id="search_status" class="form-control" style="width:100%;margin-left:20%">
                                    <option id="status_default" value="default">Search By Status</option>
                                    <option value="Approve">Approve</option>
                                    <option value="Checking">Checking</option>
                                    <option value="Waiting">Waiting</option>
                                    <option value="Canceled">Canceled</option>
                                    <option value="Reject">Reject</option>
                                </select>
                                </div>
                                <div class="col-md-3 pull-right" style="margin-left:20px">
                                    <select id="book_order" class="form-control pull-right" style="width:100%">
                                        <option id="sort_default" value="date%20desc">Sort By Date</option>
                                        <option value="booking_status">Sort By Status</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="all_type" name="search_only" type="radio" checked> All Type
                                    </label>
                                </div>
                                <div class="col-md-2 radio" style="padding-left: 5px">
                                    <label>
                                        <input id="only_bookid" name="search_only" type="radio"> By Booking ID
                                    </label>
                                </div>
                            </div>
                            <div class="span12">
                                <br>
                                <table class="table table-striped table-hover" style="border: solid 1px #cccccc">
                                    <th style="width: 120px">Booking ID</th>
                                    <th style="width: 100px">First Name</th>
                                    <th style="width: 100px">Last Name</th>
                                    <th style="width: 170px">Booking Date</th>
                                    <th style="width: 170px">Expire Date</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 100px"><button id="refresh_result" class="btn1 btn1-default">Refresh Booking</button></th>
                                    <tbody id="show_result">
                                        <tr>
                                            <td colspan="7" style="text-align: center;height: 51px"> No Result</td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="7"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="span12">
                                <ul id="show_book_page" class="page_book pagination pull-right" style="margin-top: 0px">

                                </ul>
                                <ul id="show_status_page" class="page_status pagination pull-right" style="margin-top: 0px">

                                </ul>
                                <ul id="show_sort_page" class="page_sort_date pagination pull-right" style="margin-top: 0px">

                                </ul>

                            </div>
                            <a href="index.php?chose_page=ownersystem" class="btn1 btn1-danger" style="margin-left: 20px;margin-top: 30px; width: 30%">Back</a>
                        </div>
                        <br />
                    </fieldset>

                    <script>

                        $(document).on("click", ".viewdetail", function() {
                            $(".modal-body-booking #bookid").html($(this).data('bookid'));
                            document.getElementById("approvebutton").setAttribute("value", $(this).data('bookid'));
                            document.getElementById("rejectbutton").setAttribute("value", $(this).data('bookid'));
                            document.getElementById("canceledbutton").setAttribute("value", $(this).data('bookid'));
                            $(".modal-body-booking #name").html($(this).data('name'));
                            $(".modal-body-booking #date").html($(this).data('date'));
                            $(".modal-body-booking #expire_date").html($(this).data('expiredate'));
                            if ($(this).data('slip') === "") {
                                document.getElementById("slip").setAttribute("src", "/images/picture_slip/default_slip_picture.jpg");
                            } else {
                                document.getElementById("slip").setAttribute("src", "/images/picture_slip/" + $(this).data('slip'));
                            }
                            if ($(this).data('status') === "Approve") {
                                document.getElementById("status").setAttribute("style", "color:#00cc33");
                            }
                            if ($(this).data('status') === "Checking") {
                                document.getElementById("status").setAttribute("style", "color:#0480be");
                            }
                            if ($(this).data('status') === "Canceled") {
                                document.getElementById("status").setAttribute("style", "color:red");
                            }
                            if ($(this).data('status') === "Reject") {
                                document.getElementById("status").setAttribute("style", "color:red");
                            }
                            if ($(this).data('status') === "Waiting") {
                                document.getElementById("status").setAttribute("style", "color:black");
                            }
                            $(".modal-body-booking #status").html($(this).data('status'));
                            $(".modal-body-booking #dormname").html($(this).data('dormname'));
                            $(".modal-body-booking #room").html($(this).data('room'));
                            $(".modal-body-booking #totalprice").html($(this).data('totalprice'));
                            if ($(this).data('transfername') !== "") {
                                $(".modal-body-booking #transfername").html($(this).data('transfername'));
                            } else {
                                $(".modal-body-booking #transfername").html("Empty Data");
                            }
                            if ($(this).data('transfername') !== "") {
                                $(".modal-body-booking #transfertime").html($(this).data('transfertime'));
                            } else {
                                $(".modal-body-booking #transfertime").html("Empty Data");
                            }

                        });

                        $(function() {

                            $("#submitbutton").on("click", function() {

                                change_url = "callback.php?change_booking_status=" + $("#book_status").val() + "&change_booking_id=" + $(this).val();
                                $("#submitbutton").load(change_url);

                                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+");
                                if ($("#only_bookid").attr("checked")) {
                                    special_url = url + "&search_only=bookingID";
                                    $("#show_result").load(special_url);
                                } else
                                if ($("#only_date").attr("checked")) {
                                    special_url = url + "&search_only=expire_date";
                                    $("#show_result").load(special_url);
                                } else
                                if ($("#only_status").attr("checked")) {
                                    special_url = url + "&search_only=booking_status";
                                    $("#show_result").load(special_url);
                                } else {
                                    $("#show_result").load(url);
                                }
                            });
                        });

                    </script>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" style="background-color: #f5f5f5">
                                <form id="addcontent" action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Book Modal</h4>
                                    </div>
                                    <div class="modal-body-booking" style="background-color: white;padding:30px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <legend style="font-style: italic;text-align: right">Booking Detail</legend>
                                            </div>
                                            <div class="col-md-4" style="text-align: center;margin-bottom: 30px;margin-left: 60px">
                                                <h5 style="text-align: center">Slip Image</h5>
                                                <img id="slip" style="width: 340px;height: 370px;" src="images/picture_evidence/evidance_9_LNERU" class="img-thumbnail">
                                            </div>
                                            <div class="col-md-7" style="margin-top: 0px">
                                                <h5 style="text-align: left">Booking ID : <span id="bookID" class="pull-right">14</span></h5>
                                                <h5 style="text-align: left">Customer Name : <span id="name" class="pull-right">Ajchariya Arunaramwong</span></h5>
                                                <h5 style="text-align: left">Dormitory Name :<span id="dormname" class="pull-right">Myplace 2</span></h5>
                                                <h5 style="text-align: left">Room Type : <span id="room" class="pull-right">Superior</span></h5>
                                                <h5 style="text-align: left">Booking Status :<span id="status" class="pull-right">Checking</span></h5>
                                                <h5 style="text-align: left">Booking Date :<span id="date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                <h5 style="text-align: left">Booking Date Expire :<span id="expire_date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                <h5 style="text-align: left;color: #33cc00">Total Price :<span id="totalprice" class="pull-right" style="color: #33cc00">6000 Bath</span></h5>
                                                <legend style="font-style: italic;text-align: right">Money Transfer Evidence</legend>
                                                <h5 style="text-align: left">Transfer Name : <span class="pull-right" id="transfername">นาย ยอช เอง</span></h5>
                                                <h5 style="text-align: left">Transfer Time : <span class="pull-right" id="transfertime">2014-09-04T15:33</span></h5>
                                                <br>
                                                <legend style="font-style: italic;text-align: left">Change Status</legend>
                                                <button id="approvebutton" class="btn1 btn1-success" style="width:30%;margin-left:2%">Approve</button>
                                                <button id="canceledbutton" class="btn1 btn1-warning" style="width:35%">Canceled</button>
                                                <button id="rejectbutton" class="btn1 btn1-danger" style="width:30%">Reject</button>
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="text-align: center">
                                        <span id="ajaxscript"></span>
                                        <button id="close_modal" type="button" class="btn1 btn1-danger" data-dismiss="modal" style="width: 20%">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>       
