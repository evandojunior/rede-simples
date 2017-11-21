<?php

use Project\Core\Command;
use Project\BBHive\Command as CommandBPM;
use Symfony\Component\Console\Application;

$console = new Application("WorkFlow API", APP_VERSION);
$console->add(new Command\EmailCommand($app));
$console->add(new CommandBPM\RedeSimplesViabilidadeCommand($app));

return $console;