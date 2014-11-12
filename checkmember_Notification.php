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
                            <select class="form-control" style="width: 30%" id="sort_by">
                                <option value="date+desc">Sort By Date</option>
                                <option value="booking_status">Sort By Status</option>
                            </select>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-hover" style="border:solid 1px #cccccc;margin-bottom: 0px">
                                <th>Booking ID</th>
                                <th>Booking Date</th>
                                <th>Expire Date</th>
                                <th></th>
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
                                        $query = "update Booking set member_noti = 2 where bookingID = $bookingID";
                                        if (mysqli_query($con, $query)) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }

                                    function getAllNotification() {
                                        require 'connection.php';
                                        $memberID = $_SESSION["memberID"];
                                        $query = "select * from Booking where memberID = $memberID and (member_noti = 1 or member_noti = 2 or booking_status = 'Waiting' or booking_status = 'Checking') order by date desc limit 0 , 8";
                                        $result = mysqli_query($con, $query);
                                        if (mysqli_num_rows($result) !== 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row["booking_status"] === "Waiting") {
                                                    echo '<tr style="background-color:#f9f9f9">';
                                                    echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                                                    echo '<td>' . $row["date"] . '</td>';
                                                    echo '<td>' . $row["expire_date"] . '</td>';
                                                    echo '<td>This booking is wating to confirm evidance</td>';
                                                    echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $row["bookingID"] . '" style="width:100%" class="btn1 btn1-success">Click to confirm</a></td>';
                                                    echo '</tr>';
                                                } else if ($row["booking_status"] === "Checking") {
                                                    echo '<tr style="background-color:#f9f9f9">';
                                                    echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                                                    echo '<td>' . $row["date"] . '</td>';
                                                    echo '<td>' . $row["expire_date"] . '</td>';
                                                    echo '<td>This booking is wating owner to check evidance</td>';
                                                    echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $row["bookingID"] . '" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>';
                                                    echo '</tr>';
                                                } else {
                                                    $unread = "";
                                                    if ($row["member_noti"] == "1") {
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
                                                        case "Already Refunded":
                                                            $color = "#00cc33";
                                                            break;
                                                    }
                                                    echo '<tr ' . $unread . '>';
                                                    echo '<td style="text-align: center">' . $row["bookingID"] . '</td>';
                                                    echo '<td>' . $row["date"] . '</td>';
                                                    echo '<td>' . $row["expire_date"] . '</td>';
                                                    echo '<td>This Booking change status to <span style="color:' . $color . '">' . $row["booking_status"] . '</span></td>';
                                                    echo '<td><a href="index.php?chose_page=membookdetail&bookingID=' . $row["bookingID"] . '" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>';
                                                    echo '</tr>';
                                                    if ($row["member_noti"] == "1") {
                                                        if (!readAble($row["bookingID"])) {
                                                            echo '<script>alert("something error")<script>';
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            echo '<tr>';
                                            echo '<td colspan="5" style="text-align:center">No Result</td>';
                                            echo '</tr>';

                                            for ($i = 1; $i < 8; $i++) {
                                                echo '<tr>';
                                                echo '<td colspan="5" style="height:47px"></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
                                            for ($i = mysqli_num_rows($result); $i < 8; $i++) {
                                                echo '<tr>';
                                                echo '<td colspan="5" style="height:47px"></td>';
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
                                        document.getElementById("submitbutton").setAttribute("value", $(this).data('bookid'));
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

                                    $(".member_pagi li a").live("click", function() {
                                        event.preventDefault();
                                        url = "callback.php?membernoti_curpage=" + $(this).attr("value") + "&membernoti_orderby=" + $("#sort_by").val();
                                        cur_page = $(this).attr("href");
                                        $(".member_pagi").load(cur_page);
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

                                    $("#sort_by").on("change", function() {
                                        url = "callback.php?membernoti_curpage=1" + "&membernoti_orderby=" + $(this).val();
                                        $(".member_pagi").load("callback.php?member_noti_curpage=1");
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
                                                            <h5 style="text-align: left;color: #33cc00">Total Price :<span id="totalprice" class="pull-right" style="color: #33cc00">6000 Baht</span></h5>
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
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </table>
                            <ul class="pagination pull-right member_pagi">
                                <?php
                                $cur_page = 1;
                                $memberID = $_SESSION["memberID"];
                                $query = "select * from Booking where memberID = $memberID and (member_noti = 1 or member_noti = 2 or booking_status = 'Waiting')";
                                $href = "callback.php?member_noti_curpage=";
                                displayPage($cur_page, $query, $href);
                                ?>
                            </ul>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
