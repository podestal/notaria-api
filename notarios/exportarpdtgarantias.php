<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="tcal.css" />
<link href="includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="includes/css/uniform.default.min.css" />
<link rel="stylesheet" type="text/css" href="tcal.css" />


<script type="text/javascript" src="includes/ext_script1.js"></script> 
<script src="includes/jquery-1.8.3.js"></script>
<script src="includes/js/jquery-ui-notarios.js"></script>
<script src="includes/jquery.uniform.min.js"></script>
<script src="includes/maskedinput.js"></script>
<script type="text/javascript" src="tcal.js"></script> 


<script language="javascript">
window.onload = function() {
vaciar_tablas();


}
</script>

<script type="text/javascript">

 $(document).ready(function(){ 
 	$("button").button();
 });

function vaciar_tablas(){
	//var divResultado = document.getElementById('resultado');
	var paterno      = "1";

	ajax=objetoAjax();
	ajax.open("POST", "borrar_tablas.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4 && ajax.status==200) {
			//divResultado.innerHTML = ajax.responseText;
			//reiniciar();
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("paterno="+paterno)
}

function showValidationPdt()
	{
		var _desde    = document.getElementById('desde').value;
		var _hasta    = document.getElementById('hasta').value;
		
		window.open('pdt/frm_garantia.php?initialDate='+_desde+'&finalDate='+_hasta);			
	}	
	
	
</script>

<style type="text/css">



div.frmprotocolar
{ 
  background-color: #ffffff;
border: 4px solid #264965;  

-moz-border-radius: 13px;
-webkit-border-radius: 13px;
border-radius: 13px;
-moz-box-shadow: 0px 0px 5px #000000;
-webkit-box-shadow: 0px 0px 5px #000000;
box-shadow: 0px 0px 5px #000000;
width:900px; height:250px;
font-size: 11px;
}

.titulosprincipales {
	font-family: Calibri;
	font-size: 18px;
	color: #FF9900;
	font-style: italic;
}
.line {color: #FFFFFF}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body onload="vaciar_tablas();">
<div class="frmprotocolar">
  <table width="900" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" bgcolor="#264965"><table width="900" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33" height="30"><img src="iconos/newproto.png" alt="" width="26" height="26" /></td>
          <td width="328"><span class="titulosprincipales">PDT Garantia</span></td>
          <td width="510" align="left">&nbsp;</td>
          <td width="29">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="19"></td>
    </tr>
    <tr>
      <td align="center">
        <table width="740" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="6"><!--<span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036;"><strong>Escriba  Año y Rango de Escrituras para exportar</strong></span>--></td>
            </tr>
          <tr>
            <!--<td width="65" height="34"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036;">Año</span></td>
            <td width="143" align="left"> <input type="text" class=""  name="anio" id="anio"  size="18" value="" /></td>-->
            <td width="63">&nbsp;</td>
            <td width="153">&nbsp;</td>
           <!-- <td colspan="2" rowspan="5"><div id="gen_archi"><input type="button" name="button" id="button" value="Reiniciar Carga..!!!" / onclick="reiniciar();">
              <input type="button" name="button2" id="button2" value="Cargar Data..!!!" / onclick="carga_pdt();" /></div><div id="gen_archi2" style="display:none">
                <table width="228" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="118"><input type="button" name="button3" id="button3" value="1 Exportar ACT" onclick="fExportatxt()" /></td>
                    <td width="110"><input type="button" name="button4" id="button4" value="4 Exportar MPA" onclick="fExportatxt4()" /></td>
                  </tr>
                  <tr>
                    <td><input type="button" name="button3" id="button4" value="2 Exportar BIE" onclick="fExportatxt2()" /></td>
                    <td><input type="button" name="button5" id="button5" value="5 Exportar FOR" onclick="fExportatxt5()" /></td>
                  </tr>
                  <tr>
                    <td><input type="button" name="button3" id="button5" value="3 Exportar OTG" onclick="fExportatxt3()" /></td>
                    <td><input type="button" name="button6" id="button6" value="Reiniciar Carga..!!!" / onclick="reiniciar();" /></td>
                  </tr>
                </table>
              </div></td>-->
            </tr>
          <tr>
            <td height="27" colspan="4"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036;"><strong>Garantia</strong></span></td>
            </tr>
          <tr>
            <td height="29"><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036;">Desde</span></td>
            <td>
              <input type="text" class="tcal"  name="desde" id="desde"  size="18" value="" />
              </td>
            <td><span style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036;">Hasta</span></td>
            <td>
              <input type="text" class="tcal"  name="hasta" id="hasta"  size="18" value=""  />
              <button  name="generar"    id="generar" value="" onclick="showValidationPdt()" >Generar PDT</button>
            </td>
            <td>
            	
            </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><div id="estado" style="font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#036; display:; font:bold;"></div></td>
          </tr>
          </table>
     </td>
    </tr>
  </table>
</div>

</body>
</html>
