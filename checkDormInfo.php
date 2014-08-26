
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
                                            <span>Dormitory</span> Information
                                        </legend>
                                        Search Dormitory : 
                                        <input type="text" placeholder="" class="form-control">
                                        <select>
                                            <option>Sort By A-Z</option>
                                            <option>Female</option>
                                            <option>Male</option>
                                            <option>Female & Male</option>
                                        </select>
                                        <button type="button" class="btn btn-success">Search</button>
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
                                            <tr>
                                                <td>1</td>
                                                <td>0001</td>
                                                <td>Myplace1</td>
                                                <td>Ajchariya Arunaramwong</td>
                                                <td>Male & Female</td>
                                                <td><a href="checkDormDetail.jsp"><button type="button" class="btn btn-success book-now">Detail</button></a></td>
                                               </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>0002</td>
                                                <td>Myplace2</td>
                                                <td>Ajchariya Arunaramwong</td>
                                                <td>Male</td>
                                                <td><button type="button" class="btn btn-success book-now">Detail</button></td>
                                               </tr>
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
