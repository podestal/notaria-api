<?php 
session_start();

include("../../conexion.php");
	require_once("../../includes/barramenu.php") ;
	require_once("../../includes/gridView.php")  ;
	require_once("../../includes/combo.php")  	  ;
	$oBarra = new BarraMenu() 				  ;
	$Grid1 = new GridView()					  ;
	$oCombo = new CmbList()  				  ;	

$num_crono  = $_REQUEST['num_crono'];	
$id_cambio = $_REQUEST['id_cambio'];

$consulcartas = mysql_query("SELECT cambio_caracter.*, DATE_FORMAT(fec_ingreso,'%d/%m/%Y') as 'fec_ingreso_2' FROM cambio_caracter WHERE cambio_caracter.num_crono='$num_crono'", $conn) or die(mysql_error());
$rowcrono = mysql_fetch_array($consulcartas);

$numcro = $rowcrono['id_cambio'];
$numcrono2 = $rowcrono['num_crono'];
$numcronoShow = substr($numcrono2,5,6).'-'.substr($numcrono2,0,4);

$id_usuario= $_SESSION["id_usu"];
$sqlu  = mysql_query("SELECT * FROM permisos_usuarios where idusuario = '$id_usuario'",$conn) or die(mysql_error());

$rowu= mysql_fetch_array($sqlu);
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cambio de Caracteristicas</title>
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../tcal.css" />
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../includes/css/uniform.default.min.css" />
<link rel="stylesheet" type="text/css" href="../../tcal.css" />

<script type="text/javascript" src="../../tcal.js"></script> 
<script type="text/javascript" src="../includes/Mantenimientos.js"></script> 
<script src="../../includes/jquery-1.8.3.js"></script>
<script src="../../includes/js/jquery-ui-notarios.js"></script>
<script src="../../includes/jquery.uniform.min.js"></script>
<script src="../../includes/maskedinput.js"></script>
<script type="text/javascript" src="../../tcal.js"></script>
<script type="text/javascript" src="../includes/js/CambioCaracVie.js"></script>


<style type="text/css">
div.carta_content {
	background:#333333;
	border: 1px solid #333333;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	-moz-box-shadow: 0px 0px 7px #000000;
	-webkit-box-shadow: 0px 0px 7px #000000;
	box-shadow: 0px 0px 7px #000000;
	width:638px;
	height:220px;
	position:absolute;
	left: 549px;
	top: 496px;
	margin-top: 15px;
	margin-left: -450px;
	opacity: 0.95;
	filter: "alpha(opacity=50)"; /* expected to work in IE 8 */
	filter: alpha(opacity=50);   /* IE 4-7 */
	zoom: 1;
}

div.allcontrata {width:600px; height:150px; overflow:auto;}
.titupatrimo {font-size: 12; font-style: italic; font-family: Calibri;}

div.div_bloques
{ 
background-color: #ffffff;
border: 4px solid #264965;  
-moz-border-radius: 13px;
-webkit-border-radius: 13px;
border-radius: 13px;
-moz-box-shadow: 0px 0px 5px #000000;
-webkit-box-shadow: 0px 0px 5px #000000;
box-shadow: 0px 0px 5px #000000;
width:820px; height:750px;
}

.camposss {font-family: Calibri; font-style: italic; font-size: 14px; color: #333333; }


#field_remitente, #field_destinatario, #field_responpago, #field_diligencia, #field_cargo{
	margin:0 auto;
	border: 2px solid #ddd; 
	border-radius: 10px; 
	padding: 2px; 
	box-shadow: #ccc 5px 0 5px;
	margin-bottom:0px;
	}
	
</style>
<script type="text/javascript">
function mostrarubigeoo(id,name)
    {
  document.getElementById('ubigen').value = id;
  document.getElementById('distrito_solic').value = name;  
  ocultar_desc('buscaubi');     
        
    }

