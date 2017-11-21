<?php
// Uso do Silex para execução de todos os processos
require_once __DIR__ . "/../../../../../../vendor/autoload.php";
$app = require __DIR__ . "/../../../../../../app/app.php";

// Usuário padrão para integracao rede simples
$userDefault = $app['api.rede_simples.user_token'];

$user = $app['db.orm.em']->getRepository(\Project\Core\Entity\BbhUsuario::class)->findOneByBbhUsuIdentificacao($userDefault);
if (empty($user)) {
    throw new \Exception("Usuário não encontrado");
}

// Viabilidade
$wsViabilidade = $app['longevo.api.rede_simples.ws_viabilidade']->executeViabilidadesPendentes($app['db.orm.em'], $user);

echo "<center><h2>Integração com Junta Comercial</h2></center>";
echo "<hr>";

echo $wsViabilidade['viabilidades'];
echo "<br>{$wsViabilidade['totalSincronizado']} protocolos recepcionados.<br>";

echo "<hr>";
echo sprintf("<strong>%s</strong>", date('d/m/Y H:i:s'));