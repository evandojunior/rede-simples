<?php

require __DIR__.'/params.php';
require __DIR__.'/external.php';

// Local
$app['debug'] = true;
$app['auth'] = true;
$app['locale'] = 'en';
$app['session.default_locale'] = $app['locale'];
$app['translator.messages'] = array(
    'fr' => __DIR__.'/../app/locales/pt-BR.yml',
);

// Root Path
$app['rootPath'] = __DIR__ . '/../../';

// Cache
$app['cache.path'] = __DIR__ . '/../../var/cache';

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => $app['app.params']['db']['driver'],
    'charset'  => 'utf8',
    'host'     => $app['app.params']['db']['host'],
    'dbname'   => $app['app.params']['db']['dbname'],
    'user'     => $app['app.params']['db']['user'],
    'password' => $app['app.params']['db']['password'],
);

// Doctrine (ORM)
$app['orm.proxies_dir'] = $app['cache.path'].'/doctrine/proxies';
$app['orm.default_cache'] = array(
    'driver' => 'filesystem',
    'path' => $app['cache.path'].'/doctrine/cache',
);
$app['orm.em.options'] = array(
    'mappings' => array(
        array(
            'type' => 'annotation',
            'path' => __DIR__.'/../../src',
            'namespace' => 'Project\Core\Entity',
        ),
    ),
);

// User
$app['security.users'] = array(
    $app['app.params']['security']['username'] => array(
        $app['app.params']['security']['role'],
        $app['app.params']['security']['password'],
    )
);

// External API
$app['api.rede_simples.user_token'] = "tecnica@longevo.com.br";