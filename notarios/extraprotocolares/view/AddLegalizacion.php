<?php 
session_start();

	include("../../conexion.php");
	
	require_once("../../includes/barramenu.php") ;
	require_once("../../includes/gridView.php")  ;
	require_once("../../includes/combo.php")  	  ;
	$oBarra = new BarraMenu() 				  ;
	$Grid1 = new GridView()					  ;
	$oCombo = new CmbList() ; 



			if(isset($_GET['idLegalizacion']))
		{	
			$id=$_GET['idLegalizacion'];
			$xidsql="SELECT idLegalizacion,fechaIngreso,direccionCertificado as direCertificado,documento,dni FROM legalizacion WHERE idLegalizacion=".$id;

			//echo $xidsql;

			$sqlDataLegalizacion=mysql_query($xidsql,$conn) or die(mysql_error()); 

			$rowData=mysql_fetch_array($sqlDataLegalizacion);


		}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificado Domiciliario</title>
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../tcal.css" />
<link href="../../includes/css/jquery-ui-notarios.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="../../includes/css/uniform.default.min.css" />
<link rel="stylesheet" type="text/css" href="../../tcal.css" />
<link rel="stylesheet" type="text/css" href="../includes/css/CertDomiVie.css" />


<script type="text/javascript" src="../../tcal.js"></script> 
<script type="text/javascript" src="../includes/Mantenimientos.js?j=<?php echo time(); ?>"></script> 
<script src="../../includes/jquery-1.8.3.js"></script>
<script src="../../includes/js/jquery-ui-notarios.js"></script>
<script src="../../includes/jquery.uniform.min.js"></script>
<script src="../../includes/maskedinput.js"></script>
<script type="text/javascript" src="../../tcal.js"></script> 
<script type="text/javascript" src="../includes/js/CertDomiVie.js?j=<?php echo time(); ?>"></script> 
<script type="text/javascript" src="ajaxdom.js"></script> 
<script type="text/javascript">
function tabulador (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 9) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 

function ggclie1dom(){
	
	   grabarcliente_dom();
	   alert("Cliente grabado satisfactoriamente");
	   ocultar_desc('clientenewdni');
	
}
function ggEditarclie1dom(){
	
	   editarcliente_dom();
	   alert("Cliente editado satisfactoriamente");
	   ocultar_desc('clientenewdni');
	
}
	 
	function ggclie1dom2()
 {
	
	   grabarcliente2_dom();
	   alert("Cliente grabado satisfactoriamente");
	   ocultar_desc('clientenew');
	
	 }
	 
function send(e){ 
	   
	tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){
        buscar_cliente_car();
		
	} 
} 
		
function mpresa()
    {
	mostrar_desc('clientenew');
	
	}	
function newclient(id=null)
    {
	mostrar_desc('clientenewdni');

		if(id!=null){//codigo para edicion de cliente en certificacion de firmas
			ajax=objetoAjax();
			ajax.open("POST", "../model/obtener_solicitante.php",true);	
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4 && ajax.status==200) { 
					let data = ajax.responseText
					let registro = JSON.parse(data)
					
					hdnIdCliente.value = registro['idcliente']
					napepat.value = registro['apepat']
					napemat.value = registro['apemat']
					nprinom.value = registro['prinom']
					nsegnom.value = registro['segnom']
					apepat.value = registro['apepat']
					apemat.value = registro['apemat']
					prinom.value = registro['prinom']
					segnom.value = registro['segnom']
					document.getElementById('direccion').value = registro['direccion']
					ubigensc.value = registro['idubigeo']
					idestcivil.value = registro['idestcivil']
					sexo.value = registro['sexo']
					nacionalidad.value = registro['nacionalidad']
					natper.value = registro['natper']
					cumpclie.value = registro['cumpclie']
					telcel.value = registro['telcel']
					telofi.value = registro['telofi']
					telfijo.value = registro['telfijo']
					email.value = registro['email']

				}
			}
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			//enviando los valores
			ajax.send("idCliente="+id);

			btnEditar.style.display='block'
			btnGrabar.style.display='none'
		}else{
			btnEditar.style.display='none'
			btnGrabar.style.display='block'
		}
	}	
	
function validar(value){
	
	if(valor=='8'){
		document.getElementById('numdoc').maxLength="11";
		}
		
	if(valor=='1'){
		document.getElementById('numdoc').maxLength="8";
		}
		
	if(valor!='1' || valor!='8'){
		document.getElementById('numdoc').maxLength="15";
		}
	}
function cerrar(){
	ocultar_desc('clientenew');
	regresa_caja();

	}

function cerrar2(){
	ocultar_desc('clientenewdni')
	regresa_caja();
	}
	
function regresa_caja(){
	var divResultado = document.getElementById('rpta_bus');
	var _num_doc     = document.getElementById('numdoc_solic').value;
	ajax=objetoAjax();

	ajax.open("POST", "clear_text_dom.php",true);	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4 && ajax.status==200) { 
			divResultado.innerHTML = ajax.responseText;		
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("_num_doc="+_num_doc);
	
	}
	
var countSolicitant=0;
var arryDataSolicitante=[];

function fncValidarRepetir(arrayData,dni)
{
	var validat=false;
		$.each(arrayData,function(r)
		{
			var obj=this;
			if(obj.numDoc==dni){
				validat=true;
				return ;
			}
			
		});
		return validat;
}

