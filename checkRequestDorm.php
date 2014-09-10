
<?php

function getRequest($page, $order_by) {

    require 'connection.php';

    $limit_start = ((8 * $page) - 8);
    $query = "select * from ConfirmationDorm order by $order_by limit $limit_start , 8";

    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td style="text-align:center">' . $row["confirmID"] . '</td>';
        echo '<td style="text-align:center">' . $row["memberID"] . '</td>';
        echo '<td>' . $row["dormName"] . '</td>';
        echo '<td>' . $row["license"] . '</td>';
        echo '<td>' . $row["date"] . '</td>';
        if ($row["approval"] == "Rejected") {
            echo '<td style="color: red" >' . $row["approval"] . '</td>';
        } else if ($row["approval"] == "Waiting") {
            echo '<td style="color: black">' . $row["approval"] . '</td>';
        } else {
            echo '<td style="color: green">' . $row["approval"] . '</td>';
        }
        echo '<td><a href="index.php?chose_page=checkRequestDetail&confirmID=' . $row["confirmID"] . '">View</a></td>';
        echo '</tr>';
    }
    if (mysqli_num_rows($result) !== 10) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
    if (mysqli_num_rows($result) === 0) {
        echo '<tr><td colspan="7"> No Result </td></tr>';
        for ($i = 1; $i < 8; $i++) {
            echo '<tr style="height: 39px"><td colspan="7"></td></tr>';
        }
    }
}

function displayPage($cur_page) {
    require 'connection.php';

    $query = "select confirmID from ConfirmationDorm";
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

    echo '<li><a value=' . $prev_page . ' href="callback.php?request_dormpage=' . $prev_page . '">&laquo;</a></li>';
    for ($i = 1; $i <= $total_page; $i++) {
        $class = ($cur_page == $i ? "class = 'active'" : "");
        echo '<li ' . $class . '><a value=' . $i . ' href="callback.php?request_dormpage=' . $i . '">' . $i . '</a></li>';
    }
    echo '<li><a value=' . $next_page . ' href="callback.php?request_dormpage=' . $next_page . '">&raquo;</a></li>';
}
?>


<script>

    $(function() {
        $("#order").live("change", function() {
            url = "callback.php?request_dormpage=1&request_orderby=" + $(this).val();
            cur_page = "callback.php?request_curpage=1";
            $("#requestlist").animate({
                opacity: 0
            }, 100, function() {
                $("#requestlist").load(url, function() {
                    $("#requestlist").animate({
                        opacity: 1
                    }, 200);
                });
            });
            $("#show_page_request").animate({
                opacity: 0
            }, 100, function() {
                $("#show_page_request").load(cur_page, function() {
                    $("#show_page_request").animate({
                        opacity: 1
                    }, 200);
                });
            });
        });
    });

    $(function() {
        $(".page_request li a").live("click", function() {
            event.preventDefault();
            url = $(this).attr("href") + "&request_orderby=" + $("#order").val();
            cur_page = "callback.php?request_curpage=" + $(this).attr("value");
            $("#show_page_request").load(cur_page);
            $("#requestlist").animate({
                opacity: 0
            }, 100, function() {
                $("#requestlist").load(url, function() {
                    $("#requestlist").animate({
                        opacity: 1
                    }, 200);
                });
            });
        });
    });

    $(function() {
        $("#searching").live("keyup", function() {
            event.preventDefault();
            $("#show_page_request").html("");
            url = "callback.php?request_searching=" + $(this).val().replace(/ /g, "+");
            if ($("#only_confirm").attr("checked")) {
                special_url = url + "&search_only=confirmID";
                $("#requestlist").load(special_url);
            } else
            if ($("#only_dormname").attr("checked")) {
                special_url = url + "&search_only=dormName";
                $("#requestlist").load(special_url);
            } else
            if ($("#only_license").attr("checked")) {
                special_url = url + "&search_only=license";
                $("#requestlist").load(special_url);
            } else {
                $("#requestlist").load(url);
            }
            if($("#searching").val() === ""){
                $("#show_page_request").load("callback.php?request_curpage=1");
            }
        });
        $("#only_confirm").click(function(){
            url = "callback.php?request_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=confirmID";
            $("#requestlist").load(url);
        });
        $("#only_dormname").click(function(){
            url = "callback.php?request_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=dormName";
            $("#requestlist").load(url);
        });
        $("#only_license").click(function(){
            url = "callback.php?request_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=license";
            $("#requestlist").load(url);
        });
        $("#all_type").click(function(){
            url = "callback.php?request_searching=" + $("#searching").val().replace(/ /g, "+");
            $("#requestlist").load(url);
        });
    });


</script>
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal">
                    <fieldset>
                        <br />
                        <div class="row">
                            <div class="span12">
                                <legend>
                                    <span>Dormitory</span> Request
                                </legend>
                                <div class="col-md-7" style="padding: 0;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Searching</span>
                                        <input id="searching" type="text"  class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="col-md-3 pull-right" style="padding: 0;margin-right: 20px;">
                                    <select id="order" class="form-control">
                                        <option value="date%20desc">Sort By Send Date</option>
                                        <option value="approval">Sort By Status</option>
                                    </select>
                                </div>

                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="only_confirm" name="search_only" type="radio"> Only Confirm ID
                                    </label>
                                </div>
                                <div class="col-md-3 radio">
                                    <label>
                                        <input id="only_dormname" name="search_only" type="radio"> Only Dormitory Name
                                    </label>
                                </div>
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="only_license" name="search_only" type="radio"> Only License ID
                                    </label>
                                </div>
                                <div class="col-md-2 radio">
                                    <label>
                                        <input id="all_type" name="search_only" type="radio" checked> All Type
                                    </label>
                                </div>
                            </div>



                            <div class="span12">
                                <table class="table table-striped table-hover" style="margin-top: 30px;border-left: solid 1px #ddd;border-right: solid 1px #ddd;border-bottom: solid 1px #ddd;border-top: solid 1px #ddd;background-color: white">
                                    <thead>
                                    <th>Confirm ID</th>
                                    <th>Member ID</th>
                                    <th>Dormitory Name</th>
                                    <th>License ID</th>
                                    <th>Send Date</th>
                                    <th>Approval</th>
                                    <th></th>
                                    </thead>
                                    <tbody id="requestlist" style="font-size: 16px">
                                        <?php
                                        if (!isset($_GET["request_page"])) {
                                            $order = "date desc";
                                            $page = 1;
                                            getRequest($page, $order);
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="span12">
                                <ul id='show_page_request' class="page_request pagination pull-right" style="margin-top: 0px">
                                    <?php
                                    if (!isset($_GET["request_page"])) {
                                        $cur_page = 1;
                                        displayPage($cur_page);
                                    }
                                    ?>
                                </ul>
                            </div>
                            <a href="adminsystem.jsp" style="margin-top:0px;margin-left:350px" class="btn btn-primary btn-large book-now">Back</a>


                        </div>

                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
