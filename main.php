
</div>
<div style="margin-top: 0%;">    
    <img src="../images/IMG_4009.jpg" style="width: 100%;height: 100%;">
    <div class="thumbnail" style="position: absolute; left: 20%; top:30%; width:60%; height:40%;padding:2% ">

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
                <option value="FemaleMale">Female & Male</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
            </select>
        </div>
        <div class="col-md-4">
            <p>Road</p>
            <select id="dorm_road" class="form-control">
                <option value="all">All Road</option>
                <option value="Prachauthit">Prachauthit</option>
                <option value="Budhabucha">Budhabucha</option>
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
            <p>&nbsp;</p>
            <input id="end_price" type="number" class="form-control" placeholder="End Price">
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
                $("#search_modal").load(url);
            })
        
        
        </script>
    </div>
</div>

