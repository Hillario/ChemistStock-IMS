<?php
require_once "header.php";
require_once "MySql.php";

$mydb=new MySql();

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $fname=trim($_POST['fname']);
    $mname=trim($_POST['mname']);
    $lname=trim($_POST['lname']);
    $email=trim($_POST['email']);
    $cpass=trim($_POST['cpass']);
    $npass=trim($_POST['npass']);
    $confpass=trim($_POST['confpass']);
    $phone=trim($_POST['phone']);
    $address=trim($_POST['address']);

    if (isset($_POST['fname'])) $fname = $_POST['fname'];
    if (isset($_POST['mname'])) $mname = $_POST['mname'];
    if (isset($_POST['lname'])) $lname = $_POST['lname'];
    if (isset($_POST['email'])) $email = $_POST['email'];
    if (isset($_POST['cpass'])) $cpass = $_POST['cpass'];
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
    if (empty($_POST["cpass"])) {
        $error[]='Please enter current password';
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
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-user-md"></i> Profile</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                    <li><i class="fa fa-user-md"></i>Profile</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <!-- profile-widget -->
            <div class="col-lg-12">
                <div class="profile-widget profile-widget-info">
                    <div class="panel-body">
                        <div class="col-lg-2 col-sm-2">
                            <h4><?php echo $un1." ".$un2?></h4>
                            <div class="follow-ava">
                                <img src="img/user.png" alt="">
                            </div>
                            <h6>Cashier</h6>
                        </div>
                        <div class="col-lg-4 col-sm-4 follow-info">
                            <?php
                            //get admin data from database
                            $doctorQuery="SELECT * FROM user WHERE Userid='".$uid."'";
                            $doctorSelect=$mydb->select($doctorQuery);
                            foreach ($doctorSelect as $row)
                            {
                                $fn=$row['FirstName'];
                                $mn=$row['MiddleName'];
                                $ln=$row['LastName'];
                                $em=$row['Email'];
                                $ps=$row['Password'];
                                $ph=$row['Phone'];
                                $rs=$row['Address'];
                            }
                            ?>
                            <p>Profile details of user with priviledges as a cashier</p>
                            <p><?php echo $em;?></p>
                            <h6>
                                <span><i class="icon_house_alt"></i>Address: <?php echo $rs;?></span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading tab-bg-info">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#profile">
                                    <i class="icon-home"></i>
                                    Profile
                                </a>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#edit-profile">
                                    <i class="icon-envelope"></i>
                                    Edit Profile
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <!--profile-->
                            <div id="profile" class="tab-pane active">
                                <section class="panel">
                                    <div class="bio-graph-heading">
                                        Generic summary of cashier details as updated in the database in respect to time and location.
                                    </div>
                                    <div class="panel-body bio-graph-info">
                                        <h1>Bio Graph</h1>
                                        <div class="row">
                                            <div class="bio-row">
                                                <p><span>First Name </span>: <?php echo $fn;?> </p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Middle Name </span>: <?php echo $mn;?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Last Name </span>: <?php echo $ln;?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Phone</span>: <?php echo $ph;?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Email </span>: <?php echo $em;?></p>
                                            </div>
                                            <div class="bio-row">
                                                <p><span>Address</span>: <?php echo $rs;?></p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="row">
                                    </div>
                                </section>
                            </div>
                            <!-- edit-profile -->
                            <div id="edit-profile" class="tab-pane">
                                <section class="panel">
                                    <div class="panel-body bio-graph-info">
                                        <h1> Update Profile Info</h1>
                                        <form class="form-horizontal" role="form" method="post" action="#edit-profile">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">First Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="<?php echo $fn;?> " value="<?php if (isset($_POST['fname'])) $fname = $_POST['fname'];?>" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Middle Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="<?php echo $mn;?> " value="<?php if (isset($_POST['mname'])) $mname = $_POST['mname'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Last Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="<?php echo $ln;?> " value="<?php if (isset($_POST['lname'])) $lname = $_POST['lname'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="exampleInputEmail1">Address</label>
                                                <div class="col-lg-6">
                                                    <input name="address" type="text" class="form-control" id="address" placeholder="<?php echo $rs;?>" value="<?php if (isset($_POST['address'])) $address = $_POST['address'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Current Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control" id="cpass" name="cpass" placeholder="<?php echo $ps;?> " value="<?php if (isset($_POST['cpass'])) $cpass = $_POST['cpass'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">New Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control" id="npass" name="npass" placeholder="Your new password" value="<?php if (isset($_POST['npass'])) $npass = $_POST['npass'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Confirm Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" class="form-control" id="confpass" name="confpass" placeholder="Confirm New Password " value="<?php if (isset($_POST['confpass'])) $confpass = $_POST['confpass'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Phone</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo $ph;?> " value="<?php if (isset($_POST['phone'])) $phone = $_POST['phone'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $em;?> " value="<?php if (isset($_POST['email'])) $email = $_POST['email'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                </div>
                                            </div>
                                            <!--form operations-->
                                            <?php
                                            if (isset($error)) {
                                                if (!empty($error)) {
                                                    echo '<ul style="color: red"><li>', @implode('</li><li>', $error), '</li></ul>';
                                                } else {
                                                    //password validation
                                                    if(trim($_POST['cpass'])==$ps && strlen(trim($_POST['npass']))>=6 && strlen(trim($_POST['confpass']))>=6 && trim($_POST['npass'])==trim($_POST['confpass'])) {
                                                        //update query here
                                                        $insertQuery = "UPDATE `stockmanagement`.`user` SET `FirstName` = '" . $fname . "', `MiddleName` = '" . $mname . "', `LastName` = '" . $lname . "',`Phone` = '" . $phone . "',`Email` = '" . $email . "', `Password` = '" . $npass . "',`Address` = '" . $address . "', WHERE `stockmanagement`.`Userid` =$uid;";
                                                        $mydb->insert($insertQuery);
                                                        echo "Successfully Updated";
                                                    }else
                                                    {
                                                        $error[]="Check if password matches and is more than 6 characters.";
                                                        echo '<ul style="color:red;"><li>', @implode('</li><li>', $error), '</li></ul>';
                                                    }
                                                }
                                            }
                                            ?>
                                            <!--form operations-->
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>
<!--main content end-->
</section>
<!-- container section end -->
<!-- javascripts -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- jquery knob -->
<script src="assets/jquery-knob/js/jquery.knob.js"></script>
<!--custome script for all page-->
<script src="js/scripts.js"></script>

<script>

    //knob
    $(".knob").knob();

</script>


</body>
</html>
