<?php 
include("../../conexion.php");

$sql =mysql_query("SELECT * FROM ingreso_cartas",$conn) or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../tcal.css" />
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../includes/css/uniform.default.min.css" />


<script language="JavaScript" type="text/javascript" src="../../ajax.js"></script>
<script type="text/javascript" src="../../tcal.js"></script> 
<script type="text/javascript" src="../includes/Mantenimientos.js"></script> 
<script src="../../includes/jquery-1.8.3.js"></script>
<script src="../../includes/js/jquery-ui-notarios.js"></script>
<script src="../../includes/jquery.uniform.min.js"></script>
<script type="text/javascript" src="../../tcal.js"></script> 
<script type="text/javascript" src="../../js/prototype.js"></script>
<script type="text/javascript" src="../ajax/caracteristicas.js"></script> 
<title>Listado de Caracteristicas</title>
<style type="text/css">
<!--
.titubuskar {
	font-family: Calibri;
	font-size: 12px;
	font-weight: bold;
	font-style: italic;
	color: #003366;
}
.titubuskar0 {font-family: Calibri; font-size: 12px; font-style: italic; font-weight: bold; color: #333333; }
.titubuskar1 {color: #333333}
.reskar2 {font-family: Calibri; font-size: 13px; font-weight: bold; font-style: italic; color: #003366; }
.reskar {font-size: 12px; font-style: italic; color: #333333; font-family: Calibri;}
-->
</style>

</head>

<body onload="buscar_caracteristicas(1)">


<form id="frm_buscarcaracteristicas" name="frm_buscarcaracteristicas" method="post" action="">
<table width="840" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="9">
				<table >
						<tr>
							<td width="398" height="35"><span class="reskar2">Busqueda Por:</span></td>
							<td width="412"><span class="reskar2">Seleccione fecha :</span></td>
						</tr>
				</table>
			</td>
		</tr>
		<tr >
			<td width="68">
				<span class="titubuskar0">N° Crono :</span>	
			</td>
			<td width="100">
				<input id="num_crono" name="num_crono" type="text"  size="10" maxlength="11">
			</td>
			<td width="68">
				<span class="titubuskar0">Solicitante :</span>
			</td>
			<td width="167">
				<input id="solicitante" name="solicitante" type="text" size="20" maxlength="70"/>
			</td>
			<td width="53">
				<span class="titubuskar0">Desde</span>:
			</td>
			<td width="118">
				<input id="rango1" name="rango1" type="text" class="tcal" style="text-transform:uppercase"  size="10" readonly="readonly" />
			</td>
			<td width="43">
				<span class="titubuskar0">Hasta</span>:
			</td>
			<td width="113">
				<input id="rango2" name="rango2" type="text" class="tcal" style="text-transform:uppercase"  size="10" readonly="readonly"/>
			</td>
			<td width="110">
				<a onclick="buscar_caracteristicas(1)"><img src="../../iconos/buscarclie.png" width="72" height="29" border="0" /></a>
			</td>
		</tr>
		<tr>
	        <td colspan="9">-------------------------------------------------------------------------------------------------------------------------------------------------------</td>
	    </tr>
	    <tr>
	    	<td colspan="9">
	    		<div id="lista_caracteristicas"></div>
	    	</td>
	    </tr>
</table>
</form>




</body>
</html>