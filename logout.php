<?php
require "core.php";
//echo($http_refer);
session_destroy();
echo('Redirecting...');
header('Location:login.php');
?>
