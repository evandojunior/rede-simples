<?php

namespace Project\Core\Command;

use Silex\Application;

class ContainerAwareCommand extends AbstractCommand
{
    protected $app;
    protected $db;
    protected $output;
    protected $input;

    public function __construct(Application $app, $name = null)
    {
        parent::__construct($name);
        $this->app = $app;
        $this->db = $this->app['db'];
    }
}
