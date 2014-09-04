

<script>
    
    $(function() {
                $("#select_dorm").live("change", function(event) {
                    event.preventDefault();
                    url = "callback.php?showbook_dormID=" + $(this).val();
                    $("#show_result").animate({
                        opacity: 0
                    }, 100, function() {
                        $("#show_result").load(url, function() {
                            $("#show_result").animate({
                                opacity: 1
                            }, 200);
                        });
                    });
                    return false;
                });
            });
    
    
</script>


    <div class="row booking_summary">
        <div class="span12">	
            <div class="row">
                <div class="span12">
                    <form class="form-horizontal">
                        <fieldset>
                            <br />
                            <div class="row">
                                
                                <div class="span12">
                                    <legend>
                                        <span>Booking</span> System
                                    </legend>
                                </div>

                                <div class="span12" style="margin-bottom: 30px">
                                    <select id="select_dorm" class="form-control pull-left" style="width:30%">
                                        <option value="default">Select Dormitories</option>
                                        <?php 
                                        require 'connection.php';
                                        $memberID = $_SESSION["memberID"];
                                        
                                        $query = "select * from dormitories where memberID = $memberID ";
                                        $result = mysqli_query($con, $query);
                                        while($row = mysqli_fetch_array($result)){?>
                                        <option value="<?php echo $row["dormID"]; ?>"><?php echo $row["dormName"]; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="span6">
                                    <div class="input-group" style="width:100%">
                                        <span class="input-group-addon">Search Booking</span>
                                        <input class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="span3 pull-right">
                                    <select class="form-control pull-right" style="width:100%">
                                        <option>Sort By Date</option>
                                        <option>Sort By Status</option>
                                        <option>Sort By Member</option>
                                        <option>Sort By Status Waiting Only</option>
                                        <option>Sort By Status Approve Only</option>
                                        <option>Sort By Status Over Time Only</option>
                                    </select>
                                </div>
                                
                                <div class="span12">
                                    <br>
                                    <table class="table table-striped" style="border: solid 1px #cccccc">
                                        <th>#</th>
                                        <th>Booking ID</th>
                                        <th>Booking Room Type</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th></th>
                                        <tbody id="show_result">
                                        <tr>
                                            <td colspan="8" style="text-align: center"> No Result</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium">
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium">
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium">
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium" disabled>
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option disabled selected>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium" disabled>
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option selected>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium">
                                                    <option>Waiting</option>
                                                    <option>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium" disabled>
                                                    <option>Waiting</option>
                                                    <option selected>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn ">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium" disabled>
                                                    <option>Waiting</option>
                                                    <option selected>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn">Change Status</button></td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>1234</td>
                                            <td>1222</td>
                                            <td>Ajchariya</td>
                                            <td>Arunaramwong</td>
                                            <td>26/08/35</td>
                                            <td>
                                                <select class="form-control input-medium" disabled>
                                                    <option>Waiting</option>
                                                    <option selected>Confirmed</option>
                                                    <option>Canceled</option>
                                                    <option>Absent</option>
                                                </select>
                                            </td>
                                            <td><button type="button" class="btn">Change Status</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="ownersystem.jsp" class="btn btn-primary btn-large book-now" style="margin-left: 400px;margin-top: 30px">Back</a>
                            </div>
                            <br />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /container -->
<br><br><br><br><br>       