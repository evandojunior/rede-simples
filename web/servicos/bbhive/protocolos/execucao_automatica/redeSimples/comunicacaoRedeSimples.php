<?php
if(!isset($_SESSION)){session_start();}

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");

// Uso do Silex para execução de todos os processos
require_once __DIR__ . "/../../../../../../vendor/autoload.php";
$app = require __DIR__ . "/../../../../../../app/app.php";

$resCommunicacaoRedeSimples = true;

try {
    $app['longevo.api.rede_simples.ws_viabilidade']->getCollectionViabilidadesDisponiveis();
} catch (\Exception $e) {
    $resCommunicacaoRedeSimples = $e->getMessage();
}