$(document).ready(function(){ 
	 $("input, textarea").uniform();
	 $("button").button();
	 $("#dialog").dialog();	 
	 ShowCCarac();
	 $(".ui-dialog-titlebar").hide();
	 $('#div_newsolicitante').attr('style','display:none'); 
	 $("#contienepersona").removeAttr("style","display:none");
	 var _id_cambio = document.getElementById('id_cambio').value;
	 $('#llamaphp').load('list_cambios.php?id_cambio='+_id_cambio);
	})

	function fVisualDocument()
	{
		var valid_numcrono = document.getElementById('num_crono').value;
		if(valid_numcrono==''){alert('Debe guardar los datos primero');return;}
		var _num_crono = document.getElementById('muesnumcrono').value;
		
		var _usuario_imprime = '<?php echo $_SESSION["apepat_usu"].' '.$_SESSION["nom1_usu"]; ?>';
		var _nom_notario     = 'NOMBRE DEL NOTARIO';

		window.open("genera_cambio.php?num_crono="+_num_crono+"&usuario_imprime="+_usuario_imprime+"&nom_notario="+_nom_notario);				
	}



	function ocultar_desc(objac2)
		{
			if(document.getElementById(objac2).style.display=="")
				document.getElementById(objac2).style.display="none";
			else
				document.getElementById(objac2).style.display="none";
		}	
	
	function mostrar_desc(objac)
		{
			if(document.getElementById(objac).style.display=="none")
				document.getElementById(objac).style.display=""
			else
				document.getElementById(objac).style.display="";
		}
		
	function fGraba2()
	{
		var _numdoc		  = document.getElementById('num_docu');
		var _solicitante  = document.getElementById('nombre'); 
	
		
			$( "#muesguarda" ).dialog({
				resizable: false,
				height:140,
				position :["center","top"],
				modal: true,
				buttons: {
					"Aceptar": function() { fevalguarda();
					},
					"Cancelar": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		
	}

	function fevalguarda()
	{
		
		fguardaCambio();
		$("#muesguarda").dialog("close");
	}
	

	function ShowCCarac()
	{
		var _id_cambio = document.getElementById('id_cambio').value;
		$('#div_cambiocar').load('listdetCCarac.php?id_cambio='+_id_cambio);		
	}

	function fAddDetalle()
	{
		var _id_cambio = document.getElementById('id_cambio').value;
		var _detalle = document.getElementById('detalle_cambios').value;
		
		if(_id_cambio == '')
		{
			alert('Debe ingresar y grabar los datos primero...');return;
		}
		else if(_id_cambio != '')	
		{
			if(_detalle == ''){alert('Debe seleccionar la caracteristica');return;}
			fPassData();
		}
		
	}

	function fPassData2()
	{
		var _id_cambio = document.getElementById('id_cambio').value;
		var _detalle = document.getElementById('detalle_cambios').value;
		$('#div_cambiocar').load('listdetCCarac.php?detalle='+_detalle+'&id_cambio='+_id_cambio);	
	}

	function fElimDetalle()
	{
		var _id_cambio = document.getElementById('id_cambio').value;
		var _detalle = document.getElementById('detalle_cambios').value;
		
		if(_id_cambio == '')
		{
			alert('Debe ingresar y grabar los datos primero...');return;
		}
		else if(_id_cambio != '')	
		{
			if(_detalle == ''){alert('Debe seleccionar la caracteristica a eliminar');return;}
			fElimData();
		}
		
	}
 
	function fElimData2()
	{
		var _id_cambio = document.getElementById('id_cambio').value;
		var _detalle = document.getElementById('detalle_cambios').value;
		$('#div_cambiocar').load('listdetCCarac.php?detalle='+_detalle+'&id_cambio='+_id_cambio);	
	}		

	function fImprimir()
	{
		var _num_crono = document.getElementById('num_crono').value;
		if(_num_crono==''){alert('Debe guardar los datos primero');return;}
	
		var _usuario_imprime = '<?php echo $_SESSION["apepat_usu"].' '.$_SESSION["nom1_usu"]; ?>';
		var _nom_notario     = 'NOMBRE DEL NOTARIO';
		var _id_cambio = document.getElementById('id_cambio').value;
	
	   _data =
		{
			num_crono : _num_crono,
			usuario_imprime : _usuario_imprime,
			nom_notario : _nom_notario,
			id_cambio : _id_cambio
		}
	
		$.post("../../reportes_word/generador_cambio_caracteristicas.php",_data,function(_respuesta){
						alert(_respuesta);
					});
		
	
	}
	
	function agregarpersona2()
	{		
	
		var _id_cambio  = document.getElementById('id_cambio');
		var _id_cambio2 = document.getElementById('id_cambio').value;
		var _num_crono = document.getElementById('muesnumcrono').value;
		
		
		$("#div_newsolicitante").removeAttr("style","display:none");
			$("#nombre").val("");
			$("#direccion").val("");
			$("#num_docu").val("");
			$("#representacion").val("");
			$("#poder_inscrito").val("");
			$("#int_legitimo").val("");
			
			$("#llamaphp").attr("style","display:none");
			$("#contienepersona").attr("style","display:none");
		
	}
	
	function ggpcambiocarac222()
	{
		var _id_cambio 		= document.getElementById('id_cambio').value;
		var _num_crono      = document.getElementById('muesnumcrono').value;
		var _nombre 		= document.getElementById('nombre').value;
		var _tipdoc			= document.getElementById('tipdoc').value;
		var _num_docu 		= document.getElementById('num_docu').value;
		var _direccion 		= document.getElementById('direccion').value;
		var _ecivil 		= document.getElementById('ecivil').value;
		var _representante 	= document.getElementById('representacion').value;
		var _poder_inscrito = document.getElementById('poder_inscrito').value;
		var _int_legitimo 	= document.getElementById('int_legitimo').value;
		var _distrito_solic = document.getElementById('distrito_solic').value;
		var _tipdoc_rep		= document.getElementById('tipdoc_representante1').value;
		var _numdoc_rep		= document.getElementById('numdocu_representante1').value;
		
		
		var data = {
			id_cambio 		:_id_cambio,
			num_crono 		: _num_crono,
			nombre 			: _nombre,
			tipdoc 			: _tipdoc,
			num_docu 		: _num_docu,
			direccion 		: _direccion,
			ecivil 			: _ecivil,
			representante   : _representante,
			poder_inscrito  : _poder_inscrito,
			int_legitimo 	: _int_legitimo,
			distrito_solic  : _distrito_solic,
			tipdoc_rep		: _tipdoc_rep,
			numdoc_rep		: _numdoc_rep
			};
		
		
		if( _nombre == '' || _tipdoc == '' || _num_docu == '' || _direccion == '' || _ecivil == '' || distrito_solic=='')
		
		{alert('Faltan ingresar datos');return;}

		// graba
		$.post("../model/grabar_clientecambio.php",data,function(){ 
			ocultar_desc('div_newsolicitante');
			$('#llamaphp').load('list_cambios.php?id_cambio='+_id_cambio,function(){
					
					 mostrar_desc('llamaphp');
					 $("#contienepersona").removeAttr("style","display:none");
				
				});
			});			
	}
	

	function ggpcambiocarac2222()
	{
		 	 ocultar_desc('div_newsolicitante');
			 mostrar_desc('llamaphp');
			 $("#contienepersona").removeAttr("style","display:none");
			 
			 $('#llamaphp').load('list_cambios.php?id_cambio='+_id_cambio);
			
		
	}
	
	function Recargar()
	{
	var _id_cambio = document.getElementById('id_cambio').value;
	$('#llamaphp').load('list_cambios.php?id_cambio='+_id_cambio);
	}
	

function editnnombre_solic()
	{
		valord=document.getElementById('nnombre_soli').value;
	 	textod=valord.replace(/&/g,"*");
		document.getElementById('nombre_soli').value=textod;
	}
function editndireccion_solic()
	{
		valord=document.getElementById('ndireccion_soli').value;
	 	textod=valord.replace(/&/g,"*");
		document.getElementById('direccion_soli').value=textod;
	}
function editnrepresentacion_solic()
	{
		valord=document.getElementById('nrepresentacion_soli').value;
	 	textod=valord.replace(/&/g,"*");
		document.getElementById('representacion_soli').value=textod;
	}
function fShowDatosProvee(evento)
	{
	var _tipdoc     = document.getElementById('tipdoc').value;
	var _numdoc		= document.getElementById('num_docu').value;
	

	var _nombre_soli   = document.getElementById('nombre');
	var __direccion	= document.getElementById('direccion');
	
	var _idestcivil	= document.getElementById('ecivil');
			
			if(evento.keyCode==13) 
				{
					if(_numdoc=='' || _tipdoc==''){alert('Ingrese un numero de documento');return;}
					
					var _des = fShowAjaxDato('../includes/ccnombre.php?numdoc='+_numdoc);
					
					document.getElementById('nombre').value = _des;
					
					var _direcc = fShowAjaxDato('../includes/ccdireccion.php?numdoc='+_numdoc);
					
					document.getElementById('direccion').value=_direcc;
					
					var _dist = fShowAjaxDato('../includes/ccdistrito.php?numdoc='+_numdoc);
					document.getElementById('distrito_solic').value=_dist;
					
					var _estciv = fShowAjaxDato('../includes/ccestciv.php?numdoc='+_numdoc);
					document.getElementById('ecivil').value=_estciv;
						
					if(_nombre_soli.value==''){alert('No se encuentra registrado');
					
					$('#nombre').val('');
					$('#direccion').val('');
					$('#distrito_solic').val('');
					$('#ecivil').val('');
					return; }
				}
	
	}
	function validacion()
	{
	
		if	(!$('#tipdoc').val())
		{
			
			alert("debe seleccionar tipo de documento");
		}else if($('#tipdoc').val()==01)
		{
			$("#num_docu").attr("maxlength", 8);
		}else if($('#tipdoc').val()==08)
		{
			$("#num_docu").attr("maxlength", 11);
		}
	}
	function validacion1()
	{
	
		if	(!$('#tipdoc_representante1').val())
		{
			alert("debe seleccionar tipo de documento");
		}else if($('#tipdoc_representante1').val()==01)
		{
			$("#numdocu_representante1").attr("maxlength", 8);
		}else if($('#tipdoc_representante1').val()==08)
		{
			$("#numdocu_representante1").attr("maxlength", 11);
		}
	}
	
	function fShowDatosProvee1(evento)
	{
	var _tipdoc     = document.getElementById('tipdoc_representante1').value;
	var _numdoc		= document.getElementById('numdocu_representante1').value;
			
	var _nrepres	= document.getElementById('representacion');
			if(evento.keyCode==13) 
				{
					if(_numdoc=='' || _tipdoc==''){alert('Ingrese un numero de documento');return;}
					
					var _des = fShowAjaxDato('../includes/ccnombre.php?numdoc='+_numdoc);
					document.getElementById('representacion').value = _des;
						
					if(_nrepres.value==''){alert('No se encuentra registrado');
					
					
					$('#representacion').val('');

					return; }
				}
	
	}
	
	function fbuscanrocontrol(numero){
    if (!/^([0-9])*$/.test(numero))
      alert("El valor " + numero + " no es un número");

  }
  
  function buscanomparticipante(numero){
    if (!/^([0-9])*$/.test(numero))
      alert("El valor " + numero + " no es un número");

  } 
  
function IsNumeric(valor) 
{ 
var log=valor.length; var sw="S"; 
for (x=0; x<log; x++) 
{ v1=valor.substr(x,1); 
v2 = parseInt(v1); 
//Compruebo si es un valor numérico 
if (isNaN(v2)) { sw= "N";} 
} 
if (sw=="S") {return true;} else {return false; } 
} 
var primerslap=false; 
var segundoslap=false; 
function formateafecha(fecha) 
{ 
var long = fecha.length; 
var dia; 
var mes; 
var ano; 
if ((long>=2) && (primerslap==false)) { dia=fecha.substr(0,2); 
if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslap=true; } 
else { fecha=""; primerslap=false;} 
} 
else 
{ dia=fecha.substr(0,1); 
if (IsNumeric(dia)==false) 
{fecha="";} 
if ((long<=2) && (primerslap=true)) {fecha=fecha.substr(0,1); primerslap=false; } 
} 
if ((long>=5) && (segundoslap==false)) 
{ mes=fecha.substr(3,2); 
if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslap=true; } 
else { fecha=fecha.substr(0,3);; segundoslap=false;} 
} 
else { if ((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; } } 
if (long>=7) 
{ ano=fecha.substr(6,4); 
if (IsNumeric(ano)==false) { fecha=fecha.substr(0,6); } 
else { if (long==10){ if ((ano==0) || (ano<1900) || (ano>2100)) { fecha=fecha.substr(0,6); } } } 
} 
if (long>=10) 
{ 
fecha=fecha.substr(0,10); 
dia=fecha.substr(0,2); 
mes=fecha.substr(3,2); 
ano=fecha.substr(6,4); 
// Año no viciesto y es febrero y el dia es mayor a 28 
if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; } 
} 
return (fecha); 
}
  
  
 function soloLetras(e){
 key = e.keyCode || e.which;
 tecla = String.fromCharCode(key).toLowerCase();
 letras = " áéíóúabcdefghijklmnñopqrstuvwxyz-:/._";
 especiales = [8,37,39,46];

 tecla_especial = false
 for(var i in especiales){
     if(key == especiales[i]){
  tecla_especial = true;
  break;
            } 
 }
 
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
     return false;
     }
 

function solonumeros(e){
 key = e.keyCode || e.which;
 tecla = String.fromCharCode(key).toLowerCase();
 nume = " 0123456789*+\-:/_,;.^()|$#%";
 especiales = [8,37,39,46];

 tecla_especial = false
 for(var i in especiales){
     if(key == especiales[i]){
  tecla_especial = true;
  break;
            } 
 }
 
        if(nume.indexOf(tecla)==-1 && !tecla_especial)
     return false;
     }
 
 
 
 var nav4 = window.Event ? true : false;
function aceptNum(evt){
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key>= 48 && key <= 57));
}


