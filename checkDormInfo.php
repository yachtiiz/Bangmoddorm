
<?php include 'header.php' ?>

<?php
require 'connection.php';

$query = "select * from dormitories d join members m where d.memberID = m.memberID";
$result = mysqli_query($con, $query);
?>
<div class="row booking_summary">
    <div class="span12">	
        <div class="row">
            <div class="span9">
                <form class="form-horizontal">
                    <fieldset>
                        <br /><br />
                        <br />
                        <div class="row">
                            <div class="span12">
                                <legend>
                                    <span>Dormitory</span> Information
                                </legend>
                                Search Dormitory : 
                                <input type="text" style="width:40%" placeholder="" class="form-control">
                                <select class="form-control pull-right" style="width:20%">
                                    <option>Sort By A-Z</option>
                                    <option>Dormitory Type</option>
                                    <option>Rate</option>
                                    <option>Owner</option>
                                </select>

                            </div>
                            <br><br><br><br><br><br>
                            <div class="span12">
                                <table class="table table-striped">
                                    <th>#</th>
                                    <th>Dormitory ID</th>
                                    <th>Dormitory Name</th>
                                    <th>Owner Name</th>
                                    <th>Dormitory Type</th>
                                    <th></th>
                                    <?php while ($row = mysqli_fetch_array($result)) {
                                        $num = 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $num; ?></td>
                                            <td><?php echo $row["dormID"]; ?></td>
                                            <td><?php echo $row["dormName"]; ?></td>
                                            <td><?php echo $row["firstName"] . " " . $row["lastName"]; ?></td>
                                            <td><?php echo $row["type"]; ?></td>
                                            <td><a href="checkDormDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                        </tr>
                                        <?php $num = $num + 1;
                                    }
                                    ?>
                                    <tr>
                                        <td>3</td>
                                        <td>0003</td>
                                        <td>44 Garden</td>
                                        <td>Ajchariya</td>
                                        <td>Female</td>
                                        <td><button type="button" class="btn btn-success book-now">Detail</button></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>0004</td>
                                        <td>Thonburi Sport Club</td>
                                        <td>Thanakorn Kamarj</td>
                                        <td>Male & Female</td>
                                        <td><button type="button" class="btn btn-success book-now">Detail</button></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>0005</td>
                                        <td>3Brother</td>
                                        <td>Patawee Namtewee</td>
                                        <td>Male & Female</td>
                                        <td><button type="button" class="btn btn-success book-now">Detail</button></td>
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
                        <a href="adminsystem.jsp" class="btn btn-primary btn-large book-now pull-left">Back</a>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
</div> <!-- /container -->
<br><br><br><br><br>
<?php include 'footer.php' ?>
