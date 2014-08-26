
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
                                            <span>Dormitory</span> Request
                                        </legend>
                                        Search Request : 
                                        <input type="text" placeholder="" class="form-control">
                                        <select>
                                            <option>Sort By Date</option>
                                            <option>Sort By Status</option>
                                            <option>Sort By Member</option>
                                        </select>
                                        <button type="button" class="btn btn-success">Search</button>
                                    </div>
                                    <br><br><br><br><br><br>
                                    <div class="span12">
                                        <table class="table table-striped">
                                            <th>#</th>
                                            <th>Request ID</th>
                                            <th>Member ID</th>
                                            <th>Dormitory Name</th>
                                            <th>Approval</th>
                                            <th>Date</th>
                                            <th></th>
                                            <tr>
                                                <td>1</td>
                                                <td>0001</td>
                                                <td>0111</td>
                                                <td>SuanThon</td>
                                                <td>Wait For Approve</td>
                                                <td>14/05/57</td>
                                                <td><a href="checkRequestDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>0002</td>
                                                <td>0122</td>
                                                <td>55 garden</td>
                                                <td>Approved</td>
                                                <td>02/05/57</td>
                                                <td><a href="checkRequestDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>0003</td>
                                                <td>0133</td>
                                                <td>Saransook</td>
                                                <td>Wait For Approve</td>
                                                <td>08/05/57</td>
                                                <td><a href="checkRequestDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>0004</td>
                                                <td>0144</td>
                                                <td>6Brothers</td>
                                                <td>Decline</td>
                                                <td>14/04/57</td>
                                                <td><a href="checkRequestDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>0005</td>
                                                <td>0155</td>
                                                <td>12Brothers</td>
                                                <td>Decline</td>
                                                <td>20/04/57</td>
                                                <td><a href="checkRequestDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
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