function fncAddSolicitante()
{
	var numDoc=getDataPorId('numdoc_solic');
	var nombreSolicitante=getDataPorId('nnombre_solic');
	var condicion=getDataPorId('motivo_solic');
	var direCertificado=getDataPorId('direCertificado');
	
	var idClienteSolicitante;
	if(getDataPorId('idClienteSolicitante')!=''){

		idClienteSolicitante=getDataPorId('idClienteSolicitante');
	}
	
	if(getDataPorId('idGrabarClienteSolicitante')!=''){

		idClienteSolicitante=getDataPorId('idGrabarClienteSolicitante');
	}

	
	if(numDoc=='')
	{
		alert('Ingresar DNI');
		return ;
	}
	if(nombreSolicitante=='')
	{
		alert('Ingresar Nombre Solicitante');
		return;
	}
	

	if(fncValidarRepetir(arryDataSolicitante,numDoc))
	{
		alert('Ya se ha resgitrado este solicitante !!!');
		return ;
	}
	arryDataSolicitante.push({nombreSolicitante:nombreSolicitante,numDoc:numDoc,condicion:condicion});

	console.log(arryDataSolicitante)
	countSolicitant++;

	html = `<tr id="containerSolicitante${numDoc}">
		<td>${countSolicitant}</td>
		<td>${nombreSolicitante}</td>
		<td>${numDoc}</td>
		<td>${condicion}</td>
		<td id="">
			<a href="#" onclick="newclient('${idClienteSolicitante}')">
				<img src="../../iconos/editacontrar.png" title="Editar Contratante" width="22" height="22" border="0">
			</a>&nbsp;&nbsp;
			<a href="#" onclick="eliminarSolicitante(null,'${numDoc}')">
				<img src="../../iconos/eliminacontrar.png" title="Eliminar Contratante" width="22" height="22" border="0">
			</a>
		</td>
	</tr>`;

	$('.clDataSolicitante').append(html);

	document.getElementById('rpta_bus').innerHTML="";

}
function eliminarSolicitante(id,documento){

	if(id == null){
		
		let containerFilas = document.getElementById("containerFilas");
		let containerSolicitantes = document.getElementById("containerSolicitante"+documento);
		containerFilas.removeChild(containerSolicitantes);
		removeItemFromArr( arryDataSolicitante, documento );
		
	}else{
		ajax=objetoAjax();
		ajax.open("POST", "../model/eliminar_solicitante.php",true);	
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4 && ajax.status==200) { 
				console.log(ajax.responseText)

				let containerFilas = document.getElementById("containerFilas");
				let containerSolicitantes = document.getElementById("containerSolicitante"+documento);
				containerFilas.removeChild(containerSolicitantes);
				removeItemFromArr( arryDataSolicitante, documento );

			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//enviando los valores
		ajax.send("idSolicitante="+id);

	}

}

function removeItemFromArr ( arr, item ) {
    let i = arr.indexOf( item );
    arr.splice( i, 1 );
}



function apepaterno(){
	
 valord=document.getElementById('napepat').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('apepat').value=textod;
}

function apematerno(){
 valord=document.getElementById('napemat').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('apemat').value=textod;

}
function prinombre(){
 valord=document.getElementById('nprinom').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('prinom').value=textod;

}
function segnombre(){
 valord=document.getElementById('nsegnom').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('segnom').value=textod;

}
function direccion(){
 valord=document.getElementById('ndireccion').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('direccion').value=textod;

}

function razonsociall(){
	
 valorra=document.getElementById('nrazonsocial').value;
 textor=valorra.replace(/&/g,"*");
 document.getElementById('razonsocial').value=textor;
	}
function domfiscall(){
	
valord=document.getElementById('ndomfiscal').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('domfiscal').value=textod;
	}	

	
$("#idzonax").live("click", function(){
				$("#_buscaubi").val("");
				$("#_buscaubi").focus();
				$("#resulubi").html("");
			 })
	
function mostrarubigeoo(id,name)
    {

  document.getElementById('ubigen').value = id;
  document.getElementById('codubi').value = name;  
  ocultar_desc('buscaubi');     
        
    }
	
	function mostrarubigeoosc(id,name){
	document.getElementById('ubigensc').value=id;
	document.getElementById('codubisc').value=name;
	ocultar_desc('buscaubisc');
	
	}

	function fImprimir()
	{
		var _idLocalizacion = document.getElementById('idLegalizacion').value;
		if(_idLocalizacion=='')
			{
				alert('Debe guardar los datos primero');
				return;
			}
	
		var _usuario_imprime = '<?php echo $_SESSION["apepat_usu"].' '.$_SESSION["nom1_usu"]; ?>';
		var _nom_notario     = 'NOMBRE DEL NOTARIO';
	
		_data =
		{
			idLocalizacion : _idLocalizacion,
			usuario_imprime : _usuario_imprime,
			nom_notario : _nom_notario
		}
	
		$.post("../../reportes_word/generador_legalizacion.php",_data,function(_respuesta){
						alert(_respuesta);
					});
	}

	function fVisualDocument()
	{
		let valid_numcrono;
		if(document.getElementById('num_certificado')){

			valid_numcrono = document.getElementById('num_certificado').value;
		}
		if(document.getElementById('idLegalizacion')){
			valid_numcrono = document.getElementById('idLegalizacion').value;
		}

		if(valid_numcrono==''){alert('Debe guardar los datos primero');return;}

		let _num_crono;

		if(document.getElementById('num_certificado')){

			_num_crono = document.getElementById('num_certificado').value;
		}
		if(document.getElementById('idLegalizacion')){
			_num_crono = document.getElementById('idLegalizacion').value;
		}

		
		
		var _usuario_imprime = '<?php echo $_SESSION["apepat_usu"].' '.$_SESSION["nom1_usu"]; ?>';
		var _nom_notario     = 'NOMBRE DEL NOTARIO';

		window.open("genera_legalizacion.php?num_crono="+_num_crono+"&usuario_imprime="+_usuario_imprime+"&nom_notario="+_nom_notario);				
	}
	
function nomtestigo(){
	
 valord=document.getElementById('nnom_testigo').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('nom_testigo').value=textod;
}


function nombresolic(){
 valord=document.getElementById('nnombre_solic').value;
 textod=valord.replace(/&/g,"*");
 document.getElementById('nombre_solic').value=textod;

}
	
