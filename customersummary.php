<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/7/2017
 * Time: 6:00 AM
 */
require_once "MySql.php";
$mydb=new MySql();
        //form operations
        $deleteQuery="DELETE From temp";
        $deleteQuery2="DELETE From tempa";
        $mydb->insert($deleteQuery);
        $mydb->insert($deleteQuery2);

$tinsertquery="INSERT INTO `tempa` (`tdue`, `balance`) VALUES ('0', '0');";
$tselect=$mydb->insert($tinsertquery);
header('Location:viewoutgoing.php');
