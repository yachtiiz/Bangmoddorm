         
<?php
require 'connection.php';

$query = "select * from Dormitories where status = 'Active'";

$dorm_result = mysqli_query($con, $query);
?>
<div class="row">

    <div class="col-md-12">	
        <br />
        <legend><h1 style="margin-left: 40%;font-style: italic">Dormitory</h1></legend>
        <div class="col-md-12">
            <iframe width="900" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;source=embed" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
        </div>
        <?php while ($dorm_row = mysqli_fetch_array($dorm_result)) { ?>
            <div class="col-md-4" style="margin-top: 40px">
                <legend><span><?php echo $dorm_row["dormName"] ?></span></legend>
                <a href="book-start.html"><img style="width: 405px;height: 250px" src="images/dormitory_picture/<?php echo $dorm_row["dorm_pictures"]; ?>" alt="" /></a>
                <ul class="thumbnails hotel-options no_margin_left">
                    <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                    <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
                </ul>
                <br>
                <p>

                    DORMITORY TYPE : <?php echo $dorm_row["type"]; ?><br>
                    DISTANCE FROM UNIVERSITY : <?php echo $dorm_row["disFromUni"]; ?><br>
                    PRICE RATE : 2000 - 5000 BATH/MONTH<br>
                </p>
                <br>
                <a style="margin-left:70px;width: 50%" class="btn book-now2" href="index.php?chose_page=dormdetail&dormID=<?php echo $dorm_row["dormID"]; ?>">View Details</a>

            </div>		
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="span12 what_people_say">
        <div id="quotes">
            <blockquote class="textItem" style="display: none;">
                <p>Easy to find</p>
                <small>Someone famous <cite title="Source Title">Source Title</cite></small>
            </blockquote>			

            <blockquote class="textItem" style="display: none;">
                <p>Safe Dormitory</p>
                <small>Someone famous <cite title="Source Title">Source Title</cite></small>
            </blockquote>			

            <blockquote class="textItem" style="display: none;">
                <p>Beyond All Comfortable</p>
                <small>Someone famous <cite title="Source Title">Source Title</cite></small>
            </blockquote>
            <blockquote class="textItem" style="display: none;">
                <p>All in Bangmod Dorm</p>
                <small>Someone famous <cite title="Source Title">Source Title</cite></small>
            </blockquote>
        </div>
    </div>	
</div>

</div>