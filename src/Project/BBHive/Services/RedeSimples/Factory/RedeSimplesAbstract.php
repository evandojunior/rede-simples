<?php

namespace Project\BBHive\Services\RedeSimples\Factory;

use Project\BBHive\Services\RedeSimples\ApiRedeSimples;
use Project\Core\Exception\Error;
use Project\Core\Helper\ArrayHelper;

/**
 * Class RedeSimplesAbstract
 * @package Project\BBHive\Services
 */
abstract class RedeSimplesAbstract
{
    CONST WS_MAXIMO_REGISTROS = 50;
    CONST WS_SERVICE_RECUPERA_EMPREENDIMENTOS_DEFERIDOS = "recuperaEmpreendimentosDeferidosParaPrefeitura";
    CONST WS_SERVICE_RECUPERA_VIABILIDADES_PENDENTES = "recuperaViabilidadesPendentes";
    CONST WS_SERVICE_CONFIRMA_RECEBIMENTO_VIABILIDADE = "confirmaRecebimentoViabilidade";
    CONST WS_SERVICE_CONFIRMA_RESPOSTA_ANALISE_ENDERECO = "confirmaRespostaAnaliseEndereco";

    /**
     * @var \Project\Core\Services\ApiService
     */
    protected $api;

    /**
     * @var
     */
    protected $webService;

    public function __construct($urlWebService)
    {
        $this->api = new ApiRedeSimples();
        $this->webService = $urlWebService;

        $this->api->setUrlWebService($urlWebService);
    }

    /**
     * @param \DOMDocument $xml
     * @param string $defaultElement
     * @return \DOMNodeList
     */
    protected function extractDataFromXml(\DOMDocument $xml, $defaultElement = 'empreendimento')
    {
        return $xml->getElementsByTagName($defaultElement);
    }

    /**
     * @param array $responseContent
     * @return mixed
     * @throws \Exception
     */
    protected function extractResponse(array $responseContent)
    {
        if (!$respostaProcessamento = ArrayHelper::extractContentIfExists($responseContent, 'respostaProcessamento')) {
            throw new \Exception(Error::NOT_FOUND);
        }

        return $respostaProcessamento;
    }
}
