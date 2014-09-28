
</div>
<div style="margin-top: -20px;">    
    <img src="../images/IMG_4009.jpg" style="width: 100%; height: 630px">
    <div class="thumbnail" style="position: absolute; left: 280px; top:250px; width:700px; height:270px;padding:20px ">

        <div class="col-md-5">
            <p>Distance From University</p>
            <select id="dorm_dis" class="form-control">
                <option value="all">All Distance</option>
                <option value="<1">Less than 1 Kilometer</option>
                <option value="<2">Less than 2 Kilometer</option>
                <option value="<3">Less than 3 Kilometer</option>
                <option value="<4">Less than 4 Kilometer</option>
                <option value="<5">Less than 5 Kilometer</option>
                <option value=">=5">More than 5 Kilometer</option>
            </select>
        </div>
        <div class="col-md-3">
            <p>Type</p>
            <select id="type_dorm" class="form-control" style="width:100%;">
                <option value="all">All Type</option>
                <option value="Male & Female">Male & Female</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
            </select>
        </div>
        <div class="col-md-4">
            <p>Road</p>
            <select id="dorm_road" class="form-control">
                <option value="all">All Road</option>
                <option value="Prachauthit">Prachauthit</option>
                <option value="Phuthabucha">Phuthabucha</option>
            </select>
        </div>
        <div class="col-md-5" style="margin-top:2%">
            <p>Dormitory Rate</p>
            <select id="rate_dorm" class="form-control" style="color:black">
                <option value="all">All Rate</option>
                <option value="1">&#9733;&#9734;&#9734;&#9734;&#9734;</option>
                <option value="2">&#9733;&#9733;&#9734;&#9734;&#9734;</option>
                <option value="3">&#9733;&#9733;&#9733;&#9734;&#9734;</option>
                <option value="4">&#9733;&#9733;&#9733;&#9733;&#9734;</option>
                <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
            </select>
        </div>
        <div class="col-md-3" style="margin-top:2%">
            <p>Price Rate</p>
            <input id="start_price" type="number" class="form-control" placeholder="Start Price">
        </div>
        <div class="col-md-3" style="margin-top:2%;margin-bottom: 5%">
            <input id="end_price" type="number" class="form-control" placeholder="End Price" style="margin-top:22%">
        </div>
        <button id="search_button" data-target="#dormModal" data-toggle="modal" class="btn1 btn1-default btn1-lg" style="margin-left:0%;width:100%"> SEARCH DORMITORIES</button>

        <div class="modal fade" id="dormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Search Dormitories</h4>
                    </div>
                    <div class="modal-body" id="search_modal">
                        <h2 style="text-align:center"> No Result </h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        
            $("#search_button").on("click",function(){
                
                disFromUni = $("#dorm_dis").val();
                type = $("#type_dorm").val();
                road = $("#dorm_road").val();
                rate_dorm = $("#rate_dorm").val();
                start_price = $("#start_price").val();
                end_price = $("#end_price").val();
                
                url = "callback.php?search_dorm=true&disFromUni=" + disFromUni + "&search_dorm_type=" + type + "&search_dorm_road=" + road + "&search_dorm_rate=" + rate_dorm + "&search_dorm_stprice=" + start_price + "&search_dorm_enprice=" + end_price ;
                alert(url);
                $("#search_modal").load(url);
                
            })
        
        
        </script>
    </div>
</div>    
<!--<div class="row-fluid slideshow-row">
<iframe width="900" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;output=embed"></iframe><br /><small>View <a href="https://www.google.co.th/maps/ms?msa=0&amp;msid=202827098492161551372.0004f9988870873ff3abe&amp;hl=en&amp;ie=UTF8&amp;ll=13.651582,100.494049&amp;spn=0.009673,0.01368&amp;t=m&amp;source=embed" style="color:#0000FF;text-align:left">Map Project</a> in a larger map</small>
<br><br>            
<div class="slideshow" style="margin:0px;width: 900px;" >
                <div class="slider-wrapper theme-default">
                    <div id="nivoslider-125" class="nivoSlider">
                        <img src="css/images/slideshow5.jpg" alt="" />
                        <img src="css/images/slideshow1.jpg" alt="" />
                        <img src="css/images/slideshow2.jpg" alt="" />
                        <img src="css/images/slideshow3.jpg" alt="" />
                        <img src="css/images/slideshow4.jpg" alt="" />
                    </div>
                </div>
                <div id="nivoslider-125-caption-0" class="nivo-html-caption">You can add captions too&#8230;</div>
            </div>

        </div>
        <div class="row-fluid">

            <div class="span3">
                <h3><span>Suggest</span>Dormitory</h3>
                <a href="dormdetail.jsp"><img src="css/images/Myplace1.jpg" alt="" /></a>
                <a href="dormdetail.jsp"><h3>My Place</h3></a>
                Rating<h3 style="color:gold"> &#9733;&#9733;&#9733;&#9733;&#9734;</h3>
            </div>		
            <div class="span3">
                <br><br><br>
                <a href="facilities.html"><img src="css/images/ThonburiSportclub.jpg" alt="" /></a>
                <a href="dormdetail.jsp"><h3>Thonburi Sport Club</h3></a>
                Rating<h3 style="color:gold"> &#9733;&#9733;&#9733;&#9733;&#9734;</h3>                </div>		
            <div class="span3">
                <br><br><br>
                <a href="promotions.html"><img src="css/images/Kiatsuda residence2.jpg" alt="" /></a>
                <a href="dormdetail.jsp"><h3>Kiatsuda Residence</h3></a>
                Rating<h3 style="color:gold"> &#9733;&#9733;&#9733;&#9734;&#9734;</h3>                </div>		
            <div class="span3">
                <br><br><br>
                <a href="map.html"><img src="css/images/3brother2.jpg" alt="" /></a>
                <a href="dormdetail.jsp"><h3>3Brothers</h3></a>
                Rating<h3 style="color:gold"> &#9733;&#9733;&#9733;&#9734;&#9734;</h3>                </div>		
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
        </div>-->

<!-- /container -->

