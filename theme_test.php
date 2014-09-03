<html>
    <title></title>
    <body >
        <div class="container-fluid">
            <img src="https://scontent-b-sin.xx.fbcdn.net/hphotos-xpa1/v/t1.0-9/s720x720/1390778_10151955441937147_1211238680_n.jpg?oh=ac867faeb56af6e59004c1a94d57217d&oe=54780C4E" style="width: 1280px">

        </div>


        <div class="row">
            <table class="table table-striped" style="width:50%">
                <thead>
                <h3><span> Facilities</span> in room</h3>
                </thead>

                <?php echo $fac_room_row["air"] === "0" ? "" : "<tr><td><h5 style='text-align:left'> &nbsp;<span style='color:green' class='glyphicon glyphicon-ok'></span> Air Condition</h5></td></tr>" ?>
                <?php echo $fac_room_row["wardrobe"] === "0" ? "" : "" ?>
                <?php echo $fac_room_row["refrigerator"] === "0" ? "" : "<tr><td><h5 style='text-align:left'>&nbsp;<span style='color:green' class='glyphicon glyphicon-ok'></span> Refrigerator </h5></td></tr>" ?>
                <?php echo $fac_room_row["table_fac"] === "0" ? "" : "<tr><td><h5 style='text-align:left'>&nbsp;<span style='color:green' class='glyphicon glyphicon-ok'></span> Table</h5></td></tr>" ?>
                <?php echo $fac_room_row["chair"] === "0" ? "" : "<tr><td><h5 style='text-align:left'>&nbsp;<span style='color:green' class='glyphicon glyphicon-ok'></span> Chair</h5></td></tr>" ?>
                <?php echo $fac_room_row["fan"] === "0" ? "" : "<tr><td><h5 style='text-align:left'>&nbsp;<span style='color:green' class='glyphicon glyphicon-ok'></span> Fan</h5></td></tr>" ?>


                <?php echo $fac_room_row["waterHeater"] === "0" ? "" : "<tr><td><h4>Water Heater</h4></td></tr>" ?>
                <?php echo $fac_room_row["bed"] === "0" ? "" : "<tr><td><h4>Bed</h4></td></tr>" ?>


                <?php echo $fac_room_row["mattress"] === "0" ? "" : "<tr><td><h4>Mattress</h4></td></tr>" ?>
                <?php echo $fac_room_row["television"] === "0" ? "" : "<tr><td><h4>Television</h4></td></tr>" ?>



            </table>
        </div>
    </body>
</html>