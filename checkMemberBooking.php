
<div class="row booking_summary">
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
                                Search Booking : 
                                <input type="text" style="width: 40%" placeholder="" class="form-control">
                                <select class="form-control pull-right" style="width:25%">
                                    <option>Sort By Date</option>
                                    <option>Sort By Status</option>
                                    <option>Sort By Member</option>
                                    <option>Sort By Status Waiting Only</option>
                                    <option>Sort By Status Approve Only</option>
                                    <option>Sort By Status Over Time Only</option>
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
                                    <th></th>
                                    <tbody id='show_mem_result'>
                                        <?php

                                        function displayPage($memberID, $cur_page) {

                                            require 'connection.php';
                                            $query = "select bookingID from Booking where $memberID";
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
                                            $query = "select * from members where memberID = $memberID";
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

                                            $query = "select * from Booking b join Dormitories d join Rooms r where b.roomID = r.roomID and r.dormID = d.dormID and b.memberID = $memberID order by date desc limit 0 , 8";
                                            $result = mysqli_query($con, $query);
                                            while ($book_row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <td><p style="margin-left:20px"><?php echo $book_row["bookingID"] ?></p></td>
                                                    <td><p style="margin-left:20px"><?php echo $book_row["dormName"] ?></p></td>
                                                    <td><?php echo $book_row["roomType"] ?></td>
                                                    <td><?php echo $book_row["expire_date"] ?></td>
                                                    <td><?php echo $book_row["booking_status"] ?></td>
                                                    <td><a href="index.php?chose_page=membookdetail&bookingID=<?php echo $book_row["bookingID"] ?>" type="button" style="width:100%" class="btn btn-success book-now">View Detail</a></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="8">Something Error</td>
                                            </tr>
                                        </tbody>
                                    <?php } ?>

                                </table>
                                <ul id="show_mem_book" class="mem_book pagination pull-right" style="margin-top: 0px">
                                    <?php displayPage($_SESSION["memberID"], 1) ?>
                                </ul>
                            </div>
                        </div>
                        <a href="membersystem.jsp" class="btn btn-primary btn-large book-now pull-left">Back</a>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>

