
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

require 'connection.php';

$query = "select dormID,dormName,firstName,lastName,d.type,d.status from dormitories d join members m where d.memberID = m.memberID limit 0,8";
$result = mysqli_query($con, $query);
?>
<script>


    $(function() {
        $(".check_dorm li a").live("click", function() {
            event.preventDefault();
            url = $(this).attr("href");
            cur_page = "callback.php?checkdorm_showpage=" + $(this).attr("value") + "&sortby_dorm=" + $("#sort_by").val();
            $("#check_dorm_page").load(cur_page);
            $("#show_dorm_info").animate({
                opacity: 0
            }, 100, function() {
                $("#show_dorm_info").load(url, function() {
                    $("#show_dorm_info").animate({
                        opacity: 1
                    }, 200);
                });
            });
        });

        $("#searching_dorm").on("keyup", function() {
            url = "callback.php?search_dormitories=" + $(this).val().replace(/ /g, "+");
            cur_page = "callback.php?checkdorm_showpage=1";
            $("#check_dorm_page").html("");
            $("#show_dorm_info").load(url);
            document.getElementById("sort_dormID").setAttribute("selected", "");
            if ($(this).val() === "") {
                $("#check_dorm_page").load(cur_page);
            }
        });

        $("#sort_by").on("change", function() {
            url = "callback.php?sortby_dormitories=" + $(this).val() + "&sortby_dormitories_page=1";
            cur_page = "callback.php?checkdorm_showpage=1&sortby_dorm=" + $(this).val();
            $("#show_dorm_info").animate({
                opacity: 0
            }, 100, function() {
                $("#show_dorm_info").load(url, function() {
                    $("#show_dorm_info").animate({
                        opacity: 1
                    }, 200);
                });
            });
            $("#check_dorm_page").animate({
                opacity: 0
            }, 100, function() {
                $("#check_dorm_page").load(cur_page, function() {
                    $("#check_dorm_page").animate({
                        opacity: 1
                    }, 200);
                });
            });

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
                                    <span>Dormitory</span> Information
                                </legend>
                                Search Dormitory : 
                                <input id="searching_dorm" type="text" style="width: 40%" placeholder="" class="form-control">
                                <select id="sort_by" class="form-control pull-right" style="width:20%">
                                    <option id="sort_dormID" value="dormID">Sort By Dormitory ID</option>
                                    <option value="type">Sort By Dormitory Type</option>
                                    <option value="status">Sort By Dormitory Status</option>
                                </select>

                            </div>
                            <br><br><br><br><br><br>
                            <div class="span12">
                                <table class="table table-striped table-hover" style="border: solid 1px #cccccc">
                                    <th style="width:120px">Dormitory ID</th>
                                    <th style="width:170px">Dormitory Name</th>
                                    <th style="width:250px">Owner Name</th>
                                    <th style="width:170px">Dormitory Type</th>
                                    <th >Status</th>
                                    <th></th>
                                    <tbody id="show_dorm_info">
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {

                                            $color = "red";
                                            if ($row["status"] === "Active") {
                                                $color = "#00cc33";
                                            }
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?php echo $row["dormID"]; ?></td>
                                                <td><?php echo $row["dormName"]; ?></td>
                                                <td><?php echo $row["firstName"] . " " . $row["lastName"]; ?></td>
                                                <td><?php echo $row["type"]; ?></td>
                                                <td style="color:<?php echo $color ?>"><?php echo $row["status"]; ?></td>
                                                <td><a href="index.php?chose_page=checkDormDetail&dormID=<?php echo $row["dormID"] ?>"><button type="button" class="btn1 btn1-primary pull-right " style="width:100%">View Detail</button></a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <ul id="check_dorm_page" class="check_dorm pagination pull-right" style="margin-top: 0px;height: 34px">
                                    <?php
                                    $href = "callback.php?checkdorm_currentpage=";
                                    displayPage(1, "select * from Dormitories", $href);
                                    ?>
                                </ul>

                            </div>
                        </div>
                        <a href="index.php?chose_page=adminsystem" class="btn1 btn1-danger" style="margin-left:50%;width: 30%">Back</a>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
<?php include 'footer.php' ?>
