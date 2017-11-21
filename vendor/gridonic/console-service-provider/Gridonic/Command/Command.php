<?php

namespace Gridonic\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * Silex application based command class
 *
 * @package Gridonic\Command
 */
class Command extends BaseCommand
{
    public function getSilexApplication()
    {
        return $this->getApplication()->getSilexApplication();
    }

    public function getProjectDirectory()
    {
        return $this->getApplication()->getProjectDirectory();
    }
}
