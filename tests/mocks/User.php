<?php


namespace Instante\Tracy\Login\Tests\Mocks;


use Nette\Security\Identity;

class User extends Identity
{
    public function getEmail()
    {
        return $this->data['email'];
    }
}
