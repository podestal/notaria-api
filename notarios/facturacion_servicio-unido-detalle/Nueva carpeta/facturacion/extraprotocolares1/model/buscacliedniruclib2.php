<?php 
include("../../conexion.php");
$tipoper = $_POST['tipoper'];
$numdoc  = $_POST['numdoc'];
$tip_poder = $_POST['tip_poder'];
$idtipdoc = $_POST['idtipdoc'];



$sqlclie=mysql_query("SELECT * FROM cliente WHERE  numdoc='".$numdoc."' AND tipper='".$tipoper."' AND idtipdoc='".$idtipdoc."'", $conn) or die(mysql_error());
$row=mysql_fetch_array($sqlclie);
if (!empty($row)){
	 if ($row['tipper']=="N"){
		 include("../view/mostrarclientelib2.php");
		}else{ 
		  include ("../view/mostrarempresalib2.php");} 
}else{
    if ($tipoper!="N"){
	  echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encontro la empresa :</span> <a onClick='newclientempresa()'><img src='../../iconos/newcliente.png' width='134' height='28' border='0'></a>"; 
	 }else{
	  echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encontro al cliente :</span><a onClick='newclient()'> <img src='../../iconos/newcliente.png' width='134' height='28' border='0'></a>";
	 }
}

?>