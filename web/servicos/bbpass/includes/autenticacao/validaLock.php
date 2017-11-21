<?php
require_once("../../../../Connections/bbpass.php");
require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php");
//--
$modulo = new Modulo();
$modulo->dadosModulo($database_bbpass, $bbpass, (int)$_GET['i']);
exit($modulo->bbp_adm_loc_arquivo);