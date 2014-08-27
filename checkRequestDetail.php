

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
                    </div>
                    <div class="row">
                        <div class="span9">
                            <br />
                            <a href="callback.php?approval_submit=<?php echo $row["confirmID"]; ?>" class="btn btn-primary btn-large book-now pull-right" style="margin-left:15px">Approve</a>
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
