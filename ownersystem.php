



<form class="form-horizontal" >
<fieldset>
    <legend><span>Owner</span> System</legend>
    <div class="span4">
        <a href="index.php?chose_page=adddormitory"><button type="button" class="btn btn-primary btn-lg btn-block book-now2">Add Dormitory</button></a><br><br>
        <a href="index.php?chose_page=checkbooking"><button type="button" class="btn btn-primary btn-lg btn-block book-now2">Check Booking History</button></a>
    </div>
    <br />
    <br />
    
    
    <?php  
    
    function show_room($dormID,$dormName){
        
        require 'connection.php';
        
        $query = "select * from Rooms where dormID = $dormID and status = 'Active'";
        
        $result = mysqli_query($con, $query);        
        while($row = mysqli_fetch_array($result)){
            echo '<a href="index.php?chose_page=editroom&dormID='.$dormID.'&dormName='.$dormName.'&roomID='.$row["roomID"].'"><button style="width: 70%" type="button" class="btn btn-primary btn-lg btn-block book-now2">'.$row["roomType"].'</button></a><br><br>';
        }
        
    }
        
        require 'connection.php';
        
        $query = 'select * from Dormitories where memberID = '.$_SESSION["memberID"];
        $result = mysqli_query($con, $query);
        
        
    ?>
    <div style="margin-top: 70px">
        <legend><span>Edit Your</span> Domitory</legend>
        <?php while($row = mysqli_fetch_array($result)){ ?>
        <div class="span4">
            <a href="index.php?chose_page=editDormitory&dormID=<?php echo $row["dormID"]; ?>"><button type="button" class="btn btn-primary btn-block book-now2"><?php echo $row["dormName"] ?></button></a><br><br>
        </div>
        <div class="span5">
            <?php show_room($row["dormID"], $row["dormName"]); ?>
            <a href="index.php?chose_page=editroom&dormID=<?php echo $row["dormID"]; ?>&dormName=<?php echo $row["dormName"]?>"><button type="button" style="width: 70%" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Room</button><br><br></a>
        </div>
        <?php } ?>
    </div>
</fieldset>
</form>
</div> <!-- /container -->
<br><br><br><br><br><br><br>
