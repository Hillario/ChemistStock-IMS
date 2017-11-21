<?php
require_once "header.php";
require_once "MySql.php";

$mydb=new MySql();

if (isset($_POST['search'])) $search = $_POST['search'];
else $search="";

$mydbQuery="Select * From stock where ProductName LIKE"."'%".$search."%' ORDER BY ExpiryDate";
$mydbSelect=$mydb->select($mydbQuery);
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Dashboard</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box green-bg">
                    <i class="fa fa-cubes"></i>
                    <?php
                    $stockQuery="SELECT SUM(Quantity) as totalcost, Stockid,ProductName,ExpiryDate,BatchNumber,buyingprice,sellingprice,discount,Quantity from stock  WHERE ProductName LIKE"."'%".$search."%' ORDER BY ExpiryDate";
                    $stockSelect=$mydb->select($stockQuery);

                    foreach($stockSelect as $row)
                    {
                        $totalstock=$row['totalcost'];
                    }
                    ?>
                    <div class="count"><?php echo $totalstock?></div>
                    <div class="title">Total Stock</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box brown-bg">
                    <i class="fa fa-toggle-up"></i>
                    <?php
                    $ingoingstockQuery="Select SUM(Quantity) as stockTotal From stock";
                    $ingoingstockSelect=$mydb->select($ingoingstockQuery);

                    foreach($ingoingstockSelect as $row)
                    {
                        $sTotal=$row['stockTotal'];
                    }

                    $queryoutgoing="Select SUM(OutgoingQuantity) as outgoingTotal From outgoingstock";
                    $queryoutgoingSelect=$mydb->select($queryoutgoing);

                    foreach ($queryoutgoingSelect as $row)
                    {
                        $oTotal=$row['outgoingTotal'];
                    }

                    $totalIngoing=$sTotal-$oTotal;
                    ?>
                    <div class="count"><?php echo $totalIngoing?></div>
                    <div class="title">Total Ingoing Stock</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box dark-bg">
                    <i class="fa fa-toggle-down"></i>
                    <?php
                    $outgoingstockQuery="Select SUM(OutgoingQuantity) as totalOutgoing ,S.Stockid,O.Outgoingid FROM stock S, outgoingstock O WHERE S.Stockid=O.Stockid AND S.Storeid='$sid'";
                    $outgoingstockSelect=$mydb->select($outgoingstockQuery);

                    foreach($outgoingstockSelect as $row)
                    {
                        $outgoingstockCount=$row['totalOutgoing'];
                    }
                    ?>
                    <div class="count"><?php echo $outgoingstockCount?></div>
                    <div class="title">Total Outgoing Stock</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box blue-bg">
                    <i class="fa fa-money"></i>
                    <?php
                    $usersQuery="Select SUM(outgoingtotal) as total ,S.Stockid,O.Outgoingid FROM stock S, outgoingstock O WHERE S.Stockid=O.Stockid AND S.Storeid='$sid'";
                    $userSelect=$mydb->select($usersQuery);

                    foreach($userSelect as $row)
                    {
                        $sumtotal=$row['total'];
                    }
                    ?>
                    <div class="count"><?php echo $sumtotal?></div>
                    <div class="title">Total Sold</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

        </div><!--/.row-->


        <!--Level 2 of summary details-->

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box green-bg">
                    <i class="fa fa-shopping-cart"></i>
                    <?php
                    $stockQuery="SELECT SUM(total) as totalcost From stock";
                    $stockSelect=$mydb->select($stockQuery);

                    foreach($stockSelect as $row)
                    {
                        $totalstock=$row['totalcost'];
                    }
                    ?>
                    <div class="count"><?php echo $totalstock?></div>
                    <div class="title">Gross Buying Price</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box brown-bg">
                    <i class="fa fa-magic"></i>
                    <?php
                    $ingoingstockQuery="Select SUM(outgoingtotal) as stockTotal From outgoingstock";
                    $ingoingstockSelect=$mydb->select($ingoingstockQuery);

                    foreach($ingoingstockSelect as $row)
                    {
                        $sTotal=$row['stockTotal'];
                    }

                    $profit=$sTotal-$totalstock;
                    ?>
                    <div class="count"><?php echo $profit?></div>
                    <div class="title">Net Profit</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box dark-bg">
                    <i class="fa fa-car"></i>
                    <?php
                    $outgoingstockQuery="Select COUNT(*) As count from supplier";
                    $outgoingstockSelect=$mydb->select($outgoingstockQuery);

                    foreach($outgoingstockSelect as $row)
                    {
                        $outgoingstockCount=$row['count'];
                    }
                    ?>
                    <div class="count"><?php echo $outgoingstockCount?></div>
                    <div class="title">Supplier(s)</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box blue-bg">
                    <i class="fa fa-medkit"></i>
                    <?php
                    $usersQuery="Select COUNT(*) as drugcount from drug";
                    $userSelect=$mydb->select($usersQuery);

                    foreach($userSelect as $row)
                    {
                        $sumtotal=$row['drugcount'];
                    }
                    ?>
                    <div class="count"><?php echo $sumtotal?></div>
                    <div class="title">Drugs in Ref.</div>
                </div><!--/.info-box-->
            </div><!--/.col-->

        </div><!--/.row-->

        <!--END-->
        <!-- project team & activity end -->
        <!--Main Table starts here-->
        <div class="row">
            <section class="panel">
                <form class="navbar-form" action="" method="post">
                    <input name="search" class="form-control" placeholder="Search" type="text" value="<?php if (isset($_POST['search'])) {echo($_POST['search']);} ?>">
                    <button class="btn btn-danger" type="submit">Go!</button>
                </form>
                <!--FORM Operations-->

                <!--Form Operations-->
                <header class="panel-heading">
                    Stock Summary
                </header>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Stockid</th>
                            <th>Name</th>
                            <th>ExpiryDate</th>
                            <th>BatchNo</th>
                            <th>Buying Price</th>
                            <th>Selling Price</th>
                            <th>Discount</th>
                            <th>Quantity</th>
                            <th>Re-Stock</th>
                            <th>QuantityInStock</th>
                            <th>InStockTotal</th>
                        </tr>
                        </thead>
                        <?php
                        if(count($mydbSelect)) {
                            foreach ($mydbSelect as $row) {
                                ?>
                                <tbody>
                                <tr>
                                    <td><?php echo $row['Stockid']; ?></td>
                                    <td><?php echo $row['ProductName']; ?></td>
                                    <td><?php echo $row['ExpiryDate']; ?></td>
                                    <td><?php echo $row['BatchNumber']; ?></td>
                                    <td><?php echo $row['buyingprice']; ?></td>
                                    <td><?php echo $row['sellingprice']; ?></td>
                                    <td><?php echo $row['discount']; ?></td>
                                    <td><?php echo $row['Quantity']; ?></td>
                                    <td><?php echo $row['minquantity']; ?></td>
                                    <td><?php echo $row['ingoing']; ?></td>
                                    <td><?php echo $row['intotal']; ?></td>
                                </tr>
                                </tbody>
                                <?php
                            }
                        }
                        else
                        {
                            echo "Oops :( No Data Found";
                        }
                        ?>
                    </table>
                </div>

            </section>
        </div>
        </div>
        <!--Main Table starts here-->
    </section>
