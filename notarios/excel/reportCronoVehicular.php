<?php

$fechade = $_POST['fechade'];
$fecha=explode("/",$fechade);
$desde=$fecha[2]."-".$fecha[1]."-".$fecha[0];

$fechaa  = $_POST['fechaa'];
$fecha2=explode("/",$fechaa);
$hasta=$fecha2[2]."-".$fecha2[1]."-".$fecha2[0];

function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.', '.$num.' de '.$mes.' del '.$anno;
}
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}


if($_POST['fechade']!="" or $_POST['fechaa']!="") {
	
include("../conexion.php");
// include("../extraprotocolares/view/funciones.php");	

//Exportar datos de php a Excel

$tipoDocumento = $_POST['enviarrr'];
$extension = '';
if($tipoDocumento == 'EXCEL'){
	$extension = 'xls';
}else if($tipoDocumento == 'WORD'){
	$extension = 'doc';
}

header("Content-Description: File Transfer");  
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=INDICE_CRONOLOGICO_VEHICULAR_".$fecha2[2].".".$extension);
$consulta = mysql_query("SELECT fechaescritura,
								k.kardex,
								contrato,
								numescritura,
								numminuta,
								folioini, 
								CAST(numescritura AS SIGNED) AS numescritura2,
								p.importetrans as precio,
								m.simbolo as moneda,
								dv.numplaca as placa
	FROM kardex as k 
	LEFT JOIN patrimonial as p ON p.kardex=k.kardex AND p.idtipoacto = k.codactos
	LEFT JOIN monedas as m ON m.idmon=p.idmon
	LEFT JOIN detallevehicular as dv on dv.kardex=k.kardex AND dv.idtipacto = k.codactos
	WHERE k.idtipkar='3' and nc=0 and fechaescritura <> '' 
					   AND STR_TO_DATE(fechaescritura,'%Y-%m-%d') >= STR_TO_DATE('".$desde."','%Y-%m-%d') 
					   AND STR_TO_DATE(fechaescritura,'%Y-%m-%d') <= STR_TO_DATE('".$hasta."','%Y-%m-%d') order by numescritura2 asc,fechaescritura asc", $conn) or die(mysql_error());
					   

$confinotario=mysql_query("SELECT nombre,apellido,telefono,correo,ruc,direccion,distrito FROM confinotario",$conn);
$resnotario=mysql_fetch_assoc($confinotario);
$nombrenotario = $resnotario['nombre']." ".$resnotario['apellido'];
$direccion = $resnotario['direccion'];
$telefono = $resnotario['telefono'];
$correo = $resnotario['correo'];
$ruc = $resnotario['ruc'];
$distrito = $resnotario['distrito'];
?>
<HTML LANG="es">
<head>
<TITLE>::. Exportacion de Datos .::</TITLE>
<style>

table{
	font-family:Arial;
	font-size: 13px;
	width:100%;
	border-collapse:collapse;
}
</style>
</head>
<body>
<table border='0' cellpadding='0' cellspacing='0'>
<tr>
	<td colspan="7" align="center" style="font-size:18.5px"><b>INDICE CRONOLOGICO - REGISTRO DE TRANSFERENCIAS DE BIENES MUEBLES</b></td>
</tr>
<tr>
	<td colspan="7" align="center" style="font-size:18.5px"><b><?php echo utf8_decode('AÑO ').$fecha2[2];?></b></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td colspan="2" align="left"><b><span>NOTARIA</span></b></td>
	<td align="left"><span>: <?php echo $nombrenotario;?></span></td>
	<td></td>
	<td></td>
</tr>
<tr>
	<td colspan="2" align="left"><b><span>DIRECCION</span></b></td>
	<td align="left"><span>: <?php echo $direccion;?></span></td>
	<td align="right"><b>TELEFONO</b></td>
	<td colspan="3">: <?php echo $telefono;?></td>
</tr>
<tr>
	<td colspan="2" align="left"><b><span>DEPARTAMENTO</span></b></td>
	<td align="left"><span>: PUNO</span></td>
	<td align="right"><b>RUC</b></td>
	<td colspan="3">: <?php echo $ruc;?></td>
</tr>
<tr>
	<td colspan="2" align="left"><b><span>PROVINCIA</span></b></td>
	<td align="left"><span>: SAN ROMAN</span></td>
	<td align="right"><b><span>DESDE </span></b></td>
	<td colspan="3" align="left"><span>: <?php echo strtoupper(obtenerFechaEnLetra($desde));?></span></td>
</tr>
<tr>
	<td colspan="2" align="left"><b><span>DISTRITO</span></b></td>
	<td align="left"><span>: <?php echo $distrito;?></span></td>
	<td align="right"><b><span>HASTA</span></b></td>
	<td colspan="3" align="left"><span>: <?php echo strtoupper(obtenerFechaEnLetra($hasta)); ?></span></td>
</tr>
</table>
<br>
<table border="1" width="1000" align="center" cellpadding="0" cellspacing="0">       
		<tr>   
			<th align="center">ACTA</th>
			<th align="center">FECHA</th>
			<th align="center">VENDEDOR</th>
			<th align="center">COMPRADOR</th>
			<th align="center">ACTO JURIDICO</th>
			<th align="center">PLACA</th>
			<th align="center">NUM.FOLIO</th>
         </tr> 
<?php

while($row = mysql_fetch_array($consulta)){
	
	$kardex = $row['kardex'];
	$time = explode("-",$row['fechaescritura']);

	$query = "SELECT 
				c2.tipper,
				UPPER(CONCAT(c2.apepat,' ',c2.apemat,' ',c2.prinom,' ',c2.segnom)) AS nombre,
				cxa.idcontratante,
				UPPER(c2.razonsocial) AS empresa,
				cxa.parte,
				cxa.uif,
				(SELECT cxar.parte 
					FROM contratantesxacto AS cxar
					WHERE con.idcontratanterp = cxar.idcontratante AND  cxar.kardex = '$kardex' limit 1) as parte_representada
			FROM contratantesxacto AS cxa
			INNER JOIN contratantes AS con ON con.idcontratante=cxa.idcontratante
			INNER JOIN cliente2 AS c2 ON c2.idcontratante=con.idcontratante
			WHERE cxa.kardex = '$kardex' ORDER BY c2.tipper ASC";

	$otorgante = mysql_query($query, $conn) or die(mysql_error());
	$otorgado = mysql_query($query, $conn) or die(mysql_error());

	 $parte1='';
	 $parte2='';
	 while($row3 = mysql_fetch_array($otorgante)){
		 if($row3['parte']==1 || $row3['parte_representada']==1 || $row3['uif']=='O'){
			 
			$parte1.= ($row3['tipper']=='N')?utf8_decode($row3['nombre']).", ":utf8_decode($row3['empresa']).", ";

		 }		
	 }
 
	 while($row4 = mysql_fetch_assoc($otorgado)){
		 if($row4['parte']==2 || $row4['parte_representada']==2 || $row4['uif']=='B'){
			 
			$parte2 .= ($row4['tipper']=='N')?utf8_decode($row4['nombre']).", ":utf8_decode($row4['empresa']).", ";
			 
		 }
	 }

	 $reemplazados = array('/','DE VEHICULO AUTOMOTOR');
	 $arrIndices[] = array(
		 'numero_escritura' => $row['numescritura'],
		 'fecha' => $time[2] . "/" . $time[1] . "/" . $time[0],
		 'otorgante' => ($row['contrato']=='NO CORRE / ')?"NO CORRE":substr($parte1,0,-2),
		 'otorgado' => ($row['contrato']=='NO CORRE / ')?"NO CORRE":substr($parte2,0,-2),
		 'contrato' => str_replace($reemplazados,'',strtoupper($row['contrato'])),
		 'placa' => $row['placa'],
		 'folio' => $row['folioini'],
	 ); 

 }
 foreach($arrIndices as $value){
	 $html = "<tr>";
		 $html .= "<td align='center'>".$value['numero_escritura']."</td>";
		 $html .= "<td align='center'>".$value['fecha']."</td>";						
		 $html .= "<td>".$value['otorgante']."</td>";
		 $html .= "<td>".$value['otorgado']."</td>";
		 $html .= "<td>".$value['contrato']."</span></td>";
		 $html .= "<td style='white-space: nowrap;' align='right'>".strtoupper($value['placa'])."&nbsp;</td>";
		 $html .= "<td align='center'>".$value['folio']."</td>";
	 $html .=  "</tr>";

	 echo $html;
 }
?>
</table>
</body>
</html>
<?php
}else{
	echo "<script>window.location='../indicecrovehicular.php'</script>";	
}
?>


