<?php 
include("../../conexion.php");
$tipodocumen=$_POST['_num_carta'];
$numdoc=$_POST['_num_doc'];




	$sqlclie=mysql_query("select * from cliente where  numdoc='$numdoc' and idtipdoc='$tipodocumen'", $conn) or die(mysql_error());
	$row=mysql_fetch_array($sqlclie);
	if (!empty($row) ){
		 if ($row['tipper']=="N" and $row['numdoc']!=""){
			 include("mostrarclientecardestinatario.php");
			}else{ 
				if ($row['tipper']=="N" and $row['numdoc']==""){
			echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra al cliente :</span><input name='nuevo' type='button' onclick='newclient();' value='Nuevo Cliente' /><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />";
			//  echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra al cliente :</span><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />";
				}
			  } 
		 
	   if ($row['tipper']=="J" and $row['numdoc']!=""){
			 include ("mostrarclientecar2.php");
			}else{ 
				if ($row['tipper']=="J" and $row['numdoc']==""){
			echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra la empresa :</span><input name='cancelar2' type='button' onclick='newclientempresa();' value='Nueva Empresa' /><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />"; 
				//  echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra la empresa :</span><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />"; 
				}
	
			  }
		
	}else{
		if ($tipodocumen=="8"){
		 echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra la empresa :</span><input name='cancelar2' type='button' onclick='newclientempresa();' value='Nueva Empresa' /><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />"; 
			//  echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra la empresa :</span><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />"; 
		
		}else{
		 echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra al cliente :</span><input name='nuevo' type='button' onclick='newclient();' value='Nuevo Cliente' /><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />";
		//   echo"<span style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;'>No se encuentra al cliente :</span><input name='cancelar' type='button' onclick='regresa_caja2();' value='Cancelar' />";
		 }
	}






 
?>
