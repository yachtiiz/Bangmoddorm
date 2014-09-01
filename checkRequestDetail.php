

<?php

if(isset($_GET["confirmID"]) && is_numeric($_GET["confirmID"])){
    
require 'connection.php';

$query = "select * from ConfirmationDorm where confirmID = ".$_GET["confirmID"];

$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

?>

<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form action="" method="post" class="form-horizontal">
                <fieldset>
                    <br /><br />
                    <h1>Add Dormitory				<br /><small>Owner send request to Admin for add your dormitory.
                        </small></h1><br />
                    <div class="row">
                        <div class="span8">
                            <legend><span>Your</span> Dormitory Information</legend>
                        </div>
                        <div class="span3">
                            <label>Dormitory Name
                                <p class="lead"><?php echo $row["dormName"] ?></p>
                            </label>
                        </div>	
                    </div>		
                    <br />
                    <div class="row">
                        <div class="span8">
                            <legend><span>Your</span> Evidence</legend>
                        </div>
                        <div class="span3">
                            <label>License ID
                                <p class="lead"><?php echo $row["license"] ?> </p>
                            </label>
                        </div>
                        <div class="span3">
                            <label>Evidence
                                <img src="/<?php echo $row["evidence"] ?>" class="img-thumbnail"/>
                            </label>
                        </div>	
                    </div>
                    <br />
                    <div class="row">
                        <div class="span9">
                            <legend><span>Any</span> special requests?</legend>
                            <textarea class="span9 form-control" rows="4"><?php echo $row["special_request"] ?></textarea>
                        </div>			
                    </div><br><br>
                    <div class="row">
                        <div class="span9">
                            <legend><span>Dormitories</span> Rating</legend>
                        </div>
                        <div class="span4">
                            <select id="dorm_rate" name="dorm_rate" class="form-control" style="width: 80%">
                                <option value="default">Chose Dormitory Rate</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Star</option>
                                <option value="3">3 Star</option>
                                <option value="4">4 Star</option>
                                <option value="5">5 Star</option>
                            </select>
                        </div>
                        <div class="span3 pull-right">
                            <h3 id="dorm_star" style="color:gold"> &#9734;&#9734;&#9734;&#9734;&#9734;</h3>
                        </div>
                        <script>
                                                
                        $(document).on("change","#dorm_rate" , function(){
                            var dorm_rate = $("#dorm_rate").val();
                            
                            if(dorm_rate === "default"){
                                $("#dorm_star").html("&#9734;&#9734;&#9734;&#9734;&#9734;");
                                document.getElementById("approve_button").setAttribute("onClick", "alert('Please Chose Dormitory Rating');");
                                document.getElementById("approve_button").removeAttribute("href");
                            }
                            if(dorm_rate === "1"){
                                $("#dorm_star").html("&#9733;&#9734;&#9734;&#9734;&#9734;");
                                document.getElementById("approve_button").setAttribute("href", "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=1");
                                document.getElementById("approve_button").removeAttribute("onClick");
                            }
                            if(dorm_rate === "2"){
                                $("#dorm_star").html("&#9733;&#9733;&#9734;&#9734;&#9734;");
                                document.getElementById("approve_button").setAttribute("href", "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=2");
                                document.getElementById("approve_button").removeAttribute("onClick");
                            }
                            if(dorm_rate === "3"){
                                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9734;&#9734;");
                                document.getElementById("approve_button").setAttribute("href", "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=3");
                                document.getElementById("approve_button").removeAttribute("onClick");
                            }
                            if(dorm_rate === "4"){
                                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9733;&#9734;");
                                document.getElementById("approve_button").setAttribute("href", "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=4");
                                document.getElementById("approve_button").removeAttribute("onClick");
                            }
                            if(dorm_rate === "5"){
                                $("#dorm_star").html("&#9733;&#9733;&#9733;&#9733;&#9733;");
                                document.getElementById("approve_button").setAttribute("href", "callback.php?approval_submit=<?php echo $row["confirmID"]; ?>&dorm_rate=5");
                                document.getElementById("approve_button").removeAttribute("onClick");
                            }
                            
                        });
                        
                        </script>
                    </div><br><br>
                    <div class="row">
                        <div class="span9">
                            <br />
                            <a id="approve_button" onClick="alert('Please Chose Dormitory Rating');" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Approve</a>
                            <a href="checkRequestDorm.jsp" class="btn btn-primary btn-large book-now pull-right">Back</a>
                            <br />
                            <br />
                        </div>
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div></div> <!-- /container -->
<?php } ?>
