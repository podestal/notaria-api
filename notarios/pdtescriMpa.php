<?php
include('conexion.php');
function quitar_sim($dato){
	$dato1=str_replace("?"," ",$dato);
    $dato2=str_replace("*"," ",$dato1);
    $dato3=str_replace("QQ11QQ"," ",$dato2);
	$dato4=str_replace("Ñ","N",$dato3);
	$dato5=str_replace("ñ","n",$dato4);
	$dato6=str_replace("°"," ",$dato5);
	$dato7=str_replace("#"," ",$dato6);
	$dato8=str_replace("é"," ",$dato7);
	$dato9=str_replace("á"," ",$dato8);
	$dato10=str_replace("í"," ",$dato9);
	$dato11=str_replace("ó"," ",$dato10);
	$dato12=str_replace("ú"," ",$dato11);
	$dato13=str_replace("'"," ",$dato12);
	$dato14=str_replace("&"," ",$dato13);
	$dato15=str_replace("É"," ",$dato14);
	$dato16=str_replace("Á"," ",$dato15);
	$dato17=str_replace("Ó"," ",$dato16);
	$dato18=str_replace("Ú"," ",$dato17);
	$dato19=str_replace("Í"," ",$dato18);
	$dato20=str_replace("."," ",$dato19);
	$dato21=str_replace("-","",$dato20);
    $resultado=str_replace("QQ22KK"," ",$dato21); 
    return $resultado;	
}
$sqlarchi = "SELECT * FROM confinotario where idnotar='1'";
$resultarchi=mysql_query($sqlarchi,$conn);
$rowarchi = mysql_fetch_array($resultarchi);
$ano=date('Y');

$archivo = "3520".$ano.$rowarchi['ruc'].".Mpa";
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename='.$archivo);
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.filesize($archivo));
 
include($archivo);



$sql = "SELECT * FROM temp_act";
$result=mysql_query($sql,$conn);
while($row = mysql_fetch_array($result)) {
	
	$sqldetalle="select * from detallemediopago where itemmp='".$row['itemmp']."' and codmepag <> '95' and codmepag <> '96' and codmepag <> '98' and codmepag <> '15' and codmepag <> '16'";
	$resultdet=mysql_query($sqldetalle,$conn);
	while($rowdet = mysql_fetch_array($resultdet)) {
		
     if($rowdet["tipacto"]=='028' || $rowdet["tipacto"]=='029' || $rowdet["tipacto"]=='105' || $rowdet["tipacto"]=='030' || $rowdet["tipacto"]=='107' || $rowdet["tipacto"]=='108' || $rowdet["tipacto"]=='110' || $rowdet["tipacto"]=='111' || $rowdet["tipacto"]=='112' || $rowdet["tipacto"]=='113' || $rowdet["tipacto"]=='094' || $rowdet["tipacto"]=='106' || $rowdet["tipacto"]=='068' || $rowdet["tipacto"]=='061' || $rowdet["tipacto"]=='064' || $rowdet["tipacto"]=='041'){
        $sql2="select * from mediospago where codmepag='".$rowdet['codmepag']."'"; 
		$result2=mysql_query($sql2,$conn); 
		$row2 = mysql_fetch_array($result2);
		
		//if($row2['codmepag']!='15' || $row2['codmepag']!='16' || $row2['codmepag']!='95' || $row2['codmepag']!='96' || $row2['codmepag']!='98' ){
		$money=$rowdet['idmon'];
		switch ($money) {
		case "1":
		$moneda="2";
		$importe=$rowdet["importemp"];
		break;
		case "2":
		$moneda="1";	
		$importe=$rowdet["importemp"];
		break;					
	     }

		$sqlb="select * from bancos where idbancos='".$rowdet['idbancos']."'"; 
		$resultb=mysql_query($sqlb,$conn); 
		$rowb = mysql_fetch_array($resultb);	
				
				if ($row["idtipkar"]==1){
				$tipokardex= '1';			
			}else{
				if ($row["idtipkar"]==3){
					$tipokardex= '2';				
				}else{
					$tipokardex= $row["idtipkar"];
					}
				}
		
		$numeroescritura=$row["numescritura"]; $secuacto=$row["secuencialacto"];   
		$codpag=$row2["sunat"]; $fechapago=$rowdet["foperacion"]; $numdocumento=$rowdet["documentos"]; $banco=$rowb['codbancos'];
		
		
		echo str_pad(substr(intval($tipokardex),0,1),1," ",STR_PAD_LEFT)."|".str_pad(substr(intval($numeroescritura),0,5),5," ",STR_PAD_LEFT)."|".str_pad(substr($secuacto,0,5),5," ",STR_PAD_RIGHT)."|".str_pad(substr($codpag,0,3),3," ",STR_PAD_RIGHT)."|".str_pad(substr($moneda,0,1),1," ",STR_PAD_RIGHT)."|".str_pad(substr($importe,0,15),15," ",STR_PAD_RIGHT)."|".str_pad(substr($fechapago,0,10),10," ",STR_PAD_RIGHT)."|".str_pad(substr(quitar_sim($numdocumento),0,25),25," ",STR_PAD_RIGHT)."|".str_pad(substr($banco,0,2),2," ",STR_PAD_RIGHT)."|".chr(13).chr(10);
		   
	/*	mysql_query("INSERT INTO temp_mpa(idmpa, idtipkar, numescritura, secuencialacto, sunat, idmon, importemp, foperacion, documentos, codbancos) VALUES (NULL,'".$tipokardex."','".$numeroescritura."','".$secuacto."','".$codpag."','".$moneda."','".$importe."','".$fechapago."','".$numdocumento."','".$banco."')",$conn); */
         }
	  
	 }
}
mysql_free_result($result);
mysql_close($conn);
?>