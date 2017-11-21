<?php

namespace Project\Core\Helper;

use Symfony\Component\HttpFoundation\Response;

class ResponseHelper
{
    // @TODO - Melhorar response :(
    public static function response($responseContent = null, $codeStatus = 200)
    {
        $response = new Response();
        $response->setStatusCode($codeStatus);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($responseContent, JSON_UNESCAPED_UNICODE));
        $response->send();
        exit;
    }
}