/*no valida otros caracteres*/

var r={'special':/[\W]/g}
function valid(o,w){
o.value = o.value.replace(r[w],'');

}


function isNumberKey(evt)
     {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
           return true;
 
        return false;
     }


function validacion3() {
 
   // var er_cp = /(^([0-9]{5,5})|^)$/                
    var er_telefono = /(^([0-9\s\+\-]+)|^)$/           
 
  
    if( !er_telefono.test(frmbuscakardex.id_cambio.value) ) {
        alert('Caracter Incorrecto.')
			document.getElementById('id_cambio').value='';
        return false
    }
 
  
    return false           
}



function validacion4() {
 
   // var er_cp = /(^([0-9]{5,5})|^)$/                
    var er_telefono = /(^([A-Z\s\+\-]+)|^)$/           
 
  
    if( !er_telefono.test(frmbuscakardex.lugar_formuG.value) ) {
        alert('Caracter Incorrecto.')
        return false
    }
 
  
    return false           
}


function CheckTime(str)
{
hora=str.value
if (hora=='') {return}
if (hora.length>8) {alert("Introdujo una cadena mayor a 8 caracteres");return}
if (hora.length!=8) {alert("Introducir HH:MM:SS");return}
a=hora.charAt(0) //<=2
b=hora.charAt(1) //<4
c=hora.charAt(2) //:
d=hora.charAt(3) //<=5
e=hora.charAt(5) //:
f=hora.charAt(6) //<=5
if ((a==2 && b>3) || (a>2)) {alert("El valor que introdujo en la Hora no corresponde, introduzca un digito entre 00 y 23");return}
if (d>5) {alert("El valor que introdujo en los minutos no corresponde, introduzca un digito entre 00 y 59");return}
if (f>5) {alert("El valor que introdujo en los segundos no corresponde");return}
if (c!=':' || e!=':') {alert("Introduzca el caracter ':' para separar la hora, los minutos y los segundos");return}

} 
</script>
</head>

