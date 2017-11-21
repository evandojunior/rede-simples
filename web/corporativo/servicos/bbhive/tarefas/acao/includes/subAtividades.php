<?php
if(!isset($_SESSION)){ session_start(); }

require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");

$bbh_flu_codigo = $_GET['bbh_flu_codigo'];
?>
<div>
<?php require_once('../../busca.php'); ?>
</div>