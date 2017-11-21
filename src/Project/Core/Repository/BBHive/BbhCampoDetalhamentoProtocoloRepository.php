<?php

namespace Project\Core\Repository\BBHive;

use Doctrine\ORM;

class BbhCampoDetalhamentoProtocoloRepository extends ORM\EntityRepository
{
    public function findFieldsAbailable()
    {
        $sql = "SELECT * FROM bbh_campo_detalhamento_protocolo where bbh_cam_det_pro_disponivel ='1' order by bbh_cam_det_pro_ordem asc";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