<body style="font-size:62.5%;">

<div id="carta_content">
<form name="frmbuscakardex" method="post" action="">
 <?php
			  if($rowu['editcarac'] == '1')
              {
                    echo'<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="24%">'; ?>
     <?php
				$oBarra->Graba      = "1"                 ;
				$oBarra->GrabaClick = "fGraba2();"        ;
				$oBarra->Impri        = "1"               ;
				$oBarra->ImpriClick   = "fImprimir();"    ;
				$oBarra->clase        = "css"      		  ; 
				$oBarra->widthtxt   = "20"				  ; 
				$oBarra->Show()  						  ; 
				?><?php
    echo'</td><TD width="76%"><div id="verdocumen"><button title="visualizar" type="button" name="btnver"    id="btnver" value="visualizar" onclick="fVisualDocument();" ><img align="absmiddle" src="../../images/block.png" width="15" height="15" />Ver Doc.</button></div></TD>
</tr>
</table>';
			  }else{
				    echo'';
				  }
			  ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td width="637"><table  width="100%">
      <tr>
        <td colspan="6"><div id="muesguarda" title="Confirmacion" style="display:none">Desea guardar el Formulario..?</div><div id="confirmaGuarda"></div></td>
        </tr>
      <tr>
        <td width="10%"><span class="camposss">Nro Cronologico:</span></td>
        <td width="12%"><div id="resul_cambio" style="width:100px;"><input name="num_crono" type="hidden" id="num_crono" value="<?php echo $rowcrono['num_crono']; ?>" size="15" readonly placeholder="Autogenerado" /><input name="id_cambio" type="hidden" id="id_cambio" value="<?php echo $rowcrono['id_cambio']; ?>" /><input name='muesnumcrono' type='text' id='muesnumcrono' style='font-family:Calibri; font-size:16px; color:#003366; border:none;' value="<?php echo $numcronoShow; ?>" size='8' onKeyUp="return validacion3(this)" readonly='readonly'></div></td>
        <td width="12%"><span class="camposss">Fecha ingreso:</span></td>
        <td width="17%"><input name="fec_ingreso" type="text" id="fec_ingreso" style="text-transform:uppercase" value="<?php echo $rowcrono['fec_ingreso_2']; ?>" size="15" class="tcal" onKeyUp = "this.value=formateafecha(this.value);"/></td>
        <td width="14%"><span class="camposss"># Formulario:</span></td>
        <td width="35%"><input name="num_formu" type="text" id="num_formu" onkeypress="return solonumeros(event)" style="text-transform:uppercase" value="<?php echo $rowcrono['num_formu']; ?>" size="15" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>
    <fieldset id="field_remitente">
    <legend><span class="camposss">DATOS DE LAS PERSONAS<button style="font-size:80.5%;" onClick="agregarpersona2();" title="Agregar" type="button" name="addpersona"    id="addpersona" value="Agregar" ><img src="../../images/newuser.png" alt="" width="15" height="15" align="absmiddle" />Agregar</button>
    </span>
    </legend>
    <div id="div_newsolicitante">
    <table  width="100%">
    <tr>
          <td><span class="camposss">Identificado con:</span> </td>
          <td width="19%"><?php 
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT tipodocumento.codtipdoc AS 'id', tipodocumento.destipdoc AS 'des'
FROM tipodocumento
ORDER BY tipodocumento.destipdoc ASC"; 
			$oCombo->value      = "id";
			$oCombo->text       = "des";
			$oCombo->size       = "200"; 
			$oCombo->name       = "tipdoc";
			$oCombo->style      = "camposss"; 
			$oCombo->click      = "validacion();";   
			$oCombo->selected   =  "01";
			$oCombo->Show();
			$oCombo->oDesCon(); 
