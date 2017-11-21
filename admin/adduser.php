<?php
require_once "header.php";
require_once "MySql.php";

$mydb=new MySql();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $fname=trim($_POST['fname']);
    $mname=trim($_POST['mname']);
    $lname=trim($_POST['lname']);
    $email=trim($_POST['email']);
    $npass=trim($_POST['npass']);
    $confpass=trim($_POST['confpass']);
    $phone=trim($_POST['phone']);
    $address=trim($_POST['address']);


    if (isset($_POST['fname'])) $fname = $_POST['fname'];
    if (isset($_POST['mname'])) $mname = $_POST['mname'];
    if (isset($_POST['lname'])) $lname = $_POST['lname'];
    if (isset($_POST['email'])) $email = $_POST['email'];
    if (isset($_POST['npass'])) $npass = $_POST['npass'];
    if (isset($_POST['confpass'])) $confpass = $_POST['confpass'];
    if (isset($_POST['phone'])) $phone = $_POST['phone'];
    if (isset($_POST['address'])) $address = $_POST['address'];

    $error=array();
    if (empty($_POST["fname"])) {
        $error[]='Please update first name';
    }
    if (empty($_POST["mname"])) {
        $error[]='Please update middle name';
    }
    if (empty($_POST["lname"])) {
        $error[]='Please update last name';
    }
    if (empty($_POST["email"])) {
        $error[]='Please update email';
    }
    if (empty($_POST["npass"])) {
        $error[]='Please enter new password';
    }
    if (empty($_POST["confpass"])) {
        $error[]='Please confirm new password';
    }
    if (empty($_POST["phone"])) {
        $error[]='Please update Phone Number';
    }
    if (empty($_POST["address"])) {
        $error[]='Please update address';
    }
}
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!--overview start-->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Add User</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-laptop"></i>Add User</li>
                </ol>
            </div>
        </div>
        <!--END-->
        <!-- project team & activity end -->
        <!--Main Form starts here-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading">
                    Add User
                </header>
                <div class="panel-body">
                    <form role="form" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name" value="<?php if (isset($_POST['fname'])) $fname = $_POST['fname'];?>" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Middle Name</label>
                                <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name" value="<?php if (isset($_POST['mname'])) $mname = $_POST['mname'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" value="<?php if (isset($_POST['lname'])) $lname = $_POST['lname'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php if (isset($_POST['email'])) $email = $_POST['email'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="<?php if (isset($_POST['phone'])) $phone = $_POST['phone'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                                <input type="password" class="form-control" id="npass" name="npass" placeholder="Your new password" value="<?php if (isset($_POST['npass'])) $npass = $_POST['npass'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password</label>
                                <input type="password" class="form-control" id="confpass" name="confpass" placeholder="Confirm New Password " value="<?php if (isset($_POST['confpass'])) $confpass = $_POST['confpass'];?>">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                                <input name="address" type="text" class="form-control" id="address" placeholder="Enter Address" value="<?php if (isset($_POST['address'])) $address = $_POST['address'];?>">

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <!--form operations-->
                    <?php
                    if (isset($error)) {
                        if (!empty($error)) {
                            echo '<ul style="color: red"><li>', @implode('</li><li>', $error), '</li></ul>';
                        } else {
                            //password validation
                            if(strlen(trim($_POST['npass']))>=6 && strlen(trim($_POST['confpass']))>=6 && trim($_POST['npass'])==trim($_POST['confpass'])) {
                                //update query here
                                $insertQuery = "INSERT INTO `user` (`Userid`, `FirstName`, `MiddleName`, `LastName`, `Email`, `Password`, `Phone`, `Address`, `Storeid`) VALUES (NULL, '".$fname."', '".$mname."', '".$lname."', '".$email."', '".$npass."', '".$phone."', '".$address."', '1');";
                                $mydb->insert($insertQuery);
                                echo "Successfully Added";
                            }else
                            {
                                $error[]="Check if password matches and is more than 6 characters.";
                                echo '<ul style="color:red;"><li>', @implode('</li><li>', $error), '</li></ul>';
                            }
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
