<div class="span12">	
    <div class="row">
        <div class="span9">
            <form class="form-horizontal">
                <fieldset>
                    <br />
                    <div class="row">
                        <div class="span12">
                            <legend>
                                <span>Notification</span> System
                            </legend>
                            <select id="noti_orderby" class="form-control" style="width: 25%">
                                <option value="date">Sort By Date</option>
                                <option value="booking_status">Sort By Status</option>
                            </select>
                            <select id="search_status" class="form-control" style="margin-left: 5%;width:25%">
                                <option id="status_default" value="default">Search By Status</option>
                                <option value="Approve">Approve</option>
                                <option value="Checking">Checking</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-hover" style="border:solid 1px #cccccc;margin-bottom: 0px">
                                <th>Booking ID</th>
                                <th>Member Name</th>
                                <th>Dormitory</th>
                                <th>Status</th>
                                <th>Contact</th>
                                <th></th>
                                <tbody id="noti_result">
                                    <?php

                                    function displayPage($cur_page, $query, $href) {

                                        require 'connection.php';

                                        $result = mysqli_query($con, $query);

                                        if (mysqli_num_rows($result) !== 0) {
                                            $total_page = ceil(mysqli_num_rows($result) / 8);
                                        } else {
                                            $total_page = 1;
                                        }
                                        if ($cur_page == 1) {
                                            $prev_page = 1;
                                        } else {
                                            $prev_page = $cur_page - 1;
                                        }
                                        if ($cur_page == $total_page) {
                                            $next_page = $cur_page;
                                        } else {
                                            $next_page = $cur_page + 1;
                                        }

                                        echo '<li><a value=' . $prev_page . ' href="' . $href . $prev_page . '">&laquo;</a></li>';
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            $class = ($cur_page == $i ? "class = 'active'" : "");
                                            echo '<li ' . $class . '><a value=' . $i . ' href="' . $href . $i . '">' . $i . '</a></li>';
                                        }
                                        echo '<li><a value=' . $next_page . ' href="' . $href . $next_page . '">&raquo;</a></li>';
                                    }

                                    function readAble($bookingID) {

                                        require 'connection.php';
                                        $query = "update Booking set owner_noti = 2 where bookingID = $bookingID";
                                        if (mysqli_query($con, $query)) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }

                                    function getTHNUMBER($floor) {

                                        $th_number = "th";

                                        switch ($floor) {
                                            case "1": $th_number = "st";
                                                break;
                                            case "2": $th_number = "nd";
                                                break;
                                            case "3": $th_number = "rd";
                                                break;
                                        }
                                        return $th_number;
                                    }

                                    function getAllNotification() {
                                        require 'connection.php';
                                        $memberID = $_SESSION["memberID"];
                                        $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and (owner_noti = 1 or owner_noti = 2) order by date desc limit 0 , 8";
                                        $result = mysqli_query($con, $query);
                                        if (mysqli_num_rows($result) !== 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $unread = "";
                                                if ($row["owner_noti"] == "1") {
                                                    $unread = 'style="background-color:#f9f9f9"';
                                                }
                                                $color = "black";

                                                switch ($row["booking_status"]) {
                                                    case "Canceled":
                                                        $color = "red";
                                                        break;
                                                    case "Reject":
                                                        $color = "red";
                                                        break;
                                                    case "Checking":
                                                        $color = "#0480be";
                                                        break;
                                                    case "Approve":
                                                        $color = "#00cc33";
                                                        break;
                                                    case "Refund Needed":
                                                        $color = "red";
                                                        break;
                                                }
                                                echo '<tr ' . $unread . '>';
                                                echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                                                echo '<td>' . $row["firstName"] . " " . $row["lastName"] . '</td>';
                                                echo '<td>' . $row["dormName"] . '</td>';
                                                echo '<td style="color:' . $color . '">' . $row["booking_status"] . '</td>';
                                                echo '<td>' . $row["dormTel"] . '</td>';
                                                echo '<td><button type="button" style="width:130px" class="viewdetail btn1 btn1-primary" data-bookID="' . $row["bookingID"] . '" data-name="' . $row["firstName"] . " " . $row["lastName"] . '" data-date="' . $row["date"] . '" data-expiredate="' . $row["expire_date"] . '" data-status="' . $row["booking_status"] . '" data-dormname="' . $row["dormName"] . '" data-room="' . $row["roomType"] . '" data-slip="' . $row["slip"] . '" data-totalprice="' . number_format($row["totalPrice"]) . '" data-transfername="' . $row["transfer_name"] . '" data-transferbank="' . $row["transfer_bank"] . '" data-floor="' . $row["floor_no"] . " " . getTHNUMBER($row["floor_no"]) . '" data-bankacc="' . $row["bank_acc_id"] . '" data-bankname="' . $row["bank_name"] . '" data-transferrefID="' . $row["transfer_referenceID"] . '" data-transfertime="' . $row["transfer_time"] . '" data-toggle="modal" data-target=".bs-example-modal-lg">View Detail</button></td>';
                                                echo '</tr>';
                                                if ($row["owner_noti"] == "1") {
                                                    if (!readAble($row["bookingID"])) {
                                                        echo '<script>alert("something error")<script>';
                                                        break;
                                                    }
                                                }
                                            }
                                        } else {
                                            echo '<tr>';
                                            echo '<td colspan="6" style="text-align:center">No Result</td>';
                                            echo '</tr>';

                                            for ($i = 1; $i < 8; $i++) {
                                                echo '<tr>';
                                                echo '<td colspan="6" style="height:47px"></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
                                            for ($i = mysqli_num_rows($result); $i < 8; $i++) {
                                                echo '<tr>';
                                                echo '<td colspan="6" style="height:47px"></td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }

                                    getAllNotification();
                                    ?>
                                </tbody>
                                <script>

                                    $(document).on("click", ".viewdetail", function() {
                                        $(".modal-body-booking #bookid").html($(this).data('bookid'));
                                        document.getElementById("approvebutton").setAttribute("value", $(this).data('bookid'));
//                                            document.getElementById("rejectbutton").setAttribute("value", $(this).data('bookid'));
                                        document.getElementById("canceledbutton").setAttribute("value", $(this).data('bookid'));
                                        document.getElementById("refundbutton").setAttribute("value", $(this).data('bookid'));
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
                                        $(".modal-body-booking #floor").html($(this).data('floor'));
                                        $(".modal-body-booking #totalprice").html($(this).data('totalprice') + " Baht");
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
                                        if ($(this).data('transferrefid') !== "") {
                                            $(".modal-body-booking #transferrefID").html($(this).data('transferrefid'));
                                        } else {
                                            $(".modal-body-booking #transferrefID").html("Empty Data");
                                        }
                                        if ($(this).data('transfername') !== "") {
                                            $(".modal-body-booking #transferbank").html($(this).data('transferbank'));
                                        } else {
                                            $(".modal-body-booking #transferbank").html("Empty Data");
                                        }
                                        if ($(this).data('bankacc') !== "") {
                                            $(".modal-body-booking #bankacc_id").html($(this).data('bankacc'));
                                        } else {
                                            $(".modal-body-booking #bankacc_id").html("Empty Data");
                                        }
                                        if ($(this).data('bankname') !== "") {
                                            $(".modal-body-booking #bankname").html($(this).data('bankname'));
                                        } else {
                                            $(".modal-body-booking #bankname").html("Empty Data");
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
                                                            <h5 style="text-align: left">Floor No : <span id="floor" class="pull-right">4</span></h5>
                                                            <h5 style="text-align: left">Booking Status :<span id="status" class="pull-right">Checking</span></h5>
                                                            <h5 style="text-align: left">Booking Date :<span id="date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                            <h5 style="text-align: left">Booking Date Expire :<span id="expire_date" class="pull-right">2014-09-08 22:50:43</span></h5>
                                                            <h5 style="text-align: left;color: #33cc00">Total Price :<span id="totalprice" class="pull-right" style="color: #33cc00">6000 Baht</span></h5>
                                                            <legend style="font-style: italic;text-align: right">Money Transfer Evidence</legend>
                                                            <h5 style="text-align: left">Reference ID : <span class="pull-right" id="transferrefID">Empty Data</span></h5>
                                                            <h5 style="text-align: left">Transfer Name : <span class="pull-right" id="transfername">นาย ยอช เอง</span></h5>
                                                            <h5 style="text-align: left">Transfer Time : <span class="pull-right" id="transfertime">2014-09-04T15:33</span></h5>
                                                            <h5 style="text-align: left">Transfer Bank : <span class="pull-right" id="transferbank">2014-09-04T15:33</span></h5>
                                                            <h5 style="text-align: left">Customer Bank Account ID : <span class="pull-right" id="bankacc_id">2014-09-04T15:33</span></h5>
                                                            <h5 style="text-align: left">Customer Bank Name : <span class="pull-right" id="bankname">2014-09-04T15:33</span></h5>
                                                            <br>
                                                            <legend style="font-style: italic;text-align: left">Change Status</legend>
                                                            <button id="approvebutton" class="btn1 btn1-success" style="width:30%;margin-left:2%" data-toggle="tooltip" data-placement="bottom" title="Correct Evidence or Real transfer money" type="button">Approve</button>
                                                            <button id="canceledbutton" class="btn1 btn1-warning" style="width:35%" data-toggle="tooltip" data-placement="bottom" title="Fault Evidence or money not come">Canceled</button>
                                                            <button id="refundbutton" class="btn1 btn1-danger" style="width:30%" data-toggle="tooltip" data-placement="bottom" title="Have a problem ex.Full Room , Money Transfer Problem">Refund Needed</button>
                                                            <br><br>
                                                            <!--                                                                <legend style="font-style: italic;text-align: left">Have a problem ex.Full Room , Money Transfer Problem </legend>
                                                                                                                            <button id="refundbutton" class="btn1 btn1-danger" style="width:60%;margin-left:20%;">Refund Needed</button>
                                                                                                                            <br><br>-->

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn1 btn1-default" data-dismiss="modal">Close</button>
                                                    <button id="linkbutton" type="button" class="btn1 btn1-default" >Check Booking Page</button>
                                                </div>
                                                <script>

                                                    $(function() {

                                                        $('#approvebutton').tooltip('hide');
                                                        $('#canceledbutton').tooltip('hide');
                                                        $('#refundbutton').tooltip('hide');

                                                        $("#linkbutton").on("click", function() {
                                                            window.location = "index.php?chose_page=checkDormBooking&memberID=<?php echo $_SESSION["memberID"]; ?>";
                                                        });

                                                        $("#approvebutton").on("click", function() {
                                                            if (confirm("Confirm to Change Status ?")) {
                                                                change_url = "callback.php?change_booking_status=Approve&change_booking_id=" + $(this).val();
                                                                $("#approvebutton").load(change_url);
                                                                event.preventDefault();
                                                                window.location = "index.php?chose_page=ownernotification";
                                                            } else {
                                                                event.preventDefault();
                                                            }
                                                        });
//                                                            $("#rejectbutton").on("click", function() {
//                                                                if (confirm("Confirm to Change Status ?")) {
//                                                                    change_url = "callback.php?change_booking_status=Reject&change_booking_id=" + $(this).val();
//                                                                    $("#rejectbutton").load(change_url);
//                                                                    event.preventDefault();
//                                                                    window.location = "index.php?chose_page=ownernotification";
//                                                                } else {
//                                                                    event.preventDefault();
//                                                                }
//                                                            });
                                                        $("#canceledbutton").on("click", function() {
                                                            if (confirm("Confirm to Change Status ?")) {
                                                                change_url = "callback.php?change_booking_status=Canceled&change_booking_id=" + $(this).val();
                                                                $("#canceledbutton").load(change_url);
                                                                event.preventDefault();
                                                                window.location = "index.php?chose_page=ownernotification";
                                                            } else {
                                                                event.preventDefault();
                                                            }
                                                        });
                                                        $("#refundbutton").on("click", function() {
                                                            if (confirm("Confirm to Change Status ?")) {
                                                                change_url = "callback.php?change_booking_status=Refund+Needed&change_booking_id=" + $(this).val();
                                                                $("#refundbutton").load(change_url);
                                                                event.preventDefault();
                                                                window.location = "index.php?chose_page=ownernotification";
                                                            } else {
                                                                event.preventDefault();
                                                            }
                                                        });



                                                        $("#search_status").on("change", function() {
                                                            url = "callback.php?ownernoti_curpage=1&ownernoti_orderby=&search_ownernoti=" + $(this).val();
                                                            if ($(this).val() === "default") {
                                                                url = "callback.php?ownernoti_curpage=1" + "&ownernoti_orderby=" + $("#noti_orderby").val();
                                                            }
                                                            $(".owner_pagi").load("callback.php?owner_noti_curpage=1");
                                                            $("#noti_result").animate({
                                                                opacity: 0
                                                            }, 100, function() {
                                                                $("#noti_result").load(url, function() {
                                                                    $("#noti_result").animate({
                                                                        opacity: 1
                                                                    }, 200);
                                                                });
                                                            });


                                                        })

                                                        $("#noti_orderby").on("change", function() {
                                                            url = "callback.php?ownernoti_curpage=1" + "&ownernoti_orderby=" + $(this).val();
                                                            document.getElementById("status_default").setAttribute("selected", "");
                                                            $(".owner_pagi").load("callback.php?owner_noti_curpage=1");
                                                            $("#noti_result").animate({
                                                                opacity: 0
                                                            }, 100, function() {
                                                                $("#noti_result").load(url, function() {
                                                                    $("#noti_result").animate({
                                                                        opacity: 1
                                                                    }, 200);
                                                                });
                                                            });
                                                        });

                                                        $(".owner_pagi li a").live("click", function() {
                                                            event.preventDefault();
                                                            url = "callback.php?ownernoti_curpage=" + $(this).attr("value") + "&ownernoti_orderby=" + $("#noti_orderby").val() + $("#search_status").val() === "default" ? "" : ("&search_ownernoti=" + $("#search_status").val());
                                                            cur_page = $(this).attr("href");
                                                            $(".owner_pagi").load(cur_page);
                                                            $("#noti_result").animate({
                                                                opacity: 0
                                                            }, 100, function() {
                                                                $("#noti_result").load(url, function() {
                                                                    $("#noti_result").animate({
                                                                        opacity: 1
                                                                    }, 200);
                                                                });
                                                            });
                                                        });
                                                    });

                                                </script>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </table>
                            <ul class="pagination pull-right owner_pagi">
                                <?php
                                $cur_page = 1;
                                $memberID = $_SESSION["memberID"];
                                $query = "select *,m.tel as dormTel from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and d.memberID = $memberID and (owner_noti = 1 or owner_noti = 2) ";
                                $href = "callback.php?owner_noti_curpage=";
                                displayPage($cur_page, $query, $href);
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!--<a href="membersystem.jsp" class="btn1 btn1-danger pull-left" style="width: 30%">Back</a>-->
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
