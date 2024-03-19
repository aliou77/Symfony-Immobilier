<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $u = new User();
        $u
            ->setUsername("username")
            ->setPassword("password")
            ->setEmail("email@gmail.com")
            ->setRoles(['ROLE_ADMIN'])
        ;

        $this->assertTrue($u->getUsername() === "username");
        $this->assertTrue($u->getPassword() === "password");
        $this->assertTrue($u->getRoles() === ['ROLE_ADMIN']);
        $this->assertTrue($u->getEmail() === "email@gmail.com");
        $this->assertTrue($u->getUserIdentifier() === "email@gmail.com");
        
    }

    public function testIsNull(){
        $u = new User();
        $this->assertNull($u->getId());
    }

}