function fShowDatosPersona(evento)
{	
	var _tipdoc     = document.getElementById('tipdoc_solic').value;
	var _numdoc		= document.getElementById('numdoc_solic').value;
	
	var _nombre_soli	= document.getElementById('nnombre_solic');
	var _nombre_soli2   = document.getElementById('nombre_solic');
	
	var _direccion 	    = document.getElementById('ndomic_solic');
	var __direccion2	= document.getElementById('domic_solic');
	
	var _distrito   = document.getElementById('distrito_solic');
	var _motivo		= document.getElementById('motivo_solic');
	var _idestcivil	= document.getElementById('idestcivil');
	var _sexo   	= document.getElementById('sexo');
	var _nomprofesionesc   	= document.getElementById('nomprofesionesc');
	var _idprofesionc   	= document.getElementById('idprofesionc');
			
			if(evento.keyCode==13) 
				{
					if(_numdoc=='' || _tipdoc==''){alert('Ingrese un numero de documento');return;}
					
					var _des = fShowAjaxDato('../includes/certnombre.php?numdoc='+_numdoc);
					document.getElementById('nnombre_solic').value = _des;
					document.getElementById('nombre_solic').value = _des;
					var _direcc = fShowAjaxDato('../includes/certdireccion.php?numdoc='+_numdoc);
					document.getElementById('ndomic_solic').value=_direcc;
					document.getElementById('domic_solic').value=_direcc;
					
					var _dist = fShowAjaxDato('../includes/certdistrito.php?numdoc='+_numdoc);
					document.getElementById('distrito_solic').value=_dist;
					
					
					var _dist2 = fShowAjaxDato('../includes/certdistrito2.php?numdoc='+_numdoc);
					document.getElementById('ubigen').value=_dist2;
									
					var _estciv = fShowAjaxDato('../includes/certestciv.php?numdoc='+_numdoc);
					document.getElementById('idestcivil').value=_estciv;
						var _sexo = fShowAjaxDato('../includes/certsexo.php?numdoc='+_numdoc);
					document.getElementById('sexo').value=_sexo;
					
						var _idprofesion = fShowAjaxDato('../includes/certidprof.php?numdoc='+_numdoc);
					document.getElementById('idprofesionc').value=_idprofesion;
					
						var _nomprofesion = fShowAjaxDato('../includes/certdetprof.php?numdoc='+_numdoc);
					document.getElementById('nomprofesionesc').value=_nomprofesion;
					
					if(_nombre_soli.value==''){alert('No se encuentra registrado');
					
					
					$('#nnombre_solic').val('');
					$('#nombre_solic').val('');
					$('#ndomic_solic').val('');
					$('#domic_solic').val('');
					$('#distrito_solic').val('');
					$('#motivo_solic').val('');
					$('#idestcivil').val('');
					$('#sexo').val('');
					$('#ubigen').val('');
					return; }
				}
}
function mostrar_desc(objac)
		{
		
		if(document.getElementById(objac).style.display=="none")
		document.getElementById(objac).style.display=""
		else
		document.getElementById(objac).style.display="";
		}
		

function ocultar_desc(objac2)
		{
		
		if(document.getElementById(objac2).style.display=="")
		document.getElementById(objac2).style.display="none";
		else
			document.getElementById(objac2).style.display="none";
		}
	
function focusprofec(){
	document.getElementById('buscaprofesc').focus();
	}
	
