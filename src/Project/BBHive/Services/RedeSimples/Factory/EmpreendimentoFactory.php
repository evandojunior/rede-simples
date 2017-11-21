<?php

namespace Project\BBHive\Services\RedeSimples\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Project\BBHive\Services\RedeSimples\Empreendimento;
use Project\Core\Exception\Error;
use Project\Core\Helper\ArrayHelper;
use Project\Core\Helper\XML2ArrayHelper;

class EmpreendimentoFactory extends RedeSimplesAbstract
{
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCollectionEmpreendimentosDeferidos()
    {
        return $this->convertArrayToEmpreendimentoCollection(
            $this->getEmpreendimentosDeferidosXml()
        );
    }

    /**
     * @return array
     */
    public function getEmpreendimentosDeferidosXml()
    {
        $xmlResponse = $this->api->getServiceFromXml(
            self::WS_SERVICE_RECUPERA_EMPREENDIMENTOS_DEFERIDOS,
            $this->getParamEmpreendimentosDeferidos()
        );

        $empreendimentosListNew = [];
        $empreendimentosList = $this->extractDataFromXml($xmlResponse, 'empreendimento');
        foreach ($empreendimentosList as $empreendimento)
        {
            $empreendimentosListNew[] = XML2ArrayHelper::DOMDocumentToArray($empreendimento);
        }

        return $empreendimentosListNew;
    }

    public function getEmpreendimentosDeferidosJson()
    {
        $json = $this->api->getServiceFromJson(
            self::WS_SERVICE_RECUPERA_EMPREENDIMENTOS_DEFERIDOS,
            $this->getParamEmpreendimentosDeferidos()
        );
    }

    /**
     * @return array
     */
    protected function getParamEmpreendimentosDeferidos()
    {
        return ['xmlRequerimentoEmpreendimento' =>
            sprintf("<requerimentoEmpreendimentoPrefeitura><maximoRegistros>%s</maximoRegistros></requerimentoEmpreendimentoPrefeitura>", self::WS_MAXIMO_REGISTROS)
        ];
    }

    /**
     * @param array $empreendimentos
     * @return ArrayCollection
     */
    protected function convertArrayToEmpreendimentoCollection(array $empreendimentos)
    {
        $collection = new ArrayCollection();

        foreach ($empreendimentos as $empreendimento) {
            $empreendimentoObject = new Empreendimento();
            $empreendimentoObject->arrayToObject($empreendimento);

            $collection->add($empreendimentoObject);
        }

        return $collection;
    }

    /**
     * @param array $empreendimentos
     * @return mixed|null
     * @throws \Exception
     */
    private function extractEmpreendimentosDeferidos(array $empreendimentos)
    {
        if (!$empreendimentoslist = ArrayHelper::extractContentIfExists($empreendimentos, 'empreendimentos')) {
            throw new \Exception(Error::NOT_FOUND_TAG_EMPREENDIMENTOS);
        }

        if (!$empreendimentoList = ArrayHelper::extractContentIfExists($empreendimentoslist, 'empreendimento')) {
            throw new \Exception(Error::NOT_FOUND_TAG_EMPREENDIMENTO);
        }

        return $empreendimentoList;
    }

    /**
     * @todo Muita responsabilidade =/
     * @param $collectionEmpreendimentos
     * @param $protocoloModel
     * @param $keyNumeroProcesso
     * @param $fieldsAlias
     * @param $user
     * @param $fluxoModel
     * @param $nomeEmpresa
     * @return int
     */
    public function saveEmpreendimentosDeferidos(
        $collectionEmpreendimentos, $protocoloModel, $keyNumeroProcesso, $fieldsAlias, $user, $fluxoModel, &$nomeEmpresa
    ) {
        $totalEmpresasSincronizadas = 0;
        foreach($collectionEmpreendimentos as $empreendimento) {
            $inputData = [];
            $request = new \Symfony\Component\HttpFoundation\Request();

            $fieldsSearch = ["{$keyNumeroProcesso} = '{$empreendimento->getNumeroProcesso()}'"];
            if ($protocoloModel->getProtocolByFieldDetail($fieldsSearch)) {
                continue;
            }

            // Recupera valores
            foreach ($fieldsAlias as $campo => $atributoClasse) {
                $propriedadeClass = sprintf("get%s", ucfirst($atributoClasse));

                $inputData[] = [
                    'name' => $campo,
                    'value' => $empreendimento->$propriedadeClass()
                ];

                $request->request->set($campo, $empreendimento->$propriedadeClass());
            }

            $nomeEmpresa.= sprintf("%s - %s<br>", $empreendimento->getNumeroProcesso(), $empreendimento->getNomeEmpresa());

            // Define campos que sao padroes no sistema
            $request->request->set("bbh_pro_flagrante", "Não");
            $request->request->set("bbh_dep_codigo", $user->getBbhDepCodigo()->getBbhDepCodigo());
            $request->request->set("bbh_pro_data", date('Y-m-d'));

            // Recupera o mesmo fazendo um merge
            $protocoloFields = $fluxoModel->getDynamicFieldsProtocolo($request->request);

            // grava protocolo
            $codProtocolo = $protocoloModel->createProtocolo($user, $protocoloFields);

            $totalEmpresasSincronizadas++;
        }

        return $totalEmpresasSincronizadas;
    }
}
