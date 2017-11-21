<?php

namespace Project\Core\Model\BBHive;

use Project\Core\Entity\BbhUsuario;
use Project\Core\Model\AbstractModel;
use Doctrine\ORM;

class BbhUsuarioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('Project\Core\Entity\BbhUsuario');
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getAllUsersToJson()
    {
        $users = $this->getRepository()->findAll();
        $userList = [];
        foreach ($users as $item => $user) {
            $userList[$item]['bbh_usu_codigo'] = $user->getBbhUsuCodigo();
            $userList[$item]['bbh_usu_identificacao'] = $user->getBbhUsuIdentificacao();
            $userList[$item]['bbh_usu_apelido'] = $user->getBbhUsuApelido();
            $userList[$item]['bbh_usu_data_nascimento'] = $user->getBbhUsuDataNascimento() instanceof \DateTime ? $user->getBbhUsuDataNascimento()->format('d/m/Y') : '';
        }

        return $userList;
    }

    protected function searchAll()
    {
        return $this->repository->buscaDados();
    }
}
