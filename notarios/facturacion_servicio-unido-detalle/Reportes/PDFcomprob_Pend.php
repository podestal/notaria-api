<?php
ob_start();
 
include('IMPREcomprob_Pend.PHP');   
$content_html = ob_get_clean();
require_once('../../html2pdf/html2pdf.class.php'); 
try
{
$html2pdf = new HTML2PDF('l','A4','es', false, 'ISO-8859-15', array(0, 0, 0, 0));
$html2pdf->writeHTML($content_html, isset($_GET['vuehtml']));
$html2pdf->Output('RepComprobantesPend.pdf');
}
catch(HTML2PDF_exception $e) { echo $e; }
$contenido_extra=file_get_contents();
?>