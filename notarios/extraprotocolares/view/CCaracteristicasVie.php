<?php
session_start();
include("conexion.php");
$id_usuario= $_SESSION["id_usu"];
$sqlu  = mysql_query("SELECT * FROM permisos_usuarios where idusuario = '$id_usuario'",$conn) or die(mysql_error());

$rowu= mysql_fetch_array($sqlu);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cambio de Caracteristicas</title>
<style type="text/css">
div.frmCambioCarac
{ 
  background-color: #ffffff;
border: 4px solid #264965;  

-moz-border-radius: 13px;
-webkit-border-radius: 13px;
border-radius: 13px;
-moz-box-shadow: 0px 0px 5px #000000;
-webkit-box-shadow: 0px 0px 5px #000000;
box-shadow: 0px 0px 5px #000000;
width:900px; height:850px;
}

.titulosprincipales {
	font-family: Calibri;
	font-size: 18px;
	color: #FF9900;
	font-style: italic;
}
.line {color: #FFFFFF}
</style>
</head>

<body>
<div class="frmCambioCarac">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="30" bgcolor="#264965"><table width="900" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="33" height="30"><img src="../../iconos/newproto.png" alt="" width="26" height="26" /></td>
          <td width="328"><span class="titulosprincipales">Cambio de Caracteristicas</span></td>
          <td width="510" align="left"><table width="454" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td width="239" height="30">&nbsp;</td>
              <td width="80">
              <?php
			  if($rowu['newcarac'] == '1')
              {
                    echo'<a href="CambioCaracVie.php" target="ncambio"><img src="../../iconos/nuevo.png" width="62" height="22" border="0" /></a>';
			  }else{
				    echo'<img src="../../iconos/nuevo.png" width="62" height="22" border="0" />';
				  }
			  ?>
              
              </td>
              <td width="17"><span class="line">|</span></td>
              <td width="118"><a href="listCambioCaract.php" target="ncambio"><img src="../../images/search.png" width="22" height="22" border="0" /></a></td>
              </tr>
          </table></td>
          <td width="29">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="19">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><iframe name="ncambio" src="listCambioCaract.php" frameborder="0" width="100%" height="800" allowtransparency="true" scrolling="auto"></iframe></td>
    </tr>
  </table>
</div>
</body>
</html>
