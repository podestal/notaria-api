<?php 

include("conexion.php");

$tipper=$_POST['tipoper'];
$razonsocialrecep=strtoupper($_POST['razonsocial']);
$cabioapostro=str_replace("'","?",$razonsocialrecep);
$razonsocial=strtoupper(str_replace("ñ","Ñ",$cabioapostro));

$cabioapostro2=str_replace("*","&",$razonsocialrecep);
$razonsocial2=strtoupper(str_replace("ñ","Ñ",$cabioapostro2));

$domfiscaltexto=$_POST['domfiscal'];
$cabioapostro2=str_replace("'","?",$domfiscaltexto);
$domfiscal=strtoupper(str_replace("ñ","Ñ",$cabioapostro2));

$cabioapostro3=str_replace("*","&",$domfiscaltexto);
$domfiscal2=strtoupper($cabioapostro3);

$telempresa=$_POST['telempresa'];
$mailempresa=$_POST['mailempresa'];
$contacempresa=strtoupper($_POST['contacempresa']);

if (strpos($_POST['numdoc'], 'CODJU') !== false) {

    $queryCodJuridica = "SELECT COUNT(numdoc_plantilla)+1 AS numdoc FROM cliente WHERE numdoc_plantilla LIKE '%CODJU%'";
    $CodJuridica = mysql_query($queryCodJuridica,$conn);
    $totalCodJuridica = mysql_fetch_assoc($CodJuridica);
    $codJuridica = 'CODJU'.str_pad($totalCodJuridica['numdoc'], 6, '0', STR_PAD_LEFT);
    $numdoc = '';
    $numDocPlantilla = $codJuridica;
    $idtipdoc=intval("10");

}else{
    $numdoc = $_POST['numdoc'];
    $numDocPlantilla = '';
    $idtipdoc=intval("8");
}

//$idtipdoc=intval("8");
//$numdoc=$_POST['numdoc'];
$fechaconstitu=$_POST['fechaconstitu'];
$numregistro=$_POST['numregistro'];
$numpartida=$_POST['numpartida'];
$actmunicipal=strtoupper($_POST['actmunicipal']);
$codubi=$_POST['codubi'];
$idsedereg3=$_POST['idsedereg3'];

$consulclien=mysql_query("Select * from cliente order by idcliente DESC LIMIT 1", $conn) or die(mysql_error());

$rowclin = mysql_fetch_array($consulclien);

$numeroc=$rowclin['idcliente'];
$sumac= intval($numeroc) + 1;
$cantidadc= strlen($sumac);


 switch ($cantidadc) {
	case "1":
	$ncliente="000000000".$sumac;
	break;
	case "2":
	$ncliente="00000000".$sumac;	
	break;
	case "3":
	$ncliente="0000000".$sumac;
	break;
	case "4":
	$ncliente="000000".$sumac;	
	break;
	case "5":
	$ncliente="00000".$sumac;
	break;
	case "6":
	$ncliente="0000".$sumac;	
	break;		
	case "7":
	$ncliente="000".$sumac;	
	break;	
	case "8":
	$ncliente="00".$sumac;	
	break;	
	case "9":
	$ncliente="0".$sumac;	
	break;
	case "10":
	$ncliente=$sumac;	
	break;			
}

$grabarempresac="INSERT INTO cliente (idcliente, tipper, apepat, apemat, prinom, segnom, nombre, direccion, idtipdoc, numdoc, email, telfijo, telcel, telofi, sexo, idestcivil, natper, conyuge, nacionalidad, idprofesion, detaprofesion, idcargoprofe, profocupa, dirfer, idubigeo, cumpclie, fechaing, razonsocial, domfiscal, telempresa, mailempresa, contacempresa, fechaconstitu, idsedereg, numregistro, numpartida, actmunicipal, tipocli, impeingre, impnumof, impeorigen, impentidad, impremite, impmotivo,residente,docpaisemi,numdoc_plantilla) VALUES ('$ncliente','$tipper','','','','','','','$idtipdoc','$numdoc','','','','','',0,'','','0',0,'','0','','','$codubi','','','$razonsocial','$domfiscal','$telempresa','$mailempresa','$contacempresa','$fechaconstitu','$idsedereg3','$numregistro','$numpartida','$actmunicipal','0','','','','','','','','','$numDocPlantilla')";
mysql_query($grabarempresac,$conn) or die(mysql_error());
 
?>

<table width="684" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33">&nbsp;</td>
    <td width="651"><table width="640" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr>
        <td width="116" height="30" ><span class="camposss">Razón Social</span></td>
        <td width="396" height="30"><input name="apepat" type="text" id="apepat"   style="text-transform:uppercase" value="<?php echo $razonsocial2; ?>" size="45" /></td>
        <td width="138" height="30" ><div id="menucondicion" class="menucondicion" style="display:none; z-index:3;" >
                                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td height="29" colspan="2" class="style30"><table width="196" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="16">&nbsp;</td>
                                          <td width="180"><span class="titulomenuacto">Seleccione Condición(es)</span></td>
                                        </tr>
                                    </table></td>
                                    <td width="45" align="right" valign="middle">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="50" colspan="3"><table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25">&nbsp;</td>
    <td width="725"><div id="tipocondicion" class="tipoacto" style="overflow:auto;"></div></td>
  </tr>
</table></td>
                                  </tr>
                                  <tr>
                                    <td width="620" height="10">&nbsp;</td>
                                    <td width="95"><a href='#' onClick="ocultar_desc('menucondicion')"><img src="iconos/aceptar.png" width="95" height="29" border="0" /></a></td>
                                    <td height="10">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" align="center" valign="middle"></td>
                                  </tr>
                                  <tr></tr>
                                </table>
          </div>    </td>
      </tr>
      <tr>
        <td height="30" ><span class="camposss">Domicilio Fiscal</span></td>
        <td height="30"><input name="direccion"  style="text-transform:uppercase" type="text" id="direccion" value="<?php echo $domfiscal2; ?>" size="60" /></td>
        <td height="30" >&nbsp;</td>
      </tr>
      
      <tr>
        <td height="30" colspan="3" ><span class="camposss">
          <input type="hidden" name="codclie" id="codclie" value="<?php echo $ncliente; ?>"   /><input type='hidden' name='apepat' style='text-transform:uppercase'   id='apepat' value='' /><input type='hidden' name='apemat' style='text-transform:uppercase'   id='apemat' value='' /><input type='hidden' name='prinom' style='text-transform:uppercase'   id='prinom' valsue='' /><input type='hidden' name='segnom' style='text-transform:uppercase'   id='segnom' value='' /><input type='hidden' name='idubigeo' id='idubigeo'  value='' />
          </span></td>
      </tr>
    </table></td>
  </tr>
</table>