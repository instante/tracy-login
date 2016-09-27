<?php

namespace Instante\Tracy\Login;

use Nette\Security\IIdentity;

interface IUserDao
{
    /**
     * Finds user by id
     *
     * @param int $id
     *
     * @return IIdentity
     */
    function find($id);

    /**
     * Finds all users
     *
     * @return IIdentity[]
     */
    function findAll();
}
