<?php

namespace Gridonic\Console;

use Symfony\Component\EventDispatcher\Event;

/**
 * A silex application based console event
 *
 * @package Gridonic\Console
 */
class ConsoleEvent extends Event
{
    /** @var Application */
    private $application;

    /**
     * Public constructor
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Returns the application
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }
}
