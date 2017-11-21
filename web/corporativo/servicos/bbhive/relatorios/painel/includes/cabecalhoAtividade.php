<?php
$caminho = "/corporativo/servicos/bbhive/tarefas/acao/includes/classeAtividade.php";
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico'].$caminho);

$atividade = new atividade();
$atividade->setLinkConnection($bbhive);
$atividade->setDefaultDatabase($database_bbhive);
$atividade->execute($bbh_ati_codigo);
?>