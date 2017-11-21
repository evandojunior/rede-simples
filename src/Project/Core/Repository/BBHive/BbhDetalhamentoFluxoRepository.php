<?php

namespace Project\Core\Repository\BBHive;

use Project\Core\Entity\BbhFluxo;
use Project\Core\Repository;

class BbhDetalhamentoFluxoRepository extends Repository\AbstractRepository
{
    public function findDetailByFluxo(BbhFluxo $bbhFluxo)
    {
        if (!$this->hasColumn(
                $this->_em->getConnection()->getDatabase(),
                sprintf("bbh_modelo_fluxo_%s_detalhado", $bbhFluxo->getBbhModFluCodigo()->getBbhModFluCodigo()),
                "bbh_flu_codigo")
        ) {
            return null;
        }

        $sql = sprintf("select * from bbh_modelo_fluxo_%s_detalhado where bbh_flu_codigo = %s",
            $bbhFluxo->getBbhModFluCodigo()->getBbhModFluCodigo(),
            $bbhFluxo->getBbhFluCodigo());
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return current($query->fetchAll());
    }
}
