<?php
require_once "header.php";
require_once "MySql.php";

$mydb=new MySql();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $sname=trim($_POST['sname']);
    $category=trim($_POST['category']);
    $expirydate=trim($_POST['expirydate']);
    $batchno=trim($_POST['batchno']);
    $buyingprice=trim($_POST['bp']);
    $sellingprice=trim($_POST['sp']);
    $discount=trim($_POST['dis']);
    $quantity=trim($_POST['quantity']);
    $minquantity=trim($_POST['minquantity']);
    if (isset($_POST['sname'])) $sname = $_POST['sname'];
    if (isset($_POST['category'])) $category = $_POST['category'];
    if (isset($_POST['expirydate'])) $expirydate = $_POST['expirydate'];
    if (isset($_POST['batchno'])) $batchno = $_POST['batchno'];
    if (isset($_POST['bp'])) $buyingprice = $_POST['bp'];
    if (isset($_POST['sp'])) $sellingprice = $_POST['sp'];
    if (isset($_POST['dis'])) $discount = $_POST['dis'];
    if (isset($_POST['quantity'])) $quantity = $_POST['quantity'];
    if (isset($_POST['supplier'])) $supplier = $_POST['supplier'];
    if (isset($_POST['minquantity'])) $minquantity = $_POST['minquantity'];
    $error=array();
    if (empty($_POST["sname"])) {
        $error[]='Please enter product name';
    }
    if (empty($_POST["category"])) {
        $error[]='Please enter category';
    }
    if (empty($_POST["expirydate"])) {
        $error[]='Please enter expiry date';
    }
    if (empty($_POST["batchno"])) {
        $error[]='Please enter batch number';
    }
    if (empty($_POST["bp"])) {
        $error[]='Please enter buying price';
    }
    if (empty($_POST["sp"])) {
        $error[]='Please enter selling price';
    }
    if (empty($_POST["dis"])) {
        $error[]='Please enter discount';
    }
    if (empty($_POST["quantity"])) {
        $error[]='Please enter quantity';
    }
    if (empty($_POST["supplier"])) {
        $error[]='Please enter supplier';
    }
    if (empty($_POST["minquantity"])) {
        $error[]='Please enter the minimum quantity';
    }
}
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Add Stock</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Add Stock</li>
                </ol>
            </div>
        </div>
        <!--END-->
        <!-- project team & activity end -->
        <!--Main Form starts here-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Basic Forms
                </header>
                <div class="panel-body">
                    <form role="form" method="post" action="">
                        <select name="supplier" id="supplier" class="form-control m-bot15">
                            <?php
                            $squery="SELECT * FROM supplier";//store id of the selected premises
                            $ssquery=$mydb->select($squery);
                            foreach($ssquery as $row)
                            {
                                echo "<option selected='selected'>".$row['Name']."</option>";
                            }
                            ?>
                        </select>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input name="sname" type="text" class="form-control" id="sname" placeholder="Enter Product Name" value="<?php if (isset($_POST['sname'])) $sname = $_POST['sname'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category</label>
                            <input name="category" type="text" class="form-control" id="category" placeholder="Enter Product Category" value="<?php if (isset($_POST['category'])) $category = $_POST['category'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Batch Number</label>
                            <input name="batchno" type="text" class="form-control" id="batchno" placeholder="Enter Batch Number" value="<?php if (isset($_POST['batchno'])) $batchno = $_POST['batchno'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Expiry Date</label>
                            <input name="expirydate" type="text" class="form-control" id="expirydate" value="<?php if (isset($_POST['expirydate'])) $expirydate = $_POST['expirydate'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input name="quantity" type="text" class="form-control" id="quantity" placeholder="Enter Quantity" value="<?php if (isset($_POST['quantity'])) $quantity = $_POST['quantity'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Buying Price</label>
                            <input name="bp" type="text" class="form-control" id="bp" placeholder="Enter Buying Price" value="<?php if (isset($_POST['bp'])) $buyingprice = $_POST['bp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Selling Price</label>
                            <input name="sp" type="text" class="form-control" id="sp" placeholder="Enter Selling Price" value="<?php if (isset($_POST['sp'])) $sellingprice = $_POST['sp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discount</label>
                            <input name="dis" type="text" class="form-control" id="dis" placeholder="Enter Discount" value="<?php if (isset($_POST['dis'])) $discount = $_POST['dis'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Re-stock Level</label>
                            <input name="minquantity" type="text" class="form-control" id="minquantity" placeholder="Enter Minimum Quantity" value="<?php if (isset($_POST['minquantity'])) $minquantity = $_POST['minquantity'];?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                    <!--form operations-->
                    <?php
                    if (isset($error)) {
                    if (!empty($error)) {
                        echo '<ul><li>', @implode('</li><li>', $error), '</li></ul>';
                    } else {
                     //insert query here
                        //calculate total
                        $esellingprice=(0.33*$buyingprice)+$buyingprice;
                        $stotal=$buyingprice*$quantity;
                        $insertQuery="INSERT INTO `stockmanagement`.`stock` (`Stockid`, `ProductName`, `category`, `ExpiryDate`, `BatchNumber`, `buyingprice`, `lsp`,`sellingprice`, `discount`, `Quantity`, `minquantity`, `ingoing`, `supplier`, `total`, `intotal`, `Storeid`) VALUES (NULL, '".$sname."', '".$category."', '".$expirydate."', '".$batchno."', '".$buyingprice."', '".$esellingprice."', '".$sellingprice."','".$discount."', '".$quantity."', '".$minquantity."', '".$quantity."','".$supplier."', '".$stotal."', '".$stotal."','".$sid."');";
                        $mydb->insert($insertQuery);
                        //add data to temporary stock table
                        $tempquery="INSERT INTO `tempstock` (`suppliername`, `productname`, `category`, `batchno`, `expirydate`, `quantity`, `buyingprice`, `lsp`, `sellingprice`, `discount`, `total`) VALUES ('".$supplier."', '".$sname."', '".$category."', '".$batchno."', '".$expirydate."', '".$quantity."', '".$buyingprice."', '".$esellingprice."', '".$sellingprice."', '".$discount."', '".$stotal."');";
                        $tempselect=$mydb->insert($tempquery);
                        echo "Successfully Added";
                                            }
                    }
                    $selectquery="SELECT * FROM tempstock";
                    $mydbSelect=$mydb->select($selectquery);

                    //calculate total
                    $tquery="Select SUM(total) as tt from tempstock";
                    $tselect=$mydb->select($tquery);
                    foreach ($tselect as $row){
                        $gtotal=$row['tt'];
                    }

                    ?>
                    <!--form operations-->

                </div>
            </section>
        </div>
        </div>
        <!--Main Table ends here-->
        <!--view summary-->
        <!--Main Table starts here-->
        <div class="row">
            <section class="panel">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>SupplierName</th>
                            <th>ProductName</th>
                            <th>Category</th>
                            <th>Batch_No</th>
                            <th>ExpiryDate</th>
                            <th>Quantity</th>
                            <th>Buying Price</th>
                            <th>L.S.P</th>
                            <th>SellingPrice</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <?php
                        if(count($mydbSelect)) {
                            foreach ($mydbSelect as $row) {
                                ?>
                                <tbody>
                                <tr>
                                    <td><?php echo $row['suppliername']; ?></td>
                                    <td><?php echo $row['productname']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['batchno']; ?></td>
                                    <td><?php echo $row['expirydate']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['buyingprice']; ?></td>
                                    <td><?php echo $row['lsp']; ?></td>
                                    <td><?php echo $row['sellingprice']; ?></td>
                                    <td><?php echo $row['discount']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                </tr>
                                </tbody>
                                <?php
                            }
                        }
                        else
                        {
                            echo "Add stock for further update";
                        }
                        ?>
                    </table>
                </div>

            </section>
        </div>
        </div>
        <form role="form" method="post" action="stocksummary.php">
                <button type="submit" class="btn btn-warning">Submit</button>
        </form>

        <!--Main Table ends here-->
        <div align="right">
            <form role="form" method="post" action="">
                <button type="submit" class="btn btn-success"><?php echo "GrandTotal:".$gtotal;?></button>
            </form>
        </div>

        <!--view summary-->
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
