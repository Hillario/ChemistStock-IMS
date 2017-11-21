<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/7/2017
 * Time: 7:30 AM
 */
require_once "MySql.php";

$mydb=new MySql();

if ($_SERVER["REQUEST_METHOD"]=="POST") {

    if (isset($_POST['due'])) $due = $_POST['due'];
    $error=array();
    if (empty($_POST["due"])) {
        $error[]='Please Enter the Amount Due';
    }
}


$querytotal="SELECT SUM(total) as ttl from temp";
$totalselect=$mydb->select($querytotal);
foreach ($totalselect as $row){
    $totaldue=$row['ttl'];
    $balance=$due-$totaldue;
}

$tinsertquery="INSERT INTO `tempa` (`tdue`, `balance`) VALUES ('".$totaldue."', '".$balance."');";
$tselect=$mydb->insert($tinsertquery);
header('Location:addoutgoing.php');


