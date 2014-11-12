         
<?php
require 'connection.php';

$query = "select * from Dormitories where status = 'Showing'";

$dorm_result = mysqli_query($con, $query);
?>
        <br />
        <legend><h1 style="text-align: center; text-shadow: 3px 3px #cccccc"><span style="text-shadow: 3px 3px #eee">Dormitory</span> MAP</h1></legend>
        <div class="col-md-12" style="padding: 0">
            <iframe width="905" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;source=embed" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
        </div>
        <div class="col-md-12" style="padding: 0">
            <legend><h1 style="text-align: center; margin-top: 50px;">Dormitory</h1></legend>  
        </div>
        <?php
        while ($dorm_row = mysqli_fetch_array($dorm_result)) {

            $dormID = $dorm_row["dormID"];
            $room_query = "select min(price) as minprice , max(price) as maxprice from Dormitories d join Rooms r join Floor f join RoomPerFloor rpf where d.dormID = f.dormID and f.floorID = rpf.floorID and rpf.roomID = r.roomID and d.status = 'Showing' and r.status = 'Complete' and d.dormID = $dormID group by d.dormID";
            $room_result = mysqli_query($con, $room_query);
            $room_row = mysqli_fetch_array($room_result);
            ?>
            <div class="col-md-12 thumbnail" style=";border:solid 1px black;max-height: 100%;padding:2%;background-color: #eee">        
                <div class="col-md-6" style="text-align: center">
                    <img src="images/dormitory_picture/<?php echo $dorm_row["dorm_pictures"]; ?>" style="width:90%;height: 30%;">
                </div>
                <div class="col-md-6">
                    <legend><h3 style="margin-top:0%"><span><?php echo $dorm_row["dormName"] ?><span class="pull-right" style="color: gold">
                                    <?php
                                    for ($i = 1; $i <= $dorm_row["dormitory_rate"]; $i++) {
                                        echo '&#9733;';
                                    } for ($i = $dorm_row["dormitory_rate"]; $i < 5; $i++) {
                                        echo '&#9734;';
                                    }
                                    ?></span></span></h2></legend>
                    <p style="text-align:center">

                        DORMITORY TYPE : <?php echo $dorm_row["type"]; ?><br>
                        DISTANCE FROM UNIVERSITY : <?php echo $dorm_row["disFromUni"]; ?> Kilometers<br>
                        <?php if($room_row["minprice"] === $room_row["maxprice"]) { ?>PRICE RATE : <?php echo $room_row["maxprice"] ?> BAHT/MONTH<br> <?php } else { ?>PRICE RATE : <?php echo $room_row["minprice"] ?> - <?php echo $room_row["maxprice"] ?> BAHT/MONTH<br> <?php } ?>

                        <!--                       <h4 style="text-align:center">Dormitory Facilities</h4>
                                           <ul class="pagination" style="margin-left:30px;margin-top:0px">
                                                <li><a href="book-start.html" ><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                                                <li ><a  href=""><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
                                                <li ><a  href=""><img src="css/flat/png/wifi3.png" alt="" width="24" /></a></li>
                                                <li><a  href=""><img src="css/flat/png/restaurant7.png" alt="" width="24" /></a></li>
                                                
                                            </ul>-->

                        <a style="margin-top:20px;" class="btn1 btn1-primary" target="_blank" href="index.php?chose_page=dormdetail&dormID=<?php echo $dorm_row["dormID"]; ?>">View Details</a>
                    </p>
                </div>       
            </div>
        <?php } ?>
<div class="row">
    <div class="span12 what_people_say">
        <div id="quotes">
            <blockquote class="textItem" style="display: none;">
                <p>Easy to find</p>   
            </blockquote>			

            <blockquote class="textItem" style="display: none;">
                <p>Safe Dormitory</p>
            </blockquote>			

            <blockquote class="textItem" style="display: none;">
                <p>Beyond All Comfortable</p>
            </blockquote>
            <blockquote class="textItem" style="display: none;">
                <p>All in Bangmod Dorm</p>
            </blockquote>
        </div>
    </div>	
</div>

</div>
