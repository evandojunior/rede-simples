<?php

namespace Project\Core\Repository;

use Doctrine\ORM;

class AbstractRepository extends ORM\EntityRepository
{
    /**
     * @param $schema
     * @param $table
     * @param $column
     * @return bool
     */
    protected function hasColumn($schema, $table, $column)
    {
        $sql = "SELECT column_name
            FROM INFORMATION_SCHEMA.COLUMNS
           WHERE table_name = :table
             AND table_schema = :schema
             AND column_name = :column";

        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->execute([
            'schema' => $schema,
            'table' => $table,
            'column' => $column
        ]);

        $result = $stmt->fetchAll();

        return false == empty($result);
    }
}
