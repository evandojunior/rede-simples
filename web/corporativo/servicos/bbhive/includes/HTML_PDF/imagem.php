<?php
$file = 'http://projeto12.backsite.com.br/datafiles/servicos/bbhive/corporativo/images/sistema/cabecalho.jpg';
//echo file_get_contents($file);
//exit;
error_reporting(E_ALL);
$data = '';
$check = fopen($file,"rb");
if (!$check) { echo "Failed to fopen the file. HTTP response header was: "; print_r($http_response_header); exit; }
fclose($check);
$data = file_get_contents($file);
if (!$data) { echo "Failed to 'file_get_contents' the file. HTTP response header was: "; print_r($http_response_header); exit; }
//header("Content-type: image/jpg");
echo $data;
exit;
?>