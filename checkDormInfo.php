
<?php

function displayPage($cur_page) {

    require 'connection.php';
    $query = "select dormID from Dormitories";
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

require 'connection.php';

$query = "select dormID,dormName,firstName,lastName,d.type from dormitories d join members m where d.memberID = m.memberID limit 0,8";
$result = mysqli_query($con, $query);
?>
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal">
                    <fieldset>
                        <br /><br />
                        <br />
                        <div class="row">
                            <div class="span12">
                                <legend>
                                    <span>Dormitory</span> Information
                                </legend>
                                Search Dormitory : 
                                <input type="text" style="width:40%" placeholder="" class="form-control">
                                <select class="form-control pull-right" style="width:20%">
                                    <option>Sort By A-Z</option>
                                    <option>Dormitory Type</option>
                                    <option>Rate</option>
                                    <option>Owner</option>
                                </select>

                            </div>
                            <br><br><br><br><br><br>
                            <div class="span12">
                                <table class="table table-striped table-hover" style="border: solid 1px #cccccc">
                                    <th>#</th>
                                    <th>Dormitory ID</th>
                                    <th>Dormitory Name</th>
                                    <th>Owner Name</th>
                                    <th>Dormitory Type</th>
                                    <th></th>
                                    <?php
                                    $num = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $num; ?></td>
                                            <td><?php echo $row["dormID"]; ?></td>
                                            <td><?php echo $row["dormName"]; ?></td>
                                            <td><?php echo $row["firstName"] . " " . $row["lastName"]; ?></td>
                                            <td><?php echo $row["type"]; ?></td>
                                            <td><a href="index.php?chose_page=checkDormDetail"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                        </tr>
                                        <?php
                                        $num = $num + 1;
                                    }
                                    ?>
                                </table>
                                <ul class="pagination pull-right" style="margin-top: 0px">
                                    <?php displayPage(1) ?>
                                </ul>

                            </div>
                        </div>
                        <a href="adminsystem.jsp" class="btn btn-primary btn-large book-now pull-left">Back</a>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
<?php include 'footer.php' ?>
