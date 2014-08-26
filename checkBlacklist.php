
<?php include 'header.php' ?>
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal" />
                <fieldset>
                    <br>
                    <div class="row">
                        <div class="span12">
                            <legend>
                                <span>Member Blacklist</span> Information System
                            </legend>
                            Search Member : 
                            <input type="text" placeholder="" class="form-control">
                            <select>
                                <option>Sort By Member ID</option>
                                <option>Sort By Alphabet</option>
                                <option>Sort By Status</option>
                            </select>
                            <button type="button" class="btn btn-success">Search</button>
                        </div>
                        <br><br><br><br><br><br>
                        <div class="span12">
                            <table class="table table-striped">
                                <th>#</th>
                                <th>Member ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Identity Card Number</th>
                                <th>Reason</th>
                                <th></th>
                                <tr>
                                    <td>1</td>
                                    <td>0001</td>
                                    <td>Ajchariya</td>
                                    <td>Arunaramwong</td>
                                    <td>112312423211</td>
                                    <td><a href="checkBlacklistBooking.php">Absent booking for three times</a></td>
                                    <td><a href="memberInfo.php"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>0002</td>
                                    <td>Thanakorn</td>
                                    <td>Kamarj</td>
                                    <td>441235223211</td>
                                    <td>Rude word</td>
                                    <td><a href="memberInfo.php"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                </tr> <tr>
                                    <td>3</td>
                                    <td>0003</td>
                                    <td>Thanin</td>
                                    <td>Jalernrungsun</td>
                                    <td>001231223211</td>
                                    <td><a href="checkBlacklistBooking.php">Absent booking for three times</a></td>
                                    <td><a href="memberInfo.php"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                </tr> <tr>
                                    <td>4</td>
                                    <td>0004</td>
                                    <td>Danuphon</td>
                                    <td>Sumarayasuk</td>
                                    <td>123355223211</td>
                                    <td>Rude word</td>
                                    <td><a href="memberInfo.php"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>0005</td>
                                    <td>Somchai</td>
                                    <td>Makme</td>
                                    <td>123355223211</td>
                                    <td><a href="checkBlacklistBooking.php">Absent booking for three times</a></td>
                                    <td><a href="memberInfo.php"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
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
                    <a href="adminsystem.php" class="btn btn-primary btn-large book-now pull-left">Back</a>
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
<?php include 'footer.php' ?>

