<?php
	include("../../conexion.php");
	
$sql="select * from servidor where idservidor='1'";
$rpta=mysql_query($sql,$conn) or die(mysql_error());
$row=mysql_fetch_array($rpta);
$server = $row['nombre'];
//$ruta    = "C:/Doc_Generados/poderes/";	
//$archivo = "Carta202.odt"; 
#####################
$num_carta        = $_REQUEST["numcarta"];
$usuario_imprime  = $_REQUEST["usuario_imprime"];
$nom_notario      = $_REQUEST["nom_notario"];
//$numdocu        = $_REQUEST["numdocu"];
$anioKardex = explode('-',$num_carta);
//Carta000024-2013.odt
$nom  = "__CARTA__".$num_carta;
//echo $nom; exit();
# disco
$disk = "C:/";
# carpeta base
$mainfile = "\Doc_Generados/cartas/".$anioKardex[1].'/';

//$rutageneral = "\\"."\\".$server.$mainfile;

$rutageneral = 'C:/Doc_Generados/cartas/'.$anioKardex[1].'/';
	
$ruta = $rutageneral;	
$archivo = $nom.".docx"; 

$root = $ruta;
$file = basename($archivo);
$path = $root.$file;
$type = '';
 
if (is_file($path))
{
	 $size = filesize($path);
	 if (function_exists('mime_content_type')) 
	 {
		$type = mime_content_type($path);
	 }
	 else if (function_exists('finfo_file')) 
	 {
		$info = finfo_open(FILEINFO_MIME);
		$type = finfo_file($info, $path);
		finfo_close($info);
	 }
	 
	 if ($type == '')
	 {
		//$type = "application/octet-stream"; #
		$type = "application/force-download";
	 }
	 // Definir headers
	 // header('Content-Description: File Transfer'); #
	/* header("Content-Type: $type");
	 header("Content-Disposition: attachment; filename=$file");
	 header("Content-Transfer-Encoding: binary");
	 // header('Expires: 0'); #
	 // header('Cache-Control: must-revalidate'); #
	 // header('Pragma: public'); # 
	 header("Content-Length: " . $size);
	 // Descargar archivo
	  ob_clean();
    flush();
	 readfile($path);
	 */
	 
	############################################################################
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$file);
	header('Content-Transfer-Encoding: binary');
	header("Content-Type: application/download");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . $size);
	ob_clean();
	flush();
	readfile($path);
	exit;
	############################################################################

}
else
{
	die("El archivo no se encuentra...!");
}

?>