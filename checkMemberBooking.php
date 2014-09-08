
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
                                <table class="table table-striped">
                                    <th>Booking ID</th>
                                    <th></th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Expire Date</th>
                                    <th>Status</th>
                                    <th></th>
                                    <?php
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

                                        $query = "select * from Booking where memberID = $memberID";
                                        $result = mysqli_query($con, $query);
                                        while ($book_row = mysqli_fetch_array($result)) {
                                            ?>
                                            <tr>
                                                <td><p style="margin-left:20px">0000<?php echo $book_row["bookingID"] ?></p></td>
                                                <td><p style="margin-left:20px">0000<?php echo $book_row["memberID"] ?></p></td>
                                                <td><?php echo $row["firstName"] ?></td>
                                                <td><?php echo $row["lastName"] ?></td>
                                                <td><?php echo $book_row["expire_date"] ?></td>
                                                <td>
                                                    <?php echo $book_row["booking_status"] ?>
                                                </td>
                                                <td><a href="index.php?chose_page=membookdetail&bookingID=<?php echo $book_row["bookingID"] ?>" type="button" style="width:100%" class="btn btn-success book-now">View Detail</a></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="8">Something Error</td>
                                        </tr>
                                    <?php } ?>
                                    
                                </table>
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

