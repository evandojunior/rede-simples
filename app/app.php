<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Project\Core\Doctrine\DoctrineORMServiceProvider;

if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.0.0');
}
$app = new Silex\Application();

// Get command line arguments
$envCommandLine = \Project\Core\Helper\ArrayHelper::getArgByCommandLine('env');
$env = getenv('SYMFONY__ENV') ? getenv('SYMFONY__ENV') : $envCommandLine;

if (empty($env)) {
    $env = 'dev';
}

require __DIR__ . "/../app/config/{$env}.php";

$app->register(new HttpCacheServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());

$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/',
            'form'    => array(
                'login_path'         => '/login',
                'username_parameter' => 'form[username]',
                'password_parameter' => 'form[password]',
            ),
            'logout'    => true,
            'anonymous' => true,
            'users'     => $app['security.users'],
        ),
    ),
));

$app['security.encoder.digest'] = function ($app) {
    return new PlaintextPasswordEncoder();
};

$app->register(new TranslationServiceProvider());

$app['translator'] = $app->extend('translator', function ($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', __DIR__.'/../app/locales/pt-BR.yml', 'fr');
    return $translator;
});

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/log/app.log',
    'monolog.name'    => 'app',
    'monolog.level'   => 300 // = Logger::WARNING
));

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.options'        => array(
        'cache'            => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true
    ),
    'twig.form.templates' => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path'           => array(__DIR__ . '/../app/views')
));

if ($app['debug'] && isset($app['cache.path'])) {
    $app->register(new ServiceControllerServiceProvider());
//    $app->register(new \Silex\Provider\WebProfilerServiceProvider(), array(
//        'profiler.cache_dir' => $app['cache.path'].'/profiler',
//    ));
}

//if (isset($app['assetic.enabled']) && $app['assetic.enabled']) {
//    $app->register(new AsseticServiceProvider(), array(
//        'assetic.options' => array(
//            'debug'            => $app['debug'],
//            'auto_dump_assets' => $app['debug'],
//        )
//    ));
//    $app['assetic.filter_manager'] = $app->share(
//        $app->extend('assetic.filter_manager', function ($fm, $app) {
//            $fm->set('lessphp', new Assetic\Filter\LessphpFilter());
//            return $fm;
//        })
//    );
//    $app['assetic.asset_manager'] = $app->share(
//        $app->extend('assetic.asset_manager', function ($am, $app) {
//            $am->set('styles', new Assetic\Asset\AssetCache(
//                new Assetic\Asset\GlobAsset(
//                    $app['assetic.input.path_to_css'],
//                    array($app['assetic.filter_manager']->get('lessphp'))
//                ),
//                new Assetic\Cache\FilesystemCache($app['assetic.path_to_cache'])
//            ));
//            $am->get('styles')->setTargetPath($app['assetic.output.path_to_css']);
//            $am->set('scripts', new Assetic\Asset\AssetCache(
//                new Assetic\Asset\GlobAsset($app['assetic.input.path_to_js']),
//                new Assetic\Cache\FilesystemCache($app['assetic.path_to_cache'])
//            ));
//            $am->get('scripts')->setTargetPath($app['assetic.output.path_to_js']);
//            return $am;
//        })
//    );
//}
$app->register(new Silex\Provider\DoctrineServiceProvider());

$app->register(new Project\Core\Doctrine\DoctrineORMServiceProvider(), array(
    'db.orm.proxies_dir'           => __DIR__ . '/../var/cache/doctrine/Proxy',
    'db.orm.proxies_namespace'     => 'DoctrineProxy',
    'db.orm.auto_generate_proxies' => true,
    'db.orm.entities'              => array(array(
        'type'      => 'yml',
        'path'      => __DIR__ . '/../src/Project/Core/yml',
        'namespace' => 'Project\Core\Entity',
    )),
));

// Routes
require_once 'routes.php';

return $app;