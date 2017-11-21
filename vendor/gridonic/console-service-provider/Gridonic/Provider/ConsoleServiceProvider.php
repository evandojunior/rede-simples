<?php

namespace Gridonic\Provider;

use Gridonic\Console\Application as ConsoleApplication;
use Gridonic\Console\ConsoleEvent;
use Gridonic\Console\ConsoleEvents;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Console service provider class
 *
 * @package Gridonic\Provider
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['console'] = $app->share(function () use ($app) {
            $console = new ConsoleApplication(
                $app,
                $app['console.project_directory'],
                $app['console.name'],
                $app['console.version']
            );

            // Set silex event dispatcher
            $console->setDispatcher($app['dispatcher']);

            $app['dispatcher']->dispatch(ConsoleEvents::INIT, new ConsoleEvent($console));

            return $console;
        });
    }

    public function boot(Application $app)
    {
    }
}
