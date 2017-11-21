<?php

use Symfony\Component\HttpFoundation\Request;

// Auth
$app->before(function (Request $request) use ($app) {
    Project\Core\Security\SecurityProvider::auth($app, $request);
});

// Default
$app->get('/api', function () use ($app) {
    return json_encode(array("content" => "Welcome workflow app - " . date('Y-m-d H:i:s')));
});

// Rede Simples
$app->mount('/api/servicos/bbhive/rede-simples', new Project\BBHive\Controller\RedeSimplesController());