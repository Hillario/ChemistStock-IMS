<?php
require_once "header.php";
require_once "MySql.php";
$mydb=new MySql();

if(isset($_POST['mySupplierid']))
{
    $_SESSION['spid']=$_POST['mySupplierid'];

}
$spid=($_SESSION['spid']);

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['spname'])) $spname = $_POST['spname'];
    if (isset($_POST['email'])) $email = $_POST['email'];
    if (isset($_POST['phone'])) $phone = $_POST['phone'];
    if (isset($_POST['address'])) $address = $_POST['address'];
    $error=array();
    if (empty($_POST["spname"])) {
        $error[]='Please update supplier name';
    }
    if (empty($_POST["email"])) {
        $error[]='Please update supplier email';
    }
    if (empty($_POST["phone"])) {
        $error[]='Please update phone';
    }
    if (empty($_POST["address"])) {
        $error[]='Please update supplier address';
    }
}

$uQuery="SELECT * from supplier where Supplierid='$spid'";
$suQuery=$mydb->select($uQuery);
foreach($suQuery as $row)
{
    $myspid=$row['Supplierid'];
    $myname=$row['Name'];
    $myemail=$row['Email'];
    $myphone=$row['Phone'];
    $myaddress=$row['Address'];
}

?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Update Supplier</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Update Supplier</li>
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
                    echo "Update ".$myname;
                    ?>
                </header>
                <div class="panel-body">
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input name="spname" type="text" class="form-control" id="spname" placeholder="<?php echo $myname?>" value="<?php if (isset($_POST['spname'])) $spname = $_POST['spname'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="<?php echo $myemail?>" value="<?php if (isset($_POST['email'])) $email = $_POST['email'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input name="phone" type="text" class="form-control" id="phone" placeholder="<?php echo $myphone?>" value="<?php if (isset($_POST['phone'])) $phone = $_POST['phone'];?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input name="address" type="text" class="form-control" id="address" placeholder="<?php echo $myaddress?>" value="<?php if (isset($_POST['address'])) $address = $_POST['address'];?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!--form operations-->
                    <?php
                    if (isset($error)) {
                        if (!empty($error)) {
                            echo '<ul><li>', @implode('</li><li>', $error), '</li></ul>';
                        } else {

                            //update query here
                            $insertQuery="UPDATE `stockmanagement`.`supplier` SET `Name` = '".$spname."',`Email` = '".$email."',`Phone` = '".$phone."',`Address` = '".$address."' WHERE `supplier`.`Supplierid` =$spid;";
                            $mydb->insert($insertQuery);
                            header('Location:viewsupplier.php');
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
