<?php

namespace Project\BBHive\Services\RedeSimples;

use Project\Core\Exception\Error;
use Project\Core\Helper\HttpHelper;

/**
 * Class ApiRedeSimples
 * @package Project\BBHive\Services
 */
class ApiRedeSimples
{
    /**
     * @var string
     */
    protected $keyPem = "/../../../../../database/keys/urbem-cmp.pem";

    /**
     * @var
     */
    protected $urlWebService;

    /**
     * @var
     */
    protected $service;

    /**
     * @return string
     * @throws \Exception
     */
    protected function getKeyAccess()
    {
        $keyPem = sprintf("%s%s", __DIR__, $this->keyPem);

        if (!file_exists($keyPem)) {
            throw new \Exception(Error::FILE_CREDENTIAL_NOT_FOUND);
        }

        return $keyPem;
    }

    /**
     * @return mixed
     */
    public function getUrlWebService()
    {
        return $this->urlWebService;
    }

    /**
     * @param mixed $urlWebService
     */
    public function setUrlWebService($urlWebService)
    {
        $this->urlWebService = $urlWebService;
    }

    /**
     * @return \SoapClient
     * @throws \Exception
     */
    protected function openConnection()
    {
        if (!empty($this->service)) {
            return $this->service;
        }

        $context = stream_context_create(
            [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]
        );

        $this->service = new \SoapClient(
            $this->urlWebService,
            [
                'stream_context'     => $context,
                'local_cert'         => $this->getKeyAccess(),
                'cache_wsdl'         => WSDL_CACHE_NONE,
                'connection_timeout' => 3000000,
            ]
        );

        return $this->service;
    }

    protected function closeConnection()
    {
        $this->service = null;
    }

    /**
     * @param $location
     * @param array $params
     * @return \Project\Core\Helper\DOMDocument
     */
    public function getServiceFromXml($location, array $params)
    {
        $response = $this->getService($location, $params);

        return $this->xmlResponse($response->return);
    }

    /**
     * @param $location
     * @param array $params
     * @return \Project\Core\Helper\DOMDocument
     */
    public function getServiceFromJson($location, array $params)
    {
        $response = $this->getService($location, $params);

        return json_encode(simplexml_load_string($response->return));
    }

    /**
     * @param $location
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function getService($location, array $params)
    {
        if (empty($this->urlWebService)) {
            throw new \Exception(Error::WS_NOT_DEFINED);
        }

        $service = $this->openConnection();
        $resultContent = $service->$location($params);

        $this->closeConnection();
        return $resultContent;
    }

    /**
     * @param $content
     * @return string
     */
    private function xmlResponse($content)
    {
        $xml = new \DOMDocument( "1.0", "UTF-8" );
        $xml->loadXML($content);

        return $xml;
    }

    /**
     * @param $response
     * @return mixed|string
     */
    private function parseJsonToArray($response)
    {
        $response = (object) $response;

        if ($response->statusCode == HttpHelper::HTTP_STATUS_OK) {
            return json_decode($response->content, true);
        }

        return Error::NOT_FOUND;
    }
}
