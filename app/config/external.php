<?php

// External plugin
$ws_junta_comercial = "https://projetointegrarhom.jucergs.rs.gov.br:443/empreendimento/service";

// Empreendimento e Viabilidade
$app['api.rede_simples.ws_empreendimento'] = "{$ws_junta_comercial}/EmpreendimentoPrefeituraWS?wsdl";
$app['api.rede_simples.ws_viabilidade'] = "{$ws_junta_comercial}/ViabilidadePrefeituraWS?wsdl";

$webservice = new \Project\BBHive\Services\RedeSimplesService($app);

$app['longevo.api.rede_simples.ws_empreendimento'] = $app->share(function () use ($webservice) {
    return $webservice->build(\Project\BBHive\Services\RedeSimplesService::WS_TIPO_EMPREENDIMENTO);
});

$app['longevo.api.rede_simples.ws_viabilidade'] = $app->share(function () use ($webservice) {
    return $webservice->build(\Project\BBHive\Services\RedeSimplesService::WS_TIPO_VIABILIDADE);
});