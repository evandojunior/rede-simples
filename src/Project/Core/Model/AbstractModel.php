<?php

namespace Project\Core\Model;

class AbstractModel
{
    protected $entityManager;

    protected $repository;

    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update($entity)
    {
        $this->entityManager->refresh($entity);
        $this->entityManager->flush();
    }

    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
