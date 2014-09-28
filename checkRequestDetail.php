

<?php
if (isset($_GET["confirmID"]) && is_numeric($_GET["confirmID"])) {

    require 'connection.php';
    $confirmID = $_GET["confirmID"];
    $query = "select * from ConfirmationDorm c join Members m where confirmID = $confirmID and c.memberID = m.memberID";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    ?>

    <div col-md-12>    
        <legend><h3 style="text-align: center"><span>Dormitory </span>Information</h3></legend>
        <div class="col-md-6 pull-left" >
            <table style="width: 100%;">
                <tbody>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Dorm Name : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["dormName"] ?>
                        </td>
                    </tr>            
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>Request Date : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["date"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px"> 
                        <td>
                            <h4><span>License ID : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["license"] ?>
                        </td>
                    </tr>
                    <tr style=" border-bottom: #cccccc solid 1px">
                        <td>
                            <h4><span>Request Status : </span></h4>  
                        </td>
                        <td>
                            <?php echo $row["approval"] ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-md-6">   
            <h4 style=" margin-left: 60%"><span>Evidence</span></h4>  
            <img src="<?php echo $row["evidence"] ?>" class="img-thumbnail pull-right" style="width: 60%;height: 30%;"/>
        </div>       


        <div class="col-md-6" style=" margin-top: -5%; margin-bottom: 5%">
            <legend><span>Special</span> Request</legend>
            <textarea class="col-md-12 form-control" rows="4" disabled=""><?php echo $row["special_request"] ?></textarea>
        </div>			

        <legend><h3 style="text-align: center;"><span>Owner </span>Information</h3></legend>
        <div class="col-md-6 pull-left" style="margin-bottom: 5%" >
            <table style="width: 100%;">
                <tbody>
                    <tr> 
                        <td>
                            <h4><span>Owner Name : </span></h4>
                        </td>
                        <td>
                            <?php echo $row["firstName"] ?> <?php echo $row["lastName"] ?>
                        </td>
                    </tr>            
                </tbody>
            </table>
        </div>
    </div>

    <legend><h3 style="text-align: center"><span>Dormitory </span>Rating</h3></legend>
    <div class="col-md-12">
    <div class="col-md-4 pull-left">
        <select id="dorm_rate" name="dorm_rate" class="form-control" style="width: 80%">
            <option value="default">Chose Dormitory Rate</option>
            <option value="1">1 Star</option>
            <option value="2">2 Star</option>
            <option value="3">3 Star</option>
            <option value="4">4 Star</option>
            <option value="5">5 Star</option>
        </select>
    </div>
        <div class="col-md-4 " style="margin-top: -2.5%">
        <h3 id="dorm_star" style="color:gold"> &#9734;&#9734;&#9734;&#9734;&#9734;</h3>
    </div>
    
    <script>

        $(document).on("change", "#dorm_rate", function() {
            var dorm_rate = $("#dorm_rate").val();

            if (dorm_rate === "default") {
                $("#dorm_star").html("&#9734;&#9734;&#9734;&#9734;&#9734;");
                document.getElementById("approve_button").removeAttribute("href");
            }
            if (dorm_rate === "1") {
                $("#dorm_star").html("&#9733;&#9734;&#9734;&#9734;&#9734;");
                document.getElementById("approve_button").removeAttribute("onClick");
            }
            if (dorm_rate === "2") {
                $("#dorm_star").html("&#9733;&#9733;&#9734;&#9734;&#9734;");
                document.getElementById("approve_button").removeAttribute("onClick");
            }
            if (dorm_rate === "3") {
                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9734;&#9734;");
                document.getElementById("approve_button").removeAttribute("onClick");
            }
            if (dorm_rate === "4") {
                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9733;&#9734;");
                document.getElementById("approve_button").removeAttribute("onClick");
            }
            if (dorm_rate === "5") {
                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9733;&#9733;");
                document.getElementById("approve_button").removeAttribute("onClick");
            }

        });

        $(function() {

            $("#reject_button").on("click", function() {
                if (confirm("Do you want to reject this request ?")) {
                    url = "callback.php?reject_submit=<?php echo $row["confirmID"] ?>";
                    $("#reject_button").load(url);
                } else {
                    event.preventDefault();
                }
            });
            $("#approve_button").on("click", function() {
                if ($("#dorm_rate").attr("value") !== "default") {
                    if (confirm("Do you want to approve this request ?")) {
                        url = "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=" + $("#dorm_rate").attr("value");
                        $("#approve_button").load(url);
                    } else {
                        event.preventDefault();
                    }
                }
            });
        });

    </script>
    <br><br>
    <div class="col-md-12" style="margin-bottom: 10%">
            <br />
            <a id="approve_button" onClick="alert('Please Chose Dormitory Rating');" class="btn1 btn1-success pull-left" style="width: 20%; margin-top: 5%">Approve</a>
            <a id="reject_button" class="btn1 btn1-danger pull-left" style="margin-left: 15px;width: 20%;margin-top: 5%">Reject</a>
            <a href="index.php?chose_page=checkRequestDorm" class="btn1 btn1-danger pull-right" style="width: 20%;margin-top: 5%">Back</a>
            <br />
            <br />
        
    </div>

    </div>
    </div>
<?php } ?>          <!-- /container -->

