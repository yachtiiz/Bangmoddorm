
<?php

function getRequest($page, $order_by) {

    require 'connection.php';

    $limit_start = ((10 * $page) - 10);
    $query = "select * from ConfirmationDorm order by $order_by limit $limit_start , 10";

    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row["confirmID"] . '</td>';
        echo '<td>' . $row["memberID"] . '</td>';
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
}
?>

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
                                        <option value="regis_date">Sort By Register Date</option>
                                        <option value="firstname">Sort By Name</option>
                                        <option value="cpn_name">Sort By Company Name</option>
                                        <option value="timestamp">Sort By Update Time</option>
                                    </select>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="span12">
                                <table class="table table-striped table-hover" style="margin-top: 40px;border-left: solid 1px #ddd;border-right: solid 1px #ddd;border-bottom: solid 1px #ddd;border-top: solid 1px #ddd;background-color: white">
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
                                <ul class="pagination">
                                    <li><a href="#">&laquo;</a>
                                        <a href="#">1</a>
                                        <a href="#">2</a>
                                        <a href="#">3</a>
                                        <a href="#">4</a>
                                        <a href="#">5</a>
                                        <a href="#">&raquo;</a></li>
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