</section>
<!--main content end-->
</section>
<!-- container section start -->

<!-- javascripts -->
<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>
<script src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<!-- bootstrap -->
<script src="js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- charts scripts -->
<script src="assets/jquery-knob/js/jquery.knob.js"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="js/owl.carousel.js" ></script>
<!-- jQuery full calendar -->
<<script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
<script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
<!--script for this page only-->
<script src="js/calendar-custom.js"></script>
<script src="js/jquery.rateit.min.js"></script>
<!-- custom select -->
<script src="js/jquery.customSelect.min.js" ></script>
<script src="assets/chart-master/Chart.js"></script>

<!--custome script for all page-->
<script src="js/scripts.js"></script>
<!-- custom script for this page-->
<script src="js/sparkline-chart.js"></script>
<script src="js/easy-pie-chart.js"></script>
<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jquery-jvectormap-world-mill-en.js"></script>
<script src="js/xcharts.min.js"></script>
<script src="js/jquery.autosize.min.js"></script>
<script src="js/jquery.placeholder.min.js"></script>
<script src="js/gdp-data.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/sparklines.js"></script>
<script src="js/charts.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script>

    //knob
    $(function() {
        $(".knob").knob({
            'draw' : function () {
                $(this.i).val(this.cv + '%')
            }
        })
    });

    //carousel
    $(document).ready(function() {
        $("#owl-slider").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });

    /* ---------- Map ---------- */
    $(function(){
        $('#map').vectorMap({
            map: 'world_mill_en',
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#000', '#000'],
                    normalizeFunction: 'polynomial'
                }]
            },
            backgroundColor: '#eef3f7',
            onLabelShow: function(e, el, code){
                el.html(el.html()+' (GDP - '+gdpData[code]+')');
            }
        });
    });



</script>

</body>
</html>
