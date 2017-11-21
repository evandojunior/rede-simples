# ConsoleServiceProvider

Provides a `Symfony\Component\Console` based console for Silex.

## Install

The recommended way to install ConsoleServiceProvider is [through composer](http://getcomposer.org).

You can either add it as a depedency to your project using the command line:

    $ composer require gridonic/console-service-provider

or by adding it directly to your ```composer.json``` file:

```json
{
    "require": {
        "gridonic/console-service-provider": "1.0.*"
    }
}
```

Run these two commands to install it:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

Now you can add the autoloader, and you will have access to the library:

```php
<?php
require 'vendor/autoload.php';
```

Register the service provider with your Silex application

```php
<?php

use Gridonic\Provider\ConsoleServiceProvider;

$app->register(new ConsoleServiceProvider(), array(
    'console.name' => 'MyApplication',
    'console.version' => '1.0.0',
    'console.project_directory' => __DIR__.'/..'
));

?>
```

You can now copy the `console` executable in whatever place you see fit, and tweak it to your needs.
You will need a way to fetch your silex application, the most common way is to return it from your bootstrap:

```php
<?php

$app = new Silex\Application();

// Your beautiful silex bootstrap

return $app;

?>
```

For the rest of this document, we will assume you do have an `app` directory, so the `console` executable will be located at `app/console`.

## Usage

Use the console just like any `Symfony\Component` based console:

```
$ app/console my:command
```

## Write commands

Your commands should extend `Gridonic\Command\Command` to have access to the 2 useful following commands:

* `getSilexApplication`, which returns the silex application
* `getProjectDirectory`, which returns your project's root directory (as configured earlier)

## Register commands

There are two ways of registering commands to the console application.

### Directly access the console application from the `console` executable

Open up `app/console`, and stuff your commands directly into the console application:

```php
#!/usr/bin/env php
<?php

set_time_limit(0);

$app = require_once __DIR__.'/bootstrap.php';

use My\Command\MyCommand;

$application = $app['console'];
$application->add(new MyCommand());
$application->run();

?>
```

### Use the Event Dispatcher

This way is intended for use by provider developers and exposes an unobstrusive way to register commands in 3 simple steps:

1. Register a listener to the `ConsoleEvents::INIT` event
2. Implement your program logic
3. PROFIT!

Example:

```php
<?php

use My\Command\MyCommand;
use Gridonic\Console\ConsoleEvents;
use Gridonic\Console\ConsoleEvent;

$app['dispatcher']->addListener(ConsoleEvents::INIT, function(ConsoleEvent $event) {
    $app = $event->getApplication();
    $app->add(new MyCommand());
});

?>
```
