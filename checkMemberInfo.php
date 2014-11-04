
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

function getAllMember($page, $order_by) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select * from Members order by $order_by limit $limit_start , 8";

    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            
            $color = "black";
            switch ($row["type"]) {
                case "Member":
                    $color = "#00cc33";
                    break;
                case "Owner":
                    $color = "#0480be";
                    break;
                case "Admin":
                    $color = "red";
                    break;
            }
            
            $bl_color = "black";
            if($row["status"] === "Blacklist"){
                $bl_color = "red";
            }
            
            echo '<tr>';
            echo '<td style="text-align: center">' . $row["memberID"] . '</td>';
            echo '<td>' . $row["username"] . '</td>';
            echo '<td>' . $row["firstName"] . '</td>';
            echo '<td>' . $row["lastName"] . '</td>';
            echo '<td style="color:'. $color . '">' . $row["type"] . '</td>';
            echo '<td style="color:'. $bl_color . '">' . $row["status"] . '</td>';
            echo '<td>' . $row["tel"] . '</td>';
            echo '<td><a href="index.php?chose_page=memberInfo&memberID='. $row["memberID"] .'"><button type="button" class="btn1 btn1-primary" style="width:100%">View Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="8" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}
?>

<script>

    $(function() {
        $(".check_mem li a").live("click", function() {
            event.preventDefault();
            url = $(this).attr("href");
            cur_page = "callback.php?show_member_curpage=" + $(this).attr("value") + "&sortby_member=" + $("#sort_by").val();
            $("#show_member_page").load(cur_page);
            $("#show_member").animate({
                opacity: 0
            }, 100, function() {
                $("#show_member").load(url, function() {
                    $("#show_member").animate({
                        opacity: 1
                    }, 200);
                });
            });
        });

        $("#searching_member").on("keyup", function() {
            url = "callback.php?search_members=" + $(this).val().replace(/ /g, "+");
            cur_page = "callback.php?show_member_curpage=1";
            $("#show_member_page").html("");
            $("#show_member").load(url);
            document.getElementById("memberID").setAttribute("selected", "");
            if ($(this).val() === "") {
                $("#show_member_page").load(cur_page);
            }
        });

        $("#sort_by").on("change", function() {
            url = "callback.php?sortby_member=" + $(this).val() + "&sortby_member_page=1";
            cur_page = "callback.php?show_member_curpage=1&sortby_member=" + $(this).val();
            $("#show_member").animate({
                opacity: 0
            }, 100, function() {
                $("#show_member").load(url, function() {
                    $("#show_member").animate({
                        opacity: 1
                    }, 200);
                });
            });
            $("#show_member_page").animate({
                opacity: 0
            }, 100, function() {
                $("#show_member_page").load(cur_page, function() {
                    $("#show_member_page").animate({
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
                                    <span>Member</span> Information
                                </legend>
                                Search Member : 
                                <input id="searching_member" type="text" style="width:40%" placeholder="" class="form-control">
                                <select id="sort_by" style="width:20%" class="form-control pull-right">
                                    <option id="memberID" value="memberID">Sort By Member ID</option>
                                    <option value="status">Sort By Status</option>
                                    <option value="type">Sort By Type</option>
                                </select>
                            </div>
                            <br><br><br><br><br><br>
                            <div class="span12">
                                <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
                                    <th>Member ID</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Telephone</th>
                                    <th></th>
                                    <tbody id="show_member">
                                        <?php getAllMember(1, "memberID") ?>
                                    </tbody>
                                </table>
                                <ul id="show_member_page" class="check_mem pagination pull-right" style="margin-top: 0px;height: 34px">
                                    <?php
                                    $href = "callback.php?show_member_page=";
                                    displayPage(1, "select * from members", $href);
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <a href="index.php?chose_page=adminsystem" class="btn1 btn1-danger" style="margin-left: 50%; width: 30%">Back</a>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
