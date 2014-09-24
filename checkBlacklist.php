

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

function getAllBlacklist($page, $order_by) {

    require 'connection.php';
    $limit_start = ((8 * $page) - 8);
    $query = "select * from members where status = 'Blacklist' order by $order_by limit $limit_start , 8";

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
            echo '<td style="color:'. $bl_color . '">' . $row["status"] . '</td>';
            echo '<td>' . $row["status_reason"] . '</td>';
            echo '<td><a href="index.php?chose_page=memberInfo&memberID='. $row["memberID"] .'"><button type="button" class="btn btn-success book-now">Detail</button></a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="7" style="text-align:center">No Result</td>';
        echo '</tr>';

        for ($i = 1; $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="7" style="height:47px"></td>';
            echo '</tr>';
        }
    }
    if (mysqli_num_rows($result) !== 0 && mysqli_num_rows($result) !== 8) {
        for ($i = mysqli_num_rows($result); $i < 8; $i++) {
            echo '<tr>';
            echo '<td colspan="7" style="height:47px"></td>';
            echo '</tr>';
        }
    }
}




?>

<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal" />
                <fieldset>
                    <br>
                    <div class="row">
                        <div class="span12">
                            <legend>
                                <span>Member Blacklist</span> Information System
                            </legend>
                            Search Member : 
                            <input type="text" placeholder="" class="form-control" style="width: 30%">
                            <select class="form-control pull-right" style="width:25%">
                                <option>Sort By Member ID</option>
                                <option>Sort By Alphabet</option>
                                <option>Sort By Status</option>
                            </select>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-striped table-hover" style="border:solid 1px #cccccc">
                                
                                <th>Member ID</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>status</th>
                                <th>Reason</th>
                                <th></th>
                                <tbody id="show_blacklist">
                                    <?php getAllBlacklist(1, "memberID") ?>
                                </tbody>

                            </table>
                            <ul class="pagination pull-right">
                                <?php
                                $cur_page = 1;
                                $query = "select * from members where status = 'Blacklist'";
                                $href = "callback.php?blacklist_curpage=";
                                displayPage($cur_page, $query, $href);
                                
                                
                                ?>
                            </ul>
                        </div>
                    </div>
                    <a href="adminsystem.php" class="btn btn-primary btn-large book-now pull-left">Back</a>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>

