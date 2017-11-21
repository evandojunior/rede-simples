<?php

namespace Project\Core\Repository\BBHive;

use Doctrine\ORM;
use Project\Core\Entity\BbhProtocolos;

/**
 * Class BbhDetalhamentoProtocoloRepository
 * @package Project\Core\Repository\BBHive
 */
class BbhDetalhamentoProtocoloRepository extends ORM\EntityRepository
{
    /**
     * @param \Project\Core\Entity\BbhProtocolos $protocolo
     * @return mixed
     */
    public function findDetailByProtocol(BbhProtocolos $protocolo)
    {
        $sql = sprintf("SELECT * FROM bbh_detalhamento_protocolo WHERE bbh_pro_codigo = %s", $protocolo->getBbhProCodigo());
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch();
    }
}
