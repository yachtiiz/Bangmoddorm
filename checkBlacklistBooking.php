
<?php include 'header.php' ?>
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal" />
                <fieldset>
                    <br /><br />
                    <br />
                    <div class="row">
                        <div class="span12">
                            <legend>
                                <span>Booking</span> System
                            </legend>
                            Search Booking : 
                            <input type="text" placeholder="" class="form-control">
                            <select>
                                <option>Sort By Date</option>
                                <option>Sort By Status</option>
                                <option>Sort By Member</option>
                                <option>Sort By Status Waiting Only</option>
                                <option>Sort By Status Approve Only</option>
                                <option>Sort By Status Over Time Only</option>
                            </select>
                            <button type="button" class="btn btn-success">Search</button>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-striped">
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Member ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date</th>
                                <th>Status</th>
                                <tr>
                                    <td>1</td>
                                    <td>1235</td>
                                    <td>1222</td>
                                    <td>Ajchariya</td>
                                    <td>Arunaramwong</td>
                                    <td>18/05/57</td>
                                    <td>
                                        Absent
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1236</td>
                                    <td>1222</td>
                                    <td>Ajchariya</td>
                                    <td>Arunaramwong</td>
                                    <td>14/05/57</td>
                                    <td>
                                        Absent
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>1234</td>
                                    <td>1222</td>
                                    <td>Ajchariya</td>
                                    <td>Arunaramwong</td>
                                    <td>10/05/57</td>
                                    <td>
                                        Absent
                                    </td>
                                </tr>
                            </table>
                            <ul class="pagination">
                                <li><a href="#">&laquo;</a>
                                    <a href="#">1</a>
                                    <a href="#">2</a>
                                    <a href="#">3</a>
                                    <a href="#">4</a>
                                    <a href="#">5</a>
                                    <a href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="checkBlacklist.php" class="btn btn-primary btn-large book-now pull-left">Back</a>
                </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
<?php include 'footer.php' ?>

