<?php


namespace Instante\Tracy\Login\Tests\Mocks;


use Instante\Tracy\Login\IUserDao;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

class UserDao implements IUserDao
{

    /**
     * Finds user by id
     *
     * @param int $id
     *
     * @return IIdentity
     */
    function find($id)
    {
        return new User($id, [], ['email' => 'test@test.test']);
    }

    /**
     * Finds all users
     *
     * @return IIdentity[]
     */
    function findAll()
    {
        return [
            new User(1, [], ['email' => 'test1@test.test']),
            new User(2, [], ['email' => 'test2@test.test']),
            new User(3, [], ['email' => 'test3@test.test']),
        ];
    }
}
