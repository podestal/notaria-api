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
    $resultado=str_replace("QQ22KK"," ",$dato19); 
    return $resultado;	
}
$sqlarchi = "SELECT * FROM confinotario where idnotar='1'";
$resultarchi=mysql_query($sqlarchi,$conn);
$rowarchi = mysql_fetch_array($resultarchi);
$ano=date('Y');

$archivo = "3520".$ano.$rowarchi['ruc'].".Bie";
/*
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename='.$archivo);
header('Content-Transfer-Encoding: binary');
header('Content-Length: '.filesize($archivo));
*/
header('Content-Type:text/plain'); // txt, html, etc
header('Content-Type: application/force-download');
header('Pragma:public');
header('Expires:0');
header('Cache-Control:no-cache,must-revalidate,post-check=0,pre-check=0');
header('Cache-Control:private,false');
header('Content-Disposition: attachment; filename='.$archivo);
header('Content-Transfer-Encoding: utf8'); 
 

$nittem="";
$secuencial=0;
$sql = "SELECT * FROM temp_act";
$detalle="select * from detallevehicular";
$result=mysql_query($sql,$conn);
while($row = mysql_fetch_array($result)) {
	
	$sqldetalle="select * from detallevehicular where kardex='".$row['kardex']."'";
	$resultdet=mysql_query($sqldetalle,$conn);
	$valor=mysql_num_rows($resultdet);
    $cantidad=intval($valor);
	
	while($rowdet = mysql_fetch_array($resultdet)) {
     
     $sql2="select * from tipobien where idtipbien='8'"; 
		$result2=mysql_query($sql2,$conn); 
		$row2 = mysql_fetch_array($result2);
		
		$kardex=$row["kardex"];
		
			if ($row["idtipkar"]==1){
				$tipokardex= '1';			
			}else{
				if ($row["idtipkar"]==3){
					$tipokardex= '2';				
				}else{
					$tipokardex= $row["idtipkar"];
					}
				}
		
		
		if ($row["idtipkar"]=3)
				{
					
			if ($rowdet["numplaca"]<>""){
				$opcion= '1';
				$numplaca=$rowdet["numplaca"];				
			}else{
				if ($rowdet["numserie"]<>""){
					$opcion= '2';
					$numplaca=$rowdet["numserie"];				
				}else{
						$opcion= '3';
						$numplaca=$rowdet["motor"];	
					 }
				}	
					
					$tipobien='B';	
					$opciones='1';
					$ubica='';
					$origenbien='';
					$codibien='09';
					$descrip='';
					$tipokarde='2';
					$numeroescritura=$row["numescritura"]; $fechaescri=$row["fechaescritura"]; 
					$secuacto=$row["secuencialacto"];  
					$codbien=$row2["codbien"]; $numserie='';  $fechacons=$rowdet['fecinsc'];  $tempo="T";
					//$numplaca=$rowdet["numplaca"];
					//$numplaca='placa';
					$secuencial=$secuencial+1; 
				}
		
		/*
		if ($row["idtipkar"]=1)
			{
				if ($rowdet['tipob']=="BIENES"){
				$tipobien="B";
				}else{
				$tipobien="A";	
					}
								
					$opciones=$rowdet['tpsm'];
					switch ($opciones) {
					case "P":
					$opcion="1";
					break;
					case "S":
					$opcion="2";	
					break;
					case "M":
					$opcion="3";
					break;
					case "":
					$opcion="";	
					break;							
								 }
					$ubicas=$rowdet['coddis'];
				if($ubicas!=''){
				$ubica=$rowdet['coddis'];
				}else{$ubica='';}	
				if($ubica!=""){
				$codibien=$row2["codbien"];
				if($codibien=='04' || $codibien=='99'){
				$origenbien="1"; 
					}else{
				$origenbien="";
					}
				}else{
				$origenbien="";
					}
				if($row2["codbien"]=='99'){
				$descrip=$rowdet['oespecific']; 
				}else{
				$descrip="";
					}			
						
					$numero=$rowdet['npsm']; $kardex=$row["kardex"];
					$numeroescritura=$row["numescritura"]; $fechaescri=$row["fechaescritura"]; 
					$secuacto=$row["secuencialacto"];  
					$codbien=$row2["codbien"]; $numserie=$rowdet['smaquiequipo'];  $fechacons=$rowdet['fechaconst'];  $tempo="T";
					$secuencial=$secuencial+1; 
			}
		*/
		
		echo str_pad(substr(intval($tipokardex),0,1),1," ",STR_PAD_RIGHT)."|".str_pad(substr(intval($numeroescritura),0,5),5," ",STR_PAD_RIGHT)."|".str_pad(substr($fechaescri,0,10),10," ",STR_PAD_RIGHT)."|".str_pad(substr($secuacto,0,5),5," ",STR_PAD_RIGHT)."|".str_pad(substr($secuencial,0,5),5," ",STR_PAD_RIGHT)."|".str_pad(substr($tipobien,0,1),1," ",STR_PAD_RIGHT)."|".str_pad(substr($codbien,0,2),2," ",STR_PAD_RIGHT)."|".str_pad(substr($opcion,0,1),1," ",STR_PAD_RIGHT)."|".str_pad(substr($numplaca,0,20),20," ",STR_PAD_RIGHT)."|".str_pad(substr(quitar_sim($numserie),0,20),20," ",STR_PAD_RIGHT)."|".str_pad(substr(quitar_sim($origenbien),0,1),1," ",STR_PAD_RIGHT)."|".str_pad(substr($ubica,0,6),6," ",STR_PAD_RIGHT)."|".str_pad(substr($fechacons,0,10),10," ",STR_PAD_RIGHT)."|".str_pad(substr(quitar_sim($descrip),0,30),30," ",STR_PAD_RIGHT)."|".chr(13).chr(10);
		
	 mysql_query("INSERT INTO temp_bie(idbie, kardex, idtipkar, numescritura, fechaescrituracion, secuacto, secubien, tipobien, codbien, nopcion, npsm, numserie, oriegenbien, ubibien, fechaadd, descrip, flag) 
	 VALUES (NULL,'".$kardex."','".$tipokardex."','".$numeroescritura."','".$fechaescri."','".$secuacto."','".$secuencial."','".$tipobien."','".$codbien."','".$opcion."','".$numplaca."','".$numserie."','".$origenbien."','".$ubica."','".$fechacons."','".$descrip."','".$tempo."')",$conn); 
	 	 

      }
}
mysql_free_result($result);
mysql_close($conn);
?>