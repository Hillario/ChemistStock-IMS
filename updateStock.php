<?php
require_once "header.php";
require_once "MySql.php";
$mydb=new MySql();

if(isset($_POST['myStockid']))
{
    $_SESSION['usid']=$_POST['myStockid'];

}
$usid=($_SESSION['usid']);

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['sname'])) $sname = $_POST['sname'];
    if (isset($_POST['category'])) $category = $_POST['category'];
    if (isset($_POST['expirydate'])) $expirydate = $_POST['expirydate'];
    if (isset($_POST['batchno'])) $batchno = $_POST['batchno'];
    if (isset($_POST['bp'])) $buyingprice = $_POST['bp'];//os aforabe
    if (isset($_POST['sp'])) $sellingprice = $_POST['sp'];
    if (isset($_POST['dis'])) $discount = $_POST['dis'];
    if (isset($_POST['quantity'])) $quantity = $_POST['quantity'];
    if (isset($_POST['minquantity'])) $minquantity = $_POST['minquantity'];
    if (isset($_POST['supplier'])) $supplier = $_POST['supplier'];
    $error=array();
    if (empty($_POST["sname"])) {
        $error[]='Please update product name';
    }
    if (empty($_POST["category"])) {
        $error[]='Please update product category';
    }
    if (empty($_POST["expirydate"])) {
        $error[]='Please update expiry date';
    }
    if (empty($_POST["batchno"])) {
        $error[]='Please update batch number';
    }
    if (empty($_POST["bp"])) {
        $error[]='Please update buying price';
    }
    if (empty($_POST["sp"])) {
        $error[]='Please update selling price';
    }
    if (empty($_POST["dis"])) {
        $error[]='Please update discount';
    }
    if (empty($_POST["minquantity"])) {
        $error[]='Please update re-stock level';
    }
    if (empty($_POST["supplier"])) {
        $error[]='Please update supplier';
    }
}
echo $usid;
$uQuery="SELECT * from stock where Stockid='$usid'";
$suQuery=$mydb->select($uQuery);
foreach($suQuery as $row)
{
    $stid=$row['Stockid'];
    $name=$row['ProductName'];
    $ctg=$row['category'];
    $date=$row['ExpiryDate'];//megas xcom
    $batno=$row['BatchNumber'];
    $bpp=$row['buyingprice'];
    $spp=$row['sellingprice'];
    $dp=$row['discount'];
    $qnt=$row['Quantity'];
    $minqnt=$row['minquantity'];
    $supp=$row['supplier'];
    $tt=$row['total'];
    $ingoingq=$row['ingoing'];
}

?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Update Stock</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Update Stock</li>
                </ol>
            </div>
        </div>
        <!--END-->
        <!-- project team & activity end -->
        <!--Main Form starts here-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    <?php
                    echo "Update Product ".$name;//update product name in relation to database tuple.
                    ?>
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
                            <input name="sname" type="text" class="form-control" id="sname" placeholder="<?php echo $name?>" value="<?php if (isset($_POST['sname'])) $sname = $_POST['sname'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Category</label>
                            <input name="category" type="text" class="form-control" id="category" placeholder="<?php echo $ctg?>" value="<?php if (isset($_POST['category'])) $category = $_POST['category'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Expiry Date</label>
                            <input name="expirydate" type="text" class="form-control" id="expirydate" placeholder="<?php echo $date?>" value="<?php if (isset($_POST['expirydate'])) $expirydate = $_POST['expirydate'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Batch Number</label>
                            <input name="batchno" type="text" class="form-control" id="batchno" placeholder="<?php echo $batno?>" value="<?php if (isset($_POST['batchno'])) $batchno = $_POST['batchno'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Buying Price</label>
                            <input name="bp" type="text" class="form-control" id="bp" placeholder="<?php echo $bpp?>" value="<?php if (isset($_POST['bp'])) $buyingprice = $_POST['bp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Selling Price</label>
                            <input name="sp" type="text" class="form-control" id="sp" placeholder="<?php echo $spp?>" value="<?php if (isset($_POST['sp'])) $sellingprice = $_POST['sp'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discount</label>
                            <input name="dis" type="text" class="form-control" id="dis" placeholder="<?php echo $dp?>" value="<?php if (isset($_POST['dis'])) $discount = $_POST['dis'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input name="quantity" type="text" class="form-control" id="quantity" placeholder="<?php echo $qnt?>" value="<?php if (isset($_POST['quantity'])) $quantity = $_POST['quantity'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Re-Stock Level</label>
                            <input name="minquantity" type="text" class="form-control" id="minquantity" placeholder="<?php echo $minqnt?>" value="<?php if (isset($_POST['minquantity'])) $minquantity = $_POST['minquantity'];?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!--form operations-->
                    <?php
                    if (isset($error)) {
                        if (!empty($error)) {
                            echo '<ul><li>', @implode('</li><li>', $error), '</li></ul>';
                        } else {
                            $esellingprice=(0.33*$buyingprice)+$buyingprice;
                            $uqnt = $ingoingq+$quantity;
                            $stotal=$buyingprice*$uqnt;
                            //update query here
                            $insertQuery="UPDATE `stockmanagement`.`stock` SET `ProductName` = '".$sname."', `category` = '".$category."',`ExpiryDate` = '".$expirydate."',`BatchNumber` = '".$batchno."',`buyingprice` = '".$buyingprice."',`lsp` = '".$esellingprice."', `sellingprice` = '".$sellingprice."',`discount` = '".$discount."',`Quantity` = '".$uqnt."' ,`minquantity` = '".$minquantity."' , `ingoing` = '".$uqnt."' ,`supplier` = '".$supplier."' ,`total` = '".$stotal."',`intotal` = '".$stotal."' WHERE `stock`.`Stockid` =$usid;";
                            $mydb->insert($insertQuery);
                            header('Location:viewstock.php');//creation of the most wanted
                        }
                    }
                    ?>
                    <!--form operations-->

                </div>
            </section>
        </div>
        </div>
        <!--Main Table ends here-->
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
