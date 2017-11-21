<?php
require_once "header.php";
require_once "MySql.php";
$mydb=new MySql();

if(isset($_POST['iStockid']))
{
    $_SESSION['isid']=$_POST['iStockid'];

}
$isid=($_SESSION['isid']);

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['iquantity'])) $iquantity = $_POST['iquantity'];
    $error=array();
    if (empty($_POST["iquantity"])) {
        $error[]='Please update the Ingoing Quantity';
    }
}

$uQuery="select S.Stockid,S.ProductName,S.ExpiryDate,S.BatchNumber,S.buyingprice,S.sellingprice,I.IngoingQuantity FROM stock S,ingoingstock I WHERE S.Stockid=I.Stockid AND S.Stockid='$isid' AND S.Storeid='$sid'";
$suQuery=$mydb->select($uQuery);
foreach($suQuery as $row)
{
   $productname=$row['ProductName'];
   $myiQuantity=$row['IngoingQuantity'];
}

?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Update Ingoing Stock</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Update Ingoing Stock</li>
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
                    echo "Update Ingoing Stock on ".$productname;
                    ?>
                </header>
                <div class="panel-body">
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ingoing Quantity</label>
                            <input name="iquantity" type="text" class="form-control" id="iquantity" placeholder="<?php echo $myiQuantity?>" value="<?php if (isset($_POST['iquantity'])) $iquantity = $_POST['iquantity'];?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <!--form operations-->
                    <?php
                    if (isset($error)) {
                        if (!empty($error)) {
                            echo '<ul><li>', @implode('</li><li>', $error), '</li></ul>';
                        } else {

                            //update query here
                            $insertQuery="UPDATE `stockmanagement`.`ingoingstock` SET `IngoingQuantity` = '".$iquantity."' WHERE `ingoingstock`.`Stockid` =$isid;";
                            $mydb->insert($insertQuery);
                            header('Location:viewingoing.php');
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
