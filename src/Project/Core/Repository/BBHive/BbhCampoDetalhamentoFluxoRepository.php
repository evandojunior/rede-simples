<?php

namespace Project\Core\Repository\BBHive;

use Doctrine\ORM;
use Project\Core\Entity\BbhModeloFluxo;

class BbhCampoDetalhamentoFluxoRepository extends ORM\EntityRepository
{
    public function findFieldsAbailableByModeloFluxo(BbhModeloFluxo $bbhModeloFluxo)
    {
        $sql = sprintf("select * from bbh_campo_detalhamento_fluxo cdf 
	              inner join bbh_detalhamento_fluxo df on cdf.bbh_det_flu_codigo = df.bbh_det_flu_codigo
	              where df.bbh_mod_flu_codigo = %s and bbh_cam_det_flu_disponivel ='1' order by bbh_cam_det_flu_codigo asc",
                $bbhModeloFluxo->getBbhModFluCodigo());
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function findModeloFluxoByAliasField($aliasField)
    {
        $sql = sprintf("select detFluxo.bbh_mod_flu_codigo from bbh_campo_detalhamento_fluxo camposFluxo
                    inner join bbh_detalhamento_fluxo detFluxo on camposFluxo.bbh_det_flu_codigo = detFluxo.bbh_det_flu_codigo
                where bbh_cam_det_flu_apelido = '%s'", $aliasField);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function findFieldsCampoDetalhamento(array $paramsWhere)
    {
        $sql = sprintf(
            "SELECT * FROM bbh_campo_detalhamento_fluxo cdf
              inner join bbh_detalhamento_fluxo df on cdf.bbh_det_flu_codigo = df.bbh_det_flu_codigo
                WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
