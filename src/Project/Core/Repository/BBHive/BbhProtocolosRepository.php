<?php

namespace Project\Core\Repository\BBHive;

use Doctrine\ORM;
use Project\Core\Entity\BbhProtocolos;

/**
 * Class BbhProtocolosRepository
 * @package Project\Core\Repository\BBHive
 */
class BbhProtocolosRepository extends ORM\EntityRepository
{
    /**
     * @param array $listFields
     * @param array $listValues
     * @param string $table
     * @return string
     */
    public function save(array $listFields, array $listValues, $table = 'bbh_protocolos')
    {
        $insert = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(", ", $listFields),
            implode(", ", $listValues)
        );

        $conn = $this->_em->getConnection();
        $query = $conn->prepare($insert);
        $query->execute();

        return $conn->lastInsertId();
    }

    /**
     * @param \Project\Core\Entity\BbhProtocolos $protocolo
     * @return mixed
     */
    public function findByProtocol(BbhProtocolos $protocolo)
    {
        $sql = sprintf("SELECT * FROM bbh_protocolos WHERE bbh_pro_codigo = %s", $protocolo->getBbhProCodigo());
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function findProtocoloByFieldDetalhamento(array $paramsWhere)
    {
        $sql = sprintf(
            "SELECT * FROM bbh_detalhamento_protocolo WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function findProtocolo(array $paramsWhere)
    {
        $sql = sprintf(
            "SELECT * FROM bbh_protocolos WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $paramsWhere
     * @return mixed
     */
    public function findProtocoloAndDetalhamento(array $paramsWhere)
    {
        $sql = sprintf(
            "select * from bbh_protocolos p
                inner join bbh_detalhamento_protocolo dp on p.bbh_pro_codigo = dp.bbh_pro_codigo WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $fieldsList
     * @param array $paramsWhere
     * @param string $table
     * @return string
     */
    public function update(array $fieldsList, array $paramsWhere, $table = 'bbh_protocolos')
    {
        $update = sprintf(
            "UPDATE %s SET %s WHERE %s",
            $table,
            implode(", ", $fieldsList),
            implode(" AND ", $paramsWhere)
        );

        $conn = $this->_em->getConnection();
        $query = $conn->prepare($update);
        $query->execute();

        return $conn->lastInsertId();
    }
}
