<?php
require 'core.php';
include 'MySql.php';

//instantiate database

$db=new MySql();
if (loggedin()) {
    header('Location:index.php');
}
else{
    $message='';
    $user="";
}


if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['email']) && isset($_POST['_password'])) {
        $email= $_POST['email'];
        $_password= ($_POST['_password']);

        $dbQuery="SELECT * FROM `user` WHERE Email='$email' AND password='$_password'";

        if (!empty($email) && !empty($_password)) {
            $dbSelect=$db->select($dbQuery);

            if(count($dbSelect)==0){
                $message="invalid email/password combination";
            }
            else if (count($dbSelect)==1) {
                foreach($dbSelect as $row)
                {
                    $userf=$row['FirstName'];
                    $userl=$row['LastName'];
                    $uid=$row['Userid'];
                    $sid=$row['Storeid'];
                }
                $_SESSION['userf']= $userf;
                $_SESSION['userl']=$userl;
                $_SESSION['uid']=$uid;
                $_SESSION['sid']=$sid;
                header('Location:index.php');
            }
        }
        else{
            $message="You must enter email and password";
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Creative Stock Management System</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-img3-body">

<div class="container">

    <form class="login-form" action="" method="post">
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_profile"></i></span>
                <input name="email" type="text" class="form-control" placeholder="Email" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input name="_password" type="password" class="form-control" placeholder="Password">
            </div>
            <?php
            if (($message!="")) {
                echo "Error:",($message);
            }
            ?>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
            </label>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
        </div>
    </form>

</div>


</body>
</html>
