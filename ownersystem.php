

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
                        echo '<tr>';
                        echo '<td style="text-align: center">';
                        echo '<a href="index.php?chose_page=editroom&dormID=' . $dormID . '&dormName=' . $dormName . '&roomID=' . $row["roomID"] . '">' . $row["roomType"] . '</a>';
                        echo '</td>';
                        echo '</tr>';
                        
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
                <div class="col-md-12">
                    <?php if (mysqli_num_rows($result) !== 0) { ?>
                    <legend style=" text-align: center"><span>Edit Your</span> Dormitory</legend>
                    <?php } ?>
                </div>
                
                <div class="col-md-6" style="margin-top: 20px; margin-left: 25%">
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <div class='col-md-12'>
                            <table class='table table-striped table-hover' style="border: solid 1px #cccccc;width:100%;margin-left: auto;margin-right: auto" >
                                <tbody>
                                    <tr>
                                        <td><h4 style="text-align: center"><?php echo $row["dormName"] ?></h4></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center"><a href="index.php?chose_page=editDormitory&dormID=<?php echo $row["dormID"]; ?>"><button class="btn1 btn1-primary" type="button">Edit Dormitory</button></a></td>
                                    </tr>
                                    <tr>
                                        <td><h4 style="text-align: center">Rooms</h4></td>
                                    </tr>
                                         
                                     <?php show_room($row["dormID"], $row["dormName"]); ?> 
                                    
                                    <tr>
                                        <td style=" text-align: center"><a href="index.php?chose_page=editroom&dormID=<?php echo $row["dormID"]; ?>&dormName=<?php echo $row["dormName"] ?>"><button type="button" class="btn1 btn1-success" style="width:40%"> Add Room Type +</button></a></td>
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
