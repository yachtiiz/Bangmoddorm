

<script>

    $(function() {
        $("#select_dorm").live("change", function(event) {
            event.preventDefault();
            $("#sort_chosendate").removeAttr("value");
            url = "callback.php?showbook_dormID=" + $(this).val() + "&dormbook_order=" + $("#book_order").val() + "&dormbook_showpage=1";
            show_page = "callback.php?showpage_dormID=" + $(this).val() + "&dormbook_page=1";
            if ($(this).val() === "default") {
                $("#show_result").html("<tr><td colspan='8' style='text-align: center'> No Result </td></tr>");
                for (i = 1; i < 8; i++) {
                    $("#show_result").append("<tr style='height: 51px'><td colspan='8'></td></tr>");
                }
                $("#show_book_page").html("");
            }
            else {
                $("#show_result").animate({
                    opacity: 0
                }, 100, function() {
                    $("#show_result").load(url, function() {
                        $("#show_result").animate({
                            opacity: 1
                        }, 200);
                    });
                });
                $("#show_book_page").animate({
                    opacity: 0
                }, 100, function() {
                    $("#show_book_page").load(show_page, function() {
                        $("#show_book_page").animate({
                            opacity: 1
                        }, 200);
                    });
                });
            }
            return false;
        });
    });

    $(function() {
        $(".page_book li a").live("click", function() {
            event.preventDefault();
            url = $(this).attr("href") + "&showbook_dormID=" + $("#select_dorm").val() + "&dormbook_order=" + $("#book_order").val();
            cur_page = "callback.php?dormbook_page=" + $(this).attr("value") + "&showpage_dormID=" + $("#select_dorm").val();
            $("#show_book_page").load(cur_page);
            $("#show_result").animate({
                opacity: 0
            }, 100, function() {
                $("#show_result").load(url, function() {
                    $("#show_result").animate({
                        opacity: 1
                    }, 200);
                });
            });
        });
    });

    $(function() {
        $("#book_order").live("change", function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?showbook_dormID=" + $("#select_dorm").val() + "&dormbook_order=" + $(this).val() + "&dormbook_showpage=1";
                cur_page = "callback.php?showpage_dormID=" + $("#select_dorm").val() + "&dormbook_page=1";
                $("#show_result").animate({
                    opacity: 0
                }, 100, function() {
                    $("#show_result").load(url, function() {
                        $("#show_result").animate({
                            opacity: 1
                        }, 200);
                    });
                });
                $("#show_book_page").animate({
                    opacity: 0
                }, 100, function() {
                    $("#show_book_page").load(show_page, function() {
                        $("#show_book_page").animate({
                            opacity: 1
                        }, 200);
                    });
                });
            }
        });
    });


    $(function() {

        $("#searching").live("keyup", function() {
            if ($("#select_dorm").val() !== "default") {
                event.preventDefault();
                $("#show_book_page").html("");
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $(this).val().replace(/ /g, "+");
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
                if ($("#searching").val() === "") {
                    $("#show_book_page").load("callback.php?dormbook_page=1&showpage_dormID=" + $("#select_dorm").val());
                }
            }
        });
        $("#only_bookid").click(function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=bookingID";
                $("#show_result").load(url);
            }
        });
        $("#only_date").click(function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=date";
                $("#show_result").load(url);
            }
        });
        $("#only_status").click(function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=booking_status";
                $("#show_result").load(url);
            }
        });
        $("#all_type").click(function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+");
                $("#show_result").load(url);
            }
        });

        $("#sort_chosendate").live("change", function() {
            if ($("#select_dorm").val() !== "default") {
                url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $(this).val() + "&search_only=date";
                $("#show_result").load(url);
            }
        });

    });

</script>


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
                                <select id="select_dorm" class="form-control pull-left" style="width:30%">
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
                                    <span class="input-group-addon">Sort By Booking Date</span>
                                    <input id="sort_chosendate" type="date" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="span12">
                                <div class="col-md-7" style="padding: 0px">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon">Search Booking</span>
                                        <input id="searching" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3 pull-right" style="margin-left:20px">
                                    <select id="book_order" class="form-control pull-right" style="width:100%">
                                        <option value="date%20desc">Sort By Date</option>
                                        <option value="booking_status">Sort By Status</option>
                                    </select>
                                </div>
                                <div class="col-md-2 radio" style="padding-left: 5px">
                                    <label>
                                        <input id="only_bookid" name="search_only" type="radio"> Only Booking ID
                                    </label>
                                </div>
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="only_date" name="search_only" type="radio"> Only Date
                                    </label>
                                </div>
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="only_status" name="search_only" type="radio"> Only Status
                                    </label>
                                </div>
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="all_type" name="search_only" type="radio" checked> All Type
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
                                    <th style="width: 100px"></th>
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
                            </div>
                            <a href="index.php?chose_page=ownersystem" class="btn btn-primary btn-large book-now" style="margin-left: 400px;margin-top: 30px">Back</a>
                        </div>
                        <br />
                    </fieldset>

                    <script>

                        $(document).on("click", ".viewdetail", function() {
                            $(".modal-body-booking #bookid").html($(this).data('bookid'));
                            document.getElementById("submitbutton").setAttribute("value",$(this).data('bookid'));
                            $(".modal-body-booking #name").html($(this).data('name'));
                            $(".modal-body-booking #date").html($(this).data('date'));
                            $(".modal-body-booking #expire_date").html($(this).data('expiredate'));
                            if ($(this).data('slip') === "") {
                                document.getElementById("slip").setAttribute("src", "/images/picture_slip/default_slip_picture.jpg");
                            } else {
                                document.getElementById("slip").setAttribute("src", "/images/picture_slip/" + $(this).data('slip'));
                            }
                            if ($(this).data('status') === "Approve") {
                                document.getElementById("approve").setAttribute("selected", "");
                            }
                            if ($(this).data('status') === "Checking") {
                                document.getElementById("checking").setAttribute("selected", "");
                            }
                            if ($(this).data('status') === "Canceled") {
                                document.getElementById("cancel").setAttribute("selected", "");
                            }
                            if ($(this).data('status') === "Reject") {
                                document.getElementById("reject").setAttribute("selected", "");
                            }
                            if ($(this).data('status') === "Waiting") {
                                document.getElementById("waiting").setAttribute("selected", "");
                            }
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
                                                <h5 style="text-align: left">Booking Status :<select class="form-control pull-right" id="book_status" style="width: 20%;height: 26px"><option id="approve">Approve</option><option id="checking">Checking</option><option id="waiting">Waiting</option><option id="cancel">Canceled</option><option id="reject">Reject</option></select></h5>
                                                <h5 style="text-align: left">Booking Date :<span id="date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                <h5 style="text-align: left">Booking Date Expire :<span id="expire_date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                <h5 style="text-align: left;color: #33cc00">Total Price :<span id="totalprice" class="pull-right" style="color: #33cc00">6000 Bath</span></h5>
                                                <legend style="font-style: italic;text-align: right">Money Transfer Evidence</legend>
                                                <h5 style="text-align: left">Transfer Name : <span class="pull-right" id="transfername">นาย ยอช เอง</span></h5>
                                                <h5 style="text-align: left">Transfer Time : <span class="pull-right" id="transfertime">2014-09-04T15:33</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        <button id="submitbutton" type="button" name="confirm" class="confirm btn btn-success">Change Status</button>
                                    </div>
                                    <script>



                                    </script>
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