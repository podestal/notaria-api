	<?php
    
    include("../../extraprotocolares/view/funciones.php");
    
    $conexion = Conectar();
    
	$id_servicio = $_REQUEST['id']; 
	
	echo $sql_delserv = "delete from estudioabogado where idest= '$id_servicio'";
				  
    $exe_delserv = mysql_query($sql_delserv, $conexion);
	
	?>