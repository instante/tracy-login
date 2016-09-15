<?php

namespace Instante\Tracy\Login;

use Doctrine\ORM\EntityManager;

class DoctrineUserDao implements IUserDao
{
    /** @var EntityManager */
    private $em;

    /** @var string */
    private $entity;

    /**
     * @param EntityManager $em
     * @param string $entity
     */
    public function __construct(EntityManager $em, $entity)
    {
        $this->entity = $entity;
        $this->em = $em;
    }

    /**
     * Finds user by id
     *
     * @param int $id
     *
     * @return mixed
     */
    function find($id)
    {
        return $this->em->getRepository($this->entity)->find($id);
    }

    /**
     * Finds all users
     *
     * @return array
     */
    function findAll()
    {
        return $this->em->getRepository($this->entity)->findAll();
    }
}
