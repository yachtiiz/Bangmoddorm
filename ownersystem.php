

<?php
?>

<div class="row booking_summary">
    <div class="span12">
        <form class="form-horizontal" >
            <fieldset>
                <script>

                    $(document).on("click", "#check_dorm", function() {
                        event.preventDefault;
                        $("#check_dorm").load("callback.php?checkdorm_memberID=<?php echo $_SESSION["memberID"]; ?>");
                    });



                </script>

                <?php

                function show_room($dormID, $dormName) {

                    require 'connection.php';

                    $query = "select * from Rooms where dormID = $dormID and status = 'Active'";

                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_array($result)) {
//                        echo '<tr>';
                        echo '<a href="index.php?chose_page=editroom&dormID=' . $dormID . '&dormName=' . $dormName . '&roomID=' . $row["roomID"] . '">' . $row["roomType"] . '</a>';
//                        echo '</tr>';
                        
                    }
                    if (mysqli_num_rows($result) === 0) {
                        echo '<tr>';
                        echo '</tr>';
                    }
                }

                require 'connection.php';

                $query = 'select * from Dormitories where memberID = ' . $_SESSION["memberID"];
                $result = mysqli_query($con, $query);
                ?>
                <div style="margin-top: 20px">
                    <?php if (mysqli_num_rows($result) !== 0) { ?>
                        <legend><span style="margin-left:37%">Edit Your</span> Dormitory</legend>
                    <?php } ?>

                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <div class='col-md-12'>
                            <table class='table table-striped table-hover' style="border: solid 1px #cccccc;width:100%;margin-left: auto;margin-right: auto" >
                                <tbody>
                                    <tr>
                                        <td><h4 style="text-align: center"><?php echo $row["dormName"] ?></h4></td>
                                    </tr>
                                    <tr>
                                        <!--                            <div class="span4" style="margin-left:15%">-->
                                        <td style="text-align: center"><a href="index.php?chose_page=editDormitory&dormID=<?php echo $row["dormID"]; ?>">Edit Dormitory</a></td>
                                        <!--                            </div>-->
                                        <!--                            <div class="span5">-->
                                    </tr>
                                    <tr>
                                        <td><h4 style="text-align: center">Rooms</h4></td>
                                    </tr>
                                       <td> <?php show_room($row["dormID"], $row["dormName"]); ?> </td>
                                    <tr>
                                        <td><a href="index.php?chose_page=editroom&dormID=<?php echo $row["dormID"]; ?>&dormName=<?php echo $row["dormName"] ?>"><button type="button" class="btn1 btn1-success" style="width:20%"> Add Room Type +</button></a></td>
                                        <!--                            </div>-->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </fieldset>
        </form>
    </div>
</div></div> <!-- /container -->
<br><br><br><br><br><br><br>
