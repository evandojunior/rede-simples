<?php
// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;
$app['orm.default_cache'] = 'array';

$app['api.rede_simples.user_token'] = "tecnica@blackbee.com.br";