<?php

namespace Project\BBHive\Services\RedeSimples\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Project\BBHive\Services\RedeSimples\Viabilidade;
use Project\Core\Entity\BbhModeloFluxo;
use Project\Core\Entity\BbhProtocolos;
use Project\Core\Entity\BbhUsuario;
use Project\Core\Helper\StringHelper;
use Project\Core\Helper\XML2ArrayHelper;
use Project\Core\Model\BBHive\BbhModeloFluxoModel;
use Project\Core\Model\BBHive\BbhProtocolosModel;
use Doctrine\ORM;

class ViabilidadeFactory extends RedeSimplesAbstract
{
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCollectionViabilidadesDisponiveis()
    {
        return $this->convertArrayToViabilidadeCollection(
            $this->getViabilidadesPentendetesXml()
        );
    }

    /**
     * @return array
     */
    public function getViabilidadesPentendetesXml()
    {
        $xmlResponse = $this->api->getServiceFromXml(
            self::WS_SERVICE_RECUPERA_VIABILIDADES_PENDENTES,
            $this->getParamViabilidadesPendentes()
        );

        $viabilidadesListNew = [];
        $viabilidadesList = $this->extractDataFromXml($xmlResponse, 'viabilidade');

        foreach ($viabilidadesList as $viabilidade)
        {
            $viabilidadesListNew[] = XML2ArrayHelper::DOMDocumentToArray($viabilidade);
        }

        return $viabilidadesListNew;
    }

    /**
     * @param array $viabilidades
     * @return ArrayCollection
     */
    protected function convertArrayToViabilidadeCollection(array $viabilidades)
    {
        $collection = new ArrayCollection();

        foreach ($viabilidades as $viabilidade) {
            $viabilidadeObject = new Viabilidade();
            $viabilidadeObject->arrayToObject($viabilidade);

            $collection->add($viabilidadeObject);
        }

        return $collection;
    }

    /**
     * @return array
     */
    protected function getParamViabilidadesPendentes()
    {
        return ['xmlRequerimentoConsultaViabilidade' =>
            sprintf("<requerimentoConsultaViabilidade><maximoConsultas>%s</maximoConsultas></requerimentoConsultaViabilidade>", self::WS_MAXIMO_REGISTROS)
        ];
    }

    /**
     * @param $codProtocolo
     * @return array
     */
    protected function getParamConfirmaRecebimentoViabilidade($codProtocolo)
    {
        return ['xmlConfirmacaoRecebimentoConsulta' =>
            sprintf("<confirmacaoRecebimentoViabilidade><protocoloViabilidade>%s</protocoloViabilidade></confirmacaoRecebimentoViabilidade>", $codProtocolo)
        ];
    }

    /**
     * @param $codProtocolo
     * @param $situacaoAnaliseEndereco
     * @param $dataValidadeAnalise
     * @return array
     */
    protected function getParamRespostaAnaliseEndereco($codProtocolo, $situacaoAnaliseEndereco, $dataValidadeAnalise)
    {
        return ['xmlRespostaAnaliseEndereco' =>
            sprintf(
                "<respostaAnaliseEndereco><protocoloViabilidade>%s</protocoloViabilidade><analiseEndereco><situacaoAnaliseEndereco>%s</situacaoAnaliseEndereco><dataValidadeAnalise>%s</dataValidadeAnalise></analiseEndereco></respostaAnaliseEndereco>",
                $codProtocolo,
                $situacaoAnaliseEndereco,
                $dataValidadeAnalise
            )
        ];
    }

