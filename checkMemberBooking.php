<div class="span12">	
    <div class="row">
        <script>

            $(function() {
                $(".mem_book li a").live("click", function() {
                    event.preventDefault();
                    url = $(this).attr("href");
                    cur_page = "callback.php?membook_curpage=" + $(this).attr("value");
                    $("#show_mem_book").load(cur_page);
                    $("#show_mem_result").animate({
                        opacity: 0
                    }, 100, function() {
                        $("#show_mem_result").load(url, function() {
                            $("#show_mem_result").animate({
                                opacity: 1
                            }, 200);
                        });
                    });
                });

                $(".sort_mem_book li a").live("click", function() {
                    event.preventDefault();
                    url = $(this).attr("href");
                    cur_page = "callback.php?sortby_memberbooking_curpage=" + $(this).attr("value") + "&sortby_membook=" + $("#sort_by").val();
                    $("#sort_mem_book").load(cur_page);
                    $("#show_mem_result").animate({
                        opacity: 0
                    }, 100, function() {
                        $("#show_mem_result").load(url, function() {
                            $("#show_mem_result").animate({
                                opacity: 1
                            }, 200);
                        });
                    });
                });

                $("#searching").on("keyup", function() {

                    url = "callback.php?search_member_value=" + $(this).val().replace(/ /g, "+");
                    cur_page = "callback.php?membook_curpage=1";
                    $("#show_mem_book").html("");
                    $("#sort_mem_book").html("");
                    $("#show_mem_result").load(url);
                    document.getElementById("sortby_date").setAttribute("selected", "");

                    if ($(this).val() === "") {
                        $("#show_mem_book").load(cur_page);
                    }
                });

                $("#sort_by").on("change", function() {

                    url = "callback.php?sortby_memberbooking=" + $(this).val() + "&sortby_memberbooking_page=1";
                    cur_page = "callback.php?sortby_memberbooking_curpage=1&sortby_membook=" + $(this).val();
                    $("#show_mem_book").html("");
                    $("#show_mem_result").animate({
                        opacity: 0
                    }, 100, function() {
                        $("#show_mem_result").load(url, function() {
                            $("#show_mem_result").animate({
                                opacity: 1
                            }, 200);
                        });
                    });
                    $("#sort_mem_book").animate({
                        opacity: 0
                    }, 100, function() {
                        $("#sort_mem_book").load(cur_page, function() {
                            $("#sort_mem_book").animate({
                                opacity: 1
                            }, 200);
                        });
                    });

                });
            });

        </script>
        <div class="span9">
            <form class="form-horizontal">
                <fieldset>
                    <br />
                    <div class="row">
                        <div class="span12">
                            <legend>
                                <span>Booking</span> System
                            </legend>
                            Search Booking ID : 
                            <input id="searching" type="text" style="width: 40%" placeholder="" class="form-control">
                            <select id="sort_by" class="form-control pull-right" style="width:25%">
                                <option id="sortby_date" value="date">Sort By Expire Date</option>
                                <option value="booking_status">Sort By Status</option>
                                <option value="bookingID">Sort By Booking ID</option>
                            </select>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-striped" style="border: solid 1px #cccccc">
                                <th>Booking ID</th>
                                <th>Dormitory Name</th>
                                <th>Room Type</th>
                                <th>Expire Date</th>
                                <th>Status</th>
                                <th> </th>
                                <tbody id='show_mem_result'>
                                    <?php

                                    function displayPage($memberID, $cur_page) {

                                        require 'connection.php';
                                        $query = "select bookingID from Booking where memberID = $memberID";
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

                                        echo '<li><a value=' . $prev_page . ' href="callback.php?membook_showpage=' . $prev_page . '">&laquo;</a></li>';
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            $class = ($cur_page == $i ? "class = 'active'" : "");
                                            echo '<li ' . $class . '><a value=' . $i . ' href="callback.php?membook_showpage=' . $i . '">' . $i . '</a></li>';
                                        }
                                        echo '<li><a value=' . $next_page . ' href="callback.php?membook_showpage=' . $next_page . '">&raquo;</a></li>';
                                    }

                                    function getMember() {
                                        require 'connection.php';
                                        $memberID = $_SESSION["memberID"];
                                        $query = "select * from Members where memberID = $memberID";
                                        $result = mysqli_query($con, $query);
                                        $row = mysqli_fetch_array($result);
                                        if (mysqli_num_rows($result) !== 0) {
                                            return $row;
                                        } else {
                                            return NULL;
                                        }
                                    }

                                    $row = getMember();
                                    if ($row !== NULL) {
                                        require 'connection.php';

                                        $memberID = $_SESSION["memberID"];

                                        $query = "select * from Booking b join Rooms r join Members m join Dormitories d join Floor f join RoomPerFloor rpf where b.memberID = m.memberID and  d.dormID = f.dormID and f.floorID = rpf.floorID and b.matchingID = rpf.matchingID and rpf.roomID = b.roomID and b.roomID = r.roomID and b.memberID = $memberID order by date desc limit 0 , 8 ";
                                        $result = mysqli_query($con, $query);
                                        while ($book_row = mysqli_fetch_array($result)) {

                                            $color = "black";

                                            switch ($book_row["booking_status"]) {
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
                                            ?>
                                            <tr>
                                                <td><p style="margin-left:20px"><?php echo $book_row["bookingID"] ?></p></td>
                                                <td><p style="margin-left:20px"><?php echo $book_row["dormName"] ?></p></td>
                                                <td><?php echo $book_row["roomType"] ?></td>
                                                <td><?php echo $book_row["expire_date"] ?></td>
                                                <td style="color:<?php echo $color; ?>" ><?php echo $book_row["booking_status"] ?></td>
                                                <td><a href="index.php?chose_page=membookdetail&bookingID=<?php echo $book_row["bookingID"] ?>" type="button" style="width:100%" class="btn1 btn1-primary">View Detail</a></td>
        <!--                                                    <td><a href="index.php?chose_page=membookdetail&bookingID=<?php echo $book_row["bookingID"] ?>" type="button" style="width:100%" class="btn btn-success book-now">View Detail</a></td>-->
                                            </tr>
                                            <?php
                                        }
                                        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
                                            echo '<tr>';
                                            echo '<td colspan="6" style="height:49px"></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6">Something Error</td>
                                        </tr>
                                    </tbody>
                                    <?php
                                    for ($i = 1; $i < 8; $i++) {
                                        echo '<tr>';
                                        echo '<td colspan="6" style="height:49px"></td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>

                            </table>
                            <ul id="show_mem_book" class="mem_book pagination pull-right" style="margin-top: 0px;height: 34px">
                                <?php displayPage($_SESSION["memberID"], 1) ?>
                            </ul>
                            <ul id="sort_mem_book" class="sort_mem_book pagination pull-right" style="margin-top: 0px;height: 34px">

                            </ul>
                        </div>
                    </div>
                    <!--<a href="index.php?chose_page=membersystem" class="btn1 btn1-danger" style="width: 30%">Back</a>-->
                </fieldset>
            </form>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>

