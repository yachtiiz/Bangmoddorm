         
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
        <div class="col-md-4">
            <h3><span>MyPlace 2</span></h3>
            <a href="book-start.html"><img style="width: 287px;height: 218px" src="css/images/Myplace2.jpg" alt="" /></a>
            <ul class="thumbnails hotel-options no_margin_left">
                <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Wireless.png" alt="" width="24" height="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
            </ul>
            <fieldset>



            </fieldset>
            <div class="row center">
                <a class="btn btn-primary btn-large check-availability" href="index.php?chose_page=dormdetail">View Details</a>
            </div>
        </div>	

        <div class="col-md-4">
            <h3><span>44 Garden Place</span></h3>
            <a href="book-start.html"><img style="width: 287px;height: 218px" src="css/images/44 garden place.jpg" alt="" /></a>
            <ul class="thumbnails hotel-options no_margin_left">
                <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Wireless.png" alt="" width="24" height="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
            </ul>
            <p> 44 Garden Place At Soi Phudhabucha44 male & female Dormitory luxury Dormitory </p>
            <div class="row center">
                <a class="btn btn-primary btn-large check-availability" href="index.php?chose_page=dormdetail">View Details</a>
            </div>
        </div>				
        <div class="col-md-4">
            <h3><span>Thonburi Sport Club</span></h3>
            <a href="book-start.html"><img style="width: 287px;height: 218px" src="css/images/ThonburiSportclub.jpg" alt="" /></a>
            <ul class="thumbnails hotel-options no_margin_left">
                <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Wireless.png" alt="" width="24" height="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Restaurant-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
            </ul>
            <p> Thonburi Sport Club Only Building3 is in the KMUTT Dormitories Related.
                <br>This place have Spot Club and Swimming Pool</p>
            <div class="row center">
                <a class="btn btn-primary btn-large check-availability" href="index.php?chose_page=dormdetail">View Details</a>
            </div>
        </div>		
        <div class="col-md-4">
            <h3><span>Kiatsuda Residence</span></h3>
            <a href="book-start.html" class="picbox"><img style="width: 287px;height: 218px" src="css/images/Kiatsuda residence2.jpg" alt="" /></a>
            <ul class="thumbnails hotel-options no_margin_left">
                <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Wireless.png" alt="" width="24" height="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Restaurant-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Indoor-Swimming.png" alt="" width="24" /></a></li>
            </ul>
            <p>Kiatsuda Residence At Phudhabucha44 is new Dormitory</p>
            <br>
            <div class="row center">
                <a class="btn btn-primary btn-large check-availability" href="index.php?chose_page=dormdetail">View Details</a>
            </div>
        </div>	

        <div class="col-md-4">
            <h3><span>Sam Peenong </span></h3>
            <a href="book-start.html"><img style="width: 287px;height: 218px" src="css/images/3brother2.jpg" alt="" /></a>
            <ul class="thumbnails hotel-options no_margin_left">
                <li class="no_margin_left"><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Wireless.png" alt="" width="24" height="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Restaurant-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Tv-black.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Shower.png" alt="" width="24" /></a></li>
                <li><a class="btn btn-large btn-info" href="book-start.html"><img src="css/images/icons/Indoor-Swimming.png" alt="" width="24" /></a></li>
            </ul>
            <p>Sam Peenong At Soi Prachauthit45 This Dormitory is the most Popular in KMUTT</p>
            <br>
            <div class="row center">
                <a class="btn btn-primary btn-large check-availability" href="index.php?chose_page=dormdetail">View Details</a>
            </div>

        </div>	

    </div>




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
</div>	</div> <!-- /container -->