?></td>
          <td width="10%" align="right"><span class="camposss">Nro:</span></td>
          <td width="63%"><input name="num_docu" type="text" id="num_docu" style="text-transform:uppercase"  onkeypress="return solonumeros(event)" value="<?php echo $rowcrono['num_docu']; ?>" size="16" maxlength="20" /></td>
          </tr>
        <tr>
          <td width="8%"><span class="camposss">Solicitante:</span></td>
          <td colspan="3"><input name="nombre" type="text" id="nombre" style="text-transform:uppercase" value="<?php echo $rowcrono['nombre']; ?>" size="60" maxlength="400" onkeypress="return soloLetras(event)"/>
            </td>
          </tr>
        
        <tr>
          <td><span class="camposss">Domicilio:</span> </td>
          <td colspan="3"><input name="direccion" type="text" id="direccion" style="text-transform:uppercase" value="<?php echo $rowcrono['direccion']; ?>" size="60" maxlength="2000" /></td>
        </tr>
        <tr>
          <td><span class="camposss">Distrito:</span></td>
          <td colspan="3"><?php /*
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT ubigeo.coddis AS 'id', CONCAT(ubigeo.nomdis,'/', ubigeo.nomprov,'/',ubigeo.nomdpto)  AS 'descripcion' FROM ubigeo
ORDER BY ubigeo.nomdis ASC
"; 
			$oCombo->value      = "id";
			$oCombo->text       = "descripcion";
			$oCombo->size       = "150"; 
			$oCombo->name       = "distrito_solic";
			$oCombo->style      = "camposss"; 
			$oCombo->click      = "//selectzona(this.value);";   
			$oCombo->selected   =  $rowpart['ubigeo'];
			$oCombo->Show();
			$oCombo->oDesCon(); */
