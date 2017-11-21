<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/7/2017
 * Time: 3:43 PM
 */
require_once "MySql.php";

$mydb=new MySql();
$deleteQuery="DELETE from tempstock";
$mydb->insert($deleteQuery);
header('Location:viewstock.php');