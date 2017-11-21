<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$fechar = "document.getElementById('flu_".$_GET['bbh_flu_codigo']."').innerHTML=''";
//--
if(isset($_GET['exibeFrame'])){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/bbhive.js"></script>
<script type="text/javascript" src="/corporativo/servicos/bbhive/includes/functions.js"></script>
<style type="text/css">
body {
	background: none;
}
</style>
<script type="text/javascript">
function aumentaFrame(){
	window.top.document.getElementById('flu_<?php echo $_GET['bbh_flu_codigo']?>').height = document.body.offsetHeight;
}
</script>
</head>
<body onload="aumentaFrame()">
<?php 
	$fechar = "window.top.document.getElementById('flu_".$_GET['bbh_flu_codigo']."').height = '0';";
} ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="98%" height="5" colspan="3" align="right" style="border-top:#999999 solid 1px;"><a href="#@" onclick="<?php echo $fechar; ?>">Fechar</a></td>
  </tr>
  <tr>
    <td colspan="3"><?php require_once("../tarefas/busca.php");?></td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table><?php
if(isset($_GET['exibeFrame'])){
?>
    </body>
</html>
<?php } ?>