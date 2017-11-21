<?php 
require_once("../../../../../Connections/policy.php");
require_once("function.php");

//remove o que interessa
removeFiles($ondeAssinatura);

//variável ondeAssinatura encontra-se no SETUP.PHP
$arquivo = "relatorio".$_GET['id'].".pdf.p7s";

$file = $ondeAssinatura."/".$arquivo; 

// estiver na mesma pagina!! 
 header("Content-Type: application/save");
 header("Content-Length:".filesize($file)); 
 header('Content-Disposition: attachment; filename="' . $arquivo . '"'); 
 header("Content-Transfer-Encoding: binary");
 header('Expires: 0');
 header('Pragma: no-cache');
 
 // nesse momento ele le o arquivo e envia
 $fp = fopen($file, "r");
 fpassthru($fp);
 fclose($fp); 
?>