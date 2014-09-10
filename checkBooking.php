

<script>

    $(function() {
        $("#select_dorm").live("change", function(event) {
            event.preventDefault();
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
        });
    });


    $(function() {
        $("#searching").live("keyup", function() {
            event.preventDefault();
            $("#show_book_page").html("");
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $(this).val().replace(/ /g, "+");
            if ($("#only_bookid").attr("checked")) {
                special_url = url + "&search_only=bookingID";
                $("#show_result").load(special_url);
            } else
            if ($("#only_date").attr("checked")) {
                special_url = url + "&search_only=date";
                alert(special_url);
                $("#show_result").load(special_url);
            } else
            if ($("#only_status").attr("checked")) {
                special_url = url + "&search_only=status";
                $("#show_result").load(special_url);
            } else {
                $("#show_result").load(url);
            }
            if ($("#searching").val() === "") {
                $("#show_book_page").load("callback.php?dormbook_page=1&showpage_dormID="+ $("#select_dorm").val());
            }
        });
        $("#only_bookid").click(function() {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=bookingID";
            $("#show_result").load(url);
        });
        $("#only_date").click(function() {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=date";
            $("#show_result").load(url);
        });
        $("#only_status").click(function() {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=booking_status";
            $("#show_result").load(url);
        });
        $("#all_type").click(function() {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+");
            $("#show_result").load(url);
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

                                    $query = "select * from dormitories where memberID = $memberID ";
                                    $result = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value="<?php echo $row["dormID"]; ?>"><?php echo $row["dormName"]; ?> </option>
                                    <?php } ?>
                                </select>
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
                                <div class="col-md-3 radio">
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
                                <table class="table table-striped" style="border: solid 1px #cccccc">
                                    <th>Booking ID</th>
                                    <th>Room Type</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th style="width: 150px">Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <tbody id="show_result">
                                        <tr>
                                            <td colspan="8" style="text-align: center"> No Result</td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr style="height: 51px">
                                            <td colspan="8"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="span12">
                                <ul id="show_book_page" class="page_book pagination pull-right" style="margin-top: 0px">

                                </ul>
                            </div>
                            <a href="ownersystem.jsp" class="btn btn-primary btn-large book-now" style="margin-left: 400px;margin-top: 30px">Back</a>
                        </div>
                        <br />
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>       