?>
            <span class="camposss">
            <input name="distrito_solic" type="hidden" id="distrito_solic" value="<?php echo $rowpart['ubigeo']; ?>" size="15" />
            </span>
            <?php 
		  
		  $consulubigeo= mysql_query("SELECT * FROM ubigeo where coddis='".$rowpart['ubigeo']."'", $conn) or die(mysql_error());
		  $rowubbi=mysql_fetch_array($consulubigeo);
        
		  
		  ?><div id="buscaubi" style="position:absolute; display:none; width:637px; height:223px; left: 28px; top: 335px; z-index:20; background:#CCCCCC; border: 1px solid #333333; border: 1px solid #264965; -moz-border-radius: 13px; -webkit-border-radius: 13px; border-radius: 13px; -moz-box-shadow: 0px 0px 5px #000000; -webkit-box-shadow: 0px 0px 5px #000000; box-shadow: 0px 0px 5px #000000;">
              <table width="637" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="24" height="29">&nbsp;</td>
                  <td width="585" class="camposss">Seleccionar Zona:</td>
                  <td width="28"><a href="#" onclick="ocultar_desc('buscaubi')"><img src="../../iconos/cerrar.png" width="21" height="20" border="0" /></a></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><label>
                    <input name="_buscaubi" style="text-transform:uppercase; background:#FFF;" type="text" id="_buscaubi" size="65" onkeypress="buscaubigeos()" />
                  </label></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><div id="resulubi" style="width:585px; height:150px; overflow:auto"></div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
          </div>
            <table width="522" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="428"><input name="ubigen" type="text" id="ubigen" value="<?php echo $rowubbi['nomdpto']."/".$rowubbi['nomprov']."/".$rowubbi['nomdis']; ?>"  size="60" onKeyUp="return validacion4(this)"  disabled/></td>
                <td width="94"><a href="#" onclick="mostrar_desc('buscaubi')"><img src="../../iconos/seleccionar.png" width="94" height="29" border="0" /></a></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><span class="camposss">Estado civil:</span></td>
          <td colspan="3"><?php 
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT tipoestacivil.idestcivil AS 'id', tipoestacivil.desestcivil AS 'des'
FROM tipoestacivil
ORDER BY tipoestacivil.desestcivil ASC "; 
			$oCombo->value      = "id";
			$oCombo->text       = "des";
			$oCombo->size       = "200"; 
			$oCombo->name       = "ecivil";
			$oCombo->style      = "camposss"; 
			$oCombo->click      = "//selectAsunto(this.value);";   
			$oCombo->selected   =  $rowcrono['ecivil'];
			$oCombo->Show();
			$oCombo->oDesCon(); 
