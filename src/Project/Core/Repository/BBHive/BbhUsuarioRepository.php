<?php

namespace Project\Core\Repository\BBHive;

use Doctrine\ORM;

class BbhUsuarioRepository extends ORM\EntityRepository
{
    public function buscaDados()
    {
        return ['result' => 'Resultado do Repository'];
    }
}
