

<?php
?>

<div class="row booking_summary">
    <div class="span12">
        <fieldset>
            <script>

                $(document).on("click", "#check_dorm", function() {
                    event.preventDefault;
                    $("#check_dorm").load("callback.php?checkdorm_memberID=<?php echo $_SESSION["memberID"]; ?>");
                });



            </script>

            <?php

            function getRoom_Per_floor($dormID) {

                require 'connection.php';

                $room_query = "select * from floor f join roomperfloor rpf join rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID group by rpf.roomID";
                $room_result = mysqli_query($con, $room_query);
                $colspan = mysqli_num_rows($room_result) + 1;
                echo '<input type="hidden" name="dormID" value="' . $dormID . '">';
                echo '<thead>';
                echo '<tr>';
                echo '<th style="background-color:#f9f9f9" colspan="' . $colspan . '"><h4 style="text-align:center">Room Per Floor</h4></th>';
                echo '</tr>';
                echo '<tr id="new_thead_input">';
                echo '<th>Floor</th>';
                while ($room_row = mysqli_fetch_array($room_result)) {
                    echo '<th data-roomID="' . $room_row["roomID"] . '">' . $room_row["roomType"] . '</th>';
                }
                echo '</tr>';
                echo '</thead>';

                echo '<tbody id="new_tbody_input">';
                $query = "select * from floor where dormID = $dormID";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $floorID = $row["floorID"];
                    $floorNo = $row["floorNo"];
                    $rpf_query = "select * from RoomPerFloor where floorID = $floorID";
                    $rpf_result = mysqli_query($con, $rpf_query);

                    echo '<tr id="floor' . $floorNo . '">';
                    echo '<td style="text-align:center">' . $floorNo . '</td>';
                    while ($rpf_row = mysqli_fetch_array($rpf_result)) {
                        echo '<td><input type="number" class="form-control" name="floor' . $floorNo . '_roomtype[]" value="' . $rpf_row["roomPerFloor"] . '" data-matchingid="' . $rpf_row["matchingID"] . '"></td>';
                        echo '<input type="hidden" name="floor' . $floorNo . '_roomtype_matchingID[]" value="' . $rpf_row["matchingID"] . '">';
                    }
                    echo '</tr>';
                }
                echo '</tbody>';
            }

            function update_room_per_floor() {

                require 'connection.php';
                $dormID = $_POST["dormID"];
                $room_query = "select * from floor f join roomperfloor rpf join rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID group by rpf.roomID";
                $room_result = mysqli_query($con, $room_query);
                $number_of_room = mysqli_num_rows($room_result);
                $query = "select * from floor where dormID = $dormID";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    for ($i = 1; $i <= $number_of_room; $i++) {
                        $floorNo = $row["floorNo"];
                        $room_per_floor = $_POST["floor" . $floorNo . "_roomtype"][$i - 1];
                        $matchingID = $_POST["floor" . $floorNo . "_roomtype_matchingID"][$i - 1];
                        $query = "update roomperfloor set roomPerFloor = $room_per_floor where matchingID = $matchingID";
                        if (!mysqli_query($con, $query)) {
                            return false;
                        }
                    }
                }
                return true;
            }

            function show_room($dormID, $dormName) {

                require 'connection.php';

                $query = "select * from floor f join roomperfloor rpf join rooms r where f.floorID = rpf.floorID and rpf.roomID = r.roomID and f.dormID = $dormID group by rpf.roomID";

                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $color = "green";
                    if ($row["status"] === "Incomplete") {
                        $color = "red";
                    }
                    echo '<tr>';
                    echo '<td style="text-align: left;padding-left:15%">';
                    echo '<a href="index.php?chose_page=editroom&dormID=' . $dormID . '&dormName=' . $dormName . '&roomID=' . $row["roomID"] . '">' . $row["roomType"] . '</a><span class="pull-right" style="color:' . $color . '">' . $row["status"] . '</span>';
                    echo '</td>';
                    echo '</tr>';
                }
                if (mysqli_num_rows($result) === 0) {
                    echo '<tr>';
                    echo '</tr>';
                }
            }

            if (isset($_POST["update_rpf"])) {
                if (update_room_per_floor()) {
                    echo '<script>alert("Update Success")</script>';
                    echo '<script>window.location = "index.php?chose_page=ownersystem"</script>';
                } else {
                    echo '<script>alert("Update Failed")</script>';
                }
            }

            require 'connection.php';

            $query = 'select * from Dormitories where memberID = ' . $_SESSION["memberID"];
            $result = mysqli_query($con, $query);
            ?>
            <div class="col-md-12">
                <?php if (mysqli_num_rows($result) !== 0) { ?>
                    <legend style=" text-align: center"><span>Edit Your</span> Dormitory</legend>
                <?php } ?>
            </div>

            <div class="col-md-12" style="margin-top: 20px; margin-left: 0%;">
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <div class="col-md-12" style="border:solid 2px #cccccc;padding-top:3%;padding-bottom:3%;margin-bottom:5%;">
                        <div class='col-md-6'>
                            <table class='table table-striped table-hover' style="border: solid 1px #cccccc;width:100%;margin-left: auto;margin-right: auto" >
                                <tbody>
                                    <tr>
                                        <td><h4><?php echo $row["dormName"] ?><span class="pull-right" style="color:<?php echo $row["status"] === "Showing" ? "green" : "red" ?>"><?php echo $row["status"] ?></span></h4></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center"><button type="button" id="<?php echo $row["status"] === "Showing" ? "disabled_button_".$row["dormID"] : "active_button_".$row["dormID"]; ?>" class="btn1 btn1-<?php echo $row["status"] === "Showing" ? "danger" : "success" ?>"><?php echo $row["status"] === "Showing" ? "Hide On Page" : "Show On Page"; ?></button></td>
                                    </tr>
                                    <script>

                                        $(document).on("click", "#disabled_button_<?php echo $row["dormID"] ?>", function() {
                                            $("#disabled_button_<?php echo $row["dormID"] ?>").load("callback.php?disabled_dorm=" + "<?php echo $row["dormID"]; ?>");
                                            alert("Your Dormitory Information be Hidden on Dormitory Page");
                                            window.location = "index.php?chose_page=ownersystem";
                                        });
                                        $(document).on("click", "#active_button_<?php echo $row["dormID"] ?>", function() {
                                            $("#active_button_<?php echo $row["dormID"] ?>").load("callback.php?showing_dorm=" + "<?php echo $row["dormID"]; ?>");
                                            window.location = "index.php?chose_page=ownersystem";
                                        });


                                    </script>
                                    <tr>
                                        <td style="text-align: center"><a href="index.php?chose_page=editDormitory&dormID=<?php echo $row["dormID"]; ?>"><button class="btn1 btn1-primary" type="button">Edit Dormitory</button></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class='table table-striped table-hover' style="border: solid 1px #cccccc;width:100%;margin-left: auto;margin-right: auto" >
                                <tbody>
                                    <tr>
                                        <td><h4 style="text-align: center">Rooms</h4></td>
                                    </tr>

                                    <?php show_room($row["dormID"], $row["dormName"]); ?> 

                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <form action="" method="POST">
                                <table class="table table-bordered" id="new_input_table">

                                    <?php getRoom_Per_floor($row["dormID"]) ?>

                                </table>
                                <button class="btn1 btn1-default" type="submit" style="margin-left:45%" name="update_rpf"> Save Change</button>
                            </form>
                        </div>

                    </div>
                <?php } ?>
            </div>

        </fieldset>
    </div>
</div></div> <!-- /container -->
<br><br><br><br><br><br><br>