?></td>
        </tr>
        <tr>
          <td colspan="4">
            <input name="c_nombre" type="hidden" id="c_nombre" style="text-transform:uppercase" value="<?php echo $rowcrono['c_nombre']; ?>" size="60" />
            <input name="c_tipdoc" type="hidden" id="c_tipdoc"  value="<?php echo $rowcrono['c_tipdoc']; ?>" size="60" /><input name="c_numdoc" type="hidden" id="c_numdoc" style="text-transform:uppercase" onKeyPress="//fShowDatosProvee(event);" value="<?php echo $rowcrono['c_numdoc']; ?>" size="15" readonly /></td>
        </tr>
        <tr>
          <td colspan="4"><span class="camposss">Quien manifesto actuar por su propio derecho, o en representacion de :</span></td>
        </tr>
 <tr>
          <td><?php 
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT tipodocumento.codtipdoc AS 'id', tipodocumento.destipdoc AS 'des'
FROM tipodocumento
ORDER BY tipodocumento.destipdoc ASC"; 
			$oCombo->value      = "id";
			$oCombo->text       = "des";
			$oCombo->size       = "150"; 
			$oCombo->name       = "tipdoc_representante1";
			$oCombo->style      = "camposss"; 
			//$oCombo->click      = "//selectAsunto(this.value);";   
			$oCombo->click      = "validacion1()"; 
			$oCombo->selected   =  "";
			$oCombo->Show();
			$oCombo->oDesCon(); 
