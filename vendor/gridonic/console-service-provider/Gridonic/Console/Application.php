<?php

namespace Gridonic\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Silex\Application as SilexApplication;

class Application extends BaseApplication
{
    /** @var SilexApplication */
    private $silexApplication;

    /** @var string */
    private $projectDirectory;

    /**
     * Public constructor
     *
     * @param SilexApplication $application
     * @param string $projectDirectory
     * @param string $name
     * @param string $version
     */
    public function __construct(SilexApplication $application, $projectDirectory, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->silexApplication = $application;
        $this->projectDirectory = $projectDirectory;

        $application->boot();
    }

    public function getSilexApplication()
    {
        return $this->silexApplication;
    }

    public function getProjectDirectory()
    {
        return $this->projectDirectory;
    }
}