function buscaprofesionesc()
{ 	
	var divResultado = document.getElementById('resulprofesionesc');
	var buscaprofes  = document.getElementById('buscaprofesc').value;
		
	ajax=objetoAjax();
	ajax.open("POST","buscaprofesionnesdomic.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4 && ajax.status==200) {
			divResultado.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("buscaprofes="+buscaprofes);
}

function mostrarprofesionessc(id,name)
    {
  document.getElementById('idprofesionc').value = id;
  document.getElementById('nomprofesionesc').value = name;  
  ocultar_desc('buscaprofec');        
    }
function fShowDatosPersonacert(evento)
{
			var _tipdoc        = $("#tdoc_testigo");			
			var _numdoc		   = $("#ndocu_testigodom").val();

			var _nombre        = $("#nnom_testigo");
			var _nombre_2      = $("#nom_testigo");
			
			if(evento.keyCode==13) 
				{
					if(_numdoc=='' || _tipdoc.val()==''){alert('Ingrese un numero/tipo de documento');return;}
					
					// Nombre de la persona
					var _des_nombre = fShowAjaxDato('../includes/testigo_nombre.php?numdoc='+_numdoc);
					document.getElementById('nnom_testigo').value = _des_nombre;
					document.getElementById('nom_testigo').value  = _des_nombre;
					
					
					if(_nombre.val()==''){alert('No se encuentra registrado');
					
					
					$('#nrepresentante').val('');
					$('#representante').val('');

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
 
  
    if( !er_telefono.test(frmbuscakardex.num_certificado.value) ) {
        alert('Caracter Incorrecto.')
		document.getElementById('num_certificado').value='';
        return false
    }
 
  
    return false           
}



function validacion4() {
 
   // var er_cp = /(^([0-9]{5,5})|^)$/                
    var er_telefono = /(^([A-Z\s\+\-]+)|^)$/           
 
  
    if( !er_telefono.test(frmbuscakardex.distrito_solic.value) ) {
        alert('Caracter Incorrecto.')
		document.getElementById('distrito_solic').value='';
        return false
    }
 
  
    return false           
}

function validacion5() {
 
   // var er_cp = /(^([0-9]{5,5})|^)$/                
    var er_telefono = /(^([A-Z\s\+\-]+)|^)$/           
 
  
    if( !er_telefono.test(frmbuscakardex.nomprofesionesc.value) ) {
        alert('Caracter Incorrecto.')
		document.getElementById('nomprofesionesc').value='';
        return false
    }
 
  
    return false           
}



function fncMostrarCuerpo()
{
	var solicitantesInfo='';
	var direSolic=getDataPorId('direCertificado');
	var size=arryDataSolicitante.length;

	$.each(arryDataSolicitante,function(index){
		var obj=this;
		if((size-1)==index)
		{
			solicitantesInfo=solicitantesInfo+" y "+obj.nombreSolicitante+" CON D.N.I. N° "+obj.numDoc+" QUIEN FIRMA EN CONDICIÓN DE "+obj.condicion+" ";
		}else
		{
			solicitantesInfo=solicitantesInfo+" "+obj.nombreSolicitante+" CON D.N.I. N° "+obj.numDoc+" QUIEN FIRMA EN CONDICIÓN DE "+obj.condicion+" , ";
		}
		

	});

	var fe = getDataPorId('fec_ingreso');
	var arrFe=fe.split('/');
	var fecha=new Date(arrFe[2]+'-'+arrFe[1]+'-'+(parseInt(arrFe[0])+1));
	var options = { year: 'numeric', month: 'long', day: 'numeric' };


 var fechaActual= fecha.toLocaleDateString("es-ES", options)



	$('#texto_cuerpo').text('CERTIFICO: QUE LAS FIRMAS QUE ANTECEDEN CORRESPONDEN A '+solicitantesInfo+'  A SOLICITUD DE LOS MISMOS LEGALIZO SUS FIRMAS EN '+direSolic+' EL '+fechaActual);
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
function validar_documento(){
	
if(document.getElementById('tdoc_testigo').value=='01'){
	document.getElementById('ndocu_testigodom').maxLength=8;
	}else{
		document.getElementById('ndocu_testigodom').maxLength=16;
		}
}

function validar_documento2(){
if(document.getElementById('tipdoc_solic').value=='01'){
	document.getElementById('numdoc_solic').maxLength=8;
	}else{
		document.getElementById('numdoc_solic').maxLength=16;
		}	
	
	}

function getDataPorId(id)
{
	var id_=document.getElementById(id);
 	if(id_!=null)
 		return id_.value;
 	else
 		return '';
}


function fncMostrarCuerpo()
{
	var solicitantesInfo='';
	var direSolic=getDataPorId('direCertificado');
	var size=arryDataSolicitante.length;

	$.each(arryDataSolicitante,function(index){
		var obj=this;
		if((size-1)==index)
		{
			solicitantesInfo=solicitantesInfo+" y "+obj.nombreSolicitante+" CON D.N.I. N° "+obj.numDoc+" QUIEN FIRMA EN CONDICIÓN DE "+obj.condicion+" ";
		}else
		{
			solicitantesInfo=solicitantesInfo+" "+obj.nombreSolicitante+" CON D.N.I. N° "+obj.numDoc+" QUIEN FIRMA EN CONDICIÓN DE "+obj.condicion+" , ";
		}
		

	});

	var fe = getDataPorId('fec_ingreso');
	var arrFe=fe.split('/');
	var fecha=new Date(arrFe[2]+'-'+arrFe[1]+'-'+(parseInt(arrFe[0])+1));
	var options = { year: 'numeric', month: 'long', day: 'numeric' };


 var fechaActual= fecha.toLocaleDateString("es-ES", options)



	$('#texto_cuerpo').text('CERTIFICO: QUE LAS FIRMAS QUE ANTECEDEN CORRESPONDEN A '+solicitantesInfo+'  A SOLICITUD DE LOS MISMOS LEGALIZO SUS FIRMAS EN '+direSolic+' EL '+fechaActual);
}



function act_comprobante(){
	
	var divResultado = document.getElementById('comprobante_carta');
	document.getElementById('comprobante_carta').style.display="";
	divResultado.innerHTML= '<img src="../../loading.gif">';
	var _carta     = document.getElementById('idLegalizacion').value;
	
	ajax=objetoAjax();

				
	tipo="LE";


	ajax.open("POST", "documentosEmitidos.php",true);	
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4 && ajax.status==200) { 
			divResultado.innerHTML = ajax.responseText;		
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("carta="+_carta+"&tipo="+tipo);
	
	}
	


function cerrar_comprobante(){
	
	var divResultado = document.getElementById('comprobante_carta');

	divResultado.style.display="none";
	
	}
	
function crearOs()
{		
	var tipo     = "LE";
	var idActo     = document.getElementById('idLegalizacion').value;
	
		window.parent.location = 'PrefacturaVie.php?val=1&tipo='+tipo+"&idActo="+idActo;
	
}

function fncEditarOS(xordenServicio)
{
	window.parent.location = "PrefacturaVie.php?&ordenservicio="+xordenServicio;

}



function fncEliminarOS(xos)
{
	if(confirm("Desea Anular este elemento ?"))
	{
		ajax=objetoAjax();
		ajax.open("POST","../consultas/anularOs.php",true);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4 && ajax.status==200) {
					if(ajax.responseText=="0")
			  			alert("Esta Orden de Servicio fue Emitida, no se puede ANULAR !!");
			  	verOrdenServicio();


			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("ordenservicio="+xos);

	}
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

	function verOrdenServicio()
		{	
				tipo="LE";
				/*var vvidasunto=document.getElementById("idasunto").value;
				if(vvidasunto=="001") //INTERIOR
				{
					tipo=9;
				}else if(vvidasunto=="002") //EXTERIOR
				{
					tipo=17;
				} else if(vvidasunto=="003") //REVOCATORIA
				{
					tipo=18;
				}else if(vvidasunto=="004") //INDETERMINADO
				{
					tipo=22;
				}*/



				var idActo     = document.getElementById('idLegalizacion').value;
				if(idActo==0)
				{
					alert("Tiene que Guardar primero la Legalización");
					return;
				}
				mostrar_desc('dvOrdenServicio');
				ajax=objetoAjax();
				ajax.open("POST","../consultas/verOrdenServicios.php",true);
				ajax.onreadystatechange=function() {
					if (ajax.readyState==4 && ajax.status==200) {
					   $("#rsptOrdenServicios").html(ajax.responseText);
					}
				}
				ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				ajax.send("tipo="+tipo+"&idActo="+idActo);

				$("#dvOrdenServicio" ).draggable(); 

		}



</script>

<script src="../../js/consulta_reniec_sunat.js"></script>
<style>
div.dalib {
	background: #333333;
	border: 1px solid #333333;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	-moz-box-shadow: 0px 0px 7px #000000;
	-webkit-box-shadow: 0px 0px 7px #000000;
	box-shadow: 0px 0px 7px #000000;
	width: 760px;
	height: 299px;
	position: absolute;
	left: 494px;
	top: 121px;
	margin-top: 15px;
	margin-left: -450px;
	opacity: 0.95;
	filter: "alpha(opacity=70)"; /* expected to work in IE 8 */
	filter: alpha(opacity=70);   /* IE 4-7 */
	zoom: 1;
}


</style>
</head>

<body style="font-size:62.5%;">
<div id="carta_content">
<form name="frmbuscakardex" method="post" action="">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr><td>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="23%">
     <?php
				$oBarra->Graba        = "1"               ;
				$oBarra->GrabaClick   = "fGrabaLegalizacion();"       ;
				$oBarra->Impri        = "1"               ;
				$oBarra->ImpriClick   = "fImprimir();"    ;
				$oBarra->clase        = "css"      		  ; 
				$oBarra->widthtxt   = "20"				  ; 
				$oBarra->Show()  						  ; 
				?>
    </td>


      <!-- <td width="21%" align="left"><div id="vergeneraros"><button title="Generar OS" type="button" name="btnver"    id="btnGenerarOs" value="Generar OS" onclick="verOrdenServicio();" ><img align="absmiddle" src="../../images/block.png" width="15" height="15" />Generar OS</button></div>
    </td>


<td width="21%" align="left"><div id="vergeneraros"><button title="Generar OS" type="button" name="btnver"    id="btnGenerarOs" value="Generar OS" onclick="act_comprobante();" ><img align="absmiddle" src="../../images/block.png" width="15" height="15" />Ver Documentos Emitidos</button></div>
    </td>*/-->



	<td width="77%"><div id="verdocumen"><button title="visualizar" type="button" name="btnver"    id="btnver" value="visualizar" onclick="fVisualDocument();" ><img align="absmiddle" src="../../images/block.png" width="15" height="15" />Ver Doc.</button></div></td>
</tr>
</table>
  </td></tr>
  <tr>
    <td ><table  width="100%">
      <tr>
        <td colspan="6"><div id="muesguarda" title="Confirmacion" style="display:none">Desea guardar el Certificado..?</div><div id="confirmaGuarda"></div></td>
       </tr>

      <tr>
        <td width="13%"><span class="camposss">Nro Legalización:</span></td>
        <td width="19%"><div id="resul_certi" style="width:100px;">

        	<input name="num_certificado" type="text" id="num_certificado" style="text-transform:uppercase" size="15" readonly value="<?php echo isset($rowData['idLegalizacion'])?$rowData['idLegalizacion']:''; ?>" placeholder="Autogenerado"  onKeyUp="return validacion3(this)"/>
        	<input type="hidden" id="idLegalizacion" name="idLegalizacion" value="<?php echo isset($rowData['idLegalizacion'])?$rowData['idLegalizacion']:''; ?>">
        </div></td>
        <td width="11%"><span class="camposss">Fecha Ingreso:</span> </td>
        <td width="23%"><input name="fec_ingreso" type="text" id="fec_ingreso" style="text-transform:uppercase" size="15" value="<?php echo date("d/m/Y"); ?>"  class="tcal" onKeyUp = "this.value=formateafecha(this.value);" /></td>

        </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>
    <fieldset>
    
    <legend><strong><span class="camposss">SOLICITANTE</span></strong></legend>
    
    <table  width="100%">
    
      <tr>
          <td><span class="camposss">Identificado con:</span></td>
          <td width="23%" colspan="-1"><?php 
			$oCombo = new CmbList()  ;					 		
			$oCombo->dataSource = "SELECT tipodocumento.codtipdoc AS 'id', tipodocumento.destipdoc AS 'des'
FROM tipodocumento
ORDER BY tipodocumento.destipdoc ASC"; 
			$oCombo->value      = "id";
			$oCombo->text       = "des";
			$oCombo->size       = "200"; 
			$oCombo->name       = "tipdoc_solic";
			$oCombo->style      = "camposss"; 
			$oCombo->click      = "validar_documento2()";   
			$oCombo->selected   = "01";
			$oCombo->Show();
			$oCombo->oDesCon(); 
?></td>
          <td width="9%" colspan="-1" align="right"><span class="camposss">Nro:</span></td>
          <td width="54%" colspan="-1"><input name="numdoc_solic" type="text" id="numdoc_solic" onkeypress="send(event);" style="text-transform:uppercase" size="15" maxlength="20" placeholder="Num. Docum." /></td>
        </tr>
  </TABLE>
        <div id="rpta_bus">
        <table width="100%">
        </table>
 		 </div>
         <table>


   <tr>
    		<td width="18%"><span class="camposss">Dirección</span></td>
    		<td width="30%"><input style="width: 100%;" type="text" id="direCertificado" value="<?php echo isset($rowData['direCertificado'])?$rowData['direCertificado']:''; ?>" name="direCertificado"></td>
    </tr>
  <tr style="display: none;">
          <td><span class="camposss">Condición:</span></td>
          <td colspan="3"><input name="motivo_solic" value=".." type="text" id="motivo_solic" style="text-transform:uppercase" size="100" maxlength="2000" onkeypress="return tabulador(this, event);return soloLetras(event)" /></td>
  </tr>
  <tr>
  	<td><button type="button" onclick="fncAddSolicitante();">Agregar Solicitante</button></td>
  </tr>
  <tr> 
  	<td colspan="2">
  		<table style="width: 60%;" cellpadding="0" cellspacing="0" class="clDataSolicitante"  border="1" style="border-style: dotted;border-width: 2px;"><tbody id="containerFilas">
  			<tr>
  				<td align="center"><span class="camposss">N°</span></td>
  				<td align="center"><span class="camposss">Nombre</span></td>
  				<td align="center"><span class="camposss">DNI</span></td>
  				<td align="center"><span class="camposss">Condición</span></td>
  				<td align="center"><span class="camposss">Accion</span></td>
  			</tr>
 <?php
 $sqlClient="SELECT sl.idSolicitanteLocalizacion AS id_solicitante,
					c.idcliente,
					sl.nombreSolicitante AS nombre,
					sl.numdoc,
					sl.condicion 
			FROM solicitantelegalizacion AS sl
			INNER JOIN cliente AS c ON c.numdoc=sl.numdoc
			WHERE idLocalizacion=$id ORDER BY sl.idSolicitanteLocalizacion";

 $queryCliente=mysql_query($sqlClient);
 $i=1;
	while($rowCliente=mysql_fetch_array($queryCliente))
 	{

?>
<tr id="containerSolicitante<?php echo $rowCliente["numdoc"];?>">
	<td><?php echo $i;?></td>
	<td><?php echo $rowCliente["nombre"];?></td>
	<td><?php echo $rowCliente["numdoc"];?></td>
	<td><?php echo $rowCliente["condicion"];?></td>
	<td>
		<a href="#" onclick="newclient('<?php echo $rowCliente['idcliente'];?>')"><img src="../../iconos/editacontrar.png" title="Editar Contratante" width="22" height="22" border="0"></a>&nbsp;&nbsp;&nbsp;
		<a href="#" onclick="eliminarSolicitante(<?php echo $rowCliente['id_solicitante'];?>,'<?php echo $rowCliente['numdoc'];?>')"><img src="../../iconos/eliminacontrar.png" title="Eliminar Contratante" width="22" height="22" border="0"></a>
	</td>
</tr>


<?php
$i++;
 	}
  ?>
  		</table>
  	</td>
  </tr>
        </table>
    </fieldset>  
      </td>
    </tr>
    <tr>
    	<td>
    		<br>
    		<button type="button" onclick="fncMostrarCuerpo();">Mostrar</button>
    		<br>
    	</td>
	</tr>
  <tr>

    <td height="30"><fieldset>
      <legend><strong><span class="camposss">CUERPO</span></strong></legend>
      <table  width="100%">
        <tr>
          
          <td colspan="4"><label for="texto_cuerpo"></label>
            <textarea style="text-transform:uppercase;" onkeypress="return tabulador(this, event);" name="texto_cuerpo" id="texto_cuerpo" cols="95" rows="5">
            	<?php echo trim($rowData["documento"]); ?>
            </textarea></td>
        </tr>
        
        
        <tr>
     
          
          <td width="30%">&nbsp;</td>
          <td width="1%" align="right">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
          <td width="1%">&nbsp;</td>
        </tr>
        <tr>
        </tr>
        <tr>
          <td colspan="5"><input name="justifi_cuerpo" type="hidden" id="justifi_cuerpo" /></td>
        </tr>
        <tr>
          <td colspan="5"><input name="id_domiciliario" type="hidden" id="id_domiciliario" /><input name="idprofesionc" type="hidden" id="idprofesionc" size="15" /></td>
          </tr>
        </table>
    </fieldset></td>
  </tr>
</table>
</form>
</div>
<div id="clientenewdni" class="dalib" style="display:none; z-index:7;">
<input type="hidden" name="hdnIdCliente" id="hdnIdCliente" value="0">
                          <table width="760" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="18" height="29">&nbsp;</td>
                              <td width="707" class="">Agregar Cliente</td>
                              <td width="35"><a  onclick="cerrar2();"><img src="../../iconos/cerrar.png" width="21" height="20" /></a></td>
                            </tr>
                            <tr>
                              <td colspan="3"><table width="724" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="724" height="54" bgcolor="#FFFFFF"><div id="busclie" style=" width:720px; height:230px; overflow:auto">
                                    <table width="607" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10" height="30">&nbsp;</td>
    <td width="119" height="30" align="right"><span class="camposss">Apellido Paterno :</span></td>
    <td width="180" height="30"><input type="text" name="napepat" style="text-transform:uppercase" id="napepat" onkeyup="apepaterno();" /><input type="hidden" name="apepat" style="text-transform:uppercase" id="apepat" /><span style="color:#F00">*</span></td>
    <td width="119" height="30" align="right"><span class="camposss">Apellido Materno :</span></td>
    <td width="179" height="30"><input type="text" name="napemat" style="text-transform:uppercase" id="napemat" onkeyup="apematerno();" /><input type="hidden" name="apemat" style="text-transform:uppercase" id="apemat" /></td>
	<div style="position:absolute;right:40px;top:40px;cursor:pointer;"><a onclick="consultar_dni()"><img style="box-shadow:0px 0px 5px 0px gray;border-radius:5px" src="../../iconos/icon-reniec.png" alt="" width="100px" id="iconReniec"><img id="loaderReniec" style="display: none" src="../../loading.gif" id="iconReniec"></a></div>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">1er Nombre :</span></td>
    <td height="30"><input type="text" name="nprinom" style="text-transform:uppercase" id="nprinom" onkeyup="prinombre();" /><input type="hidden" name="prinom" style="text-transform:uppercase" id="prinom" /><span style="color:#F00">*</span></td>
    <td height="30" align="right"><span class="camposss">2do Nombre :</span></td>
    <td height="30"><input type="text" name="nsegnom" style="text-transform:uppercase" id="nsegnom" onkeyup="segnombre();" /><input type="hidden" name="segnom" style="text-transform:uppercase" id="segnom" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Direccion :</span></td>
    <!-- <td height="30" colspan="3"><input name="ndireccion" style="text-transform:uppercase" type="text" id="ndireccion" size="55" onkeyup="direccion();" /><input name="direccion" style="text-transform:uppercase" type="text" id="direccion" size="55" /><span style="color:#F00">*</span></td> -->
    <td height="30" colspan="3"><input name="direccion" style="text-transform:uppercase" type="text" id="direccion" size="55" /><span style="color:#F00">*</span></td>
  </tr>
  <tr>
    <td height="44">&nbsp;</td>
    <td height="44" align="right"><span class="camposss">Ubigeo :</span></td>
    <td height="44" colspan="3"><table width="471" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="336"><input name="ubigensc" readonly type="text" id="ubigensc" size="40" /><span style="color:#F00">*</span></td>
        <td width="135"><a href="#" onclick="mostrar_desc('buscaubisc')"><img src="../../iconos/seleccionar.png" width="94" height="29" border="0" /></a>
      <div id="buscaubisc" style="position:absolute; display:none; width:637px; height:223px; left: -8px; top: 146px; z-index:20; background:#CCCCCC; border: 1px solid #333333; border: 1px solid #264965; -moz-border-radius: 13px; -webkit-border-radius: 13px; border-radius: 13px; -moz-box-shadow: 0px 0px 5px #000000; -webkit-box-shadow: 0px 0px 5px #000000; box-shadow: 0px 0px 5px #000000;">
        <table width="637" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="24" height="29">&nbsp;</td>
            <td width="585"><strong><span class="camposss">Seleccionar Ubigeo:</span></strong></td>
            <td width="28"><a href="#" onclick="ocultar_desc('buscaubisc')"><img src="../../iconos/cerrar.png" width="21" height="20" border="0" /></a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><label>
              <input name="_buscaubisc" type="text" id="_buscaubisc"  style="background:#FFFFFF; text-transform:uppercase;" size="50" onkeypress="buscaubigeossc()" />
            </label></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div id="resulubisc" style="width:585px; height:150px; overflow:auto"></div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Estado Civil :</span></td>
    <td height="30"><select name="idestcivil" id="idestcivil">
      <option value = "0" selected="selected">SELECCIONE ESTADO</option>
      <?php
	   	  $civil=mysql_query("SELECT * FROM tipoestacivil",$conn) or die(mysql_error());
		  while($rowcicil=mysql_fetch_array($civil)){
		  echo "<option value = ".$rowcicil["idestcivil"].">".nl2br($rowcicil["desestcivil"])."</option>";  
		  }
		?>
    </select></td>
    <td height="30" colspan="2" align="left"><div id="casado" style="display:none">
      <table width="272" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="139" align="right"><span class="camposss">Conyuge :</span></td>
          <td width="133"><a href="#" onclick="mostrar_desc('conyugesss')"><img src="../../iconos/grabarconyuge.png" width="111" height="29" border="0" /></a></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Sexo :</span></td>
    <td height="30"><select name="sexo" id="sexo">
      <option value = "" selected="selected">SELECCIONE SEXO</option>
      <option value="M">MASCULINO</option>
      <option value="F">FEMENINO</option>
    </select></td>
    <td height="30" align="right">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Nacionalidad :</span></td>
    <td height="30"><select name="nacionalidad" id="nacionalidad" style="width:150px;">
      <option value = "177" selected="selected">PERUANA</option>
      <?php
	      $naci =mysql_query("SELECT * FROM nacionalidades order by desnacionalidad asc",$conn) or die(mysql_error());
		  while($rownaci=mysql_fetch_array($naci)){
		  echo "<option value = ".$rownaci["idnacionalidad"].">".nl2br($rownaci["descripcion"])."</option>";  
		  }
		?>
    </select></td>
    <td height="30" align="right"><span class="camposss">Residente :</span></td>
    <td height="30"><label>
      <select name="residente" id="residente">
        <option value="1" selected="selected">SI</option>
        <option value="0">NO</option>
                  </select>
    </label></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Natural de :</span></td>
    <td height="30"><input type="text" style="text-transform:uppercase" name="natper" id="natper" /></td>
    <td height="30" align="right"><span class="camposss">Fecha de Nac. :</span></td>
    <td height="30"><input name="cumpclie" type="text" class="tcal" id="cumpclie" style="text-transform:uppercase" size="20" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Telefono Cel. :</span></td>
    <td height="30"><input name="telcel" type="text" id="telcel" size="20" /></td>
    <td height="30" align="right"><span class="camposss">Telefono Oficina :</span></td>
    <td height="30"><input name="telofi" type="text" id="telofi" size="20" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Telefono Fijo :</span></td>
    <td height="30"><input name="telfijo" type="text" id="telfijo" size="20" /></td>
    <td height="30">&nbsp;</td>
    <td height="30">&nbsp;</td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right"><span class="camposss">Email :</span></td>
    <td height="30" colspan="3"><input name="email" type="text" id="email" size="60" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td height="30" align="right">&nbsp;</td>
    <td height="30"><a  id="btnEditar" style="border-radius:8px; border:2px solid lightgray;padding:6px 5px;font-style:italic;letter-spacing:1px;font-family:tahoma;font-weight:bolder;color:gray;cursor:pointer;text-align:center" onclick="ggEditarclie1dom()" >Editar</a></td>
    <td height="30"><a  id="btnGrabar" onclick="ggclie1dom()"><img src="../../iconos/grabar.png" width="94" height="29" border="0" /></a></td>
    <td height="30">&nbsp;</td>
    <td height="30"><input name="codubisc" type="hidden" id="codubisc" size="15" /><input name="idprofesion" type="hidden" id="idprofesion" size="15" value="0" /><input name="idcargoo" type="hidden" id="idcargoo" size="15" value="0" />
      <input name="nomcargoss" type="hidden" id="nomcargoss" size="40" />
      <input name="nomprofesiones" type="hidden" id="nomprofesiones" size="40" />
      <input type="hidden" name="docpaisemi" id="docpaisemi" value="PERU" /></td>
  </tr>
</table>
                                    </div></td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table>
                      </div>
<div id="clientenew" class="dalib" style="display:none; z-index:7; color: #F90; font-weight: bold; font-family: Calibri; font-style: italic;">
                          <table width="760" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="18" height="29">&nbsp;</td>
                              <td width="707" class="editcampp">Agregar Cliente</td>
                              <td width="35"><a  onclick="cerrar()"><img src="../../iconos/cerrar.png" width="21" height="20" /></a></td>
                            </tr>
                            <tr>
                              <td height="233" colspan="3"><table width="724" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="724" height="54" bgcolor="#FFFFFF"><div id="busclie" style=" width:720px; height:230px; overflow:auto">
                                      <table width="637" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                                        <tr>
                                          <td height="32" align="right" ><span class="camposss">Razón Social</span></td>
                                          <td height="32" >&nbsp;</td>
                                          <td height="32" colspan="5"> <input name="nrazonsocial" type="text" style="text-transform:uppercase" id="nrazonsocial" size="60" onkeyup="razonsociall();" />
      <input name="razonsocial" type="hidden" style="text-transform:uppercase" id="razonsocial" size="60" />
      <span style="color:#F00">*</span>
                                            <div id="menucondicion" class="menucondicion" style="display:none; z-index:3;" >
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
                                                      <td width="725"><div id="tipocondicion" class="tipoacto"></div></td>
                                                    </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td width="620" height="10">&nbsp;</td>
                                                  <td width="95"><a href='#' onclick="ocultar_desc('menucondicion')"><img src="../../iconos/aceptar.jpg" alt="" width="95" height="29" border="0" /></a></td>
                                                  <td height="10">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="3" align="center" valign="middle"></td>
                                                </tr>
                                                <tr></tr>
                                              </table>
                                            </div></td>
                                        </tr>
                                        <tr>
                                          <td height="26" align="right" ><span class="camposss">Domicilio Fiscal</span></td>
                                          <td height="26" >&nbsp;</td>
                                          <td height="26" colspan="5"><input name="ndomfiscal" style="text-transform:uppercase" type="text" onkeyup="domfiscall();" id="ndomfiscal" size="60" /><input name="domfiscal" style="text-transform:uppercase"  type="hidden" id="domfiscal" size="60" /><span style="color:#F00">*</span></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" ><span class="camposss">Ubigeo</span></td>
                                          <td height="0" >&nbsp;</td>
                                          <td height="0" colspan="5" valign="middle"><table width="522" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="428"><input name="ubigen" readonly type="text" id="ubigen" size="60" />
                                                <span style="color:#F00">*</span></td>
                                              <td width="94"><a href="#" onclick="mostrar_desc('buscaubi')"><img src="../../iconos/seleccionar.png" width="94" height="29" border="0" /></a></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" ><span class="camposss"><span class="camposss">Contacto</span></td>
                                          <td height="0" >&nbsp;</td>
                                          <td height="0" colspan="5"><input name="contacempresa" style="text-transform:uppercase" type="text" id="contacempresa" size="60" /></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" ><span class="camposss">Fecha de Const.</span></td>
                                          <td height="30" >&nbsp;</td>
                                          <td width="155" height="30"><input type="text" name="fechaconstitu" class="tcal" style="text-transform:uppercase" id="fechaconstitu" /></td>
                                          <td width="15" height="30" >&nbsp;</td>
                                          <td width="138" height="30" align="right" ><span class="camposss">Nº de Registro</span></td>
                                          <td width="14" height="30" >&nbsp;</td>
                                          <td height="30" ><input type="text" name="numregistro" style="text-transform:uppercase" id="numregistro" /></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" ><span class="camposss">Sede Registral</span></td>
                                          <td height="30" >&nbsp;</td>
                                          <td height="30"><label><span class="titupatrimo">
                                            <select name="idsedereg3" id="idsedereg3">
                                            <option selected="selected" value="09">IX - Lima</option>
                                              <?php
		   
		   $sqlsedesss=mysql_query("SELECT * FROM sedesregistrales",$conn) or die(mysql_error()); 
	       while($rowsedesss = mysql_fetch_array($sqlsedesss)){
	         echo "<option value=".$rowsedesss['idsedereg'].">".$rowsedesss['dessede']."</option> \n";
             }
	     ?>
                                            </select>
                                          </span></label></td>
                                          <td height="30">&nbsp;</td>
                                          <td height="30" align="right" ><span class="camposss">N° de Partida</span></td>
                                          <td height="30" >&nbsp;</td>
                                          <td height="30" ><label>
                                            <input type="text" name="numpartida" style="text-transform:uppercase" id="numpartida" />
                                          </label></td>
                                        </tr>
                                        <tr>
                                          <td width="141" height="30" align="right" ><span class="camposss">Telefono</span></td>
                                          <td width="10" height="30" >&nbsp;</td>
                                          <td height="30"><label>
                                            <input type="text" name="telempresa" style="text-transform:uppercase" id="telempresa" />
                                          </label></td>
                                          <td height="30">&nbsp;</td>
                                          <td height="30" align="right" ><span class="camposss">CIIU</span></td>
                                          <td height="30" >&nbsp;</td>
                                          <td height="30" ><label>
                                            <select style="width:200px;" name="actmunicipal" id="actmunicipal">
                                            <option value="">SELECCIONAR</option>
                                              <?php
		   
		   $sqlciiu=mysql_query("SELECT * FROM ciiu",$conn) or die(mysql_error()); 
	       while($rowciuu = mysql_fetch_array($sqlciiu)){
	         echo "<option value=".$rowciuu['coddivi'].">".$rowciuu['nombre']."</option> \n";
             }
	     ?>
                                            </select>
                                          </label></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" ><span class="camposss">Correo de la empresa</span></td>
                                          <td height="30" >&nbsp;</td>
                                          <td height="30" colspan="5" valign="middle" ><label>
                                            <input name="mailempresa" type="text" id="mailempresa" size="60" />
                                          </label>
                                            <div id="buscaubi" style="position:absolute; display:none; width:637px; height:223px; left: 50px; top: 120px; z-index:20; background:#CCCCCC; border: 1px solid #333333; border: 1px solid #264965; -moz-border-radius: 13px; -webkit-border-radius: 13px; border-radius: 13px; -moz-box-shadow: 0px 0px 5px #000000; -webkit-box-shadow: 0px 0px 5px #000000; box-shadow: 0px 0px 5px #000000;">
                                              <table width="637" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td width="24" height="29">&nbsp;</td>
                                                  <td width="585" class="camposss">Seleccionar Ubigeo:</td>
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
                                          </div></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="right" >&nbsp;</td>
                                          <td height="30" >&nbsp;</td>
                                          <td height="30" colspan="5" ><a  onclick="ggclie1dom2()"><img src="../../iconos/grabar.png" width="94" height="29" border="0" />
                                            <input name="codubi" type="hidden" id="codubi" size="15" />
                                          </a></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table>
                      </div>
</body>
</html>





 <div id="dvOrdenServicio" style="display:none;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	-moz-box-shadow: 0px 0px 7px #000000;
	-webkit-box-shadow: 0px 0px 7px #000000;
	box-shadow: 0px 0px 7px #000000;
    border:solid;width:68%;
	height:300px;
	position:absolute;
	left: -150px;
	top: 10%;
	margin-left: 25%;padding:10px;
	zoom: 1;z-index:99;background:#264965;">
<div >
	<table>
		<tr> 
			<td width="250" class="editcampp" style="color: black;font-weight: bold;">
				<span  style="cursor:pointer;" onclick="ocultar_desc('dvOrdenServicio');">
					<img src="../../iconos/cerrar.png" />
					Cerrar
				</span>
				&nbsp;&nbsp;&nbsp;
				<span style="cursor: pointer;" onclick="crearOs();">
				 	<img src="../../iconos/add.png"/>
				 	 Nuevo
				 </span>
				
			</td>  
			<td width="150" class="editcampp" style="color: black;font-weight: bold;"> <br>
				
			 </td> 
		</tr>
	</table>
</div>
	<div style=" color:white; font-size: 15px;">
	</div>
    	<div id="rsptOrdenServicios" style="height: 200px; overflow-y: scroll;">
    		
    	</div>
    </div>


<div style="background: #E0E0E0;
	border: 1px solid #333333;
	-moz-box-shadow: 0px 0px 7px #000000;
	-webkit-box-shadow: 0px 0px 7px #000000;
	box-shadow: 0px 0px 7px #000000;
	width: 60%;
	height: 30%;
	min-height: 30%;
	position: absolute;
	left: 40%;
	top: 5%;
	margin-top: -300px;
	margin-left: -250px;
	overflow:auto;
	zoom: 1;display:none;width:50%;margin-left:25%;left:0%;top:50%;" id="comprobante_carta">
		
</div>



</body>
</html>