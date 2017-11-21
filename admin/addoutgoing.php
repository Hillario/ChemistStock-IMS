<?php
require_once "header.php";
require_once "MySql.php";
$mydb=new MySql();

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['outgoingid'])) $outgoingid = $_POST['outgoingid'];
    if (isset($_POST['cname'])) $cname = $_POST['cname'];
    if (isset($_POST['oquantity'])) $oquantity = $_POST['oquantity'];
    if (isset($_POST['sp'])) $sp = $_POST['sp'];
    if (isset($_POST['dis'])) $dis = $_POST['dis'];
    $error=array();
    if (empty($_POST["outgoingid"])) {
        $error[]='Please Select the Product Id';
    }
    if (empty($_POST["cname"])) {
        $error[]='Please Enter the Customer name';
    }
    if (empty($_POST["oquantity"])) {
        $error[]='Please Enter the Outgoing Quantity';
    }
    if (empty($_POST["sp"])) {
        $error[]='Please Enter the Selling Price';
    }
    if (empty($_POST["dis"])) {
        $error[]='Please Enter the Discount';
    }
}
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Add Outgoing Stock</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Add Outgoing Stock</li>
                </ol>
            </div>
        </div>
        <!--END-->
        <!-- project team & activity end -->
        <!--Main Form starts here-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Add Outgoing Stock
                </header>
                <div class="panel-body">
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Select Product Name</label>
                            <div class="form-group">
                                <select name="outgoingid" id="outgoingid" class="form-control m-bot15">
                                    <?php
                                    $squery="SELECT * FROM stock WHERE Storeid='$sid'";//store id of the selected premises
                                    $ssquery=$mydb->select($squery);
                                    foreach($ssquery as $row)
                                    {
                                        echo "<option selected='selected'>".$row['ProductName']."</option>";
                                    }
                                    //select id from productname
                                    $idquery="SELECT Stockid from stock where ProductName='".$outgoingid."'";
                                    $idselect=$mydb->select($idquery);
                                    foreach ($idselect as $row){
                                        $id=$row['Stockid'];
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input name="oquantity" type="text" class="form-control" id="oquantity" placeholder="Enter Outgoing Quantity" value="<?php if (isset($_POST['oquantity'])) $oquantity = $_POST['oquantity'];?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Selling Price</label>
                            <input name="sp" type="text" class="form-control" id="sp" placeholder="Enter the selling price" value="<?php if (isset($_POST['sp'])) $sp = $_POST['sp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discount</label>
                            <input name="dis" type="text" class="form-control" id="dis" placeholder="Enter Discount" value="<?php if (isset($_POST['dis'])) $dis = $_POST['dis'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Patient Name</label>
                            <input name="cname" type="text" class="form-control" id="cname" placeholder="Enter Customer Name" value="<?php if (isset($_POST['cname'])) $cname = $_POST['cname'];?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                    <!--form operations-->
                    <?php

                    if (isset($error)) {
                        if (!empty($error)) {
                            echo '<ul><li>', @implode('</li><li>', $error), '</li></ul>';
                        } else {
                            //select total quantity
                            $hquery="SELECT * FROM stock WHERE Stockid='$id'";
                            $shquery=$mydb->select($hquery);
                            foreach($shquery as $row)
                            {
                                $totalStock=$row['Quantity'];
                                $sellingprice=$row['sellingprice'];
                                $discount=$row['discount'];
                                $minquan=$row['minquantity'];
                                $ingoing=$row['ingoing'];
                                $bp=$row['buyingprice'];
                                $lsp=$row['lsp'];
                            }
                            //intelligent calculating for the ingoing stock
                            $ingoingStock=$totalStock-$oquantity;
                            //calculate outgoing parameters
                            $ototal;
                            $fsellingprice=$sp-$dis;
                            $ototal=$fsellingprice*$oquantity;

                            $sdiff=$ingoing-$oquantity;
                            $itotal=$bp*$sdiff;
                            //validate the minimum stock
                            if($sdiff<=$minquan){
                                echo "<style> P{color: red}</style> <p>The minimum stock level has been reached, please re-stock to continue. </p>";
                            }elseif ($fsellingprice<=$lsp){
                                echo "<style> P{ color: red}</style> <p>The selling price[".$fsellingprice."]"." cannot be less than or equal to L.S.P[".$lsp."] </p>";
                            }
                            else if($sdiff>$minquan && $fsellingprice>$lsp) {
                                //insert query here
                                $insertQuery = "INSERT INTO `stockmanagement`.`outgoingstock` (`Outgoingid`, `DateOut`, `CustomerName`,`OutgoingQuantity`,`outgoingtotal`,`Stockid`,`Userid`) VALUES (NULL,CURRENT_TIMESTAMP(), '" . $cname . "','" . $oquantity . "','" . $ototal . "','" . $id . "','" . $uid . "');";
                                //add ingoing stock here
                                $ingoingQuery = "INSERT INTO `stockmanagement`.`ingoingstock` (`Ingoingstockid`, `IngoingQuantity`, `Stockid`) VALUES (NULL, '" . $ingoingStock . "', '" . $id . "');";
                                //update ingoing in the stock table
                                $updateStocki = "UPDATE `stock` SET `ingoing` = '" . $sdiff . "', `intotal` = '" . $itotal . "' WHERE `stock`.`Stockid` = '" . $id . "';";
                                //insert data for temp
                                $querytemp="INSERT INTO `temp` (`id`, `name`, `quantity`, `sellingprice`, `discount`,`total`, `dateout`) VALUES ('".$id."', '".$outgoingid."', '".$oquantity."', '".$sp."', '".$dis."','".$ototal."', CURRENT_TIMESTAMP);";
                                //query for updating the quantity with the ingoing stock
                                $mydb->insert($insertQuery);
                                $mydb->insert($ingoingQuery);
                                $mydb->insert($updateStocki);
                                $mydb->insert($querytemp);
                                //$updatequery="UPDATE `stock` SET `Quantity` = '".$ingoingStock."' WHERE `stock`.`Stockid` = '".$outgoingid."';";
                                //$mydb->insert($updatequery);
                                echo "<h4>Successfully Added,</h4>";
                            }
                            $querytotal="SELECT SUM(total) as ttl from temp";
                            $totalselect=$mydb->select($querytotal);
                            foreach ($totalselect as $row){
                                $totaldue=$row['ttl'];
                            }
                            echo "<h4>Total Amount::".$totaldue."</h4>";
                        }
                    }
                    $selectquery="SELECT * FROM temp";
                    $mydbSelect=$mydb->select($selectquery);
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
                            <th>Stockid</th>
                            <th>ProductName</th>
                            <th>Quantity</th>
                            <th>SellingPrice</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>DateOut</th>
                        </tr>
                        </thead>
                        <?php
                        if(count($mydbSelect)) {
                            foreach ($mydbSelect as $row) {
                                ?>
                                <tbody>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['sellingprice']; ?></td>
                                    <td><?php echo $row['discount']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td><?php echo $row['dateout']; ?></td>
                                </tr>
                                </tbody>
                                <?php
                            }
                        }
                        else
                        {
                            echo "<style>H3{ color: blue}</style> <h3>Currently no sale on customer made</h3>";
                        }
                        $queryt2="SELECT * FROM tempa";
                        $selectquery2=$mydb->select($queryt2);
                        foreach ($selectquery2 as $row){
                            $amountdue=$row['tdue'];
                            $balance=$row['balance'];
                        }
                        echo "<style>H4{color: green}</style> <h4>[Total Amount::".$amountdue.",</h4>";
                        echo "<h4>Balance::".$balance."]</h4>";
                        ?>
                    </table>
                </div>

            </section>
        </div>
        </div>
        <form role="form" method="post" action="compute.php">
            <div class="form-group">
            <div class="form-group">
                <label for="exampleInputEmail1">Amount paid</label>
                <input name="due" type="text" class="form-control" id="due" placeholder="Enter Amount Paid" value="<?php if (isset($_POST['due'])) $due = $_POST['due'];?>">
            </div>
            <button type="submit" class="btn btn-warning">Calculate</button>
        </form>

        <!--Main Table ends here-->
        <div align="right">
            <form role="form" method="post" action="customersummary.php">
                <button type="submit" class="btn btn-success">Submit</button>
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