?></td>
          <td width="12%" align="center"><span class="camposss">Nro:</span></td>
          <td width="17%"><input name="numdocu_representante1" type="text" id="numdocu_representante1" style="text-transform:uppercase" onkeypress="return solonumeros(event)" size="16" maxlength="20" value="<?php echo $rowcrono['numdocu_representante']; ?>" /></td>
          <td width="61%">&nbsp;</td>

          </tr>
        <tr>
          <td colspan="4"><input name="representacion" type="text" id="representacion" style="text-transform:uppercase" value="<?php echo $rowcrono['representacion']; ?>" size="100" maxlength="400" onkeypress="return soloLetras(event)" /></td>
          </tr>
        <tr>
          <td align="left"><span class="camposss">Nro partida electronica:</span></td>
          <td colspan="3"><input name="poder_inscrito" type="text" id="poder_inscrito" style="text-transform:uppercase" value="<?php echo $rowcrono['poder_inscrito']; ?>" size="84" maxlength="400" onKeyUp="return validacion3(this)" /></td>
          </tr>
        <tr>
          <td align="left"><span class="camposss">O tercero con interes legitimo segun</span></td>
          <td colspan="3"><input name="int_legitimo" type="text" id="int_legitimo" style="text-transform:uppercase" value="<?php echo $rowcrono['int_legitimo']; ?>" size="84" maxlength="400" onkeypress="return soloLetras(event)" /></td>
          </tr>
           <tr>
         
            <?php
			  if($rowu['editcarac'] == '1')
              {
                    echo'<td><button title="grabar" type="button" name="Grabar"   id="Grabar"   value="Grabar" onclick="ggpcambiocarac222()"   ><img src="../../images/save.png" width="17" height="17" align="absmiddle" /> Guardar</button></td>
    	  <td width="19%"><button title="visualizar" type="button" name="btnver"    id="btnver" value="visualizar" onclick="ggpcambiocarac2222()" ><img align="absmiddle" src="../../images/block.png" width="15" height="15" />Ver</button></td>';
			  }else{
				    echo'<td></td>
    	  <td width="19%"></td>';
				  }
			  ?>
          
         
          </tr>
        </table>
        </div>
<div id="contienepersona">
        	
   			 <table width="880" border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" bgcolor="#CCCCCC">
            <tr>
              <td width="20" align="center"><span class="titubuskar0">Nro</span></td>
              <td width="90" align="center"><span class="titubuskar0">Documento</span></td>
              <td width="150" align="center"><span class="titubuskar0">Solicitante</span></td>
              <td width="150" align="center"><span class="titubuskar0">Domicilio</span></td>
           	  <td width="50" align="center"><span class="titubuskar0">Accion</span></td>

          	  </tr>
          </table>
          <div id="llamaphp">
  

          </div>
        </div>
    </fieldset>  
      </td>
    </tr>
  <tr>
    <td>
    <fieldset id="field_destinatario">
    <legend><span class="camposss">CAMBIO DE CARACTERISTICAS</span></legend>
    <table  width="98%">
        <tr>
          <td width="67%" rowspan="3" valign="top"><div id="div_cambiocar" style='border: 1px solid #264965;border-radius: 5px;width:560px; height:150px; overflow:auto'></div></td>
          <td width="9%"><span class="camposss">Agregar:</span></td>
          <td width="24%"><?php 
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT detalle_cambios.id_cambio AS 'id', CONCAT(detalle_cambios.id_cambio,' - ',detalle_cambios.des_cambio) AS 'des'
FROM detalle_cambios ORDER BY des_cambio ASC"; 
			$oCombo->value      = "id";
			$oCombo->text       = "des";
			$oCombo->size       = "200"; 
			$oCombo->name       = "detalle_cambios";
			$oCombo->style      = "camposss"; 
			$oCombo->click      = "//selectAsunto(this.value);";   
			$oCombo->selected   =  "01";
			$oCombo->Show();
			$oCombo->oDesCon(); 
?></td>
          </tr>
        <tr>
          <td colspan="2">
          <?php
			  if($rowu['editcarac'] == '1')
              {
                    echo'<button title="Añadir" type="button" name="anadir"    id="anadir" value="anadir" onclick="fAddDetalle();" ><img src="../../images/obs.png" width="18" height="18" align="absmiddle" /> Añadir</button>&nbsp;&nbsp;<button title="Crear Bloque" type="button" name="eliminar"    id="eliminar" value="eliminar" onclick="fElimDetalle();" ><img src="../../images/delete.png" width="18" height="18" align="absmiddle" /> Eliminar</button>';
			  }else{
				    echo'';
				  }
			  ?>
          
          </td>
          </tr>
        <tr>
          <td colspan="2" valign="top"><div id="div_muesresul"></div></td>
          </tr>
        </table>
    </fieldset>
   </td>
    </tr>
  
  <tr>
    <td width="70" height="30" align="left" valign="center"><span class="camposss">Observaciones:
      <textarea name="observacion" style="text-transform:uppercase;" id="observacion" cols="120" rows="5"><?php echo $rowcrono['observacion']; ?></textarea>
   </span></td>
    
  </tr>
</table>
</form>
</div>
</body>
</html>