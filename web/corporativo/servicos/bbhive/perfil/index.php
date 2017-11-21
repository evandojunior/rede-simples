<?php 
if(!isset($_SESSION)){ session_start(); }

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
?>
<div id="menuFluxo"><?php require_once("../includes/colunaEsquerda.php"); ?></div>
<label id="restLoad"></label>