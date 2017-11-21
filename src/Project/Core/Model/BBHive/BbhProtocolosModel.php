<?php

namespace Project\Core\Model\BBHive;

use Project\Core\Entity\BbhDetalhamentoProtocolo;
use Project\Core\Entity\BbhFluxo;
use Project\Core\Entity\BbhModeloFluxo;
use Project\Core\Entity\BbhProtocolos;
use Project\Core\Entity\BbhUsuario;
use Project\Core\Model\AbstractModel;
use Doctrine\ORM;

class BbhProtocolosModel extends AbstractModel
{
    /**
     * BbhProtocolosModelModel constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('Project\Core\Entity\BbhProtocolos');
    }

    /**
     * @param $codProtocol
     * @return mixed
     */
    public function getProtocol($codProtocol)
    {
        return $this->repository->findOneByBbhProCodigo($codProtocol);
    }

    /**
     * @param \Project\Core\Entity\BbhProtocolos $protocolo
     * @return mixed
     */
    public function getProtocolToArray(BbhProtocolos $protocolo)
    {
        return $this->repository->findByProtocol($protocolo);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function getProtocolByFieldDetail(array $paramsWhere)
    {
        return $this->repository->findProtocoloByFieldDetalhamento($paramsWhere);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function getProtocoloAndDetalhamento(array $paramsWhere)
    {
        return $this->repository->findProtocoloAndDetalhamento($paramsWhere);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function getProtocolByField(array $paramsWhere)
    {
        return $this->repository->findProtocolo($paramsWhere);
    }

    /**
     * @param \Project\Core\Entity\BbhProtocolos $protocolo
     * @return mixed
     */
    public function getDetailProtocol(BbhProtocolos $protocolo)
    {
        $detalhamentoProtocoloRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhDetalhamentoProtocolo');
        return $detalhamentoProtocoloRepository->findDetailByProtocol($protocolo);
    }

    /**
     * @return mixed
     */
    public function getFieldsDetailProtocol()
    {
        $camposDetalhamentoProtocoloRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoProtocolo');
        return $camposDetalhamentoProtocoloRepository->findFieldsAbailable();
    }

    /**
     * @param \Project\Core\Entity\BbhProtocolos $protocolo
     * @return mixed
     */
    public function getWorkflowByProtocol(BbhProtocolos $protocolo)
    {
        $workflowRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhFluxo');
        return $workflowRepository->findOneByBbhFluCodigo($protocolo->getBbhFluCodigo());
    }

    /**
     * @param \Project\Core\Entity\BbhFluxo $bbhFluxo
     * @return mixed
     */
    public function getDetailWorkflowByFluxo(BbhFluxo $bbhFluxo)
    {
        $workflowRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhDetalhamentoFluxo');
        return $workflowRepository->findDetailByFluxo($bbhFluxo);
    }

    /**
     * @return mixed
     */
    public function getFieldsDetailWorkflowByFluxo(BbhFluxo $bbhFluxo)
    {
        $camposDetalhamentoFluxoRepository = $this->entityManager->getRepository('Project\Core\Entity\BbhCampoDetalhamentoFluxo');
        return $camposDetalhamentoFluxoRepository->findFieldsAbailableByModeloFluxo($bbhFluxo->getBbhModFluCodigo());
    }

    /**
     * @param array $listFields
     * @return mixed
     */
    public function createProtocolo(BbhUsuario $user, array $listFields)
    {
        //ALTER TABLE bbh_protocolos MODIFY COLUMN bbh_pro_momento datetime DEFAULT CURRENT_TIMESTAMP NULL;

        $fieldsProtocolo = [];
        $valuesProtocolo = [];

        $fieldsDetalhamento = [];
        $valuesDetalhamento = [];

        foreach($listFields as $item => $field) {
            if (!isset($field['name'])) {
                continue;
            }
            if (strpos($field['name'], "bbh_cam_det_pro") !== false) {
                $fieldsDetalhamento[$item] = $field['name'];
                $valuesDetalhamento[$item] = $field['value'];
                unset($listFields[$item]);
                continue;
            }

            if (in_array($field['name'], ['bbh_dep_codigo', 'bbh_pro_email'])) {
                continue;
            }

            $fieldsProtocolo[$item] = $field['name'];
            $valuesProtocolo[$item] = $field['value'];
        }
        unset($listFields);

        $fieldsProtocolo[] = 'bbh_pro_email';
        $valuesProtocolo[] = sprintf("'%s'", $user->getBbhUsuIdentificacao());

        $fieldsProtocolo[] = 'bbh_dep_codigo';
        $valuesProtocolo[] = $user->getBbhDepCodigo()->getBbhDepCodigo();

        $fieldsProtocolo[] = 'bbh_pro_status';
        $valuesProtocolo[] = BbhProtocolos::STATUS_PROTOCOLADO;

        $fieldsProtocolo[] = 'bbh_pro_momento';
        $valuesProtocolo[] = sprintf("'%s'", date('Y-m-d H:i:s'));

        $codProtocolo = $this->repository->save($fieldsProtocolo, $valuesProtocolo);
        if (!empty($fieldsDetalhamento) && !empty($codProtocolo)) {
            $fieldsDetalhamento[] = 'bbh_pro_codigo';
            $valuesDetalhamento[] = $codProtocolo;

            $this->repository->save($fieldsDetalhamento, $valuesDetalhamento, $table = 'bbh_detalhamento_protocolo');
        }

        return $codProtocolo;
    }
}
