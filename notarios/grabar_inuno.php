<?php 
include("conexion.php");

$codkardex = $_POST['codkardex'];
$no = $_POST['no'];
mysql_query("UPDATE rouif SET uni='$no' WHERE kardex='".$codkardex ."'",$conn) or die(mysql_error());


?>