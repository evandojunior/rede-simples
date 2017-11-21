<?php

namespace Project\Core\Controller;

use Project\Core\Helper;
use Project\Core\Exception;
use Silex\Application;

class AbstractController
{
    protected $em;

    protected $security;

    protected $currentHost;

    protected $user;

    protected function setUp(Application $app)
    {
        $this->em = $app['db.orm.em'];
        $this->security = $app['app.params']['security'];
//        $this->currentHost = $app['app.params']['http'];
        $this->user = $app['user'];
    }

    private function getCurrentRoute()
    {
        return get_class($this);
    }

    protected function setRoute($methodName)
    {
        if (!class_exists($this->getCurrentRoute()) || !method_exists($this->getCurrentRoute(), $methodName)) {
            Helper\ResponseHelper::response(
                sprintf(
                    Exception\Error::METHOD_NOT_FOUND,
                    $methodName,
                    $this->getCurrentRoute()
                ),
                Helper\HttpHelper::HTTP_STATUS_INTERNAL_SERVER_ERROR
            );
        }

        return sprintf("%s::%s", $this->getCurrentRoute(), $methodName);
    }
}