    /**
     * @param $collectionViabilidade
     * @param \Project\Core\Model\BBHive\BbhProtocolosModel $protocoloModel
     * @param $keyNumeroProcesso
     * @param $fieldsAlias
     * @param $user
     * @param $fluxoModel
     * @param $nomeEmpresa
     * @return int
     */
    public function saveViabilidadesPendentes(
        $collectionViabilidade, BbhProtocolosModel $protocoloModel, $keyNumeroProcesso, $fieldsAlias, $user, $fluxoModel, &$nomeEmpresa
    ) {
        $totalEmpresasSincronizadas = 0;
        foreach($collectionViabilidade as $viabilidade) {
            $inputData = [];
            $request = new \Symfony\Component\HttpFoundation\Request();

            $fieldsSearch = ["{$keyNumeroProcesso} = '{$viabilidade->getNumeroProcesso()}'"];
            if ($protocoloModel->getProtocolByField($fieldsSearch)) {
                continue;
            }

            // Recupera valores
            foreach ($fieldsAlias as $campo => $atributoClasse) {
                $propriedadeClass = sprintf("get%s", ucfirst($atributoClasse));

                $inputData[] = [
                    'name' => $campo,
                    'value' => $viabilidade->$propriedadeClass()
                ];

                $request->request->set($campo, $viabilidade->$propriedadeClass());
            }

            $nomeEmpresa.= sprintf("%s - requerente: %s<br>", $viabilidade->getNumeroProcesso(), $viabilidade->getNomeRequerente());

            // Define campos que sao padroes no sistema
            $request->request->set("bbh_pro_flagrante", "Não");
            $request->request->set("bbh_pro_titulo", "Rede Simples");
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

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Project\Core\Entity\BbhUsuario $user
     * @return array
     */
    public function executeViabilidadesPendentes(ORM\EntityManager $entityManager, BbhUsuario $user)
    {
        $protocoloModel = new \Project\Core\Model\BBHive\BbhProtocolosModel($entityManager);
        $fluxoModel = new \Project\Core\Model\BBHive\BbhModeloFluxoModel($entityManager);
        $fieldsProtocol = $protocoloModel->getFieldsDetailProtocol();
        $nomeEmpresa = "";

        // Somente viabilidade
        $viabilidade = new \Project\BBHive\Services\RedeSimples\Viabilidade();

        $fieldsAlias = $viabilidade->mergeFieldsToForm($fieldsProtocol, $viabilidade->listFieldsViabilidadePendentes);
        $keyNumeroProcesso = $viabilidade->getKeyNumeroProcesso($fieldsAlias);

        $collectionViabilidade = $this->getCollectionViabilidadesDisponiveis();

        $totalViabilidadesSincronizadas = $this->saveViabilidadesPendentes(
            $collectionViabilidade, $protocoloModel, $keyNumeroProcesso, $fieldsAlias, $user, $fluxoModel, $nomeEmpresa
        );

        return ['totalSincronizado' => $totalViabilidadesSincronizadas, 'viabilidades' => $nomeEmpresa];
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return array
     */
    public function confirmaRecebimentoViabilidade(ORM\EntityManager $entityManager, BbhUsuario $user)
    {
        $protocoloModel = new \Project\Core\Model\BBHive\BbhProtocolosModel($entityManager);
        $fieldsProtocol = $protocoloModel->getFieldsDetailProtocol();

        $protocoloRepository = $entityManager->getRepository('Project\Core\Entity\BbhProtocolos');

        // Somente viabilidade
        $viabilidade = new \Project\BBHive\Services\RedeSimples\Viabilidade();
        $campoRecebimento = key($viabilidade->mergeFieldsToForm($fieldsProtocol, $viabilidade->listFieldsConfirmaRecebimentoViabilidades));
        $campoProcesso = key($viabilidade->mergeFieldsToForm($fieldsProtocol, ['processo' => $viabilidade::CAMPO_NUMERO_PROCESSO]));
        $campoProcesso = sprintf("get%s", StringHelper::dashesToCamelCase($campoProcesso, true));

        $fieldsSearch = ["({$campoRecebimento} <> 'Sim' or {$campoRecebimento} is null)"];
        $viabilidadesRecebidasPendentes = $protocoloModel->getProtocolByFieldDetail($fieldsSearch);

        $totalSincronizado = 0;
        foreach ($viabilidadesRecebidasPendentes as $protocoloDetalhes) {
            // Busca Protocolo
            $protocolo = $protocoloModel->getProtocol($protocoloDetalhes->bbh_pro_codigo);
            $numeroProcesso = $protocolo->$campoProcesso();

            if (empty($numeroProcesso)) {
                continue;
            }

            if ($this->sendConfirmaRecebimentoViabilidade($numeroProcesso)) {
                $fieldsList = ["{$campoRecebimento} = 'Sim'"];
                $paramsWhere = ["bbh_det_pro_codigo = {$protocoloDetalhes->bbh_det_pro_codigo}"];
                $protocoloRepository->update($fieldsList, $paramsWhere, $table = 'bbh_detalhamento_protocolo');
                /*$protocoloRepository->update(
                    [sprintf(
                        "bbh_pro_status = '%s', bbh_pro_recebido='%s', bbh_pro_dt_recebido='%s'",
                        BbhProtocolos::STATUS_RECEBIDO,
                        $user->getBbhUsuIdentificacao(),
                        date('Y-m-d H:i:s')
                    )],
                    ["bbh_pro_codigo = {$protocoloDetalhes->bbh_pro_codigo}"],
                    $table = 'bbh_protocolos'
                );*/

                $totalSincronizado++;
            }
        }

        return ['totalSincronizado' => $totalSincronizado];
    }

    /**
     * @param $codProtocolo
     * @return bool
     */
    protected function sendConfirmaRecebimentoViabilidade($codProtocolo)
    {
        $xmlResponse = $this->api->getServiceFromXml(
            self::WS_SERVICE_CONFIRMA_RECEBIMENTO_VIABILIDADE,
            $this->getParamConfirmaRecebimentoViabilidade($codProtocolo)
        );

        $viabilidadesListNew = [];
        $viabilidadesList = $this->extractDataFromXml($xmlResponse, 'tipoRetorno');

        foreach ($viabilidadesList as $viabilidade)
        {
            $viabilidadesListNew[] = XML2ArrayHelper::DOMDocumentToArray($viabilidade);
        }

        return current($viabilidadesListNew) == "SUCESSO";
    }

    private function processaProtocoloSemFluxo($protocoloRepository, $protocoloModel, $fieldsAlias)
    {
        $campoSincronizado = array_search("sincronizadoRedeSimples", $fieldsAlias);
        $campoProtocoloRespostaAnalise = array_search("respostaAnalise", $fieldsAlias);
        $campoProtocoloMotivoAnalise = array_search("motivoAnalise", $fieldsAlias);

        // Todos os protocolos finalizados e não sincronizados
        $fieldsSearch = [
            "({$campoSincronizado} <> 'Sim' or {$campoSincronizado} is null)",
            sprintf("bbh_pro_status IN ('%s', '%s')", BbhProtocolos::STATUS_INDEFERIDO, BbhProtocolos::STATUS_CONCLUIDO),
            "bbh_flu_codigo is null"
        ];
        $processosAnalisadosSemFluxo = $protocoloModel->getProtocoloAndDetalhamento($fieldsSearch);

        // Protocolo
        $totalSincronizado = 0;
        foreach($processosAnalisadosSemFluxo as $protocolo) {
            $xml = simplexml_load_string($protocolo->bbh_pro_obs);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            $motivo = array_pop($array['conversa']);
            $motivo = (object) $motivo['@attributes'];
            $momento = \DateTime::createFromFormat('d/m/Y H:i', $motivo->momento);

            // Popula informações do motivo recuperada no fluxo
            $protocoloJunta = $protocolo->bbh_pro_identificacao;
            $resultadoAnalise = strtoupper($protocolo->bbh_pro_status == BbhProtocolos::STATUS_INDEFERIDO ? "INDEFERIDA" : "DEFERIDA");
            $resultadoMotivoAnalise = $motivo->mensagem;
            $dataValidadeAnalise = str_replace(" ", "T", $momento->format("Y-m-d H:i:s"));

            // Notifica Junta comercial com base em informações do protocolo
            if ($this->sendConfirmaRespostaAnaliseEndereco($protocoloJunta, $resultadoAnalise, $dataValidadeAnalise)) {
                $fieldsList = [
                    sprintf("{$campoProtocoloRespostaAnalise} = '%s'", $resultadoAnalise),
                    sprintf("{$campoProtocoloMotivoAnalise} = '%s'", $resultadoMotivoAnalise),
                    "{$campoSincronizado} = 'Sim'"
                ];
                $paramsWhere = ["bbh_pro_codigo = {$protocolo->bbh_pro_codigo}"];
                $protocoloRepository->update($fieldsList, $paramsWhere, $table = 'bbh_detalhamento_protocolo');

                $totalSincronizado++;
            }
        }

        return $totalSincronizado;
    }

    private function buscaCamposDetalhamentoRedeSimplesPorFluxo($entityManager, $fluxo)
    {
        $repository = $entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoFluxo');

        $fieldsSearch = [
            sprintf("bbh_cam_det_flu_apelido = '%s'", Viabilidade::CAMPO_ANALISE_PROCESSO),
            sprintf("bbh_mod_flu_codigo = '%s'", $fluxo->getBbhModFluCodigo()->getBbhModFluCodigo()),
        ];
        $campoAnaliseProcesso = $repository->findFieldsCampoDetalhamento($fieldsSearch);

        $fieldsSearch = [
            sprintf("bbh_cam_det_flu_apelido = '%s'", Viabilidade::CAMPO_MOTIVO_ANALISE_PROCESSO),
            sprintf("bbh_mod_flu_codigo = '%s'", $fluxo->getBbhModFluCodigo()->getBbhModFluCodigo()),
        ];
        $campoMotivoAnalise = $repository->findFieldsCampoDetalhamento($fieldsSearch);

        return [
            !empty($campoAnaliseProcesso) ? $campoAnaliseProcesso->bbh_cam_det_flu_nome : null,
            !empty($campoMotivoAnalise) ? $campoMotivoAnalise->bbh_cam_det_flu_nome : null
        ];
    }

    private function processaDetalhamentoFluxo($entityManager, $protocolo, $fluxoRepository, $protocoloModel, $fieldsAlias)
    {
        $protocoloRepository = $entityManager->getRepository('Project\Core\Entity\BbhProtocolos');

        $campoSincronizado = array_search("sincronizadoRedeSimples", $fieldsAlias);
        $campoProtocoloRespostaAnalise = array_search("respostaAnalise", $fieldsAlias);
        $campoProtocoloMotivoAnalise = array_search("motivoAnalise", $fieldsAlias);

        $fluxos = $fluxoRepository->findByBbhProtocoloReferencia($protocolo->bbh_pro_codigo);

        $totalSincronizado = 0;
        foreach($fluxos as $fluxo) {
            $detalhesFluxo = $protocoloModel->getDetailWorkflowByFluxo($fluxo);
            if (empty($detalhesFluxo)) {
                continue;
            }

            // Busca campos relacionados ao Rede Simples :D
            list($campoAnaliseProcesso, $campoMotivoAnalise) = $this->buscaCamposDetalhamentoRedeSimplesPorFluxo($entityManager, $fluxo);
            if (empty($campoAnaliseProcesso) || empty($campoMotivoAnalise)) {
                continue;
            }

            // Popula informações do motivo recuperada no fluxo
            $protocoloJunta = $protocolo->bbh_pro_identificacao;
            $resultadoAnalise = strtoupper($detalhesFluxo[$campoAnaliseProcesso]);
            $resultadoMotivoAnalise = $detalhesFluxo[$campoMotivoAnalise];
            $dataValidadeAnalise = str_replace(" ", "T", date("Y-m-d H:i:s"));

            // Notifica Junta comercial com base em informações do protocolo
            if ($this->sendConfirmaRespostaAnaliseEndereco($protocoloJunta, $resultadoAnalise, $dataValidadeAnalise)) {
                $fieldsList = [
                    sprintf("{$campoProtocoloRespostaAnalise} = '%s'", $resultadoAnalise),
                    sprintf("{$campoProtocoloMotivoAnalise} = '%s'", $resultadoMotivoAnalise),
                    "{$campoSincronizado} = 'Sim'"
                ];
                $paramsWhere = ["bbh_pro_codigo = {$protocolo->bbh_pro_codigo}"];
                $protocoloRepository->update($fieldsList, $paramsWhere, $table = 'bbh_detalhamento_protocolo');
                $protocoloRepository->update(
                    [sprintf(
                        "bbh_pro_status = '%s'",
                        ($resultadoAnalise == "DEFERIDA" ? BbhProtocolos::STATUS_CONCLUIDO : BbhProtocolos::STATUS_INDEFERIDO) // Isso pode dar ruim
                    )],
                    ["bbh_pro_codigo = {$protocolo->bbh_pro_codigo}"],
                    $table = 'bbh_protocolos'
                );

                $totalSincronizado++;
            }
        }

        return $totalSincronizado;
    }

    private function processaProtocoloComFluxo($entityManager, $protocoloModel, $fieldsAlias)
    {
        // Repositórios de apoio
        $fluxoRepository = $entityManager->getRepository('Project\Core\Entity\BbhFluxo');
        $protocoloRepository = $entityManager->getRepository('Project\Core\Entity\BbhProtocolos');

        // Protocolos finalizados e não sincronizados
        $campoSincronizado = array_search("sincronizadoRedeSimples", $fieldsAlias);
        $campoProtocoloRespostaAnalise = array_search("respostaAnalise", $fieldsAlias);
        $campoProtocoloMotivoAnalise = array_search("motivoAnalise", $fieldsAlias);

        // Todos os protocolos finalizados e não sincronizados
        $fieldsSearch = [
            "({$campoSincronizado} <> 'Sim' or {$campoSincronizado} is null)",
            sprintf("bbh_pro_status = '%s'", BbhProtocolos::STATUS_CONCLUIDO),
            "bbh_flu_codigo is not null"
        ];
        $viabilidadesComRespostasPendentes = $protocoloModel->getProtocoloAndDetalhamento($fieldsSearch);

        // Com todos os protocolos em mãos buscamos detalhes de cada fluxo
        $totalSincronizado = 0;
        foreach($viabilidadesComRespostasPendentes as $protocolo) {
            $totalSincronizado += $this->processaDetalhamentoFluxo($entityManager, $protocolo, $fluxoRepository, $protocoloModel, $fieldsAlias);
        }

        return $totalSincronizado;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return array
     */
    public function confirmaRespostaAnaliseEndereco(ORM\EntityManager $entityManager)
    {
        $protocoloRepository = $entityManager->getRepository('Project\Core\Entity\BbhProtocolos');
        $protocoloModel = new \Project\Core\Model\BBHive\BbhProtocolosModel($entityManager);
        $fieldsProtocol = $protocoloModel->getFieldsDetailProtocol();

        // Somente viabilidade
        $viabilidade = new \Project\BBHive\Services\RedeSimples\Viabilidade();
        $fieldsAlias = $viabilidade->mergeFieldsToForm($fieldsProtocol, $viabilidade->listFieldsConfirmaRespostaAnaliseEndereco);

        // Analisa protocolos processados sem necessidade de fluxo
        $totalSincronizado = $this->processaProtocoloSemFluxo($protocoloRepository, $protocoloModel, $fieldsAlias);
        $totalSincronizado += $this->processaProtocoloComFluxo($entityManager, $protocoloModel, $fieldsAlias);

        return ['totalSincronizado' => $totalSincronizado];
    }

    /**
     * @param $codProtocolo
     * @param $situacaoAnaliseEndereco
     * @param $dataValidadeAnalise
     * @return bool
     */
    protected function sendConfirmaRespostaAnaliseEndereco($codProtocolo, $situacaoAnaliseEndereco, $dataValidadeAnalise)
    {
        $xmlResponse = $this->api->getServiceFromXml(
            self::WS_SERVICE_CONFIRMA_RESPOSTA_ANALISE_ENDERECO,
            $this->getParamRespostaAnaliseEndereco($codProtocolo, $situacaoAnaliseEndereco, $dataValidadeAnalise)
        );

        $viabilidadesListNew = [];
        $viabilidadesList = $this->extractDataFromXml($xmlResponse, 'tipoRetorno');

        foreach ($viabilidadesList as $viabilidade)
        {
            $viabilidadesListNew[] = XML2ArrayHelper::DOMDocumentToArray($viabilidade);
        }

        return current($viabilidadesListNew) == "SUCESSO";
    }
}
